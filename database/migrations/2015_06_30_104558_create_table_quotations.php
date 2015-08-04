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
            $table->integer('sale_id');
            $table->integer('sale_price');//ค่าแนะนำคอร์ส
            $table->date('quo_date');
            $table->integer('quo_status');
            $table->decimal('price',14,2);
            $table->decimal('discount',14,2);
            //สถานะ
            // -1 = อยุ่ในหน้าจอการซื้อ, 1 = ซื้อสำเร็จ ,
            // 2 = อยุ่ในระหว่างการรักษา ,3 = เรียบร้อยแล้ว
            $table->enum('payment_type', array('CASH','CREDIT'));
            $table->integer('commission_rate');//% ค่าคอมมิชชั้น
            $table->integer('branch_id')->nullable();
            $table->integer('bill_number');//เลขที่ใบเสร้จ
            $table->timestamps();
        });
        Schema::create('quotations_detail', function (Blueprint $table) {
            $table->increments('quo_de_id');
            $table->integer('quo_id');
            $table->string('course_id');
            $table->integer('treat_status');
            $table->integer('quo_de_discount'); //ส่วนลดเปอเซ็น
            $table->decimal('quo_de_disamount',10,2); //ส่วนลดจำนวนเงิน
            $table->enum('payment_status', array('REMAIN','FULLY_PAID'));//REMAIN ค้างจ่าย fully Paid จ่ายครบ
            $table->decimal('payment_remain',14,2);
            //สถานะ
            // 0 = ไม่เริ่ม,
            // 1 = อยุ่ในระหว่างการรักษา ,5 = เรียบร้อยแล้ว -99 = ยกเลิก
            $table->integer('qty');
            $table->decimal('quo_de_price',12,2);
            $table->timestamps();
            $table->unique(array('quo_id', 'course_id'));
        });
        DB::unprepared("ALTER TABLE quotations AUTO_INCREMENT = 580000;");




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
