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
//        Log::debug("Entering AccountFactory definition");
        $email = random_int(0, 100) > 50;
        $atts = [
//            Account::PKEY => Str::uuid()->toString(),
            'phone' => $email ? null : $this->faker->phoneNumber,
            'email' => $email? $this->faker->unique()->safeEmail : null,
            'email_verified_at' => $email ? (FactoryHelper::randc(.5) ? now() : null) : null,
            'phone_verified_at' => $email ? null : (FactoryHelper::randc(.5) ? now() : null),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // Hash::make('password')
            'remember_token' => Str::random(10),
        ];
        Log::debug("Leaving AccountFactory definition");
        return $atts;
    }
    public function configure()
    {
        return $this->afterCreating(function (User $account) {
//            Log::debug("Entering AccountFactory afterCreating");
            $account->settings()->save(UserSettings::factory()->make());
            $account->profileImage()->save(ProfileImage::factory()->make());
//            Log::debug("Leaving AccountFactory afterCreating");
        });
    }
    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverifiedfiftyfifty()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => rand(0, 100) > 50 ? now() : null,
            ];
        });
    }
}
