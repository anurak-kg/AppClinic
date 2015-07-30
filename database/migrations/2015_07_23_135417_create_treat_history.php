<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTreatHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('treat_history', function (Blueprint $table) {
            $table->increments('treat_id');
            $table->string('course_id');
            $table->integer('quo_id');
            $table->integer('emp_id');
            $table->integer('dr_id');
            $table->integer('dr_price');//ค่ามือแพทย์
            $table->integer('bt_user_id1');
            $table->integer('bt1_price');//ค่ามือผู้ช่วย1
            $table->integer('bt_user_id2');
            $table->integer('bt2_price');//ค่ามือผู้ช่วย2
            $table->text('comment');
            $table->date('treat_date');
            $table->integer('branch_id')->unsigned()->nullable();
            $table->unique(array('course_id', 'quo_id'));
            $table->timestamps();
        });
        Schema::create('treat_has_medicine', function (Blueprint $table) {
            $table->increments('treat_medicine_id');
            $table->integer('treat_id');
            $table->string('product_id');
            $table->integer('qty');
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
        Schema::drop('treat_has_medicine');
        Schema::drop('treat_history');
    }
}
