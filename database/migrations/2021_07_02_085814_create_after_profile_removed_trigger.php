<?php

use Illuminate\Database\Migrations\Migration;
use App\DataBase\Trigger\TriggerFacade as Schema;

class CreateAfterProfileRemovedTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('after_profile_removed')
            ->on('profiles')
            ->statement(function () {
                return "
                    DELETE FROM images where `imageable_type`='App\\\\Models\\\\Profile' and `imageable_id`=OLD.id;
                    DELETE FROM videos where `videoable_type`='App\\\\Models\\\\Profile' and `videoable_id`=OLD.id;
                    DELETE FROM notifications where `notifiable_type`='App\\\\Models\\\\Profile' and `notifiable_id`=OLD.id;
                ";
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
        Schema::dropIfExists('profiles.after_user_removed');
    }
}
