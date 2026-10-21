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
            'phone' => '050' . rand(1000000, 9999999),
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
        $phone = '055' . rand(1000000, 9999999);
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

    public function test_doctor_completes_2fa_and_redirects_to_doctor_dashboard(): void
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

        // Step 1: Login triggers 2FA
        $this->post(route('login.store'), [
            'email' => $email,
            'password' => 'password123',
        ]);

        // Step 2: 2FA challenge code
        $twoFactorService = app(TwoFactorService::class);
        $otp = $twoFactorService->generateAndSendOtp($doctor);

        $response = $this->withSession(['login.id' => $doctor->id])
            ->post(route('two-factor.login.store'), [
                'code' => $otp,
            ]);

        $response->assertSessionHasNoErrors();
        $this->assertAuthenticatedAs($doctor);
        $response->assertRedirect(route('doctor.dashboard'));

        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $doctor->id,
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
            'phone' => '0501234567',
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
}
