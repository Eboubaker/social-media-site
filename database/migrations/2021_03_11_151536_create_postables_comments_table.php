<?php

use App\Models\Comment;
use App\Models\Morphs\Postable;
use Database\Seeders\MigrationHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class  CreatePostablesCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('postables_comments', function (Blueprint $table) {
//            MigrationHelper::addForeign($table, new Comment());
//            $table->morphs('postable');
//            $table->timestamps();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('postables_comments');
    }
}
