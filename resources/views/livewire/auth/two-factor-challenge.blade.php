<x-layouts.auth :title="__('auth.two_factor_title')">
    <x-slot:icon>
        <i class="fas fa-user-shield"></i>
    </x-slot:icon>

    <x-slot:heading>
        {{ __('auth.two_factor_title') }}
    </x-slot:heading>

    <x-slot:badge>
        {{ __('auth.two_factor_badge') }}
    </x-slot:badge>

    <x-slot:subheading>
        {{ __('auth.two_factor_desc') }}
    </x-slot:subheading>

    {{-- Dev OTP Banner: Strictly only appears when app()->environment('local') --}}
    @if (app()->environment('local') && session('demo_2fa_code'))
        <div class="mb-4 p-3 rounded-xl bg-sky-50 border border-sky-200 text-sky-900 text-xs">
            <div class="flex items-center justify-between">
                <span class="flex items-center gap-1.5 font-medium">
                    <i class="fas fa-terminal text-sky-600"></i>
                    {{ __('auth.dev_otp_label') }}
                </span>
                <span class="font-mono text-sm font-bold bg-white text-sky-700 px-2.5 py-0.5 rounded-lg border border-sky-200">
                    {{ session('demo_2fa_code') }}
                </span>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('two-factor.login.store') }}">
        @csrf

        {{-- حقل رمز التحقق 6 أرقام --}}
        <div class="form-group mb-5" id="code-group">
            <label for="code" class="text-center block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                {{ __('auth.two_factor_code_label') }}
            </label>
            <input
                id="code"
                type="text"
                name="code"
                inputmode="numeric"
                pattern="[0-9]*"
                maxlength="6"
                class="form-control-custom text-center text-2xl font-mono font-bold tracking-[0.35em] h-14 @error('code') border-rose-500 @enderror"
                placeholder="••••••"
                autofocus
                autocomplete="one-time-code"
            >
        </div>

        {{-- حقل رمز الاسترداد للطوارئ --}}
        <div class="form-group mb-5 hidden" id="recovery-group">
            <label for="recovery_code" class="block text-xs font-semibold text-slate-700 mb-2">
                {{ __('auth.recovery_code_label') }}
            </label>
            <input
                id="recovery_code"
                type="text"
                name="recovery_code"
                class="form-control-custom text-sm font-mono @error('recovery_code') border-rose-500 @enderror"
                placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx"
                autocomplete="one-time-code"
            >
        </div>

        {{-- زر تأكيد الرمز --}}
        <button type="submit" class="btn-auth-primary btn-hover-scale mb-4">
            <i class="fas fa-check-circle ml-1 mr-1"></i>
            <span>{{ __('auth.two_factor_button') }}</span>
        </button>

        {{-- تبديل كود الاسترداد وإلغاء الدخول --}}
        <div class="flex justify-between items-center text-xs text-slate-500 pt-2 border-t border-slate-100">
            <a href="#" id="toggle-recovery" class="text-blue-600 hover:text-blue-700 font-semibold link-hover-underline" onclick="toggleRecoveryMode(event)">
                {{ __('auth.use_recovery_code') }}
            </a>
            <a href="{{ route('login') }}" class="text-slate-500 hover:text-slate-700">
                {{ __('auth.cancel_back_to_login') }}
            </a>
        </div>
    </form>

    <script>
        function toggleRecoveryMode(e) {
            e.preventDefault();
            const codeGroup = document.getElementById('code-group');
            const recoveryGroup = document.getElementById('recovery-group');
            const link = document.getElementById('toggle-recovery');
            const isAr = "{{ app()->getLocale() === 'ar' }}";

            if (codeGroup.classList.contains('hidden')) {
                codeGroup.classList.remove('hidden');
                recoveryGroup.classList.add('hidden');
                link.innerText = isAr ? 'استخدام رمز استرداد للطوارئ' : 'Use emergency recovery code';
                document.getElementById('code').focus();
            } else {
                codeGroup.classList.add('hidden');
                recoveryGroup.classList.remove('hidden');
                link.innerText = isAr ? 'استخدام رمز التحقق (OTP/TOTP)' : 'Use verification code';
                document.getElementById('recovery_code').focus();
            }
        }
    </script>
</x-layouts.auth>
