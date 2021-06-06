<?php

use App\Models\Follow;
use App\Models\Profile;
use Database\Seeders\MigrationHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesFollowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles_followers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained(Profile::tablename())->cascadeOnDelete();
            $table->foreignId('follower_id')->constrained(Profile::tablename())->cascadeOnDelete();
            $table->unique(['profile_id', 'follower_id']);

            MigrationHelper::addTimeStamps($table, Follow::class);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles_followers');
    }
}
