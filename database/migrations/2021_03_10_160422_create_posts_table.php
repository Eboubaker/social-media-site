<?php

use App\Models\Morphs\Profileable;
use App\Models\Post;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Post::TABLE, function (Blueprint $table) {
            $table->uuid(Post::PKEY)->primary();
            // foreign key for either a social account or a business account
            $table->json('content');
            $table->uuidMorphs(Profileable::$morphRelationName);
            if(Post::CREATED_AT)
            {
                $table->timestamp(Post::CREATED_AT)->default(DB::raw('CURRENT_TIMESTAMP'));
            }
            if(Post::UPDATED_AT)
            {
                $table->timestamp(Post::UPDATED_AT)->default(DB::raw('CURRENT_TIMESTAMP'));
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
        Schema::dropIfExists(Post::TABLE);
    }
}
