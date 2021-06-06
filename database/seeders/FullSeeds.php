<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FullSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            $this
            ->call(UsersSeeder::class)
            ->call(ProfilesSeeder::class)
            ->call(ProfileFollowersSeeder::class)
            ->call(CommunityPermissionsSeeder::class)
            ->call(CommunityRolesSeeder::class)
            ->call(CommunitiesSeeder::class)
            ->call(CommunityMembersSeeder::class)
            ->call(PostsSeeder::class)
            ->call(PostViewsSeeder::class)
            ->call(CommentsSeeder::class)
            ->call(RepliesSeeder::class)
            ->call(LikesSeeder::class)
        ;
        });
    }
}
