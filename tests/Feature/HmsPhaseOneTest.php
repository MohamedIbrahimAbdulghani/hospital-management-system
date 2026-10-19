<?php

namespace Tests\Feature;

use App\Livewire\Auth\ForceChangePassword;
use App\Models\Patient;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class HmsPhaseOneTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Ensure roles & permissions are seeded
        $this->seed(RolesAndPermissionsSeeder::class);
    }

    public function test_patient_registration_enforces_patient_role_and_creates_patient_profile(): void
    {
        $uniqueEmail = 'patient_'.Str::random(8).'@patient.test';

        $response = $this->post(route('register.store'), [
            'name' => 'Ahmad Mahmoud',
            'email' => $uniqueEmail,
            'password' => 'secret1234',
            'password_confirmation' => 'secret1234',
            'role' => 'admin', // Attempting to escalate role
        ]);

        $this->assertAuthenticated();

        $user = User::where('email', $uniqueEmail)->first();
        $this->assertNotNull($user);

        // Assert role is patient, ignoring client attempt
        $this->assertEquals('patient', $user->role);
        $this->assertTrue($user->hasRole('patient'));
        $this->assertFalse($user->hasRole('admin'));

        // Assert patient profile was created automatically
        $this->assertNotNull($user->patient);
        $this->assertInstanceOf(Patient::class, $user->patient);
    }

    public function test_admin_dashboard_is_forbidden_for_patients(): void
    {
        $uniqueEmail = 'sara_'.Str::random(8).'@patient.test';

        $patient = User::create([
            'name' => 'Sara Ali',
            'email' => $uniqueEmail,
            'password' => Hash::make('password123'),
            'role' => 'patient',
            'is_active' => true,
        ]);
        $patient->assignRole('patient');

        $response = $this->actingAs($patient)->get(route('admin.dashboard'));

        $response->assertForbidden();
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        $uniqueEmail = 'admin_'.Str::random(8).'@hospital.test';

        $admin = User::create([
            'name' => 'Hospital Administrator',
            'email' => $uniqueEmail,
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'is_active' => true,
        ]);
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));
        $this->assertEquals(200, $response->getStatusCode(), 'Redirected to: '.$response->headers->get('Location'));
        $response->assertSee('لوحة التحكم');
    }

    public function test_deactivated_user_is_logged_out_and_redirected(): void
    {
        $uniqueEmail = 'inactive_'.Str::random(8).'@test.com';

        $user = User::create([
            'name' => 'Inactive User',
            'email' => $uniqueEmail,
            'password' => Hash::make('password123'),
            'role' => 'patient',
            'is_active' => false,
        ]);
        $user->assignRole('patient');

        $response = $this->actingAs($user)->get(route('dashboard'));

        $this->assertGuest();
        $response->assertRedirect(route('login'));
    }

    public function test_user_with_must_change_password_is_redirected_to_force_change(): void
    {
        $uniqueEmail = 'khaled_'.Str::random(8).'@doctor.test';

        $doctorUser = User::create([
            'name' => 'Dr. Khaled Omar',
            'email' => $uniqueEmail,
            'password' => Hash::make('temporaryPassword123'),
            'role' => 'doctor',
            'is_active' => true,
            'must_change_password' => true,
        ]);
        $doctorUser->assignRole('doctor');

        $response = $this->actingAs($doctorUser)->get(route('doctor.dashboard'));

        $response->assertRedirect(route('password.change.force'));
    }

    public function test_artisan_command_creates_super_admin(): void
    {
        $uniqueEmail = 'console_admin_'.Str::random(8).'@hospital.test';

        $this->artisan('hms:create-admin', [
            '--name' => 'Console Super Admin',
            '--email' => $uniqueEmail,
            '--password' => 'supersecure123',
        ])->assertSuccessful();

        $admin = User::where('email', $uniqueEmail)->first();
        $this->assertNotNull($admin);
        $this->assertEquals('admin', $admin->role);
        $this->assertTrue($admin->hasRole('admin'));
    }

    public function test_login_authenticates_and_redirects_admin_to_admin_dashboard(): void
    {
        $uniqueEmail = 'login_admin_'.Str::random(8).'@hospital.test';

        $admin = User::create([
            'name' => 'Login Admin',
            'email' => $uniqueEmail,
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'is_active' => true,
            'must_change_password' => false,
        ]);
        $admin->assignRole('admin');

        $response = $this->post(route('login.store'), [
            'email' => $uniqueEmail,
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($admin);
        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_force_change_password_component_renders_and_updates_password(): void
    {
        $uniqueEmail = 'force_doc_'.Str::random(8).'@hospital.test';

        $doctor = User::create([
            'name' => 'Doctor Force Test',
            'email' => $uniqueEmail,
            'password' => Hash::make('tempPass123'),
            'role' => 'doctor',
            'is_active' => true,
            'must_change_password' => true,
        ]);
        $doctor->assignRole('doctor');

        $response = $this->actingAs($doctor)->get(route('password.change.force'));
        $response->assertOk();
        $response->assertSee('تغيير كلمة المرور المؤقتة');

        Livewire::actingAs($doctor)
            ->test(ForceChangePassword::class)
            ->set('current_password', 'tempPass123')
            ->set('password', 'newSecurePass123')
            ->set('password_confirmation', 'newSecurePass123')
            ->call('updatePassword')
            ->assertRedirect(route('doctor.dashboard'));

        $doctor->refresh();
        $this->assertFalse($doctor->must_change_password);
        $this->assertTrue(Hash::check('newSecurePass123', $doctor->password));
    }

    public function test_login_as_doctor_with_patient_credentials_is_rejected(): void
    {
        $patientEmail = 'patient_auth_'.Str::random(8).'@hospital.test';

        $patient = User::create([
            'name' => 'Patient Only',
            'email' => $patientEmail,
            'password' => Hash::make('password123'),
            'role' => 'patient',
            'is_active' => true,
            'must_change_password' => false,
        ]);
        $patient->assignRole('patient');

        // Attempt logging in via Doctor portal with Patient credentials
        $response = $this->from(route('login', ['role' => 'doctor']))->post(route('login.store'), [
            'email' => $patientEmail,
            'password' => 'password123',
            'role' => 'doctor',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors(['email']);
    }

    public function test_doctor_login_opens_doctor_dashboard_directly_when_no_password_change_required(): void
    {
        $doctorEmail = 'doctor_login_'.Str::random(8).'@hospital.test';

        $doctor = User::create([
            'name' => 'Dr. Sameh',
            'email' => $doctorEmail,
            'password' => Hash::make('password123'),
            'role' => 'doctor',
            'is_active' => true,
            'must_change_password' => false,
        ]);
        $doctor->assignRole('doctor');

        $response = $this->post(route('login.store'), [
            'email' => $doctorEmail,
            'password' => 'password123',
            'role' => 'doctor',
        ]);

        $this->assertAuthenticatedAs($doctor);
        $response->assertRedirect(route('doctor.dashboard'));
    }

    public function test_hr_user_can_login_and_access_hr_dashboard(): void
    {
        $hrEmail = 'hr_test_'.Str::random(8).'@hospital.test';

        $hr = User::create([
            'name' => 'HR Specialist',
            'email' => $hrEmail,
            'password' => Hash::make('password123'),
            'role' => 'hr',
            'is_active' => true,
            'must_change_password' => false,
        ]);

        $response = $this->post(route('login.store'), [
            'email' => $hrEmail,
            'password' => 'password123',
            'role' => 'hr',
        ]);

        $this->assertAuthenticatedAs($hr);
        $response->assertRedirect(route('hr.dashboard'));

        // Visit HR dashboard directly
        $dashResponse = $this->actingAs($hr)->get(route('hr.dashboard'));
        $dashResponse->assertOk();
        $dashResponse->assertSee(__('الموارد البشرية وشؤون المرضى (HR)'));
    }

    public function test_hr_dashboard_is_forbidden_for_patients(): void
    {
        $patientEmail = 'patient_hr_'.Str::random(8).'@patient.test';

        $patient = User::create([
            'name' => 'Patient Only',
            'email' => $patientEmail,
            'password' => Hash::make('password123'),
            'role' => 'patient',
            'is_active' => true,
            'must_change_password' => false,
        ]);

        $response = $this->actingAs($patient)->get(route('hr.dashboard'));
        $response->assertForbidden();
    }
}
