<?php

use App\Models\User;
use App\Models\UserSettings;
use App\Models\ProfileImage;
use Database\Seeders\MigrationHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(User::TABLE, function (Blueprint $table) {
            $table->id();

            $table->string('email')->index()->nullable()->unique();
            $table->string('phone')->index()->nullable()->unique();

            $table->timestamp('phone_verified_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();

            $table->string('password');
            $table->string('api_token')->unique()->nullable()->default(null);

            $table->unsignedBigInteger('used_profileable_id')->nullable()->default(null);
            $table->string('active_profileable_type')->nullable()->default(null);

            $table->rememberToken();
            MigrationHelper::addTimeStamps($table, new User);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(User::TABLE);
    }
}
