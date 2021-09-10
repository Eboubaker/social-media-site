<?php

use Illuminate\Database\Migrations\Migration;
use App\DataBase\Trigger\TriggerFacade as Schema;
use App\Models\CommunityMember;

class CreateAddMemberDefaultRoleIdBeforeMemberJoinsCommunityTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('add_member_default_role_id_before_member_joins_community')
            ->on(CommunityMember::tablename())
            ->statement(function () {
                return "
                IF NEW.role_id is null and NEW.community_id is not null
                THEN
                    SET NEW.role_id = (select member_default_role_id from communities where id = NEW.community_id);
                END IF;
                ";
            })
            ->before()
            ->insert();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('communities_members.add_member_default_role_id_before_member_joins_community');
    }
}
