<?php

use App\Models\Account;
use App\Models\AccountSettings;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(AccountSettings::TABLE, function (Blueprint $table) {
            $table->id(AccountSettings::PKEY);
            $table->uuid(Account::FKEY);
            $table->foreign(Account::FKEY)
                ->references(Account::PKEY)
                ->on(Account::TABLE)
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->json('data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(AccountSettings::TABLE);
    }
}
