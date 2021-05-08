<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChaptersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chapters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');

            $table->string('key');
            $table->boolean('status');

            $table->string('walkin')->default(0);
            $table->string('regular')->default(0);

            $table->string('total_cash_in_hands');

            $table->string('sale_orders')->default(0);
            $table->string('tax_amount')->default(0);
            $table->string('discount')->default(0);
            $table->string('sold_item')->default(0);
            $table->string('profit')->default(0);
            $table->string('low_price_index')->default(0);
            $table->string('payables')->default(0);

            $table->string('refund_orders')->default(0);
            $table->string('tax_fall')->default(0);
            $table->string('surcharges')->default(0);
            $table->string('refundables')->default(0);

            $table->longText('gatewayFilters')->nullable();
            $table->longText('holdOnOrders')->nullable();

            $table->string('closed_at')->default('Not closed');
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
        Schema::dropIfExists('chapters');
    }
}
