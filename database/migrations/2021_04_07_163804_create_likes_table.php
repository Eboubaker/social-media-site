<?php

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\Profile;
use Database\Seeders\MigrationHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikesTable extends Migration
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
        Schema::create('likes', function (Blueprint $table) use(&$schema){
            $schema=$table;
            $table->id();
            $table->morphs('likeable');
            $table->foreignId('liker_id')->constrained(Profile::tablename())->cascadeOnDelete();

            $table->unique(['liker_id', 'likeable_id', 'likeable_type']);
            MigrationHelper::addTimeStamps($table, Like::class);
            $table->timestamp("deleted_at")->nullable();
        });
        $schema->cascadeMorphsWithTriggers([
            Post::class,
            Comment::class,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('likes');
    }
}
