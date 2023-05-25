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
    //   dd($date);
    }

    public function daycompare($date,$end)
    { 
      $todayDate = Carbon::now();
      $initialDate = Carbon::parse($date)->format('Y-m-d');
      $endDate = Carbon::parse($end)->format('Y-m-d');
      $finalDate = $todayDate->diffInDays($initialDate);
      $totalDate = floor(abs(strtotime($endDate) - strtotime($initialDate))/86400);

      if ($totalDate < 0) {
          $totalDate = abs($totalDate);
      } else {
          $totalDate = $totalDate;
      }
      $percentage = ($finalDate/$totalDate) * 100;
      // dd($percentage);
      return $percentage;
    }

    public static function daytimeline($date,$end)
    { 
      $todayDate = Carbon::now();
      $initialDate = Carbon::parse($date)->format('Y-m-d');
      $endDate = Carbon::parse($end)->format('Y-m-d');
      $finalDate = $todayDate->diffInDays($initialDate);
      $totalDate = floor(abs(strtotime($endDate) - strtotime($initialDate))/86400);

      if ($totalDate < 0) {
          $totalDate = abs($totalDate);
      } else {
          $totalDate = $totalDate;
      }
      if($totalDate != 0){
        $percentage = ($finalDate/$totalDate) * 100;
      }else{
        $percentage = 0;
      }
      // dd($percentage);
      return $percentage;
    }

    public static function dayPercentage($date,$end)
    { 
      $todayDate = Carbon::now();
      $initialDate = Carbon::parse($date)->format('Y-m-d');
      $endDate = Carbon::parse($end)->format('Y-m-d');
      $finalDate = $todayDate->diffInDays($initialDate);
      $totalDate = floor(abs(strtotime($endDate) - strtotime($initialDate))/86400);

      if ($totalDate < 0) {
          $totalDate = abs($totalDate);
      } else {
          $totalDate = $totalDate;
      }
      $percentage = ($finalDate/$totalDate) * 100;
      // dd($percentage);
      return $percentage;
    }
}
