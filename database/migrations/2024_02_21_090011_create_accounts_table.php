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
        Schema::create('accounts', function (Blueprint $table) {
            $table->comment('جدول الشجرة المحاسبية العامة');
            $table->id();
            $table->string('name',255);
            // active : account is "active" or "not"
            $table->tinyInteger('active')->default(1);
            // is_archived : account is "is_archived" or "not is_archived"
            $table->tinyInteger('is_archived')->default(0)->comment('هل الحساب حصل له ارشفة ولا لا لان الحساب المالي لا يمكن حذفه');
            // com_code : company_code : رقم الشركة
            $table->integer('com_code')->comment('رقم الشركة')->nullable();
            // ++++++++++ Foreign key : account_type +++++++++++++++++
            $table->unsignedBigInteger('account_type')->nullable()->comment('انواع الحسابات');
            $table->foreign('account_type')->references('id')->on('account_types')->onDelete('cascade');
            // is_parent
            $table->tinyInteger('is_parent')->default(0)->comment('هل الحساب اب ولا لا');
            // parent_account_number
            $table->bigInteger('parent_account_number')->nullable()->comment('رقم الحساب الاب الذي ينتمي له هذا الحساب');
            // account_number
            $table->bigInteger('account_number')->comment('رقم الحساب  المالي لا يتكرر علي مستوي الشركة يعني ممكن يتكرر مع شركة اخري بستخدم نفس النظام');
            // start_balance_status
            $table->tinyInteger('start_balance_status')->nullable()->comment('1- credit 2- debit 3- balance حالةالرصيد الابتدائي او الافتتاحي سواء دائن او مدين او متزن');
            // start_balance
            $table->decimal('start_balance',10,2)->comment('الرصيد الابتدائي او الافتتاحي سواء دائن او مدين او متزن');
            // current_balance
            $table->decimal('current_balance',10,2)->default(0)->comment('الحساب الحالي');
            // ++++++++++ other_table_FK : Foreign keys for other tables +++++++++++++++++
            $table->unsignedBigInteger('other_table_FK')->nullable()->comment('جميع الحركات اللي جايه من الجداول الداخلية');
            $table->string('notes')->nullable()->comment('الملاحظات');
            // date : i will use this column for search
            $table->date('date')->comment('i will use this column for search')->nullable();
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
        Schema::dropIfExists('accounts');
    }
};
