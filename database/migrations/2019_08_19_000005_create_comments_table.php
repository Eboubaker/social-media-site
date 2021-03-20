<?php

use App\Models\Comment;
use App\Models\Morphs\Profileable;
use App\Models\Post;
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
        Schema::create(Comment::TABLE, function (Blueprint $table) {
            $table->id();
            $table->json('content');
            $table->morphs('profileable');
            MigrationHelper::addTimeStamps($table, new Comment());
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Comment::TABLE);
    }
}
