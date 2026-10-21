@extends('Dashboard.layouts.master2')

@section('title', app()->getLocale() === 'ar' ? 'تسجيل الدخول الموحد - نظام إدارة المستشفى' : 'Unified Sign In - Hospital Management System')

@section('css')
<link href="{{ URL::asset('Dashboard/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css') }}" rel="stylesheet">
<style>
    /* Reset & Viewport setup matching Register */
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        background-color: #ffffff;
        font-family: 'Cairo', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    .login-container-fluid {
        min-height: 100vh;
        height: 100vh;
        padding: 0;
        overflow-x: hidden;
    }

    .login-row {
        min-height: 100vh;
        height: 100vh;
        margin: 0;
    }

    /* Left Side: Exact Same Hero Showcase as Register */
    .login-hero-side {
        position: relative;
        min-height: 100vh;
        overflow: hidden;
        background: #0f172a;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        padding: 3rem 6rem;
    }

    .login-hero-bg {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center 25%;
        z-index: 1;
        transform: scale(1.02);
        transition: transform 0.6s ease;
    }

    .login-hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(
            180deg,
            rgba(15, 23, 42, 0.15) 0%,
            rgba(15, 23, 42, 0.45) 50%,
            rgba(15, 23, 42, 0.85) 100%
        );
        z-index: 2;
    }

    .login-hero-content {
        position: relative;
        z-index: 3;
        color: #ffffff;
        max-width: 540px;
        width: 100%;
        margin-inline-start: 2.5rem;
        margin-inline-end: auto;
        padding: 0;
        background: transparent;
        border: none;
        box-shadow: none;
        animation: fadeInHero 0.8s ease-out;
    }

    @keyframes fadeInHero {
        from { opacity: 0; transform: translateY(16px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .login-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.25);
        color: #ffffff;
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 1.25rem;
    }

    .login-hero-title {
        font-size: 2.1rem;
        font-weight: 800;
        line-height: 1.35;
        margin-bottom: 0.9rem;
        color: #ffffff;
        text-shadow: 0 2px 14px rgba(0,0,0,0.6);
    }

    .login-hero-desc {
        font-size: 0.95rem;
        line-height: 1.65;
        color: rgba(255, 255, 255, 0.92);
        margin-bottom: 1.5rem;
        text-shadow: 0 1px 8px rgba(0,0,0,0.5);
    }

    .login-hero-features {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .login-hero-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(15, 23, 42, 0.70);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.18);
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12.5px;
        color: #f1f5f9;
        transition: transform 0.2s ease, background 0.2s ease;
    }
    .login-hero-pill:hover {
        background: rgba(15, 23, 42, 0.85);
        transform: translateY(-2px);
    }

    /* Right Side: Form (Identical layout to Register) */
    .login-form-side {
        min-height: 100vh;
        height: 100vh;
        overflow-y: auto;
        background: #ffffff;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 2.5rem 3.5rem;
        position: relative;
    }

    .login-top-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        max-width: 440px;
        margin: 0 auto 1.5rem auto;
    }

    .login-box {
        width: 100%;
        max-width: 440px;
        margin: auto;
        padding: 1rem 0;
    }

    .login-footer-bar {
        text-align: center;
        padding-top: 1rem;
        font-size: 12px;
        color: #94a3b8;
    }

    /* Brand Logo */
    .brand-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 1.25rem;
    }
    .brand-logo-img {
        height: 42px;
        width: auto;
        object-fit: contain;
    }
    .brand-name {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1e293b;
        margin: 0;
        line-height: 1;
    }
    .brand-name span {
        color: #0162e8;
    }

    /* Form Inputs */
    .form-group label {
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 6px;
        display: block;
    }

    .form-input-wrapper {
        position: relative;
    }

    .form-input-icon {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 15px;
        z-index: 4;
        pointer-events: none;
        transition: color 0.2s ease;
    }
    html[dir="rtl"] .form-input-icon {
        right: 14px;
        left: auto;
    }
    html[dir="ltr"] .form-input-icon {
        left: 14px;
        right: auto;
    }

    .form-control-custom {
        height: 44px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-size: 13.5px;
        color: #1e293b;
        background-color: #f8fafc;
        transition: all 0.2s ease-in-out;
    }
    html[dir="rtl"] .form-control-custom {
        padding-right: 42px;
        padding-left: 42px;
    }
    html[dir="ltr"] .form-control-custom {
        padding-left: 42px;
        padding-right: 42px;
    }
    .form-control-custom:focus {
        background-color: #ffffff;
        border-color: #0162e8;
        box-shadow: 0 0 0 3.5px rgba(1, 98, 232, 0.12);
        outline: none;
    }
    .form-input-wrapper:focus-within .form-input-icon {
        color: #0162e8;
    }

    .password-toggle-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: transparent;
        border: none;
        color: #94a3b8;
        cursor: pointer;
        padding: 0 6px;
        font-size: 15px;
        z-index: 5;
        transition: color 0.2s;
    }
    .password-toggle-btn:hover {
        color: #334155;
    }
    html[dir="rtl"] .password-toggle-btn {
        left: 12px;
        right: auto;
    }
    html[dir="ltr"] .password-toggle-btn {
        right: 12px;
        left: auto;
    }

    /* Submit Button (Identical to Register) */
    .btn-login-submit {
        height: 46px;
        border-radius: 10px;
        font-size: 14.5px;
        font-weight: 700;
        background-color: #0162e8 !important;
        background: linear-gradient(135deg, #0162e8 0%, #0150bf 100%) !important;
        border: 1px solid #0162e8 !important;
        color: #ffffff !important;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 4px 14px rgba(1, 98, 232, 0.35);
        transition: all 0.2s ease-in-out;
        cursor: pointer;
    }
    .btn-login-submit:hover {
        background: linear-gradient(135deg, #0150bf 0%, #01419c 100%) !important;
        box-shadow: 0 6px 20px rgba(1, 98, 232, 0.45);
        transform: translateY(-1px);
        color: #ffffff !important;
    }
    .btn-login-submit:active {
        transform: translateY(0);
    }
    .btn-login-submit *,
    .btn-login-submit span,
    .btn-login-submit i {
        color: #ffffff !important;
    }

    /* Back link */
    .back-role-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        font-weight: 500;
        color: #64748b;
        text-decoration: none;
        transition: color 0.2s;
    }
    .back-role-link:hover {
        color: #0162e8;
        text-decoration: none;
    }
    html[dir="rtl"] .back-role-link .arrow-icon {
        transform: scaleX(-1);
    }

    /* Responsive */
    @media (max-width: 991px) {
        .login-hero-side {
            min-height: 320px;
            padding: 2rem 1.5rem;
            align-items: center;
        }
        .login-hero-content {
            padding: 1.5rem;
            margin-inline-start: 0;
        }
        .login-hero-title {
            font-size: 1.45rem;
        }
    }
    @media (max-width: 767px) {
        .login-container-fluid, .login-row {
            height: auto;
            min-height: 100vh;
        }
        .login-form-side {
            height: auto;
            min-height: 100vh;
            padding: 2rem 1.5rem;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid login-container-fluid">
    <div class="row no-gutters login-row">

        {{-- الجانب الأيسر - الصورة والشكل الجمالي متطابق تماماً مع Register --}}
        <div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex login-hero-side">
            <img src="{{ URL::asset('Dashboard/img/media/login.jpg') }}"
                 class="login-hero-bg"
                 alt="Hospital Management System">
            <div class="login-hero-overlay"></div>

            <div class="login-hero-content">
                @if (app()->getLocale() === 'ar')
                    <div class="login-hero-badge">
                        <i class="fas fa-hospital-alt"></i>
                        <span>{{ __('messages.unified_portal') }}</span>
                    </div>
                    <h1 class="login-hero-title">
                        رعاية صحية بمعايير عالمية وإدارة طبية متطورة
                    </h1>
                    <p class="login-hero-desc">
                        منظومة متكاملة لربط الأطباء، شؤون المرضى، والخدمات الطبية في بيئة آمنة وسلسة تدعم التحول الرقمي الكامل.
                    </p>
                    <div class="login-hero-features">
                        <div class="login-hero-pill">
                            <i class="fas fa-heartbeat text-danger"></i>
                            <span>ملفات طبية فورية</span>
                        </div>
                        <div class="login-hero-pill">
                            <i class="fas fa-calendar-check text-success"></i>
                            <span>جدولة دقيقة للمواعيد</span>
                        </div>
                        <div class="login-hero-pill">
                            <i class="fas fa-user-shield text-info"></i>
                            <span>أعلى معايير الأمان والخصوصية</span>
                        </div>
                    </div>
                @else
                    <div class="login-hero-badge">
                        <i class="fas fa-hospital-alt"></i>
                        <span>Smart Hospital Management</span>
                    </div>
                    <h1 class="login-hero-title">
                        World-Class Care & Advanced Healthcare Management
                    </h1>
                    <p class="login-hero-desc">
                        An integrated, secure platform connecting physicians, patients, and clinical administration with peak efficiency.
                    </p>
                    <div class="login-hero-features">
                        <div class="login-hero-pill">
                            <i class="fas fa-heartbeat text-danger"></i>
                            <span>Real-Time Health Records</span>
                        </div>
                        <div class="login-hero-pill">
                            <i class="fas fa-calendar-check text-success"></i>
                            <span>Smart Scheduling</span>
                        </div>
                        <div class="login-hero-pill">
                            <i class="fas fa-user-shield text-info"></i>
                            <span>Enterprise-Grade Security</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- الجانب الأيمن - نموذج تسجيل الدخول الموحد --}}
        <div class="col-md-6 col-lg-6 col-xl-5 login-form-side">

            {{-- الشريط العلوي (الرجوع للرئيسية + تبديل اللغة متطابق مع حدود الفورم) --}}
            <div class="login-top-bar">
                <a href="{{ route('home') }}" class="back-role-link">
                    <i class="fas fa-home"></i>
                    <span>{{ app()->getLocale() === 'ar' ? 'الرئيسية' : 'Home' }}</span>
                </a>

                {{-- زر تبديل اللغة الموحد --}}
                <x-language-switcher />
            </div>

            {{-- صندوق تسجيل الدخول في المنتصف --}}
            <div class="login-box auth-card">

                {{-- الشعار والعنوان --}}
                <div class="brand-header">
                    <a href="{{ url('/') }}">
                        <img src="{{ URL::asset('Dashboard/img/brand/favicon.png') }}"
                             class="brand-logo-img" alt="logo">
                    </a>
                    <h2 class="brand-name">
                        Hos<span>pi</span>tal
                    </h2>
                </div>

                {{-- العنوان الترحيبي --}}
                <div class="mb-3">
                    <h3 class="font-weight-bold text-dark mb-1" style="font-size: 1.5rem;">
                        {{ __('auth.login') }}
                    </h3>
                    <p class="text-muted tx-13 mb-0">
                        {{ __('auth.sign_in_desc') }}
                    </p>
                </div>

                {{-- رسائل التنبيه والنجاح --}}
                @if (session('status'))
                    <div class="alert alert-success py-2 px-3 mb-3 tx-13 rounded">
                        <i class="fas fa-check-circle mr-1 ml-1"></i>
                        {{ session('status') }}
                    </div>
                @endif

                {{-- رسائل الخطأ --}}
                @if ($errors->any())
                    <div class="alert alert-danger py-2 px-3 mb-3 tx-13 rounded">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-circle mr-1 ml-1 text-danger"></i>
                            <span>
                                {{ $errors->first('email') ?: $errors->first() }}
                            </span>
                        </div>
                    </div>
                @endif

                {{-- نموذج تسجيل الدخول الموحد --}}
                <form method="POST" action="{{ route('login.store') }}" id="login-form">
                    @csrf

                    {{-- البريد الإلكتروني أو رقم الهاتف --}}
                    <div class="form-group mb-3">
                        <label for="email">
                            {{ __('auth.email_or_phone') }}
                        </label>
                        <div class="form-input-wrapper">
                            <i class="fas fa-user-circle form-input-icon"></i>
                            <input
                                id="email"
                                name="email"
                                type="text"
                                class="form-control form-control-custom @error('email') is-invalid @enderror"
                                placeholder="{{ __('auth.email_or_phone_placeholder') }}"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="username"
                            >
                        </div>
                        @error('email')
                            <div class="invalid-feedback d-block tx-12 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- كلمة المرور --}}
                    <div class="form-group mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="password" class="mb-0">
                                {{ __('auth.password_label') }}
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="tx-12 text-primary font-weight-semibold">
                                    {{ __('auth.forgot_password') }}
                                </a>
                            @endif
                        </div>
                        <div class="form-input-wrapper">
                            <i class="fas fa-lock form-input-icon"></i>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                class="form-control form-control-custom @error('password') is-invalid @enderror"
                                placeholder="{{ __('auth.password_placeholder') }}"
                                required
                                autocomplete="current-password"
                            >
                            <button
                                type="button"
                                class="password-toggle-btn"
                                onclick="togglePasswordVisibility()"
                                aria-label="Toggle password"
                            >
                                <i class="fas fa-eye" id="password-toggle-icon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block tx-12 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- تذكرني --}}
                    <div class="form-group d-flex align-items-center mb-4">
                        <label class="ckbox mb-0 d-flex align-items-center" style="gap: 8px; cursor: pointer;">
                            <input type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <span class="tx-13 mr-1 ml-1 text-muted">
                                {{ __('auth.remember_me') }}
                            </span>
                        </label>
                    </div>

                    {{-- زر تسجيل الدخول الموحد --}}
                    <button class="btn btn-login-submit" type="submit" id="login-button">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>{{ __('auth.login') }}</span>
                    </button>

                </form>

                {{-- رابط إنشاء حساب للمريض --}}
                @if (Route::has('register'))
                    <div class="mt-4 text-center">
                        <span class="tx-13 text-muted">
                            {{ __('auth.dont_have_account') }}
                        </span>
                        <a href="{{ route('register') }}" class="font-weight-bold text-primary ml-1 mr-1 tx-13">
                            {{ __('auth.register') }}
                        </a>
                    </div>
                @endif

            </div>{{-- end login-box --}}

            {{-- الفوتر السفلي --}}
            <div class="login-footer-bar">
                <span>&copy; {{ date('Y') }} {{ config('app.name', 'Hospital Management System') }}. All rights reserved.</span>
            </div>

        </div>{{-- end col --}}

    </div>
</div>
@endsection

@section('js')
<script>
    function togglePasswordVisibility() {
        const input = document.getElementById('password');
        const icon  = document.getElementById('password-toggle-icon');
        if (!input || !icon) return;

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('login-form');
        const btn  = document.getElementById('login-button');
        if (form && btn) {
            form.addEventListener('submit', function() {
                if (typeof form.checkValidity === 'function' && !form.checkValidity()) return;
                btn.style.pointerEvents = 'none';
                btn.style.opacity = '0.85';
                btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> <span>{{ app()->getLocale() === "ar" ? "جاري تسجيل الدخول..." : "Signing in..." }}</span>';
            });
        }
    });
</script>
@endsection
