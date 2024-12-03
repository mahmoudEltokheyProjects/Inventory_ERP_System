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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->comment('جدول الموردين');
            $table->id();
            $table->string('name',255)->comment('اسم المورد');
            $table->tinyInteger('active')->default(1)->comment('حالة تفعيل');
            $table->tinyInteger('is_archived')->default(0)->comment('حالة الارشفة');
            // com_code : company_code : رقم الشركة
            $table->integer('com_code')->comment('رقم الشركة')->nullable();
            // customer code : supplier_code : رقم المورد
            $table->integer('supplier_code')->comment('رقم المورد')->nullable();
            // account_number
            $table->bigInteger('account_number')->comment('رقم الحساب  المالي لا يتكرر علي مستوي الشركة يعني ممكن يتكرر مع شركة اخري بستخدم نفس النظام');
            // is_city
            $table->tinyInteger('is_city')->default(0)->nullable()->comment('المدينة التي ينتمي اليها العميل');
            // address
            $table->string('address',250)->nullable()->comment('عنوان المورد');
            // start_balance_status
            $table->tinyInteger('start_balance_status')->nullable()->comment('1- credit 2- debit 3- balance حالةالرصيد الابتدائي او الافتتاحي سواء دائن او مدين او متزن');
            // start_balance
            $table->decimal('start_balance',10,2)->comment('الرصيد الابتدائي او الافتتاحي سواء دائن او مدين او متزن');
            // current_balance
            $table->decimal('current_balance',10,2)->default(0)->comment('الحساب الحالي');
            // date : i will use this column for search
            $table->date('date')->comment('i will use this column for search')->nullable();
            // notes
            $table->string('notes')->nullable()->comment('الملاحظات');
            // ++++++++++ Foreign key : account_type +++++++++++++++++
            $table->unsignedBigInteger('account_type')->nullable()->comment('انواع الحسابات');
            $table->foreign('account_type')->references('id')->on('account_types')->onDelete('cascade');
            // ============ Foreign key : supplier_categories_id ============
            $table->unsignedBigInteger('supplier_categories_id')->nullable()->comment('اسم فئة الموردين الذي ينتمي اليه المورد');
            $table->foreign('supplier_categories_id')->references('id')->on('suppliers_categories')->onDelete('cascade');
            // ============ Foreign key : added_by ============
            $table->unsignedBigInteger('added_by')->nullable()->comment('الشخص الذي قام باضافة مورد جديد');
            $table->foreign('added_by')->references('id')->on('admins')->onDelete('cascade');
            // ============ Foreign key : updated_by ============
            $table->unsignedBigInteger('updated_by')->nullable()->comment('الشخص الذي قام بتحديث مورد جديد');
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
        Schema::dropIfExists('suppliers');
    }
};
