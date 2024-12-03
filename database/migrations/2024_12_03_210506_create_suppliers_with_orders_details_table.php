<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers_with_orders_details', function (Blueprint $table) {
            $table->comment("تفاصيل أصناف فاتورة المشتريات و المرتجعات");
            $table->id();
            // +++++++++++ foreign_key : supplier_with_orders_id ++++++++++++
            $table->unsignedBigInteger('supplier_with_orders_id');
            $table->foreign('supplier_with_orders_id')->references('id')->on('supplier_with_orders')->onDelete('cascade');
            $table->tinyInteger('order_type');
            $table->integer('com_code');
            $table->
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
        Schema::dropIfExists('suppliers_with_orders_details');
    }
};
