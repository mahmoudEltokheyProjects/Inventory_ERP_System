<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierCategoriesRequest extends FormRequest
{
    /* ================== authorize ================== */
    public function authorize()
    {
        return true;
    }
    /* ================== rules ================== */
    public function rules()
    {
        return [
            'name'   => 'required|string|unique:suppliers_categories,name,'.$this->id,
            'active' => 'required' ,
        ];
    }
    /* ================== messages ================== */
    public function messages()
    {
        return [
            'name.required'     => 'اسم فئة الموردين مطلوب' ,
            'name.unique'       => 'اسم فئة الموردين موجود مسبقاً' ,
            'active.required'   => 'حالة التفعيل مطلوبة' ,

        ];
    }
}
