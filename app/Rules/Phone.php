<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Log;
use libphonenumber\PhoneNumberUtil;
use PHPUnit\Exception;

class Phone implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */


    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $rawNumber
     * @return bool
     */
    public function passes($attribute, $rawNumber): bool
    {
        /**
         * @var $phoneUtil PhoneNumberUtil
         */
        $phoneUtil = app()->get('phoneNumberUtil');
        try {
            // TODO: set default region using the IP address of the client
            $phoneNumber = $phoneUtil->parse($rawNumber, "DZ");
            return $phoneNumber !== null && $phoneUtil->isValidNumber($phoneNumber);
        }catch (\Exception $e)
        {
            report($e);
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.phone');
    }
}
