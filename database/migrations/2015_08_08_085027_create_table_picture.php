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
        Schema::create('picture', function (Blueprint $table) {
            $table->increments('pic_id');
            $table->integer('cus_id');
            $table->enum('pic_type', array('Before','After'));
            $table->string('pic_name');
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
        Schema::drop('picture');
    }
}
