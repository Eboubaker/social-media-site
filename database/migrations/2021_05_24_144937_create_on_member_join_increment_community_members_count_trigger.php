<?php

use Illuminate\Database\Migrations\Migration;
use App\DataBase\Trigger\TriggerFacade as Schema;

class CreateOnMemberJoinIncrementCommunityMembersCountTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('on_member_join_increment_community_members_count')
            ->on('communities_members')
            ->statement(function () {
                return 'UPDATE communities SET members_count=members_count+1 where id = NEW.community_id;';
            })
            ->after()
            ->insert();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('communities_members.on_member_join_increment_community_members_count');
    }
}
