@php
    $emergencyPhone = \App\Models\SiteSetting::get('emergency_phone', '19000');
    $hotlinePhone   = \App\Models\SiteSetting::get('hotline_phone', '16000');
    $user           = auth()->user();
    $locale         = app()->getLocale();
    $isRtl          = $locale === 'ar';
@endphp

<header
    data-sticky-header
    id="public-sticky-header"
    x-data="{ mobileMenu: false, userDropdown: false }"
    x-init="$watch('mobileMenu', value => document.body.classList.toggle('overflow-hidden', value))"
    class="sticky top-0 z-50 w-full bg-white/95 backdrop-blur-md border-b border-slate-100 shadow-sm transition-all duration-300"
>
    <div class="max-w-7xl 2xl:max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20 gap-3 sm:gap-4">

            {{-- 1. Brand Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 sm:gap-3 group text-decoration-none shrink-0">
                <img src="{{ URL::asset('Dashboard/img/brand/favicon.png') }}"
                     class="h-9 sm:h-10 w-auto object-contain transition-transform group-hover:scale-105" alt="logo">
                <span class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight leading-none">
                    Hos<span class="text-[#0162e8]">pi</span>tal
                </span>
            </a>

            {{-- 2. Desktop Navigation Menu --}}
            <nav class="hidden xl:flex items-center gap-5 2xl:gap-7">
                <a href="{{ route('home') }}#hero" class="text-sm font-bold text-slate-900 hover:text-sky-600 transition">
                    {{ __('messages.nav_home') }}
                </a>
                <a href="{{ route('home') }}#about" class="text-sm font-semibold text-slate-600 hover:text-sky-600 transition">
                    {{ __('messages.nav_about') }}
                </a>
                <a href="{{ route('home') }}#departments" class="text-sm font-semibold text-slate-600 hover:text-sky-600 transition">
                    {{ __('messages.nav_departments') }}
                </a>
                <a href="{{ route('home') }}#services" class="text-sm font-semibold text-slate-600 hover:text-sky-600 transition">
                    {{ __('messages.nav_services') }}
                </a>
                <a href="{{ route('home') }}#doctors" class="text-sm font-semibold text-slate-600 hover:text-sky-600 transition">
                    {{ __('messages.nav_doctors') }}
                </a>
                <a href="{{ route('home') }}#pharmacy" class="text-sm font-semibold text-slate-600 hover:text-sky-600 transition">
                    {{ __('messages.nav_pharmacy') }}
                </a>
                <a href="{{ route('home') }}#medical-info" class="text-sm font-semibold text-slate-600 hover:text-sky-600 transition">
                    {{ __('messages.nav_medical_info') }}
                </a>
            </nav>

            {{-- 3. Header Action Buttons (Emergency Hotline, Language Switcher, Sign in, Book appointment) --}}
            <div class="hidden xl:flex items-center gap-2.5 2xl:gap-3 shrink-0">
                {{-- Emergency Hotline (Red Pill with pulse) --}}
                <a
                    href="tel:{{ preg_replace('/[^0-9+]/', '', $emergencyPhone) }}"
                    class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full border border-rose-200 bg-rose-50/80 text-rose-600 hover:bg-rose-100 transition text-xs font-bold"
                    title="{{ __('messages.emergency_247') }}"
                >
                    <i class="fas fa-heart-pulse text-rose-500 animate-pulse text-xs"></i>
                    <span>{{ $isRtl ? 'طوارئ' : 'Emergency' }}</span>
                    <span dir="ltr" class="font-extrabold">{{ $emergencyPhone }}</span>
                </a>

                {{-- Language Switcher --}}
                <x-language-switcher />

                @guest
                    {{-- Sign In (Light Blue Pill) --}}
                    <a
                        href="{{ route('login') }}"
                        class="inline-flex items-center justify-center px-4 py-2 rounded-xl border border-sky-200 bg-sky-50/80 text-sky-700 hover:bg-sky-100 font-bold text-xs transition"
                    >
                        <span>{{ __('messages.sign_in') }}</span>
                    </a>

                    {{-- Book Appointment (Dark Teal Solid Button) --}}
                    <a
                        href="{{ route('register') }}"
                        class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-[#084c61] hover:bg-[#063b4c] text-white font-bold text-xs shadow-sm transition"
                    >
                        <span>{{ $isRtl ? 'احجز موعد' : 'Book Appointment' }}</span>
                    </a>
                @else
                    {{-- User Dropdown --}}
                    <div class="relative" @click.away="userDropdown = false">
                        <button
                            type="button"
                            @click="userDropdown = !userDropdown"
                            class="inline-flex items-center gap-2 text-xs font-bold text-slate-800 bg-slate-100 hover:bg-slate-200 px-3.5 py-2 rounded-xl transition"
                        >
                            <i class="fas fa-user-circle text-sky-600 text-sm"></i>
                            <span class="max-w-[120px] truncate">{{ $user->name }}</span>
                            <i class="fas fa-chevron-down text-[10px] text-slate-500 transition-transform duration-200" :class="userDropdown ? 'rotate-180' : ''"></i>
                        </button>

                        <div
                            x-show="userDropdown"
                            x-cloak
                            x-transition
                            class="absolute end-0 mt-2 w-52 bg-white rounded-2xl shadow-xl border border-slate-100 p-2 z-[120]"
                        >
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-3 py-2 text-xs font-bold text-slate-700 hover:bg-sky-50 hover:text-sky-600 rounded-xl transition">
                                <i class="fas fa-th-large text-slate-400 w-4"></i>
                                <span>{{ __('messages.my_dashboard') }}</span>
                            </a>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-sky-50 hover:text-sky-600 rounded-xl transition">
                                <i class="fas fa-id-card text-slate-400 w-4"></i>
                                <span>{{ __('messages.profile') }}</span>
                            </a>
                            <div class="border-t border-slate-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-xs font-bold text-rose-600 hover:bg-rose-50 rounded-xl transition text-start">
                                    <i class="fas fa-sign-out-alt text-rose-400 w-4"></i>
                                    <span>{{ __('messages.logout') }}</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>

            {{-- 4. Mobile / Tablet Hamburger & Quick Call --}}
            <div class="flex xl:hidden items-center gap-2 shrink-0">
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $emergencyPhone) }}" class="p-2.5 rounded-xl bg-rose-50 text-rose-600 border border-rose-200 hover:bg-rose-100 transition" title="{{ $emergencyPhone }}">
                    <i class="fas fa-phone-alt text-xs"></i>
                </a>
                <button
                    type="button"
                    @click="mobileMenu = !mobileMenu"
                    class="p-2.5 rounded-xl text-slate-700 hover:bg-slate-100 border border-slate-200/80 transition focus:outline-none focus:ring-2 focus:ring-sky-500/20"
                    aria-label="Toggle navigation menu"
                >
                    <i class="fas text-lg transition-transform duration-200" :class="mobileMenu ? 'fa-times text-rose-500' : 'fa-bars'"></i>
                </button>
            </div>

        </div>
    </div>

    {{-- ================= MOBILE OFF-CANVAS DRAWER (Teleported to body to prevent backdrop-filter clipping) ================= --}}
    <template x-teleport="body">
        <div
            x-show="mobileMenu"
            x-cloak
            class="fixed inset-0 z-[9999] xl:hidden"
        >
            {{-- Backdrop --}}
            <div
                x-show="mobileMenu"
                x-transition:enter="transition-opacity ease-linear duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-linear duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @click="mobileMenu = false"
                class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"
            ></div>

            {{-- Slide Drawer --}}
            <div
                x-show="mobileMenu"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="{{ $isRtl ? 'translate-x-full' : '-translate-x-full' }}"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="{{ $isRtl ? 'translate-x-full' : '-translate-x-full' }}"
                class="fixed inset-y-0 {{ $isRtl ? 'right-0' : 'left-0' }} max-w-xs sm:max-w-sm w-full bg-white shadow-2xl p-6 flex flex-col justify-between overflow-y-auto z-10"
            >
                <div>
                    {{-- Drawer Header --}}
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-6">
                        <a href="{{ route('home') }}" @click="mobileMenu = false" class="flex items-center gap-2.5 text-decoration-none">
                            <img src="{{ URL::asset('Dashboard/img/brand/favicon.png') }}"
                                 class="h-8 w-auto object-contain" alt="logo">
                            <span class="text-xl font-extrabold text-slate-900 tracking-tight leading-none">
                                Hos<span class="text-[#0162e8]">pi</span>tal
                            </span>
                        </a>
                        <button
                            type="button"
                            @click="mobileMenu = false"
                            class="p-2 rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition"
                            aria-label="Close menu"
                        >
                            <i class="fas fa-times text-base"></i>
                        </button>
                    </div>

                    {{-- Drawer Navigation Links --}}
                    <nav class="flex flex-col gap-1.5">
                        <a href="{{ route('home') }}#hero" @click="mobileMenu = false" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:bg-sky-50 hover:text-sky-600 transition">
                            <i class="fas fa-home w-5 text-sky-500"></i>
                            <span>{{ __('messages.nav_home') }}</span>
                        </a>
                        <a href="{{ route('home') }}#about" @click="mobileMenu = false" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:bg-sky-50 hover:text-sky-600 transition">
                            <i class="fas fa-hospital w-5 text-sky-500"></i>
                            <span>{{ __('messages.nav_about') }}</span>
                        </a>
                        <a href="{{ route('home') }}#departments" @click="mobileMenu = false" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:bg-sky-50 hover:text-sky-600 transition">
                            <i class="fas fa-stethoscope w-5 text-sky-500"></i>
                            <span>{{ __('messages.nav_departments') }}</span>
                        </a>
                        <a href="{{ route('home') }}#services" @click="mobileMenu = false" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:bg-sky-50 hover:text-sky-600 transition">
                            <i class="fas fa-briefcase-medical w-5 text-sky-500"></i>
                            <span>{{ __('messages.nav_services') }}</span>
                        </a>
                        <a href="{{ route('home') }}#doctors" @click="mobileMenu = false" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:bg-sky-50 hover:text-sky-600 transition">
                            <i class="fas fa-user-md w-5 text-sky-500"></i>
                            <span>{{ __('messages.nav_doctors') }}</span>
                        </a>
                        <a href="{{ route('home') }}#pharmacy" @click="mobileMenu = false" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:bg-sky-50 hover:text-sky-600 transition">
                            <i class="fas fa-pills w-5 text-emerald-500"></i>
                            <span>{{ __('messages.nav_pharmacy') }}</span>
                        </a>
                        <a href="{{ route('home') }}#medical-info" @click="mobileMenu = false" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:bg-sky-50 hover:text-sky-600 transition">
                            <i class="fas fa-book-medical w-5 text-purple-500"></i>
                            <span>{{ __('messages.nav_medical_info') }}</span>
                        </a>
                    </nav>
                </div>

                {{-- Drawer Bottom Actions --}}
                <div class="pt-6 border-t border-slate-100 flex flex-col gap-3">
                    <div class="flex justify-center pb-2">
                        <x-language-switcher />
                    </div>

                    @guest
                        <a href="{{ route('login') }}" class="w-full flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl border border-sky-200 text-sky-700 font-bold text-sm bg-sky-50/70 hover:bg-sky-100 transition">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>{{ __('messages.sign_in') }}</span>
                        </a>

                        <a href="{{ route('register') }}" class="w-full flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl bg-[#084c61] text-white font-bold text-sm shadow hover:bg-[#063b4c] transition">
                            <i class="fas fa-calendar-check"></i>
                            <span>{{ $isRtl ? 'احجز موعد' : 'Book Appointment' }}</span>
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="w-full flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl bg-[#084c61] text-white font-bold text-sm shadow hover:bg-[#063b4c] transition">
                            <i class="fas fa-th-large"></i>
                            <span>{{ __('messages.my_dashboard') }}</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl border border-rose-200 text-rose-600 font-bold text-sm hover:bg-rose-50 transition">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>{{ __('messages.logout') }}</span>
                            </button>
                        </form>
                    @endguest

                    <div class="text-center pt-2 flex flex-col items-center gap-2">
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $emergencyPhone) }}" class="text-xs text-rose-600 font-bold inline-flex items-center justify-center gap-1.5">
                            <span class="emergency-pulse-dot"></span>
                            <span>{{ __('messages.emergency_247') }}: {{ $emergencyPhone }}</span>
                        </a>
                        @if (!empty($hotlinePhone))
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $hotlinePhone) }}" class="text-xs text-sky-600 font-semibold inline-flex items-center justify-center gap-1.5">
                                <i class="fas fa-headset text-sky-500 text-xs"></i>
                                <span>{{ $isRtl ? 'الخط الساخن' : 'Hotline' }}: <span dir="ltr">{{ $hotlinePhone }}</span></span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </template>
</header>
