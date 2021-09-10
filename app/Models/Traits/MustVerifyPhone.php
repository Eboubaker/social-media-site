<?php


namespace App\Models\Traits;


use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\View\View;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

trait MustVerifyPhone
{
    /**
     * Determine if the user has verified their phone number.
     *
     * @return bool
     */
    public function hasVerifiedPhone()
    {
        return ! is_null($this->phone_verified_at);
    }

    /**
     * Mark the given user's phone number as verified.
     *
     * @return bool
     */
    public function markPhoneAsVerified()
    {
        return $this->forceFill([
            'phone_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    /**
     * Send the phone verification message.
     *
     * @return View|null
     */
    public function sendPhoneVerificationNotification()
    {
        if (false) {
            $this->delete();
            foreach ($verification->getErrors() as $error)
            {
                report($error);
            }
            return view('auth.register')->withErrors(['verification' => __("invalid phone number")]);
        }
        return null;
    }

    /**
     * Get the phone number that should be used for verification.
     *
     * @return string
     */
    public function getPhoneForVerification()
    {
        return $this->phoneNumber;
    }
}
