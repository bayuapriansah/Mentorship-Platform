<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class simintEncryption extends Controller
{
    public function encData($data){
		$encrypted = Crypt::encryptString($data);
        return $encrypted;
	}

    public function decData($data){
		$decrypted = Crypt::decryptString($data);
        return $decrypted;
	}
}
