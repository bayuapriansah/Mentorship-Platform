<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Carbon;
use DateTime;

class SimintEncryption extends Controller
{
    public function encData($data){
      $encrypted = Crypt::encryptString($data);
      return $encrypted;
    }

    public function decData($data){
      $decrypted = Crypt::decryptString($data);
      return $decrypted;
    }

    public function waktu()
    {
      $myDate = Carbon::now()->toDateString();
      $date = Carbon::createFromFormat('Y-m-d', $myDate);
      $daysToAdd = 20;
      $date = $date->addDays($daysToAdd)->toDateString();
      dd($date);
    }

    public function bday()
    {
      $myBday = "2023-04-07";
      $myBday = new DateTime($myBday);
      $myDate = Carbon::now()->toDateString();
      $date = Carbon::createFromFormat('Y-m-d', $myDate);
      $date = new DateTime($myDate);
      $bday = $date->diff($myBday);
      // $daysToAdd = 20;
      // $date = $date->addDays($daysToAdd)->toDateString();
      dd($bday->format('%a'));
    }
}
