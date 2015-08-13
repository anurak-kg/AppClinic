<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePicture extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_photo', function (Blueprint $table) {
            $table->increments('photo_id');
            $table->integer('branch_id');
            $table->integer('emp_id');
            $table->integer('cus_id');
            $table->enum('photo_type', array('Before','After'));
            $table->string('photo_file_name');
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
        Schema::drop('customer_photo');
    }
}
