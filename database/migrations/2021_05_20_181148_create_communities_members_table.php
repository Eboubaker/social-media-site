<?php

use App\Models\Community;
use App\Models\CommunityMember;
use App\Models\CommunityRole;
use App\Models\Profile;
use Database\Seeders\MigrationHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunitiesMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('communities_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained(Profile::tablename())->cascadeOnDelete();
            $table->foreignId(Community::getForegin())->constrained(Community::tablename())->cascadeOnDelete();
            $table->foreignId('role_id')->constrained(CommunityRole::tablename());

            $table->unique(['profile_id', Community::getForegin()], 'unique_community_id_x_profile_id');
            MigrationHelper::addTimeStamps($table, CommunityMember::class);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('communities_members');
    }
}
