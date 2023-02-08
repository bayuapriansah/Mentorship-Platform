<?php

namespace App\Http\Controllers;

use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Company;
use App\Models\Mentor;


class AuthController extends Controller
{
    public function register()
    {
        if(Auth::guard('company')->check()){
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
            'g-recaptcha-response' => function ($attribute, $value, $fail) {
                $secretkey = config('services.recaptcha.secret');
                $response = $value;
                $userIP = $_SERVER['REMOTE_ADDR'];
                $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$response&remoteip=$userIP";
                $response = \file_get_contents($url);
                $response = json_decode($response);
                // dd($response);
                if(!$response->success){
                    Session::flash('g-recaptcha-response', 'Google reCAPTCHA validation failed, please try again.');
                    Session::flash('alert-class', 'alert-danger');
                    $fail($attribute.'Google reCAPTCHA validation failed, please try again.');
                }
            },
        ]);

        if($validator->fails()){
            return redirect('/register')->withErrors($validator)->withInput();
        }
        $validated = $validator->validated();
        $existing_student = Student::where('email',$validated['email'])->first();
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
        if(Auth::guard('company')->check()){
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
        if(Auth::guard('student')->attempt($validated)){
            $request->session()->regenerate();
            return redirect('/')->with('success','Logged in');
        }elseif(Auth::guard('mentor')->attempt($validated)){
            $request->session()->regenerate();
            return redirect('/')->with('success','Logged in mentor');
        }elseif(Auth::guard('company')->attempt($validated)){
            $request->session()->regenerate();
            return redirect('/')->with('success','Logged in company');
        }elseif(Auth::guard('web')->attempt($validated)){
            $request->session()->regenerate();
            return redirect('/')->with('success','Logged in admin');
        }else{
            return back()->with('error','User has not been registered');
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


}
