<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateCourseSystem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course', function (Blueprint $table) {
            $table->string('course_id');
            $table->string('course_name',50);
            $table->string('course_type',20);
            $table->integer('course_price');//ราคาคอร์ส
            $table->timestamps();
        });
        Schema::create('course_detail', function (Blueprint $table) {
            $table->increments('course_detail_id');
            $table->string('course_id');
            $table->string('course_detail_name',50);
            $table->integer('course_detail_qty');
            $table->timestamps();
        });
        Schema::create('course_medicine', function (Blueprint $table) {
            $table->integer('course_detail_id');
            $table->string('product_id');
            $table->integer('qty');//จำนวนยาที่ใช้
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
        Schema::drop('course');
        Schema::drop('course_detail');
        Schema::drop('course_medicine');

    }
}
