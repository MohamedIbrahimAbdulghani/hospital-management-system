@php
    $locale = app()->getLocale();
    $isRtl  = $locale === 'ar';
    $emergencyPhone = $settings->emergency_phone ?? \App\Models\SiteSetting::get('emergency_phone', '19000');
    $hotlinePhone   = $settings->hotline_phone ?? \App\Models\SiteSetting::get('hotline_phone', '16000');
    $hospitalEmail  = $settings->hospital_email ?? \App\Models\SiteSetting::get('hospital_email', 'support@aura-hospital.com');
    $hospitalAddress = $settings->hospital_address ?? ($isRtl
        ? \App\Models\SiteSetting::get('hospital_address_ar', 'طريق الملك فهد، حي العقيق الطبي')
        : \App\Models\SiteSetting::get('hospital_address_en', 'King Fahd Road, Al-Aqeeq Medical District'));
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', $locale) }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $isRtl ? 'مستشفى أورا التخصصي - رعاية طبية فائقة' : 'Aura Medical Hospital - Advanced Healthcare' }}</title>
    <meta name="description" content="{{ $isRtl ? 'مستشفى أورا التخصصي، كوادر طبية استشارية متمرسة وخدمة طوارئ 24/7 لضمان أعلى معايير الجودة والسلامة.' : 'Aura Medical Hospital provides premier medical consultants, surgical precision, and 24/7 emergency care.' }}">

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
    <section id="hero" class="relative pt-8 pb-16 lg:pt-14 lg:pb-24 overflow-hidden bg-gradient-to-b from-sky-50/40 via-white to-slate-50/50">
        <!-- Ambient Background Glows with Smooth Drift Animation -->
        <div class="ambient-blob-1 absolute top-8 end-8 w-96 h-96 bg-sky-200/40 rounded-full blur-3xl pointer-events-none"></div>
        <div class="ambient-blob-2 absolute bottom-8 start-8 w-96 h-96 bg-cyan-100/40 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-10 items-center">

                <!-- Right Column: Texts, CTAs, 4-Card Stats (RTL) -->
                <div class="lg:col-span-7 text-center lg:text-start reveal reveal-delay-1">

                    <!-- Pill Badge -->
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-sky-100/80 text-sky-800 text-xs font-bold mb-6 border border-sky-200/90 shadow-sm">
                        <i class="fas fa-shield-heart text-sky-600 text-xs"></i>
                        <span>{{ $isRtl ? 'نحو مستقبل متطور للرعاية الطبية' : 'Pioneering Modern Healthcare' }}</span>
                    </div>

                    <!-- Main Headline -->
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight leading-[1.3] mb-6">
                        @if ($isRtl)
                            رعاية طبية فائقة تضع <span class="text-sky-500">صحتك وصحة</span><br>
                            <span class="text-sky-500">عائلتك</span> أولاً
                        @else
                            Premier Medical Care Putting <span class="text-sky-500">Your Health</span><br>
                            and <span class="text-sky-500">Family</span> First
                        @endif
                    </h1>

                    <!-- Subtitle Description -->
                    <p class="text-sm sm:text-base text-slate-600 leading-relaxed max-w-2xl mx-auto lg:mx-0 mb-8">
                        {{ $isRtl 
                            ? 'مستشفى أورا يقدم أحدث التقنيات الجراحية والتشخيصية بكوادر طبية استشارية متمرسة وخدمة طوارئ 24/7 مستعدة دوماً لضمان أعلى معايير بيئة استشفائية آمنة.' 
                            : 'Aura Hospital offers surgical and diagnostic innovations backed by senior consultants and 24/7 emergency preparedness for the highest quality of patient care.' }}
                    </p>

                    <!-- CTA Buttons & Hotline -->
                    <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4 mb-10">
                        <a href="{{ route('register') }}" class="btn-shimmer btn-ripple inline-flex items-center gap-2.5 bg-[#084c61] hover:bg-[#063b4c] text-white px-7 py-3 rounded-xl font-bold text-sm shadow-md shadow-[#084c61]/20 transition transform hover:-translate-y-0.5">
                            <span>{{ $isRtl ? 'احجز موعدك الآن' : 'Book Appointment' }}</span>
                            <i class="fas fa-calendar-check text-sm"></i>
                        </a>

                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $emergencyPhone) }}" class="btn-shimmer btn-ripple inline-flex items-center gap-2 bg-[#dc2626] hover:bg-[#b91c1c] text-white px-6 py-3 rounded-xl font-bold text-sm shadow-md shadow-rose-600/20 transition transform hover:-translate-y-0.5">
                            <i class="fas fa-phone-volume text-sm"></i>
                            <span>{{ $isRtl ? 'استشارة عاجلة' : 'Emergency Consultation' }}</span>
                        </a>

                        <div class="inline-flex items-center gap-2 text-slate-500 text-xs font-bold ps-2">
                            <i class="fas fa-headset text-slate-400 text-sm"></i>
                            <span>{{ $isRtl ? 'خط المساعدة المجاني:' : 'Toll-free Hotline:' }}</span>
                            <span dir="ltr" class="font-extrabold text-slate-700">{{ $emergencyPhone }}</span>
                        </div>
                    </div>

                    <!-- 4 Metric Stats Cards in a Row with Animated Counters -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-6 border-t border-slate-200/80">
                        <!-- Card 1 -->
                        <div class="hover-lift bg-white rounded-2xl p-3.5 border border-slate-200/80 shadow-sm text-center">
                            <div class="text-xl sm:text-2xl font-black text-[#084c61]" data-counter="99.8" data-suffix="%">99.8%</div>
                            <div class="text-[11px] font-bold text-slate-500 mt-1">
                                {{ $isRtl ? 'دقة تشخيصية رقمية' : 'Diagnostic Accuracy' }}
                            </div>
                        </div>

                        <!-- Card 2 -->
                        <div class="hover-lift bg-white rounded-2xl p-3.5 border border-slate-200/80 shadow-sm text-center">
                            <div class="text-xl sm:text-2xl font-black text-[#084c61]" data-counter="120" data-prefix="+ ">+ 120</div>
                            <div class="text-[11px] font-bold text-slate-500 mt-1">
                                {{ $isRtl ? 'طبيب واستشاري دولي' : 'Senior Consultants' }}
                            </div>
                        </div>

                        <!-- Card 3 -->
                        <div class="hover-lift bg-white rounded-2xl p-3.5 border border-slate-200/80 shadow-sm text-center">
                            <div class="text-xl sm:text-2xl font-black text-rose-600 inline-flex items-center justify-center gap-1.5">
                                <span class="emergency-pulse-dot"></span>
                                24/7
                            </div>
                            <div class="text-[11px] font-bold text-slate-500 mt-1">
                                {{ $isRtl ? 'طوارئ وإنعاش فوري' : 'Emergency & Trauma' }}
                            </div>
                        </div>

                        <!-- Card 4 -->
                        <div class="hover-lift bg-white rounded-2xl p-3.5 border border-slate-200/80 shadow-sm text-center">
                            <div class="text-xl sm:text-2xl font-black text-[#084c61]">1 : 1</div>
                            <div class="text-[11px] font-bold text-slate-500 mt-1">
                                {{ $isRtl ? 'رعاية تمريضية فردية' : 'Personal Nursing' }}
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Left Column: Visual OR Surgeons Image with Smooth Floating Badge -->
                <div class="lg:col-span-5 relative reveal reveal-delay-2">
                    <div class="relative mx-auto max-w-md lg:max-w-none">
                        <!-- Image Container with White Border & Shadow -->
                        <div class="rounded-3xl overflow-hidden shadow-2xl border-4 border-white bg-slate-900 group">
                            <img
                                src="{{ URL::asset('Dashboard/img/hero-surgeons.jpg') }}"
                                alt="Aura Hospital Advanced Surgical Suite"
                                class="w-full h-[400px] sm:h-[460px] object-cover group-hover:scale-105 transition-transform duration-700"
                                loading="eager"
                            >
                        </div>

                        <!-- Floating Card at Bottom (Gentle Animated Float) -->
                        <div class="animate-float-gentle absolute -bottom-6 start-3 sm:-start-6 bg-white/95 backdrop-blur-md rounded-2xl p-4 shadow-xl border border-slate-100 max-w-[280px] z-20">
                            <div class="flex items-center justify-between gap-2 mb-2">
                                <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full">
                                    <i class="fas fa-check-circle text-emerald-500"></i>
                                    {{ $isRtl ? 'معتمد من وزارة الصحة' : 'MOH Certified' }}
                                </span>
                                <a href="{{ route('register') }}" class="btn-ripple bg-cyan-500 hover:bg-cyan-600 text-white text-[10px] font-bold px-2.5 py-1 rounded-full transition shadow-sm">
                                    {{ $isRtl ? 'الحجز الفوري' : 'Instant' }}
                                </a>
                            </div>
                            <div class="text-xs font-bold text-slate-900 leading-snug">
                                {{ $isRtl ? 'نتائج الفحوص والتشخيص المبكر' : 'Early Diagnostics & Test Results' }}
                            </div>
                            <div class="text-[10px] text-slate-500 mt-0.5">
                                {{ $isRtl ? 'نظام سرعة بروتوكول متقدم لسلامة المرضى' : 'Advanced safety clinical protocols' }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- =========================================================================
         2. QUICK SEARCH & APPOINTMENT SCHEDULING (FLOATING BANNER)
         ========================================================================= -->
    <section class="relative z-30 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 mb-20 reveal">
        <div class="bg-white rounded-3xl shadow-xl border border-slate-200/80 p-6 sm:p-8 hover-lift">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-5 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="card-icon-box w-10 h-10 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center font-bold shadow-sm">
                        <i class="fas fa-calendar-alt text-base"></i>
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-slate-900">
                        {{ $isRtl ? 'البحث السريع وتحديد المواعيد' : 'Quick Search & Appointment Scheduling' }}
                    </h3>
                </div>
                <p class="text-xs text-slate-500 font-medium">
                    {{ $isRtl ? 'اختر التخصص والفرع وتاريخ الكشف للاطلاع على المواعيد المتاحة فورياً' : 'Select specialty, clinic, and date to check instant appointment availability' }}
                </p>
            </div>

            <form action="{{ route('register') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end pt-5">
                <!-- Specialty Dropdown -->
                <div class="md:col-span-3">
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">
                        {{ $isRtl ? 'التخصص الطبي المطلوب' : 'Required Medical Specialty' }}
                    </label>
                    <select class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500 transition">
                        <option value="">{{ $isRtl ? 'كافة التخصصات الطبية' : 'All Medical Specialties' }}</option>
                        @foreach ($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Doctor or Clinic Name -->
                <div class="md:col-span-4">
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">
                        {{ $isRtl ? 'اسم الطبيب أو العيادة' : 'Doctor or Clinic Name' }}
                    </label>
                    <div class="relative">
                        <i class="fas fa-search absolute inset-y-0 {{ $isRtl ? 'right-3' : 'left-3' }} flex items-center text-slate-400 text-xs pointer-events-none"></i>
                        <input
                            type="text"
                            placeholder="{{ $isRtl ? 'ابحث باسم دكتور أو عيادة...' : 'Search by physician or clinic...' }}"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl {{ $isRtl ? 'pr-9 pl-3.5' : 'pl-9 pr-3.5' }} py-2.5 text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500 transition"
                        >
                    </div>
                </div>

                <!-- Consultation Date -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">
                        {{ $isRtl ? 'تاريخ الكشف المناسب' : 'Preferred Date' }}
                    </label>
                    <input
                        type="date"
                        value="2026-05-22"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500 transition"
                    >
                </div>

                <!-- Submit Button -->
                <div class="md:col-span-3">
                    <button type="submit" class="btn-shimmer btn-ripple w-full bg-[#084c61] hover:bg-[#063b4c] text-white py-2.5 px-4 rounded-xl font-bold text-xs flex items-center justify-center gap-2 shadow-sm transition">
                        <i class="fas fa-search text-xs"></i>
                        <span>{{ $isRtl ? 'استعراض المواعيد المتاحة' : 'View Available Appointments' }}</span>
                    </button>
                </div>
            </form>

            <!-- Popular Quick Tags -->
            <div class="flex flex-wrap items-center gap-2 pt-4 text-xs">
                <span class="text-slate-400 font-bold text-[11px]">{{ $isRtl ? 'شائع الآن:' : 'Trending:' }}</span>
                <a href="#departments" class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 text-[11px] font-semibold hover:bg-sky-50 hover:text-sky-600 transition">
                    {{ $isRtl ? 'عيادة القلب' : 'Cardiology' }}
                </a>
                <a href="#departments" class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 text-[11px] font-semibold hover:bg-sky-50 hover:text-sky-600 transition">
                    {{ $isRtl ? 'عظام وروماتيزم' : 'Orthopedics' }}
                </a>
                <a href="#departments" class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 text-[11px] font-semibold hover:bg-sky-50 hover:text-sky-600 transition">
                    {{ $isRtl ? 'استشارات أسنان' : 'Dentistry' }}
                </a>
                <a href="#departments" class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 text-[11px] font-semibold hover:bg-sky-50 hover:text-sky-600 transition">
                    {{ $isRtl ? 'طوارئ أطفال' : 'Pediatric ER' }}
                </a>
            </div>
        </div>
    </section>

    <!-- =========================================================================
         3. ABOUT US SECTION (#about)
         ========================================================================= -->
    <section id="about" class="py-16 bg-slate-50/60 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center max-w-3xl mx-auto mb-14 reveal">
                <span class="text-sky-600 font-bold text-xs uppercase tracking-wider bg-sky-50 px-3.5 py-1 rounded-full">
                    {{ $isRtl ? 'من نحن' : 'About Us' }}
                </span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 mt-3 mb-3">
                    {{ $isRtl ? 'ريادة طبية وتاريخ عريق من الثقة والإنسانية' : 'Medical Leadership & Dedicated Compassion' }}
                </h2>
                <p class="text-slate-600 text-xs sm:text-sm leading-relaxed max-w-2xl mx-auto">
                    {{ $isRtl 
                        ? 'في مستشفى أورا، نؤمن بأن الرعاية الصحية الحقيقية تبدأ من الاهتمام بأدق تفاصيل راحة المريض وسلامته بأحدث الوسائل التكنولوجية والكوادر الطبية المرموقة.' 
                        : 'Committed to delivering evidence-based clinical excellence through cutting-edge technologies and compassionate patient care.' }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Pillar 1 -->
                <div class="hover-lift reveal reveal-delay-1 bg-white rounded-2xl p-7 border border-slate-200/80 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="card-icon-box w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl mb-4">
                            <i class="fas fa-heart-circle-check"></i>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 mb-2">
                            {{ $isRtl ? 'رعاية فائقة تتمحور حول المريض' : 'Patient-Centric Care' }}
                        </h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            {{ $isRtl 
                                ? 'سلامة المريض وخصوصيته أولويتنا القصوى، حيث نصمم خطط استشفاء فردية تراعي الاحتياجات الصحية والنفسية لكل مراجع.' 
                                : 'Patient safety and comfort are paramount, driven by individualized recovery protocols and utmost privacy.' }}
                        </p>
                    </div>
                    <div class="pt-5 mt-4 border-t border-slate-100 flex items-center gap-2 text-xs font-bold text-sky-600">
                        <i class="fas fa-check-circle text-xs"></i>
                        <span>{{ $isRtl ? 'معايير جودة معتمدة دولياً' : 'JCI Standard Protocols' }}</span>
                    </div>
                </div>

                <!-- Pillar 2 -->
                <div class="hover-lift reveal reveal-delay-2 bg-white rounded-2xl p-7 border border-slate-200/80 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="card-icon-box w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center text-xl mb-4">
                            <i class="fas fa-microscope"></i>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 mb-2">
                            {{ $isRtl ? 'تقنيات تشخيصية وجراحية روبوتية' : 'Precision & Robotic Surgery' }}
                        </h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            {{ $isRtl 
                                ? 'أحدث أجهزة الرنين المغناطيسي 3T ومختبرات آلية وغرف عمليات رقمية تضمن دقة التشخيص وتسرع من وتيرة الشفاء.' 
                                : '3T MRI, automated clinical laboratories, and robotic capsules delivering swift, definitive surgical precision.' }}
                        </p>
                    </div>
                    <div class="pt-5 mt-4 border-t border-slate-100 flex items-center gap-2 text-xs font-bold text-sky-600">
                        <i class="fas fa-check-circle text-xs"></i>
                        <span>{{ $isRtl ? 'تجهيزات رقمية بمعيار ألماني' : 'High Precision Diagnostics' }}</span>
                    </div>
                </div>

                <!-- Pillar 3 -->
                <div class="hover-lift reveal reveal-delay-3 bg-white rounded-2xl p-7 border border-slate-200/80 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="card-icon-box w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl mb-4">
                            <i class="fas fa-award"></i>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 mb-2">
                            {{ $isRtl ? 'كوادر طبية معتمدة دولياً' : 'World-Class Medical Faculty' }}
                        </h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            {{ $isRtl 
                                ? 'نخبة من الأطباء والاستشاريين الحاصلين على البورد الأمريكي والأوروبي لمتابعة أدق الحالات الجراحية والطبية.' 
                                : 'Board-certified medical consultants bringing international clinical standards to every patient interaction.' }}
                        </p>
                    </div>
                    <div class="pt-5 mt-4 border-t border-slate-100 flex items-center gap-2 text-xs font-bold text-sky-600">
                        <i class="fas fa-check-circle text-xs"></i>
                        <span>{{ $isRtl ? 'أكثر من 120 استشاري' : 'Top Tier Consultants' }}</span>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- =========================================================================
         4. MEDICAL DEPARTMENTS & SPECIALIZED CENTERS (#departments - 3 Visible Cards with Continuous Loop)
         ========================================================================= -->
    <section
        id="departments"
        class="py-16 bg-white relative"
        x-data="infiniteCarousel()"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Section Title Header with Navigation Buttons -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10 reveal">
                <div>
                    <span class="text-sky-600 font-bold text-xs uppercase tracking-wider bg-sky-50 px-3.5 py-1 rounded-full">
                        {{ $isRtl ? 'التميز الإكلينيكي' : 'Clinical Excellence' }}
                    </span>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 mt-3 mb-2">
                        {{ $isRtl ? 'الأقسام الطبية والمراكز التخصصية' : 'Medical Departments & Specialized Centers' }}
                    </h2>
                    <p class="text-slate-600 text-xs sm:text-sm max-w-xl">
                        {{ $isRtl ? 'مجمع أرقى الخدمات الطبية مع نخبة من الاستشاريين (3 في كل عرض) واستخدم الأسهم للتنقل المستمر.' : 'Comprehensive clinical departments (3 visible at a time) with continuous infinite loop.' }}
                    </p>
                </div>

            </div>

            <!-- 3-Card Carousel Wrapper -->
            <div class="slider-wrapper">
                <!-- Floating Side Prev Button -->
                <button
                    type="button"
                    @click="prev()"
                    class="slider-side-btn btn-prev flex"
                    aria-label="Previous"
                >
                    <i class="fas {{ $isRtl ? 'fa-chevron-right' : 'fa-chevron-left' }}"></i>
                </button>

                <!-- Cards Slider Track inside Viewport -->
                <div class="slider-viewport">
                    <div x-ref="track" class="slider-track">

                    <!-- 1. Cardiology & Vascular Surgery -->
                    <div class="slider-card hover-lift bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <div class="card-icon-box w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl">
                                    <i class="fas fa-heart-pulse"></i>
                                </div>
                                <span class="text-[11px] font-bold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-full">
                                    {{ $isRtl ? 'طوارئ 24 ساعة' : '24/7 ER' }}
                                </span>
                            </div>
                            <h3 class="text-base font-bold text-slate-900 mb-2">
                                {{ $isRtl ? 'جراحة القلب والأوعية الدموية' : 'Cardiovascular Surgery' }}
                            </h3>
                            <p class="text-xs text-slate-500 leading-relaxed mb-6">
                                {{ $isRtl 
                                    ? 'خدمات قسطرة قلبية علاجية ثلاثية الأبعاد، جراحات القلب المفتوح المعقدة، وزراعة الشرايين التاجية بإشراف نخبة من كبار الجراحين.' 
                                    : '3D catheterization interventions, complex open-heart surgeries, and coronary artery grafting directed by top surgeons.' }}
                            </p>
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t border-slate-100 text-xs">
                            <span class="font-bold text-slate-600">{{ $isRtl ? '18 استشاري معتمد' : '18 Consultants' }}</span>
                            <a href="{{ route('register') }}" class="text-sky-600 hover:text-sky-700 font-bold inline-flex items-center gap-1.5 transition">
                                <span>{{ $isRtl ? 'عرض تفاصيل القسم' : 'View Details' }}</span>
                                <i class="fas fa-arrow-left text-[10px]"></i>
                            </a>
                        </div>
                    </div>

                    <!-- 2. Pediatrics & Neonatology -->
                    <div class="slider-card hover-lift bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <div class="card-icon-box w-12 h-12 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center text-xl">
                                    <i class="fas fa-baby"></i>
                                </div>
                                <span class="text-[11px] font-bold text-teal-700 bg-teal-50 px-2.5 py-1 rounded-full">
                                    {{ $isRtl ? 'أحدث التقنيات' : 'Modern NICU' }}
                                </span>
                            </div>
                            <h3 class="text-base font-bold text-slate-900 mb-2">
                                {{ $isRtl ? 'طب الأطفال وحديثي الولادة' : 'Pediatrics & Neonatology' }}
                            </h3>
                            <p class="text-xs text-slate-500 leading-relaxed mb-6">
                                {{ $isRtl 
                                    ? 'وحدة عناية مركزة متطورة للمبتسرين، عيادات تخصصية لأمراض المناعة، والنمو والتكامل، وإشراف متواصل على صحة وتغذية الطفل.' 
                                    : 'Advanced neonatal intensive care units, pediatric immunology clinics, developmental tracking, and specialized childcare.' }}
                            </p>
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t border-slate-100 text-xs">
                            <span class="font-bold text-slate-600">{{ $isRtl ? '16 استشاري أطفال' : '16 Pediatricians' }}</span>
                            <a href="{{ route('register') }}" class="text-sky-600 hover:text-sky-700 font-bold inline-flex items-center gap-1.5 transition">
                                <span>{{ $isRtl ? 'عرض تفاصيل القسم' : 'View Details' }}</span>
                                <i class="fas fa-arrow-left text-[10px]"></i>
                            </a>
                        </div>
                    </div>

                    <!-- 3. Orthopedics & Joint Surgery -->
                    <div class="slider-card hover-lift bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <div class="card-icon-box w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl">
                                    <i class="fas fa-bone"></i>
                                </div>
                                <span class="text-[11px] font-bold text-purple-700 bg-purple-50 px-2.5 py-1 rounded-full">
                                    {{ $isRtl ? 'تدخل روبوتي' : 'Robotic Surgery' }}
                                </span>
                            </div>
                            <h3 class="text-base font-bold text-slate-900 mb-2">
                                {{ $isRtl ? 'جراحة العظام والمفاصل' : 'Orthopedic & Joint Surgery' }}
                            </h3>
                            <p class="text-xs text-slate-500 leading-relaxed mb-6">
                                {{ $isRtl 
                                    ? 'استبدال مفاصل الركبة والحوض بمساعدة الذراع الروبوتي المعقد، علاج العمود الفقري، ورعاية التأهيل الرياضي الحركي.' 
                                    : 'Robotic-assisted knee and hip arthroplasty, spinal deformity corrective surgery, and sports rehabilitation medicine.' }}
                            </p>
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t border-slate-100 text-xs">
                            <span class="font-bold text-slate-600">{{ $isRtl ? '22 جراح واستشاري' : '22 Surgeons' }}</span>
                            <a href="{{ route('register') }}" class="text-sky-600 hover:text-sky-700 font-bold inline-flex items-center gap-1.5 transition">
                                <span>{{ $isRtl ? 'عرض تفاصيل القسم' : 'View Details' }}</span>
                                <i class="fas fa-arrow-left text-[10px]"></i>
                            </a>
                        </div>
                    </div>

                    <!-- 4. Internal Medicine & Gastroenterology -->
                    <div class="slider-card hover-lift bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <div class="card-icon-box w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center text-xl">
                                    <i class="fas fa-stethoscope"></i>
                                </div>
                                <span class="text-[11px] font-bold text-sky-700 bg-sky-50 px-2.5 py-1 rounded-full">
                                    {{ $isRtl ? 'مناظير تشخيصية' : 'Endoscopy' }}
                                </span>
                            </div>
                            <h3 class="text-base font-bold text-slate-900 mb-2">
                                {{ $isRtl ? 'الباطنة والجهاز الهضمي' : 'Internal Medicine & Gastroenterology' }}
                            </h3>
                            <p class="text-xs text-slate-500 leading-relaxed mb-6">
                                {{ $isRtl 
                                    ? 'وحدة مناظير الجهاز الهضمي والقولون التشخيصية والعلاجية، برامج علاج أمراض الكبد المزمنة، والرعاية الطبية الشاملة.' 
                                    : 'Advanced upper and lower GI diagnostic and therapeutic endoscopy, chronic hepatology treatment, and comprehensive care.' }}
                            </p>
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t border-slate-100 text-xs">
                            <span class="font-bold text-slate-600">{{ $isRtl ? '19 استشاري باطنة' : '19 Internists' }}</span>
                            <a href="{{ route('register') }}" class="text-sky-600 hover:text-sky-700 font-bold inline-flex items-center gap-1.5 transition">
                                <span>{{ $isRtl ? 'عرض تفاصيل القسم' : 'View Details' }}</span>
                                <i class="fas fa-arrow-left text-[10px]"></i>
                            </a>
                        </div>
                    </div>

                    <!-- 5. Neurology & Spine Surgery -->
                    <div class="slider-card hover-lift bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <div class="card-icon-box w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl">
                                    <i class="fas fa-brain"></i>
                                </div>
                                <span class="text-[11px] font-bold text-indigo-700 bg-indigo-50 px-2.5 py-1 rounded-full">
                                    {{ $isRtl ? 'جراحة ميكروسكوبية' : 'Microsurgery' }}
                                </span>
                            </div>
                            <h3 class="text-base font-bold text-slate-900 mb-2">
                                {{ $isRtl ? 'المخ والأعصاب والعمود الفقري' : 'Neurology & Spine' }}
                            </h3>
                            <p class="text-xs text-slate-500 leading-relaxed mb-6">
                                {{ $isRtl 
                                    ? 'جراحة الأعصاب المجهرية الدقيقة، علاج السكتات الدماغية في الدقائق الذهبية الأولى، وجراحات تثبيت الفقرات الحديثة.' 
                                    : 'Precision microscopic neurosurgery, golden-hour stroke management interventions, and minimally invasive spine stabilization.' }}
                            </p>
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t border-slate-100 text-xs">
                            <span class="font-bold text-slate-600">{{ $isRtl ? '21 استشاري مخ وأعصاب' : '21 Neurologists' }}</span>
                            <a href="{{ route('register') }}" class="text-sky-600 hover:text-sky-700 font-bold inline-flex items-center gap-1.5 transition">
                                <span>{{ $isRtl ? 'عرض تفاصيل القسم' : 'View Details' }}</span>
                                <i class="fas fa-arrow-left text-[10px]"></i>
                            </a>
                        </div>
                    </div>

                    <!-- 6. Obstetrics & Women's Health -->
                    <div class="slider-card hover-lift bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <div class="card-icon-box w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                                    <i class="fas fa-venus"></i>
                                </div>
                                <span class="text-[11px] font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full">
                                    {{ $isRtl ? 'أمومة آمنة' : 'Maternity' }}
                                </span>
                            </div>
                            <h3 class="text-base font-bold text-slate-900 mb-2">
                                {{ $isRtl ? 'النساء والتوليد وصحة المرأة' : 'Obstetrics & Women\'s Health' }}
                            </h3>
                            <p class="text-xs text-slate-500 leading-relaxed mb-6">
                                {{ $isRtl 
                                    ? 'رعاية متكاملة للحمل الحرج، أحدث أجنحة ومستشفى ولادة مجهزة بالكامل، وجراحات المناظير النسائية ودلائل الإخصاب المساعد.' 
                                    : 'Comprehensive high-risk obstetrics, modern birthing suites, gynecological laparoscopy, and reproductive care.' }}
                            </p>
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t border-slate-100 text-xs">
                            <span class="font-bold text-slate-600">{{ $isRtl ? '15 طبيبة واستشارية' : '15 Gynecologists' }}</span>
                            <a href="{{ route('register') }}" class="text-sky-600 hover:text-sky-700 font-bold inline-flex items-center gap-1.5 transition">
                                <span>{{ $isRtl ? 'عرض تفاصيل القسم' : 'View Details' }}</span>
                                <i class="fas fa-arrow-left text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Floating Side Next Button -->
            <button
                type="button"
                @click="next()"
                class="slider-side-btn btn-next flex"
                aria-label="Next"
            >
                <i class="fas {{ $isRtl ? 'fa-chevron-left' : 'fa-chevron-right' }}"></i>
            </button>
        </div>

    </div>
</section>

<!-- =========================================================================
     5. MEDICAL SERVICES CAROUSEL SECTION (#services - 3 Visible Cards with Continuous Loop)
     ========================================================================= -->
<section
    id="services"
    class="py-16 bg-slate-50/70 relative"
    x-data="infiniteCarousel()"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Section Header with Navigation Buttons -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10 reveal">
            <div>
                <span class="text-sky-600 font-bold text-xs uppercase tracking-wider bg-sky-50 px-3.5 py-1 rounded-full">
                    {{ $isRtl ? 'الخدمات الطبية الشاملة' : 'Integrated Services' }}
                </span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 mt-3 mb-2">
                    {{ $isRtl ? 'خدمات علاجية وتشخيصية ترتقي بصحتك' : 'Comprehensive Healthcare Solutions' }}
                </h2>
                <p class="text-slate-600 text-xs sm:text-sm max-w-xl">
                    {{ $isRtl ? 'استعرض أبرز خدماتنا المتقدمة (3 في كل عرض) واستخدم أزرار التنقل للتنقل المستمر.' : 'Explore 3 services at a time with continuous loop side navigation.' }}
                </p>
            </div>

        </div>

        <!-- 3-Card Carousel Wrapper -->
        <div class="slider-wrapper">
            <!-- Floating Side Prev Button -->
            <button
                type="button"
                @click="prev()"
                class="slider-side-btn btn-prev flex"
                aria-label="Previous"
            >
                <i class="fas {{ $isRtl ? 'fa-chevron-right' : 'fa-chevron-left' }}"></i>
            </button>

            <!-- Cards Slider Track inside Viewport -->
            <div class="slider-viewport">
                <div x-ref="track" class="slider-track">
                    @forelse ($services as $service)
                        <div class="slider-card hover-lift bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm flex flex-col justify-between">
                            <div>
                                <div class="card-icon-box w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center text-xl mb-4">
                                    <i class="fas {{ str_starts_with($service->icon ?? '', 'fa-') ? $service->icon : ($service->icon ? 'fa-' . $service->icon : 'fa-briefcase-medical') }}"></i>
                                </div>
                                <h3 class="text-base font-bold text-slate-900 mb-2">
                                    {{ $service->title }}
                                </h3>
                                <p class="text-xs text-slate-500 leading-relaxed mb-6">
                                    {{ $service->description }}
                                </p>
                            </div>
                            <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                                <span class="font-bold text-emerald-600 bg-emerald-50 px-2.5 py-0.5 rounded-full">
                                    {{ $isRtl ? 'متاح فورياً' : 'Available' }}
                                </span>
                                <a href="{{ route('register') }}" class="text-sky-600 hover:text-sky-700 font-bold inline-flex items-center gap-1.5 transition">
                                    <span>{{ $isRtl ? 'طلب الخدمة' : 'Request Service' }}</span>
                                    <i class="fas fa-arrow-left text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="slider-card bg-white rounded-2xl p-6 text-center text-slate-400">
                            {{ $isRtl ? 'لا توجد خدمات حالياً' : 'No services available' }}
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Floating Side Next Button -->
            <button
                type="button"
                @click="next()"
                class="slider-side-btn btn-next flex"
                aria-label="Next"
            >
                <i class="fas {{ $isRtl ? 'fa-chevron-left' : 'fa-chevron-right' }}"></i>
            </button>
        </div>

    </div>
</section>

    <!-- =========================================================================
         6. STATS & ACCREDITATIONS SECTION (LAVENDER / ICE-BLUE CONTAINER)
         ========================================================================= -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 my-16 reveal">
        <div class="bg-[#f0f4ff] rounded-3xl p-8 sm:p-12 lg:p-16 border border-blue-100/60 shadow-sm">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">

                <!-- 2x2 Cards Grid (Left in RTL, Right in LTR) -->
                <div class="lg:col-span-7 order-2 lg:order-1">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <!-- Card 1: 250,000+ Patients -->
                        <div class="hover-lift bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex flex-col justify-between">
                            <div class="flex items-center justify-between mb-4">
                                <div class="card-icon-box w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center text-lg">
                                    <i class="fas fa-users"></i>
                                </div>
                                <span class="text-[10px] font-bold text-teal-700 bg-teal-50 px-2 py-0.5 rounded-full">
                                    {{ $isRtl ? '+120 تخصص' : '+120 Specialties' }}
                                </span>
                            </div>
                            <div>
                                <div class="text-2xl sm:text-3xl font-black text-slate-900 mb-1" data-counter="250000" data-prefix="+ " data-format="comma">+ 250,000</div>
                                <div class="text-xs font-bold text-slate-800 mb-1">
                                    {{ $isRtl ? 'مرضى سنوياً يتلقون رعايتنا' : 'Patients Treated Annually' }}
                                </div>
                                <div class="text-[11px] text-slate-500 leading-relaxed">
                                    {{ $isRtl ? 'نعتز بثقة أسرهم ضمن خدمات العيادات الخارجية ومراكز الطوارئ.' : 'Entrusted by families across outpatient clinics and trauma centers.' }}
                                </div>
                            </div>
                        </div>

                        <!-- Card 2: 45+ Units -->
                        <div class="hover-lift bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex flex-col justify-between">
                            <div class="flex items-center justify-between mb-4">
                                <div class="card-icon-box w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-lg">
                                    <i class="fas fa-hospital-user"></i>
                                </div>
                                <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full">
                                    {{ $isRtl ? 'تجهيز عالمي' : 'Global Standards' }}
                                </span>
                            </div>
                            <div>
                                <div class="text-2xl sm:text-3xl font-black text-slate-900 mb-1" data-counter="45" data-prefix="+">+45</div>
                                <div class="text-xs font-bold text-slate-800 mb-1">
                                    {{ $isRtl ? 'أقسام ووحدات علاجية تخصصية' : 'Specialized Clinical Units' }}
                                </div>
                                <div class="text-[11px] text-slate-500 leading-relaxed">
                                    {{ $isRtl ? 'تغطي كافة الضرورات الجراحية والتشخيصية والرعاية المركزة.' : 'Covering all surgical, diagnostic, and critical intensive care needs.' }}
                                </div>
                            </div>
                        </div>

                        <!-- Card 3: 15 Digital OR Capsules -->
                        <div class="hover-lift bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex flex-col justify-between">
                            <div class="flex items-center justify-between mb-4">
                                <div class="card-icon-box w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg">
                                    <i class="fas fa-shield-virus"></i>
                                </div>
                                <span class="text-[10px] font-bold text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded-full">
                                    {{ $isRtl ? 'معيار ألماني' : 'German Standard' }}
                                </span>
                            </div>
                            <div>
                                <div class="text-2xl sm:text-3xl font-black text-slate-900 mb-1" data-counter="15">15</div>
                                <div class="text-xs font-bold text-slate-800 mb-1">
                                    {{ $isRtl ? 'غرفة عمليات كبسولة رقمية' : 'Digital OR Capsules' }}
                                </div>
                                <div class="text-[11px] text-slate-500 leading-relaxed">
                                    {{ $isRtl ? 'أنظمة تعقيم هوائي نقي ومجهزة بأحدث روبوتات الجراحة الدقيقة.' : 'Laminar air sterilization equipped with state-of-the-art robotic surgery.' }}
                                </div>
                            </div>
                        </div>

                        <!-- Card 4: Under 7 Minutes ER Response -->
                        <div class="hover-lift bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex flex-col justify-between">
                            <div class="flex items-center justify-between mb-4">
                                <div class="card-icon-box w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-lg">
                                    <i class="fas fa-bolt"></i>
                                </div>
                                <span class="text-[10px] font-bold text-rose-700 bg-rose-50 px-2 py-0.5 rounded-full">
                                    {{ $isRtl ? 'استجابة فائقة' : 'Ultra Fast' }}
                                </span>
                            </div>
                            <div>
                                <div class="text-2xl sm:text-3xl font-black text-slate-900 mb-1">&lt; 7 دقائق</div>
                                <div class="text-xs font-bold text-slate-800 mb-1">
                                    {{ $isRtl ? 'متوسط وقت التدخل السريع للحوادث' : 'Average Trauma Response Time' }}
                                </div>
                                <div class="text-[11px] text-slate-500 leading-relaxed">
                                    {{ $isRtl ? 'فريق طوارئ متأهب على مدار الساعة لإنقاذ الحالات فوراً.' : 'Dedicated critical trauma team ready 24/7 for life-saving care.' }}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Text & Accreditations (Right in RTL, Left in LTR) -->
                <div class="lg:col-span-5 order-1 lg:order-2 text-center lg:text-start">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-blue-100/70 text-blue-800 text-xs font-bold mb-4">
                        <i class="fas fa-certificate text-sky-600"></i>
                        <span>{{ $isRtl ? 'شهادات واعتمادات دولية' : 'Accreditations & Quality' }}</span>
                    </div>

                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight leading-tight mb-4">
                        {{ $isRtl ? 'أرقام وإنجازات تعكس ثقة مجتمعنا ورسالتنا الإنسانية' : 'Numbers & Milestones Reflecting Community Trust' }}
                    </h2>

                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-8">
                        {{ $isRtl 
                            ? 'نفخر بأعلى معايير جودة الرعاية الطبية وفق متطلبات الهيئة المشتركة الدولية (JCI) والمركز السعودي لاعتماد المنشآت الصحية (CBAHI).' 
                            : 'Proud to operate under rigorous global benchmarks aligned with Joint Commission International (JCI) and CBAHI standards.' }}
                    </p>

                    <!-- Accreditation Badges -->
                    <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4">
                        <div class="hover-lift flex items-center gap-3 bg-white px-4 py-2.5 rounded-2xl border border-slate-200/80 shadow-sm">
                            <i class="fas fa-shield-halved text-sky-600 text-2xl"></i>
                            <div class="text-start">
                                <div class="text-xs font-black text-slate-900">JCI Accredited</div>
                                <div class="text-[10px] text-slate-500 font-semibold">{{ $isRtl ? 'اعتماد الجودة العالمي' : 'International Quality' }}</div>
                            </div>
                        </div>

                        <div class="hover-lift flex items-center gap-3 bg-white px-4 py-2.5 rounded-2xl border border-slate-200/80 shadow-sm">
                            <i class="fas fa-medal text-emerald-600 text-2xl"></i>
                            <div class="text-start">
                                <div class="text-xs font-black text-slate-900">CBAHI</div>
                                <div class="text-[10px] text-slate-500 font-semibold">{{ $isRtl ? 'اعتماد المركز السعودي' : 'Saudi National Accreditation' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- =========================================================================
         7. MEDICAL DOCTORS & FACULTY CAROUSEL SECTION (#doctors - 3 Visible Cards with Continuous Loop)
         ========================================================================= -->
    <section
        id="doctors"
        class="py-16 bg-white relative"
        x-data="infiniteCarousel()"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Section Header with Navigation Buttons -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10 reveal">
                <div>
                    <span class="text-sky-600 font-bold text-xs uppercase tracking-wider bg-sky-50 px-3.5 py-1 rounded-full">
                        {{ $isRtl ? 'الكادر الطبي الاستشاري' : 'Consultant Faculty' }}
                    </span>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 mt-3 mb-2">
                        {{ $isRtl ? 'نخبة كبار الأطباء والاستشاريين' : 'Distinguished Senior Consultants' }}
                    </h2>
                    <p class="text-slate-600 text-xs sm:text-sm max-w-xl">
                        {{ $isRtl ? 'اختر طبيبك المعالج من بين خيرة الخبرات الاستشارية (3 في كل عرض) واستخدم الأسهم للتنقل المستمر.' : 'Meet senior faculty members (3 at a time) with continuous loop side navigation.' }}
                    </p>
                </div>

            </div>

            <!-- 3-Card Carousel Wrapper -->
            <div class="slider-wrapper">
                <!-- Floating Side Prev Button -->
                <button
                    type="button"
                    @click="prev()"
                    class="slider-side-btn btn-prev flex"
                    aria-label="Previous"
                >
                    <i class="fas {{ $isRtl ? 'fa-chevron-right' : 'fa-chevron-left' }}"></i>
                </button>

                <!-- Cards Slider Track inside Viewport -->
                <div class="slider-viewport">
                    <div x-ref="track" class="slider-track">
                    @forelse ($doctors as $doc)
                        <div class="slider-card hover-lift bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden flex flex-col justify-between">
                            <div>
                                <!-- Image box -->
                                <div class="h-56 bg-slate-100 overflow-hidden relative group">
                                    <img
                                        src="{{ $doc->avatar_url }}"
                                        alt="{{ $doc->name }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                        loading="lazy"
                                    >
                                    <span class="absolute top-3 end-3 bg-white/90 backdrop-blur-md text-[#084c61] text-[11px] font-bold px-2.5 py-1 rounded-full shadow-sm">
                                        {{ $doc->specialization_name }}
                                    </span>
                                </div>

                                <!-- Body -->
                                <div class="p-5">
                                    <div class="flex items-center justify-between text-xs mb-1">
                                        <div class="text-amber-500 font-bold flex items-center gap-1">
                                            <i class="fas fa-star text-[11px]"></i>
                                            <span>{{ number_format((float)($doc->rating ?? 4.9), 1) }}</span>
                                        </div>
                                        <span class="text-slate-400 text-[11px]">
                                            {{ $isRtl ? '+12 سنة خبرة' : '+12 yrs exp' }}
                                        </span>
                                    </div>

                                    <h4 class="text-base font-bold text-slate-900 mb-1">
                                        {{ $doc->name }}
                                    </h4>
                                    <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed mb-4">
                                        {{ $doc->bio ?? ($isRtl ? 'استشاري حاصل على الزمالة الدولية، متخصص في أحدث التدخلات الدقيقة.' : 'Senior consultant specialized in modern interventional protocols.') }}
                                    </p>
                                </div>
                            </div>

                            <div class="p-5 pt-0">
                                <a href="{{ route('register') }}" class="btn-ripple w-full py-2.5 px-4 rounded-xl bg-sky-50 hover:bg-[#084c61] text-sky-700 hover:text-white font-bold text-xs flex items-center justify-center gap-2 transition duration-200">
                                    <i class="fas fa-calendar-check text-xs"></i>
                                    <span>{{ $isRtl ? 'حجز موعد كشف' : 'Book Consultation' }}</span>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="slider-card bg-white rounded-2xl p-6 text-center text-slate-400">
                            {{ $isRtl ? 'لا يوجد أطباء متاحون حالياً' : 'No doctors available' }}
                        </div>
                    @endforelse
                    </div>
                </div>

                <!-- Floating Side Next Button -->
                <button
                    type="button"
                    @click="next()"
                    class="slider-side-btn btn-next flex"
                    aria-label="Next"
                >
                    <i class="fas {{ $isRtl ? 'fa-chevron-left' : 'fa-chevron-right' }}"></i>
                </button>
            </div>

        </div>
    </section>

    <!-- =========================================================================
         8. SENIOR BOARD CERTIFIED CONSULTANTS BANNER
         ========================================================================= -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 my-16 reveal">
        <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-10 lg:p-12 shadow-sm hover-lift">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">

                <!-- Left Column: Doctor Consultation Image -->
                <div class="lg:col-span-6 relative">
                    <div class="rounded-2xl overflow-hidden shadow-lg border-2 border-slate-100 relative group">
                        <img
                            src="{{ URL::asset('Dashboard/img/doctor-consultation.jpg') }}"
                            alt="Aura Hospital Senior Medical Faculty"
                            class="w-full h-80 sm:h-96 object-cover group-hover:scale-105 transition-transform duration-500"
                            loading="lazy"
                        >
                        <!-- Floating Dark Glassmorphic Pill at bottom of image -->
                        <div class="absolute bottom-4 inset-x-4 bg-slate-900/85 backdrop-blur-md text-white p-3.5 rounded-xl text-center shadow-lg">
                            <div class="text-xs font-bold">{{ $isRtl ? 'عيادات الاستشارة الخارجية المتكاملة' : 'Integrated Outpatient Specialty Clinics' }}</div>
                            <div class="text-[10px] text-slate-300 mt-0.5">{{ $isRtl ? 'أكثر من 40 عيادة تخصصية بأحدث تجهيزات الفحص السريع' : 'Over 40 clinics equipped with instant diagnostics' }}</div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Consultant Faculty Details -->
                <div class="lg:col-span-6 text-start">
                    <span class="text-sky-600 font-bold text-xs uppercase tracking-wider bg-sky-50 px-3.5 py-1 rounded-full">
                        {{ $isRtl ? 'النخبة الطبية' : 'Medical Faculty' }}
                    </span>

                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-3 mb-4 leading-snug">
                        {{ $isRtl ? 'استشاريون معتمدون من البورد الأمريكي والكندي والأوروبي' : 'Board-Certified Consultants (American, Canadian & European)' }}
                    </h2>

                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-6">
                        {{ $isRtl 
                            ? 'نحرص على استقطاب أعضاء يمتلكون سجلات بحثية وعلاجية مشهوداً لها دولياً، يرافقهم طاقم تمريض مدرب على بروتوكولات الرعاية التخصصية وإدارة الصدمات للنهوض والرعاية.' 
                            : 'We host internationally recognized physicians supported by specialized clinical nursing trained in trauma management and advanced recovery.' }}
                    </p>

                    <!-- 3 Checklist Items -->
                    <div class="space-y-3 mb-8">
                        <div class="flex items-center gap-3 text-xs font-semibold text-slate-700">
                            <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                                <i class="fas fa-check text-[10px]"></i>
                            </span>
                            <span>{{ $isRtl ? 'فحص شامل ومطابقة التوافق الطبي قبل أي تدخل دوائي' : 'Comprehensive screening and drug compatibility before treatment' }}</span>
                        </div>

                        <div class="flex items-center gap-3 text-xs font-semibold text-slate-700">
                            <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                                <i class="fas fa-check text-[10px]"></i>
                            </span>
                            <span>{{ $isRtl ? 'أحدث أنظمة الأشعة والتداخلات الدقيقة والمناظير على مدار الساعة' : 'State-of-the-art 24/7 radiology, interventional, and endoscopy units' }}</span>
                        </div>

                        <div class="flex items-center gap-3 text-xs font-semibold text-slate-700">
                            <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                                <i class="fas fa-check text-[10px]"></i>
                            </span>
                            <span>{{ $isRtl ? 'استشارات صوتية ومباشرة عن بعد عبر بوابة المريض الذكية' : 'Remote telehealth audio/video consultations via the patient portal' }}</span>
                        </div>
                    </div>

                    <!-- Button: Browse Doctors -->
                    <a href="#doctors" class="btn-ripple inline-flex items-center gap-2.5 bg-sky-50 hover:bg-sky-100 text-sky-700 font-bold px-6 py-3 rounded-xl text-xs transition">
                        <i class="fas fa-user-doctor text-sky-600"></i>
                        <span>{{ $isRtl ? 'تصفح الدليل الكامل للأطباء والاستشاريين' : 'Browse All Doctors & Faculty' }}</span>
                        <i class="fas fa-arrow-left text-[11px]"></i>
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- =========================================================================
         9. DIGITAL PHARMACY SECTION (#pharmacy)
         ========================================================================= -->
    <section id="pharmacy" class="py-16 bg-gradient-to-br from-emerald-50/60 via-teal-50/30 to-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">

                <!-- Left Content -->
                <div class="lg:col-span-6 reveal reveal-delay-1 text-start">
                    <span class="text-emerald-700 font-bold text-xs uppercase tracking-wider bg-emerald-100/70 px-3.5 py-1 rounded-full">
                        {{ $isRtl ? 'الصيدلية الذكية' : 'Smart Digital Pharmacy' }}
                    </span>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 mt-3 mb-4 leading-tight">
                        {{ $isRtl ? 'صيدلية المستشفى الرقمية على مدار 24 ساعة' : '24/7 Digital In-House Pharmacy' }}
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-6">
                        {{ $isRtl 
                            ? 'صرف فوري للوصفات الطبية الإلكترونية المعتمدة مع خدمة توصيل الأدوية للمنزل ومتابعة برامج العلاج للأمراض المزمنة بدقة متناهية.' 
                            : 'Automated dispensing of verified e-prescriptions, doorstep medication delivery, and chronic refill tracking.' }}
                    </p>

                    <div class="space-y-4 mb-8">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5">
                                <i class="fas fa-check text-xs"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-900">{{ $isRtl ? 'تزامن مباشر مع ملف المريض' : 'Direct Electronic Health Record Sync' }}</h4>
                                <p class="text-[11px] text-slate-500">{{ $isRtl ? 'تصل الوصفة للصيدلي بمجرد اعتماد الطبيب لها في العيادة.' : 'Prescriptions flow directly into the pharmacy queue.' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5">
                                <i class="fas fa-check text-xs"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-900">{{ $isRtl ? 'فحص التعارضات الدوائية آلياً' : 'Automated Drug Safety & Interaction Screening' }}</h4>
                                <p class="text-[11px] text-slate-500">{{ $isRtl ? 'نظام ذكي ينبه الصيدلي لأي تعارضات كيميائية أو حساسية للحفاظ على سلامتك.' : 'Safety algorithms check allergy profiles and medication contraindications.' }}</p>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('login') }}" class="btn-shimmer btn-ripple inline-flex items-center gap-2 bg-[#047857] hover:bg-[#065f46] text-white px-7 py-3 rounded-xl font-bold text-xs shadow transition">
                        <i class="fas fa-pills text-xs"></i>
                        <span>{{ $isRtl ? 'طلب الأدوية عبر البوابة الإلكترونية' : 'Request Medication Online' }}</span>
                    </a>
                </div>

                <!-- Right Vibrant Showcase Card -->
                <div class="lg:col-span-6 reveal reveal-delay-2">
                    <div class="bg-gradient-to-br from-emerald-600 to-teal-700 text-white rounded-3xl p-8 sm:p-10 shadow-xl relative overflow-hidden hover-lift">
                        <div class="ambient-blob-1 absolute -top-10 -right-10 w-48 h-48 bg-white/20 rounded-full blur-2xl pointer-events-none"></div>

                        <div class="w-14 h-14 rounded-2xl bg-white/20 text-white flex items-center justify-center text-3xl mb-5 shadow-sm">
                            <i class="fas fa-prescription-bottle-medical"></i>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-bold mb-3">
                            {{ $isRtl ? 'متابعة خطتك الدوائية وإعادة الصرف بضغطة زر' : 'Medication Refills & Delivery' }}
                        </h3>
                        <p class="text-emerald-100 text-xs sm:text-sm leading-relaxed mb-6 max-w-md">
                            {{ $isRtl 
                                ? 'سجل دخولك الآن عبر بوابة المرضى لمراجعة الأدوية المصروفة ومواعيد الجرعات وجدولة التوصيل المباشر.' 
                                : 'Log in to your patient portal to review active prescriptions, dosage schedules, and doorstep delivery.' }}
                        </p>
                        <a href="{{ route('login') }}" class="btn-ripple inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-white text-emerald-800 font-bold text-xs shadow hover:bg-slate-50 transition">
                            <i class="fas fa-sign-in-alt text-xs"></i>
                            <span>{{ $isRtl ? 'الدخول لبوابة الصيدلية' : 'Access Pharmacy Portal' }}</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- =========================================================================
         10. MEDICAL ARTICLES & HEALTH INFO CAROUSEL (#medical-info - 3 Visible Cards with Continuous Loop)
         ========================================================================= -->
    <section
        id="medical-info"
        class="py-16 bg-white relative"
        x-data="infiniteCarousel()"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Section Header (Clean header without redundant top arrows) -->
            <div class="max-w-3xl mb-10 reveal text-start">
                <span class="text-sky-600 font-bold text-xs uppercase tracking-wider bg-sky-50 px-3.5 py-1 rounded-full">
                    {{ $isRtl ? 'التثقيف والتوعية الصحية' : 'Health Knowledge & Insights' }}
                </span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 mt-3 mb-2">
                    {{ $isRtl ? 'المعلومات الطبية وإرشادات نمط الحياة السليم' : 'Clinical Insights & Medical Advice' }}
                </h2>
                <p class="text-slate-600 text-xs sm:text-sm max-w-xl">
                    {{ $isRtl ? 'مقالات وإرشادات صحية موثوقة بقلم كبار أطبائنا لتعزيز صحتك وسلامة عائلتك (3 في كل عرض).' : 'Evidence-based healthcare articles (3 visible at a time) with continuous card-by-card navigation.' }}
                </p>
            </div>

            <!-- 3-Card Carousel Wrapper -->
            <div class="slider-wrapper">
                <!-- Floating Side Prev Button -->
                <button
                    type="button"
                    @click="prev()"
                    class="slider-side-btn btn-prev flex"
                    aria-label="Previous"
                >
                    <i class="fas {{ $isRtl ? 'fa-chevron-right' : 'fa-chevron-left' }}"></i>
                </button>

                <!-- Cards Slider Track inside Viewport -->
                <div class="slider-viewport">
                    <div x-ref="track" class="slider-track">
                    <!-- Article 1 -->
                    <article class="slider-card hover-lift bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden flex flex-col justify-between">
                        <div>
                            <div class="h-44 bg-rose-50 flex items-center justify-center text-rose-500 text-5xl">
                                <i class="fas fa-heart-pulse"></i>
                            </div>
                            <div class="p-6">
                                <div class="flex items-center justify-between text-[11px] font-bold text-slate-400 mb-2">
                                    <span class="text-rose-600 bg-rose-50 px-2.5 py-0.5 rounded-full">{{ $isRtl ? 'صحة القلب' : 'Cardiology' }}</span>
                                    <span>{{ $isRtl ? 'قراءة 4 دقائق' : '4 min read' }}</span>
                                </div>
                                <h4 class="text-sm font-bold text-slate-900 mb-2 leading-snug">
                                    {{ $isRtl ? 'أهم 5 علامات تحذيرية لصحة القلب لا يجب تجاهلها أبداً' : '5 Early Cardiovascular Warning Signs Never to Ignore' }}
                                </h4>
                                <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed">
                                    {{ $isRtl ? 'إرشادات استشاريي القلب حول المؤشرات الحيوية المبكرة وأهمية الفحص الدوري لمنع الأزمات القلبية المفاجئة.' : 'Key indicators for early intervention and preventive cardiology recommendations.' }}
                                </p>
                            </div>
                        </div>
                        <div class="p-6 pt-0 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                            <span>{{ $isRtl ? 'بقلم: د. استشاري القلب' : 'By Cardiology Faculty' }}</span>
                            <span class="text-sky-600 font-bold hover:underline cursor-pointer">{{ $isRtl ? 'اقرأ المزيد' : 'Read More' }}</span>
                        </div>
                    </article>

                    <!-- Article 2 -->
                    <article class="slider-card hover-lift bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden flex flex-col justify-between">
                        <div>
                            <div class="h-44 bg-emerald-50 flex items-center justify-center text-emerald-500 text-5xl">
                                <i class="fas fa-apple-whole"></i>
                            </div>
                            <div class="p-6">
                                <div class="flex items-center justify-between text-[11px] font-bold text-slate-400 mb-2">
                                    <span class="text-emerald-600 bg-emerald-50 px-2.5 py-0.5 rounded-full">{{ $isRtl ? 'التغذية العلاجية' : 'Nutrition' }}</span>
                                    <span>{{ $isRtl ? 'قراءة 3 دقائق' : '3 min read' }}</span>
                                </div>
                                <h4 class="text-sm font-bold text-slate-900 mb-2 leading-snug">
                                    {{ $isRtl ? 'الدليل الغذائي المتكامل لمرضى السكري والضغط' : 'Comprehensive Dietary Protocol for Diabetes & Hypertension' }}
                                </h4>
                                <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed">
                                    {{ $isRtl ? 'نصائح عملية لتنظيم الوجبات وضبط مستويات الجلوكوز في الدم وتعزيز اللياقة البدنية والوقاية من المضاعفات.' : 'Actionable nutritional advice for maintaining stable blood glycemic indexes and wellness.' }}
                                </p>
                            </div>
                        </div>
                        <div class="p-6 pt-0 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                            <span>{{ $isRtl ? 'بقلم: عيادة التغذية' : 'By Clinical Nutrition' }}</span>
                            <span class="text-sky-600 font-bold hover:underline cursor-pointer">{{ $isRtl ? 'اقرأ المزيد' : 'Read More' }}</span>
                        </div>
                    </article>

                    <!-- Article 3 -->
                    <article class="slider-card hover-lift bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden flex flex-col justify-between">
                        <div>
                            <div class="h-44 bg-purple-50 flex items-center justify-center text-purple-500 text-5xl">
                                <i class="fas fa-shield-virus"></i>
                            </div>
                            <div class="p-6">
                                <div class="flex items-center justify-between text-[11px] font-bold text-slate-400 mb-2">
                                    <span class="text-purple-600 bg-purple-50 px-2.5 py-0.5 rounded-full">{{ $isRtl ? 'المناعة والوقاية' : 'Immunology' }}</span>
                                    <span>{{ $isRtl ? 'قراءة 5 دقائق' : '5 min read' }}</span>
                                </div>
                                <h4 class="text-sm font-bold text-slate-900 mb-2 leading-snug">
                                    {{ $isRtl ? 'طرق تقوية المناعة الطبيعية خلال مواسم تغير الطقس' : 'Strengthening Natural Immunity During Seasonal Transitions' }}
                                </h4>
                                <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed">
                                    {{ $isRtl ? 'إرشادات الأطباء حول لقاحات الإنفلونزا والمكملات الغذائية لدعم مناعة كبار السن والأطفال وتجنب العدوى.' : 'Specialist advice on vaccinations and lifestyle practices for pediatric and geriatric health.' }}
                                </p>
                            </div>
                        </div>
                        <div class="p-6 pt-0 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                            <span>{{ $isRtl ? 'بقلم: قسم المناعة' : 'By Immunology Dept' }}</span>
                            <span class="text-sky-600 font-bold hover:underline cursor-pointer">{{ $isRtl ? 'اقرأ المزيد' : 'Read More' }}</span>
                        </div>
                    </article>

                    <!-- Article 4 -->
                    <article class="slider-card hover-lift bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden flex flex-col justify-between">
                        <div>
                            <div class="h-44 bg-sky-50 flex items-center justify-center text-sky-500 text-5xl">
                                <i class="fas fa-bone"></i>
                            </div>
                            <div class="p-6">
                                <div class="flex items-center justify-between text-[11px] font-bold text-slate-400 mb-2">
                                    <span class="text-sky-600 bg-sky-50 px-2.5 py-0.5 rounded-full">{{ $isRtl ? 'جراحة العظام' : 'Orthopedics' }}</span>
                                    <span>{{ $isRtl ? 'قراءة 4 دقائق' : '4 min read' }}</span>
                                </div>
                                <h4 class="text-sm font-bold text-slate-900 mb-2 leading-snug">
                                    {{ $isRtl ? 'أحدث التطورات في استبدال المفاصل بالذراع الروبوتي' : 'Robotic Knee & Hip Arthroplasty Innovations' }}
                                </h4>
                                <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed">
                                    {{ $isRtl ? 'كيف تسهم جراحة العظام بمساعدة الروبوت في تقليل فترة الإقامة بالمستشفى والعودة السريعة للحياة الطبيعية.' : 'How robotic precision surgery minimizes recovery time and optimizes implant longevity.' }}
                                </p>
                            </div>
                        </div>
                        <div class="p-6 pt-0 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                            <span>{{ $isRtl ? 'بقلم: جراحة المفاصل' : 'By Joint Surgery' }}</span>
                            <span class="text-sky-600 font-bold hover:underline cursor-pointer">{{ $isRtl ? 'اقرأ المزيد' : 'Read More' }}</span>
                        </div>
                    </article>

                    <!-- Article 5 -->
                    <article class="slider-card hover-lift bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden flex flex-col justify-between">
                        <div>
                            <div class="h-44 bg-indigo-50 flex items-center justify-center text-indigo-500 text-5xl">
                                <i class="fas fa-brain"></i>
                            </div>
                            <div class="p-6">
                                <div class="flex items-center justify-between text-[11px] font-bold text-slate-400 mb-2">
                                    <span class="text-indigo-600 bg-indigo-50 px-2.5 py-0.5 rounded-full">{{ $isRtl ? 'المخ والأعصاب' : 'Neurology' }}</span>
                                    <span>{{ $isRtl ? 'قراءة 3 دقائق' : '3 min read' }}</span>
                                </div>
                                <h4 class="text-sm font-bold text-slate-900 mb-2 leading-snug">
                                    {{ $isRtl ? 'الصداع المزمن وأعراض الجهاز العصبي: متى يجب استشارة الطبيب؟' : 'Chronic Headaches: When to Seek Neurological Consultation' }}
                                </h4>
                                <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed">
                                    {{ $isRtl ? 'مؤشرات دقيقة للتفرقة بين الصداع التوتري الشائع ومؤشرات السكتة الدماغية أو اضطرابات الأعصاب الدقيقة.' : 'Distinguishing tension headaches from neurological red flags requiring rapid intervention.' }}
                                </p>
                            </div>
                        </div>
                        <div class="p-6 pt-0 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                            <span>{{ $isRtl ? 'بقلم: استشاري الأعصاب' : 'By Neurology Faculty' }}</span>
                            <span class="text-sky-600 font-bold hover:underline cursor-pointer">{{ $isRtl ? 'اقرأ المزيد' : 'Read More' }}</span>
                        </div>
                    </article>
                    </div>
                </div>

                <!-- Floating Side Next Button -->
                <button
                    type="button"
                    @click="next()"
                    class="slider-side-btn btn-next flex"
                    aria-label="Next"
                >
                    <i class="fas {{ $isRtl ? 'fa-chevron-left' : 'fa-chevron-right' }}"></i>
                </button>
            </div>

        </div>
    </section>

    <!-- =========================================================================
         11. ONLINE BOOKING & PATIENT PORTAL CTA BANNER
         ========================================================================= -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 my-20 reveal">
        <div class="bg-gradient-to-r from-[#035c81] via-[#0284c7] to-[#084c61] rounded-3xl p-8 sm:p-12 lg:p-14 text-white shadow-2xl relative overflow-hidden">
            <!-- Decorative Background Graphic -->
            <div class="ambient-blob-1 absolute -right-20 -bottom-20 w-80 h-80 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center relative z-10">

                <!-- Left Column: Instant Booking Floating Card -->
                <div class="lg:col-span-5 order-2 lg:order-1">
                    <div class="bg-white rounded-2xl p-6 text-slate-900 shadow-2xl max-w-md mx-auto lg:mx-0">
                        <div class="flex items-center gap-3 pb-4 mb-4 border-b border-slate-100">
                            <div class="card-icon-box w-9 h-9 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center font-bold">
                                <i class="fas fa-calendar-check text-base"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-900">
                                    {{ $isRtl ? 'حجز موعد عاجل' : 'Instant Appointment Booking' }}
                                </h4>
                                <p class="text-[10px] text-slate-500">
                                    {{ $isRtl ? 'تأكيد فوري برقم تذكرة رقمية' : 'Instant confirmation with digital pass' }}
                                </p>
                            </div>
                        </div>

                        <form action="{{ route('register') }}" method="GET" class="space-y-3.5">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 mb-1">
                                    {{ $isRtl ? 'رقم الهوية الوطنية أو الإقامة' : 'National ID / Residence Number' }}
                                </label>
                                <input
                                    type="text"
                                    placeholder="1xxxxxxxx"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500 transition"
                                >
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 mb-1">
                                    {{ $isRtl ? 'رقم الجوال لتلقي الرمز' : 'Mobile Phone Number' }}
                                </label>
                                <input
                                    type="text"
                                    placeholder="055 000 0000"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500 transition"
                                >
                            </div>

                            <button
                                type="submit"
                                class="btn-shimmer btn-ripple w-full bg-[#047857] hover:bg-[#065f46] text-white py-3 rounded-xl font-bold text-xs flex items-center justify-center gap-2 shadow transition"
                            >
                                <i class="fas fa-check text-xs"></i>
                                <span>{{ $isRtl ? 'تأكيد الحجز الفوري' : 'Confirm Instant Booking' }}</span>
                            </button>
                        </form>

                        <p class="text-[10px] text-slate-400 text-center mt-3">
                            {{ $isRtl ? 'بياناتك محمية ومشفرة وفق أعلى معايير أمن المعلومات الصحية' : 'Protected by strict healthcare encryption standards' }}
                        </p>
                    </div>
                </div>

                <!-- Right Column: Portal Callout & Action Buttons -->
                <div class="lg:col-span-7 order-1 lg:order-2 text-center lg:text-start">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white/15 text-white border border-white/20 text-xs font-bold mb-4">
                        <i class="fas fa-shield-alt text-xs"></i>
                        <span>{{ $isRtl ? 'خدمة دفع وحجز فوري' : 'Instant Payment & Booking' }}</span>
                    </div>

                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight leading-snug mb-4">
                        {{ $isRtl ? 'احجز كشفك الطبي الإلكتروني وسجل ملفك الصحي بضغطة زر' : 'Book Your Electronic Medical Appointment & Register in Seconds' }}
                    </h2>

                    <p class="text-xs sm:text-sm text-sky-100 leading-relaxed mb-8 max-w-xl mx-auto lg:mx-0">
                        {{ $isRtl 
                            ? 'وفّر وقت الانتظار وأتم كافة مواعيدك، وتابع الفحوصات الطبية، وصرف الأدوية عبر بوابتنا الإلكترونية الآمنة والمعتمدة رسمياً لأجلك.' 
                            : 'Save waiting time, manage visits, monitor laboratory results, and request prescriptions through our certified patient portal.' }}
                    </p>

                    <!-- Buttons Row -->
                    <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4">
                        <a href="{{ route('register') }}" class="btn-shimmer btn-ripple bg-white hover:bg-slate-100 text-[#084c61] font-bold px-6 py-3 rounded-xl text-xs shadow-md transition flex items-center gap-2">
                            <i class="fas fa-user-plus text-xs"></i>
                            <span>{{ $isRtl ? 'تسجيل حساب مريض جديد' : 'Register New Patient' }}</span>
                        </a>

                        <a href="{{ route('login') }}" class="btn-shimmer btn-ripple bg-transparent hover:bg-white/10 border border-white/40 text-white font-bold px-6 py-3 rounded-xl text-xs transition flex items-center gap-2">
                            <i class="fas fa-sign-in-alt text-xs"></i>
                            <span>{{ $isRtl ? 'الدخول لتداول الملف الطبي' : 'Sign in to Patient Portal' }}</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- =========================================================================
         12. FOOTER SECTION
         ========================================================================= -->
    <footer class="bg-white border-t border-slate-200/80 pt-16 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 pb-12 border-b border-slate-100">

                <!-- Col 1: Brand & Accreditations -->
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-sky-500 to-blue-600 text-white flex items-center justify-center">
                            <i class="fas fa-hospital text-sm"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-base font-extrabold text-slate-900 leading-tight">
                                {{ $isRtl ? 'مستشفى أورا التخصصي' : 'Aura Medical Hospital' }}
                            </span>
                            <span class="text-[10px] text-sky-600 font-semibold">
                                {{ $isRtl ? 'Aura Medical Hospital' : 'Healthcare Center' }}
                            </span>
                        </div>
                    </div>

                    <p class="text-xs text-slate-500 leading-relaxed mb-6">
                        {{ $isRtl 
                            ? 'صرح طبي رائد يجمع نخبة العقول الطبية وأحدث تقنيات التشخيص والجراحة لتقديم بيئة استشفائية آمنة وفق أعلى معايير الجودة العالمية.' 
                            : 'A premier medical institution combining world-class clinical minds and modern diagnostic technologies.' }}
                    </p>

                    <!-- Micro Accreditation Badges -->
                    <div class="flex items-center gap-3 text-[11px] font-bold text-slate-600">
                        <span class="inline-flex items-center gap-1.5"><i class="fas fa-shield-alt text-sky-600"></i> {{ $isRtl ? 'معتمد من كباهي' : 'CBAHI Accredited' }}</span>
                        <span class="text-slate-300">|</span>
                        <span class="inline-flex items-center gap-1.5"><i class="fas fa-award text-emerald-600"></i> JCI Quality</span>
                    </div>
                </div>

                <!-- Col 2: Clinical Departments & Clinics -->
                <div>
                    <h5 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-4">
                        {{ $isRtl ? 'الأقسام الطبية والعيادات' : 'Departments & Clinics' }}
                    </h5>
                    <ul class="space-y-2.5 text-xs text-slate-500">
                        <li><a href="#departments" class="hover:text-sky-600 transition">{{ $isRtl ? 'مراكز جراحة القلب والأوعية الدموية' : 'Cardiovascular Surgery Center' }}</a></li>
                        <li><a href="#departments" class="hover:text-sky-600 transition">{{ $isRtl ? 'قسم السكتة الدماغية والأعصاب المتقدمة' : 'Stroke & Advanced Neurology' }}</a></li>
                        <li><a href="#departments" class="hover:text-sky-600 transition">{{ $isRtl ? 'مراكز جراحة المفاصل والعمود الفقري' : 'Joint & Spine Surgery Center' }}</a></li>
                        <li><a href="#departments" class="hover:text-sky-600 transition">{{ $isRtl ? 'وحدة الأورام والعلاج الإشعاعي الدقيق' : 'Oncology & Precision Radiotherapy' }}</a></li>
                        <li><a href="#departments" class="hover:text-sky-600 transition">{{ $isRtl ? 'قسم النساء والولادة وطب الأطفال الفائق' : 'Maternity & Neonatal Care' }}</a></li>
                    </ul>
                </div>

                <!-- Col 3: Quick Services & Links -->
                <div>
                    <h5 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-4">
                        {{ $isRtl ? 'روابط وخدمات سريعة' : 'Quick Services & Links' }}
                    </h5>
                    <ul class="space-y-2.5 text-xs text-slate-500">
                        <li><a href="{{ route('register') }}" class="hover:text-sky-600 transition">{{ $isRtl ? 'حجز موعد عيادة خارجية' : 'Book Outpatient Visit' }}</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-sky-600 transition">{{ $isRtl ? 'الاستعلام عن نتائج التحاليل والأشعة' : 'Lab & Radiology Results' }}</a></li>
                        <li><a href="#pharmacy" class="hover:text-sky-600 transition">{{ $isRtl ? 'دليل الأدوية وصيدلية أورا الذكية' : 'Digital In-House Pharmacy' }}</a></li>
                        <li><a href="{{ route('home') }}" class="hover:text-sky-600 transition">{{ $isRtl ? 'سياسات المرضى والحقوق والمسؤولية' : 'Patient Bill of Rights' }}</a></li>
                        <li><a href="#doctors" class="hover:text-sky-600 transition">{{ $isRtl ? 'جدول العيادات وتوافر الأطباء' : 'Physician Duty Schedules' }}</a></li>
                    </ul>
                </div>

                <!-- Col 4: Hours & Branch Info -->
                <div>
                    <h5 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-4">
                        {{ $isRtl ? 'ساعات العمل والفروع' : 'Hours & Branches' }}
                    </h5>
                    <div class="space-y-3 text-xs text-slate-600">
                        <div class="flex items-center gap-2.5">
                            <i class="far fa-clock text-slate-400"></i>
                            <span>{{ $isRtl ? 'العيادات الخارجية: 8:00 ص - 10:00 م' : 'Outpatient: 8:00 AM - 10:00 PM' }}</span>
                        </div>
                        <div class="flex items-center gap-2.5 text-rose-600 font-bold">
                            <i class="fas fa-truck-medical"></i>
                            <span>{{ $isRtl ? 'قسم الطوارئ والإسعاف: متاح 24/7' : 'Emergency & Trauma: 24/7 Active' }}</span>
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

            <!-- Bottom Copyright Strip -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-400">
                <div>
                    {{ $isRtl 
                        ? 'جميع الحقوق محفوظة © ' . date('Y') . ' مستشفى أورا التخصصي - مرخص من الهيئة العامة للاعتماد والرقابة الصحية.' 
                        : '© ' . date('Y') . ' Aura Medical Hospital. All rights reserved. Certified by Health Accreditation Authority.' }}
                </div>
                <div class="text-[11px] text-slate-400">
                    {{ $isRtl ? 'من شأنها تسليم الرعاية التي ترضيكم جميعاً' : 'Dedicated to delivering care that brings total peace of mind' }}
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to top button -->
    <button id="back-to-top-btn" class="btn-back-to-top" aria-label="{{ $isRtl ? 'الرجوع للأعلى' : 'Back to top' }}">
        <i class="fas fa-arrow-up"></i>
    </button>

</body>
</html>
