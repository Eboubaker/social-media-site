<?php

use App\Models\Account;
use App\Models\SocialProfile;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSocialProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(SocialProfile::TABLE, function (Blueprint $table) {
            $table->uuid('id')->unique()->primary();
            $table->uuid('public_id')->unique();
            $table->foreignId('account_id');
            $table->foreign('account_id')
                ->references('id')
                ->on('accounts')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->json('data');
            if(SocialProfile::CREATED_AT)
            {
                $table->timestamp(SocialProfile::CREATED_AT)->default(DB::raw('CURRENT_TIMESTAMP'));
            }
            if(SocialProfile::UPDATED_AT)
            {
                $table->timestamp(SocialProfile::UPDATED_AT)->default(DB::raw('CURRENT_TIMESTAMP'));
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
        Schema::dropIfExists(SocialProfile::TABLE);
    }
}
