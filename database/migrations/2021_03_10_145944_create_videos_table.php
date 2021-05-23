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
        Schema::create(Video::tablename(), function (Blueprint $table) {
            $table->id();
            $table->morphs('videoable');
            $table->char('sha256', 64)->index('videos_by_sha256');

            $table->tinyInteger('type', unsigned:true);
            $table->smallInteger('width', unsigned:true);
            $table->smallInteger('height', unsigned:true);
            $table->mediumInteger('seconds', unsigned:true);
            $table->unsignedBigInteger('size');
            $table->string('origin_name')->nullable();
            $table->string('extension', 4);
            $table->float('sfw_score', total:2, places:1, unsigned:true)->nullable()->default(.5);
            $table->softDeletes();
            $table->timestamps();
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
        Schema::dropIfExists(Video::tablename());
    }
}
