<!-- Title -->
<title>@yield('title', config('app.name', 'Hospital Management System'))</title>

<!-- Favicon -->
<link rel="icon" href="{{ URL::asset('Dashboard/img/brand/favicon.png') }}" type="image/x-icon"/>

<!-- Google Fonts (Cairo & Inter for crisp Arabic/English typography) -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    body, h1, h2, h3, h4, h5, h6, .main-sidebar, .main-header, button, input, select, textarea {
        font-family: 'Cairo', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
    }
</style>

<!-- Icons css -->
<link href="{{ URL::asset('Dashboard/css/icons.css') }}" rel="stylesheet">

<!-- Custom Scroll bar-->
<link href="{{ URL::asset('Dashboard/plugins/mscrollbar/jquery.mCustomScrollbar.css') }}" rel="stylesheet"/>

<!-- Sidebar css -->
<link href="{{ URL::asset('Dashboard/plugins/sidebar/sidebar.css') }}" rel="stylesheet">

@if (App::getLocale() == 'ar')
    <!-- Sidemenu css -->
    <link rel="stylesheet" href="{{ URL::asset('Dashboard/css-rtl/sidemenu.css') }}">
    <!--- Style css -->
    <link href="{{ URL::asset('Dashboard/css-rtl/style.css') }}" rel="stylesheet">
    <!--- Dark-mode css -->
    <link href="{{ URL::asset('Dashboard/css-rtl/style-dark.css') }}" rel="stylesheet">
    <!---Skinmodes css-->
    <link href="{{ URL::asset('Dashboard/css-rtl/skin-modes.css') }}" rel="stylesheet">
@else
    <!-- Sidemenu css -->
    <link rel="stylesheet" href="{{ URL::asset('Dashboard/css/sidemenu.css') }}">
    <!--- Style css -->
    <link href="{{ URL::asset('Dashboard/css/style.css') }}" rel="stylesheet">
    <!--- Dark-mode css -->
    <link href="{{ URL::asset('Dashboard/css/style-dark.css') }}" rel="stylesheet">
    <!---Skinmodes css-->
    <link href="{{ URL::asset('Dashboard/css/skin-modes.css') }}" rel="stylesheet">
@endif

@yield('css')
