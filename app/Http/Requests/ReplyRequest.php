<?php

namespace App\Http\Requests;

class ReplyRequest extends Request
{
    public function rules()
    {
        return [
            'content' => 'required|min:2',
        ];
    }

    public function messages()
    {
        return [
            'content.required'=>'要发评论，得写点内容哦！',
            'content.min'=>'评论内容写多点内容嘛~'
        ];
    }
}
