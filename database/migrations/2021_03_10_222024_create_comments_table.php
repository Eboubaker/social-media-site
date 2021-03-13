<?php

use App\Models\Comment;
use App\Models\Morphs\Commentable;
use App\Models\Morphs\Profileable;
use App\Models\Post;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Comment::TABLE, function (Blueprint $table) {
            $table->uuid(Comment::PKEY)->index()->primary();
            // foreign key for either a social account or a business account
            $table->json('content');
            $table->uuidMorphs(Profileable::$morphRelationName);
            if(Comment::CREATED_AT)
            {
                $table->timestamp(Comment::CREATED_AT)->default(DB::raw('CURRENT_TIMESTAMP'));
            }
            if(Comment::UPDATED_AT)
            {
                $table->timestamp(Comment::UPDATED_AT)->default(DB::raw('CURRENT_TIMESTAMP'));
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
        Schema::dropIfExists(Comment::TABLE);
    }
}
