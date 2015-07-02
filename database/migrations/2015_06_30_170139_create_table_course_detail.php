<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCourseDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_detail', function (Blueprint $table) {
            $table->increments('course_de_id');
            $table->string('course_de_name',20);
            $table->integer('course_de_price');
            $table->integer('course_de_qty');
            $table->date('course_de_date_start');
            $table->date('course_de_date_end');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('course_detail');
    }
}
