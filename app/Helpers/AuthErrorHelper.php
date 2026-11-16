<?php

namespace App\Helpers;

use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AuthErrorHelper
{
    /**
     * Cache for dynamic auth failure messages across supported locales.
     */
    protected static ?array $cachedAuthMessages = null;

    /**
     * Get all supported locales in the application dynamically.
     *
     * @return array<string>
     */
    public static function getSupportedLocales(): array
    {
        if (class_exists(LaravelLocalization::class)) {
            $locales = LaravelLocalization::getSupportedLocales();
            if (is_array($locales) && ! empty($locales)) {
                return array_keys($locales);
            }
        }

        return ['ar', 'en'];
    }

    /**
     * Get all known authentication error messages dynamically from lang files.
     * Everything is read directly from lang/{locale}/auth.php so editing a message in
     * the lang file automatically takes effect here without changing code.
     *
     * @return array<string>
     */
    public static function getKnownAuthMessages(): array
    {
        if (self::$cachedAuthMessages !== null) {
            return self::$cachedAuthMessages;
        }

        $locales = self::getSupportedLocales();

        // Translation keys representing authentication/session failures
        $authKeys = [
            'auth.failed',
            'auth.password',
            'auth.account_deactivated',
            'auth.must_change_password_notice',
            'auth.two_factor_invalid_simple',
            'auth.two_factor_locked',
            'auth.two_factor_resend_limit_exceeded',
        ];

        $messages = [];

        foreach ($locales as $locale) {
            foreach ($authKeys as $key) {
                $translated = trans($key, [], $locale);
                if (is_string($translated) && $translated !== $key && trim($translated) !== '') {
                    $messages[] = trim($translated);
                }
            }
        }

        return self::$cachedAuthMessages = array_values(array_unique($messages));
    }

    /**
     * Reset the cached messages (useful for unit tests or dynamic language changes).
     */
    public static function flushCache(): void
    {
        self::$cachedAuthMessages = null;
    }

    /**
     * Check if a given error message represents an authentication failure or throttling.
     * Resolves dynamically against current and supported lang files.
     */
    public static function isAuthFailureMessage(?string $message): bool
    {
        if (empty($message)) {
            return false;
        }

        $trimmed = trim($message);

        // 1. Direct match with dynamically fetched translation messages from lang/
        $knownMessages = self::getKnownAuthMessages();
        if (in_array($trimmed, $knownMessages, true)) {
            return true;
        }

        // 2. Direct match with currently active locale translations
        if ($trimmed === trim(trans('auth.failed')) ||
            $trimmed === trim(trans('auth.password')) ||
            $trimmed === trim(trans('auth.account_deactivated')) ||
            $trimmed === trim(trans('auth.two_factor_locked')) ||
            $trimmed === trim(trans('auth.two_factor_invalid_simple'))) {
            return true;
        }

        // 3. Dynamic template matches (e.g. 2FA invalid code with remaining attempts or throttling seconds)
        foreach (self::getSupportedLocales() as $locale) {
            // Check base template of auth.two_factor_invalid
            $twoFactorTemplate = trans('auth.two_factor_invalid', ['remaining' => '___PLACEHOLDER___'], $locale);
            if (is_string($twoFactorTemplate) && str_contains($twoFactorTemplate, '___PLACEHOLDER___')) {
                $parts = explode('___PLACEHOLDER___', $twoFactorTemplate);
                $prefix = trim($parts[0] ?? '');
                if ($prefix !== '' && str_starts_with($trimmed, $prefix)) {
                    return true;
                }
            }

            // Check base template of auth.throttle
            $throttleTemplate = trans('auth.throttle', ['seconds' => '___PLACEHOLDER___'], $locale);
            if (is_string($throttleTemplate) && str_contains($throttleTemplate, '___PLACEHOLDER___')) {
                $parts = explode('___PLACEHOLDER___', $throttleTemplate);
                $prefix = trim($parts[0] ?? '');
                if ($prefix !== '' && str_starts_with($trimmed, $prefix)) {
                    return true;
                }
            }
        }

        // 4. Fallback check for common throttling / 2FA keywords
        if (str_contains($trimmed, 'Too many login attempts') ||
            str_contains($trimmed, 'محاولات دخول كثيرة جداً') ||
            str_contains($trimmed, 'رمز التحقق غير صحيح') ||
            str_contains($trimmed, 'Invalid verification code')) {
            return true;
        }

        return false;
    }

    /**
     * Extract the single authentication error from errors bag, if one exists.
     */
    public static function getAuthFailure(ViewErrorBag|MessageBag|null $errors): ?string
    {
        if (! $errors || (method_exists($errors, 'any') && ! $errors->any())) {
            return null;
        }

        $bag = $errors instanceof ViewErrorBag ? $errors->getBag('default') : $errors;

        if ($bag->has('general')) {
            return $bag->first('general');
        }

        if ($bag->has('auth')) {
            return $bag->first('auth');
        }

        foreach ($bag->all() as $msg) {
            if (self::isAuthFailureMessage($msg)) {
                return $msg;
            }
        }

        return null;
    }

    /**
     * Determine if a field's inline error text should be displayed.
     * Field-specific validation errors appear inline; authentication failures do not.
     */
    public static function shouldShowInlineError(string $field, ViewErrorBag|MessageBag|null $errors): bool
    {
        if (! $errors) {
            return false;
        }

        $bag = $errors instanceof ViewErrorBag ? $errors->getBag('default') : $errors;

        if (! $bag->has($field)) {
            return false;
        }

        $fieldMessage = $bag->first($field);

        // إذا كان الخطأ خاصاً بالمصادقة فإنه يعرض في البانر العلوي فقط ولا يتكرر تحت الحقل
        return ! self::isAuthFailureMessage($fieldMessage);
    }
}
