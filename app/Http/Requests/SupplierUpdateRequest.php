<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierUpdateRequest extends FormRequest
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
            'name' => 'required|unique:suppliers,name,'.$this->id ,
            'active'                 => 'required',
            'is_archived'            => 'required' ,

        ];
    }
    /* ++++++++++++++++ messages() ++++++++++++++++ */
    public function messages()
    {
        return [
            'name.required' => 'اسم المورد مطلوب' ,
            'name.unique' => 'اسم المورد موجود مسبقاً' ,
            'active.required'                   => 'حالة التفعيل مطلوبة' ,
            'is_archived.required'              => 'حالة الارشفة مطلوبة' ,
        ];
    }
}
