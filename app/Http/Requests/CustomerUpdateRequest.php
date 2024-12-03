<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerUpdateRequest extends FormRequest
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
    /* ++++++++++++++++++++++++++++ rules() ++++++++++++++++++++++++++++ */
    public function rules()
    {
        return [
            'name'                   => 'required|unique:customers,name,'.$this->id,
            'active'                 => 'required',
            'is_archived'            => 'required' ,
        ];
    }
    /* ++++++++++++++++++++++++++++ messages() ++++++++++++++++++++++++++++ */
    public function messages()
    {
        return [
            'name.required'                     => 'اسم العميل مطلوب' ,
            'name.unique'                       => 'اسم العميل موجود مسبقاً' ,
            'active.required'                   => 'حالة التفعيل مطلوبة' ,
            'is_archived.required'              => 'حالة الارشفة مطلوبة' ,
        ];
    }
}
