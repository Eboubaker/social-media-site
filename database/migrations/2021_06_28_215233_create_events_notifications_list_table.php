<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsNotificationsListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events_notifications_list', function (Blueprint $table) {
            $table->id();
            $table->morphs('eventable', 'by_eventables');
            $table->foreignId('profile_id')->constrained('profiles')->cascadeOnDelete();
            $table->smallInteger('notification_level')->nullable()->default(0);
            $table->unique(['profile_id', 'eventable_id', 'eventable_type'], 'profile_evetable_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events_notifications_list');
    }
}
