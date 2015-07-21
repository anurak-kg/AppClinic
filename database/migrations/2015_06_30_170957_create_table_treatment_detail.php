<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTreatmentDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('treatment_detail', function (Blueprint $table) {
            $table->integer('tre_id');
            $table->integer('dr_id');
            $table->text('tre_de_cm');
            $table->timestamps();
            $table->primary(['tre_id','dr_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('treatment_detail');
    }
}
