<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function store(Request $request){
        // dd($request->all());
        $validated = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required'],
            'password' => ['required', 'min:8'],
            'role' => ['required'],
            'date' => ['required'],
            'g-recaptcha-response' => 'recaptcha',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        if($validated['role'] == 'student'){
            $student = new Student;
            $student->name = $validated['name'];
            $student->email = $validated['email'];
            $student->password = $validated['password'];
            $student->is_confirm = 0;
            $student->save();
            // Auth::guard('student')->login($student);
            return redirect('/')->with('success','Akun sudah terdaftar dan sedang direview silahkan tunggu email konfirmasi ');
        }elseif ($validated['role'] == 'partner') {
            $company = new Company;
            $company->name = $validated['name'];
            $company->email = $validated['email'];
            $company->password = $validated['password'];
            $company->is_confirm = 0;
            $company->save();
            // Auth::guard('company')->login($company);
            return redirect('/')->with('success','Akun sudah terdaftar dan sedang direview silahkan tunggu email konfirmasi ');
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
