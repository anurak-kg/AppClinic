<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableQuotations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->increments('quo_id');
            $table->integer('cus_id');
            $table->integer('emp_id');
            $table->date('quo_date');
            $table->integer('quo_status');
            //สถานะ
            // -1 = อยุ่ในหน้าจอการซื้อ
            // 1 = ซื้อสำเร็จ
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
        Schema::drop('quotations');
    }
}
