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
            $table->integer('order_id');
            $table->string('product_id');
            $table->integer('order_de_qty_buy');
            $table->decimal('order_de_price',6,2);
            $table->integer('order_de_discount');
            $table->decimal('order_de_disamount',6,2);
            $table->timestamps();
            $table->primary(['order_id','product_id']);
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
