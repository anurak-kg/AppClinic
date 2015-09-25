<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpgrateV122ToV200 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("ALTER TABLE `quotations_detail`  ADD COLUMN `product_id` varchar(255) NULL AFTER `course_id`,
                                                         ADD COLUMN `product_qty` int NULL AFTER `payment_remain`");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("ALTER TABLE `quotations_detail`   DROP COLUMN `product_id`");
        DB::unprepared("ALTER TABLE `quotations_detail`   DROP COLUMN `product_qty`");
    }
}
