<div class="flex flex-col gap-6">
    <div class="text-center">
        <h1 class="text-xl font-bold text-zinc-900 dark:text-white">
            {{ __('تغيير كلمة المرور المؤقتة') }}
        </h1>
        <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
            {{ __('تم تسجيل دخولك بكلمة مرور مؤقتة، لأمان حسابك يرجى تعيين كلمة مرور جديدة للمتابعة.') }}
        </p>
    </div>

    @if (session('warning'))
        <div class="p-3 text-sm font-medium text-amber-800 bg-amber-50 rounded-lg dark:bg-amber-900/30 dark:text-amber-300 border border-amber-200 dark:border-amber-800">
            {{ session('warning') }}
        </div>
    @endif

    <form wire:submit="updatePassword" class="flex flex-col gap-5">
        <!-- Current Password -->
        <div>
            <flux:input
                wire:model="current_password"
                :label="__('كلمة المرور الحالية (المؤقتة)')"
                type="password"
                required
                viewable
            />
            @error('current_password') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
        </div>

        <!-- New Password -->
        <div>
            <flux:input
                wire:model="password"
                :label="__('كلمة المرور الجديدة')"
                type="password"
                required
                viewable
            />
            @error('password') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
        </div>

        <!-- Confirm New Password -->
        <div>
            <flux:input
                wire:model="password_confirmation"
                :label="__('تأكيد كلمة المرور الجديدة')"
                type="password"
                required
                viewable
            />
        </div>

        <flux:button variant="primary" type="submit" class="w-full mt-2">
            {{ __('حفظ وتعيين كلمة المرور') }}
        </flux:button>
    </form>

    <form method="POST" action="{{ route('logout') }}" class="text-center">
        @csrf
        <button type="submit" class="text-xs text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 underline">
            {{ __('تسجيل الخروج') }}
        </button>
    </form>
</div>
