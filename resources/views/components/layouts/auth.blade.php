<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name', 'Hospital Management System') }}</title>
    <link rel="icon" href="{{ URL::asset('Dashboard/img/brand/favicon.png') }}" type="image/x-icon"/>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons & Plugins -->
    <link href="{{ URL::asset('Dashboard/css/icons.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('Dashboard/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary: #0162e8;
            --primary-dark: #0150bf;
            --primary-light: #e6f0fd;
            --dark: #0f172a;
        }

        html, body {
            min-height: 100vh;
            margin: 0;
            padding: 0;
            font-family: 'Cairo', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            color: #1e293b;
        }

        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 1rem;
            position: relative;
            overflow: hidden;
        }

        .auth-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 14px 40px rgba(15, 23, 42, 0.08);
            border: 1px solid rgba(226, 232, 240, 0.85);
            max-width: 490px;
            width: 100%;
            padding: 2.25rem 2.5rem;
            position: relative;
            z-index: 10;
            animation: fadeUp 0.55s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .shield-badge {
            width: 68px;
            height: 68px;
            border-radius: 50%;
            background: rgba(1, 98, 232, 0.1);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            margin: 0 auto 1.25rem auto;
            border: 2px solid rgba(1, 98, 232, 0.15);
            box-shadow: 0 4px 16px rgba(1, 98, 232, 0.12);
        }

        .auth-title {
            font-size: 1.55rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 4px;
            text-align: center;
        }

        .auth-badge {
            display: inline-block;
            font-size: 12px;
            font-weight: 700;
            padding: 3px 12px;
            border-radius: 50px;
            margin-bottom: 8px;
        }

        .auth-desc {
            font-size: 13.5px;
            color: #64748b;
            text-align: center;
            margin-bottom: 1.75rem;
            line-height: 1.55;
        }

        /* Form Inputs */
        .form-group {
            margin-bottom: 1.15rem;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
        }

        .form-control-custom {
            width: 100%;
            height: 46px;
            border-radius: 10px;
            border: 1px solid #cbd5e1;
            padding: 0 14px;
            font-size: 14px;
            color: #0f172a;
            background-color: #ffffff;
            transition: all 0.2s ease-in-out;
        }

        .form-control-custom:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(1, 98, 232, 0.14);
            outline: none;
        }

        .password-field-wrapper {
            position: relative;
        }

        .password-field-wrapper .form-control-custom {
            padding-inline-end: 42px;
        }

        .password-toggle-btn {
            position: absolute;
            top: 50%;
            inset-inline-end: 12px;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            padding: 4px;
            font-size: 14px;
        }

        .password-toggle-btn:hover {
            color: var(--primary);
        }

        .btn-auth-primary {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            height: 48px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: #ffffff !important;
            font-weight: 700;
            font-size: 14.5px;
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 14px rgba(1, 98, 232, 0.32);
            transition: all 0.2s ease-in-out;
            cursor: pointer;
            text-decoration: none !important;
        }

        .btn-auth-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(1, 98, 232, 0.42);
        }

        .btn-auth-primary:active {
            transform: translateY(0);
        }

        .back-home-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 600;
            color: #64748b;
            text-decoration: none;
            transition: color 0.2s;
        }

        .back-home-link:hover {
            color: var(--primary);
        }

        html[dir="rtl"] .back-home-link .arrow-icon {
            transform: scaleX(-1);
        }

        .auth-footer {
            margin-top: 1.5rem;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
        }
    </style>
</head>
<body>

    <div class="auth-container">
        {{-- Soft Living Blurred Gradient Blobs (Motion Objective 3) --}}
        <div class="living-blobs-wrapper">
            <div class="living-blob blob-primary" style="top: -10%; inset-inline-start: -10%; width: 440px; height: 440px;"></div>
            <div class="living-blob blob-teal" style="bottom: -15%; inset-inline-end: -10%; width: 500px; height: 500px;"></div>
            <div class="living-blob blob-amber" style="top: 40%; inset-inline-start: 60%; width: 320px; height: 320px;"></div>
        </div>

        <div class="auth-card">

            {{-- Top Header Row: Home Link & Language Switcher in opposite corners --}}
            <div class="flex justify-between items-center mb-4">
                <a href="{{ route('home') }}" class="back-home-link">
                    <span class="arrow-icon"><i class="fas fa-arrow-right"></i></span>
                    <span>{{ __('messages.back_to_home') }}</span>
                </a>

                <x-language-switcher />
            </div>

            {{-- Circular Icon --}}
            @if(isset($icon))
                <div class="shield-badge">
                    {!! $icon !!}
                </div>
            @endif

            {{-- Page Title & Optional Badge --}}
            <div class="text-center">
                @if(isset($heading))
                    <h2 class="auth-title">{{ $heading }}</h2>
                @endif

                @if(isset($badge))
                    <span class="auth-badge bg-blue-50 text-blue-700 border border-blue-200">
                        {{ $badge }}
                    </span>
                @endif

                @if(isset($subheading))
                    <p class="auth-desc">{{ $subheading }}</p>
                @endif
            </div>

            {{-- Flash Messages --}}
            @if (session('status'))
                <div class="mb-4 p-3 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center gap-2">
                    <i class="fas fa-check-circle text-emerald-600"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-3 rounded-lg bg-rose-50 border border-rose-200 text-rose-800 text-xs">
                    <div class="flex items-center gap-2 font-semibold mb-1">
                        <i class="fas fa-exclamation-triangle text-rose-600"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                </div>
            @endif

            {{-- Main Form / Content Slot --}}
            {{ $slot }}

        </div>

    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (!input || !icon) return;

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
