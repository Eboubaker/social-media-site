<?php

use App\Models\Image;
use App\Models\Morphs\Postable;
use Database\Seeders\MigrationHelper;
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
            $table->id();
            $table->char('sha256', 64)->index('images_by_sha256');
            $table->string('storage_id', 36)->index('images_by_storage_id');
            $table->tinyInteger('type');
            $table->morphs('postable');
            $table->json('meta');
            MigrationHelper::addTimeStamps($table, new Image());
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
