<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableQuotationsDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotations_detail', function (Blueprint $table) {
            $table->integer('quo_id');
            $table->string('course_id');
            $table->integer('quo_t');
            $table->decimal('quo_discount',10,2);
            $table->timestamps();
            $table->primary(['quo_id','course_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('quotations_detail');
    }
}
