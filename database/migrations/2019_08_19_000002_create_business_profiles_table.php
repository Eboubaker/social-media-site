<?php

use App\Models\User;
use App\Models\BusinessProfile;
use Database\Seeders\MigrationHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateBusinessProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(BusinessProfile::TABLE, function (Blueprint $table) {
            $table->id();
            MigrationHelper::addForeign($table, new User);
            $table->json('data');
            MigrationHelper::addTimeStamps($table, new BusinessProfile());
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(BusinessProfile::TABLE);
    }
}
