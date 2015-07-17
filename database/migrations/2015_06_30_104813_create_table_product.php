<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->increments('product_id');
            $table->string('pg_id',4);
            $table->string('product_name',30);
            $table->integer('product_qty');
            $table->integer('product_qty_order');
            $table->date('product_date_start');
            $table->date('product_date_end');
            $table->integer('product_price');
            $table->string('product_unit',10);
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
        Schema::drop('product');
    }
}
