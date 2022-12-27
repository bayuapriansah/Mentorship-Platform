<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthOtpController extends Controller
{
    public function login(){
        return view('auth.login');
    }

    public function generate(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $verificationCode = $this->generateOtp($request->email);

        $message = "Your verification code is {$verificationCode->otp}";

        return redirect()->route('otp.verification')->with('success', $message);
    }

    public function generateOtp($email){
        $user = User::where('email', $email)->first();
        
        $verificationCode = VerificationCode::where('user_id', $user->id)->latest()->first();

        $now = Carbon::now();

        if($verificationCode && $verificationCode->expired_at){
            return $verificationCode;
        }

        return VerificationCode::create([
            'user_id' => $user->id,
            'otp' => rand(100000, 999999),
            'expired_at' => $now->addMinutes(5)
        ]);
    }
}
