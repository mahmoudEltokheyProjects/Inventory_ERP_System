<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
    /* ++++++++++++++++++++++ rules() ++++++++++++++++++++++ */
    public function rules()
    {
        return [
            'name'                      => 'required|unique:suppliers,name,'.$this->id ,
            'supplier_categories_id'   => 'required' ,
            'active'                    => 'required' ,
            'start_balance_status'      => 'required' ,
            'start_balance'             => 'required|numeric|min:0',
            'is_archived'               => 'required' ,
        ];
    }
    /* ++++++++++++++++++++++ messages() ++++++++++++++++++++++ */
    public function messages()
    {
        return [
            'name.required'                     => 'اسم المورد مطلوب',
            'name.unique'                       => 'اسم المورد موجود مسبقاً' ,
            'supplier_categories_id.required'  => 'فئة المورد مطلوبة',
            'active.required'                   => 'حالة التفعيل مطلوبة' ,
            'start_balance_status.required'     => 'اختار حالة رصيد اول المدة' ,
            'start_balance.required'            => 'رصيد اول المدة مطلوب' ,
            'start_balance.numeric'             => 'رصيد اول المدة لابد ان يكون رقم' ,
            'start_balance.min'                 => 'رصيد اول المدة لابد ان يكون قيمة موجبة' ,
            'is_archived.required'              => 'حالة الارشفة مطلوبة' ,
        ];
    }
}
