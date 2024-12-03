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
        Schema::create('inv_item_cards', function (Blueprint $table) {
            $table->comment('جدول الاصناف');
            // id
            $table->id();
            // name
            $table->string('name')->comment('اسم الصنف ذي فراخ او لحمة');
            // item_code : barcode ولا ال id في باقي الجداول الاخري مش هعتمد علي ال foreign_key هيكون هوه ال
            $table->unsignedBigInteger('item_code')->comment('الكود بتاع كل صنف');
            // item_type
            $table->tinyInteger('item_type')->comment('1- مخزني : ذي المكاتب والكراسي ليس لها تاريخ صلاحية
                                                                    2- استهلاكي : ذي الماكولات لها تاريخ صلاحية
                                                                    3- عهدة : ذي صرف جهاز كمبيوتر للموظف فممكن استرجاعه لما الموظف يترك العمل');
            // barcode
            $table->string('barcode')->comment('باركود الصنف');
            // parent_inv_item_card_id : كل صنف بيكون ليه صنف اب =========
            $table->unsignedBigInteger('parent_inv_item_card_id')->nullable()->comment('الصنف الاب');
            // does_has_retail_unit : هل يمتلك وحدة تجزئه
            $table->tinyInteger('does_has_retail_unit')->nullable()->comment('هل للصنف وحدة تجزئه');
            // has_retail_unit : هل للصنف سعر ثابت بالفواتير او قابل للتغيير بالفواتير
            $table->tinyInteger('has_fixed_price')->nullable()->comment('هل للصنف سعر ثابت بالفواتير او قابل للتغيير بالفواتير');
            // retail_uom_to_uom : وحدة التجزئه بتساوي كام من الوحدة الاب مثال الشكاره فيها 10 كيلو
            $table->unsignedDecimal('retail_uom_to_uom')->nullable()->comment('وحدة التجزئه ذي طبق 1 كيلو فوحدة النجزئه بتساوي كام من الوحدة الاب مثال الشكاره فيها 10 طبق 1 كيلو');
            // inv_item_cards is "active" or "not active" : هل الصنف مفعلة او معطلة
            $table->tinyInteger('active')->value(1)->comment('هل الخزنة مفعلة او معطلة');
            // date : i will use this column for search
            $table->date('date')->comment('i will use this column for search')->nullable();
            // com_code : company_code : رقم الشركة
            $table->integer('com_code')->comment('رقم الشركة')->nullable();
            // photo : صورة الصنف
            $table->string('photo',225)->comment('صورة الصنف')->nullable();
            // ++++++++++++++++++++ quantities : الكميات ++++++++++++++++++++
            // quantity : الكمية بالوحدة الاب
            $table->float('quantity',10,3)->comment('الكمية بالوحدة الاب')->nullable();
            // quantity_retail : كمية التجزئه المتبقية من وحدة الاب في حالة وجود وحدة تجزئه للصنف
            $table->float('quantity_retail',10,3)->comment(' كمية التجزئه المتبقية من وحدة الاب في حالة وجود وحدة تجزئه للصنف')->nullable();
            // quantity_all_retail = quantity + quantity_retail : كل الكمية للصنف بوحدة التجزئه
            $table->float('quantity_all_retail',10,3)->comment('quantity + quantity_retail  كل الكمية للصنف بوحدة التجزئه وهتساوي')->nullable();
            // ++++++++++++++++++++ Prices : الاسعار ++++++++++++++++++++
            // ========= 1- price =========
            // price : السعر القطاعي بوحدة القياس الاساسية
            $table->float('price',10,2)->comment('السعر القطاعي بوحدة القياس الاساسية')->nullable();
            // gomla_price : السعر جملة بوحدة القياس الاساسية
            $table->float('gomla_price',10,2)->comment('السعر جملة بوحدة القياس الاساسية')->nullable();
            // nos_gomla_price : سعر النص جملة قطاعي مع الوحدة الاب
            $table->float('nos_gomla_price',10,2)->comment('سعر النص جملة قطاعي مع الوحدة الاساسية')->nullable();
            // ========= 2- price_retail =========
            // price_retail : السعر القطاعي بوحدة قياس التجزئه
            $table->float('price_retail',10,2)->comment('السعر القطاعي بوحدة قياس التجزئه')->nullable();
            // gomla_price_retail : السعر جملة بوحدة القياس التجزئه
            $table->float('gomla_price_retail',10,2)->comment('السعر جملة بوحدة القياس التجزئه')->nullable();
            // nos_gomla_price_retail : سعر النص جملة قطاعي مع الوحدة التجزئه
            $table->float('nos_gomla_price_retail',10,2)->comment('سعر النص جملة قطاعي مع الوحدة التجزئه')->nullable();
            // cost_price : متوسط التكلفة للصنف بوحدة القياس الاساسية
            $table->float('cost_price',10,2)->comment('متوسط التكلفة للصنف بوحدة القياس الاساسية')->nullable();
            // cost_price_retail : متوسط التكلفة للصنف بوحدة قياس التجزئه
            $table->float('cost_price_retail',10,2)->comment('متوسط التكلفة للصنف بوحدة قياس التجزئه')->nullable();
            // ========= Foreign key : inv_item_card_categories_id =========
            $table->unsignedBigInteger('inv_item_card_categories_id')->unsigned()->comment('فئة الصنف');
            $table->foreign('inv_item_card_categories_id')->references('id')->on('inv_item_card_categories')->onDelete('cascade')->comment('فئة الصنف');
            // ========= Foreign key : retail_uom_id : retail_unit_of_measurment : وحدة تجزئه =========
            $table->unsignedBigInteger('retail_uom_id')->unsigned()->comment('وحدة تجزئه ذي طبق 1 كيلو او طبق 200 جرام')->nullable();
            $table->foreign('retail_uom_id')->references('id')->on('inv_uoms')->onDelete('cascade');
            // ========= Foreign key : uom_id : unit_of_measurment : وحدة القياس الاب (الاساسية) =========
            $table->unsignedBigInteger('uom_id')->nullable()->comment('وحدة القياس الاب للصنف مثال ذي الفراخ وحدة القياس الاساسية لها ممكن شكارة او كارتونة');
            $table->foreign('uom_id')->references('id')->on('inv_uoms')->onDelete('cascade');
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
        Schema::dropIfExists('inv_item_cards');
    }
};
