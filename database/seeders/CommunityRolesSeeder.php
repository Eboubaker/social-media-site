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
            $visitor_permissions = [
                CommunityPermission::find(config('permissions.communities.can-reply-to-comments')),
                CommunityPermission::find(config('permissions.communities.can-create-posts')),
                CommunityPermission::find(config('permissions.communities.can-comment-on-posts')),
                CommunityPermission::find(config('permissions.communities.can-mention-members')),
                CommunityPermission::find(config('permissions.communities.can-mention-non-members')),
                CommunityPermission::find(config('permissions.communities.can-attach-images-to-own-comment')),
                CommunityPermission::find(config('permissions.communities.can-attach-videos-to-own-comment')),
                CommunityPermission::find(config('permissions.communities.can-attach-images-to-own-post')),
                CommunityPermission::find(config('permissions.communities.can-attach-videos-to-own-post')),
            ];
            
            CommunityRole::create([
                'id' => CommunityRole::MEMBER_DEFAULT_ROLE_ID,
                'name' => 'community_member_default_role_id'
            ])->permissions()->saveMany($visitor_permissions + [
                // member-only permission go here
            ]);
            CommunityRole::create([
                'id' => CommunityRole::VISITOR_DEFAULT_ROLE_ID,
                'name' => 'community_visitor_default_role_id'
            ])->permissions()->saveMany($visitor_permissions);

            CommunityRole::create([
                'id' => CommunityRole::OWNER_ROLE_ID,
                'name' => 'community_owner_role'
            ])->permissions()->saveMany(CommunityPermission::all());
        });
    }
}
