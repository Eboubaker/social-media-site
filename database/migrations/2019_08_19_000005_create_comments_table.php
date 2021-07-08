<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\Profile;
use Database\Seeders\MigrationHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        /** @var Blueprint $schema */
        $schema = null;
        Schema::create(Comment::tablename(), function (Blueprint $table) use(&$schema){
            $schema=$table;
            $table->id();
            $table->string('uuid62')->index('comments_by_uuid62');
            $table->foreignId('commentor_id');
            $table->foreignId('post_id');
            $table->morphs('commentable');
            $table->text('body')->nullable();
            MigrationHelper::addTimeStamps($table, Comment::class);

            $table->foreign('commentor_id')->references('id')->on('profiles');
            $table->foreign('post_id')->references('id')->on('posts');
        });
        $schema->cascadeForeignKeysWithTriggers('commentor_id', 'post_id');
        $schema->cascadeMorphsWithTriggers([
            'relation' => 'commentable',
            'models' => [
                Comment::class,
                Post::class,
            ]
        ]);
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
