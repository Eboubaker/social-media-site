<?php

use Illuminate\Database\Migrations\Migration;
use App\DataBase\Trigger\TriggerFacade as Schema;

class CreateProfileCantFollowItselfTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_cant_follow_itself')
            ->on('profiles_followers')
            ->statement(function () {
                return "IF NEW.profile_id=NEW.follower_id THEN 
                SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'follower_id cant be same as profile_id.';
              END IF;";
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
        Schema::dropIfExists('profiles_followers.profile_cant_follow_itself');
    }
}
