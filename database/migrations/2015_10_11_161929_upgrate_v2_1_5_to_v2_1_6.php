<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpgrateV215ToV216 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("ALTER TABLE `treat_history` DROP COLUMN `course_id`,
                        CHANGE COLUMN `quo_id` `quo_de_id`  int(11) NOT NULL AFTER `treat_id`");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
