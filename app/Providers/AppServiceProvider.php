<?php

namespace App\Providers;

use Aloha\Twilio\Twilio;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use libphonenumber\PhoneNumberUtil;
use App\Verify\Service;
use App\Services\Twilio\Verification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
        // TODO: are you sure about how you will manage different timezones for different geo-users ??
        if(strtolower(date_default_timezone_get()) !== "africa/algiers")
        {
            date_default_timezone_set("Africa/Algiers");
        }
        // Register Google's Phone-Number-Utility Service
        $this->app->singleton('phoneNumberUtil', function(){
            return PhoneNumberUtil::getInstance();
        });
        // Register Twilio Service
        $this->app->bind(Service::class, Verification::class);

        $this->app->singleton('country-code-for-client', function(){
            // TODO: set default region using the IP address of the client
            return 'DZ';
        });
        $this->app->singleton('locale-for-client', function(){
            if(!empty(session('locale')))
            {
                // if the user's 'locale' cookie is set we want to use it
                $locale = session('locale');
            }else{
                // most browsers now will send the user's preferred language with the request
                // so we just read it
                $locale = request()->server('HTTP_ACCEPT_LANGUAGE');
                $locale = substr($locale, 0, 2);
            }
            if(in_array($locale, config('app.locales'), true))
            {
                return $locale;
            }
            // if the cookie or the browser's locale is invalid or unknown we fallback
            return config('app.fallback_locale');
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('apiToken', function () {
            return "<input hidden name='api_token' value='{{ Auth::user()->singleUseToken() }}'/>";
        });
        Auth::macro('profile', function(){
            if(Auth::user())
            {
                return Auth::user()->activeProfile;
            }
            return null;
        });
        Validator::extendImplicit('allowed_attributes', function ($attribute, $value, $parameters, $validator) {
            // If the attribute to validate request top level
            if (strpos($attribute, '.') === false) {
                return in_array($attribute, $parameters);
            }
        
            // If the attribute under validation is an array
            if (is_array($value)) {
                return empty(array_diff_key($value, array_flip($parameters)));
            }
        
            // If the attribute under validation is an object
            foreach ($parameters as $parameter) {
                if (substr_compare($attribute, $parameter, -strlen($parameter)) === 0) {
                    return true;
                }
            }
        
            return false;
        });
    }
}
