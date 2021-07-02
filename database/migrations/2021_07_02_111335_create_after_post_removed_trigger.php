<?php

use Illuminate\Database\Migrations\Migration;
use App\DataBase\Trigger\TriggerFacade as Schema;

class CreateAfterPostRemovedTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('after_post_removed')
            ->on('posts')
            ->statement(function () {
                return "
                    DELETE FROM images where `imageable_type`='App\\\\Models\\\\Post' and `imageable_id`=OLD.id;
                    DELETE FROM videos where `videoable_type`='App\\\\Models\\\\Post' and `videoable_id`=OLD.id;
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
        Schema::dropIfExists('posts.after_post_removed');
    }
}
