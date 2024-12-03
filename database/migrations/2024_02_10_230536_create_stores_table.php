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
        Schema::create('stores', function (Blueprint $table) {
            // Add Comment To Table
            $table->comment('جدول المخازن');
            // id
            $table->id();
            // store name : اسم المخزن
            $table->string('name', 250)->comment('اسم المادة');
            // store is "active" or "not active" : هل المخزن مفعل او معطل
            $table->tinyInteger('active')->value(1)->comment('هل المخزن مفعلة او معطلة');
            // store phone
            $table->string('phone')->nullable()->comment('هاتف المخزن');
            // store address
            $table->string('address')->comment('عنوان المخزن')->nullable();
            // com_code : company_code : رقم الشركة
            $table->integer('com_code')->comment('رقم الشركة')->nullable();
            // date : I will use this column for search
            $table->date('date')->comment('i will use this column for search')->nullable();
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
        Schema::dropIfExists('stores');
    }
};
