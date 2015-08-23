<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableReceive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receive', function (Blueprint $table) {
            $table->increments('receive_id');
            $table->integer('ven_id');
            $table->integer('emp_id');
            $table->integer('order_id');
            $table->date('receive_date');
            $table->decimal('receive_total',10,2);
            $table->enum('receive_status', array('WAITING','CLOSE'));
            $table->text('receive_comment');
            //VAT
            $table->enum('vat', array('true','false'));
            $table->integer('vat_rate');//

            $table->integer('branch_id')->nullable();

            $table->timestamps();
        });
        Schema::create('receive_detail', function (Blueprint $table) {
            $table->integer('receive_id')->unsigned();
            $table->string('product_id');
            $table->integer('receive_de_qty');//รับสินค้า
            $table->integer('receive_de_discount'); //ส่วนลดเปอเซ็น
            $table->decimal('receive_de_disamount',10,2); //ส่วนลดจำนวนเงิน
            $table->decimal('receive_de_price',10,2);
            $table->date('product_exp');//วันหมดอายุ
           /* $table->decimal('receive_de_price',10,2);
            $table->decimal('receive_de_discount',10,2);
            $table->decimal('receive_de_disamount',10,2);
            $table->decimal('receive_de_total',10,2);*/
            $table->timestamps();
            $table->primary(['receive_id','product_id']);

            $table->foreign('receive_id')
                ->references('receive_id')->on('receive')
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
        Schema::drop('receive_detail');
        Schema::drop('receive');
    }
}
