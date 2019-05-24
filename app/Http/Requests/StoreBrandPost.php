<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBrandPost extends FormRequest
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
             'brand_name' => 'required|unique:brand|max:10',
             'brand_logo' => 'required',
             'brand_desc' => 'required',
             'brand_url' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'brand_name.required'=>'品牌名称不可为空',
            'brand_name.max'=>'品牌名称长度为10位',
            'brand_name.unique'=>'品牌名称已存在',
            'brand_logo.required'=>'品牌logo不可为空',
            'brand_desc.required'=>'品牌描述不可为空',
            'brand_url.required'=>'品牌网址不可为空',
        ];
    }
}
