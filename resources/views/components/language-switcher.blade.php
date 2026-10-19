@props([
    'variant' => 'dropdown', // 'dropdown', 'button', 'compact', 'glass'
    'class'   => '',
])

@php
    $currentLocale = app()->getLocale();
    $targetLocale  = $currentLocale === 'ar' ? 'en' : 'ar';
    $targetName    = $currentLocale === 'ar' ? 'English' : 'العربية';
    $targetCode    = $currentLocale === 'ar' ? 'EN' : 'AR';
    $currentFlag   = $currentLocale === 'ar' ? 'eg_flag.svg' : 'us_flag.svg';
    $targetFlag    = $currentLocale === 'ar' ? 'us_flag.svg' : 'eg_flag.svg';
    $currentName   = $currentLocale === 'ar' ? 'العربية' : 'English';
    $switchUrl     = route('locale.switch', $targetLocale);

    // ID فريد لكل instance
    $dropdownId = 'lang-dropdown-' . uniqid();
@endphp

@if($variant === 'dropdown')
    {{-- Dropdown مع العلم - نفس شكل الداشبورد، يعمل بدون Bootstrap --}}
    <div class="lang-switcher-wrap {{ $class }}" style="position: relative; display: inline-block;">
        <button
            type="button"
            onclick="toggleLangDropdown('{{ $dropdownId }}')"
            title="{{ $currentLocale === 'ar' ? 'تغيير اللغة' : 'Change Language' }}"
            style="display: inline-flex; align-items: center; gap: 6px; padding: 5px 10px;
                   border-radius: 20px; border: 1px solid #e2e8f0; background: white;
                   cursor: pointer; font-family: inherit; text-decoration: none;
                   box-shadow: 0 1px 3px rgba(0,0,0,0.07); transition: border-color 0.2s;">
            <img src="{{ asset('Dashboard/img/flags/' . $currentFlag) }}"
                 alt="{{ $currentLocale }}"
                 style="width: 22px; height: 15px; object-fit: cover; border-radius: 3px; box-shadow: 0 1px 3px rgba(0,0,0,0.15);">
            <span style="font-size: 13px; font-weight: 600; color: #141c2b;">{{ $currentName }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none"
                 stroke="#9ca3af" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
        </button>

        <div id="{{ $dropdownId }}"
             style="display: none; position: absolute; top: calc(100% + 6px);
                    {{ $currentLocale === 'ar' ? 'left: 0;' : 'right: 0;' }}
                    min-width: 160px; background: white; border: 1px solid #e5e7eb;
                    border-radius: 10px; box-shadow: 0 4px 16px rgba(0,0,0,0.1);
                    z-index: 9999; overflow: hidden;">
            <div style="font-size: 10px; font-weight: 700; color: #9ca3af;
                        text-transform: uppercase; letter-spacing: 0.08em;
                        padding: 8px 14px 6px; border-bottom: 1px solid #f3f4f6;">
                🌐 {{ $currentLocale === 'ar' ? 'اختر اللغة' : 'Select Language' }}
            </div>
            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                @php
                    $flag     = $localeCode === 'ar' ? 'eg_flag.svg' : 'us_flag.svg';
                    $isActive = app()->getLocale() === $localeCode;
                @endphp
                <a href="{{ route('locale.switch', $localeCode) }}"
                   rel="alternate"
                   hreflang="{{ $localeCode }}"
                   style="display: flex; align-items: center; gap: 8px; padding: 9px 14px;
                          font-size: 13px; text-decoration: none; transition: background 0.15s; color: #141c2b;
                          {{ $isActive ? 'font-weight: 700; background: #fdf3ee;' : '' }}"
                   onmouseover="this.style.background='#f3f4f6'"
                   onmouseout="this.style.background='{{ $isActive ? '#fdf3ee' : 'transparent' }}'">
                    <img src="{{ asset('Dashboard/img/flags/' . $flag) }}"
                         alt="{{ $properties['native'] }}"
                         style="width: 20px; height: 14px; object-fit: cover; border-radius: 2px; flex-shrink: 0;">
                    <span style="flex: 1;">{{ $properties['native'] }}</span>
                    @if($isActive)
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24"
                             fill="none" stroke="#22c55e" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    @endif
                </a>
            @endforeach
        </div>
    </div>

    <script>
        function toggleLangDropdown(id) {
            const el = document.getElementById(id);
            const isOpen = el.style.display === 'block';
            // إغلاق كل الـ dropdowns المفتوحة
            document.querySelectorAll('[id^="lang-dropdown-"]').forEach(d => d.style.display = 'none');
            el.style.display = isOpen ? 'none' : 'block';
        }
        // إغلاق عند الضغط خارج الـ dropdown
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.lang-switcher-wrap')) {
                document.querySelectorAll('[id^="lang-dropdown-"]').forEach(d => d.style.display = 'none');
            }
        });
    </script>

@elseif($variant === 'glass')
    <a href="{{ $switchUrl }}"
       class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 hover:bg-white/20 border border-white/20 text-white transition-all duration-200 text-xs font-medium backdrop-blur shadow-sm {{ $class }}"
       title="{{ $currentLocale === 'ar' ? 'Switch to English' : 'التبديل إلى العربية' }}">
        <img src="{{ asset('Dashboard/img/flags/' . $targetFlag) }}" alt="{{ $targetName }}" style="width: 16px; height: 11px; object-fit: cover; border-radius: 2px;" />
        <span>{{ $targetName }}</span>
    </a>

@elseif($variant === 'compact')
    <a href="{{ $switchUrl }}"
       class="inline-flex items-center justify-center w-8 h-8 rounded-full border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 hover:bg-neutral-100 dark:hover:bg-neutral-700 transition shadow-xs {{ $class }}"
       title="{{ $currentLocale === 'ar' ? 'Switch to English' : 'التبديل إلى العربية' }}">
        <img src="{{ asset('Dashboard/img/flags/' . $targetFlag) }}" alt="{{ $targetName }}" style="width: 16px; height: 11px; object-fit: cover; border-radius: 2px;" />
    </a>

@else {{-- button (default fallback) --}}
    <a href="{{ $switchUrl }}"
       class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border border-neutral-200 dark:border-neutral-700 bg-white/90 dark:bg-neutral-800/90 backdrop-blur text-neutral-800 dark:text-neutral-100 hover:bg-neutral-50 dark:hover:bg-neutral-700 transition-all duration-200 text-xs font-semibold shadow-xs {{ $class }}"
       title="{{ $currentLocale === 'ar' ? 'Switch to English' : 'التبديل إلى العربية' }}">
        <img src="{{ asset('Dashboard/img/flags/' . $targetFlag) }}" alt="{{ $targetName }}" style="width: 16px; height: 11px; object-fit: cover; border-radius: 2px;" />
        <span>{{ $targetName }}</span>
    </a>
@endif
