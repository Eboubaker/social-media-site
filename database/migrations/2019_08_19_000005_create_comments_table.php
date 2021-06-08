<?php

use App\Models\Comment;
use App\Models\Morphs\Profileable;
use App\Models\Post;
use App\Models\Profile;
use Database\Seeders\MigrationHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Comment::tablename(), function (Blueprint $table) {
            $table->id();
            $table->string('uuid62')->index('comments_by_uuid62');
            $table->foreignId('commentor_id')->constained(Profile::tablename());
            $table->morphs('commentable');
            $table->text('body')->nullable();
            MigrationHelper::addTimeStamps($table, Comment::class);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Comment::tablename());
    }
}
