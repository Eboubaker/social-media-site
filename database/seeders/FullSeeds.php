<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FullSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this
            ->call(UsersSeeder::class)
            ->call(CommunityPermissionsSeeder::class)
            ->call(CommunityRolesSeeder::class)
            ->call(ProfilesSeeder::class)
            ->call(ProfileFollowersSeeder::class)
            ->call(CommunitiesSeeder::class)
            ->call(CommunityMembersSeeder::class)
            ->call(PostsSeeder::class)
            ->call(PostViewsSeeder::class)
            ->call(CommentsSeeder::class)
            ->call(LikesSeeder::class)
        ;
    }
}
