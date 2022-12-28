<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\MailNotify;
class MailController extends Controller
{
    public function emailregister($mailto)
    {
        $data = [
            'subject' => 'Registration Under Review',
            'body' => 'Your registration is under review, please wait for confirmation email from us. Thank you! 😊',
            'body2' => 'it takes 1-2 days to review your registration.',
            'body3' => 'but no worries if you\'re account is ready to use, we will inform you via email.',
            'body4'=> 'Best regards,',
            'body5'=> 'Simulated Internship Team ❤️',
            'type' => 'index',
        ];
        try
        {
            Mail::to($mailto)->send(new MailNotify($data));
            return response()->json(['Registration Email sent successfully']);
        } catch (Exeption $th) {
            return response()->json(['Sorry Something went wrong']);
        }
    }

    public function otplogin($mailto,$otpdata)
    {
        $data = [
            'subject' => '[Simulated Internship] OTP Verification',
            'body' => $otpdata,
            'type' => 'otp',
        ];
        try
        {
            Mail::to($mailto)->send(new MailNotify($data));
            return response()->json(['OTP Verification Email sent successfully']);
        } catch (Exeption $th) {
            return response()->json(['Sorry Something went wrong']);
        }
    }
}
