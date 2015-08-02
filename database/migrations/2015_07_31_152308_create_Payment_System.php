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
            $table->integer('quo_id');
            $table->integer('sales_id');
            $table->integer('cus_id');
            $table->enum('payment_status', array('PAID_IN_FULL','PAYABLE'));//PAID_IN_FULL เต็มจำนวน PAYABLE ผ่านจ่าย
            $table->timestamps();
        });
        Schema::create('payment_detail', function (Blueprint $table) {
            $table->integer('payment_id');
            $table->integer('quo_de_id');
            $table->integer('bank_id');
            $table->integer('emp_id');
            $table->integer('branch_id');
            $table->enum('payment_type', array('CASH','DEBIT','CREDIT'));
            $table->string('card_id');//เลขที่บัตรเครดิต
            $table->string('edc_id');//เลขที่ edc
            $table->decimal('amount',12,2); //จำนวนเงินที่จ่าย
            $table->timestamps();
            $table->primary(['payment_id','quo_de_id']);
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
