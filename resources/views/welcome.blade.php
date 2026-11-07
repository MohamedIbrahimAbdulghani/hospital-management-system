@php
    $locale = app()->getLocale();
    $isRtl  = $locale === 'ar';
    $emergencyPhone = $settings->emergency_phone ?? \App\Models\SiteSetting::get('emergency_phone', '19000');
    $hotlinePhone   = $settings->hotline_phone ?? \App\Models\SiteSetting::get('hotline_phone', '16000');
    $hospitalEmail  = $settings->hospital_email ?? \App\Models\SiteSetting::get('hospital_email', 'support@aura-hospital.com');
    $hospitalAddress = $settings->hospital_address ?? ($isRtl
        ? \App\Models\SiteSetting::get('hospital_address_ar', 'طريق الملك فهد، حي العقيق الطبي')
        : \App\Models\SiteSetting::get('hospital_address_en', 'King Fahd Road, Al-Aqeeq Medical District'));

    // أيقونات وألوان الأقسام (التصميم فقط - النصوص من ملف الترجمة)
    $deptStyles = [
        'cardio'   => ['icon' => 'fa-heart-pulse',  'box' => 'bg-rose-50 text-rose-600',       'badge' => 'text-slate-500 bg-slate-100'],
        'peds'     => ['icon' => 'fa-baby',         'box' => 'bg-teal-50 text-teal-600',       'badge' => 'text-teal-700 bg-teal-50'],
        'ortho'    => ['icon' => 'fa-bone',         'box' => 'bg-purple-50 text-purple-600',   'badge' => 'text-purple-700 bg-purple-50'],
        'internal' => ['icon' => 'fa-stethoscope',  'box' => 'bg-sky-50 text-sky-600',         'badge' => 'text-sky-700 bg-sky-50'],
        'neuro'    => ['icon' => 'fa-brain',        'box' => 'bg-indigo-50 text-indigo-600',   'badge' => 'text-indigo-700 bg-indigo-50'],
        'women'    => ['icon' => 'fa-venus',        'box' => 'bg-emerald-50 text-emerald-600', 'badge' => 'text-emerald-700 bg-emerald-50'],
    ];

    $pillarStyles = [
        ['icon' => 'fa-heart-circle-check', 'box' => 'bg-rose-50 text-rose-600'],
        ['icon' => 'fa-microscope',         'box' => 'bg-sky-50 text-sky-600'],
        ['icon' => 'fa-award',              'box' => 'bg-emerald-50 text-emerald-600'],
    ];

    $statStyles = [
        'patients' => ['icon' => 'fa-users',         'box' => 'bg-sky-50 text-sky-600',       'chip' => 'text-teal-700 bg-teal-50',       'counter' => ['250000', '+ ', 'comma'], 'display' => '+ 250,000'],
        'units'    => ['icon' => 'fa-hospital-user', 'box' => 'bg-teal-50 text-teal-600',     'chip' => 'text-emerald-700 bg-emerald-50', 'counter' => ['45', '+', null],         'display' => '+45'],
        'or'       => ['icon' => 'fa-shield-virus',  'box' => 'bg-indigo-50 text-indigo-600', 'chip' => 'text-indigo-700 bg-indigo-50',   'counter' => ['15', null, null],        'display' => '15'],
        'response' => ['icon' => 'fa-bolt',          'box' => 'bg-rose-50 text-rose-600',     'chip' => 'text-rose-700 bg-rose-50',       'counter' => null,                      'display' => null],
    ];

    $articleStyles = [
        'heart'     => ['icon' => 'fa-heart-pulse', 'cover' => 'bg-rose-50 text-rose-500',       'tag' => 'text-rose-600 bg-rose-50'],
        'nutrition' => ['icon' => 'fa-apple-whole', 'cover' => 'bg-emerald-50 text-emerald-500', 'tag' => 'text-emerald-600 bg-emerald-50'],
        'immunity'  => ['icon' => 'fa-shield-virus','cover' => 'bg-purple-50 text-purple-500',   'tag' => 'text-purple-600 bg-purple-50'],
        'ortho'     => ['icon' => 'fa-bone',        'cover' => 'bg-sky-50 text-sky-500',         'tag' => 'text-sky-600 bg-sky-50'],
        'neuro'     => ['icon' => 'fa-brain',       'cover' => 'bg-indigo-50 text-indigo-500',   'tag' => 'text-indigo-600 bg-indigo-50'],
    ];

    $heroChips = [
        'reception' => ['icon' => 'fa-hospital',    'color' => 'text-sky-400'],
        'clinics'   => ['icon' => 'fa-stethoscope', 'color' => 'text-cyan-400'],
        'icu'       => ['icon' => 'fa-heart-pulse', 'color' => 'text-rose-400 animate-pulse'],
        'pharmacy'  => ['icon' => 'fa-pills',       'color' => 'text-emerald-400'],
        'labs'      => ['icon' => 'fa-flask-vial',  'color' => 'text-purple-400'],
    ];

    $quickLinkHrefs = [route('register'), route('login'), '#pharmacy', route('home'), '#doctors'];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', $locale) }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('welcome.meta.title') }}</title>
    <meta name="description" content="{{ __('welcome.meta.description') }}">

    <!-- Favicon -->
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <!-- Google Fonts (Tajawal for Arabic, Plus Jakarta Sans for English) -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Tajawal:wght@400;500;700;800;900&display=swap" rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        aura: {
                            navy: '#084c61',
                            teal: '#0a546e',
                            cyan: '#0284c7',
                            light: '#e0f2fe'
                        }
                    },
                    fontFamily: {
                        sans: ['{{ $isRtl ? "Tajawal" : "Plus Jakarta Sans" }}', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Custom Modern Healthcare Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">

    <!-- Custom JavaScript with Loop Carousel -->
    <script src="{{ asset('js/home.js') }}"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        body {
            font-family: '{{ $isRtl ? "Tajawal" : "Plus Jakarta Sans" }}', sans-serif;
            background-color: #fbfcfd;
        }
    </style>
</head>
<body class="selection:bg-sky-600 selection:text-white text-slate-800">

    <!-- Reading / Scroll Progress Bar -->
    <div id="scroll-progress-bar" class="scroll-progress-bar"></div>

    @include('partials.global-loader')

    <!-- Sticky Header & Navbar -->
    <x-public-header />

    <!-- =========================================================================
         1. HERO SECTION (#hero)
         ========================================================================= -->
    <section id="hero" class="relative min-h-[82vh] lg:min-h-[88vh] flex items-center justify-center overflow-hidden bg-slate-950 text-white py-16 sm:py-24">

        <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
            <video
                autoplay
                muted
                loop
                playsinline
                poster="{{ URL::asset('Dashboard/img/hero-surgeons.jpg') }}"
                class="absolute inset-0 w-full h-full object-cover filter brightness-[0.58] contrast-[1.12] transition-opacity duration-1000 scale-105"
            >
                <source src="{{ asset('videos/hospital-interior.webm') }}" type="video/webm">
                <source src="{{ asset('videos/doctors-consulting.mp4') }}" type="video/mp4">
                <source src="{{ asset('videos/hospital-hero.mp4') }}" type="video/mp4">
            </video>

            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/60 to-slate-950/80"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950/85 via-slate-950/40 to-slate-950/85"></div>

            <div class="absolute top-1/4 start-1/2 -translate-x-1/2 w-[600px] h-[300px] bg-sky-500/20 rounded-full blur-[120px] pointer-events-none"></div>
            <div class="absolute -bottom-10 inset-x-0 h-36 bg-gradient-to-t from-[#fbfcfd] to-transparent"></div>
        </div>

        <div class="relative z-10 w-full max-w-5xl px-4 mx-auto text-center sm:px-6 lg:px-8">

            <!-- 1. Badge -->
            <div class="hero-drop-1 inline-flex items-center gap-2.5 px-5 py-2.5 rounded-full bg-white/10 hover:bg-white/15 backdrop-blur-xl text-sky-200 text-xs sm:text-sm font-bold mb-7 border border-white/20 shadow-2xl shadow-sky-950/50 transition">
                <span class="relative flex w-3 h-3">
                    <span class="absolute inline-flex w-full h-full rounded-full animate-ping bg-cyan-400 opacity-80"></span>
                    <span class="relative inline-flex w-3 h-3 rounded-full bg-cyan-400"></span>
                </span>
                <span class="tracking-wide">{{ __('welcome.hero.badge') }}</span>
                <i class="text-xs fas fa-certificate text-sky-400"></i>
            </div>

            <!-- 2. Headline -->
            <h1 class="hero-drop-2 text-3xl sm:text-5xl md:text-6xl lg:text-7xl font-black text-white tracking-tight leading-[1.25] sm:leading-[1.18] mb-6 drop-shadow-2xl">
                {{ __('welcome.hero.title1') }} <br>
                <span class="text-gradient-shimmer">{{ __('welcome.hero.title2') }}</span>
            </h1>

            <!-- 3. Facility chips -->
            <div class="hero-drop-3 flex flex-wrap items-center justify-center gap-2.5 sm:gap-3 max-w-4xl mx-auto mb-7">
                @foreach ($heroChips as $key => $chip)
                    <div class="hero-facility-chip inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-xs sm:text-sm font-semibold text-slate-100 shadow-sm">
                        <i class="fas {{ $chip['icon'] }} {{ $chip['color'] }}"></i>
                        <span>{{ __('welcome.hero.chips.' . $key) }}</span>
                    </div>
                @endforeach
            </div>

            <!-- 4. Description -->
            <p class="max-w-3xl mx-auto text-sm font-medium leading-relaxed hero-drop-4 sm:text-lg md:text-xl text-slate-200/90 mb-9 drop-shadow">
                {{ __('welcome.hero.desc') }}
            </p>

            <!-- 5. CTAs -->
            <div class="flex flex-wrap items-center justify-center gap-4 hero-drop-5 sm:gap-5">
                <a href="{{ route('register') }}" class="inline-flex items-center gap-3 px-8 py-4 text-sm font-black text-white transition transform shadow-2xl btn-shimmer btn-ripple group bg-gradient-to-r from-sky-500 via-blue-600 to-sky-600 hover:from-sky-400 hover:to-blue-500 rounded-2xl sm:text-base shadow-sky-500/40 hover:-translate-y-1">
                    <span>{{ __('welcome.hero.book') }}</span>
                    <i class="text-base transition-transform fas fa-calendar-check group-hover:rotate-12"></i>
                </a>

                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $emergencyPhone) }}" class="inline-flex items-center gap-3 py-4 text-sm font-black text-white transition transform border shadow-2xl btn-ripple bg-rose-600 hover:bg-rose-500 px-7 rounded-2xl sm:text-base border-rose-400/40 shadow-rose-900/50 hover:-translate-y-1">
                    <span class="relative flex w-3 h-3">
                        <span class="absolute inline-flex w-full h-full bg-white rounded-full animate-ping opacity-80"></span>
                        <span class="relative inline-flex w-3 h-3 bg-white rounded-full"></span>
                    </span>
                    <i class="text-base fas fa-phone-volume"></i>
                    <span>{{ __('welcome.hero.hotline') }}</span>
                    <span dir="ltr" class="font-black tracking-wide">{{ $emergencyPhone }}</span>
                </a>

                <a href="#departments" class="inline-flex items-center gap-2.5 px-6 py-4 rounded-2xl bg-white/10 hover:bg-white/20 backdrop-blur-xl border border-white/20 text-white font-bold text-sm sm:text-base shadow-lg transition transform hover:-translate-y-1">
                    <i class="fas fa-compass text-sky-400"></i>
                    <span>{{ __('welcome.hero.explore') }}</span>
                </a>
            </div>

            <!-- Scroll indicator -->
            <div class="pt-12 sm:pt-16">
                <a href="#quick-search" class="inline-flex flex-col items-center gap-2 text-xs font-semibold transition text-slate-400 hover:text-white group">
                    <span class="transition opacity-75 group-hover:opacity-100">{{ __('welcome.hero.scroll') }}</span>
                    <div class="flex items-center justify-center w-8 h-8 border rounded-full shadow-sm hero-scroll-indicator border-white/20 bg-white/5 backdrop-blur-md text-sky-400">
                        <i class="text-xs fas fa-chevron-down"></i>
                    </div>
                </a>
            </div>

        </div>
    </section>

    <!-- =========================================================================
         2. QUICK SEARCH & APPOINTMENT SCHEDULING
         ========================================================================= -->
    <section id="quick-search" class="relative z-30 px-4 mx-auto mb-20 -mt-6 max-w-7xl sm:px-6 lg:px-8 reveal">
        <div class="p-6 bg-white border shadow-xl rounded-3xl border-slate-200/80 sm:p-8 hover-lift">
            <div class="flex flex-col justify-between gap-2 pb-5 border-b sm:flex-row sm:items-center border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 font-bold shadow-sm card-icon-box rounded-2xl bg-sky-50 text-sky-600">
                        <i class="text-base fas fa-calendar-alt"></i>
                    </div>
                    <h3 class="text-base font-bold sm:text-lg text-slate-900">{{ __('welcome.search.title') }}</h3>
                </div>
                <p class="text-xs font-medium text-slate-500">{{ __('welcome.search.subtitle') }}</p>
            </div>

            <form action="{{ route('register') }}" method="GET" class="grid items-end grid-cols-1 gap-4 pt-5 md:grid-cols-12">
                <!-- Specialty -->
                <div class="md:col-span-3">
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ __('welcome.search.specialty') }}</label>
                    <select class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500 transition">
                        <option value="">{{ __('welcome.search.all_specialties') }}</option>
                        @foreach ($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Doctor / Clinic -->
                <div class="md:col-span-4">
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ __('welcome.search.doctor_or_clinic') }}</label>
                    <div class="relative">
                        <i class="fas fa-search absolute inset-y-0 {{ $isRtl ? 'right-3' : 'left-3' }} flex items-center text-slate-400 text-xs pointer-events-none"></i>
                        <input
                            type="text"
                            placeholder="{{ __('welcome.search.search_placeholder') }}"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl {{ $isRtl ? 'pr-9 pl-3.5' : 'pl-9 pr-3.5' }} py-2.5 text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500 transition"
                        >
                    </div>
                </div>

                <!-- Date -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ __('welcome.search.date') }}</label>
                    <input
                        type="date"
                        value="{{ date('Y-m-d') }}"
                        min="{{ date('Y-m-d') }}"
                        class="w-full px-3 py-2 text-xs font-semibold transition border bg-slate-50 border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500"
                    >
                </div>

                <!-- Submit -->
                <div class="md:col-span-3">
                    <button type="submit" class="btn-shimmer btn-ripple w-full bg-[#084c61] hover:bg-[#063b4c] text-white py-2.5 px-4 rounded-xl font-bold text-xs flex items-center justify-center gap-2 shadow-sm transition">
                        <i class="text-xs fas fa-search"></i>
                        <span>{{ __('welcome.search.submit') }}</span>
                    </button>
                </div>
            </form>

            <!-- Quick Tags -->
            <div class="flex flex-wrap items-center gap-2 pt-4 text-xs">
                <span class="text-slate-400 font-bold text-[11px]">{{ __('welcome.search.trending') }}</span>
                @foreach (__('welcome.search.tags') as $tag)
                    <a href="#departments" class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 text-[11px] font-semibold hover:bg-sky-50 hover:text-sky-600 transition">
                        {{ $tag }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- =========================================================================
         3. ABOUT US (#about)
         ========================================================================= -->
    <section id="about" class="relative py-16 bg-slate-50/60">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">

            <div class="max-w-3xl mx-auto text-center mb-14 reveal">
                <span class="text-sky-600 font-bold text-xs uppercase tracking-wider bg-sky-50 px-3.5 py-1 rounded-full">
                    {{ __('welcome.about.badge') }}
                </span>
                <h2 class="mt-3 mb-3 text-2xl font-extrabold sm:text-3xl lg:text-4xl text-slate-900">
                    {{ __('welcome.about.title') }}
                </h2>
                <p class="max-w-2xl mx-auto text-xs leading-relaxed text-slate-600 sm:text-sm">
                    {{ __('welcome.about.desc') }}
                </p>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                @foreach (__('welcome.about.pillars') as $i => $pillar)
                    <div class="hover-lift reveal reveal-delay-{{ $i + 1 }} bg-white rounded-2xl p-7 border border-slate-200/80 shadow-sm flex flex-col justify-between">
                        <div>
                            <div class="card-icon-box w-12 h-12 rounded-2xl {{ $pillarStyles[$i]['box'] }} flex items-center justify-center text-xl mb-4">
                                <i class="fas {{ $pillarStyles[$i]['icon'] }}"></i>
                            </div>
                            <h3 class="mb-2 text-base font-bold text-slate-900">{{ $pillar['title'] }}</h3>
                            <p class="text-xs leading-relaxed text-slate-500">{{ $pillar['desc'] }}</p>
                        </div>
                        <div class="flex items-center gap-2 pt-5 mt-4 text-xs font-bold border-t border-slate-100 text-sky-600">
                            <i class="text-xs fas fa-check-circle"></i>
                            <span>{{ $pillar['footer'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

    <!-- =========================================================================
         4. DEPARTMENTS (#departments)
         ========================================================================= -->
    <section id="departments" class="relative py-16 bg-white" x-data="infiniteCarousel()">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">

            <div class="flex flex-col justify-between gap-4 mb-10 md:flex-row md:items-end reveal">
                <div>
                    <span class="text-sky-600 font-bold text-xs uppercase tracking-wider bg-sky-50 px-3.5 py-1 rounded-full">
                        {{ __('welcome.departments.badge') }}
                    </span>
                    <h2 class="mt-3 mb-2 text-2xl font-extrabold sm:text-3xl lg:text-4xl text-slate-900">
                        {{ __('welcome.departments.title') }}
                    </h2>
                    <p class="max-w-xl text-xs text-slate-600 sm:text-sm">
                        {{ __('welcome.departments.desc') }}
                    </p>
                </div>
            </div>

            <div class="slider-wrapper">
                <button type="button" @click="prev()" class="flex slider-side-btn btn-prev" aria-label="{{ __('welcome.common.prev') }}">
                    <i class="fas {{ $isRtl ? 'fa-chevron-right' : 'fa-chevron-left' }}"></i>
                </button>

                <div class="slider-viewport">
                    <div x-ref="track" class="slider-track">
                        @foreach (__('welcome.departments.items') as $key => $item)
                            <div class="flex flex-col justify-between p-6 bg-white border shadow-sm slider-card hover-lift rounded-2xl border-slate-200/80">
                                <div>
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="card-icon-box w-12 h-12 rounded-2xl {{ $deptStyles[$key]['box'] }} flex items-center justify-center text-xl">
                                            <i class="fas {{ $deptStyles[$key]['icon'] }}"></i>
                                        </div>
                                        <span class="text-[11px] font-bold {{ $deptStyles[$key]['badge'] }} px-2.5 py-1 rounded-full">
                                            {{ $item['badge'] }}
                                        </span>
                                    </div>
                                    <h3 class="mb-2 text-base font-bold text-slate-900">{{ $item['title'] }}</h3>
                                    <p class="mb-6 text-xs leading-relaxed text-slate-500">{{ $item['desc'] }}</p>
                                </div>
                                <div class="flex items-center justify-between pt-4 text-xs border-t border-slate-100">
                                    <span class="font-bold text-slate-600">{{ $item['count'] }}</span>
                                    <a href="{{ route('register') }}" class="text-sky-600 hover:text-sky-700 font-bold inline-flex items-center gap-1.5 transition">
                                        <span>{{ __('welcome.departments.details') }}</span>
                                        <i class="fas fa-arrow-left text-[10px]"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <button type="button" @click="next()" class="flex slider-side-btn btn-next" aria-label="{{ __('welcome.common.next') }}">
                    <i class="fas {{ $isRtl ? 'fa-chevron-left' : 'fa-chevron-right' }}"></i>
                </button>
            </div>

        </div>
    </section>

    <!-- =========================================================================
         5. SERVICES (#services)
         ========================================================================= -->
    <section id="services" class="relative py-16 bg-slate-50/70" x-data="infiniteCarousel()">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">

            <div class="flex flex-col justify-between gap-4 mb-10 md:flex-row md:items-end reveal">
                <div>
                    <span class="text-sky-600 font-bold text-xs uppercase tracking-wider bg-sky-50 px-3.5 py-1 rounded-full">
                        {{ __('welcome.services.badge') }}
                    </span>
                    <h2 class="mt-3 mb-2 text-2xl font-extrabold sm:text-3xl lg:text-4xl text-slate-900">
                        {{ __('welcome.services.title') }}
                    </h2>
                    <p class="max-w-xl text-xs text-slate-600 sm:text-sm">
                        {{ __('welcome.services.desc') }}
                    </p>
                </div>
            </div>

            <div class="slider-wrapper">
                <button type="button" @click="prev()" class="flex slider-side-btn btn-prev" aria-label="{{ __('welcome.common.prev') }}">
                    <i class="fas {{ $isRtl ? 'fa-chevron-right' : 'fa-chevron-left' }}"></i>
                </button>

                <div class="slider-viewport">
                    <div x-ref="track" class="slider-track">
                        @forelse ($services as $service)
                            <div class="flex flex-col justify-between p-6 bg-white border shadow-sm slider-card hover-lift rounded-2xl border-slate-200/80">
                                <div>
                                    <div class="flex items-center justify-center w-12 h-12 mb-4 text-xl card-icon-box rounded-2xl bg-sky-50 text-sky-600">
                                        <i class="fas {{ str_starts_with($service->icon ?? '', 'fa-') ? $service->icon : ($service->icon ? 'fa-' . $service->icon : 'fa-briefcase-medical') }}"></i>
                                    </div>
                                    <h3 class="mb-2 text-base font-bold text-slate-900">{{ $service->title }}</h3>
                                    <p class="mb-6 text-xs leading-relaxed text-slate-500">{{ $service->description }}</p>
                                </div>
                                <div class="flex items-center justify-between pt-4 text-xs border-t border-slate-100">
                                    <span class="font-bold text-emerald-600 bg-emerald-50 px-2.5 py-0.5 rounded-full">
                                        {{ __('welcome.services.available') }}
                                    </span>
                                    <a href="{{ route('register') }}" class="text-sky-600 hover:text-sky-700 font-bold inline-flex items-center gap-1.5 transition">
                                        <span>{{ __('welcome.services.request') }}</span>
                                        <i class="fas fa-arrow-left text-[10px]"></i>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center bg-white slider-card rounded-2xl text-slate-400">
                                {{ __('welcome.services.empty') }}
                            </div>
                        @endforelse
                    </div>
                </div>

                <button type="button" @click="next()" class="flex slider-side-btn btn-next" aria-label="{{ __('welcome.common.next') }}">
                    <i class="fas {{ $isRtl ? 'fa-chevron-left' : 'fa-chevron-right' }}"></i>
                </button>
            </div>

        </div>
    </section>

    <!-- =========================================================================
         6. STATS & ACCREDITATIONS
         ========================================================================= -->
    <section class="px-4 mx-auto my-16 max-w-7xl sm:px-6 lg:px-8 reveal">
        <div class="bg-[#f0f4ff] rounded-3xl p-8 sm:p-12 lg:p-16 border border-blue-100/60 shadow-sm">
            <div class="grid items-center grid-cols-1 gap-10 lg:grid-cols-12">

                <!-- Cards Grid -->
                <div class="order-2 lg:col-span-7 lg:order-1">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        @foreach (__('welcome.stats.items') as $key => $stat)
                            @php $style = $statStyles[$key]; @endphp
                            <div class="flex flex-col justify-between p-6 bg-white border shadow-sm hover-lift rounded-2xl border-slate-100">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="card-icon-box w-10 h-10 rounded-xl {{ $style['box'] }} flex items-center justify-center text-lg">
                                        <i class="fas {{ $style['icon'] }}"></i>
                                    </div>
                                    <span class="text-[10px] font-bold {{ $style['chip'] }} px-2 py-0.5 rounded-full">
                                        {{ $stat['chip'] }}
                                    </span>
                                </div>
                                <div>
                                    @if ($style['counter'])
                                        <div class="mb-1 text-2xl font-black sm:text-3xl text-slate-900"
                                             data-counter="{{ $style['counter'][0] }}"
                                             @if ($style['counter'][1]) data-prefix="{{ $style['counter'][1] }}" @endif
                                             @if ($style['counter'][2]) data-format="{{ $style['counter'][2] }}" @endif>{{ $style['display'] }}</div>
                                    @else
                                        <div class="mb-1 text-2xl font-black sm:text-3xl text-slate-900">{{ $stat['value'] }}</div>
                                    @endif
                                    <div class="mb-1 text-xs font-bold text-slate-800">{{ $stat['label'] }}</div>
                                    <div class="text-[11px] text-slate-500 leading-relaxed">{{ $stat['desc'] }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Text & Accreditations -->
                <div class="order-1 text-center lg:col-span-5 lg:order-2 lg:text-start">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-blue-100/70 text-blue-800 text-xs font-bold mb-4">
                        <i class="fas fa-certificate text-sky-600"></i>
                        <span>{{ __('welcome.stats.badge') }}</span>
                    </div>

                    <h2 class="mb-4 text-2xl font-black leading-tight tracking-tight sm:text-3xl text-slate-900">
                        {{ __('welcome.stats.title') }}
                    </h2>

                    <p class="mb-8 text-xs leading-relaxed sm:text-sm text-slate-600">
                        {{ __('welcome.stats.desc') }}
                    </p>

                    <div class="flex flex-wrap items-center justify-center gap-4 lg:justify-start">
                        <div class="hover-lift flex items-center gap-3 bg-white px-4 py-2.5 rounded-2xl border border-slate-200/80 shadow-sm">
                            <i class="text-2xl fas fa-shield-halved text-sky-600"></i>
                            <div class="text-start">
                                <div class="text-xs font-black text-slate-900">JCI Accredited</div>
                                <div class="text-[10px] text-slate-500 font-semibold">{{ __('welcome.stats.jci_sub') }}</div>
                            </div>
                        </div>

                        <div class="hover-lift flex items-center gap-3 bg-white px-4 py-2.5 rounded-2xl border border-slate-200/80 shadow-sm">
                            <i class="text-2xl fas fa-medal text-emerald-600"></i>
                            <div class="text-start">
                                <div class="text-xs font-black text-slate-900">CBAHI</div>
                                <div class="text-[10px] text-slate-500 font-semibold">{{ __('welcome.stats.cbahi_sub') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- =========================================================================
         7. DOCTORS (#doctors)
         ========================================================================= -->
    <section id="doctors" class="relative py-16 bg-white" x-data="infiniteCarousel()">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">

            <div class="flex flex-col justify-between gap-4 mb-10 md:flex-row md:items-end reveal">
                <div>
                    <span class="text-sky-600 font-bold text-xs uppercase tracking-wider bg-sky-50 px-3.5 py-1 rounded-full">
                        {{ __('welcome.doctors.badge') }}
                    </span>
                    <h2 class="mt-3 mb-2 text-2xl font-extrabold sm:text-3xl lg:text-4xl text-slate-900">
                        {{ __('welcome.doctors.title') }}
                    </h2>
                    <p class="max-w-xl text-xs text-slate-600 sm:text-sm">
                        {{ __('welcome.doctors.desc') }}
                    </p>
                </div>
            </div>

            <div class="slider-wrapper">
                <button type="button" @click="prev()" class="flex slider-side-btn btn-prev" aria-label="{{ __('welcome.common.prev') }}">
                    <i class="fas {{ $isRtl ? 'fa-chevron-right' : 'fa-chevron-left' }}"></i>
                </button>

                <div class="slider-viewport">
                    <div x-ref="track" class="slider-track">
                        @forelse ($doctors as $doc)
                            <div class="flex flex-col justify-between overflow-hidden bg-white border shadow-sm slider-card hover-lift rounded-2xl border-slate-200/80">
                                <div>
                                    <div class="relative h-56 overflow-hidden bg-slate-100 group">
                                        <img
                                            src="{{ $doc->avatar_url }}"
                                            alt="{{ $doc->name }}"
                                            class="object-cover w-full h-full transition-transform duration-500 group-hover:scale-105"
                                            loading="lazy"
                                        >
                                        <span class="absolute top-3 end-3 bg-white/90 backdrop-blur-md text-[#084c61] text-[11px] font-bold px-2.5 py-1 rounded-full shadow-sm">
                                            {{ $doc->specialization_name }}
                                        </span>
                                    </div>

                                    <div class="p-5">
                                        <div class="flex items-center justify-between mb-1 text-xs">
                                            <div class="flex items-center gap-1 font-bold text-amber-500">
                                                <i class="fas fa-star text-[11px]"></i>
                                                <span>{{ number_format((float)($doc->rating ?? 4.9), 1) }}</span>
                                            </div>
                                            <span class="text-slate-400 text-[11px]">{{ __('welcome.doctors.experience') }}</span>
                                        </div>

                                        <h4 class="mb-1 text-base font-bold text-slate-900">{{ $doc->name }}</h4>
                                        <p class="mb-4 text-xs leading-relaxed text-slate-500 line-clamp-2">
                                            {{ $doc->bio ?? __('welcome.doctors.default_bio') }}
                                        </p>
                                    </div>
                                </div>

                                <div class="p-5 pt-0">
                                    <a href="{{ route('register') }}" class="btn-ripple w-full py-2.5 px-4 rounded-xl bg-sky-50 hover:bg-[#084c61] text-sky-700 hover:text-white font-bold text-xs flex items-center justify-center gap-2 transition duration-200">
                                        <i class="text-xs fas fa-calendar-check"></i>
                                        <span>{{ __('welcome.doctors.book') }}</span>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center bg-white slider-card rounded-2xl text-slate-400">
                                {{ __('welcome.doctors.empty') }}
                            </div>
                        @endforelse
                    </div>
                </div>

                <button type="button" @click="next()" class="flex slider-side-btn btn-next" aria-label="{{ __('welcome.common.next') }}">
                    <i class="fas {{ $isRtl ? 'fa-chevron-left' : 'fa-chevron-right' }}"></i>
                </button>
            </div>

        </div>
    </section>

    <!-- =========================================================================
         8. SENIOR CONSULTANTS BANNER
         ========================================================================= -->
    <section class="px-4 mx-auto my-16 max-w-7xl sm:px-6 lg:px-8 reveal">
        <div class="p-6 bg-white border shadow-sm rounded-3xl border-slate-200/80 sm:p-10 lg:p-12 hover-lift">
            <div class="grid items-center grid-cols-1 gap-10 lg:grid-cols-12">

                <div class="relative lg:col-span-6">
                    <div class="relative overflow-hidden border-2 shadow-lg rounded-2xl border-slate-100 group">
                        <img
                            src="{{ URL::asset('Dashboard/img/doctor-consultation.jpg') }}"
                            alt="Aura Hospital Senior Medical Faculty"
                            class="object-cover w-full transition-transform duration-500 h-80 sm:h-96 group-hover:scale-105"
                            loading="lazy"
                        >
                        <div class="absolute bottom-4 inset-x-4 bg-slate-900/85 backdrop-blur-md text-white p-3.5 rounded-xl text-center shadow-lg">
                            <div class="text-xs font-bold">{{ __('welcome.faculty.image_title') }}</div>
                            <div class="text-[10px] text-slate-300 mt-0.5">{{ __('welcome.faculty.image_sub') }}</div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-6 text-start">
                    <span class="text-sky-600 font-bold text-xs uppercase tracking-wider bg-sky-50 px-3.5 py-1 rounded-full">
                        {{ __('welcome.faculty.badge') }}
                    </span>

                    <h2 class="mt-3 mb-4 text-2xl font-extrabold leading-snug sm:text-3xl text-slate-900">
                        {{ __('welcome.faculty.title') }}
                    </h2>

                    <p class="mb-6 text-xs leading-relaxed sm:text-sm text-slate-600">
                        {{ __('welcome.faculty.desc') }}
                    </p>

                    <div class="mb-8 space-y-3">
                        @foreach (__('welcome.faculty.checks') as $check)
                            <div class="flex items-center gap-3 text-xs font-semibold text-slate-700">
                                <span class="flex items-center justify-center w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 shrink-0">
                                    <i class="fas fa-check text-[10px]"></i>
                                </span>
                                <span>{{ $check }}</span>
                            </div>
                        @endforeach
                    </div>

                    <a href="#doctors" class="btn-ripple inline-flex items-center gap-2.5 bg-sky-50 hover:bg-sky-100 text-sky-700 font-bold px-6 py-3 rounded-xl text-xs transition">
                        <i class="fas fa-user-doctor text-sky-600"></i>
                        <span>{{ __('welcome.faculty.browse') }}</span>
                        <i class="fas fa-arrow-left text-[11px]"></i>
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- =========================================================================
         9. DIGITAL PHARMACY (#pharmacy)
         ========================================================================= -->
    <section id="pharmacy" class="relative py-16 bg-gradient-to-br from-emerald-50/60 via-teal-50/30 to-white">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid items-center grid-cols-1 gap-10 lg:grid-cols-12">

                <div class="lg:col-span-6 reveal reveal-delay-1 text-start">
                    <span class="text-emerald-700 font-bold text-xs uppercase tracking-wider bg-emerald-100/70 px-3.5 py-1 rounded-full">
                        {{ __('welcome.pharmacy.badge') }}
                    </span>
                    <h2 class="mt-3 mb-4 text-2xl font-extrabold leading-tight sm:text-3xl lg:text-4xl text-slate-900">
                        {{ __('welcome.pharmacy.title') }}
                    </h2>
                    <p class="mb-6 text-xs leading-relaxed sm:text-sm text-slate-600">
                        {{ __('welcome.pharmacy.desc') }}
                    </p>

                    <div class="mb-8 space-y-4">
                        @foreach (__('welcome.pharmacy.features') as $feature)
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5">
                                    <i class="text-xs fas fa-check"></i>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-slate-900">{{ $feature['title'] }}</h4>
                                    <p class="text-[11px] text-slate-500">{{ $feature['desc'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <a href="{{ route('login') }}" class="btn-shimmer btn-ripple inline-flex items-center gap-2 bg-[#047857] hover:bg-[#065f46] text-white px-7 py-3 rounded-xl font-bold text-xs shadow transition">
                        <i class="text-xs fas fa-pills"></i>
                        <span>{{ __('welcome.pharmacy.request') }}</span>
                    </a>
                </div>

                <div class="lg:col-span-6 reveal reveal-delay-2">
                    <div class="relative p-8 overflow-hidden text-white shadow-xl bg-gradient-to-br from-emerald-600 to-teal-700 rounded-3xl sm:p-10 hover-lift">
                        <div class="absolute w-48 h-48 rounded-full pointer-events-none ambient-blob-1 -top-10 -right-10 bg-white/20 blur-2xl"></div>

                        <div class="flex items-center justify-center mb-5 text-3xl text-white shadow-sm w-14 h-14 rounded-2xl bg-white/20">
                            <i class="fas fa-prescription-bottle-medical"></i>
                        </div>
                        <h3 class="mb-3 text-xl font-bold sm:text-2xl">{{ __('welcome.pharmacy.card_title') }}</h3>
                        <p class="max-w-md mb-6 text-xs leading-relaxed text-emerald-100 sm:text-sm">
                            {{ __('welcome.pharmacy.card_desc') }}
                        </p>
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-6 py-3 text-xs font-bold transition bg-white shadow btn-ripple rounded-xl text-emerald-800 hover:bg-slate-50">
                            <i class="text-xs fas fa-sign-in-alt"></i>
                            <span>{{ __('welcome.pharmacy.access') }}</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- =========================================================================
         10. MEDICAL ARTICLES (#medical-info)
         ========================================================================= -->
    <section id="medical-info" class="relative py-16 bg-white" x-data="infiniteCarousel()">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">

            <div class="max-w-3xl mb-10 reveal text-start">
                <span class="text-sky-600 font-bold text-xs uppercase tracking-wider bg-sky-50 px-3.5 py-1 rounded-full">
                    {{ __('welcome.articles.badge') }}
                </span>
                <h2 class="mt-3 mb-2 text-2xl font-extrabold sm:text-3xl lg:text-4xl text-slate-900">
                    {{ __('welcome.articles.title') }}
                </h2>
                <p class="max-w-xl text-xs text-slate-600 sm:text-sm">
                    {{ __('welcome.articles.desc') }}
                </p>
            </div>

            <div class="slider-wrapper">
                <button type="button" @click="prev()" class="flex slider-side-btn btn-prev" aria-label="{{ __('welcome.common.prev') }}">
                    <i class="fas {{ $isRtl ? 'fa-chevron-right' : 'fa-chevron-left' }}"></i>
                </button>

                <div class="slider-viewport">
                    <div x-ref="track" class="slider-track">
                        @foreach (__('welcome.articles.items') as $key => $article)
                            <article class="flex flex-col justify-between overflow-hidden bg-white border shadow-sm slider-card hover-lift rounded-2xl border-slate-200/80">
                                <div>
                                    <div class="h-44 {{ $articleStyles[$key]['cover'] }} flex items-center justify-center text-5xl">
                                        <i class="fas {{ $articleStyles[$key]['icon'] }}"></i>
                                    </div>
                                    <div class="p-6">
                                        <div class="flex items-center justify-between text-[11px] font-bold text-slate-400 mb-2">
                                            <span class="{{ $articleStyles[$key]['tag'] }} px-2.5 py-0.5 rounded-full">{{ $article['tag'] }}</span>
                                            <span>{{ $article['time'] }}</span>
                                        </div>
                                        <h4 class="mb-2 text-sm font-bold leading-snug text-slate-900">{{ $article['title'] }}</h4>
                                        <p class="text-xs leading-relaxed text-slate-500 line-clamp-3">{{ $article['desc'] }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between p-6 pt-0 text-xs border-t border-slate-100 text-slate-400">
                                    <span>{{ $article['by'] }}</span>
                                    <span class="font-bold cursor-pointer text-sky-600 hover:underline">{{ __('welcome.articles.read_more') }}</span>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>

                <button type="button" @click="next()" class="flex slider-side-btn btn-next" aria-label="{{ __('welcome.common.next') }}">
                    <i class="fas {{ $isRtl ? 'fa-chevron-left' : 'fa-chevron-right' }}"></i>
                </button>
            </div>

        </div>
    </section>

    <!-- =========================================================================
         11. BOOKING & PATIENT PORTAL CTA
         ========================================================================= -->
    <section class="px-4 mx-auto my-20 max-w-7xl sm:px-6 lg:px-8 reveal">
        <div class="bg-gradient-to-r from-[#035c81] via-[#0284c7] to-[#084c61] rounded-3xl p-8 sm:p-12 lg:p-14 text-white shadow-2xl relative overflow-hidden">
            <div class="absolute rounded-full pointer-events-none ambient-blob-1 -right-20 -bottom-20 w-80 h-80 bg-white/10 blur-2xl"></div>

            <div class="relative z-10 grid items-center grid-cols-1 gap-10 lg:grid-cols-12">

                <!-- Booking card -->
                <div class="order-2 lg:col-span-5 lg:order-1">
                    <div class="max-w-md p-6 mx-auto bg-white shadow-2xl rounded-2xl text-slate-900 lg:mx-0">
                        <div class="flex items-center gap-3 pb-4 mb-4 border-b border-slate-100">
                            <div class="flex items-center justify-center font-bold text-teal-600 card-icon-box w-9 h-9 rounded-xl bg-teal-50">
                                <i class="text-base fas fa-calendar-check"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-900">{{ __('welcome.cta.card_title') }}</h4>
                                <p class="text-[10px] text-slate-500">{{ __('welcome.cta.card_sub') }}</p>
                            </div>
                        </div>

                        <form action="{{ route('register') }}" method="GET" class="space-y-3.5">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 mb-1">{{ __('welcome.cta.national_id') }}</label>
                                <input
                                    type="text"
                                    placeholder="1xxxxxxxx"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500 transition"
                                >
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 mb-1">{{ __('welcome.cta.mobile') }}</label>
                                <input
                                    type="text"
                                    placeholder="055 000 0000"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500 transition"
                                >
                            </div>

                            <button type="submit" class="btn-shimmer btn-ripple w-full bg-[#047857] hover:bg-[#065f46] text-white py-3 rounded-xl font-bold text-xs flex items-center justify-center gap-2 shadow transition">
                                <i class="text-xs fas fa-check"></i>
                                <span>{{ __('welcome.cta.confirm') }}</span>
                            </button>
                        </form>

                        <p class="text-[10px] text-slate-400 text-center mt-3">{{ __('welcome.cta.secure') }}</p>
                    </div>
                </div>

                <!-- Portal callout -->
                <div class="order-1 text-center lg:col-span-7 lg:order-2 lg:text-start">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white/15 text-white border border-white/20 text-xs font-bold mb-4">
                        <i class="text-xs fas fa-shield-alt"></i>
                        <span>{{ __('welcome.cta.badge') }}</span>
                    </div>

                    <h2 class="mb-4 text-2xl font-extrabold leading-snug tracking-tight text-white sm:text-3xl lg:text-4xl">
                        {{ __('welcome.cta.title') }}
                    </h2>

                    <p class="max-w-xl mx-auto mb-8 text-xs leading-relaxed sm:text-sm text-sky-100 lg:mx-0">
                        {{ __('welcome.cta.desc') }}
                    </p>

                    <div class="flex flex-wrap items-center justify-center gap-4 lg:justify-start">
                        <a href="{{ route('register') }}" class="btn-shimmer btn-ripple bg-white hover:bg-slate-100 text-[#084c61] font-bold px-6 py-3 rounded-xl text-xs shadow-md transition flex items-center gap-2">
                            <i class="text-xs fas fa-user-plus"></i>
                            <span>{{ __('welcome.cta.register') }}</span>
                        </a>

                        <a href="{{ route('login') }}" class="flex items-center gap-2 px-6 py-3 text-xs font-bold text-white transition bg-transparent border btn-shimmer btn-ripple hover:bg-white/10 border-white/40 rounded-xl">
                            <i class="text-xs fas fa-sign-in-alt"></i>
                            <span>{{ __('welcome.cta.login') }}</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- =========================================================================
         12. FOOTER
         ========================================================================= -->
    <footer class="pt-16 pb-12 bg-white border-t border-slate-200/80">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-10 pb-12 border-b md:grid-cols-2 lg:grid-cols-4 border-slate-100">

                <!-- Col 1: Brand -->
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="flex items-center justify-center text-white w-9 h-9 rounded-xl bg-gradient-to-tr from-sky-500 to-blue-600">
                            <i class="text-sm fas fa-hospital"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-base font-extrabold leading-tight text-slate-900">{{ __('welcome.footer.brand') }}</span>
                            <span class="text-[10px] text-sky-600 font-semibold">{{ __('welcome.footer.brand_sub') }}</span>
                        </div>
                    </div>

                    <p class="mb-6 text-xs leading-relaxed text-slate-500">{{ __('welcome.footer.about') }}</p>

                    <div class="flex items-center gap-3 text-[11px] font-bold text-slate-600">
                        <span class="inline-flex items-center gap-1.5"><i class="fas fa-shield-alt text-sky-600"></i> {{ __('welcome.footer.cbahi') }}</span>
                        <span class="text-slate-300">|</span>
                        <span class="inline-flex items-center gap-1.5"><i class="fas fa-award text-emerald-600"></i> {{ __('welcome.footer.jci') }}</span>
                    </div>
                </div>

                <!-- Col 2: Departments -->
                <div>
                    <h5 class="mb-4 text-xs font-bold tracking-wider uppercase text-slate-900">{{ __('welcome.footer.dept_title') }}</h5>
                    <ul class="space-y-2.5 text-xs text-slate-500">
                        @foreach (__('welcome.footer.dept_links') as $label)
                            <li><a href="#departments" class="transition hover:text-sky-600">{{ $label }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <!-- Col 3: Quick links -->
                <div>
                    <h5 class="mb-4 text-xs font-bold tracking-wider uppercase text-slate-900">{{ __('welcome.footer.links_title') }}</h5>
                    <ul class="space-y-2.5 text-xs text-slate-500">
                        @foreach (__('welcome.footer.quick_links') as $i => $label)
                            <li><a href="{{ $quickLinkHrefs[$i] }}" class="transition hover:text-sky-600">{{ $label }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <!-- Col 4: Hours -->
                <div>
                    <h5 class="mb-4 text-xs font-bold tracking-wider uppercase text-slate-900">{{ __('welcome.footer.hours_title') }}</h5>
                    <div class="space-y-3 text-xs text-slate-600">
                        <div class="flex items-center gap-2.5">
                            <i class="far fa-clock text-slate-400"></i>
                            <span>{{ __('welcome.footer.outpatient') }}</span>
                        </div>
                        <div class="flex items-center gap-2.5 text-rose-600 font-bold">
                            <i class="fas fa-truck-medical"></i>
                            <span>{{ __('welcome.footer.emergency') }}</span>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <i class="fas fa-location-dot text-slate-400 mt-0.5"></i>
                            <span>{{ $hospitalAddress }}</span>
                        </div>
                        <div class="flex items-center gap-2.5 text-slate-800 font-bold">
                            <i class="fas fa-phone text-sky-600"></i>
                            <span dir="ltr">{{ $emergencyPhone }} / 011 000 1900</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Copyright -->
            <div class="flex flex-col items-center justify-between gap-4 pt-8 text-xs sm:flex-row text-slate-400">
                <div>{{ __('welcome.footer.copyright', ['year' => date('Y')]) }}</div>
                <div class="text-[11px] text-slate-400">{{ __('welcome.footer.tagline') }}</div>
            </div>
        </div>
    </footer>

    <!-- Back to top -->
    <button id="back-to-top-btn" class="btn-back-to-top" aria-label="{{ __('welcome.common.back_to_top') }}">
        <i class="fas fa-arrow-up"></i>
    </button>

</body>
</html>
