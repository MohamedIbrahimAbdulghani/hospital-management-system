@extends('Dashboard.layouts.master2')

@section('title', __('auth.two_factor_title') . ' - ' . config('app.name', 'Hospital Management System'))

@section('css')
<link href="{{ URL::asset('Dashboard/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
<style>
    .two-factor-page-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
        background: radial-gradient(circle at 50% 10%, rgba(1, 98, 232, 0.08) 0%, rgba(248, 250, 252, 0) 70%), #f8fafc;
    }

    .two-factor-card {
        background: #ffffff;
        border-radius: 18px;
        box-shadow: 0 16px 45px rgba(15, 23, 42, 0.08);
        border: 1px solid #e2e8f0;
        max-width: 440px;
        width: 100%;
        padding: 2.25rem 2rem;
        position: relative;
        animation: fadeUpCard 0.4s ease-out;
    }

    @keyframes fadeUpCard {
        from {
            opacity: 0;
            transform: translateY(14px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .two-factor-top-bar {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
    }

    .back-role-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #64748b;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        padding: 5px 12px;
        border-radius: 20px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.07);
        transition: all 0.2s ease;
    }

    .back-role-link:hover {
        color: #0162e8;
        background: #f8fafc;
        border-color: #cbd5e1;
        text-decoration: none;
    }

    .two-factor-shield-icon {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: rgba(1, 98, 232, 0.1);
        color: #0162e8;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        border: 2px solid rgba(1, 98, 232, 0.18);
        box-shadow: 0 4px 14px rgba(1, 98, 232, 0.15);
    }

    .two-factor-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.01em;
    }

    .badge-admin-2fa {
        display: inline-block;
        background-color: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
        font-size: 11.5px;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 50px;
    }

    .two-factor-subtitle {
        font-size: 13.5px;
        color: #64748b;
        line-height: 1.5;
    }

    .otp-boxes-container {
        display: flex;
        justify-content: space-between;
        gap: 8px;
        direction: ltr !important;
    }

    .otp-digit-box {
        width: 52px;
        height: 56px;
        text-align: center;
        font-size: 22px;
        font-weight: 700;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, monospace;
        color: #0f172a;
        background: #f8fafc;
        border: 1.5px solid #cbd5e1;
        border-radius: 12px;
        transition: all 0.2s ease-in-out;
        outline: none;
    }

    .otp-digit-box:focus {
        background: #ffffff;
        border-color: #0162e8;
        box-shadow: 0 0 0 3.5px rgba(1, 98, 232, 0.16);
    }

    .otp-digit-box.is-invalid {
        border-color: #ef4444;
        background: #fff5f5;
    }

    .otp-digit-box.is-invalid:focus {
        box-shadow: 0 0 0 3.5px rgba(239, 68, 68, 0.16);
    }

    /* زر إرسال رمز جديد الثانوي */
    .btn-auth-secondary {
        height: 42px;
        border-radius: 10px;
        font-size: 13.5px;
        font-weight: 600;
        background-color: #f8fafc;
        border: 1.5px solid #cbd5e1;
        color: #334155;
        width: 100%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s ease-in-out;
        cursor: pointer;
    }

    .btn-auth-secondary:hover:not(:disabled) {
        background-color: #f1f5f9;
        border-color: #94a3b8;
        color: #0f172a;
        text-decoration: none;
    }

    .btn-auth-secondary:disabled {
        opacity: 0.65;
        cursor: not-allowed;
        background-color: #f1f5f9;
        border-color: #e2e8f0;
        color: #94a3b8;
    }

    .demo-otp-badge-card {
        background-color: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
        border-radius: 10px;
        padding: 8px 12px;
        font-size: 12px;
        animation: fadeInBadge 0.3s ease-out;
    }

    @keyframes fadeInBadge {
        from { opacity: 0; transform: translateY(-4px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .demo-badge-label {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-weight: 600;
    }

    .demo-badge-code {
        font-family: 'Inter', monospace;
        font-weight: 800;
        font-size: 13.5px;
        letter-spacing: 0.12em;
        background: #ffffff;
        border: 1px solid #86efac;
        padding: 2px 8px;
        border-radius: 6px;
        color: #15803d;
    }

    @media (max-width: 480px) {
        .two-factor-card {
            padding: 1.75rem 1.25rem;
        }
        .otp-digit-box {
            width: 44px;
            height: 50px;
            font-size: 19px;
            border-radius: 9px;
        }
    }
</style>
@endsection

@section('content')
<div class="two-factor-page-wrapper">
    <div class="two-factor-card auth-card">

        {{-- الشريط العلوي: رابط العودة إلى الرئيسية + مبدل اللغة في طرفين متقابلين --}}
        <div class="two-factor-top-bar">
            <a href="{{ route('home') }}" class="back-role-link">
                <i class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}"></i>
                <span>{{ app()->getLocale() === 'ar' ? 'الرئيسية' : 'Home' }}</span>
            </a>

            {{-- مبدل اللغة الموحد --}}
            <x-language-switcher />
        </div>

        {{-- الشعار والأيقونة والعناوين --}}
        <div class="text-center mb-4">
            <div class="two-factor-shield-icon mb-3">
                <i class="fas fa-user-shield"></i>
            </div>

            <h2 class="two-factor-title mb-1">
                {{ __('auth.two_factor_title') }}
            </h2>

            <div class="mb-2">
                <span class="badge-admin-2fa">
                    {{ __('auth.two_factor_badge') }}
                </span>
            </div>

            <p class="two-factor-subtitle mb-0">
                {{ __('auth.two_factor_subtitle') }}
            </p>
        </div>

        {{-- تنبيه رمز التحقق التجريبي في بيئة التطوير المحلية فقط --}}
        <div id="demo-otp-container">
            @php
                $activeDemoCode = $demoCode ?? session('demo_2fa_code');
            @endphp
            @if (app()->environment('local') && $activeDemoCode)
                <div class="demo-otp-badge-card mb-4" role="note" id="demo-otp-card">
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="demo-badge-label">
                            <i class="fas fa-code text-success"></i>
                            <span>{{ __('auth.dev_otp_label') }}</span>
                        </span>
                        <span class="demo-badge-code" id="demo-badge-code-val">
                            {{ $activeDemoCode }}
                        </span>
                    </div>
                </div>
            @endif
        </div>

        {{-- رسائل التنبيه والخطأ من الجلسة ومكون التحقق الموحد --}}
        <x-auth-validation-alert />

        @if (session('status'))
            <div class="alert alert-success py-2 px-3 mb-3 tx-13 rounded d-flex align-items-center" role="alert">
                <i class="fas fa-check-circle mr-2 ml-2 text-success"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        {{-- حاوية التنبيهات الديناميكية لعمليات إعادة الإرسال --}}
        <div id="ajax-alert-container"></div>

        {{-- نموذج التحقق بخطوتين --}}
        <form method="POST" action="{{ route('two-factor.login.store') }}" id="two-factor-form">
            @csrf

            {{-- حقل الكود المخفي الذي يجمع الـ 6 أرقام للإرسال --}}
            <input type="hidden" name="code" id="otp-hidden-code" value="">

            {{-- مجموعة خانات رمز التحقق 6 أرقام --}}
            <div id="otp-group" class="form-group mb-3">
                <label class="text-center d-block mb-3 font-weight-semibold text-muted tx-13">
                    {{ __('auth.two_factor_code_label') }}
                </label>
                <div class="otp-boxes-container">
                    @for ($i = 0; $i < 6; $i++)
                        <input
                            type="text"
                            inputmode="numeric"
                            pattern="[0-9]*"
                            maxlength="1"
                            class="otp-digit-box @if($errors->has('code')) is-invalid @endif"
                            data-index="{{ $i }}"
                            autocomplete="{{ $i === 0 ? 'one-time-code' : 'off' }}"
                            {{ $i === 0 ? 'autofocus' : '' }}
                            aria-label="Digit {{ $i + 1 }}"
                        >
                    @endfor
                </div>
            </div>

            {{-- زر ثانوي: إرسال رمز جديد مع عداد انتظار 30 ثانية --}}
            <div id="resend-group" class="form-group mb-4" x-data="twoFactorResendTimer({
                cooldown: {{ (int) ($remainingCooldown ?? 0) }},
                resendUrl: '{{ route('two-factor.resend') }}',
                csrfToken: '{{ csrf_token() }}'
            })">
                <button
                    type="button"
                    id="resend-code-btn"
                    class="btn btn-auth-secondary"
                    :disabled="cooldown > 0 || isResending"
                    @click="resendOtp"
                    wire:loading.attr="disabled"
                >
                    <i class="fas" :class="isResending ? 'fa-spinner fa-spin' : (cooldown > 0 ? 'fa-clock text-warning' : 'fa-redo-alt')"></i>
                    <span x-show="!isResending && cooldown === 0">{{ __('auth.resend_code_button') }}</span>
                    <span x-show="!isResending && cooldown > 0" x-cloak>
                        {{ __('auth.resend_code_in') }} <span x-text="cooldown"></span> {{ __('auth.seconds') }}
                    </span>
                    <span x-show="isResending" x-cloak>{{ __('auth.sending') }}</span>
                </button>
            </div>

            {{-- مجموعة رمز الاسترداد للطوارئ (مخفية افتراضياً) --}}
            <div id="recovery-group" class="form-group mb-4 d-none">
                <label for="recovery_code" class="font-weight-semibold mb-2 tx-13">
                    {{ __('auth.recovery_code_label') }}
                </label>
                <div class="form-input-wrapper">
                    <i class="fas fa-key form-input-icon"></i>
                    <input
                        id="recovery_code"
                        type="text"
                        name="recovery_code"
                        class="form-control form-control-custom @error('recovery_code') is-invalid @enderror"
                        placeholder="{{ __('auth.recovery_code_placeholder') }}"
                        autocomplete="off"
                    >
                </div>
                @if (\App\Helpers\AuthErrorHelper::shouldShowInlineError('recovery_code', $errors))
                    <div class="invalid-feedback d-block tx-12 mt-1">{{ $errors->first('recovery_code') }}</div>
                @endif
            </div>

            {{-- زر التأكيد الأساسي مع حالة التحميل لمنع التكرار --}}
            <button type="submit" id="verify-button" class="btn btn-login-submit mb-3" wire:loading.attr="disabled">
                <i class="fas fa-check-circle" id="verify-icon"></i>
                <span id="verify-text">{{ __('auth.two_factor_button') }}</span>
            </button>

            {{-- التبديل بين الرمز وكود الاسترداد + العودة للدخول --}}
            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                <a href="#" id="toggle-recovery-link" class="tx-13 text-primary font-weight-semibold" onclick="handleToggleRecovery(event)">
                    {{ __('auth.use_recovery_code') }}
                </a>
                <a href="{{ route('login') }}" class="tx-13 text-muted">
                    {{ __('auth.cancel_back_to_login') }}
                </a>
            </div>
        </form>

    </div>
