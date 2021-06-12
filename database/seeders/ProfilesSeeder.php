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
            Profile::factory()->count(100)->make()->each(function (Profile $profile) use ($users) {
                $profile->active = true;
                $profile->account()->associate($users->random())->save();
                Image::factory()->make(['purpose' => 'profileImage'])->imageable()->associate($profile)->save();
                Image::factory()->make(['purpose' => 'coverImage'])->imageable()->associate($profile)->save();
            });
            $p = Profile::factory()->create([
                'user_id' => User::where('email', 'admin@test.com')->first('id')->id
            ]);
            Image::factory()->make(['purpose' => 'profileImage'])->imageable()->associate($p)->save();
            Image::factory()->make(['purpose' => 'coverImage'])->imageable()->associate($p)->save();
        });
        DB::transaction(function () {
            foreach (User::withCount('profiles')->get() as $user) {
                $user->profiles()->limit($user->profiles_count-1)->update(['active' => false]);
            }
        });
    }
}
