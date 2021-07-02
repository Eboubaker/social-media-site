<?php

use Illuminate\Database\Migrations\Migration;
use App\DataBase\Trigger\TriggerFacade as Schema;

class CreateAfterVideoRemovedTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('after_video_removed')
            ->on('videos')
            ->statement(function () {
                $sql = <<<SQL
                    insert into `jobs` (`queue`,`payload`,`attempts`,`available_at`,`created_at`) VALUES ('default', CONCAT('{"uuid":"',UUID(),'","displayName":"App\\\\\\\\Listeners\\\\\\\\StorableRemovedListener","job":"Illuminate\\\\\\\\Queue\\\\\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\\\\\Events\\\\\\\\CallQueuedListener","command":\"O:36:\\\\"Illuminate\\\\\\\\Events\\\\\\\\CallQueuedListener\\\\":19:{s:5:\\\\"class\\\\";s:37:\\\\"App\\\\\\\\Listeners\\\\\\\\StorableRemovedListener\\\\";s:6:\\\\"method\\\\";s:6:\\\\"handle\\\\";s:4:\\\\"data\\\\";a:3:{i:0;i:',OLD.id,';i:1;s:5:\\\\"Video\\\\";i:2;s:',length(OLD.extension),':\\\\"',OLD.extension,'\\\\";}s:5:\\\\"tries\\\\";N;s:13:\\\\"maxExceptions\\\\";N;s:7:\\\\"backoff\\\\";N;s:10:\\\\"retryUntil\\\\";N;s:7:\\\\"timeout\\\\";N;s:17:\\\\"shouldBeEncrypted\\\\";b:0;s:3:\\\\"job\\\\";N;s:10:\\\\"connection\\\\";N;s:5:\\\\"queue\\\\";N;s:15:\\\\"chainConnection\\\\";N;s:10:\\\\"chainQueue\\\\";N;s:19:\\\\"chainCatchCallbacks\\\\";N;s:5:\\\\"delay\\\\";N;s:11:\\\\"afterCommit\\\\";N;s:10:\\\\"middleware\\\\";a:0:{}s:7:\\\\"chained\\\\";a:0:{}}"}}'),0, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
                SQL;
                return $sql;
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
        Schema::dropIfExists('videos.after_video_removed');
    }
}
