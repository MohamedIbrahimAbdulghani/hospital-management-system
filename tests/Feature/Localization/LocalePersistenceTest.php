<?php

namespace Tests\Feature\Localization;

use App\Helpers\LocaleHelper;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LocalePersistenceTest extends TestCase
{
    use DatabaseTransactions;

    public function test_locale_switch_updates_session_and_queues_persistent_cookie(): void
    {
        $response = $this->get(route('locale.switch', 'ar'));

        $response->assertRedirect();
        $response->assertSessionHas('locale', 'ar');
        $response->assertCookie(LocaleHelper::COOKIE_NAME, 'ar');
    }

    public function test_locale_switch_to_english_updates_session_and_cookie(): void
    {
        $response = $this->get(route('locale.switch', 'en'));

        $response->assertRedirect();
        $response->assertSessionHas('locale', 'en');
        $response->assertCookie(LocaleHelper::COOKIE_NAME, 'en');
    }

    public function test_login_preserves_arabic_when_user_logs_in_with_arabic_preference(): void
    {
        $doctor = User::factory()->create([
            'role' => 'doctor',
            'email' => 'persisted_ar_doctor@hospital.com',
            'password' => Hash::make('password123'),
            'is_active' => true,
            'must_change_password' => false,
        ]);

        $response = $this->withSession(['locale' => 'ar'])
            ->withCookies([LocaleHelper::COOKIE_NAME => 'ar'])
            ->post('/login', [
                'email' => $doctor->email,
                'password' => 'password123',
            ]);

        $response->assertRedirect();
        $targetUrl = $response->headers->get('Location');

        // يجب أن يوجه المستخدم إلى الداشبورد العربي دون إجباره على الإنجليزي
        $this->assertStringContainsString('/ar/doctor/dashboard', $targetUrl);
    }

    public function test_login_preserves_english_when_user_logs_in_with_english_preference(): void
    {
        $doctor = User::factory()->create([
            'role' => 'doctor',
            'email' => 'persisted_en_doctor@hospital.com',
            'password' => Hash::make('password123'),
            'is_active' => true,
            'must_change_password' => false,
        ]);

        $response = $this->withSession(['locale' => 'en'])
            ->withCookies([LocaleHelper::COOKIE_NAME => 'en'])
            ->post('/login', [
                'email' => $doctor->email,
                'password' => 'password123',
            ]);

        $response->assertRedirect();
        $targetUrl = $response->headers->get('Location');

        // يجب أن يوجه المستخدم إلى الداشبورد الإنجليزي
        $this->assertStringContainsString('/doctor/dashboard', $targetUrl);
    }

    public function test_logout_preserves_arabic_and_redirects_to_arabic_home(): void
    {
        $user = User::factory()->create([
            'role' => 'doctor',
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)
            ->withSession(['locale' => 'ar'])
            ->withCookies([LocaleHelper::COOKIE_NAME => 'ar'])
            ->post(route('logout'));

        $response->assertRedirect();
        $targetUrl = $response->headers->get('Location');

        // التحقق من أن الخروج وجهه للمسار العربي وليس الإنجليزي الافتراضي
        $this->assertStringContainsString('/ar', $targetUrl);
        $response->assertCookie(LocaleHelper::COOKIE_NAME, 'ar');
    }

    public function test_direct_login_route_redirects_to_arabic_when_cookie_is_arabic(): void
    {
        // محاكاة إغلاق المتصفح أو التاب وفتح /login مباشرة بدون جلسة سابقة لكن مع وجود الكوكيز الدائم
        session()->forget('locale');

        $response = $this->withMiddleware([\Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class])
            ->withCookies([LocaleHelper::COOKIE_NAME => 'ar'])
            ->get('/login');

        $response->assertRedirect();
        $targetUrl = $response->headers->get('Location');

        $this->assertStringContainsString('/ar', $targetUrl);
    }
}
