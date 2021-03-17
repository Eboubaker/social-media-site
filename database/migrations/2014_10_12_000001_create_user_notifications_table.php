<?php

use App\Models\User;
use App\Models\UserNotification;
use Database\Seeders\MigrationHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUserNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(UserNotification::TABLE, function (Blueprint $table) {
            $table->id();
            MigrationHelper::addForeign($table, new User);
            $table->json('content');
            $table->tinyInteger('type');
            $table->string('event_url');
            MigrationHelper::addTimeStamps($table, new UserNotification);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(UserNotification::TABLE);
    }
}
