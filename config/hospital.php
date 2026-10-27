<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Two-Factor Authentication Roles
    |--------------------------------------------------------------------------
    | Defines the roles that strictly require mandatory two-factor
    | authentication (OTP/TOTP) before gaining access to their portal.
    | Driven by the TWO_FACTOR_ROLES environment variable.
    */
    'two_factor_roles' => array_filter(
        array_map('trim', explode(',', env('TWO_FACTOR_ROLES', 'admin')))
    ),

    /*
    |--------------------------------------------------------------------------
    | Two-Factor Challenge Security & Rate Limiting
    |--------------------------------------------------------------------------
    | Defines maximum failed attempts before terminating the challenge session,
    | resend cooldown, resend rate limiting, and OTP expiry in minutes.
    */
    'two_factor_max_attempts' => (int) env('TWO_FACTOR_MAX_ATTEMPTS', 5),
    'two_factor_resend_cooldown' => (int) env('TWO_FACTOR_RESEND_COOLDOWN', 30),
    'two_factor_max_resends' => (int) env('TWO_FACTOR_MAX_RESENDS', 3),
    'two_factor_resend_window' => (int) env('TWO_FACTOR_RESEND_WINDOW', 600), // 10 minutes (seconds)
    'two_factor_expiry_minutes' => (int) env('TWO_FACTOR_EXPIRY_MINUTES', 5),
    'two_factor_channel' => env('TWO_FACTOR_CHANNEL', 'mail'),

];

