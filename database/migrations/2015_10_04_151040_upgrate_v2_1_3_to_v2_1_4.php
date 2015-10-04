<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpgrateV213ToV214 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("ALTER TABLE `payment_detail` DROP COLUMN `payment_status`, DROP COLUMN `bill_number`");
        DB::unprepared("ALTER TABLE `payment` DROP COLUMN `bill_number` ");



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
