<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpgateV110ToV111 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("ALTER TABLE `order`  ADD COLUMN `bill_number`  int NULL AFTER `branch_id`;");


        DB::unprepared("ALTER TABLE `payment_detail`
                        MODIFY COLUMN `payment_type`  enum('CASH','DEBIT','Transfer','CREDIT')
                        CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER `branch_id`;

");

        DB::unprepared("ALTER TABLE `payment_detail`
                        ADD COLUMN `id_account`  varchar(255) NOT NULL AFTER `updated_at`,
                        ADD COLUMN `transfer_day`  date NOT NULL AFTER `id_account`,
                        ADD COLUMN `transfer_hour`  varchar(255) NOT NULL AFTER `transfer_day`,
                        ADD COLUMN `transfer_min`  varchar(255) NOT NULL AFTER `transfer_hour`;
                        ");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("ALTER TABLE `order`   DROP COLUMN `bill_number`");

    }
}
