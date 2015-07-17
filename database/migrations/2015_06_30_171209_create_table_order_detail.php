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
            $table->increments('order_id');
            $table->integer('product_id');
            $table->integer('order_de_qty_buy');
            $table->integer('order_de_qty_rev');
            $table->integer('order_de_qty_return');
            $table->string('order_de_text',50);
            $table->integer('order_de_price');
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
        Schema::drop('order_detail');
    }
}
