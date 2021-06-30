<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsNotificationsListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts_notifications_list', function (Blueprint $table) {
            $table->id();
            $table->morphs('notifiable');
            $table->foreignId('profile_id')->constrained('profiles')->cascadeOnDelete();
            $table->smallInteger('notification_level')->nullable()->default(0);
            $table->unique(['profile_id', 'notifiable_id', 'notifiable_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts_notifications_list');
    }
}
