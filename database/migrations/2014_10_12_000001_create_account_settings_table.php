<?php

use App\Models\Account;
use App\Models\AccountSettings;
use Database\Seeders\MigrationHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(AccountSettings::TABLE, function (Blueprint $table) {
            $table->id();
            MigrationHelper::addForeign($table, new Account);
            $table->json('data');
            MigrationHelper::addTimeStamps($table, new AccountSettings());
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(AccountSettings::TABLE);
    }
}
