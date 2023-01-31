<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotify;
use Exception;
class MailController extends Controller
{
    public function emailregister($mailto) //Just Email
    {
        $data = [
            'subject' => 'Registration Completed',
            'body' => $mailto,
            'body2' => (new SimintEncryption)->encData($mailto),
            // 'body' => 'Your registration as Student is Completed',
            // 'body2' => 'You can Login, and Choose the Projet that Available.',
            // 'body3' => 'If you still have a question related about this, please contact us.',
            // 'body4'=> 'Best regards,',
            // 'body5'=> 'Simulated Internship Team ❤️',
            'type' => 'welcome',
        ];
        try
        {
            Mail::to($mailto)->send(new MailNotify($data));
            return response()->json(['Registration Email sent successfully']);
        } catch (\Exception $th) {
            return response()->json(['Sorry Something went wrong']);
        }
    }

    public function otplogin($mailto,$otpdata) //Email , OTP
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
        } catch (\Exception $th) {
            return response()->json(['Sorry Something went wrong']);
        }
    }

    public function EmailMentorInvitation($mailto,$urlInvitation) //Email, urlInvitation
    {
        $data = [
            'subject' => 'Invitation to be a Mentor',
            'body' => $mailto,
            'body2' => $urlInvitation,
            'body3' => '',
            'body4' => '',
            'body5'=> '',
            // 'body' => 'We would like to invite you to be a Mentor, and put you on project that you can mentor.',
            // 'body2' => 'Please click the link below to fill the form and register as a Mentor.',
            // 'body3' => $urlInvitation,
            // 'body4' => 'Best regards,',
            // 'body5'=> 'Simulated Internship Team ❤️',
            'type' => 'mentor',
        ];
        try
        {
            Mail::to($mailto)->send(new MailNotify($data));
            return response()->json(['Mentor Invitation  Email sent successfully']);
        } catch (\Exception $th) {
            return response()->json(['Sorry Something went wrong']);
        }
    }

    public function EmailMentorRegister($mailto) //Email
    {
        $data = [
            'subject' => 'Registration Completed',
            'body' => $mailto,
            'body2' => 'otp/login',
            // 'body3' => 'if you still have a question related about this, please contact us : support@simulatedinternship.com',
            // 'body4' => 'Best regards,',
            // 'body5'=> 'Simulated Internship Team ❤️',
            'type' => 'mentor',
        ];
        try
        {
            Mail::to($mailto)->send(new MailNotify($data));
            return response()->json(['Mentor Registration Email sent successfully']);
        } catch (\Exception $th) {
            return response()->json(['Sorry Something went wrong']);
        }
    }

    public function EmailMentor($mailto,$projectName) //Email , Project Name
    {
        $data = [
            'subject' => 'New Project Assignment',
            'body' => 'You have been assigned to a new project, please check your dashboard for more information.',
            'body2' => 'Project Name: '.$projectName,
            'body3' => '',
            'body4' => 'Best regards,',
            'body5'=> 'Simulated Internship Team ❤️',
            'type' => 'welcome',
        ];
        try
        {
            Mail::to($mailto)->send(new MailNotify($data));
            return response()->json(['Mentor Assignment Project Email sent successfully']);
        } catch (\Exception $th) {
            return response()->json(['Sorry Something went wrong']);
        }
    }
}
