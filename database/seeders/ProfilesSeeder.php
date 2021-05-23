<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            $users = User::all();
            Profile::factory()->count(2000)->make()->each(function(Profile $profile)use($users){
                $profile->account()->associate($users->random())->save();
                Image::factory()->make()->imageable()->associate($profile)->save();
            });
        });
    }
}
