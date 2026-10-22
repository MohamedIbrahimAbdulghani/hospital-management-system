@extends('Dashboard.layouts.master2')

@section('title', app()->getLocale() === 'ar' ? 'إنشاء حساب مريض جديد - نظام إدارة المستشفى' : 'Patient Registration - Hospital Management System')

@section('css')
<link href="{{ URL::asset('Dashboard/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
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
                <source src="{{ asset('videos/register-video.mp4') }}" type="video/mp4">
            </video>
            <div class="login-hero-overlay"></div>

            <div class="login-hero-content">
                @if (app()->getLocale() === 'ar')
                    <div class="login-hero-badge">
                        <i class="fas fa-heartbeat"></i>
                        <span>بوابة المرضى المعتمدة</span>
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
                        <i class="fas fa-heartbeat"></i>
                        <span>Official Patient Portal</span>
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

        {{-- الجانب الأيمن - نموذج إنشاء حساب المريض --}}
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

            {{-- صندوق إنشاء الحساب في المنتصف --}}
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
                        {{ app()->getLocale() === 'ar' ? 'إنشاء حساب جديد للمريض' : 'Create Patient Account' }}
                    </h3>
                    <p class="text-muted tx-13 mb-0">
                        {{ app()->getLocale() === 'ar' ? 'يرجى إدخال بياناتك بدقة لإنشاء ملفك الطبي' : 'Please enter your details accurately to register your medical profile' }}
                    </p>
                </div>

                {{-- بطاقة توضيحية بارزة: الحساب خاص بالمرضى فقط --}}
                <div class="role-badge-card role-patient">
                    <span class="role-badge-icon">👤</span>
                    <div>
                        <div class="role-badge-title">
                            {{ app()->getLocale() === 'ar' ? 'تسجيل مخصص لـ: ' : 'Registration for: ' }}
                            <strong>{{ app()->getLocale() === 'ar' ? 'بوابة المرضى فقط' : 'Patients Portal Only' }}</strong>
                        </div>
                        <div class="role-badge-desc">
                            {{ app()->getLocale() === 'ar'
                                ? 'متابعة المواعيد، الفحوصات والملف الطبي. حسابات الأطباء والموظفين تُنشأ عبر الإدارة.'
                                : 'For patients to access medical records and appointments. Staff accounts are created by administration.' }}
                        </div>
                    </div>
                </div>

                {{-- رسائل التنبيه والخطأ العامة (إن وجدت) --}}
                @if (session('status'))
                    <div class="alert alert-success py-2 px-3 mb-3 tx-13 rounded">
                        <i class="fas fa-check-circle mr-1 ml-1"></i>
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any() && !$errors->has('name') && !$errors->has('email') && !$errors->has('password') && !$errors->has('password_confirmation'))
                    <div class="alert alert-danger py-2 px-3 mb-3 tx-13 rounded">
                        <ul class="mb-0 pr-3 pl-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- نموذج إنشاء الحساب --}}
                <form method="POST" action="{{ route('register') }}" id="register-form">
                    @csrf

                    {{-- الاسم الكامل --}}
                    <div class="form-group mb-3">
                        <label for="name">
                            {{ app()->getLocale() === 'ar' ? 'الاسم الكامل' : 'Full Name' }}
                        </label>
                        <div class="form-input-wrapper">
                            <i class="fas fa-user form-input-icon"></i>
                            <input
                                id="name"
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                autofocus
                                autocomplete="name"
                                class="form-control form-control-custom @error('name') is-invalid @enderror"
                                placeholder="{{ app()->getLocale() === 'ar' ? 'أدخل اسمك ثلاثياً' : 'Enter your full name' }}"
                            >
                        </div>
                        @error('name')
                            <div class="invalid-feedback d-block tx-12 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- البريد الإلكتروني --}}
                    <div class="form-group mb-3">
                        <label for="email">
                            {{ app()->getLocale() === 'ar' ? 'البريد الإلكتروني' : 'Email Address' }}
                        </label>
                        <div class="form-input-wrapper">
                            <i class="fas fa-envelope form-input-icon"></i>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email"
                                class="form-control form-control-custom @error('email') is-invalid @enderror"
                                placeholder="name@example.com"
                            >
                        </div>
                        @error('email')
                            <div class="invalid-feedback d-block tx-12 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- كلمة المرور --}}
                    <div class="form-group mb-3">
                        <label for="password">
                            {{ app()->getLocale() === 'ar' ? 'كلمة المرور' : 'Password' }}
                        </label>
                        <div class="form-input-wrapper">
                            <i class="fas fa-lock form-input-icon"></i>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="new-password"
                                class="form-control form-control-custom @error('password') is-invalid @enderror"
                                placeholder="••••••••"
                            >
                            <button
                                type="button"
                                class="password-toggle-btn"
                                onclick="toggleFieldVisibility('password', 'password-toggle-icon-1')"
                                aria-label="Toggle password"
                            >
                                <i class="fas fa-eye" id="password-toggle-icon-1"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block tx-12 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- تأكيد كلمة المرور --}}
                    <div class="form-group mb-4">
                        <label for="password_confirmation">
                            {{ app()->getLocale() === 'ar' ? 'تأكيد كلمة المرور' : 'Confirm Password' }}
                        </label>
                        <div class="form-input-wrapper">
                            <i class="fas fa-shield-alt form-input-icon"></i>
                            <input
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                required
                                autocomplete="new-password"
                                class="form-control form-control-custom @error('password_confirmation') is-invalid @enderror"
                                placeholder="••••••••"
                            >
                            <button
                                type="button"
                                class="password-toggle-btn"
                                onclick="toggleFieldVisibility('password_confirmation', 'password-toggle-icon-2')"
                                aria-label="Toggle password confirmation"
                            >
                                <i class="fas fa-eye" id="password-toggle-icon-2"></i>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <div class="invalid-feedback d-block tx-12 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- زر إنشاء الحساب --}}
                    <button class="btn btn-login-submit" type="submit" id="register-button">
                        <i class="fas fa-user-plus"></i>
                        <span>{{ app()->getLocale() === 'ar' ? 'إنشاء حساب المريض' : 'Create Patient Account' }}</span>
                    </button>

                </form>

                {{-- رابط تسجيل الدخول الموحد --}}
                <div class="mt-4 text-center">
                    <span class="tx-13 text-muted">
                        {{ app()->getLocale() === 'ar' ? 'لديك حساب مريض بالفعل؟' : 'Already have a patient account?' }}
                    </span>
                    <a href="{{ route('login') }}" class="font-weight-bold text-primary ml-1 mr-1 tx-13">
                        {{ app()->getLocale() === 'ar' ? 'تسجيل الدخول' : 'Sign In' }}
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
    function toggleFieldVisibility(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
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
        const form = document.getElementById('register-form');
        const btn  = document.getElementById('register-button');
        const nameInput = document.getElementById('name');

        function validateName() {
            if (!nameInput) return true;
            const val = nameInput.value.trim();
            const words = val.split(/\s+/).filter(Boolean);
            if (val.length > 0 && words.length < 3) {
                const msg = '{{ app()->getLocale() === "ar" ? "يرجى إدخال الاسم ثلاثياً على الأقل (مثال: محمد أحمد علي)" : "Please enter your full name (at least 3 parts)" }}';
                nameInput.setCustomValidity(msg);
                return false;
            } else {
                nameInput.setCustomValidity('');
                return true;
            }
        }

        if (nameInput) {
            nameInput.addEventListener('input', validateName);
        }

        if (form && btn) {
            form.addEventListener('submit', function(e) {
                if (!validateName()) {
                    nameInput.reportValidity();
                    e.preventDefault();
                    return false;
                }
                if (typeof form.checkValidity === 'function' && !form.checkValidity()) return;
                btn.style.pointerEvents = 'none';
                btn.style.opacity = '0.85';
                btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> <span>{{ app()->getLocale() === "ar" ? "جاري إنشاء الحساب..." : "Creating Account..." }}</span>';
            });
        }
    });
</script>
@endsection
