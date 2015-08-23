<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSystemLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_logs', function (Blueprint $table) {
            $table->increments('logs_id');
            $table->integer('emp_id');
            $table->integer('cus_id');
            $table->string('logs_type',255);//เช่น Create ,Update , Delete , Error , Login , Warring
            $table->string('logs_where',255);//เช่น Quo , Order ,Treatment ,Auth , User , Customer
            $table->string('description');
            $table->integer('emp_id2');//เลขพนักงานที่โดนกระทำ
            $table->integer('cus_id2');//เลขลูกค้าที่โดนกระทำ
            $table->integer('branch_id');
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
        Schema::drop('system_logs');

    }
}
