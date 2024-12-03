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
        Schema::create('supplier_with_orders', function (Blueprint $table) {
            $table->comment('جدول مشتريات و مرتجعات الموردين');
            $table->id();
            $table->tinyInteger('order_type')->nullable()->comment('1- purchase(مشتريات) 2- return on same pill (مرتجع علي اصل الفاتورة) 3- return on general (مرتجع عام) ');
            $table->bigInteger('auto_serial')->nullable();
            $table->bigInteger('doc_no')->nullable()->comment('رقم فاتورة المورد');
            $table->date('order_date')->nullable()->comment('تاريخ الفاتورة');
            $table->bigInteger('supplier_code')->nullable()->comment('كود المورد');
            $table->tinyInteger('is_approved')->default(0)->comment('هل الفاتورة معتمدة او غير معتمدة');
            $table->integer('com_code')->default(1)->comment('كود الشركة');
            $table->tinyInteger('discount_type')->nullable()->comment('نوع الخصم 1- خصم نسبة 2- خصم يدوي');
            $table->decimal('discount_percent',10,2)->nullable()->default(0)->comment('نسبة الخصم');
            $table->decimal('discount_value',10,2)->nullable()->default(0)->comment('قيمة الخصم');
            $table->decimal('tax_percent',10,2)->nullable()->default(0)->comment('نسبة الضريبة');
            $table->decimal('tax_value',10,2)->nullable()->default(0)->comment('ضريبة القيمة المضافة');
            $table->decimal('total_before_discount',10,2)->default(0)->comment('اجمالي الفاتورة قبل الخصم');
            $table->decimal('total_cost',10,2)->default(0)->comment('الاجمالي النهائي للفاتورة');
            $table->bigInteger('account_number')->nullable()->comment('كود المورد');
            $table->decimal('money_for_account',10,2)->default(0)->comment('الباقي للمورد');
            $table->tinyInteger('pill_type')->nullable()->comment('نوع الفاتورة 1- كاش 2-أجل');
            $table->decimal('what_paid',10,2)->default(0)->nullable()->comment('ما تم دفعه لاحظت انشاء الفاتورة');
            $table->decimal('what_remain',10,2)->default(0)->nullable()->comment('الباقي الذي لم يتم دفعه');
            $table->bigInteger('treasuries_transaction_id')->nullable()->comment('سندات المعاملات(حركة الخزنة)');
            $table->decimal('supplier_balance_before',10,2)->nullable()->default(0)->comment('رصيد المورد قبل الفاتورة');
            $table->decimal('supplier_balance_after',10,2)->nullable()->default(0)->comment('رصيد المورد بعد الفاتورة');
            // ========= foreign_key : added_by =========
            $table->unsignedBigInteger('added_by')->nullable();
            $table->foreign('added_by')->references('id')->on('admins')->onDelete('cascade');
            // ========= foreign_key : updated_by =========
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('admins')->onDelete('cascade');
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('supplier_with_orders');
    }
};
