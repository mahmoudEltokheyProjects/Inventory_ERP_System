<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountsRequestUpdate extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'                   => 'required' ,
            'account_type'           => 'required' ,
            'is_parent'              => 'required' ,
            // "parent_account_number" is "required" when "is_parent" = 0
            'parent_account_number'  => 'required_if:is_parent,0' ,
            'is_archived'            => 'required' ,
        ];
    }
     /* +++++++++++++++++++++++++ messages() +++++++++++++++++++++++++ */
     public function messages()
     {
         return [
            'name.required'                     => 'اسم الحساب المالي مطلوب' ,
            'account_type.required'             => 'نوع الحساب مطلوب' ,
            'is_parent.required'                => 'اختار هل الحساب اب' ,
            'parent_account_number.required_if' => 'اختر الحساب الاب' ,
            'is_archived.required'              => 'اختار حالة الارشفة' ,
         ];
     }
}
