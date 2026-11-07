@extends('Dashboard.layouts.master2')

@section('title', __('register.page_title'))

@section('css')
<link href="{{ URL::asset('Dashboard/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="container-fluid login-container-fluid">
    <div class="row no-gutters login-row">

        {{-- الجانب الأيسر - فيديو دكتور استشاري ومحتوى ترحيبي --}}
        <div class="col-md-5 col-lg-5 col-xl-6 d-none d-md-flex login-hero-side">
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
                <div class="login-hero-badge hero-drop-1">
                    <span class="hero-ping-container">
                        <span class="hero-ping-anim"></span>
                        <span class="hero-ping-dot"></span>
                    </span>
                    <span>{{ __('register.hero_badge') }}</span>
                    <i class="fas fa-certificate text-sky-400"></i>
                </div>

                <h1 class="login-hero-title hero-drop-2">
                    {{ __('register.hero_title_line1') }} <br>
                    <span class="text-gradient-shimmer">{{ __('register.hero_title_line2') }}</span>
                </h1>

                <p class="login-hero-desc hero-drop-3">
                    {{ __('register.hero_desc') }}
                </p>

                <div class="login-hero-features hero-drop-4">
                    <div class="login-hero-pill hero-facility-chip">
                        <i class="fas fa-file-medical-alt text-danger"></i>
                        <span>{{ __('register.feature_record') }}</span>
                    </div>
                    <div class="login-hero-pill hero-facility-chip">
                        <i class="fas fa-calendar-check text-success"></i>
                        <span>{{ __('register.feature_booking') }}</span>
                    </div>
                    <div class="login-hero-pill hero-facility-chip">
                        <i class="fas fa-user-shield text-info"></i>
                        <span>{{ __('register.feature_security') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- الجانب الأيمن - نموذج إنشاء حساب المريض الموسع --}}
        <div class="col-md-7 col-lg-7 col-xl-6 login-form-side">

            {{-- الشريط العلوي (الرجوع للرئيسية + تبديل اللغة) --}}
            <div class="login-top-bar">
                <a href="{{ route('home') }}" class="back-role-link">
                    <i class="fas fa-home"></i>
                    <span>{{ __('register.home') }}</span>
                </a>

                {{-- زر تبديل اللغة الموحد --}}
                <x-language-switcher />
            </div>

            {{-- صندوق إنشاء الحساب --}}
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
                    <h3 class="font-weight-bold text-dark mb-1" style="font-size: 1.45rem;">
                        {{ __('register.title') }}
                    </h3>
                    <p class="text-muted tx-13 mb-0">
                        {{ __('register.subtitle') }}
                    </p>
                </div>

                {{-- بطاقة توضيحية بارزة: الحساب خاص بالمرضى فقط --}}
                <div class="role-badge-card role-patient">
                    <span class="role-badge-icon">👤</span>
                    <div>
                        <div class="role-badge-title">
                            {{ __('register.role_label') }}
                            <strong>{{ __('register.role_name') }}</strong>
                        </div>
                        <div class="role-badge-desc">
                            {{ __('register.role_desc') }}
                        </div>
                    </div>
                </div>

                {{-- رسائل التنبيه والخطأ العامة --}}
                @if (session('status'))
                    <div class="alert alert-success py-2 px-3 mb-3 tx-13 rounded">
                        <i class="fas fa-check-circle mr-1 ml-1"></i>
                        {{ session('status') }}
                    </div>
                @endif

                {{-- رسائل الخطأ: أخطاء المصادقة العامة فقط في البانر وأخطاء الحقول تظهر تحت كل حقل فقط --}}
                <x-auth-validation-alert />

                {{-- نموذج إنشاء الحساب --}}
                <form method="POST" action="{{ route('register.store') }}" id="register-form" novalidate>
                    @csrf

                    {{-- القسم الأول: البيانات الشخصية والطبية --}}
                    <div class="form-section-divider">
                        <i class="fas fa-id-card-alt"></i>
                        <span>{{ __('register.section_personal') }}</span>
                    </div>

                    {{-- الاسم الكامل --}}
                    <div class="form-group mb-3">
                        <label for="name">
                            {{ __('register.full_name') }} <span class="text-danger">*</span>
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
                                placeholder="{{ __('register.full_name_placeholder') }}"
                            >
                        </div>
                        @error('name')
                            <div class="invalid-feedback d-block tx-12 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- صف: البريد الإلكتروني + رقم الهاتف --}}
                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label for="email">
                                {{ __('register.email') }} <span class="text-danger">*</span>
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
                                    placeholder="patient@example.com"
                                >
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block tx-12 mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="phone">
                                {{ __('register.phone') }} <span class="text-danger">*</span>
                            </label>
                            <div class="form-input-wrapper">
                                <i class="fas fa-phone-alt form-input-icon"></i>
                                <input
                                    id="phone"
                                    type="tel"
                                    name="phone"
                                    value="{{ old('phone') }}"
                                    required
                                    autocomplete="tel"
                                    class="form-control form-control-custom @error('phone') is-invalid @enderror"
                                    placeholder="01012345678"
                                    maxlength="15"
                                >
                            </div>
                            @error('phone')
                                <div class="invalid-feedback d-block tx-12 mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- صف: الرقم القومي + النوع --}}
                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label for="national_id">
                                {{ __('register.national_id') }} <span class="text-danger">*</span>
                            </label>
                            <div class="form-input-wrapper">
                                <i class="fas fa-address-card form-input-icon"></i>
                                <input
                                    id="national_id"
                                    type="text"
                                    name="national_id"
                                    value="{{ old('national_id') }}"
                                    required
                                    maxlength="14"
                                    class="form-control form-control-custom @error('national_id') is-invalid @enderror"
                                    placeholder="29501011234567"
                                >
                            </div>
                            @error('national_id')
                                <div class="invalid-feedback d-block tx-12 mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="gender">
                                {{ __('register.gender') }} <span class="text-danger">*</span>
                            </label>
                            <div class="form-input-wrapper">
                                <i class="fas fa-venus-mars form-input-icon"></i>
                                <select
                                    id="gender"
                                    name="gender"
                                    required
                                    class="form-control form-control-custom @error('gender') is-invalid @enderror"
                                >
                                    <option value="" disabled {{ old('gender') ? '' : 'selected' }}>
                                        {{ __('register.gender_select') }}
                                    </option>
                                    <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>
                                        {{ __('register.gender_male') }}
                                    </option>
                                    <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>
                                        {{ __('register.gender_female') }}
                                    </option>
                                </select>
                            </div>
                            @error('gender')
                                <div class="invalid-feedback d-block tx-12 mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- صف: تاريخ الميلاد + فصيلة الدم --}}
                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label for="date_of_birth">
                                {{ __('register.date_of_birth') }} <span class="text-danger">*</span>
                            </label>
                            <div class="form-input-wrapper">
                                <i class="fas fa-calendar-alt form-input-icon"></i>
                                <input
                                    id="date_of_birth"
                                    type="date"
                                    name="date_of_birth"
                                    value="{{ old('date_of_birth') }}"
                                    required
                                    max="{{ date('Y-m-d') }}"
                                    class="form-control form-control-custom @error('date_of_birth') is-invalid @enderror"
                                >
                            </div>
                            @error('date_of_birth')
                                <div class="invalid-feedback d-block tx-12 mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="blood_type">
                                {{ __('register.blood_type') }}
                            </label>
                            <div class="form-input-wrapper">
                                <i class="fas fa-tint form-input-icon text-danger"></i>
                                <select
                                    id="blood_type"
                                    name="blood_type"
                                    class="form-control form-control-custom @error('blood_type') is-invalid @enderror"
                                >
                                    <option value="">{{ __('register.blood_type_none') }}</option>
                                    @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bt)
                                        <option value="{{ $bt }}" {{ old('blood_type') === $bt ? 'selected' : '' }}>{{ $bt }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('blood_type')
                                <div class="invalid-feedback d-block tx-12 mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- صف: المدينة / المحافظة + هاتف الطوارئ --}}
                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label for="city">
                                {{ __('register.city') }}
                            </label>
                            <div class="form-input-wrapper">
                                <i class="fas fa-map-marker-alt form-input-icon"></i>
                                <input
                                    id="city"
                                    type="text"
                                    name="city"
                                    value="{{ old('city') }}"
                                    class="form-control form-control-custom @error('city') is-invalid @enderror"
                                    placeholder="{{ __('register.city_placeholder') }}"
                                >
                            </div>
                            @error('city')
                                <div class="invalid-feedback d-block tx-12 mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="emergency_contact_phone">
                                {{ __('register.emergency_phone') }}
                            </label>
                            <div class="form-input-wrapper">
                                <i class="fas fa-ambulance form-input-icon text-danger"></i>
                                <input
                                    id="emergency_contact_phone"
                                    type="tel"
                                    name="emergency_contact_phone"
                                    value="{{ old('emergency_contact_phone') }}"
                                    class="form-control form-control-custom @error('emergency_contact_phone') is-invalid @enderror"
                                    placeholder="{{ __('register.emergency_placeholder') }}"
                                    maxlength="15"
                                >
                            </div>
                            @error('emergency_contact_phone')
                                <div class="invalid-feedback d-block tx-12 mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- القسم الثاني: بيانات الأمان وكلمة المرور --}}
                    <div class="form-section-divider">
                        <i class="fas fa-shield-alt"></i>
                        <span>{{ __('register.section_security') }}</span>
                    </div>

                    {{-- صف: كلمة المرور وتأكيدها --}}
                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label for="password">
                                {{ __('register.password') }} <span class="text-danger">*</span>
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
                                    aria-label="{{ __('register.toggle_password') }}"
                                >
                                    <i class="fas fa-eye" id="password-toggle-icon-1"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block tx-12 mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="password_confirmation">
                                {{ __('register.password_confirm') }} <span class="text-danger">*</span>
                            </label>
                            <div class="form-input-wrapper">
                                <i class="fas fa-check-double form-input-icon"></i>
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
                                    aria-label="{{ __('register.toggle_password_confirm') }}"
                                >
                                    <i class="fas fa-eye" id="password-toggle-icon-2"></i>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <div class="invalid-feedback d-block tx-12 mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- زر إنشاء الحساب --}}
                    <button class="btn btn-login-submit mt-3" type="submit" id="register-button">
                        <i class="fas fa-user-plus"></i>
                        <span>{{ __('register.submit') }}</span>
                    </button>

                </form>

                {{-- رابط تسجيل الدخول الموحد --}}
                <div class="mt-4 text-center">
                    <span class="tx-13 text-muted">
                        {{ __('register.have_account') }}
                    </span>
                    <a href="{{ route('login') }}" class="font-weight-bold text-primary ml-1 mr-1 tx-13">
                        {{ __('register.sign_in') }}
                    </a>
                </div>

            </div>{{-- end login-box --}}

            {{-- الفوتر السفلي --}}
            <div class="login-footer-bar">
                <span>&copy; {{ date('Y') }} {{ config('app.name', 'Hospital Management System') }}. {{ __('register.rights_reserved') }}</span>
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
        const nidInput  = document.getElementById('national_id');
        const phoneInput = document.getElementById('phone');

        // قفل الإدخال في الرقم القومي على الأرقام فقط (14 رقم)
        if (nidInput) {
            nidInput.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '').slice(0, 14);
            });
        }

        // قفل الإدخال في رقم الهاتف على الأرقام و +
        if (phoneInput) {
            phoneInput.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9+]/g, '').slice(0, 15);
            });
        }

        function validateName() {
            if (!nameInput) return true;
            const val = nameInput.value.trim();
            const words = val.split(/\s+/).filter(Boolean);
            if (val.length > 0 && words.length < 3) {
                const msg = @json(__('register.name_validation'));
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
                btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> <span>' + @json(__('register.creating')) + '</span>';
            });
        }
    });
</script>
@endsection
