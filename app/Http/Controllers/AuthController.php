<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MailController;
use Session;

class AuthController extends Controller
{
    public function store(Request $request){ 
        
        $validated = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required'],
            'password' => ['required', 'min:8'],
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

        $validated['password'] = bcrypt($validated['password']);
        if($validated['role'] == 'student'){
            $existing_student = Student::where('email',$validated['email'])->first();
            if($existing_student == null){
                $student = new Student;
                $student->name = $validated['name'];
                $student->email = $validated['email'];
                $student->password = $validated['password'];
                $student->is_confirm = 0;
                $student->save();
                $sendmail = (new MailController)->emailregister($validated['email']);
                return redirect('/')->with('success','You\'re account is under review, please wait for confirmation email from us. Thank you! 😊');
            }else{
                return redirect('/')->with('error','The email you are using is already registered');
            }
            
        }elseif ($validated['role'] == 'partner') {
            $existing_company = Company::where('email', $validated['email'])->first();
            if($existing_company == null){
                $company = new Company;
                $company->name = $validated['name'];
                $company->email = $validated['email'];
                $company->password = $validated['password'];
                $company->is_confirm = 0;
                $company->save();
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
