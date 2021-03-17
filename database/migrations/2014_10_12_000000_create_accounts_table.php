<?php

use App\Models\Account;
use App\Models\AccountSettings;
use App\Models\ProfileImage;
use Database\Seeders\MigrationHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Account::TABLE, function (Blueprint $table) {
            $table->id();

            $table->string('first_name');
            $table->string('last_name');

            $table->string('email')->index()->nullable()->unique();
            $table->string('phone')->index()->nullable()->unique();

            $table->timestamp('phone_verified_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('api_token');
            // this is a foreign key it may reference work_accounts or social_accounts
            // depending on the chosen account by the user
            $table->unsignedBigInteger('used_account')->nullable();
            $table->rememberToken();
            MigrationHelper::addTimeStamps($table, new Account);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Account::TABLE);
    }
}
