<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDoctorEvent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_event', function (Blueprint $table) {
            $table->increments('event_id');
            $table->integer('dr_id');
            $table->string('event_name');
            $table->dateTime('event_start');
            $table->dateTime('event_end');
            $table->string('event_status');
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
        Schema::drop('doctor_event');
    }
}
