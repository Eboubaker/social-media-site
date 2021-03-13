<?php

use App\Models\Comment;
use App\Models\Morphs\Commentable;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCommentablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Commentable::TABLE, function (Blueprint $table) {
            $table->uuid(Comment::FKEY);
            $table->uuidMorphs(Commentable::$morphRelationName);
            if(Commentable::CREATED_AT)
            {
                $table->timestamp(Commentable::CREATED_AT)->default(DB::raw('CURRENT_TIMESTAMP'));
            }
            if(Commentable::UPDATED_AT)
            {
                $table->timestamp(Commentable::UPDATED_AT)->default(DB::raw('CURRENT_TIMESTAMP'));
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
        Schema::dropIfExists(Commentable::TABLE);
    }
}
