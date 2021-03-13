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
            $table->uuid(BusinessProfile::PKEY)->index()->primary();
            $table->uuid(Account::FKEY);
            $table->foreign(Account::FKEY)
                ->references(Account::PKEY)
                ->on(Account::TABLE)
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
