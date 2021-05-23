<?php

use App\Models\Post;
use App\Models\PostView;
use App\Models\Profile;
use App\Models\User;
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
            $table->foreignId('viewer_id')->references('id')->on(Profile::tablename())->constrained();
            $table->foreignIdFor(Post::class)->constrained();
            $table->timestamp('seen_at');
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
