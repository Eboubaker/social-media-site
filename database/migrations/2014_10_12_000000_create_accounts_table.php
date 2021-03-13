<?php

use App\Models\Account;
use App\Models\AccountSettings;
use App\Models\ProfileImage;
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
            // this id should be hidden in the model, only the back-end server can see it
            $table->uuid(Account::PKEY)->primary();

            // we add a public id which can be shared by other users
            $table->string('public_id', Account::PUPLIC_ID_LEN)->unique();
            // we add a uuid which can be used to navigate between routes
            // (users don't have to see this but if managed to get it, they can't do any harm)


            $table->string('first_name');
            $table->string('last_name');

            $table->string('email')->nullable()->unique();
            $table->string('phone')->nullable()->unique();

            $table->timestamp('phone_verified_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // this is a foreign key it may reference work_accounts or social_accounts
            // depending on the chosen account by the user
            $table->uuid('used_account')->nullable();
            $table->rememberToken();
            if(Account::CREATED_AT)
            {
                $table->timestamp(Account::CREATED_AT)->default(DB::raw('CURRENT_TIMESTAMP'));
            }
            if(Account::UPDATED_AT)
            {
                $table->timestamp(Account::UPDATED_AT)->default(DB::raw('CURRENT_TIMESTAMP'));
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
        Schema::dropIfExists(Account::TABLE);
    }
}
