<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminPanelSettingRequest extends FormRequest
{
    /* ++++++++++++++++ authorize() ++++++++++++++++ */
    public function authorize()
    {
        return true;
    }
    /* ++++++++++++++++ rules() ++++++++++++++++ */
    public function rules()
    {
        return [
            'system_name'                       => 'required' ,
            'address'                           => 'required' ,
            'phone'                             => 'required' ,
            'customer_parent_account_number'    => 'required' ,
            'supplier_parent_account_number'    => 'required' ,
        ];
    }
    /* ++++++++++++++++ messages() ++++++++++++++++ */
    public function messages()
    {
        return [
            'system_name.required'                          => 'اسم الشركة مطلوب' ,
            'address.required'                              => 'عنوان الشركة مطلوب' ,
            'phone.required'                                => 'هاتف الشركة مطلوب' ,
            'customer_parent_account_number.required'       => 'رقم الحساب الاب للعملاء مطلوب' ,
            'supplier_parent_account_number.required'       => 'رقم الحساب الاب للموردين مطلوب' ,
        ];
    }
}
