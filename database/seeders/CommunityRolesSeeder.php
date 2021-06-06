<?php

namespace Database\Seeders;

use App\Models\CommunityPermission;
use App\Models\CommunityRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommunityRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            /**
             * @var CommunityRole $role
             */
            $role = CommunityRole::create([
                'id' => CommunityRole::MEMBER_DEFAULT_ROLE_ID,
                'name' => 'default_role'
            ]);
            $role->permissions()->saveMany([
                CommunityPermission::find(config('permissions.can-comment-on-comments')),
                CommunityPermission::find(config('permissions.can-create-posts')),
                CommunityPermission::find(config('permissions.can-comment-on-posts')),
                CommunityPermission::find(config('permissions.can-mention-members')),
                CommunityPermission::find(config('permissions.can-mention-non-members')),
                CommunityPermission::find(config('permissions.can-attach-images-to-own-comment')),
                CommunityPermission::find(config('permissions.can-attach-videos-to-own-comment')),
                CommunityPermission::find(config('permissions.can-attach-images-to-own-post')),
                CommunityPermission::find(config('permissions.can-attach-videos-to-own-post')),
            ]);

            $role = CommunityRole::create([
                'id' => CommunityRole::OWNER_ROLE_ID,
                'name' => 'community_owner_role'
            ]);
            $role->permissions()->saveMany(CommunityPermission::all());
        });
    }
}
