<?php

use App\Models\User;
use App\Models\SocialProfile;
use Database\Seeders\MigrationHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSocialProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(SocialProfile::TABLE, function (Blueprint $table) {
            $table->id();
            MigrationHelper::addForeign($table, new User);
            $table->json('data');

            $table->string('first_name');
            $table->string('last_name');
            $table->date('birth_date');
            
            MigrationHelper::addTimeStamps($table, new SocialProfile());
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(SocialProfile::TABLE);
    }
}
