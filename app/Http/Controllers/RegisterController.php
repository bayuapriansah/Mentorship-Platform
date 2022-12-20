<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Company;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function store(Request $request){
        $validated = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required'],
            'password' => ['required', 'min:8'],
            'role' => ['required']
        ]);

        $validated['password'] = bcrypt($validated['password']);
        if($validated['role'] == 'student'){
            $student = new Student;
            $student->name = $validated['name'];
            $student->email = $validated['email'];
            $student->password = $validated['password'];
            $student->is_confirm = 0;
            $student->save();
        }elseif ($validated['role'] == 'partner') {
            $company = new Company;
            $company->name = $validated['name'];
            $company->email = $validated['email'];
            $company->password = $validated['password'];
            $company->is_confirm = 0;
            $company->save();
        }else{
            return redirect('/');
        }
    }
}
