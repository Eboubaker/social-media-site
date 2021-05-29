<?php

use Illuminate\Database\Migrations\Migration;
use App\DataBase\Trigger\TriggerFacade as Schema;

class CreateOnMemberLeaveDecrementCommunityMembersCountTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('on_member_leave_decrement_community_members_count')
            ->on('communities_members')
            ->statement(function () {
                return 'UPDATE communities SET members_count=members_count-1 where id = OLD.community_id;';
            })
            ->after()
            ->delete();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('communities_members.on_member_leave_decrement_community_members_count');
    }
}
