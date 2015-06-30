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
            $table->date('order_date');
            $table->string('order_receive_id',4);
            $table->date('order_receive_date');
            $table->integer('order_total',10);
            $table->string('order_status',5);
            $table->integer('order_de_discount',3);
            $table->integer('order_de_disamount',10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('order');
    }
}
