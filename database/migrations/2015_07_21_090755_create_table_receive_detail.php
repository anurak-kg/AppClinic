<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableReceiveDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receive_detail', function (Blueprint $table) {
            $table->integer('receive_id');
            $table->string('product_id');
            $table->integer('receive_de_qty');//รับสินค้า
            $table->integer('receive_de_qty_return');//คืนสินค้า
            $table->string('receive_de_text');//เหตุผลที่คืน
            $table->decimal('receive_de_price',6,2);
            $table->integer('receive_de_discount');
            $table->decimal('receive_de_disamount',6,2);
            $table->timestamps();
            $table->primary(['receive_id','product_id']);
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
    }
}
