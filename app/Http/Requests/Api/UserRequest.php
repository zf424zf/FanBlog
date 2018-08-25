<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            //
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'verification_key' => 'required|string',
            'verification_code' => 'required|string'
        ];
    }

    public function attributes()
    {
        //如果要使用自定义属性名称替换验证消息的 :attribute 部分，就在 resources/lang/xx/validation.php 语言文件的 attributes 数组中指定自定义名称：
        return [
            'verification_key' => '短信验证码key',
            'verification_code' => '短信验证码'
        ];
    }
}
