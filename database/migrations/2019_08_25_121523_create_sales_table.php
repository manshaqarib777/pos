<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('date');
            $table->string('reference');
            $table->unsignedBigInteger('customer_id');
            $table->string('order_tax');
            $table->string('tax_amount');
            $table->string('discount_rate');
            $table->string('discount_amount');
            $table->longText('staff_note')->nullable();
            $table->string('payable');
            $table->string('enter_amount');
            $table->string('change');
            $table->string('order_profit');
            $table->string('lowPricing')->default('0');
            $table->string('total_items');
            $table->string('total_price');
            $table->longtext('products_data');
            $table->text('biller_detail');
            $table->string('payment_note')->nullable();
            $table->string('payment_gateway');
            $table->unsignedBigInteger('chapter_id');
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
        Schema::dropIfExists('sales');
    }
}
