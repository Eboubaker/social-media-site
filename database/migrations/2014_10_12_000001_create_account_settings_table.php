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
            $table->id();
            $table->foreignId('account_id');
            $table->foreign('account_id')
                ->references('id')
                ->on('accounts')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
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
