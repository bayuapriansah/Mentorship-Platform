<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function store(Request $request){
        dd($request->all());
        $validated = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required'],
            'password' => ['required', 'min:8'],
            'role' => ['required'],
            'g-recaptcha-response' => 'recaptcha'
        ]);

        $validated['password'] = bcrypt($validated['password']);
        if($validated['role'] == 'student'){
            $existing_student = Student::where('email',$validated['email'])->first();
            if($existing_student == null){
                $student = new Student;
                $student->name = $validated['name'];
                $student->email = $validated['email'];
                $student->password = $validated['password'];
                // $student->g_captcha_response = $validated['g_captcha_response'];
                $student->is_confirm = 0;
                $student->save();
                // Auth::guard('student')->login($student);
                return redirect('/')->with('success','You\'re account is under review, please wait for confirmation email from us. Thank you! 😊');
                // You're account is under review, please wait for confirmation email from us. Thank you! 😊
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
                // $company->g_captcha_response = $validated['g_captcha_response'];
                $company->is_confirm = 0;
                $company->save();
                // Auth::guard('company')->login($company);
                return redirect('/')->with('success','You\'re account is under review, please wait for confirmation email from us. Thank you! 😊');
            }else{
                return redirect('/')->with('error','The email you are using is already registered');
            }
        }else{
            return redirect('/');
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
}
