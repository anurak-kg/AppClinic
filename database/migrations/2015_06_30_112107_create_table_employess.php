<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEmployess extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employess', function (Blueprint $table) {
            $table->string('emp_id',4);
            $table->string('branch_id',3);
            $table->string('emp_name',30);
            $table->string('emp_lastname',30);
            $table->string('emp_position',10);
            $table->string('emp_tel',10);
            $table->string('emp_sex',5);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('employess');
    }
}
