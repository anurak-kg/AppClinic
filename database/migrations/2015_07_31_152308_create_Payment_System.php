<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentSystem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->increments('payment_id');
            $table->integer('quo_de_id');
            $table->integer('sales_id');
            $table->integer('cus_id');
            $table->enum('payment_type', array('PAID_IN_FULL', 'PAYABLE','PAY_BY_COURSE'));
            //PAID_IN_FULL เต็มจำนวน  //  PAYABLE ผ่านจ่าย // PAY_BY_COURSE  แบ่งจ่ายตามจำนวนครั้ง
            $table->enum('payment_status', array('REMAIN', 'FULLY_PAID'));//REMAIN ค้างจ่าย fully Paid จ่ายครบ
            $table->timestamps();
        });
        Schema::create('payment_detail', function (Blueprint $table) {
            $table->increments('payment_de_id');
            $table->integer('payment_id')->unsigned();
            $table->integer('bank_id');
            $table->integer('emp_id');
            $table->integer('branch_id');
            $table->enum('payment_type', array('CASH', 'DEBIT', 'CREDIT'));
            $table->string('card_id');//เลขที่บัตรเครดิต
            $table->string('edc_id');//เลขที่ edc
            $table->decimal('amount', 12, 2); //จำนวนเงินที่จ่าย
            $table->timestamps();

            $table->foreign('payment_id')
                ->references('payment_id')->on('payment')
                ->onDelete('cascade');
        });
        Schema::create('payment_bank', function (Blueprint $table) {
            $table->increments('bank_id');
            $table->integer('bank_name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('payment_detail');
        Schema::drop('payment');
        Schema::drop('payment_bank');

    }
}
