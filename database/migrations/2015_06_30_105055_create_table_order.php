<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->increments('order_id');
            $table->integer('ven_id');
            $table->integer('emp_id');
            $table->date('order_date');
            $table->integer('order_total');
            //WAITING เลือกสินค้า PENDING กำลังจัดซื้อ CLOSE การจัดซื้อเสร้จสิ้น CANCEL ยกเลิกการสั่งซื้อ
            $table->enum('order_status', array('WAITING','PENDING', 'CLOSE','CANCEL'));
            $table->integer('branch_id')->nullable();

            $table->timestamps();

        });
        Schema::create('order_detail', function (Blueprint $table) {
            $table->integer('order_id')->unsigned();
            $table->string('product_id');
            $table->integer('order_de_qty');
            $table->decimal('order_de_price',10,2);
            $table->integer('order_de_discount'); //ส่วนลดเปอเซ็น
            $table->decimal('order_de_disamount',10,2); //ส่วนลดจำนวนเงิน
            $table->decimal('order_de_total',10,2); //จำนวนเงินการสั่งซื้อหลังเพิ่มภาษี
            $table->timestamps();
            $table->primary(['order_id','product_id']);

            $table->foreign('order_id')
                ->references('order_id')->on('order')
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
        Schema::drop('order_detail');
        Schema::drop('order');
    }
}
