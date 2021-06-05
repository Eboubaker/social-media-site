<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserSettings;
use App\Models\ProfileImage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition(): array
    {
        $email = random_int(0, 100) > 50;
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'phone' => $email ? null : $this->faker->unique()->phoneNumber(),
            'email' => $email? $this->faker->unique()->safeEmail() : null,
            'email_verified_at' => $email ? (FactoryHelper::randc(.5) ? now() : null) : null,
            'phone_verified_at' => $email ? null : (FactoryHelper::randc(.5) ? now() : null),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // Hash::make('password')
            'remember_token' => Str::random(10),
        ];
    }
}
