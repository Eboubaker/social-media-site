<?php

use App\Models\Image;
use App\Models\Morphs\Postable;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class CreateImagesTable extends Migration
{

    public function up()
    {
        Schema::create(Image::TABLE, function (Blueprint $table) {
            $table->uuid('id')->unique()->primary();
            $table->uuid('public_id')->unique();
            $table->char('sha256', 64)->index();
            $table->uuidMorphs(Postable::$morphRelationName);
            $table->tinyInteger('type');
            $table->json('meta');
            if(Image::CREATED_AT)
            {
                $table->timestamp(Image::CREATED_AT)->default(DB::raw('CURRENT_TIMESTAMP'));
            }
            if(Image::UPDATED_AT)
            {
                $table->timestamp(Image::UPDATED_AT)->default(DB::raw('CURRENT_TIMESTAMP'));
            }
        });
    }

    public function down()
    {
        DB::transaction(function(){
            Image::all()->each(function($model){
                $model->delete();
            });
        });
        Schema::dropIfExists(Image::TABLE);
    }
}
