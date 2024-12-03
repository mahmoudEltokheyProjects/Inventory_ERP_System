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
        Schema::create('account_types', function (Blueprint $table) {
            $table->comment('جدول الحسابات المالية');
            $table->id();
            $table->string('name',255);
            $table->tinyInteger('active');
            $table->tinyInteger('relatedInternalAccounts')->nullable()->comment('هو حساب تم انشائه من داخل النظام من الموردين او العملاء وبيتم تعديله من الشاشة اللي تم انشائه منها وليس شاشة الحسابات العامة لكن الحساب اللي تم انشائه من الشجرة المحاسبية يسمي حساب عام');
            // ++++++++++++++ Foreign key : added_by ++++++++++++++
            $table->unsignedBigInteger('added_by')->nullable();
            $table->foreign('added_by')->references('id')->on('admins')->onDelete('cascade');
            // ++++++++++++++ Foreign key : updated_by ++++++++++++++
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('admins')->onDelete('cascade');
            // created_at , updated_at
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
        Schema::dropIfExists('account_types');
    }
};
