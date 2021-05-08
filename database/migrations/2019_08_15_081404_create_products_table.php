<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->string('name');
            $table->string('unit');
            $table->integer('cost');
            $table->integer('price');
            $table->integer('qty')->default(0);
            $table->integer('alert_quantity');
            $table->string('barcode_symbology');
            $table->string('expiry_date')->nullable();
            $table->string('manufacturing_date')->nullable();
            $table->text('side_effects')->nullable();
            $table->integer('sold_out')->default('0');
            $table->integer('status')->default('0');
            $table->integer('discountable')->default('0');

            $table->longText('product_details');
            $table->longText('type');
            $table->string('image')->default('default_img/no_image.png');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('subcategory_id')->nullable();
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('warehouse_id');
            $table->unsignedBigInteger('tax_id');
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
        Schema::dropIfExists('products');
    }
}
