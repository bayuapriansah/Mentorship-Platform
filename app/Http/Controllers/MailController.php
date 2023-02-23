<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotify;
use Exception;
class MailController extends Controller
{

    // Used Function

    /*
    /
    /   Function used when platform admin using single invitation or bulk invitation
    /
    */
    public function EmailMentorInvitation($mailto,$urlInvitation) //Email, urlInvitation
    {
        $data = [
            'subject' => 'Invitation to be a Mentor',
            'body' => $mailto,
            'body2' => $urlInvitation,
            'type' => 'cusmemb',
        ];
        try
        {
            Mail::to($mailto)->send(new MailNotify($data));
            return response()->json(['Mentor Invitation  Email sent successfully']);
        } catch (\Exception $th) {
            return response()->json(['Sorry Something went wrong']);
        }


    public function emailregister($mailto) //Just Email
    {
        $data = [
            'subject' => 'Registration Completed',
            'body' => $mailto,
            'body2' => (new SimintEncryption)->encData($mailto),
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

    public function EmailMemberInvitation($mailto,$urlInvitation) //Email, urlInvitation
    {
        $data = [
            'subject' => 'Invitation to be a Member',
            'body' => $mailto,
            'body2' => $urlInvitation,
            'body3' => '',
            'body4' => '',
            'body5'=> '',
            'type' => 'member',
        ];
        try
        {
            Mail::to($mailto)->send(new MailNotify($data));
            return response()->json(['Member Invitation  Email sent successfully']);
        } catch (\Exception $th) {
            return response()->json(['Sorry Something went wrong']);
        }
    }

    public function emailResetPassword($mailto, $urlInvitation) //Just Email
    {
        $data = [
            'subject' => 'Reset Password',
            'body' => $mailto,
            'body2' => $urlInvitation,
            'type' => 'reset',
        ];
        try
        {
            Mail::to($mailto)->send(new MailNotify($data));
            return response()->json(['Registration Email sent successfully']);
        } catch (\Exception $th) {
            return response()->json(['Sorry Something went wrong']);
        }
    }


    public function EmailMemberRegister($mailto) //Email
    {
        $data = [
            'subject' => 'Registration Completed',
            'body' => $mailto,
            // 'body2' => 'otp/login',
            'type' => 'member',
        ];
        try
        {
            Mail::to($mailto)->send(new MailNotify($data));
            return response()->json(['Mentor Registration Email sent successfully']);
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

    public function EmailStudentInvitation($mailto,$urlInvitation) //Email, urlInvitation
    {
        $data = [
            'subject' => 'Invitation to be a Student',
            'body' => $mailto,
            'body2' => $urlInvitation,
            'type' => 'welcome',
        ];
        try
        {
            Mail::to($mailto)->send(new MailNotify($data));
            return response()->json(['Mentor Invitation  Email sent successfully']);
        } catch (\Exception $th) {
            return response()->json(['Sorry Something went wrong']);
        }
    }
}
