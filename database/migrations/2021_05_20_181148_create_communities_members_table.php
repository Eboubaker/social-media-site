<?php

use App\Models\Community;
use App\Models\CommunityRole;
use App\Models\Profile;
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
            $table->foreignId('member_id')->constrained(Profile::tablename())->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId(Community::getForegin())->constrained(Community::tablename())->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('role_id')->nullable()->default(CommunityRole::DEFAULT_ROLE_ID)->constrained(CommunityRole::tablename());

            $table->unique(['member_id', Community::getForegin()], 'unique_composite_of_community_member');
            $table->softDeletes();
            $table->timestamp('joined_at')->nullable();
            $table->timestamp('updated_at')->nullable();
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
