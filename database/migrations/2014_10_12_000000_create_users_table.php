<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('branch_id');
            $table->string('username');
            $table->string('emp_name');
            $table->string('emp_lastname');
            $table->string('emp_position');
            $table->string('emp_tel');
            $table->string('emp_sex');
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->integer('role')->unsigned();
            $table->rememberToken();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
