<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpgrateV112ToV113 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("ALTER TABLE `payment_detail`  ADD COLUMN `bill_number`  int NULL AFTER `vat_amount`");
        DB::unprepared("ALTER TABLE `quotations` DROP COLUMN `bill_number`;");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("ALTER TABLE `payment_detail`  DROP COLUMN `bill_number`");

    }
}
