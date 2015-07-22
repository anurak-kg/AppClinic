<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTreatment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('treatment', function (Blueprint $table) {
            $table->increments('tre_id');
            $table->integer('quo_id');
            $table->integer('id');
            $table->string('course_id');
            $table->integer('cus_id');
            $table->integer('tre_qty');
            $table->date('tre_date');
            $table->integer('branch_id')->nullable();

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
        Schema::drop('treatment');
    }
}
