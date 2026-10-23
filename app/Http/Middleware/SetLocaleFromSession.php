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
     * ضبط لغة التطبيق في كافة طلبات الويب:
     * إذا كان الرابط يحتوي على لغة (/ar أو /en)، فإن الرابط هو صاحب الأولوية القصوى
     * ويتم تحديث الجلسة ولغة التطبيق فوراً من أول طلب بدون الحاجة لعمل Refresh.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $supportedLocales = LaravelLocalization::getSupportedLocales();
        $urlLocale = $request->segment(1);

        // 1. إذا قام المستخدم بكتابة لغة معينة في الرابط (مثل /ar أو /en)
        if ($urlLocale && array_key_exists($urlLocale, $supportedLocales)) {
            session(['locale' => $urlLocale]);
            App::setLocale($urlLocale);
            LaravelLocalization::setLocale($urlLocale);

            return $next($request);
        }

        // 2. إذا لم يكن هناك بادئة لغة في الرابط، نعتمد اللغة المخزنة في الجلسة
        $sessionLocale = session('locale');
        if ($sessionLocale && array_key_exists($sessionLocale, $supportedLocales)) {
            App::setLocale($sessionLocale);
            LaravelLocalization::setLocale($sessionLocale);
        }

        return $next($request);
    }
}
