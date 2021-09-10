<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfileFollowersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            $profiles = Profile::all();
            $inserted = [];
            foreach(range(1, $profiles->count()) as $_)
            {
                $profile = $profiles->random();
                $follower = $profiles->random();
                if($profile->getKey() !== $follower->getKey() && !isset($inserted[$profile->getKey()."|".$follower->getKey()]))
                {
                    $inserted[$profile->getKey()."|".$follower->getKey()] = true;
                    $profile->followers()->save($follower);
                }
            }
        });
        
    }
}
