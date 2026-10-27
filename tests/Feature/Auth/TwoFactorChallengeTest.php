<?php

namespace Tests\Feature\Auth;

use App\Models\AuditLog;
use App\Models\User;
use App\Services\Auth\TwoFactorService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class TwoFactorChallengeTest extends TestCase
{
    use DatabaseTransactions;

    protected TwoFactorService $twoFactorService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\PreventRequestForgery::class]);
        $this->twoFactorService = app(TwoFactorService::class);
    }


    protected function createAdminUser(): User
    {
        $admin = User::factory()->create([
            'email' => 'admin_test_' . Str::random(8) . '@hospital.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'is_active' => true,
            'must_change_password' => false,
        ]);
        $admin->assignRole('admin');

        return $admin;
    }

    /**
     * يحاكي تسجيل دخول مدير النظام وبدء جلسة التحقق بخطوتين
     */
    protected function loginAsAdminInitiated(): array
    {
        $admin = $this->createAdminUser();

        $this->post(route('login.store'), [
            'email' => $admin->email,
            'password' => 'password123',
        ]);

        $otp = $this->twoFactorService->getDemoCode($admin);

        return [$admin, $otp];
    }

    public function test_dev_otp_persists_in_demo_ribbon_after_wrong_attempt_in_local_environment(): void
    {
        $this->app['env'] = 'local';
        [$admin, $otp] = $this->loginAsAdminInitiated();

        $this->assertNotEmpty($otp);

        // محاولة إدخال كود خاطئ
        $response = $this->from(route('two-factor.login'))
            ->post(route('two-factor.login.store'), [
                'code' => '000000',
            ]);

        $response->assertSessionHasErrors('code');
        $this->assertGuest();

        // التأكد من أن الكود الصحيح ما زال ظاهراً في الصفحة التجريبية بعد الخطأ
        $pageResponse = $this->get(route('two-factor.login'));

        $pageResponse->assertOk();
        $pageResponse->assertSee($otp);
        $pageResponse->assertSee('demo-otp-badge-card');

        // التأكد من تسجيل الحدث الأمني بدون إدراج الكود
        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $admin->id,
            'action' => '2fa_failed',
        ]);

        $log = AuditLog::where('user_id', $admin->id)->where('action', '2fa_failed')->first();
        $this->assertNotNull($log);
        $this->assertStringNotContainsString($otp, json_encode($log->details));
    }

    public function test_session_is_locked_and_redirects_to_login_after_5_failed_attempts(): void
    {
        config(['hospital.two_factor_max_attempts' => 5]);
        [$admin] = $this->loginAsAdminInitiated();

        // إدخال 4 محاولات خاطئة
        for ($i = 1; $i <= 4; $i++) {
            $res = $this->from(route('two-factor.login'))
                ->post(route('two-factor.login.store'), [
                    'code' => '11111' . $i,
                ]);

            $res->assertSessionHasErrors('code');
            $this->assertEquals($i, Cache::get("2fa_attempts_{$admin->id}"));
        }

        // المحاولة الخامسة (استنفاد الحد الأقصى)
        $res5 = $this->from(route('two-factor.login'))
            ->post(route('two-factor.login.store'), [
                'code' => '999999',
            ]);

        // يجب تحويل المستخدم لصفحة تسجيل الدخول وإلغاء جلسة التحقق
        $res5->assertRedirect(route('login'));
        $res5->assertSessionHasErrors('email');
        $this->assertGuest();

        // التأكد من مسح session login.id
        $this->assertNull(session('login.id'));

        // التأكد من تسجيل الحدث الأمني 2fa_locked
        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $admin->id,
            'action' => '2fa_locked',
        ]);

        $lockedLog = AuditLog::where('user_id', $admin->id)->where('action', '2fa_locked')->first();
        $this->assertNotNull($lockedLog);
        $this->assertEquals('max_failed_attempts_exceeded', $lockedLog->details['reason']);
    }

    public function test_resend_generates_new_code_and_invalidates_previous_code(): void
    {
        $this->app['env'] = 'local';
        [$admin, $code1] = $this->loginAsAdminInitiated();

        // طلب كود جديد عبر مسار resend
        $resendResponse = $this->postJson(route('two-factor.resend'));

        $resendResponse->assertOk();
        $resendResponse->assertJson([
            'success' => true,
        ]);

        $code2 = $resendResponse->json('demo_code');
        $this->assertNotEmpty($code2);
        $this->assertNotEquals($code1, $code2);

        // تجربة الكود القديم: يجب أن يفشل
        $oldAttempt = $this->from(route('two-factor.login'))
            ->post(route('two-factor.login.store'), [
                'code' => $code1,
            ]);
        $oldAttempt->assertSessionHasErrors('code');
        $this->assertGuest();

        // تجربة الكود الجديد: يجب أن ينجح ويدخل المستخدم
        $newAttempt = $this->post(route('two-factor.login.store'), [
            'code' => $code2,
        ]);

        $newAttempt->assertSessionHasNoErrors();
        $this->assertAuthenticatedAs($admin);

        // التأكد من تسجيل 2fa_resent
        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $admin->id,
            'action' => '2fa_resent',
        ]);
    }

    public function test_resend_is_throttled_by_30_seconds_server_cooldown(): void
    {
        [$admin] = $this->loginAsAdminInitiated();

        // الإرسال الأول ينجح
        $first = $this->postJson(route('two-factor.resend'));
        $first->assertOk();
        $this->assertEquals(30, $first->json('cooldown'));

        // الإرسال الثاني مباشرة خلال الـ 30 ثانية يجب أن يُرفض بكود 429
        $second = $this->postJson(route('two-factor.resend'));

        $second->assertStatus(429);
        $second->assertJson([
            'success' => false,
        ]);
        $this->assertGreaterThan(0, $second->json('cooldown'));
    }

    public function test_resend_is_rate_limited_to_max_3_times_per_window(): void
    {
        config(['hospital.two_factor_max_resends' => 3]);
        [$admin] = $this->loginAsAdminInitiated();

        // تكرار الإرسال 3 مرات مع تصفير الـ cooldown لاختبار الـ RateLimiter
        for ($i = 1; $i <= 3; $i++) {
            Cache::forget("2fa_resend_cooldown_{$admin->id}");
            $res = $this->postJson(route('two-factor.resend'));
            $res->assertOk();
        }

        // المحاولة الرابعة يجب أن تُرفض لتجاوز الحد الأقصى (3 مرات)
        Cache::forget("2fa_resend_cooldown_{$admin->id}");
        $fourth = $this->postJson(route('two-factor.resend'));

        $fourth->assertStatus(429);
        $this->assertFalse($fourth->json('success'));
    }

    public function test_failed_attempts_counter_is_not_reset_by_resend(): void
    {
        config(['hospital.two_factor_max_attempts' => 5]);
        [$admin] = $this->loginAsAdminInitiated();

        // محاولتان خاطئتان
        $this->from(route('two-factor.login'))->post(route('two-factor.login.store'), ['code' => '111111']);
        $this->from(route('two-factor.login'))->post(route('two-factor.login.store'), ['code' => '222222']);

        $this->assertEquals(2, Cache::get("2fa_attempts_{$admin->id}"));

        // طلب كود جديد
        Cache::forget("2fa_resend_cooldown_{$admin->id}");
        $this->postJson(route('two-factor.resend'));

        // التأكد من أن عداد المحاولات الخاطئة لم يتصفر وما زال 2
        $this->assertEquals(2, Cache::get("2fa_attempts_{$admin->id}"));

        // إدخال 3 محاولات خاطئة إضافية للوصول للمجموع 5
        $this->from(route('two-factor.login'))->post(route('two-factor.login.store'), ['code' => '333333']);
        $this->from(route('two-factor.login'))->post(route('two-factor.login.store'), ['code' => '444444']);
        $lockoutAttempt = $this->from(route('two-factor.login'))->post(route('two-factor.login.store'), ['code' => '555555']);

        // يجب قفل الجلسة وتحويل المستخدم لصفحة تسجيل الدخول
        $lockoutAttempt->assertRedirect(route('login'));
        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $admin->id,
            'action' => '2fa_locked',
        ]);
    }

    public function test_dev_otp_ribbon_is_never_rendered_in_production_environment(): void
    {
        $this->app['env'] = 'production';
        $admin = $this->createAdminUser();

        $otp = $this->twoFactorService->generateAndSendOtp($admin);

        $response = $this->withSession(['login.id' => $admin->id])
            ->get(route('two-factor.login'));

        $response->assertOk();
        $response->assertDontSee($otp);
        $response->assertDontSee('id="demo-otp-card"', false);
        $response->assertDontSee(__('auth.dev_otp_label'));
    }
}
