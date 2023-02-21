<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RecaptchaValidationRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $secretkey = config('services.recaptcha.secret');
        $response = $value;
        $userIP = $_SERVER['REMOTE_ADDR'];
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$response&remoteip=$userIP";
        $response = file_get_contents($url);
        $response = json_decode($response);

        return $response->success;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Google reCAPTCHA validation failed, please try again.';
    }
}
