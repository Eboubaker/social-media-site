<?php

use App\Models\Account;
use App\Models\AccountNotification;
use Database\Seeders\MigrationHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAccountNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(AccountNotification::TABLE, function (Blueprint $table) {
            $table->id();
            MigrationHelper::addForeign($table, new Account);
            $table->json('content');
            $table->tinyInteger('type');
            $table->string('event_url');
            MigrationHelper::addTimeStamps($table, new AccountNotification);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(AccountNotification::TABLE);
    }
}
