<?php

namespace App\Actions\Fortify;

use App\Services\Auth\TwoFactorService;
use Illuminate\Auth\Events\Failed;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\RedirectsIfTwoFactorAuthenticatable;
use Laravel\Fortify\Events\TwoFactorAuthenticationChallenged;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\LoginRateLimiter;

class RedirectIfTwoFactorAuthenticatable implements RedirectsIfTwoFactorAuthenticatable
{
    public function __construct(
        protected StatefulGuard $guard,
        protected LoginRateLimiter $limiter,
        protected TwoFactorService $twoFactorService
    ) {}

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  callable  $next
     * @return mixed
     */
    public function handle($request, $next)
    {
        $user = $this->validateCredentials($request);

        // Check if 2FA is required (Mandatory for Admin and Doctor, or configured by user)
        if ($user && $this->twoFactorService->isTwoFactorRequired($user)) {
            $this->twoFactorService->generateAndSendOtp($user, $request);

            return $this->twoFactorChallengeResponse($request, $user);
        }

        return $next($request);
    }

    /**
     * Attempt to validate the incoming credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function validateCredentials($request)
    {
        if (Fortify::$authenticateUsingCallback) {
            return tap(call_user_func(Fortify::$authenticateUsingCallback, $request), function ($user) use ($request) {
                if (! $user) {
                    $this->fireFailedEvent($request);

                    throw ValidationException::withMessages([
                        Fortify::username() => [trans('auth.failed')],
                    ]);
                }
            });
        }

        $provider = $this->guard->getProvider();
        $user = $provider->retrieveByCredentials($request->only(Fortify::username(), 'password'));

        if (! $user || ! $provider->validateCredentials($user, ['password' => $request->password])) {
            $this->fireFailedEvent($request, $user);

            throw ValidationException::withMessages([
                Fortify::username() => [trans('auth.failed')],
            ]);
        }

        return $user;
    }

    /**
     * Fire the failed authentication attempt event.
     */
    protected function fireFailedEvent($request, $user = null): void
    {
        event(new Failed($this->guard?->name ?? config('fortify.guard'), $user, [
            Fortify::username() => $request->{Fortify::username()},
            'password' => $request->password,
        ]));
    }

    /**
     * Return two-factor challenge response.
     */
    protected function twoFactorChallengeResponse($request, $user)
    {
        $request->session()->put([
            'login.id' => $user->getKey(),
            'login.remember' => $request->boolean('remember'),
        ]);

        TwoFactorAuthenticationChallenged::dispatch($user);

        return $request->wantsJson()
            ? response()->json(['two_factor' => true])
            : redirect()->route('two-factor.login');
    }
}
