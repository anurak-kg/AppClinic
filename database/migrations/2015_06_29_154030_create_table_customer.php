<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->increments('cus_id');
            $table->string('cus_name',50);
            $table->string('cus_birthday_day',20);
            $table->string('cus_birthday_month',20);
            $table->string('cus_birthday_year',20);
            $table->string('cus_sex',5);
            $table->string('cus_blood',3);
            $table->string('cus_code',18);
            $table->string('cus_tel',10);
            $table->string('cus_phone',10);
            $table->string('cus_email',60);
            $table->date('cus_reg');
            $table->text('allergic');
            $table->text('disease');
            $table->integer('cus_height');
            $table->integer('cus_weight');
            $table->string('cus_hno',10);
            $table->string('cus_moo',2);
            $table->string('cus_soi',30);
            $table->string('cus_road',30);
            $table->string('cus_subdis',30);
            $table->string('cus_district',30);
            $table->string('cus_province',30);
            $table->string('cus_postal',10);
            $table->integer('branch_id')->nullable();

            $table->timestamps();
        });
          DB::unprepared("ALTER TABLE customer AUTO_INCREMENT = 510000;");
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('customer');
    }
}
