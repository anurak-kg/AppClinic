<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpgrateV212ToV211 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("ALTER TABLE `return` ADD COLUMN `return_type`  enum('request','return') NULL AFTER `updated_at`,
                                             ADD COLUMN `warehouse_id`  int(11) NULL AFTER `return_type`");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("ALTER TABLE `return` DROP COLUMN `return_type`,DROP COLUMN `warehouse_id`");
    }
}
