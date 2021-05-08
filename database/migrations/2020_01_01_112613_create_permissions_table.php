<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('group_id');

            $table->boolean('product_add')->nullable();
            $table->boolean('product_manage')->nullable();
            $table->boolean('product_inventory')->nullable();

            //category
            $table->boolean('category_add')->nullable();
            $table->boolean('category_manage')->nullable();

            //subcategory
            $table->boolean('subcategory_add')->nullable();
            $table->boolean('subcategory_manage')->nullable();

            //supplier
            $table->boolean('supplier_add')->nullable();
            $table->boolean('supplier_manage')->nullable();

            //customer
            $table->boolean('customer_add')->nullable();
            $table->boolean('customer_manage')->nullable();

            //purchase std
            $table->boolean('purchase_add')->nullable();
            $table->boolean('purchase_manage')->nullable();
            $table->boolean('purchase_summary')->nullable();
            $table->boolean('purchase_report')->nullable();

            //expense
            $table->boolean('expense_add')->nullable();
            $table->boolean('expense_manage')->nullable();
            $table->boolean('expense_summary')->nullable();

            //warehouse
            $table->boolean('warehouse_add')->nullable();
            $table->boolean('warehouse_manage')->nullable();

            //tax
            $table->boolean('tax_add')->nullable();
            $table->boolean('tax_manage')->nullable();
            $table->boolean('tax_summary')->nullable();
            $table->boolean('tax_report')->nullable();

            //sale
            $table->boolean('sale_create')->nullable();
            $table->boolean('sale_manage')->nullable();
            $table->boolean('sale_summary')->nullable();
            $table->boolean('sale_report')->nullable();

            //Refund
            $table->boolean('refund_create')->nullable();
            $table->boolean('refund_manage')->nullable();
            $table->boolean('refund_summary')->nullable();

            //users
            $table->boolean('user_manage')->nullable();
            $table->boolean('user_edit')->nullable();
            $table->boolean('user_create')->nullable();

            //Permission
            $table->boolean('group_add')->nullable();
            $table->boolean('group_manage')->nullable();
            $table->boolean('group_request')->nullable();
            $table->boolean('group_request_manage')->nullable();

            //master setting
            $table->boolean('setting_view')->nullable();
            $table->boolean('setting_general')->nullable();
            $table->boolean('setting_logo')->nullable();
            $table->boolean('setting_mail')->nullable();
            $table->boolean('setting_product_default')->nullable();
            $table->boolean('setting_impects')->nullable();
            $table->boolean('setting_pos')->nullable();
            $table->boolean('setting_backup')->nullable();
            $table->boolean('setting_dashboard')->nullable();
            $table->boolean('setting_quick_mail')->nullable();

            //Chapter
            $table->boolean('chapter_open')->nullable();
            $table->boolean('chapter_close')->nullable();
            $table->boolean('chapter_manage')->nullable();

            //Payment gateways
            $table->boolean('payment_add')->nullable();
            $table->boolean('payment_manage')->nullable();

            //Activity logs
            $table->boolean('logs_view')->nullable();
            $table->boolean('logs_manage')->nullable();

            //Saved Reports
            $table->boolean('reports_save')->nullable();
            $table->boolean('reports_view')->nullable();
            $table->boolean('reports_manage')->nullable();

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
        Schema::dropIfExists('permissions');
    }
}
