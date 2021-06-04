<?php

namespace Database\Seeders;

use App\Models\Community;
use App\Models\CommunityMember;
use App\Models\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommunityMembersSeeder extends Seeder
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
            $communities = Community::all();
            $combosites = [];
            foreach (CommunityMember::all() as $member) {
                $combosites[$member->community->getKey() . "|" . $member->profile->getKey()] = true;
            }
            foreach (range(0, 100) as $i) {
                /** @var Community $community */
                $community = $communities->random();
                $profile = $profiles->random();
                $combosite = $community->getKey() . "|" . $profile->getKey();
                if (!isset($combosites[$combosite])) {
                    CommunityMember::create([
                        'profile_id' => $profile->getKey(),
                        'community_id' => $community->getKey()
                    ]);
                    $combosites[$combosite] = true;
                }
            } 
        });
    }
}
