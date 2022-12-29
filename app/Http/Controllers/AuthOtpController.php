<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VerificationCode;
use Carbon\Carbon;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MailController;
use App\Http\Controllers\simintEncryption;


class AuthOtpController extends Controller
{
    public function login(){
        return view('auth.loginOtp');
    }

    public function generate(Request $request){
        $request->validate([
            'email' => 'required|exists:students,email'
        ]);
        $user_id = Student::where('email', $request->email)->first();
        // dd($user_id->all());
        $verificationCode = $this->generateOtp($request->email);
        $otp = $verificationCode->otp;
        $encId = (new simintEncryption)->encData($user_id->id);
        // dd($encId);
        $message = "Your OTP verification code Already sent to your email";
        $sendmail = (new MailController)->otplogin($request->email,$otp);
        return redirect('/otp/verification/'.$encId)->with('success', $message);
    }

    public function generateOtp($email){
        // Check if email exists
        $student = Student::where('email', $email)->first();

        // check email does not have otp code
        $verificationCode = VerificationCode::where('user_id', $student->id)->latest()->first();

        $now = Carbon::now();

        if($verificationCode && $now->isBefore($verificationCode->expired_at)){
            return $verificationCode;
        }

        return VerificationCode::create([
            'user_id' => $student->id,
            'otp' => rand(1111, 9999),
            'expired_at' => $now->addMinutes(5) // Otp Only Last 5 minutes
        ]);
    }

    public function verification($user_id){
        return view('auth.loginOtpVerification')->with([
            'user_id' => $user_id
        ]);
    }

    public function loginWithOtp(Request $request){
        $request->validate([
            'user_id' => 'required|exists:students,id',
            'otp' => 'required'
        ]);
        $verificationCode = VerificationCode::where('user_id', $request->user_id)->where('otp', $request->otp)->first();
        $now = Carbon::now();
        if(!$verificationCode){
            return redirect()->route('otp.verification')->with('error', 'Your verification code is invalid');
        }elseif($verificationCode && $now->isAfter($verificationCode->expired_at)){
            return redirect()->route('otp.login')->with('error', 'Your verification code has expired');
        }
        $student = Student::where('id', $request->user_id)->first();
        // dd($student);
        if($student){
            $verificationCode->update([
                'expired_at' => $now
            ]);
            Auth::guard('student')->login($student);
            return redirect('/')->with('success', 'You are logged in');
        }
    }
}
