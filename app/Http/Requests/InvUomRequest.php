<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvUomRequest extends FormRequest
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
            'name'                  => 'required|unique:inv_uoms,name,'.$this->id,
            'is_master'             => 'required' ,
            'active'                => 'required' ,
        ];
    }
    /* ++++++++++++++++ messages() ++++++++++++++++ */
    public function messages()
    {
        return [
            'name.required'          => 'اسم الوحدة مطلوب' ,
            'name.unique'            => 'اسم الوحدة موجود مسبقاً' ,
            'is_master.required'     => 'نوع الوحدة مطلوب' ,
            'active.required'         => 'حالة الوحدة مطلوب' ,
        ];
    }
}
