<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class   SuppliersWithOrdersRequest extends FormRequest
{
    /* ====================== authorize() ====================== */
    public function authorize()
    {
        return true;
    }
    /* ====================== rules() ====================== */
    public function rules()
    {
        return [
            "order_date"    => 'required' ,
            "supplier_code" => 'required' ,
            "pill_type"     => "required" ,
        ];
    }
    /* ====================== messages() ====================== */
    public function messages()
    {
        return [
            'order_date.required'     => 'تاريخ الفاتورة مطلوب'      ,
            'supplier_code.required'  => 'من فضلك اختر اسم المورد'   ,
            'pill_type.required'      => 'نوع الفاتورة مطلوب'        ,
        ];
    }
}
