<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserPost extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
             'user_name' => 'required|unique:user|between:2,4',
             'user_pwd' => 'required|same:user_pswd|alpha_dash',
             'user_pswd' => 'required',
             'user_position' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'user_name.required'=>'名称不可为空',
            'user_name.unique'=>'名称已存在',
            'user_name.required'=>'名称长度在2~4之间',
            'user_pwd.required'=>'密码不可为空',
            'user_pwd.same'=>'两次密码请保持一致',
            'user_pwd.alpha_dash'=>'名称不可为空',
            'user_pswd.required'=>'确认密码不可为空',
            'user_position.required'=>'职位不可为空',
        ];
    }
}
