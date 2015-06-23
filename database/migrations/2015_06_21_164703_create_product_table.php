<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ProductName');
            $table->string('ProductBarcodeId');
            $table->string('ProductType');
            $table->integer('BandId');
            $table->string('ProductModel');
            $table->integer('ProductSellPrice');
            $table->text('ProductDescription');
            $table->integer('ProductMinStockQty');
            $table->integer('ProductMaxStockQty');
            $table->boolean('ProductOnlineSell');
            $table->boolean('ProductCanSellRunOut');
            $table->integer('UnitId');
            $table->integer('PlaceId');
            $table->integer('ProductWaranty');
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
        Schema::drop('products');
    }
}
