<?php

use Illuminate\Database\Migrations\Migration;
use App\DataBase\Trigger\TriggerFacade as Schema;

class CreateCantUpdateProfilesFollowersRowsTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cant_update_profiles_followers_rows')
            ->on('profiles_followers')
            ->statement(function () {
                return "
                IF old.profile_id != new.profile_id or old.follower_id != new.follower_id
                then
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'updating profiles_followers rows is forbidden.';
                end if;
                ";
            })
            ->before()
            ->update();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles_followers.cant_update_profiles_followers_rows');
    }
}
