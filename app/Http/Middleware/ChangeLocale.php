<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ChangeLocale
{
    public function handle($request, Closure $next)
    {
        $language = $request->header('accept-language');
        if ($language) {
            \App::setLocale($language);
        }

        return $next($request);
    }
}
