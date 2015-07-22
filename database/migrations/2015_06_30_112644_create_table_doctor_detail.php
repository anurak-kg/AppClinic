<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDoctorDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_detail', function (Blueprint $table) {
            $table->increments('dr_de_id');
            $table->integer('dr_id');
            $table->time('dr_de_time');
            $table->dateTime('dr_de_date');
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
        Schema::drop('doctor_detail');
    }
}
