<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpgrateV210ToV211 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("ALTER TABLE `payment_detail`
                          DROP COLUMN `payment_de_id`,
                          DROP COLUMN `bank_id`,
                          DROP COLUMN `emp_id`,
                          DROP COLUMN `branch_id`,
                          DROP COLUMN `card_id`,
                          DROP COLUMN `edc_id`,
                          DROP COLUMN `cash`,
                          DROP COLUMN `change`,
                          DROP COLUMN `id_account`,
                          MODIFY COLUMN `payment_type`  enum('PAY_BY_COURSE','PAYABLE','PAID_IN_FULL') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER `payment_id`,
                          ADD COLUMN `quo_de_id`  int(10) NOT NULL AFTER `payment_id`,
                          DROP PRIMARY KEY,
                          ADD PRIMARY KEY (`payment_id`, `quo_de_id`),
                          ADD COLUMN `payment_status`  enum('FULLY_PAID','REMAIN') NULL AFTER `payment_type`;");
        DB::unprepared("ALTER TABLE `payment`
                        DROP COLUMN `quo_de_id`,
                        DROP COLUMN `sales_id`,
                        DROP COLUMN `payment_status`,
                        MODIFY COLUMN `payment_type`  enum('CREDIT','DEBIT','TRANSFER','CASH') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER `cus_id`,
                        ADD COLUMN `emp_id`  int(11) NOT NULL AFTER `cus_id`,
                        ADD COLUMN `branch_id`  int(11) NULL AFTER `emp_id`,
                        ADD COLUMN `bank_id`  int(11) NULL AFTER `branch_id`,
                        ADD COLUMN `amount`  decimal(12,2) NOT NULL AFTER `payment_type`,
                        ADD COLUMN `vat_amount`  decimal(12,2) NULL AFTER `amount`,
                        ADD COLUMN `change`  decimal(12,2) NULL AFTER `vat_amount`,
                        ADD COLUMN `card_id`  varchar(255) NULL AFTER `change`,
                        ADD COLUMN `edc_id`  varchar(255) NULL AFTER `card_id`,
                        ADD COLUMN `id_account`  varchar(255) NULL AFTER `edc_id`,
                        ADD COLUMN `bill_number`  int(11) NULL AFTER `id_account`;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("ALTER TABLE `payment_detail`   DROP COLUMN `payment_status`,DROP COLUMN `quo_de_id`");
        DB::unprepared("ALTER TABLE `payment`   DROP COLUMN `emp_id`,DROP COLUMN `branch_id`");
        DB::unprepared("ALTER TABLE `payment`   DROP COLUMN `bank_id`,DROP COLUMN `amount`");
        DB::unprepared("ALTER TABLE `payment`   DROP COLUMN `vat_amount`,DROP COLUMN `change`");
        DB::unprepared("ALTER TABLE `payment`   DROP COLUMN `card_id`,DROP COLUMN `edc_id`");
        DB::unprepared("ALTER TABLE `payment`   DROP COLUMN `id_account`,DROP COLUMN `bill_number`");
    }
}
