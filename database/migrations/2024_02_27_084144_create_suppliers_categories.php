<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /* +++++++++++++++++++++++++++++++ up() +++++++++++++++++++++++++++++++ */
    public function up()
    {
        Schema::create('suppliers_categories', function (Blueprint $table) {
            $table->comment('جدول فئات الموردين');
            $table->id();
            $table->string('name');
            // com_code : company_code : رقم الشركة
            $table->integer('com_code')->comment('رقم الشركة')->nullable();
            // date : i will use this column for search
            $table->date('date')->comment('i will use this column for search')->nullable();
            // active : account is "active" or "not"
            $table->tinyInteger('active')->default(1);
            // ============== Foregin Key : added_by ==============
            $table->unsignedBigInteger('added_by')->nullable();
            $table->foreign('added_by')->references('id')->on('admins')->onDelete('cascade');
            // ============== Foregin Key : updated_by ==============
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('admins')->onDelete('cascade');

            $table->timestamps();
        });
    }
    /* +++++++++++++++++++++++++++++++ down() +++++++++++++++++++++++++++++++ */
    public function down()
    {
        Schema::dropIfExists('suppliers_categories');
    }
};
