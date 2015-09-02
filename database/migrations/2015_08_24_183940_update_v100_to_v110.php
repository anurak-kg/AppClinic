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
        // เพิ่ม Stock
        DB::unprepared("ALTER TABLE `branch`  ADD COLUMN `branch_type`  enum('shop','warehouse') NULL DEFAULT 'shop' AFTER `branch_code`");
        DB::unprepared("INSERT INTO `branch` (`branch_id`, `branch_name`, `branch_type`) VALUES ('1', 'คลังสินค้าใหญ่', 'warehouse')");
        //Add warehouse to Order Receive
        DB::unprepared("ALTER TABLE `order` ADD COLUMN `warehouse_id`  int NULL AFTER `updated_at`;");
        DB::unprepared("ALTER TABLE `receive` ADD COLUMN `warehouse_id`  int NULL AFTER `updated_at`;");

        //ADD Order Type
        DB::unprepared("ALTER TABLE `order`  ADD COLUMN `order_type`  enum('order','request') NULL DEFAULT 'order' AFTER `warehouse_id`;");
        DB::unprepared("ALTER TABLE `receive`  ADD COLUMN `receive_type`  enum('order','request') NULL DEFAULT 'order' AFTER `warehouse_id`;");
        //Add bill_number
        DB::unprepared("ALTER TABLE `sales`  ADD COLUMN `bill_number`  int NULL AFTER `branch_id`;");

        //ลบค่า bt จาก treat history
        DB::unprepared("ALTER TABLE `treat_history` DROP COLUMN `dr_id`,DROP COLUMN `dr_price`,DROP COLUMN `bt_user_id1`,DROP COLUMN `bt1_price`,DROP COLUMN `bt_user_id2`,DROP COLUMN `bt2_price`;");

    }



    //DB::unprepared("ALTER TABLE `quotations` MODIFY COLUMN `quo_id`  int(10) UNSIGNED NOT NULL FIRST ;");
    //DB::unprepared("ALTER TABLE `quotations_detail` MODIFY COLUMN `quo_de_id`  int(10) UNSIGNED NOT NULL FIRST ;");
    ///DB::unprepared("ALTER TABLE `customer` MODIFY COLUMN `cus_id`  int(10) UNSIGNED NOT NULL FIRST ;");
    //DB::unprepared("ALTER TABLE `sales` MODIFY COLUMN `sales_id`  int(10) UNSIGNED NOT NULL FIRST ;");
    //DB::unprepared("ALTER TABLE `order` MODIFY COLUMN `order_id`  int(10) UNSIGNED NOT NULL FIRST ;");


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("
        ALTER TABLE `treat_history`
        ADD COLUMN `dr_id`  int(11) NULL AFTER `updated_at`;
        ADD COLUMN `dr_price`  int(11) NULL AFTER `updated_at`;
        ADD COLUMN `bt_user_id1`  int(11) NULL AFTER `updated_at`;
        ADD COLUMN `bt1_price`  int(11) NULL AFTER `updated_at`;
        ADD COLUMN `bt_user_id2`  int(11) NULL AFTER `updated_at`;
        ADD COLUMN `bt2_price`  int(11) NULL AFTER `updated_at`;");
        DB::unprepared("DELETE FROM `branch`    WHERE (`branch_id`='1')");
        DB::unprepared("ALTER TABLE `sales`   DROP COLUMN `bill_number`");
        DB::unprepared("ALTER TABLE `receive`   DROP COLUMN `receive_type`");
        DB::unprepared("ALTER TABLE `order`     DROP COLUMN `order_type`");
        DB::unprepared("ALTER TABLE `branch`    DROP COLUMN `branch_type`");
        DB::unprepared("ALTER TABLE `order`     DROP COLUMN `warehouse_id`");
        DB::unprepared("ALTER TABLE `receive`   DROP COLUMN `warehouse_id`");

    }
}
