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
        Schema::create('admin_panel_settings', function (Blueprint $table) {
            // Add Comment To Table
            $table->comment('جدول اعدادات الادمن');
            // id
            $table->id();
            $table->string('system_name')->nullable();
            $table->string('photo')->nullable();
            $table->string('logo')->nullable();
            $table->tinyInteger('active')->default(1);
            $table->string('general_alert')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->integer('com_code')->nullable();
            // ============ Foreign key : country_id ============
            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            // ============ Foreign key : state_id ============
            $table->unsignedBigInteger('state_id')->nullable();
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            // ============ Foreign key : city ============
            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            // parent_account for customers :  الحساب الاب للعملاء
            $table->integer('customer_parent_account_number')->comment('رقم الحساب الاب للعملاء')->nullable();
            // parent_account for supplier :  الحساب الاب للموردين
            $table->integer('supplier_parent_account_number')->comment('رقم الحساب الاب للموردين')->nullable();
            // Foreign key : created_by
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('admins')->onDelete('cascade');
            // Foreign key : updated_by
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('admins')->onDelete('cascade');
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
        Schema::dropIfExists('admin_panel_settings');
    }
};
