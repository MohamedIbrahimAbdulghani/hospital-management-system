<?php

namespace App\Actions\Localization;

use Illuminate\Support\Facades\App;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class SwitchLocaleAction
{
    /**
     * تبديل لغة التطبيق وحفظها في السيشن وتحديد رابط التحويل المناسب
     *
     * @param string $locale كود اللغة المراد التحويل إليها
     * @param string|null $previousUrl الرابط السابق للعودة إليه
     * @return string الرابط المترجم
     */
    public function execute(string $locale, ?string $previousUrl = null): string
    {
        $supportedLocales = LaravelLocalization::getSupportedLocales();

        // لو كود اللغة مش مدعوم، بنعتمد اللغة الافتراضية
        if (! array_key_exists($locale, $supportedLocales)) {
            $locale = config('app.fallback_locale', 'en');
        }

        // هنا بنحفظ اللغة في السيشن وبنحدث لغة التطبيق الحالية
        session(['locale' => $locale]);
        App::setLocale($locale);
        LaravelLocalization::setLocale($locale);

        $previousUrl = $previousUrl ?: url()->previous();
        $root = request()->root();

        // إذا كان الرابط السابق من نفس موقعنا
        if (str_starts_with($previousUrl, $root)) {
            $path = trim((string) parse_url($previousUrl, PHP_URL_PATH), '/');

            // استخراج أول مقطع في المسار لمعرفة ما إذا كان يمثل لغة سابقة
            $segments = explode('/', $path);
            if (! empty($segments) && array_key_exists($segments[0], $supportedLocales)) {
                array_shift($segments);
            }
            $cleanPath = implode('/', $segments);

            // لو الصفحة من صفحات المصادقة (Auth) التي لا تحتوي على بادئة لغة
            $unprefixedRoutes = ['login', 'register', 'forgot-password', 'reset-password'];
            if (in_array($cleanPath, $unprefixedRoutes, true) || str_starts_with($cleanPath, 'reset-password/')) {
                return $previousUrl;
            }

            try {
                return LaravelLocalization::getLocalizedURL($locale, $previousUrl, [], true);
            } catch (\Throwable) {
                return $previousUrl;
            }
        }

        return LaravelLocalization::getLocalizedURL($locale, route('home'), [], true);
    }
}
