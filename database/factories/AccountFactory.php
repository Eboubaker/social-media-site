<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\AccountSettings;
use App\Models\ProfileImage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Account::class;

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
            Account::PKEY => Str::uuid()->toString(),
            'public_id' => Str::random(Account::PUPLIC_ID_LEN),
            'phone' => $email ? null : $this->faker->phoneNumber,
            'email' => $email? $this->faker->unique()->safeEmail : null,
            'email_verified_at' => $email ? (random_int(0, 100) > 50 ? now() : null) : null,
            'phone_verified_at' => $email ? null : (random_int(0, 100) > 50 ? now() : null),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // Hash::make('password')
            'remember_token' => Str::random(10),
        ];
    }
    public function configure()
    {
        return $this->afterCreating(function (Account $account) {
            $account->settings()->create(AccountSettings::factory()->make()->attributesToArray());
            $account->profileImage()->create(ProfileImage::factory()->make()->attributesToArray());
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
