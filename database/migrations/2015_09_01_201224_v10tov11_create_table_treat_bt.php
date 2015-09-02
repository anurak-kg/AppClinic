<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class V10tov11CreateTableTreatBt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bt', function (Blueprint $table) {
            $table->increments('bt_id');
            $table->integer('treat_id');
            $table->integer('emp_id');
            $table->enum('bt_type',array('bt1','bt2','doctor'));
            $table->decimal('total',10,2);
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
        Schema::drop('bt');
    }
}
