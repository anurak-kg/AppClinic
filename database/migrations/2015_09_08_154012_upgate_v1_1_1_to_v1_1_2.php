<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpgateV111ToV112 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("ALTER TABLE `quotations`  ADD COLUMN `sale1` varchar(255) NULL AFTER `sale_price1`,
                        ADD COLUMN `sale2` varchar(255) NULL AFTER `sale1`,
                        ADD COLUMN `sale3`  varchar(255) NULL AFTER `sale2`;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("ALTER TABLE `quotations`   DROP COLUMN `sale1` DROP COLUMN `sale2` DROP COLUMN `sale3`");
    }
}
