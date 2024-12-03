<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
    /* +++++++++++++++++ rules() +++++++++++++++++ */
    public function rules()
    {
        return [
            'name'      => 'required|unique:stores,name,'.$this->id ,
            'active'    => 'required',
        ];
    }
    /* +++++++++++++++++ messages() +++++++++++++++++ */
    public function messages()
    {
        return [
            'name.required' => 'اسم المخزن مطلوب' ,
            'name.unique' => 'هذا الحقل موجود مسبقاً' ,
            'active.required' => 'حالة المخزن مطلوب' ,
        ];
    }
}
