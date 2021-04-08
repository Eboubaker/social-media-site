<?php

namespace Database\Seeders;

use App\Models\BusinessCategory;
use App\Models\User;
use App\Models\UserSettings;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $user = User::create([
             "email" => "test@gmail.com",
             "email_verified_at" => now(),
             "password" => Hash::make("password"),
         ]);
         $user->socialProfiles()->create([
             "data" => new \stdClass,
         ]);
        $user->businessProfiles()->create([
            "data" => new \stdClass,
        ]);
        $user->settings()->create(UserSettings::factory()->make()->attributesToArray());

        BusinessCategory::create(['name' => 'Food']);
        BusinessCategory::create(['name' => 'Transport']);

    }
}
