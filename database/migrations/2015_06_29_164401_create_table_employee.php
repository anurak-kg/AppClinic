<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEmployee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee', function (Blueprint $table) {
            $table->increments('emp_id');
            $table->integer('branch_id');
            $table->string('emp_name',30);
            $table->string('emp_lastname',30);
            $table->string('emp_position',10);
            $table->string('emp_tel',10);
            $table->string('emp_sex',5);
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
        Schema::drop('employee');
    }
}
