<?php

use App\Models\User;
use App\Models\UserSettings;
use Database\Seeders\MigrationHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(UserSettings::TABLE, function (Blueprint $table) {
            $table->id();
            MigrationHelper::addForeign($table, new User);
            $table->json('data');
            MigrationHelper::addTimeStamps($table, new UserSettings());
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(UserSettings::TABLE);
    }
}
