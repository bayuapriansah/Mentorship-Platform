<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Mentor;
use App\Models\Company;
use App\Models\Student;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\InstitutionController;


class AuthController extends Controller
{
    public function multiLogIn() {
        $guards = ['customer', 'web', 'mentor', 'student'];

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect()->route('index');
            }
        }

        return view('auth.login');
    }

    public function multiLogInCheck(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'g-recaptcha-response' => 'required|recaptcha',
        ]);

        if($validator->fails()){
            Session::flash('g-recaptcha-response', 'Google reCAPTCHA validation failed, please try again.');
            return redirect()->route('multiLogIn')->withErrors($validator);
        }
        $validated = $validator->validated();
        if($validated != null){
            $usersExist = User::where('email',$validated['email'])->first();
            $mentorsExist = Mentor::where('email',$validated['email'])->where('is_confirm',1)->first();
            $customerExist = Customer::where('email',$validated['email'])->where('is_confirm',1)->first();
            $studentExist = Student::where('email',$validated['email'])->where('is_confirm',1)->first();
            if($usersExist || $mentorsExist || $customerExist){
                return $this->login($validated['email']);
            }elseif($studentExist){
                return (new AuthOtpController)->generate($request);
            }else{
                toastr()->error('This email is not registered.');

                return redirect()->route('multiLogIn');
            }
        }
    }

    public function register()
    {
        $guards = ['customer', 'web', 'mentor', 'student'];

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect()->route('index');
            }
        }

        $countries = DB::table('countries')->orderBy('name')->get();
        $GetInstituionData = (new InstitutionController)->GetInstituionData();
        $regState = 0;

        return view('auth.register', compact('countries', 'GetInstituionData','regState'));
    }

    public function store(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'date_of_birth' => ['required'],
            'sex' => ['required', 'in:male,female'],
            'team_name' => ['required'],
            'country' => ['required'],
            // 'state' => ['required'],
            'institution_name' => ['required'],
            'study_program' => ['required'],
            'year_of_study' => ['required'],
            'mentorship_type' => ['required', 'in:skills_track,entrepreneur_track'],
            'email' => ['required'],
            'password' => ['required'],
            'g-recaptcha-response' => 'required|recaptcha',
        ],[
          'first_name.required' => 'First name is required',
          'last_name.required' => 'Last name is required',
          'date_of_birth.required' => 'Date of birth is required',
          'sex.required' => 'Sex is required',
          'sex.in' => 'Sex must be Male or Female',
          'team_name.required' => 'Team name is required',
          'country.required' => 'Country is required',
        //   'state.required' => 'State is required',
          'institution_name.required' => 'Institution is required',
          'study_program.required' => 'Study program is required',
          'year_of_study.required' => 'Year of study program is required',
          'mentorship_type.required' => 'Mentorship type is required',
          'mentorship_type.in' => 'Mentorship type must be Skills Track or Entrepreneur Track',
          'email.required' => 'Email is required',
          'password.required' => 'Password is required',
          'g-recaptcha-response.required' => 'Captcha is required',
        ]);

        if($validator->fails()){
            Session::flash('g-recaptcha-response', 'Google reCAPTCHA validation failed, please try again.');
            return redirect('/register')->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();
        $existing_student = Student::where('email',$validated['email'])->first();

        $mentor = Mentor::inRandomOrder()->where('institution_id', '!=', 0)->where('is_confirm', 1)->first();
        $staff = Mentor::inRandomOrder()->where('institution_id', 0)->where('is_confirm', 1)->first();

        if($existing_student == null){
            $student = new Student;
            $student->first_name = $validated['first_name'];
            $student->last_name = $validated['last_name'];
            $student->date_of_birth = $validated['date_of_birth'];
            $student->sex = $validated['sex'];
            $student->team_name = $validated['team_name'];
            $student->country = $validated['country'];
            // $student->state = $validated['state'];
            $student->institution_name = $validated['institution_name'];

            if($validated['study_program']=='other'){
                $student->study_program = $request->study_program_form;
            }else{
                $student->study_program = $validated['study_program'];
            }

            $student->year_of_study = $validated['year_of_study'];
            $student->mentorship_type = $validated['mentorship_type'];
            $student->email = $validated['email'];
            $student->password = Hash::make($validated['password']);
            $student->end_date = \Carbon\Carbon::now()->addMonth(4)->toDateString();
            $student->is_confirm = 0;
            $student->mentor_id = $mentor->id;
            $student->staff_id = $staff->id;
            $student->save();
            $emailEnc = (new SimintEncryption)->encData($validated['email']);
            $link = route('verified', [$emailEnc]);
            $sendmail = (new MailController)->emailregister($validated['email'],$link);
            // $sendmail = (new MailController)->otplogin($validated['email'],$otp);
            // return redirect('/otp/login')->with('success','You\'re Success create an Student account. Thank you! 😊');
            return redirect()->route('verify',[$emailEnc]);
        }else{
            toastr()->error('This email address is already registered!');

            return redirect('/register#register')->withInput();
        }
    }

    public function logout(Request $request){
        Auth::guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();

        return redirect('/');
    }

    public function login($email = null){
        $guards = ['customer', 'web', 'mentor', 'student'];
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect()->route('index');
            }
        }
        return view('auth.login',compact('email'));
    }

    public function authenticate(Request $request){
        $validated = $request->validate([
            'email' => ['required'],
            'password' => ['required']
        ]);

        // dd($request->all());
        if(Auth::guard('student')->attempt($validated)){
            $request->session()->regenerate();
            toastr()->success('Logged in');

            return redirect('/');
        }elseif(Auth::guard('mentor')->attempt($validated)){
            $request->session()->regenerate();
            toastr()->success('Logged in mentor');

            return redirect('/');
        }elseif(Auth::guard('customer')->attempt($validated)){
            $request->session()->regenerate();
            toastr()->success('Logged in');

            return redirect('/');
        }elseif(Auth::guard('web')->attempt($validated)){
            $request->session()->regenerate();
            toastr()->success('Logged in admin');

            return redirect('/');
        }else{
            toastr()->error('Your email or password is incorrect. Please review your information and try again.');

            return redirect()
                    ->back()
                    ->withInput(['email' => $validated['email']]);
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
        $student = Student::where('email', $email)->where('is_confirm', 0)->first();

        if (!$student) {
            return redirect()->route('index');
        }

        $student->is_confirm = 1;
        $student->end_date = $student->created_at->addMonth(4)->toDateString();
        $student->save();

        (new MailController)->EmailStudentVerificationSuccess($student->email);

        return view('auth.verified');
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
                    if (
                        !DB::table('users')->where('email', $value)->exists() &&
                        !DB::table('mentors')->where('email', $value)->exists() &&
                        !DB::table('customers')->where('email', $value)->exists() &&
                        !DB::table('students')->where('email', $value)->exists()
                    ) {
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

        $token = Str::random(64);
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);
        $action_link = route('showResetForm',['token'=>$token, 'email'=>$request->email]);
        $sendmail = (new MailController)->emailResetPassword($request->email,$action_link);

        return redirect()->back()->with('reset-password-link-sent', 'ok');
    }

    public function showResetForm(Request $request, $token=null)
    {
        return view('auth.reset')->with(['token'=>$token, 'email'=>$request->email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|min:5|confirmed',
            'password_confirmation' => 'required'
        ],
        [
            'token.required' => 'Invalid Token',
            'password.required' => 'Please enter your new password',
            'password.min' => 'Password minimum character is 5',
            'password.confirmed' => 'Password confirmation must be the same',
            'password_confirmation.required' => 'Please enter your confirmation password',
        ]);

        $checkToken = DB::table('password_resets')->where('token', $request->input('token'))->first();

        if (!$checkToken) {
            toastr()->error('Invalid Token');

            return back()->withInput();
        } else {
            $usersExist = User::where('email',$checkToken->email)->first();
            $mentorsExist = Mentor::where('email',$checkToken->email)->first();
            $customerExist = Customer::where('email',$checkToken->email)->first();
            $studentExist = Student::where('email',$checkToken->email)->first();

            if ($usersExist) {
                User::where('email', $checkToken->email)->update([
                    'password' =>Hash::make($request->password)
                ]);
            } elseif ($mentorsExist) {
                Mentor::where('email', $checkToken->email)->update([
                    'password' =>Hash::make($request->password)
                ]);
            } elseif ($customerExist) {
                Customer::where('email', $checkToken->email)->update([
                    'password' =>Hash::make($request->password)
                ]);
            } elseif ($studentExist) {
                Student::where('email', $checkToken->email)->update([
                    'password' =>Hash::make($request->password)
                ]);
            }

            DB::table('password_resets')->where('email', $checkToken->email)->delete();
        }

        toastr()->success('Password changed successfully');

        return redirect()->route('login');
    }
}
