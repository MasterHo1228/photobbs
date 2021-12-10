<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class VerificationCodeRequest extends FormRequest
{

    public function attributes()
    {
        return [
            'captcha_key' => 'required|string',
            'captcha_code' => 'required|string',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'captcha_key' => 'required|string',
            'captcha_code' => 'required|string',
        ];
    }
}
