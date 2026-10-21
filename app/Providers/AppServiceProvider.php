<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();
        $this->configureAuthAuditLogs();
    }

    /**
     * Configure authentication audit logging.
     */
    protected function configureAuthAuditLogs(): void
    {
        \Illuminate\Support\Facades\Event::listen(\Illuminate\Auth\Events\Login::class, function ($event) {
            if ($event->user instanceof \App\Models\User) {
                \App\Models\AuditLog::record(
                    action: 'login_success',
                    email: $event->user->email,
                    userId: $event->user->id,
                    details: ['role' => $event->user->role, 'guard' => $event->guard]
                );
            }
        });

        \Illuminate\Support\Facades\Event::listen(\Illuminate\Auth\Events\Failed::class, function ($event) {
            $email = $event->credentials['email'] ?? $event->credentials['phone'] ?? request('email');
            \App\Models\AuditLog::record(
                action: 'login_failed',
                email: $email,
                userId: $event->user?->id,
                details: ['ip' => request()->ip(), 'guard' => $event->guard]
            );
        });

        \Illuminate\Support\Facades\Event::listen(\Illuminate\Auth\Events\Lockout::class, function ($event) {
            $email = $event->request->input('email') ?? $event->request->input('phone');
            \App\Models\AuditLog::record(
                action: 'login_locked',
                email: $email,
                userId: null,
                details: ['ip' => $event->request->ip(), 'reason' => 'rate_limit_exceeded']
            );
        });

        \Illuminate\Support\Facades\Event::listen(\Illuminate\Auth\Events\Logout::class, function ($event) {
            if ($event->user instanceof \App\Models\User) {
                \App\Models\AuditLog::record(
                    action: 'logout',
                    email: $event->user->email,
                    userId: $event->user->id,
                    details: ['role' => $event->user->role]
                );
            }
        });
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
