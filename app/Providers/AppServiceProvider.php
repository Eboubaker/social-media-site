<?php

namespace App\Providers;

use Aloha\Twilio\Twilio;
use Illuminate\Support\ServiceProvider;
use libphonenumber\PhoneNumberUtil;
use App\Verify\Service;
use App\Services\Twilio\Verification;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
