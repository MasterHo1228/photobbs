<?php

namespace App\Handlers;

use Illuminate\Support\Str;

class SlugHandler
{
    public function generate($text)
    {
        return Str::slug($text);
    }
}
