@php
    $selectedRole = request('role', old('role'));
    $roleInfo = match ($selectedRole) {
        'admin' => [
            'name_ar' => 'مدير النظام',
            'name_en' => 'System Admin',
            'class'   => 'role-admin',
            'icon'    => 'fas fa-shield-alt',
            'emoji'   => '🛡️',
            'desc_ar' => 'لوحة تحكم وإدارة صلاحيات النظام بالكامل',
            'desc_en' => 'Full system administration and permissions control',
        ],
        'doctor' => [
            'name_ar' => 'طبيب',
            'name_en' => 'Doctor Portal',
            'class'   => 'role-doctor',
            'icon'    => 'fas fa-user-md',
            'emoji'   => '🩺',
            'desc_ar' => 'إدارة الكشوفات، المرضى، والملفات الطبية',
            'desc_en' => 'Patient records, appointments, and clinic workflow',
        ],
        'hr' => [
            'name_ar' => 'الموارد البشرية والاستقبال',
            'name_en' => 'HR Staff Portal',
            'class'   => 'role-hr',
            'icon'    => 'fas fa-id-card-alt',
            'emoji'   => '👔',
            'desc_ar' => 'شؤون الكادر الطبي، الموظفين والمواعيد',
            'desc_en' => 'Staff management, reception, and shift schedules',
        ],
        'patient' => [
            'name_ar' => 'مريض',
            'name_en' => 'Patient Portal',
            'class'   => 'role-patient',
            'icon'    => 'fas fa-user',
            'emoji'   => '👤',
            'desc_ar' => 'متابعة المواعيد، الفحوصات والملف الطبي',
            'desc_en' => 'Medical history, lab results, and appointments',
        ],
        default => null,
    };
@endphp

@extends('Dashboard.layouts.master2')

