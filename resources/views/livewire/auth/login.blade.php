@php
    $selectedRole = request('role', old('role'));
    $roleInfo = match ($selectedRole) {
        'admin' => [
            'name_ar' => 'مدير النظام',
            'name_en' => 'Admin Portal',
            'badge' => 'bg-red-50 text-red-700 dark:bg-red-950/50 dark:text-red-300 border-red-200 dark:border-red-900',
            'icon' => 'fas fa-shield-alt',
            'desc' => 'تسجيل الدخول إلى لوحة إدارة ومراقبة النظام',
        ],
        'doctor' => [
            'name_ar' => 'طبيب',
            'name_en' => 'Doctor Portal',
            'badge' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/50 dark:text-emerald-300 border-emerald-200 dark:border-emerald-900',
            'icon' => 'fas fa-user-md',
            'desc' => 'تسجيل الدخول إلى العيادة وجدول الكشوفات',
        ],
        'hr' => [
            'name_ar' => 'الموارد البشرية والاستقبال',
            'name_en' => 'HR Staff Portal',
            'badge' => 'bg-purple-50 text-purple-700 dark:bg-purple-950/50 dark:text-purple-300 border-purple-200 dark:border-purple-900',
            'icon' => 'fas fa-id-card-alt',
            'desc' => 'تسجيل الدخول إلى شؤون الموظفين والاستقبال',
        ],
        'patient' => [
            'name_ar' => 'مريض',
            'name_en' => 'Patient Portal',
            'badge' => 'bg-blue-50 text-blue-700 dark:bg-blue-950/50 dark:text-blue-300 border-blue-200 dark:border-blue-900',
            'icon' => 'fas fa-user',
            'desc' => 'تسجيل الدخول إلى ملفك الطبي ومواعيد كشوفاتك',
        ],
        default => null,
    };
@endphp

<x-layouts::auth :title="__('تسجيل الدخول') . ($roleInfo ? ' - ' . $roleInfo['name_ar'] : '')">
    <div class="flex flex-col gap-6">

        @if ($roleInfo)
            <!-- Role Indicator Banner -->
            <div class="p-3.5 rounded-xl border flex items-center justify-between {{ $roleInfo['badge'] }}">
                <div class="flex items-center gap-3">
                    <span class="text-lg">
                        @if ($selectedRole === 'admin') 🛡️
                        @elseif ($selectedRole === 'doctor') 🩺
                        @elseif ($selectedRole === 'hr') 👔
                        @else 👤
                        @endif
                    </span>
                    <div>
                        <div class="text-sm font-bold flex items-center gap-1.5">
                            <span>تسجيل الدخول كـ:</span>
                            <span class="underline decoration-2">{{ $roleInfo['name_ar'] }}</span>
                            <span class="text-xs opacity-75">({{ $roleInfo['name_en'] }})</span>
                        </div>
                        <p class="text-xs opacity-80 mt-0.5">{{ $roleInfo['desc'] }}</p>
                    </div>
                </div>
                <a href="{{ route('choose-role') }}" class="text-xs font-semibold hover:underline px-2 py-1 rounded bg-white/40 dark:bg-black/30">
                    تغيير
                </a>
            </div>
        @else
            <x-auth-header :title="__('تسجيل الدخول')" :description="__('أدخل بريدك الإلكتروني وكلمة المرور للمتابعة')" />
        @endif

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6">
            @csrf

            @if ($selectedRole)
                <input type="hidden" name="role" value="{{ $selectedRole }}">
            @endif

            <!-- Email Address -->
            <div>
                <flux:input
                    name="email"
                    :label="__('البريد الإلكتروني')"
                    :value="old('email')"
                    type="email"
                    required
                    autofocus
                    autocomplete="email"
                    placeholder="email@example.com"
                />
            </div>

            <!-- Password -->
            <div class="relative">
                <flux:input
                    name="password"
                    :label="__('كلمة المرور')"
                    type="password"
                    required
                    autocomplete="current-password"
                    :placeholder="__('كلمة المرور')"
                    viewable
                />

                @if (Route::has('password.request'))
                    <flux:link class="absolute top-0 text-sm end-0" :href="route('password.request')" wire:navigate>
                        {{ __('نسيت كلمة المرور؟') }}
                    </flux:link>
                @endif
            </div>

            <!-- Remember Me -->
            <flux:checkbox name="remember" :label="__('تذكرني')" :checked="old('remember')" />

            <div class="flex flex-col gap-3">
                <flux:button variant="primary" type="submit" class="w-full" data-test="login-button">
                    {{ __('تسجيل الدخول') }}
                </flux:button>

                <div class="text-center">
                    <a href="{{ route('choose-role') }}" class="text-xs text-zinc-500 hover:text-zinc-800 dark:hover:text-zinc-200 transition">
                        &larr; {{ __('الرجوع لاختيار نوع الحساب') }}
                    </a>
                </div>
            </div>
        </form>

    </div>
</x-layouts::auth>
