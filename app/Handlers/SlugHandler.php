<?php

namespace App\Handlers;

use Illuminate\Support\Str;
use App\Handlers\TranslateHandler;

class SlugHandler
{
    //纯粹创建
    public function generate($text)
    {
        return Str::slug($text);
    }

    //翻译后创建
    public function generate_with_translate($text)
    {
        return Str::slug(app(TranslateHandler::class)->translate($text));
    }
}
