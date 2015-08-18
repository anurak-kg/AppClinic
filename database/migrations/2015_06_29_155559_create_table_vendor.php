<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableVendor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor', function (Blueprint $table) {
            $table->increments('ven_id');
            $table->string('ven_name',30);
            $table->text('ven_address');
            $table->string('ven_sell_name',30);
            $table->string('ven_code',13);
            $table->string('ven_sell_tel',10);
            $table->string('ven_license');
            $table->boolean('ven_vat_enable');

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
        Schema::drop('vendor');
    }
}