@section('css')
<link href="{{ URL::asset('Dashboard/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css') }}" rel="stylesheet">
<style>
    /* Reset & Viewport setup */
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        background-color: #ffffff;
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

    /* Left Side: Modern Doctor Hero Showcase */
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

    /* Right Side: Form */
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
        margin-bottom: 1.5rem;
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

    /* Role Badge Card */
    .role-badge-card {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
    .role-badge-card.role-admin {
        background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
        border-color: #fecaca;
        color: #991b1b;
    }
    .role-badge-card.role-doctor {
        background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
        border-color: #a7f3d0;
        color: #065f46;
    }
    .role-badge-card.role-hr {
        background: linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%);
        border-color: #e9d5ff;
        color: #6b21a8;
    }
    .role-badge-card.role-patient {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        border-color: #bfdbfe;
        color: #1e40af;
    }
    .role-badge-icon {
        font-size: 1.6rem;
        line-height: 1;
    }
    .role-badge-title {
        font-size: 13.5px;
        font-weight: 700;
        margin-bottom: 2px;
    }
    .role-badge-desc {
        font-size: 11.5px;
        opacity: 0.85;
    }
    .role-switch-link {
        margin-inline-start: auto;
        font-size: 11.5px;
        font-weight: 700;
        padding: 5px 12px;
        border-radius: 6px;
        background: #ffffff;
        color: inherit;
        text-decoration: none;
        border: 1px solid rgba(0, 0, 0, 0.12);
        white-space: nowrap;
        transition: all 0.2s;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    }
    .role-switch-link:hover {
        background: #f8fafc;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        text-decoration: none;
        color: inherit;
    }

    /* Form Inputs */
    .form-group label {
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 6px;
        display: block;
    }
    .form-control-custom {
        height: 46px;
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
        padding: 10px 14px;
        font-size: 14px;
        color: #0f172a;
        background-color: #f8fafc;
        width: 100%;
        transition: all 0.2s ease-in-out;
    }
    .form-control-custom:focus {
        background-color: #ffffff;
        border-color: #0162e8;
        box-shadow: 0 0 0 3px rgba(1, 98, 232, 0.15);
        outline: none;
    }

    /* Password wrapper */
    .password-field-wrapper {
        position: relative;
    }
    .password-toggle-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        padding: 0;
        color: #94a3b8;
        font-size: 15px;
        cursor: pointer;
        transition: color 0.2s;
        z-index: 5;
    }
    .password-toggle-btn:hover {
        color: #475569;
    }

    /* RTL vs LTR adjustments */
    html[dir="rtl"] .password-toggle-btn { left: 14px; right: auto; }
    html[dir="rtl"] .password-field-wrapper input { padding-left: 42px; padding-right: 14px; }
    html[dir="ltr"] .password-toggle-btn { right: 14px; left: auto; }
    html[dir="ltr"] .password-field-wrapper input { padding-right: 42px; padding-left: 14px; }

    /* Submit Button (Explicit High-Contrast Gradient & Solid Colors) */
    .btn-login-submit {
        height: 48px;
        border-radius: 10px;
        font-size: 15px;
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

        {{-- الجانب الأيسر - الصورة والشكل الجمالي --}}
        <div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex login-hero-side">
            <img src="{{ URL::asset('Dashboard/img/media/login.jpg') }}"
                 class="login-hero-bg"
                 alt="Hospital Management System">
            <div class="login-hero-overlay"></div>

            <div class="login-hero-content">
                @if (app()->getLocale() === 'ar')
                    <div class="login-hero-badge">
                        <i class="fas fa-hospital-alt"></i>
                        <span>نظام إدارة المستشفيات الذكي</span>
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

        {{-- الجانب الأيمن - نموذج تسجيل الدخول --}}
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
            <div class="login-box">

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
                        {{ app()->getLocale() === 'ar' ? 'مرحباً بعودتك!' : 'Welcome back!' }}
                    </h3>
                    <p class="text-muted tx-13 mb-0">
                        {{ app()->getLocale() === 'ar' ? 'الرجاء تسجيل الدخول للمتابعة إلى حسابك' : 'Please sign in to access your portal' }}
                    </p>
                </div>

                {{-- بطاقة الدور المختار --}}
                @if ($roleInfo)
                    <div class="role-badge-card {{ $roleInfo['class'] }}">
                        <span class="role-badge-icon">{{ $roleInfo['emoji'] }}</span>
                        <div>
                            <div class="role-badge-title">
                                {{ app()->getLocale() === 'ar' ? 'تسجيل الدخول كـ:' : 'Signing in as:' }}
                                <strong>{{ app()->getLocale() === 'ar' ? $roleInfo['name_ar'] : $roleInfo['name_en'] }}</strong>
                            </div>
                            <div class="role-badge-desc">
                                {{ app()->getLocale() === 'ar' ? $roleInfo['desc_ar'] : $roleInfo['desc_en'] }}
                            </div>
                        </div>
                        <a href="{{ route('choose-role') }}" class="role-switch-link">
                            {{ app()->getLocale() === 'ar' ? 'تغيير' : 'Change' }}
                        </a>
                    </div>
                @endif

                {{-- رسائل التنبيه والخطأ --}}
                @if (session('status'))
                    <div class="alert alert-success py-2 px-3 mb-3 tx-13 rounded">
                        <i class="fas fa-check-circle mr-1 ml-1"></i>
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any() && !$errors->has('email') && !$errors->has('password'))
                    <div class="alert alert-danger py-2 px-3 mb-3 tx-13 rounded">
                        <ul class="mb-0 pr-3 pl-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- نموذج تسجيل الدخول --}}
                <form method="POST" action="{{ route('login.store') }}">
                    @csrf

                    @if ($selectedRole)
                        <input type="hidden" name="role" value="{{ $selectedRole }}">
                    @endif

                    {{-- البريد الإلكتروني --}}
                    <div class="form-group mb-3">
                        <label for="email">
                            {{ app()->getLocale() === 'ar' ? 'البريد الإلكتروني' : 'Email Address' }}
                        </label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            class="form-control form-control-custom @error('email') is-invalid @enderror"
                            placeholder="name@hospital.com"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="email"
                        >
                        @error('email')
                            <div class="invalid-feedback tx-12 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- كلمة المرور --}}
                    <div class="form-group mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="password" class="mb-0">
                                {{ app()->getLocale() === 'ar' ? 'كلمة المرور' : 'Password' }}
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="tx-12 text-primary font-weight-semibold">
                                    {{ app()->getLocale() === 'ar' ? 'نسيت كلمة المرور؟' : 'Forgot Password?' }}
                                </a>
                            @endif
                        </div>
                        <div class="password-field-wrapper">
                            <input
                                id="password"
                                name="password"
                                type="password"
                                class="form-control form-control-custom @error('password') is-invalid @enderror"
                                placeholder="{{ app()->getLocale() === 'ar' ? '••••••••' : '••••••••' }}"
                                required
                                autocomplete="current-password"
                            >
                            <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility()" aria-label="Toggle password">
                                <i class="far fa-eye" id="password-toggle-icon"></i>
                            </button>
                            @error('password')
                                <div class="invalid-feedback tx-12 mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- تذكرني --}}
                    <div class="form-group d-flex align-items-center mb-4">
                        <label class="ckbox mb-0 d-flex align-items-center" style="gap: 8px; cursor: pointer;">
                            <input type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <span class="tx-13 mr-1 ml-1 text-muted">
                                {{ app()->getLocale() === 'ar' ? 'تذكرني على هذا الجهاز' : 'Remember me on this device' }}
                            </span>
                        </label>
                    </div>

                    {{-- زر تسجيل الدخول --}}
                    <button class="btn btn-login-submit" type="submit" id="login-button">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>{{ app()->getLocale() === 'ar' ? 'تسجيل الدخول' : 'Sign In' }}</span>
                    </button>

                </form>

                {{-- زر الرجوع لاختيار الرول --}}
                <div class="mt-4 text-center">
                    <a href="{{ route('choose-role') }}" class="back-role-link">
                        <span class="arrow-icon">←</span>
                        <span>{{ app()->getLocale() === 'ar' ? 'الرجوع لاختيار نوع الحساب' : 'Back to role selection' }}</span>
                    </a>
                </div>

            </div>{{-- end login-box --}}

            {{-- الفوتر السفلي --}}
            <div class="login-footer-bar">
                <span>&copy; {{ date('Y') }} Hospital Management System. All rights reserved.</span>
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
        const form = document.querySelector('form');
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
