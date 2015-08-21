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
            $table->integer('sale_price');//ค่าแนะนำคอร์สจำนวนเงิน
            $table->integer('sale_price1');//ค่าแนะนำคอร์สเปอร์เซ็น
            $table->date('quo_date');
            $table->integer('quo_status');
            //สถานะ
            // -1 = อยุ่ในหน้าจอการซื้อ, 1 = ซื้อสำเร็จ ,
            // 2 = อยุ่ในระหว่างการรักษา ,3 = เรียบร้อยแล้ว
            //VAT
            $table->decimal('total_net_price',14,2);
            $table->enum('vat_type', array('none','in_vat','out_vat'));
            $table->integer('vat_rate');//
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
            $table->decimal('quo_de_price',12,2);
            $table->integer('quo_de_discount'); //ส่วนลดเปอเซ็น
            $table->decimal('quo_de_disamount',10,2); //ส่วนลดจำนวนเงิน
            $table->decimal('net_price',14,2);
            $table->decimal('payment_remain',14,2);
            //สถานะ
            // 0 = ไม่เริ่ม,
            // 1 = อยุ่ในระหว่างการรักษา ,5 = เรียบร้อยแล้ว -99 = ยกเลิก
            $table->integer('qty');
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
