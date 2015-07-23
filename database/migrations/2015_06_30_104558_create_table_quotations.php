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
            $table->decimal('price',14,2);
            $table->decimal('discount',14,2);
            //สถานะ
            // -1 = อยุ่ในหน้าจอการซื้อ, 1 = ซื้อสำเร็จ ,
            // 2 = อยุ่ในระหว่างการรักษา ,3 = เรียบร้อยแล้ว
            $table->decimal('payment',10,2);
            $table->char('payment_type');
            $table->integer('branch_id')->nullable();
            $table->integer('bill_number');//เลขที่ใบเสร้จ
            $table->timestamps();
        });
        DB::unprepared("ALTER TABLE quotations AUTO_INCREMENT = 580000;");
        Schema::create('quotations_detail', function (Blueprint $table) {
            $table->integer('quo_id');
            $table->string('course_id');
            $table->integer('treat_status');
            $table->integer('qty');

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
        Schema::drop('quotations');
    }
}
