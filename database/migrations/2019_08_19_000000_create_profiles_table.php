<?php

use App\Models\Image;
use App\Models\Profile;
use App\Models\User;
use App\Models\SocialProfile;
use Database\Seeders\MigrationHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** @var Blueprint $schema */
        $schema = null;
        Schema::create(Profile::tablename(), function (Blueprint $table) use(&$schema){
            $schema=$table;
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            // $table->json('data');
            $table->string('username')->unique();
            $table->boolean('active')->nullable()->default(false);
            MigrationHelper::addTimeStamps($table, Profile::class);
        });
        $schema->cascadeForeignKeysWithTriggers('user_id');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Profile::tablename());
    }
}
