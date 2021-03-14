<?php

use App\Models\Comment;
use App\Models\Morphs\Postable;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePostablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Postable::TABLE, function (Blueprint $table) {
            $table->uuid('comment_id')->index();
            $table->uuidMorphs(Postable::$morphRelationName);
            if(Postable::CREATED_AT)
            {
                $table->timestamp(Postable::CREATED_AT)->default(DB::raw('CURRENT_TIMESTAMP'));
            }
            if(Postable::UPDATED_AT)
            {
                $table->timestamp(Postable::UPDATED_AT)->default(DB::raw('CURRENT_TIMESTAMP'));
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
        Schema::dropIfExists(Postable::TABLE);
    }
}
