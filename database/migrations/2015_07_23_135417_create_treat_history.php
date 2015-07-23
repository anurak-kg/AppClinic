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
            $table->integer('bt_user_id1');
            $table->integer('bt_user_id2');
            $table->text('comment');
            $table->dateTime('treat_date');
            $table->integer('course_detail_qty');
            $table->unique(array('course_id', 'quo_id'));
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
        Schema::drop('treat_history');
    }
}
