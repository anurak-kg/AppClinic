<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableInventory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_transaction',function (Blueprint $table){
            $table->increments('inv_id');
            $table->string('product_id');//รหัสสินค้า
            $table->integer('treatment_id')->unsigned()->nullable();//รหัสการรักษา
            $table->integer('sales_id')->unsigned()->nullable();//รหัสที่ขาย
            $table->integer('received_id')->unsigned()->nullable();//สินค้าที่ได้รับมาจากร้านยา
            $table->integer('return_id')->unsigned()->nullable();//คืนสินค้าที่ได้รับมาจากร้านยา
            $table->integer('branch_id')->unsigned()->nullable();
            $table->integer('qty');//จำนวนยาที่ใช้
            $table->date('expiry_date');//วันหมดอายุ
            $table->string('type');//รายละเอียด
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('inventory_transaction');
    }
}
