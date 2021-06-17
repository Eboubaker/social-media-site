<?php

use App\Models\Post;
use App\Models\PostView;
use App\Models\Profile;
use Database\Seeders\MigrationHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(PostView::tablename(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('viewer_id')->constrained(Profile::tablename())->cascadeOnDelete();
            $table->foreignId('post_id')->constrained(Post::tablename())->cascadeOnDelete();
            $table->smallInteger('viewed_count', unsigned:true)->nullable()->default(1);
            $table->unique(['viewer_id', 'post_id']);
            MigrationHelper::addTimeStamps($table, PostView::class);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(PostView::tablename());
    }
}
