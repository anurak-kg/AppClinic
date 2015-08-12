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
            $table->string('ct_id');
            $table->string('course_name',50);
            $table->text('course_detail');//รายละเอียดคอร์ส
            $table->decimal('course_price',14,2);//ราคาคอร์ส
            $table->integer('course_qty');
            $table->timestamps();
            $table->primary(['course_id']);
        });
        Schema::create('course_type', function (Blueprint $table) {
            $table->increments('ct_id');
            $table->string('name',50);
            $table->timestamps();
        });
        Schema::create('course_medicine', function (Blueprint $table) {
            $table->string('course_id');
            $table->string('product_id');
            $table->integer('qty');//จำนวนยาที่ใช้
            $table->timestamps();
            $table->primary(['course_id','product_id']);
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
        Schema::drop('course_type');
        Schema::drop('course_medicine');

    }
}
