<?php

use App\Models\Morphs\Postable;
use App\Models\Video;
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
            $table->uuid('id')->unique()->primary();
            $table->uuid('public_id')->unique();
            $table->char('sha256', 64)->index();
            $table->uuidMorphs(Postable::$morphRelationName);
            $table->tinyInteger('type');
            $table->json('meta');
            if(Video::CREATED_AT)
            {
                $table->timestamp(Video::CREATED_AT)->default(DB::raw('CURRENT_TIMESTAMP'));
            }
            if(Video::UPDATED_AT)
            {
                $table->timestamp(Video::UPDATED_AT)->default(DB::raw('CURRENT_TIMESTAMP'));
            }
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
