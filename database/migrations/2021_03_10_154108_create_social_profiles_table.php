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
            $table->uuid(SocialProfile::PKEY)->index()->primary();
            $table->uuid(Account::FKEY);
            $table->foreign(Account::FKEY)
                ->references(Account::PKEY)
                ->on(Account::TABLE)
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
