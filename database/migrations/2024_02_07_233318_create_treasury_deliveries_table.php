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
        Schema::create('treasury_deliveries', function (Blueprint $table) {
            // Add Comment To Table
            $table->comment('جدول استيلام الخزن');
            // id
            $table->id();
            // ++++++++++ Foreign key : treasuries_id +++++++++++++
            $table->unsignedBigInteger('treasuries_id')->nullable()->comment('الخزنة الرئيسية التي سوف تستلم من الخزنة الفرعية');
            $table->foreign('treasuries_id')->on('treasuries')->references('id')->onDelete('cascade');
            // ++++++++++ Foreign key : treasuries_can_delivery_id +++++++++++++
            $table->unsignedBigInteger('treasuries_can_delivery_id')->nullable()->comment('الخزنة الفرعية التي سوف يتم تسليمها للخزنة الرئيسية');
            $table->foreign('treasuries_can_delivery_id')->on('treasuries')->references('id')->onDelete('cascade');
            // com_code : company_code : رقم الشركة
            $table->integer('com_code')->comment('رقم الشركة')->nullable();
            // ++++++++++++++ Foreign key : added_by ++++++++++++++
            $table->unsignedBigInteger('added_by')->nullable();
            $table->foreign('added_by')->references('id')->on('admins')->onDelete('cascade');
            // ++++++++++++++ Foreign key : updated_by ++++++++++++++
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('admins')->onDelete('cascade');
            // created_at , updated_at column
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
        Schema::dropIfExists('treasury_deliveries');
    }
};
