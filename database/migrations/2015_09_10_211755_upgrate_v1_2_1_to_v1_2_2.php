<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpgrateV121ToV122 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("ALTER TABLE `bill`  ADD COLUMN `payment_id` int NULL AFTER `emp_id`,
                                            ADD COLUMN `cus_id` int NULL AFTER `payment_id`;");

        DB::unprepared("ALTER TABLE `payment_detail`
                        DROP COLUMN `transfer_hour`,
                        DROP COLUMN `transfer_min`,
                        CHANGE COLUMN `transfer_day` `transfer_date`  datetime NOT NULL AFTER `id_account`;
                        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("ALTER TABLE `bill`   DROP COLUMN `payment_id`,DROP COLUMN `cus_id`");
    }
}
