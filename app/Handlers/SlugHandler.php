<?php

namespace App\Handlers;

use Illuminate\Support\Str;
use App\Handlers\TranslateHandler;

class SlugHandler
{
    public function generate($text)
    {
        return Str::slug($text);
    }

    public function generate_with_translate($text)
    {
        return Str::slug(app(TranslateHandler::class)->translate($text));
    }
}
