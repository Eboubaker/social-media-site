<?php

use App\Models\User;
use Database\Seeders\MigrationHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeenPostablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seen_postables', function (Blueprint $table) {
            MigrationHelper::addForeign($table, new User);
            $table->morphs('postable');
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
        Schema::dropIfExists('seen_postables');
    }
}
