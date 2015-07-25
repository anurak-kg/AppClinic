<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCustomerEvent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_event', function (Blueprint $table) {
            $table->increments('event_id');
            $table->integer('customer_id');
            $table->string('event_name');
            $table->dateTime('event_start');
            $table->dateTime('event_end');
            $table->string('event_status');
            $table->string('color');
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
        Schema::drop('customer_event');
    }
}
