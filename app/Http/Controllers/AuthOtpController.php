<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Mentor;
use App\Models\Student;
use App\Models\VerificationCode;
use App\Http\Controllers\MailController;
use App\Http\Controllers\SimintEncryption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthOtpController extends Controller
{
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
        return view('auth.loginOtp');
    }

    public function generate(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'email' => 'required',
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
            return redirect()->route('otp.login')->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();
        $user_id = Student::where('email', $request->email)->first();
        if(!$user_id){
            $user_id = Mentor::where('email', $request->email)->first();
        }
        $verificationCode = $this->generateOtp($request->email);
        $otp = $verificationCode->otp;
        $encId = (new SimintEncryption)->encData($user_id->id);
        $encEmail = (new SimintEncryption)->encData($request->email);
        $message = "We have sent a One Time Password (OTP) to your email address. Please enter it below";
        $sendmail = (new MailController)->otplogin($request->email,$otp);
        return redirect()->route('otp.verification', [$encId,$encEmail])->with('success', $message);
    }

    public function generateOtp($email){
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
            'expired_at' => $now->addMinutes(2) // Otp Only Last 2 minutes
        ]);
    }

    public function verification($user_id,$email){
        return view('auth.loginOtpVerification')->with([
            'user_id' => $user_id,
            'email' => (new SimintEncryption)->decData($email)
        ]);
    }

    public function loginWithOtp(Request $request){
        if($request->input('action') == 'login'){
            $request->validate([
                'user_id' => 'required',
                'email' => 'required',
                'otp' => 'required'
            ]);
            $theMail = (new SimintEncryption)->encData($request->email);
            $encId = (new SimintEncryption)->decData($request->user_id);
            $encEmail = (new SimintEncryption)->decData($theMail);
            $verificationCode = VerificationCode::where('user_id', $encId)->where('email', $encEmail)->where('otp', $request->otp)->first();
            $now = Carbon::now();
            if(!$verificationCode){
                return redirect()->route('otp.verification',[$request->user_id,$theMail])->with('error', 'Your OTP code invalid');
            }elseif($verificationCode && $now->isAfter($verificationCode->expired_at)){
                return redirect()->route('otp.login')->with('error', 'Your verification code has expired');
            }
            
            $data_user = Student::where('id', $encId)->where('email', $encEmail)->first();
            // dd(!$data_user->email == 'student@mail.test');
            if(!$data_user){
                $data_user = Mentor::where('id', $encId)->where('email', $encEmail)->first();
                $verificationCode->update([
                    'expired_at' => $now
                ]);
                Auth::guard('mentor')->login($data_user);
                return redirect('/')->with('success', 'You are logged in');
            }else{
                if(!$data_user->email == 'student@mail.test'){
                    $verificationCode->update([
                        'expired_at' => $now
                    ]);
                }
                Auth::guard('student')->login($data_user);
                return redirect('/profile/'.Auth::guard('student')->user()->id.'/allProjects')->with('success', 'You are logged in');
            }
        }elseif($request->input('action') == 'otp'){
            $this->generate($request);
            return back();
        }else{
            return abort(403, 'Unauthorized action.');   
        }
    }
}
