<?php

namespace App\Helpers;

use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;

class AuthErrorHelper
{
    /**
     * Known authentication failure error patterns in all supported locales.
     */
    protected static array $authFailurePhrases = [
        'These credentials do not match our records.',
        'بيانات الدخول غير صحيحة.',
        'The provided password is incorrect.',
        'كلمة المرور المستخدمة غير صحيحة.',
        'This account has been deactivated. Please contact administration.',
        'تم تعطيل هذا الحساب. يرجى التواصل مع إدارة المستشفى.',
        'The provided two-factor authentication code was invalid.',
        'The provided two factor authentication code was invalid.',
        'رمز التحقق غير صحيح أو انتهت صلاحيته.',
        'Your login session was canceled due to exceeding the maximum allowed attempts. Please sign in again.',
        'تم إلغاء جلسة تسجيل الدخول بسبب استنفاد الحد الأقصى للمحاولات الخاطئة. يرجى تسجيل الدخول مجدداً.',
    ];

    /**
     * Check if a given error message represents an authentication failure or throttling.
     */
    public static function isAuthFailureMessage(?string $message): bool
    {
        if (empty($message)) {
            return false;
        }

        $trimmed = trim($message);

        // التحقق من رسائل الترجمة الحالية
        if ($trimmed === trim(trans('auth.failed')) ||
            $trimmed === trim(trans('auth.password')) ||
            $trimmed === trim(trans('auth.account_deactivated')) ||
            $trimmed === trim(trans('auth.two_factor_invalid')) ||
            $trimmed === trim(trans('auth.two_factor_locked'))) {
            return true;
        }

        // التحقق من رسائل رمز التحقق بخطوتين متغيرة المحاولات المتبقية
        if (str_contains($trimmed, 'رمز التحقق غير صحيح') ||
            str_contains($trimmed, 'Invalid verification code') ||
            str_contains($trimmed, 'Remaining attempts') ||
            str_contains($trimmed, 'المحاولات المتبقية')) {
            return true;
        }

        // التحقق من القائمة المعيارية للعبارات
        foreach (self::$authFailurePhrases as $phrase) {
            if ($trimmed === trim($phrase)) {
                return true;
            }
        }

        // التحقق من رسائل تجاوز المحاولات Throttling
        if (str_contains($trimmed, 'Too many login attempts') ||
            str_contains($trimmed, 'محاولات دخول كثيرة جداً') ||
            str_contains($trimmed, 'Please try again in') ||
            str_contains($trimmed, 'يرجى المحاولة مرة أخرى')) {
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
