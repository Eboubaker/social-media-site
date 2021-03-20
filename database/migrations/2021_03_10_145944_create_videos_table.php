<?php

use App\Models\Morphs\Postable;
use App\Models\Video;
use Database\Seeders\MigrationHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Video::TABLE, function (Blueprint $table) {
            $table->id();
            $table->char('sha256', 64)->index('videos_by_sha256');
            $table->morphs('postable');
            $table->string('storage_id', 36)->index('videos_by_storage_id');
            $table->tinyInteger('type');
            $table->json('meta');
            MigrationHelper::addTimeStamps($table, new Video());
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::transaction(function(){
            Video::all()->each(function($model){
                $model->delete();
            });
        });
        Schema::dropIfExists(Video::TABLE);
    }
}
