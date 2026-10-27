@extends('Dashboard.layouts.master2')

@section('title', app()->getLocale() === 'ar' ? 'تسجيل الدخول الموحد - نظام إدارة المستشفى' : 'Unified Sign In - Hospital Management System')

@section('css')
<link href="{{ URL::asset('Dashboard/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="container-fluid login-container-fluid">
    <div class="row no-gutters login-row">

        {{-- الجانب الأيسر - فيديو دكتور استشاري داخل المستشفى يرحب بالمرضى --}}
        <div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex login-hero-side">
            <video
                autoplay
                muted
                loop
                playsinline
                poster="{{ URL::asset('Dashboard/img/media/login.jpg') }}"
                class="login-hero-bg"
            >
                <source src="{{ asset('videos/login-video.mp4') }}" type="video/mp4">
            </video>
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

                {{-- رسائل الخطأ: عرض أخطاء المصادقة العامة في البانر العلوي مرة واحدة فقط --}}
                <x-auth-validation-alert />

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
                        @if (\App\Helpers\AuthErrorHelper::shouldShowInlineError('email', $errors))
                            <div class="invalid-feedback d-block tx-12 mt-1">{{ $errors->first('email') }}</div>
                        @endif
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
                        @if (\App\Helpers\AuthErrorHelper::shouldShowInlineError('password', $errors))
                            <div class="invalid-feedback d-block tx-12 mt-1">{{ $errors->first('password') }}</div>
                        @endif
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
