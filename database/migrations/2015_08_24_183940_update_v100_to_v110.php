<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateV100ToV110 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //DB::unprepared("ALTER TABLE `quotations` MODIFY COLUMN `quo_id`  int(10) UNSIGNED NOT NULL FIRST ;");
        //DB::unprepared("ALTER TABLE `quotations_detail` MODIFY COLUMN `quo_de_id`  int(10) UNSIGNED NOT NULL FIRST ;");
        ///DB::unprepared("ALTER TABLE `customer` MODIFY COLUMN `cus_id`  int(10) UNSIGNED NOT NULL FIRST ;");
        //DB::unprepared("ALTER TABLE `sales` MODIFY COLUMN `sales_id`  int(10) UNSIGNED NOT NULL FIRST ;");
        //DB::unprepared("ALTER TABLE `order` MODIFY COLUMN `order_id`  int(10) UNSIGNED NOT NULL FIRST ;");

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
