<?php

use App\Models\Account;
use App\Models\ProfileImage;
use Database\Seeders\MigrationHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

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
            $table->id();
            MigrationHelper::addForeign($table, new Account);
            $table->char('sha256', 64)->index();
            $table->tinyInteger('type');
            $table->json('meta');
            MigrationHelper::addTimeStamps($table, new ProfileImage());
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
