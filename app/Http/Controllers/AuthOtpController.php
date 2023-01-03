<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VerificationCode;
use Carbon\Carbon;
use App\Models\Student;
use App\Models\Mentor;
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
            'email' => 'required'
        ]);
        $user_id = Student::where('email', $request->email)->first();
        if(!$user_id){
            $user_id = Mentor::where('email', $request->email)->first();
        }
        $verificationCode = $this->generateOtp($request->email);
        $otp = $verificationCode->otp;
        $encId = (new simintEncryption)->encData($user_id->id);
        $encEmail = (new simintEncryption)->encData($request->email);
        $message = "Your OTP verification code Already sent to your email";
        $sendmail = (new MailController)->otplogin($request->email,$otp);
        return redirect()->route('otp.verification', [$encId,$encEmail])->with('success', $message);
    }

    public function generateOtp($email){
        // Check if email exists
        $data_user = Student::where('email', $email)->first();
        if(!$data_user){
            $data_user = Mentor::where('email', $email)->first();
        }

        // check email does not have otp code
        $verificationCode = VerificationCode::where('user_id', $data_user->id)->latest()->first();

        $now = Carbon::now();

        if($verificationCode && $now->isBefore($verificationCode->expired_at)){
            return $verificationCode;
        }

        return VerificationCode::create([
            'user_id' => $data_user->id,
            'email' => $email,
            'otp' => rand(1111, 9999),
            'expired_at' => $now->addMinutes(5) // Otp Only Last 5 minutes
        ]);
    }

    public function verification($user_id,$email){
        return view('auth.loginOtpVerification')->with([
            'user_id' => $user_id,
            'email' => (new simintEncryption)->decData($email)
        ]);
    }

    public function loginWithOtp(Request $request){
        $request->validate([
            'user_id' => 'required',
            'email' => 'required',
            'otp' => 'required'
        ]);
        $theMail = (new simintEncryption)->encData($request->email);
        $encId = (new simintEncryption)->decData($request->user_id);
        $encEmail = (new simintEncryption)->decData($theMail);
        $verificationCode = VerificationCode::where('user_id', $encId)->where('email', $encEmail)->where('otp', $request->otp)->first();
        $now = Carbon::now();
        if(!$verificationCode){
            return redirect()->route('otp.verification')->with('error', 'Your verification code is invalid');
        }elseif($verificationCode && $now->isAfter($verificationCode->expired_at)){
            return redirect()->route('otp.login')->with('error', 'Your verification code has expired');
        }

        $data_user = Student::where('id', $encId)->where('email', $encEmail)->first();
        if(!$data_user){
            $data_user = Mentor::where('id', $encId)->where('email', $encEmail)->first();
            $verificationCode->update([
                'expired_at' => $now
            ]);
            Auth::guard('mentor')->login($data_user);
            return redirect('/')->with('success', 'You are logged in');
        }else{
            $verificationCode->update([
                'expired_at' => $now
            ]);
            Auth::guard('student')->login($data_user);
            return redirect('/projects/'.Auth::guard('student')->user()->id.'/applied')->with('success', 'You are logged in');
        }
    }
}
