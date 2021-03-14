<?php

use App\Models\Account;
use App\Models\BusinessProfile;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateBusinessProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(BusinessProfile::TABLE, function (Blueprint $table) {
            $table->uuid('id')->unique()->primary();
            $table->uuid('public_id')->unique();
            $table->foreignId('account_id');
            $table->foreign('account_id')
                ->references('id')
                ->on('accounts')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->json('data');
            if(BusinessProfile::CREATED_AT)
            {
                $table->timestamp(BusinessProfile::CREATED_AT)->default(DB::raw('CURRENT_TIMESTAMP'));
            }
            if(BusinessProfile::UPDATED_AT)
            {
                $table->timestamp(BusinessProfile::UPDATED_AT)->default(DB::raw('CURRENT_TIMESTAMP'));
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
        Schema::dropIfExists(BusinessProfile::TABLE);
    }
}
