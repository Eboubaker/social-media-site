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
        Schema::create(Image::tablename(), function (Blueprint $table) {
            $table->id();
            $table->morphs('imageable');
            $table->string('purpose')->nullable()->index('images_by_purpose');
            $table->char('sha256', 64)->index('images_by_sha256');

            $table->tinyInteger('type', unsigned:true);
            $table->smallInteger('width', unsigned:true);
            $table->smallInteger('height', unsigned:true);
            $table->unsignedBigInteger('size');
            $table->string('origin_name')->nullable();
            $table->string('mime');
            $table->string('extension', 4);
            $table->float('sfw_score', total:2, places:1, unsigned:true)->nullable()->default(.5);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        DB::transaction(function(){
            Image::all()->each(function($model){
                $model->delete();
            });
        });
        Schema::dropIfExists(Image::tablename());
    }
}
