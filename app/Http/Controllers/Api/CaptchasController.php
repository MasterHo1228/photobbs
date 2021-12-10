<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Mews\Captcha\Captcha;
use App\Http\Requests\Api\CaptchaRequest;

class CaptchasController extends Controller
{
    public function store(CaptchaRequest $request, Captcha $captchaBuilder)
    {
        $key = 'cacheKey-'.Str::random(15);
        $phone = $request->phone;

        $captcha = $captchaBuilder->create('flat', true);
        $expiredAt = now()->addMinutes(5);
        Cache::put($key, [
            'phone' => $phone,
            'captcha' => $captcha['key']
        ], $expiredAt);

        $result = [
            'cache_key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
            'captcha_key' => $captcha['key'],
            'captcha_img' => $captcha['img']
        ];

        return response()->json($result)->setStatusCode(201);
    }
}
