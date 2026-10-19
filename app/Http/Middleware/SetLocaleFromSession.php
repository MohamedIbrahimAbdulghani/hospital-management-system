<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleFromSession
{
    /**
     * ضبط لغة التطبيق من الجلسة في كافة طلبات الويب
     */
    public function handle(Request $request, Closure $next): Response
    {
        $supportedLocales = LaravelLocalization::getSupportedLocales();
        $sessionLocale = session('locale');

        // لو فيه لغة متخزنة في السيشن ومدعومة، بنفعلها تلقائياً
        if ($sessionLocale && array_key_exists($sessionLocale, $supportedLocales)) {
            App::setLocale($sessionLocale);
            LaravelLocalization::setLocale($sessionLocale);
        }

        return $next($request);
    }
}
