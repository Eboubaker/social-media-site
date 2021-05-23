<?php

use App\Models\Community;
use App\Models\CommunityRole;
use App\Models\Profile;
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
            $table->foreignId('author_id')->references('id')->on(Profile::tablename())->constrained();
            $table->string('name')->unique('communities_unique_name');
            $table->foreignId('default_role_id')
                  ->nullable()
                  ->default(CommunityRole::DEFAULT_ROLE_ID)
                  ->constrained(CommunityRole::tablename());
            $table->unsignedBigInteger('joined_members_count')->nullable()->default(0);
            $table->softDeletes();
            $table->timestamp('created_at');
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
        Schema::dropIfExists(Community::tablename());
    }
}
