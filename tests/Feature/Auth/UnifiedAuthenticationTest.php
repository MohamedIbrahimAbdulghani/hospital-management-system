<?php

namespace Tests\Feature\Auth;

use App\Models\AuditLog;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\SiteSetting;
use App\Models\User;
use App\Services\Auth\TwoFactorService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Tests\TestCase;

class UnifiedAuthenticationTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        RateLimiter::clear('test@hospital.com|127.0.0.1');
        RateLimiter::clear('127.0.0.1');
    }

    public function test_welcome_screen_displays_all_required_navbar_items(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        // Check navbar links
        $response->assertSee(__('messages.nav_home'));
        $response->assertSee(__('messages.nav_about'));
        $response->assertSee(__('messages.nav_departments'));
        $response->assertSee(__('messages.nav_services'));
        $response->assertSee(__('messages.nav_doctors'));
        $response->assertSee(__('messages.nav_pharmacy'));
        $response->assertSee(__('messages.nav_medical_info'));
        $response->assertSee(__('messages.sign_in'));
        $response->assertSee(__('messages.register_patient'));
    }

    public function test_sticky_header_reads_phones_from_site_settings_and_renders_tel_links(): void
    {
        SiteSetting::set('emergency_phone', '19999');
        SiteSetting::set('hotline_phone', '16000');

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('tel:19999', false);
        $response->assertSee('tel:16000', false);
        $response->assertSee('emergency-pulse-dot', false);
        $response->assertSee('public-sticky-header', false);
    }

    public function test_login_screen_renders_without_role_dropdown(): void
    {
        $response = $this->get(route('login'));

        $response->assertOk();
        $response->assertDontSee('role-badge-card');
        $response->assertDontSee('name="role"', false);
        $response->assertSee(__('auth.login'));
        $response->assertSee(__('auth.forgot_password'));
        $response->assertSee('auth-card', false);
    }

    public function test_patient_authenticates_and_redirects_to_patient_dashboard(): void
    {
        $email = 'patient_' . Str::random(8) . '@hospital.com';
        $patient = User::factory()->create([
            'email' => $email,
            'phone' => '010' . rand(10000000, 99999999),
            'password' => Hash::make('password123'),
            'role' => 'patient',
            'is_active' => true,
            'must_change_password' => false,
        ]);
        $patient->assignRole('patient');

        $response = $this->post(route('login.store'), [
            'email' => $email,
            'password' => 'password123',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertAuthenticatedAs($patient);
        $response->assertRedirect(route('patient.dashboard'));

        // Check audit log
        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $patient->id,
            'email' => $email,
            'action' => 'login_success',
        ]);
    }

    public function test_user_can_login_using_phone_number(): void
    {
        $phone = '011' . rand(10000000, 99999999);
        $patient = User::factory()->create([
            'email' => 'phone_' . Str::random(8) . '@hospital.com',
            'phone' => $phone,
            'password' => Hash::make('password123'),
            'role' => 'patient',
            'is_active' => true,
            'must_change_password' => false,
        ]);
        $patient->assignRole('patient');

        $response = $this->post(route('login.store'), [
            'email' => $phone,
            'password' => 'password123',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertAuthenticatedAs($patient);
        $response->assertRedirect(route('patient.dashboard'));
    }

    public function test_admin_requires_mandatory_2fa_before_opening_session(): void
    {
        $email = 'admin_' . Str::random(8) . '@hospital.com';
        $admin = User::factory()->create([
            'email' => $email,
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'is_active' => true,
            'must_change_password' => false,
        ]);
        $admin->assignRole('admin');

        $response = $this->post(route('login.store'), [
            'email' => $email,
            'password' => 'password123',
        ]);

        // Session not yet opened
        $this->assertGuest();
        $response->assertRedirect(route('two-factor.login'));
        $this->assertTrue(session()->has('login.id'));

        // Verify audit log recorded 2fa_challenged
        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $admin->id,
            'email' => $email,
            'action' => '2fa_challenged',
        ]);
    }

    public function test_doctor_authenticates_directly_without_2fa_and_redirects_to_doctor_dashboard(): void
    {
        $email = 'doctor_' . Str::random(8) . '@hospital.com';
        $doctor = User::factory()->create([
            'email' => $email,
            'password' => Hash::make('password123'),
            'role' => 'doctor',
            'is_active' => true,
            'must_change_password' => false,
        ]);
        $doctor->assignRole('doctor');

        $response = $this->post(route('login.store'), [
            'email' => $email,
            'password' => 'password123',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertAuthenticatedAs($doctor);
        $response->assertRedirect(route('doctor.dashboard'));
    }

    public function test_admin_completes_2fa_and_redirects_to_admin_dashboard(): void
    {
        $email = 'admin_' . Str::random(8) . '@hospital.com';
        $admin = User::factory()->create([
            'email' => $email,
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'is_active' => true,
            'must_change_password' => false,
        ]);
        $admin->assignRole('admin');

        $this->post(route('login.store'), [
            'email' => $email,
            'password' => 'password123',
        ]);

        $twoFactorService = app(TwoFactorService::class);
        $otp = $twoFactorService->generateAndSendOtp($admin);

        $response = $this->withSession(['login.id' => $admin->id])
            ->post(route('two-factor.login.store'), [
                'code' => $otp,
            ]);

        $response->assertSessionHasNoErrors();
        $this->assertAuthenticatedAs($admin);
        $response->assertRedirect(route('admin.dashboard'));

        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $admin->id,
            'action' => '2fa_success',
        ]);
    }

    public function test_all_login_failures_return_same_generic_message_without_disclosing_cause(): void
    {
        // 1. Non-existent email
        $res1 = $this->post(route('login.store'), [
            'email' => 'nobody_' . Str::random(8) . '@hospital.com',
            'password' => 'secret',
        ]);
        $res1->assertSessionHasErrors('email');
        $msg1 = session('errors')->first('email');

        // 2. Existing user with wrong password
        $user = User::factory()->create([
            'email' => 'active_' . Str::random(8) . '@hospital.com',
            'password' => Hash::make('correct_password'),
            'is_active' => true,
        ]);
        $res2 = $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'wrong_password',
        ]);
        $res2->assertSessionHasErrors('email');
        $msg2 = session('errors')->first('email');

        // 3. Deactivated user with correct password
        $deactivated = User::factory()->create([
            'email' => 'deact_' . Str::random(8) . '@hospital.com',
            'password' => Hash::make('correct_password'),
            'is_active' => false,
        ]);
        $res3 = $this->post(route('login.store'), [
            'email' => $deactivated->email,
            'password' => 'correct_password',
        ]);
        $res3->assertSessionHasErrors('email');
        $msg3 = session('errors')->first('email');

        // All three must be identical generic error
        $this->assertEquals($msg1, $msg2);
        $this->assertEquals($msg2, $msg3);
        $this->assertEquals(__('auth.failed'), $msg1);
    }

    public function test_intended_url_is_respected_only_when_compatible(): void
    {
        $patient = User::factory()->create([
            'email' => 'patient_int_' . Str::random(8) . '@hospital.com',
            'password' => Hash::make('password123'),
            'role' => 'patient',
            'is_active' => true,
            'must_change_password' => false,
        ]);
        $patient->assignRole('patient');

        // Patient tried to access admin dashboard -> incompatible!
        session()->put('url.intended', route('admin.dashboard'));

        $response = $this->post(route('login.store'), [
            'email' => $patient->email,
            'password' => 'password123',
        ]);

        // Incompatible intended url is discarded; patient goes to patient dashboard
        $response->assertRedirect(route('patient.dashboard'));
    }

    public function test_public_registration_forces_patient_role_and_ignores_client_injection(): void
    {
        $email = 'newpatient_' . Str::random(8) . '@hospital.com';

        $response = $this->post(route('register.store'), [
            'name' => 'خالد محمود عبدالسلام',
            'email' => $email,
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'phone' => '01012345678',
            'national_id' => '2980101' . rand(1000000, 9999999),
            'gender' => 'male',
            'date_of_birth' => '1995-05-15',
            'role' => 'admin', // Malicious attempt to self-promote to admin
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $email,
            'role' => 'patient', // Server strictly forced patient
        ]);

        $createdUser = User::where('email', $email)->first();
        $this->assertTrue($createdUser->hasRole('patient'));
        $this->assertFalse($createdUser->hasRole('admin'));
    }

    public function test_user_with_must_change_password_is_intercepted(): void
    {
        $staff = User::factory()->create([
            'email' => 'staff_temp_' . Str::random(8) . '@hospital.com',
            'password' => Hash::make('temp123'),
            'role' => 'hr',
            'is_active' => true,
            'must_change_password' => true,
        ]);
        $staff->assignRole('hr');

        $response = $this->actingAs($staff)->get(route('hr.dashboard'));

        $response->assertRedirect(route('password.change.force'));
    }

    public function test_two_factor_roles_configuration_is_respected(): void
    {
        $twoFactorService = app(TwoFactorService::class);

        $admin = User::factory()->make(['role' => 'admin']);
        $doctor = User::factory()->make(['role' => 'doctor']);
        $patient = User::factory()->make(['role' => 'patient']);

        // Default: admin only
        config(['hospital.two_factor_roles' => ['admin']]);
        $this->assertTrue($twoFactorService->isTwoFactorRequired($admin));
        $this->assertFalse($twoFactorService->isTwoFactorRequired($doctor));
        $this->assertFalse($twoFactorService->isTwoFactorRequired($patient));

        // Config changed to doctor only
        config(['hospital.two_factor_roles' => ['doctor']]);
        $this->assertFalse($twoFactorService->isTwoFactorRequired($admin));
        $this->assertTrue($twoFactorService->isTwoFactorRequired($doctor));

        // Restore default
        config(['hospital.two_factor_roles' => ['admin']]);
    }

    public function test_authentication_failure_renders_error_once_in_alert_banner_and_not_inline(): void
    {
        $email = 'unknown_' . Str::random(8) . '@hospital.com';

        $viewResponse = $this->followingRedirects()
            ->from(route('login'))
            ->post(route('login.store'), [
                'email' => $email,
                'password' => 'wrongpassword',
            ]);

        $viewResponse->assertOk();
        $content = $viewResponse->getContent();

        // Error message appears in the top alert banner
        $errorMessage = trans('auth.failed');
        $this->assertStringContainsString($errorMessage, $content);

        // Count occurrences of the message in the entire rendered HTML
        $count = substr_count($content, $errorMessage);
        $this->assertEquals(1, $count, "The auth failure error message must appear exactly once in the rendered HTML.");
    }

    public function test_field_validation_error_renders_inline_only_and_not_in_top_alert_banner(): void
    {
        $viewResponse = $this->followingRedirects()
            ->from(route('login'))
            ->post(route('login.store'), [
                'email' => '',
                'password' => '',
            ]);

        $viewResponse->assertOk();

        // Top auth alert banner should NOT be rendered when errors are only field validation errors
        $viewResponse->assertDontSee('alert-danger');

        // Field inline feedback should be visible under the fields
        $viewResponse->assertSee('invalid-feedback');
    }

    public function test_two_factor_challenge_page_redesign_renders_required_elements(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        $response = $this->withSession(['login.id' => $admin->id])
            ->get(route('two-factor.login'));

        $response->assertOk();
        $response->assertSee('two-factor-card');
        $response->assertSee('otp-digit-box');
        $response->assertSee('two-factor-shield-icon');
        $response->assertSee('toggle-recovery-link');
        $response->assertSee(__('auth.two_factor_badge'));
        $response->assertDontSee('Mandatory for Medical & Admin Staff');
    }

    public function test_demo_2fa_code_is_only_rendered_when_local_and_debug_enabled(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        // When debug is false, demo code notice should NOT render
        config(['app.debug' => false]);

        $response = $this->withSession([
            'login.id' => $admin->id,
            'demo_2fa_code' => '428706',
        ])->get(route('two-factor.login'));

        $response->assertDontSee('428706');

        // Restore config
        config(['app.debug' => true]);
    }
}

