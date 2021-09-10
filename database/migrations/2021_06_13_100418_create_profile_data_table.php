<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained('profiles')->cascadeOnDelete();
            $table->string('website_url')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profile_data');
    }
}
