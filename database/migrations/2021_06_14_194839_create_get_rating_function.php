<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGetRatingFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
    DROP FUNCTION IF EXISTS sms.get_rating;
    CREATE FUNCTION sms.get_rating (comments_count BIGINT ,likes_count BIGINT, views_count BIGINT)
    RETURNS DOUBLE
    READS SQL DATA
    DETERMINISTIC
    BEGIN
    DECLARE rating BIGINT;
    SET @comment_worth = 1;
    SET @like_worth    = 1;
    SET @view_worth    = 1;
    IF views_count = 0 THEN
        RETURN 0;
    END IF;
    SET rating = (@comment_worth*comments_count + @like_worth*likes_count)/(views_count/@view_worth);
    RETURN rating;
    END;
");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP FUNCTION IF EXISTS sms.get_rating");
    }
}
