<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $redirectToLocalizedDashboard = function ($request) {
            $user = $request->user();

            if ($user) {
                $routeName = match ($user->role) {
                    'admin' => 'admin.dashboard',
                    'doctor' => 'doctor.dashboard',
                    'hr' => 'hr.dashboard',
                    'patient' => 'patient.dashboard',
                    default => 'dashboard',
                };

                $url = route($routeName);
                if (class_exists(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::class)) {
                    $locale = session('locale', app()->getLocale());
                    $url = \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL($locale, $url);
                }

                return redirect()->to($url);
            }

            return redirect()->route('dashboard');
        };

        $this->app->instance(
            LoginResponse::class,
            new class($redirectToLocalizedDashboard) implements LoginResponse
            {
                public function __construct(
                    private \Closure $redirect
                ) {}

                public function toResponse($request)
                {
                    return ($this->redirect)($request);
                }
            }
        );

        $this->app->instance(
            RegisterResponse::class,
            new class($redirectToLocalizedDashboard) implements RegisterResponse
            {
                public function __construct(
                    private \Closure $redirect
                ) {}

                public function toResponse($request)
                {
                    return ($this->redirect)($request);
                }
            }
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureAuthentication();
        $this->configureActions();
        $this->configureViews();
        $this->configureRateLimiting();
    }

    /**
     * Configure authentication and role-specific validation.
     */
    private function configureAuthentication(): void
    {
        Fortify::authenticateUsing(function (Request $request) {
            $email = $request->input(Fortify::username());
            $password = $request->input('password');
            $selectedRole = $request->input('role');

            $user = User::where('email', $email)->first();

            if (! $user || ! Hash::check($password, $user->password)) {
                return null;
            }

            // Verify role if a specific portal role was chosen
            if ($selectedRole && in_array($selectedRole, ['admin', 'doctor', 'hr', 'patient'], true)) {
                if ($user->role !== $selectedRole) {
                    $roleNamesAr = [
                        'admin' => 'مدير نظام',
                        'doctor' => 'طبيب',
                        'hr' => 'موارد بشرية',
                        'patient' => 'مريض',
                    ];

                    $expected = $roleNamesAr[$selectedRole] ?? $selectedRole;
                    $actual = $roleNamesAr[$user->role] ?? $user->role;

                    throw ValidationException::withMessages([
                        Fortify::username() => [
                            "بيانات هذا الحساب خاصة بـ ({$actual})، ولا يمكن استخدامها لتسجيل الدخول لبوابة ({$expected}). يرجى اختيار البوابة الصحيحة لحسابك.",
                        ],
                    ]);
                }
            }

            if (! $user->is_active) {
                throw ValidationException::withMessages([
                    Fortify::username() => [__('auth.account_deactivated')],
                ]);
            }

            return $user;
        });
    }

    /**
     * Configure Fortify actions.
     */
    private function configureActions(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
    }

    /**
     * Configure Fortify views.
     */
    private function configureViews(): void
    {
        Fortify::loginView(fn () => view('livewire.auth.login'));
        Fortify::registerView(fn () => view('livewire.auth.register'));
        Fortify::resetPasswordView(fn () => view('livewire.auth.reset-password'));
        Fortify::requestPasswordResetLinkView(fn () => view('livewire.auth.forgot-password'));
    }

    /**
     * Configure rate limiting.
     */
    private function configureRateLimiting(): void
    {
        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

    }
}
