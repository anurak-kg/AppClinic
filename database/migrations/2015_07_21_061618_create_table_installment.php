<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableInstallment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installment', function (Blueprint $table) {
            $table->increments('ins_id');
            $table->integer('ins_price');//จำนวนจ่าย
            $table->integer('ins_balance');//คงเหลือ
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('installment');
    }
}
