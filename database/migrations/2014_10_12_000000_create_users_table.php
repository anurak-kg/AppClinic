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
            $table->integer('position_id');
            $table->string('username');
            $table->string('name');
            $table->string('tel');
            $table->string('sex');
            $table->string('email')->unique();
            $table->string('license');
            $table->string('password', 60);
            $table->rememberToken();
            $table->timestamps();

        });
        Schema::create('position', function (Blueprint $table) {
            $table->increments('position_id');
            $table->string('position_name');
            $table->integer('role')->unsigned();
            $table->timestamps();
        });
        DB::unprepared("ALTER TABLE users AUTO_INCREMENT = 100000;");

    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
        Schema::drop('position');
    }
}
