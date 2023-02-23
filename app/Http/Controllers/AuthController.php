<?php

namespace App\Http\Controllers;

use Str;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Mentor;
use App\Models\Company;
use App\Models\Student;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\InstitutionController;


class AuthController extends Controller
{
    public function register()
    {
        if(Auth::guard('customer')->check()){
            return back();
        }
        if(Auth::guard('web')->check()){
            return back();
        }
        if(Auth::guard('mentor')->check()){
            return back();
        }
        if(Auth::guard('student')->check()){
            return back();
        }
        $GetInstituionData = (new InstitutionController)->GetInstituionData();
        $regState = 0;
        return view('auth.register', compact('GetInstituionData','regState'));
    }

    public function store(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'date_of_birth' => ['required'],
            'email' => ['required'],
            'sex' => ['required'],
            'state' => ['required'],
            'country' => ['required'],
            'institution' => ['required'],
            'study_program' => ['required'],
            'year_of_study' => ['required'],
            'g-recaptcha-response' => 'required|recaptcha',
        ]);

        if($validator->fails()){
            Session::flash('g-recaptcha-response', 'Google reCAPTCHA validation failed, please try again.');
            return redirect('/register')->withErrors($validator)->withInput();
        }
        $validated = $validator->validated();
        $existing_student = Student::where('email',$validated['email'])->first();
        $mentor = Mentor::inRandomOrder()->where('institution_id',$validated['institution'])->first();
        if($existing_student == null){
            $student = new Student;
            $student->first_name = $validated['first_name'];
            $student->last_name = $validated['last_name'];
            $student->date_of_birth = $validated['date_of_birth'];
            $student->email = $validated['email'];
            $student->sex = $validated['sex'];
            $student->state = $validated['state'];
            $student->country = $validated['country'];
            $student->institution_id = $validated['institution'];
            if($validated['study_program']=='other'){
                $student->study_program = $request->study_program_form;
            }else{
                $student->study_program = $validated['study_program'];
            }
            $student->year_of_study = $validated['year_of_study'];
            $student->end_date = \Carbon\Carbon::now()->addMonth(4)->toDateString();
            $student->is_confirm = 0;
            $student->mentor_id = $mentor->id;
            $student->save();
            $sendmail = (new MailController)->emailregister($validated['email']);
            $emailEnc = (new SimintEncryption)->encData($validated['email']);
            // $sendmail = (new MailController)->otplogin($validated['email'],$otp);
            // return redirect('/otp/login')->with('success','You\'re Success create an Student account. Thank you! 😊');
            return redirect()->route('verify',[$emailEnc]);
        }else{
            return redirect('/register#register')->withInput()->with('error','This email address is already registered!');
        }
    }

    public function logout(Request $request){
        Auth::guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();

        return redirect('/');
    }

    public function login(){
        if(Auth::guard('customer')->check()){
            return back();
        }
        if(Auth::guard('web')->check()){
            return back();
        }
        if(Auth::guard('mentor')->check()){
            return back();
        }
        if(Auth::guard('student')->check()){
            return back();
        }
        return view('auth.login');
    }

    public function authenticate(Request $request){
        $validated = $request->validate([
            'email' => ['required'],
            'password' => ['required']
        ]);
        // dd($request->all());
        if(Auth::guard('student')->attempt($validated)){
            $request->session()->regenerate();
            return redirect('/')->with('success','Logged in');
        }elseif(Auth::guard('mentor')->attempt($validated)){
            $request->session()->regenerate();
            return redirect('/')->with('success','Logged in mentor');
        }elseif(Auth::guard('customer')->attempt($validated)){
            $request->session()->regenerate();
            return redirect('/')->with('success','Logged in');
        }elseif(Auth::guard('web')->attempt($validated)){
            $request->session()->regenerate();
            return redirect('/')->with('success','Logged in admin');
        }else{
            return back()->with('error','Invalid Login Credentials: Your email or password is incorrect. Please review your information and try again.');
        }
    }

    public function verifyEmail($email)
    {
        $email = (new SimintEncryption)->decData($email);
        $registeredEmail = Student::where('email', $email)->first();
        if($registeredEmail == null){
            abort(403);
        }
        return view('auth.verifyEmail', compact(['email']));
    }

    public function verified($email)
    {
        $email = (new SimintEncryption)->decData($email);
        $registeredEmail = Student::where('email', $email)->where('is_confirm', 0)->first();
        if($registeredEmail){
            $registeredEmail->is_confirm = 1;
            $registeredEmail->end_date = \Carbon\Carbon::now()->addMonth(4)->toDateString();
            $registeredEmail->save();
            return view('auth.verified');
        }else{
            return abort(403);
        }
    }

    public function forgotPassword()
    {
        return view('auth.forgotPassword');
    }

    public function submitForgotPassword(Request $request)
    {
        $request->validate([
            // 'email' => 'required|email|exists:users,email|exists:mentors,email|exists:customers,email',
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    if (!DB::table('users')->where('email', $value)->exists() && !DB::table('mentors')->where('email', $value)->exists() && !DB::table('customers')->where('email', $value)->exists()) {
                        $fail('This email is not registered.');
                    }
                }
            ],
        ],
        [
            'email.required' => 'Please enter valid email address',
            'email.email' => 'Please enter valid email address',
            'email.exists' => 'This email is not registered'
        ]);

        $token = \Str::random(64);
        \DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);
        $action_link = route('showResetForm',['token'=>$token, 'email'=>$request->email]);
        $sendmail = (new MailController)->emailResetPassword($request->email,$action_link);
        return back()->with('successTailwind',"We've send you password reset email");
    }

    public function showResetForm(Request $request, $token=null)
    {
        return view('auth.reset')->with(['token'=>$token, 'email'=>$request->email]);
    } 

    public function resetPassword(Request $request)
    {
        // dd($request->all());
        $request->validate([
            // 'email' => 'required|email|exists:users,email|exists:mentors,email|exists:customers,email',
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    if (!DB::table('users')->where('email', $value)->exists() && !DB::table('mentors')->where('email', $value)->exists() && !DB::table('customers')->where('email', $value)->exists()) {
                        $fail('This email is not registered.');
                    }
                }
            ],
            'password' => 'required|min:5|confirmed',
            'password_confirmation' => 'required'
        ],
        [
            'email.required' => 'Please enter valid email address',
            'email.email' => 'Please enter valid email address',
            'email.exists' => 'This email is not registered',
            'password.required'=> 'Please enter your new password',
            'password.min'=> 'Password minimum character is 5',
            'password.confirmed' => 'Password confirmation must be the same',
            'password_confirmation.required'=> 'Please enter your confirmation password',
        ]);

        $checkToken = \DB::table('password_resets')->where([
            'email'=>$request->email,
            'token'=>$request->token,
        ])->first();

        if(!$checkToken){
            return back()->withInput()->with('error', 'Invalid Token');
        }else{
            $usersExist = User::where('email',$request->email)->first();
            $mentorsExist = Mentor::where('email',$request->email)->first();
            $customerExist = Customer::where('email',$request->email)->first();
            if($usersExist){
                User::where('email',$request->email)->update([
                    'password' =>\Hash::make($request->password)
                ]);

                \DB::table('password_resets')->where([
                    'email'=>$request->email
                ])->delete();
            }elseif($mentorsExist){
                Mentor::where('email',$request->email)->update([
                    'password' =>\Hash::make($request->password)
                ]);

                \DB::table('password_resets')->where([
                    'email'=>$request->email
                ])->delete();
            }elseif($customerExist){
                Customer::where('email',$request->email)->update([
                    'password' =>\Hash::make($request->password)
                ]);

                \DB::table('password_resets')->where([
                    'email'=>$request->email
                ])->delete();
            }
        }

        return redirect()->route('login')->with('successTailwind', 'Your password has been changed, You can login with new password');
    }

}
