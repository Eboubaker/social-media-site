<?php

use Illuminate\Database\Migrations\Migration;
use App\DataBase\Trigger\TriggerFacade as Schema;

class CreateAfterCommentRemovedTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('after_comment_removed')
            ->on('comments')
            ->statement(function () {
                return "
                    DELETE FROM images where `imageable_type`='App\\\\Models\\\\Comment' and `imageable_id`=OLD.id;
                    DELETE FROM videos where `videoable_type`='App\\\\Models\\\\Comment' and `videoable_id`=OLD.id;
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
        Schema::dropIfExists('comments.after_comment_removed');
    }
}
