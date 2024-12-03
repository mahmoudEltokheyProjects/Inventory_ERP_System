<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountsRequest extends FormRequest
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
    /* +++++++++++++++++++++++++ rules() +++++++++++++++++++++++++ */
    public function rules()
    {
        return [
            'name'                   => 'required|unique:accounts,name,'.$this->id,
            'account_type'           => 'required' ,
            'is_parent'              => 'required' ,
            // "parent_account_number" is "required" when "is_parent" = 0
            'parent_account_number'  => 'required_if:is_parent,0' ,
            'start_balance_status'   => 'required' ,
            'start_balance'          => 'required|numeric|min:0',
            'is_archived'            => 'required' ,
        ];
    }
    /* +++++++++++++++++++++++++ messages() +++++++++++++++++++++++++ */
    public function messages()
    {
        return [
            'name.required'                     => 'اسم الحساب المالي مطلوب' ,
            'name.unique'                       => 'اسم الحساب المالي موجود مسبقاً' ,
            'account_type.required'             => 'نوع الحساب مطلوب' ,
            'is_parent.required'                => 'اختار هل الحساب اب' ,
            'parent_account_number.required_if' => 'اختر الحساب الاب' ,
            'start_balance_status.required'     => 'اختار حالة رصيد اول المدة' ,
            'start_balance.required'            => 'رصيد اول المدة مطلوب' ,
            'start_balance.numeric'            => 'رصيد اول المدة لابد ان يكون رقم' ,
            'start_balance.min'                 => 'رصيد اول المدة لابد ان يكون قيمة موجبة' ,
            'is_archived.required'              => 'اختار حالة الارشفة' ,
        ];
    }
}
