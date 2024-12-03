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
        Schema::create('treasuries', function (Blueprint $table) {
            // Add Comment To Table
            $table->comment('جدول الخزن');
            // id
            $table->id();
            // treasury name : اسم الخزنة
            $table->string('name', 250)->comment('اسم الخزنة');
            // Treasury is "master" or "not master" : هل الخزنة رئيسية او فرعية
            $table->tinyInteger('is_master')->value(1)->comment('هل الخزنة رئيسية او فرعية');
            // Treasury is "active" or "not active" : هل الخزنة مفعلة او معطلة
            $table->tinyInteger('active')->value(1)->comment('هل الخزنة مفعلة او معطلة');
            // last_isal_exchange : اخر ايصال تم صرفه
            $table->bigInteger('last_isal_exchange')->comment('اخر ايصال تم صرفه')->nullable();
            // last_isal_collect : اخر ايصال تم تحصيله
            $table->integer('last_isal_collect')->comment('اخر ايصال تم تحصيله')->nullable();
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
        Schema::dropIfExists('treasuries');
    }
};
