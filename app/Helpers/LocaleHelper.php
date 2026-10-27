<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class LocaleHelper
{
    /**
     * اسم الكوكيز الدائم لحفظ لغة المستخدم المفضلة عبر الجلسات والتبويبات
     */
    public const COOKIE_NAME = 'app_locale';

    /**
     * مدة صلاحية كوكيز اللغة بالدقائق (5 سنوات = دائم)
     */
    public const COOKIE_LIFETIME_MINUTES = 60 * 24 * 365 * 5;

    /**
     * التحقق مما إذا كان كود اللغة مدعوماً في النظام
     */
    public static function isValidLocale(?string $locale): bool
    {
        if (empty($locale) || ! is_string($locale)) {
            return false;
        }

        $supported = self::getSupportedLocales();

        return array_key_exists($locale, $supported);
    }

    /**
     * الحصول على قائمة اللغات المدعومة
     *
     * @return array<string, mixed>
     */
    public static function getSupportedLocales(): array
    {
        if (class_exists(LaravelLocalization::class)) {
            return LaravelLocalization::getSupportedLocales();
        }

        return [
            'ar' => ['name' => 'Arabic', 'native' => 'العربية'],
            'en' => ['name' => 'English', 'native' => 'English'],
        ];
    }

    /**
     * استخراج وتحديد اللغة الحالية أو المفضلة للمستخدم حسب الأولوية:
     * 1. مقطع الرابط الأول إذا كان (/ar أو /en)
     * 2. الجلسة (Session)
     * 3. الكوكيز الدائم (Cookie)
     * 4. اللغة الحالية للتطبيق / الافتراضية
     */
    public static function getLocale(?Request $request = null): string
    {
        $request = $request ?: request();

        // 1. فحص مقطع الرابط الأول
        $urlSegment = $request->segment(1);
        if (self::isValidLocale($urlSegment)) {
            return $urlSegment;
        }

        // 2. فحص جلسة المستخدم الحالية
        $sessionLocale = session('locale');
        if (self::isValidLocale($sessionLocale)) {
            return $sessionLocale;
        }

        // 3. فحص الكوكيز الدائم (في حال إغلاق التاب وإعادة فتحه أو بعد تسجيل الخروج)
        $cookieLocale = $request->cookie(self::COOKIE_NAME);
        if (self::isValidLocale($cookieLocale)) {
            return $cookieLocale;
        }

        // 4. لغة التطبيق الحالية
        $appLocale = App::getLocale();
        if (self::isValidLocale($appLocale)) {
            return $appLocale;
        }

        return config('app.locale', 'ar');
    }

    /**
     * تثبيت لغة المستخدم في الجلسة والكوكيز الدائم ومحرك الترجمة
     */
    public static function rememberLocale(string $locale, ?Request $request = null): void
    {
        if (! self::isValidLocale($locale)) {
            $locale = config('app.fallback_locale', 'en');
        }

        // 1. تحديث الجلسة
        session(['locale' => $locale]);

        // 2. إرفاق كوكيز دائم (ساري لسنوات وغير مرتبط بإغلاق المتصفح)
        cookie()->queue(cookie()->make(
            self::COOKIE_NAME,
            $locale,
            self::COOKIE_LIFETIME_MINUTES,
            '/',
            null,
            false,
            false,
            false,
            'lax'
        ));

        // 3. تحديث محرك الترجمة للطلب الحالي
        App::setLocale($locale);

        if (class_exists(LaravelLocalization::class)) {
            LaravelLocalization::setLocale($locale);
        }
    }
}
