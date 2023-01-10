<?php

namespace App\Http\Controllers;

use Session;
use App\Models\Mentor;
use App\Models\Company;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }
    public function store(Request $request){ 
        $validator = Validator::make($request->all(), [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'date_of_birth' => ['required'],
            'email' => ['required'],
            'sex' => ['required'],
            'state' => ['required', 'min:3'],
            'country' => ['required', 'min:3'],
            'institution' => ['required'],
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
            $student->institution = $validated['institution'];
            $student->is_confirm = 0;
            $student->save();
            $sendmail = (new MailController)->emailregister($validated['email']);
            // $sendmail = (new MailController)->otplogin($validated['email'],$otp);
            return redirect('/otp/login')->with('success','You\'re Success create an Student account. Thank you! 😊');
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

}
