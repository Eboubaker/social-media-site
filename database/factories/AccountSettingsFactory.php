<?php

namespace Database\Factories;

use App\Models\AccountSettings;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;

class AccountSettingsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AccountSettings::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
//        Log::debug("Entering AccountSettingsFactory definition");
        $atts = [
            'data' => new \stdClass()
        ];
//        Log::debug("Leaving AccountSettingsFactory definition");
        return $atts;
    }
}
