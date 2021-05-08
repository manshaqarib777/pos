<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('date');
            $table->string('reference');
            $table->string('total_cost');
            $table->string('total_qty');
            $table->string('discount_rate');
            $table->string('discount_amount');
            $table->string('tax_rate');
            $table->string('tax_amount');
            $table->longText('staff_note');
            $table->string('shipping');
            $table->longtext('Products');
            $table->string('total_payment');
            $table->string('by');
            $table->string('status');
            $table->string('stock')->default('0');
            $table->unsignedBigInteger('supplier_id');
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
        Schema::dropIfExists('purchases');
    }
}
