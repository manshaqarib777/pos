<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('site_name');
            $table->string('default_email');
            $table->string('address_1');
            $table->string('address_2');
            $table->string('phone');
            $table->string('currency')->default('$');
            $table->string('sale_prefix');
            $table->string('refund_prefix');
            $table->string('purchase_prefix');
            $table->string('skin');
            $table->string('vat');
            $table->string('default_group')->default(2);
            $table->string('registration_number');
            $table->string('image')->default('default_img/no_image.png');
            //for env mail setup
            $table->string('mail_driver');
            $table->string('mail_host');
            $table->string('mail_port');
            $table->string('mail_user');
            $table->string('mail_password');
            $table->string('mail_encryption');
            //for Product
            $table->string('status');
            $table->string('discountable');
            $table->string('barcode_symbology');
            $table->string('alert_quantity');
            $table->string('tax');
            $table->string('dead_level')->default(1);
            $table->string('high_level')->default(5);
            $table->string('medium_level')->default(10);
            $table->string('low_level')->default(15);
            $table->string('normal_level')->default(20);
            //POS
            $table->boolean('name_show')->default(1);
            $table->boolean('qty_show')->default(1);
            $table->boolean('price_show')->default(1);
            $table->string('default_customer')->default(1);
            $table->string('default_tax')->default(18);
            $table->string('default_payment')->default(1);
            $table->string('discount_state')->default(1);
            $table->string('product_icon_skin')->default('default');
            $table->string('default_category')->default(0);
            $table->string('product_limit')->default(12);
            $table->string('quick_amounts')->default('100,50');
            //Demo
            $table->string('demo')->default('inactive');
            $table->string('locale')->default('en')->nullable();
            $table->string('version')->default('1.5')->nullable();
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
        Schema::dropIfExists('settings');
    }
}
