<?php

use App\Models\Account;
use App\Models\ProfileImage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProfileImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ProfileImage::TABLE, function (Blueprint $table) {
            // sha256 hash (64 bytes)
            $table->uuid(ProfileImage::PKEY)->primary();
            $table->uuid(Account::FKEY);
            $table->foreign(Account::FKEY)
                ->references(Account::PKEY)
                ->on(Account::TABLE)
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            // we will use the uuid as the name part of the image path
            $table->char('sha256', 64)->index();
            $table->tinyInteger('type');
            // we will store all the meta data of the image here (height, width, quality ...)
            $table->json('meta');

            if(ProfileImage::CREATED_AT)
            {
                $table->timestamp(ProfileImage::CREATED_AT)->default(DB::raw('CURRENT_TIMESTAMP'));
            }
            if(ProfileImage::UPDATED_AT)
            {
                $table->timestamp(ProfileImage::UPDATED_AT)->default(DB::raw('CURRENT_TIMESTAMP'));
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
            ProfileImage::all()->each(function($model){
                $model->delete();
            });
        });
        Schema::dropIfExists(ProfileImage::TABLE);
    }
}
