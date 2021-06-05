<?php

use App\Models\Morphs\Profileable;
use App\Models\Post;
use App\Models\Profile;
use Database\Seeders\MigrationHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create(Post::tablename(), function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('body')->nullable();
            $table->morphs('pageable');
            $table->foreignId('author_id')->nullable()->constrained(Profile::tablename());
            $table->string('slug')->unique()->nullable();
            MigrationHelper::addTimeStamps($table, Post::class);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Post::tablename());
    }
}
