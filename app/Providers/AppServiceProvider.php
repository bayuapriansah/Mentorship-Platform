<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use App\Rules\RecaptchaValidationRule;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('recaptcha', function ($attribute, $value, $parameters, $validator) {
            return (new RecaptchaValidationRule)->passes($attribute, $value);
        });
    }
}
