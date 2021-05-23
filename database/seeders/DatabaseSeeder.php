<?php

namespace Database\Seeders;

use App\Models\BusinessCategory;
use App\Models\ProfileImage;
use App\Models\User;
use App\Models\UserSettings;
use Database\Factories\UserSettingsFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        $this->call(UsersSeeder::class)
            ->call(CommunityPermissionsSeeder::class)
            ->call(CommunityRolesSeeder::class)
            ->call(ProfilesSeeder::class)
            ->call(CommunitiesSeeder::class)
            ->call(CommunityMembersSeeder::class)
            ->call(PostsSeeder::class)
    ;
    }   
}
