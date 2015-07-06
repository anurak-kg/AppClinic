<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTrainDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('train_detail', function (Blueprint $table) {
            $table->increments('tra_de_id');
            $table->string('dr_id',4);
            $table->text('tra_de_h');
            $table->date('tra_de_date');
            $table->date('tra_de_end');
            $table->string('tra_de_location',50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('train_detail');
    }
}
