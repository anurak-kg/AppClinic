<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('sales_id');
            $table->integer('emp_id');
            $table->integer('cus_id');
            $table->date('sales_date');//วันที่ซื้อสินค้า
            $table->enum('sales_status', array('WAITING','CLOSE'));
            $table->decimal('sales_total',10,2);
            $table->integer('branch_id')->nullable();
            $table->timestamps();
        });
        Schema::create('sales_detail', function (Blueprint $table) {
            $table->integer('sales_id')->unsigned();
            $table->string('product_id');
            $table->integer('sales_de_qty');
            $table->decimal('sales_de_price',10,2);
            $table->decimal('sales_de_discount',10,2); //ส่วนลดเปอเซ็น
            $table->decimal('sales_de_disamount',10,2); //ส่วนลดจำนวนเงิน
            $table->decimal('sales_de_total',10,2); //จำนวนเงินการสั่งซื้อหลังเพิ่มภาษี
            $table->timestamps();
            $table->primary(['sales_id','product_id']);

            $table->foreign('sales_id')
                ->references('sales_id')->on('sales')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sales_detail');
        Schema::drop('sales');
    }
}
