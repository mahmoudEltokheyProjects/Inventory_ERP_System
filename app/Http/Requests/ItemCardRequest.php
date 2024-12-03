<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemCardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    /* ++++++++++++++++ rules() ++++++++++++++++ */
    public function rules()
    {
        return [
            'name'                      => 'required|unique:inv_item_cards,name,'.$this->id ,
            'item_type'                 => 'required' ,
            'inv_itemCard_category_id'  => 'required' ,
            'inv_uom_parent_id'         => 'required' ,
            'does_has_retail_unit'      => 'required' ,
            // "retial_uom_id" inputField will be "required" if "does_has_retail_unit" inputField value is equal to 1
            'retail_uom_id'             => 'required_if:does_has_retail_unit,1' ,
        ];
    }
    /* ++++++++++++++++ messages() ++++++++++++++++ */
    public function messages()
    {
        return [
            'name.required'                     => 'اسم الصنف مطلوب'  ,
            'name.unique'                       => 'اسم الصنف موجود مسبقاً'  ,
            'item_type.required'                => 'نوع الصنف مطلوب' ,
            'inv_itemCard_category_id.required' => 'فئة الصنف مطلوب' ,
            'inv_uom_parent_id.required'        => 'وحدة القياس الاب مطلوب' ,
            'active.required'                   => 'حالة تفعيل الفئة مطلوب' ,
            'does_has_retail_unit.required'     => 'وحدة القياس الاب مطلوب' ,
            'retial_uom_id.required_if'         => 'وحدة القياس التجزئه الابن بالنسبة للاب مطلوب' ,
            'retail_uom_to_uom.required_if'     => ' عدد وحدات التجزئه بالوحدة الاب مطلوب' ,
            'price.required'                    => 'السعر القطاعي بوحدة القياس الاساسية مطلوب' ,
            'nos_gomla_price.required'          => 'سعر النص جملة قطاعي مع الوحدة الاساسية مطلوب' ,
            'gomla_price.required'              => 'سعر الجملة بوحدة القياس الاساسية مطلوب' ,
            'cost_price.required'               => 'سعر تكلفة الشراء للصنف بوحدة القياس الاساسية مطلوب' ,
            'price_retail.required_if'          => 'السعر القطاعي بوحدة قياس التجزئه مطلوب' ,
            'nos_gomla_price_retail.required_if'=> 'سعر النص جملة قطاعي مع الوحدة التجزئه مطلوب' ,
            'gomla_price_retail.required_if'    => 'سعر الجملة بوحدة القياس التجزئه  مطلوب' ,
            'cost_price_retail.required_if'     => 'سعر تكلفة الشراء للصنف بوحدة قياس التجزئه مطلوب' ,
            'has_fixed_price.required'          => 'من فضلك اختار هل للصنف سعر ثابت' ,
            'Item_img.required'                 => 'من فضلك ارفع صورة' ,
        ];
    }
}
