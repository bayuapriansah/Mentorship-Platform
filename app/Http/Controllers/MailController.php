<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\MailNotify;
class MailController extends Controller
{
    public function index()
    {
        $data = [
            'subject' => 'Registration Under Review',
            'body' => 'Your registration is under review, please wait for confirmation email from us. Thank you! 😊
            Best regards,
            Simulated Internship'
        ];
        try
        {
            Mail::to('bayuapriansah77@gmail.com')->send(new MailNotify($data));
            return response()->json(['Email sent successfully']);
        } catch (Exeption $th) {
            return response()->json(['Sorry Something went wrong']);
        }
    }
}
