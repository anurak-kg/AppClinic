<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOrderDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_detail', function (Blueprint $table) {
            $table->string('order_id',4);
            $table->string('product_id',4);
            $table->integer('order_de_qty_buy');
            $table->integer('order_de_qty_rev');
            $table->integer('order_de_qty_return');
            $table->string('order_de_text',50);
            $table->integer('order_de_price');
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
    }
}
