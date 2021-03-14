<?php

use App\Models\Account;
use App\Models\AccountNotification;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAccountNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(AccountNotification::TABLE, function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id');
            $table->foreign('account_id')
                ->references('id')
                ->on('accounts')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->json('content');
            $table->tinyInteger('type');
            $table->string('event_url');
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
        Schema::dropIfExists(AccountNotification::TABLE);
    }
}
