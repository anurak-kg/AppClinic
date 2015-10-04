<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpgrateV214ToV215 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("ALTER TABLE `payment` ADD COLUMN `bill_id`  int(10) NOT NULL AFTER `updated_at`,
                        ADD COLUMN `bill_date`  datetime NULL AFTER `bill_id`");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("ALTER TABLE `payment` DROP COLUMN `bill_id`, DROP COLUMN `bill_date`");
    }
}
