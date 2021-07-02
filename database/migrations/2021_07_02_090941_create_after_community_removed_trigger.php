<?php

use Illuminate\Database\Migrations\Migration;
use App\DataBase\Trigger\TriggerFacade as Schema;

class CreateAfterCommunityRemovedTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('after_community_removed')
            ->on('communities')
            ->statement(function () {
                return "
                    DELETE FROM images where `imageable_type`='App\\\\Models\\\\Community' and `imageable_id`=OLD.id;
                    DELETE FROM videos where `videoable_type`='App\\\\Models\\\\Community' and `videoable_id`=OLD.id;
                    DELETE FROM notifications where `notifiable_type`='App\\\\Models\\\\Community' and `notifiable_id`=OLD.id;
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
        Schema::dropIfExists('communities.after_community_removed');
    }
}