</div>
@endsection

@section('js')
{{-- تحميل Alpine.js في حال لم تكن محملة في الواجهة الأساسية --}}
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js"></script>

<script>
    // مكون Alpine.js لإدارة مؤقت إعادة الإرسال وحالة الزر
    function twoFactorResendTimer(config) {
        return {
            cooldown: config.cooldown || 0,
            isResending: false,
            timerInterval: null,

            init() {
                if (this.cooldown > 0) {
                    this.startCountdown();
                }
            },

            startCountdown() {
                if (this.timerInterval) {
                    clearInterval(this.timerInterval);
                }
                this.timerInterval = setInterval(() => {
                    if (this.cooldown > 0) {
                        this.cooldown--;
                    } else {
                        clearInterval(this.timerInterval);
                    }
                }, 1000);
            },

            async resendOtp() {
                if (this.cooldown > 0 || this.isResending) {
                    return;
                }

                this.isResending = true;
                const alertContainer = document.getElementById('ajax-alert-container');
                if (alertContainer) alertContainer.innerHTML = '';

                try {
                    const response = await fetch(config.resendUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': config.csrfToken
                        }
                    });

                    const data = await response.json();

                    if (response.ok && data.success) {
                        // إظهار رسالة النجاح
                        if (alertContainer) {
                            alertContainer.innerHTML = `
                                <div class="alert alert-success py-2 px-3 mb-3 tx-13 rounded d-flex align-items-center" role="alert">
                                    <i class="fas fa-check-circle mr-2 ml-2 text-success"></i>
                                    <span>${data.message}</span>
                                </div>
                            `;
                        }

                        // في البيئة المحلية: تحديث الشريط التجريبي بالكود الجديد
                        if (data.demo_code) {
                            updateDevOtpBadge(data.demo_code);
                        }

                        // تفريغ خانات الإدخال وإعادة التركيز على أول خانة
                        resetOtpInputs();

                        // بدء عداد الـ 30 ثانية
                        this.cooldown = data.cooldown || 30;
                        this.startCountdown();
                    } else {
                        // إظهار رسالة الخطأ
                        const errorMsg = data.message || "{{ __('auth.two_factor_invalid_simple') }}";
                        if (alertContainer) {
                            alertContainer.innerHTML = `
                                <div class="alert alert-danger py-2 px-3 mb-3 tx-13 rounded d-flex align-items-center" role="alert">
                                    <i class="fas fa-exclamation-circle mr-2 ml-2 text-danger"></i>
                                    <span>${errorMsg}</span>
                                </div>
                            `;
                        }

                        if (response.status === 403 || response.status === 401) {
                            setTimeout(() => {
                                window.location.href = "{{ route('login') }}";
                            }, 1500);
                        }

                        if (data.cooldown) {
                            this.cooldown = data.cooldown;
                            this.startCountdown();
                        }
                    }
                } catch (err) {
                    if (alertContainer) {
                        alertContainer.innerHTML = `
                            <div class="alert alert-danger py-2 px-3 mb-3 tx-13 rounded d-flex align-items-center" role="alert">
                                <i class="fas fa-exclamation-circle mr-2 ml-2 text-danger"></i>
                                <span>{{ __('auth.two_factor_invalid_simple') }}</span>
                            </div>
                        `;
                    }
                } finally {
                    this.isResending = false;
                }
            }
        };
    }

    // تفريغ الخانات والتركيز على الخانة الأولى
    function resetOtpInputs() {
        const otpInputs = document.querySelectorAll('.otp-digit-box');
        const hiddenCode = document.getElementById('otp-hidden-code');
        otpInputs.forEach(input => {
            input.value = '';
            input.classList.remove('is-invalid');
        });
        if (hiddenCode) hiddenCode.value = '';
        if (otpInputs.length > 0) {
            otpInputs[0].focus();
        }
    }

    // تحديث أو إنشاء شريط الكود التجريبي للمطور في البيئة المحلية فقط
    @if (app()->environment('local'))
    function updateDevOtpBadge(code) {
        const demoVal = document.getElementById('demo-badge-code-val');
        if (demoVal) {
            demoVal.textContent = code;
        } else {
            const container = document.getElementById('demo-otp-container');
            if (container) {
                container.innerHTML = `
                    <div class="demo-otp-badge-card mb-4" role="note" id="demo-otp-card">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="demo-badge-label">
                                <i class="fas fa-code text-success"></i>
                                <span>{{ __('auth.dev_otp_label') }}</span>
                            </span>
                            <span class="demo-badge-code" id="demo-badge-code-val">
                                ${code}
                            </span>
                        </div>
                    </div>
                `;
            }
        }
    }
    @else
    function updateDevOtpBadge(code) {}
    @endif


    document.addEventListener('DOMContentLoaded', function () {
        const otpInputs = document.querySelectorAll('.otp-digit-box');
        const hiddenCode = document.getElementById('otp-hidden-code');
        const form = document.getElementById('two-factor-form');
        const verifyBtn = document.getElementById('verify-button');
        const verifyText = document.getElementById('verify-text');
        const verifyIcon = document.getElementById('verify-icon');

        // عند وجود خطأ تحقق: تفريغ الحقول وإعادة الفوكس على الخانة الأولى تلقائياً
        @if ($errors->any())
            resetOtpInputs();
        @endif

        // تحديث قيمة الحقل المخفي المجمع
        function syncOtpCode() {
            let combined = '';
            otpInputs.forEach(input => {
                combined += input.value.trim();
            });
            if (hiddenCode) {
                hiddenCode.value = combined;
            }
        }

        // التعامل مع الإدخال في الخانات الـ 6
        otpInputs.forEach((input, index) => {
            input.addEventListener('input', function () {
                // السماح بالأرقام فقط
                const val = this.value.replace(/[^0-9]/g, '');
                this.value = val ? val.charAt(0) : '';

                syncOtpCode();

                if (this.value && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                    otpInputs[index + 1].select();
                }
            });

            input.addEventListener('keydown', function (e) {
                if (e.key === 'Backspace') {
                    if (!this.value && index > 0) {
                        e.preventDefault();
                        otpInputs[index - 1].focus();
                        otpInputs[index - 1].value = '';
                        syncOtpCode();
                    }
                } else if (e.key === 'ArrowLeft' && index > 0) {
                    otpInputs[index - 1].focus();
                } else if (e.key === 'ArrowRight' && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
            });

            // لصق الرمز المكون من 6 أرقام
            input.addEventListener('paste', function (e) {
                e.preventDefault();
                const pastedData = (e.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, '');

                if (pastedData) {
                    for (let i = 0; i < otpInputs.length; i++) {
                        if (i < pastedData.length) {
                            otpInputs[i].value = pastedData.charAt(i);
                        }
                    }
                    syncOtpCode();
                    const nextIndex = Math.min(pastedData.length, otpInputs.length - 1);
                    otpInputs[nextIndex].focus();
                }
            });
        });

        // منع الإرسال المزدوج وإظهار حالة التحميل
        if (form) {
            form.addEventListener('submit', function () {
                syncOtpCode();

                if (verifyBtn) {
                    verifyBtn.disabled = true;
                    verifyBtn.style.opacity = '0.85';
                    verifyBtn.style.pointerEvents = 'none';
                }
                if (verifyIcon) {
                    verifyIcon.className = 'fas fa-spinner fa-spin mr-1 ml-1';
                }
                if (verifyText) {
                    verifyText.textContent = "{{ __('auth.two_factor_verifying') }}";
                }
            });
        }
    });

    // تبديل بين وضع رمز الـ 6 أرقام ورمز الاسترداد
    function handleToggleRecovery(e) {
        e.preventDefault();
        const otpGroup = document.getElementById('otp-group');
        const resendGroup = document.getElementById('resend-group');
        const recoveryGroup = document.getElementById('recovery-group');
        const toggleLink = document.getElementById('toggle-recovery-link');
        const hiddenCode = document.getElementById('otp-hidden-code');
        const recoveryInput = document.getElementById('recovery_code');

        const useRecoveryText = "{{ __('auth.use_recovery_code') }}";
        const useAuthCodeText = "{{ __('auth.use_auth_code') }}";

        if (otpGroup.classList.contains('d-none')) {
            // العودة لوضع رمز OTP
            otpGroup.classList.remove('d-none');
            if (resendGroup) resendGroup.classList.remove('d-none');
            recoveryGroup.classList.add('d-none');
            toggleLink.textContent = useRecoveryText;
            recoveryInput.value = '';
            document.querySelector('.otp-digit-box[data-index="0"]').focus();
        } else {
            // التبديل إلى وضع رمز الاسترداد
            otpGroup.classList.add('d-none');
            if (resendGroup) resendGroup.classList.add('d-none');
            recoveryGroup.classList.remove('d-none');
            toggleLink.textContent = useAuthCodeText;
            hiddenCode.value = '';
            recoveryInput.focus();
        }
    }
</script>
@endsection
