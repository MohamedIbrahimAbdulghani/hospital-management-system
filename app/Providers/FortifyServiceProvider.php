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

        $this->app->instance(
            \Laravel\Fortify\Contracts\TwoFactorLoginResponse::class,
            new class($redirectToLocalizedDashboard) implements \Laravel\Fortify\Contracts\TwoFactorLoginResponse
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
        $this->configurePipeline();
        $this->configureAuthentication();
        $this->configureActions();
        $this->configureViews();
        $this->configureRateLimiting();
    }

    /**
     * Configure Fortify authentication pipeline.
     */
    private function configurePipeline(): void
    {
        Fortify::authenticateThrough(function (Request $request) {
            return array_filter([
                config('fortify.limiters.login') ? null : \Laravel\Fortify\Actions\EnsureLoginIsNotThrottled::class,
                config('fortify.lowercase_usernames') ? \Laravel\Fortify\Actions\CanonicalizeUsername::class : null,
                \App\Actions\Fortify\RedirectIfTwoFactorAuthenticatable::class,
                \Laravel\Fortify\Actions\AttemptToAuthenticate::class,
                \Laravel\Fortify\Actions\PrepareAuthenticatedSession::class,
            ]);
        });
    }

    /**
     * Configure authentication and role-agnostic credential validation.
     * Supports Email OR Mobile number with timing-attack mitigation.
     */
    private function configureAuthentication(): void
    {
        Fortify::authenticateUsing(function (Request $request) {
            $login = $request->input(Fortify::username());
            $password = $request->input('password');

            // Find user by either Email or Phone number
            $user = User::where('email', $login)
                ->orWhere('phone', $login)
                ->first();

            // Constant-time hash verification to defeat timing attacks and user enumeration
            $dummyHash = '$2y$12$1234567890123456789012ujyZ9mQ1E5yZqg3p3n0dDkO8sLqfO2u';
            $passwordMatches = Hash::check($password, $user?->password ?? $dummyHash);

            // Any failure (non-existent email/phone, bad password, deactivated account)
            // returns null, triggering the exact same generic error without disclosing reason
            if (! $user || ! $passwordMatches || ! $user->is_active) {
                return null;
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
        Fortify::twoFactorChallengeView(fn () => view('livewire.auth.two-factor-challenge'));
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
