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
            $table->integer('id');
            $table->integer('order_id');
            $table->date('receive_date');
            $table->decimal('receive_total',6,2);
            $table->string('receive_status');
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
        Schema::drop('receive');
    }
}
