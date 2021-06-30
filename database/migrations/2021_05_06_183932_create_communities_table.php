<?php

use App\Models\Community;
use App\Models\CommunityRole;
use App\Models\Profile;
use Database\Seeders\MigrationHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Community::tablename(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained(Profile::tablename());
            $table->string('name')->unique('communities_unique_name');
            $table->string('description');
            $table->foreignId('category_id')->nullable()->constrained('categories');
            $table->boolean('is_private')->nullable()->default(false);
            $table->foreignId('visitor_role_id')
                  ->nullable()
                  ->default(CommunityRole::VISITOR_DEFAULT_ROLE_ID)
                  ->constrained(CommunityRole::tablename());
            $table->foreignId('member_default_role_id')
                  ->nullable()
                  ->default(CommunityRole::MEMBER_DEFAULT_ROLE_ID)
                  ->constrained(CommunityRole::tablename());
            $table->unsignedBigInteger('members_count')->nullable()->default(0);
            MigrationHelper::addTimeStamps($table, Community::class);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Community::tablename());
    }
}
