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
                /** @var Profile $profile  */
                $profile = $profiles->random();
                $community = $profile->ownedCommunities()->save(Community::factory()->make());
                $community->iconImage()->save(Image::factory()->make());
                $community->coverImage()->save(Image::factory()->make());
            }
        });
    }
}
