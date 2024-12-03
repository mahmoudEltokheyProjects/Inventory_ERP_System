<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TreasuryRequest extends FormRequest
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
            'name'                  => 'required|unique:treasuries,name,'.$this->id,
            'is_master'             => 'required' ,
            'active'                => 'required' ,
            'last_isal_exchange'    => 'required|numeric|min:2' ,
            'last_isal_collect'     => 'required|numeric|min:2' ,
        ];
    }
    /* ++++++++++++++++ messages() ++++++++++++++++ */
    public function messages()
    {
        return [
            'name.required'          => 'اسم الخزنة مطلوب' ,
            'name.unique'            => 'اسم الخزنة موجود مسبقاً' ,
            'is_master.required'     => 'نوع الخزنة مطلوب' ,
            'active.required'         => 'حالة الخزنة مطلوب' ,
            'last_isal_exchange.required' => 'رقم ايصال الصرف مطلوب' ,
            'last_isal_exchange.numeric' => ' رقم ايصال الصرف لابد ان يكون رقم صحيح' ,
            'last_isal_exchange.min' => 'رقم ايصال الصرف لابد ان يكون رقمين علي الاقل' ,
            'last_isal_collect.required' => 'رقم ايصال التحصيل مطلوب' ,
            'last_isal_collect.numeric' => ' رقم ايصال التحصيل لابد ان يكون رقم صحيح' ,
            'last_isal_collect.min' => 'رقم ايصال التحصيل لابد ان يكون رقمين علي الاقل' ,

        ];
    }
}
