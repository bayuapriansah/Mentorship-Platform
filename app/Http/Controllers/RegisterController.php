<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function store(Request $request){
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
            Auth::guard('student')->login($student);
            return redirect('/');
        }elseif ($validated['role'] == 'partner') {
            $company = new Company;
            $company->name = $validated['name'];
            $company->email = $validated['email'];
            $company->password = $validated['password'];
            $company->is_confirm = 0;
            $company->save();
            Auth::guard('company')->login($company);
            return redirect('/');
        }else{
            return redirect('/');
        }
    }

    public function logout(Request $request){
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
