<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpgrateV113ToV121 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill', function (Blueprint $table) {
            $table->increments('bill_id');
            $table->date('bill_date');
            $table->integer('emp_id');
            $table->integer('branch_id');
            $table->decimal('total',10,2);
            $table->enum('bill_type', array('POS','COURSE'));
            $table->timestamps();
        });
        Schema::create('bill_detail', function (Blueprint $table) {
            $table->increments('bill_de_id');
            $table->integer('bill_id')->unsigned();
            $table->integer('payment_de_id');
            // $table->decimal('cash',10,2); //จำนวนเงินที่ลุกค้าจ่าย
          //  $table->decimal('change',10,2); //เงินทอน
            $table->timestamps();
            $table->foreign('bill_id')
                ->references('bill_id')->on('bill')
                ->onDelete('cascade');
            $table->unique(['payment_de_id']);
        });
        DB::unprepared("ALTER TABLE `payment_detail`  ADD COLUMN `cash`  decimal(12,2) NULL AFTER `updated_at`;");
        DB::unprepared("ALTER TABLE `payment_detail`  ADD COLUMN `change`  decimal(12,2) NULL AFTER `cash`;");
        DB::unprepared("ALTER TABLE `payment_detail`
                        ADD COLUMN `id_account`  varchar(255) NOT NULL AFTER `change`,
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
        Schema::drop('bill_detail');
        Schema::drop('bill');

        DB::unprepared("ALTER TABLE `payment_detail`    DROP COLUMN `cash`");
        DB::unprepared("ALTER TABLE `payment_detail`    DROP COLUMN `change`");
        DB::unprepared("ALTER TABLE `payment_detail`
                        DROP COLUMN `id_account`,
                        DROP COLUMN `transfer_day`,
                        DROP COLUMN `transfer_day`,
                        DROP COLUMN `transfer_day`");
    }
}
