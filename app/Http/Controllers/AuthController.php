<?php

namespace App\Http\Controllers;

use Session;
use App\Models\Mentor;
use App\Models\Company;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MailController;

class AuthController extends Controller
{
    public function store(Request $request){ 
        $validated = $request->validate([
            'email' => ['required'],
            // 'name' => ['sometimes', 'min:3'],
            // 'gender' => ['sometimes'],
            'state' => ['required', 'min:3'],
            'country' => ['required', 'min:3'],
            'role' => ['required'],
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

        // $validated['password'] = bcrypt($validated['password']);
        if($validated['role'] == 'student'){
            $existing_student = Student::where('email',$validated['email'])->first();
            if($existing_student == null){
                $student = new Student;
                $student->email = $validated['email'];
                $student->gender = $request->gender;
                $student->state = $validated['state'];
                $student->country = $validated['country'];
                $student->is_confirm = 0;
                $student->save();
                $sendmail = (new MailController)->emailregister($validated['email']);
                return redirect('/')->with('success','You\'re account is under review, please wait for confirmation email from us. Thank you! 😊');
            }else{
                return redirect('/')->with('error','The email you are using is already registered');
            }
            
        }elseif ($validated['role'] == 'mentor') {
            $existing_mentor = Mentor::where('email', $validated['email'])->first();
            if($existing_mentor == null){
                $mentor = new Mentor;
                $mentor->name =  $request->name;
                $mentor->email = $validated['email'];
                $mentor->institution_name = $request->institution_name;
                $mentor->position = $request->position;
                $mentor->state = $validated['state'];
                $mentor->country = $validated['country'];
                $mentor->is_confirm = 0;
                $mentor->save();
                $sendmail = (new MailController)->emailregister($validated['email']);
                return redirect('/')->with('success','You\'re account is under review, please wait for confirmation email from us. Thank you! 😊');
            }else{
                return redirect('/')->with('error','The email you are using is already registered');
            }
        }else{
            return redirect('/'+"#register");
        }
    }

    public function logout(Request $request){
        // Auth::logout();
        // $request->session()->invalidate();
        // // $request->session()->regenerateToken();
        // return redirect('/');

        // if(Auth::guard('student')->check()) // this means that the admin was logged in.
        // {
        //     Auth::guard('student')->logout();
        //     return redirect()->guest(route( 'index' ));

        // }

        // if(Auth::guard('company')->check()) // this means that the admin was logged in.
        // {
        //     Auth::guard('company')->logout();
        //     return redirect()->guest(route( 'index' ));
        // }
        Auth::guard()->logout();
        // $this->guard()->logout();
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
        try {
            $validated = $request->validate([
                'email' => ['required'],
                'password' => ['required']
            ]);
    
            $existing_student_credential = Student::where('email',$validated['email'])->first();
            $existing_company_credential = Company::where('email',$validated['email'])->first();
            
            if(Auth::guard('student')->attempt($validated)){
                $request->session()->regenerate();
                return redirect('/')->with('success','Logged in');;
            }
            if(Auth::guard('mentor')->attempt($validated)){
                $request->session()->regenerate();
                return redirect('/')->with('success','Logged in mentor');;
            }
            if(Auth::guard('company')->attempt($validated)){
                $request->session()->regenerate();
                return redirect('/')->with('success','Logged in company');;
            }
            if(Auth::guard('web')->attempt($validated)){
                $request->session()->regenerate();
                return redirect('/')->with('success','Logged in admin');;
            }
        } catch(\Exception $error){
            $response =[
                'status'=>'error',
                'message'=>'error',
                'data'=>$error->getMessage(),
            ];
            return response()->json($response, 200);
        }
        

    }

}
