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
      // Check the format of the data
      if(!is_string($data) || strlen($data) < 1) {
          return 'Error: Invalid data format';
      }
      // Check if the encryption key is valid
      if(!config('app.key')){
          return 'Error: Invalid key';
      }
      // Check if the payload is base64 encoded
      if(!base64_decode($data, true)){
          return 'Error: Payload is not base64 encoded';
      }
      try {
          // Decrypt the data
          $decrypted = Crypt::decryptString($data);
          return $decrypted;
      } catch(\Illuminate\Contracts\Encryption\DecryptException $e) {
          return abort(403);
          return 'Error: Invalid payload';
      }
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
