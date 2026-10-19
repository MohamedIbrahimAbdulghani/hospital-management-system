<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    @include('partials.head')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&family=Inter:wght@300;400;500;600;700;800&display=swap');

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Cairo', 'Inter', sans-serif;
            min-height: 100vh;
            background: #020817;
            overflow-x: hidden;
            position: relative;
        }

        /* ─── Animated gradient orbs ─── */
        .bg-orbs {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
        }
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.35;
            animation: drift 8s ease-in-out infinite alternate;
        }
        .orb-1 {
            width: 500px; height: 500px;
            background: radial-gradient(circle, #1d4ed8, #7c3aed);
            top: -150px; left: -100px;
            animation-delay: 0s;
        }
        .orb-2 {
            width: 400px; height: 400px;
            background: radial-gradient(circle, #0891b2, #1d4ed8);
            bottom: -100px; right: -80px;
            animation-delay: 3s;
        }
        .orb-3 {
            width: 300px; height: 300px;
            background: radial-gradient(circle, #7c3aed, #db2777);
            top: 40%; left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: 1.5s;
        }
        @keyframes drift {
            0%   { transform: translateY(0) scale(1); }
            100% { transform: translateY(-40px) scale(1.1); }
        }

        /* ─── Grid overlay ─── */
        .grid-overlay {
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            z-index: 0;
        }

        /* ─── Page wrapper ─── */
        .page-wrapper {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        /* ─── Glass card ─── */
        .glass-card {
            background: rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 2.5rem 2rem;
            width: 100%;
            max-width: 820px;
            box-shadow:
                0 0 0 1px rgba(255,255,255,0.05) inset,
                0 32px 80px rgba(0,0,0,0.5);
        }

        /* ─── Brand header ─── */
        .brand-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 2.5rem;
            text-align: center;
        }
        .brand-logo {
            width: 64px; height: 64px;
            background: linear-gradient(135deg, #1d4ed8, #7c3aed);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 1.25rem;
            box-shadow: 0 8px 32px rgba(124,58,237,0.4);
        }
        .brand-logo svg { width: 32px; height: 32px; fill: white; }
        .brand-title {
            font-size: 1.75rem;
            font-weight: 800;
            background: linear-gradient(135deg, #fff 0%, #a5b4fc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.5px;
            margin-bottom: 0.4rem;
        }
        .brand-subtitle {
            font-size: 0.875rem;
            color: rgba(255,255,255,0.45);
            font-weight: 400;
        }

        /* ─── Section label ─── */
        .section-label {
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.3);
            margin-bottom: 1rem;
        }

        /* ─── Roles grid ─── */
        .roles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .role-card {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1.75rem 1rem 1.5rem;
            border-radius: 16px;
            cursor: pointer;
            text-decoration: none;
            border: 1.5px solid rgba(255,255,255,0.08);
            background: rgba(255,255,255,0.03);
            transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
            overflow: hidden;
            gap: 0.875rem;
        }
        .role-card::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 16px;
            opacity: 0;
            transition: opacity 0.3s;
        }
        .role-card:hover { transform: translateY(-5px); border-color: transparent; }
        .role-card:hover::before { opacity: 1; }

        /* Card themes */
        .role-admin::before  { background: linear-gradient(135deg, rgba(239,68,68,0.15), rgba(220,38,38,0.06)); border: 1.5px solid rgba(239,68,68,0.35); }
        .role-doctor::before { background: linear-gradient(135deg, rgba(16,185,129,0.15), rgba(5,150,105,0.06)); border: 1.5px solid rgba(16,185,129,0.35); }
        .role-patient::before{ background: linear-gradient(135deg, rgba(59,130,246,0.15), rgba(37,99,235,0.06)); border: 1.5px solid rgba(59,130,246,0.35); }
        .role-hr::before     { background: linear-gradient(135deg, rgba(168,85,247,0.15), rgba(139,92,246,0.06)); border: 1.5px solid rgba(168,85,247,0.35); }

        .role-admin:hover  { box-shadow: 0 20px 40px rgba(239,68,68,0.2),  0 0 0 1.5px rgba(239,68,68,0.45); }
        .role-doctor:hover { box-shadow: 0 20px 40px rgba(16,185,129,0.2), 0 0 0 1.5px rgba(16,185,129,0.45); }
        .role-patient:hover{ box-shadow: 0 20px 40px rgba(59,130,246,0.2), 0 0 0 1.5px rgba(59,130,246,0.45); }
        .role-hr:hover     { box-shadow: 0 20px 40px rgba(168,85,247,0.2), 0 0 0 1.5px rgba(168,85,247,0.45); }

        /* ─── Role icon ─── */
        .role-icon {
            width: 56px; height: 56px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            position: relative; z-index: 1;
            transition: transform 0.3s;
        }
        .role-card:hover .role-icon { transform: scale(1.1) rotate(-3deg); }

        .icon-admin   { background: linear-gradient(135deg,#ef4444,#dc2626); box-shadow: 0 8px 24px rgba(239,68,68,0.45); }
        .icon-doctor  { background: linear-gradient(135deg,#10b981,#059669); box-shadow: 0 8px 24px rgba(16,185,129,0.45); }
        .icon-patient { background: linear-gradient(135deg,#3b82f6,#2563eb); box-shadow: 0 8px 24px rgba(59,130,246,0.45); }
        .icon-hr      { background: linear-gradient(135deg,#a855f7,#8b5cf6); box-shadow: 0 8px 24px rgba(168,85,247,0.45); }

        .role-icon svg { width: 26px; height: 26px; }

        .role-name {
            font-size: 0.9rem; font-weight: 600;
            color: rgba(255,255,255,0.9);
            position: relative; z-index: 1;
        }
        .role-desc {
            font-size: 0.71rem; color: rgba(255,255,255,0.35);
            text-align: center; line-height: 1.4;
            position: relative; z-index: 1;
        }

        /* ─── Buttons ─── */
        .actions-row { display: flex; flex-direction: column; gap: 0.875rem; margin-top: 1.5rem; }

        .btn-action {
            display: flex; align-items: center; justify-content: center;
            gap: 0.625rem; width: 100%;
            padding: 0.9rem 1.5rem;
            border-radius: 12px; font-size: 0.9rem; font-weight: 600;
            text-decoration: none;
            transition: all 0.25s cubic-bezier(0.4,0,0.2,1);
            cursor: pointer; border: none;
            letter-spacing: 0.01em;
        }
        .btn-register {
            background: rgba(59,130,246,0.1);
            color: rgba(255,255,255,0.85);
            border: 1.5px solid rgba(59,130,246,0.25);
        }
        .btn-register:hover {
            background: rgba(59,130,246,0.18);
            border-color: rgba(59,130,246,0.5);
            color: white; transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(59,130,246,0.2);
        }
        .btn-icon { width: 18px; height: 18px; flex-shrink: 0; }

        /* ─── Patients-only badge ─── */
        .patient-badge {
            display: inline-flex; align-items: center; gap: 0.3rem;
            padding: 0.2rem 0.55rem;
            border-radius: 100px; font-size: 0.63rem; font-weight: 600;
            letter-spacing: 0.06em; text-transform: uppercase;
            background: rgba(59,130,246,0.15); color: #93c5fd;
            border: 1px solid rgba(59,130,246,0.25);
        }

        /* ─── Footer ─── */
        .page-footer {
            margin-top: 1.75rem; text-align: center;
            font-size: 0.74rem; color: rgba(255,255,255,0.2);
        }
        .page-footer a {
            color: rgba(255,255,255,0.35); text-decoration: none;
            transition: color 0.2s;
        }
        .page-footer a:hover { color: rgba(255,255,255,0.65); }

        /* ─── Responsive ─── */
        @media (max-width: 580px) {
            .glass-card { padding: 1.75rem 1.125rem; border-radius: 20px; }
            .roles-grid { grid-template-columns: repeat(2, 1fr); }
            .brand-title { font-size: 1.4rem; }
        }
    </style>
</head>
<body>

    <!-- Background -->
    <div class="bg-orbs">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
    </div>
    <div class="grid-overlay"></div>

    <div class="page-wrapper">
        <div class="glass-card">

            <!-- ── Language Switcher Header ── -->
            <div style="display: flex; justify-content: flex-end; width: 100%; margin-bottom: 1rem;">
                <x-language-switcher variant="glass" />
            </div>

            <!-- ── Brand Header ── -->
            <div class="brand-header">
                <div class="brand-logo">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19 3H5C3.9 3 3 3.9 3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-4 8h-2v2c0 .55-.45 1-1 1s-1-.45-1-1v-2H9c-.55 0-1-.45-1-1s.45-1 1-1h2V7c0-.55.45-1 1-1s1 .45 1 1v2h2c.55 0 1 .45 1 1s-.45 1-1 1z"/>
                    </svg>
                </div>
                <h1 class="brand-title">{{ config('app.name', 'Hospital System') }}</h1>
                <p class="brand-subtitle">{{ app()->getLocale() == 'ar' ? 'اختر بوابتك لتسجيل الدخول والمتابعة' : __('Select your role to continue') }}</p>
            </div>

            <!-- ── Roles ── -->
            <p class="section-label">{{ app()->getLocale() == 'ar' ? 'اختر البوابة' : __('I am a...') }}</p>
            <div class="roles-grid">

                <!-- Admin -->
                <a href="{{ route('login', ['role' => 'admin']) }}" class="role-card role-admin" id="role-card-admin">
                    <div class="role-icon icon-admin">
                        <svg viewBox="0 0 24 24" fill="white" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5L12 1zm0 6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2zm4 10H8v-1c0-1.33 2.67-2 4-2s4 .67 4 2v1z"/>
                        </svg>
                    </div>
                    <span class="role-name">{{ app()->getLocale() == 'ar' ? 'مدير النظام' : 'Admin' }}</span>
                    <span class="role-desc">{{ app()->getLocale() == 'ar' ? 'لوحة تحكم وإدارة ومراقبة النظام' : 'System management & control' }}</span>
                </a>

                <!-- Doctor -->
                <a href="{{ route('login', ['role' => 'doctor']) }}" class="role-card role-doctor" id="role-card-doctor">
                    <div class="role-icon icon-doctor">
                        <svg viewBox="0 0 24 24" fill="white" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2C9.24 2 7 4.24 7 7s2.24 5 5 5 5-2.24 5-5-2.24-5-5-5zm0 12c-5.33 0-8 2.67-8 4v1h16v-1c0-1.33-2.67-4-8-4z"/>
                            <rect x="17" y="9" width="2" height="6" rx="1" fill="rgba(255,255,255,0.85)"/>
                            <rect x="15" y="11" width="6" height="2" rx="1" fill="rgba(255,255,255,0.85)"/>
                        </svg>
                    </div>
                    <span class="role-name">{{ app()->getLocale() == 'ar' ? 'طبيب' : 'Doctor' }}</span>
                    <span class="role-desc">{{ app()->getLocale() == 'ar' ? 'العيادات والمواعيد وجدول الكشوفات' : 'Medical staff & professionals' }}</span>
                </a>

                <!-- Patient -->
                <a href="{{ route('login', ['role' => 'patient']) }}" class="role-card role-patient" id="role-card-patient">
                    <div class="role-icon icon-patient">
                        <svg viewBox="0 0 24 24" fill="white" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2C9.24 2 7 4.24 7 7s2.24 5 5 5 5-2.24 5-5-2.24-5-5-5zm0 12c-5.33 0-8 2.67-8 4v1h16v-1c0-1.33-2.67-4-8-4z"/>
                        </svg>
                    </div>
                    <span class="role-name">{{ app()->getLocale() == 'ar' ? 'مريض' : 'Patient' }}</span>
                    <span class="role-desc">{{ app()->getLocale() == 'ar' ? 'الملف الطبي والمواعيد والكشوفات' : 'View health records & appointments' }}</span>
                </a>

                <!-- HR -->
                <a href="{{ route('login', ['role' => 'hr']) }}" class="role-card role-hr" id="role-card-hr">
                    <div class="role-icon icon-hr">
                        <svg viewBox="0 0 24 24" fill="white" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V18h14v-1.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V18h6v-1.5c0-2.33-4.67-3.5-7-3.5z"/>
                        </svg>
                    </div>
                    <span class="role-name">{{ app()->getLocale() == 'ar' ? 'الموارد البشرية' : 'HR Staff' }}</span>
                    <span class="role-desc">{{ app()->getLocale() == 'ar' ? 'شؤون الموظفين والاستقبال والعمليات' : 'Human resources & reception' }}</span>
                </a>

            </div>


            <!-- ── Action Buttons ── -->
            <div class="actions-row">

                {{-- Register – patients only --}}
                @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn-action btn-register" id="btn-register-patient">
                    <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <line x1="19" y1="8" x2="19" y2="14"/>
                        <line x1="22" y1="11" x2="16" y2="11"/>
                    </svg>
                    {{ app()->getLocale() == 'ar' ? 'إنشاء حساب جديد للمرضى' : __('Create Account') }}
                    <span class="patient-badge">
                        <svg width="7" height="7" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="7" r="4"/><path d="M12 14c-7 0-7 3.5-7 3.5V21h14v-3.5S19 14 12 14z"/></svg>
                        {{ app()->getLocale() == 'ar' ? 'خاص بالمرضى' : 'Patients Only' }}
                    </span>
                </a>
                @endif

            </div>

        </div>

        <!-- Page footer -->
        <div class="page-footer">
            <a href="{{ route('home') }}">&larr; {{ app()->getLocale() == 'ar' ? 'العودة للصفحة الرئيسية' : 'Back to Home' }}</a>
            &nbsp;&middot;&nbsp;
            {{ config('app.name') }} &copy; {{ date('Y') }}
        </div>
    </div>

    @fluxScripts
</body>
</html>
