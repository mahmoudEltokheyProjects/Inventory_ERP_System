<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /* +++++++++++++++ authorize() +++++++++++++++ */
    public function authorize()
    {
        return true;
    }
    /* +++++++++++++++ rules() +++++++++++++++ */
    public function rules()
    {
        return [
            'email' => 'required',
            'password' => 'required',
        ];
    }
    /* +++++++++++++++ messages() +++++++++++++++ */
    public function messages()
    {
        return [
            'email.required' => 'البريد الالكتروني مطلوب',
            'password.required' => 'كلمة المرور مطلوبه',
        ];
    }
}
