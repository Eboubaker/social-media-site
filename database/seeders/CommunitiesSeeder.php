<?php

namespace Database\Seeders;

use App\Models\Community;
use App\Models\CommunityMember;
use App\Models\CommunityRole;
use App\Models\Image;
use App\Models\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommunitiesSeeder extends Seeder
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
            foreach(range(0, 10) as $_)
            {
                $profile = $profiles->random();
                $community = Community::factory()->make();

                $community->owner()->associate($profile)->save();
                $community->members()->save(CommunityMember::make([
                    'profile_id' => $profile->getKey(),
                    'role_id' => CommunityRole::OWNER_ROLE_ID
                ]));
                Image::factory()->make(['purpose' => 'iconImage'])->imageable()->associate($community)->save();
                Image::factory()->make(['purpose' => 'coverImage'])->imageable()->associate($community)->save();
            }
        });
    }
}
