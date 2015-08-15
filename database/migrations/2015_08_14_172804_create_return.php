<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReturn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return', function (Blueprint $table) {
            $table->increments('return_id');
            $table->integer('ven_id');
            $table->integer('receive_id');
            $table->integer('emp_id');
            $table->integer('order_id');
            $table->date('return_date');
            $table->enum('return_status', array('RECEIVE','RETURN'));
            $table->decimal('return_total',10,2);
            $table->text('return_comment');
            $table->integer('branch_id')->nullable();

            $table->timestamps();
        });
        Schema::create('return_detail', function (Blueprint $table) {
            $table->integer('return_id')->unsigned();
            $table->string('product_id');
            $table->integer('return_de_qty');//รับสินค้า
            $table->string('return_de_text');//เหตุผลที่คืน
            $table->integer('return_de_discount'); //ส่วนลดเปอเซ็น
            $table->decimal('return_de_disamount',10,2); //ส่วนลดจำนวนเงิน
            $table->decimal('return_de_price',10,2);
            $table->date('product_exp');//วันหมดอายุ
            /* $table->decimal('receive_de_price',10,2);
             $table->decimal('receive_de_discount',10,2);
             $table->decimal('receive_de_disamount',10,2);
             $table->decimal('receive_de_total',10,2);*/
            $table->timestamps();
            $table->primary(['return_id','product_id']);

            $table->foreign('return_id')
                ->references('return_id')->on('return')
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
        Schema::drop('return_detail');
        Schema::drop('return');
    }
}
