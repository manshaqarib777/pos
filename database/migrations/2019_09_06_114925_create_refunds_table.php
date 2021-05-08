<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refunds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('sale_id');
            $table->unsignedBigInteger('chapter_id');
            $table->string('date');
            $table->string('reference');
            $table->string('tax_rate');
            $table->string('tax_amount');
            $table->string('charge_rate');
            $table->string('charge_amount');
            $table->longText('staff_note');
            $table->string('refundable');
            $table->string('return_items');
            $table->string('refund_price');
            $table->longtext('products_data');
            $table->text('biller_detail');
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
        Schema::dropIfExists('refunds');
    }
}
