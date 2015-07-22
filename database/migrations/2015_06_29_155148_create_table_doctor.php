<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDoctor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor', function (Blueprint $table) {
            $table->increments('dr_id');
            $table->string('dr_name',50);
            $table->string('dr_lastname',50);
            $table->string('dr_tel',10);
            $table->string('dr_sex',5);
            $table->text('education');
            $table->text('train');
            $table->timestamps();
        });
        DB::unprepared("ALTER TABLE doctor AUTO_INCREMENT = 510000;");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('doctor');
    }
}
