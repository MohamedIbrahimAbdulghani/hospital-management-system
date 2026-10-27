<?php

namespace App\Http\Middleware;

use App\Helpers\LocaleHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleFromSession
{
    /**
     * ضبط لغة التطبيق في كافة طلبات الويب مع دعم الاستمرارية عبر الجلسات والتبويبات:
     * 1. إذا كان الرابط يحتوي على بادئة (/ar أو /en)، يتم اعتمادها وحفظها في السيشن والكوكيز الدائم.
     * 2. إذا لم يكن هناك بادئة في الرابط (مثل / أو /login)، نعتمد السيشن، وإذا كانت فارغة (عند إغلاق التاب أو بعد الخروج)،
     *    نستعيد اللغة من الكوكيز الدائم ونحفظها في السيشن حتى يتمكن LaravelLocalization من توجيهه تلقائياً لنفس اللغة.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $urlLocale = $request->segment(1);

        // 1. إذا كان الرابط يحتوي على بادئة لغة صريحة (/ar أو /en)
        if (LocaleHelper::isValidLocale($urlLocale)) {
            LocaleHelper::rememberLocale($urlLocale, $request);

            return $next($request);
        }

        // 2. إذا لم تكن هناك بادئة لغة في الرابط، نفحص السيشن ثم الكوكيز الدائم
        $locale = LocaleHelper::getLocale($request);

        // تثبيت اللغة المسترجعة في السيشن ومحرك الترجمة حتى تراها الـ Middleware التالية
        LocaleHelper::rememberLocale($locale, $request);

        return $next($request);
    }
}
