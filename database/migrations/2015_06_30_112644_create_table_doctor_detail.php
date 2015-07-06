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
            $table->string('dr_id',4);
            $table->time('dr_de_time');
            $table->date('dr_de_date');
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
