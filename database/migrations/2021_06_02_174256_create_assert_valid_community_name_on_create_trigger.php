<?php

use Illuminate\Database\Migrations\Migration;
use App\DataBase\Trigger\TriggerFacade as Schema;

class CreateAssertValidCommunityNameOnCreateTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assert_valid_community_name_on_create_trigger')
            ->on('communities')
            ->statement(function () {
                return "IF NEW.name not REGEXP '^[A-Za-z0-9\-]{2,}$' then SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = ' community name is not valid.';end if;";
            })
            ->before()
            ->insert();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('communities.assert_valid_community_name_on_create_trigger');
    }
}
