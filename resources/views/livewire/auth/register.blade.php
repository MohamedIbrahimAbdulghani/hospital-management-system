@extends('Dashboard.layouts.master2')

@section('title', app()->getLocale() === 'ar' ? 'إنشاء حساب مريض جديد - نظام إدارة المستشفى' : 'Patient Registration - Hospital Management System')

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
                @if (app()->getLocale() === 'ar')
                    <div class="login-hero-badge">
                        <i class="fas fa-heartbeat"></i>
                        <span>بوابة المرضى المعتمدة</span>
                    </div>
                    <h1 class="login-hero-title">
                        رعاية صحية بمعايير عالمية وإدارة طبية متطورة
                    </h1>
                    <p class="login-hero-desc">
                        سجل الآن للوصول إلى ملفك الطبي الرقمي، متابعة التحاليل والأشعة، وحجز استشاراتك مع كبار الاستشاريين.
                    </p>
                    <div class="login-hero-features">
                        <div class="login-hero-pill">
                            <i class="fas fa-file-medical-alt text-danger"></i>
                            <span>ملف طبي رقمي فوري</span>
                        </div>
                        <div class="login-hero-pill">
                            <i class="fas fa-calendar-check text-success"></i>
                            <span>حجز استشارات بدون انتظار</span>
                        </div>
                        <div class="login-hero-pill">
                            <i class="fas fa-user-shield text-info"></i>
                            <span>أعلى درجات الخصوصية والأمان</span>
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
                        Create your account today for seamless access to digital health records, diagnostic reports, and effortless doctor consultations.
                    </p>
                    <div class="login-hero-features">
                        <div class="login-hero-pill">
                            <i class="fas fa-file-medical-alt text-danger"></i>
                            <span>Instant Digital Record</span>
                        </div>
                        <div class="login-hero-pill">
                            <i class="fas fa-calendar-check text-success"></i>
                            <span>Priority Scheduling</span>
                        </div>
                        <div class="login-hero-pill">
                            <i class="fas fa-user-shield text-info"></i>
                            <span>Enterprise-Grade Security</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- الجانب الأيمن - نموذج إنشاء حساب المريض الموسع --}}
        <div class="col-md-7 col-lg-7 col-xl-6 login-form-side">

            {{-- الشريط العلوي (الرجوع للرئيسية + تبديل اللغة) --}}
            <div class="login-top-bar">
                <a href="{{ route('home') }}" class="back-role-link">
                    <i class="fas fa-home"></i>
                    <span>{{ app()->getLocale() === 'ar' ? 'الرئيسية' : 'Home' }}</span>
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
                        {{ app()->getLocale() === 'ar' ? 'إنشاء حساب مريض جديد' : 'Create Patient Account' }}
                    </h3>
                    <p class="text-muted tx-13 mb-0">
                        {{ app()->getLocale() === 'ar'
                            ? 'أدخل بياناتك الشخصية والطبية لفتح ملف رقمي فوري في المستشفى'
                            : 'Fill in your personal and medical details to activate your digital hospital record' }}
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
                                ? 'حسابات الأطباء وموظفي المستشفى تُنشأ حصرياً عبر إدارة النظام.'
                                : 'Doctor and staff accounts are provisioned exclusively by system administration.' }}
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

                @if ($errors->any())
                    <div class="alert alert-danger py-2 px-3 mb-3 tx-13 rounded">
                        <div class="font-weight-bold mb-1">
                            <i class="fas fa-exclamation-triangle mr-1 ml-1"></i>
                            {{ app()->getLocale() === 'ar' ? 'يرجى تصحيح الأخطاء التالية:' : 'Please correct the following errors:' }}
                        </div>
                        <ul class="mb-0 pr-3 pl-3 tx-12">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- نموذج إنشاء الحساب --}}
                <form method="POST" action="{{ route('register') }}" id="register-form" novalidate>
                    @csrf

                    {{-- القسم الأول: البيانات الشخصية والطبية --}}
                    <div class="form-section-divider">
                        <i class="fas fa-id-card-alt"></i>
                        <span>{{ app()->getLocale() === 'ar' ? 'البيانات الشخصية والطبية' : 'Personal & Medical Information' }}</span>
                    </div>

                    {{-- الاسم الكامل --}}
                    <div class="form-group mb-3">
                        <label for="name">
                            {{ app()->getLocale() === 'ar' ? 'الاسم الكامل ثلاثياً على الأقل' : 'Full Name (at least 3 parts)' }} <span class="text-danger">*</span>
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
                                placeholder="{{ app()->getLocale() === 'ar' ? 'مثال: محمد أحمد علي' : 'e.g. Mohamed Ahmed Ali' }}"
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
                                {{ app()->getLocale() === 'ar' ? 'البريد الإلكتروني' : 'Email Address' }} <span class="text-danger">*</span>
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
                                {{ app()->getLocale() === 'ar' ? 'رقم الهاتف المحمول' : 'Mobile Phone Number' }} <span class="text-danger">*</span>
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
                                {{ app()->getLocale() === 'ar' ? 'الرقم القومي (14 رقماً)' : 'National ID (14 digits)' }} <span class="text-danger">*</span>
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
                                {{ app()->getLocale() === 'ar' ? 'النوع' : 'Gender' }} <span class="text-danger">*</span>
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
                                        {{ app()->getLocale() === 'ar' ? 'اختر النوع...' : 'Select Gender...' }}
                                    </option>
                                    <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>
                                        {{ app()->getLocale() === 'ar' ? 'ذكر (Male)' : 'Male' }}
                                    </option>
                                    <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>
                                        {{ app()->getLocale() === 'ar' ? 'أنثى (Female)' : 'Female' }}
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
                                {{ app()->getLocale() === 'ar' ? 'تاريخ الميلاد' : 'Date of Birth' }} <span class="text-danger">*</span>
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
                                {{ app()->getLocale() === 'ar' ? 'فصيلة الدم (اختياري)' : 'Blood Type (Optional)' }}
                            </label>
                            <div class="form-input-wrapper">
                                <i class="fas fa-tint form-input-icon text-danger"></i>
                                <select
                                    id="blood_type"
                                    name="blood_type"
                                    class="form-control form-control-custom @error('blood_type') is-invalid @enderror"
                                >
                                    <option value="">{{ app()->getLocale() === 'ar' ? 'غير محددة حالياً' : 'Not specified yet' }}</option>
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
                                {{ app()->getLocale() === 'ar' ? 'المدينة / المحافظة (اختياري)' : 'City / Governorate (Optional)' }}
                            </label>
                            <div class="form-input-wrapper">
                                <i class="fas fa-map-marker-alt form-input-icon"></i>
                                <input
                                    id="city"
                                    type="text"
                                    name="city"
                                    value="{{ old('city') }}"
                                    class="form-control form-control-custom @error('city') is-invalid @enderror"
                                    placeholder="{{ app()->getLocale() === 'ar' ? 'مثال: القاهرة، الجيزة، الإسكندرية' : 'e.g. Cairo, Giza, Alexandria' }}"
                                >
                            </div>
                            @error('city')
                                <div class="invalid-feedback d-block tx-12 mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="emergency_contact_phone">
                                {{ app()->getLocale() === 'ar' ? 'هاتف الطوارئ / قريب المريض (اختياري)' : 'Emergency Contact Phone (Optional)' }}
                            </label>
                            <div class="form-input-wrapper">
                                <i class="fas fa-ambulance form-input-icon text-danger"></i>
                                <input
                                    id="emergency_contact_phone"
                                    type="tel"
                                    name="emergency_contact_phone"
                                    value="{{ old('emergency_contact_phone') }}"
                                    class="form-control form-control-custom @error('emergency_contact_phone') is-invalid @enderror"
                                    placeholder="{{ app()->getLocale() === 'ar' ? 'رقم هاتف شخص قريب للطوارئ' : 'Relative / Emergency phone' }}"
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
                        <span>{{ app()->getLocale() === 'ar' ? 'بيانات الأمان وكلمة المرور' : 'Security & Password' }}</span>
                    </div>

                    {{-- صف: كلمة المرور وتأكيدها --}}
                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label for="password">
                                {{ app()->getLocale() === 'ar' ? 'كلمة المرور' : 'Password' }} <span class="text-danger">*</span>
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

                        <div class="col-md-6 form-group mb-3">
                            <label for="password_confirmation">
                                {{ app()->getLocale() === 'ar' ? 'تأكيد كلمة المرور' : 'Confirm Password' }} <span class="text-danger">*</span>
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
                                    aria-label="Toggle password confirmation"
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
                        <span>{{ app()->getLocale() === 'ar' ? 'إنشاء حساب المريض وتفعيل الملف' : 'Create Patient Account & Activate Record' }}</span>
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
                btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> <span>{{ app()->getLocale() === "ar" ? "جاري إنشاء الحساب والملف الطبي..." : "Creating Account & Record..." }}</span>';
            });
        }
    });
</script>
@endsection
