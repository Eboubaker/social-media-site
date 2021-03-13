<?php

namespace Database\Factories;

use App\Models\AccountSettings;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'data' => json_encode(new \stdClass(), JSON_THROW_ON_ERROR)
        ];
    }
}
