<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class FaceDetectionController extends Controller
{
    public function index()
    {
        return view('face-detection');
    }

    public function runFaceDetection()
    {
        $process = shell_exec("python3 /var/www/html/Simulated-Internship/public/assets/face.py");

        dd($process);
    }    
}