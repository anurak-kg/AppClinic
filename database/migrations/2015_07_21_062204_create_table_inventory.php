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
        Schema::create('inventory',function (Blueprint $table){
            $table->increments('inv_id');
            $table->string('product_id');//รหัสสินค้า
            $table->integer('tre_id');//รหัสการรักษา
            $table->integer('order_id');//รหัสใบสั่งซื้อสินค้าจากร้านขายยา
            $table->integer('order_de_qty_rev');//สินค้าที่ได้รับมาจากร้านยา
            $table->integer('product_de_qty');//จำนวนยาที่ใช้
            $table->integer('product_balance');//สินค้าคงเหลือในสต๊อก
        });
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
