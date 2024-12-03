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
        Schema::create('inv_uoms', function (Blueprint $table) {
            // Add Comment To Table
            $table->comment('جدول وحدات القياس');
            // id
            $table->id();
            // unit name : اسم الوحدة
            $table->string('name', 250)->comment('اسم الوحدة');
            // unit is "master" or "not master" : هل الوحدة رئيسية او فرعية
            $table->tinyInteger('is_master')->value(1)->comment('هل الوحدة رئيسية او فرعية');
            // unit is "active" or "not active" : هل الخزنة مفعلة او معطلة
            $table->tinyInteger('active')->value(1)->comment('هل الوحدة مفعلة او معطلة');
            // com_code : company_code : رقم الشركة
            $table->integer('com_code')->comment('رقم الشركة')->nullable();
            // date : i will use this column for search
            $table->date('date')->comment('i will use this column for search')->nullable();
            // ++++++++++++++ Foreign key : added_by ++++++++++++++
            $table->unsignedBigInteger('added_by')->nullable();
            $table->foreign('added_by')->references('id')->on('admins')->onDelete('cascade');
            // ++++++++++++++ Foreign key : updated_by ++++++++++++++
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
        Schema::dropIfExists('inv_uoms');
    }
};
