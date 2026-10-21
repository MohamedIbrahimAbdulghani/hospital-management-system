@extends('Dashboard.layouts.master')

@section('title', app()->getLocale() === 'ar' ? 'إعدادات أرقام الطوارئ والموقع' : 'Site Contact & Emergency Settings')

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">{{ app()->getLocale() === 'ar' ? 'الإعدادات' : 'Settings' }}</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ app()->getLocale() === 'ar' ? 'أرقام الطوارئ والاتصال' : 'Emergency & Contact Numbers' }}</span>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row row-sm">
    <div class="col-lg-8 col-xl-8 col-md-12 col-sm-12">
        <div class="card box-shadow-0">
            <div class="card-header border-bottom">
                <h4 class="card-title mb-1">
                    <i class="fas fa-phone-volume text-danger ml-1 mr-1"></i>
                    {{ app()->getLocale() === 'ar' ? 'إعدادات أرقام الطوارئ والخط الساخن للشريط العلوي' : 'Public Header Emergency & Hotline Settings' }}
                </h4>
                <p class="mb-0 text-muted tx-13">
                    {{ app()->getLocale() === 'ar'
                        ? 'تُعرض هذه الأرقام مباشرة في الشريط العلوي الثابت للصفحات العامة وفي ترويسة الموقع لتمكين المرضى والزوار من الاتصال الفوري.'
                        : 'These numbers appear directly in the public sticky header utility bar for instant click-to-call.' }}
                </p>
            </div>
            <div class="card-body pt-3">

                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle ml-1 mr-1"></i>
                        {{ session('status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 pr-3 pl-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.settings.update') }}">
                    @csrf

                    <div class="form-group">
                        <label class="form-label font-weight-bold text-danger">
                            <i class="fas fa-ambulance ml-1 mr-1"></i>
                            {{ app()->getLocale() === 'ar' ? 'رقم الطوارئ (24/7 Emergency Phone)' : 'Emergency Phone (24/7)' }}
                            <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            name="emergency_phone"
                            class="form-control @error('emergency_phone') is-invalid @enderror"
                            value="{{ old('emergency_phone', $settings['emergency_phone']) }}"
                            placeholder="19999"
                            required
                        >
                        <small class="text-muted">
                            {{ app()->getLocale() === 'ar'
                                ? 'يظهر في الشريط العلوي بنقطة نابضة مميزة ورابط tel: مباشر.'
                                : 'Displayed with a pulsing dot and clickable tel: link in the sticky utility bar.' }}
                        </small>
                    </div>

                    <div class="form-group">
                        <label class="form-label font-weight-bold text-primary">
                            <i class="fas fa-headset ml-1 mr-1"></i>
                            {{ app()->getLocale() === 'ar' ? 'الخط الساخن والاستعلامات (Hotline Phone)' : 'Hotline Phone' }}
                            <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            name="hotline_phone"
                            class="form-control @error('hotline_phone') is-invalid @enderror"
                            value="{{ old('hotline_phone', $settings['hotline_phone']) }}"
                            placeholder="16000"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-envelope ml-1 mr-1 text-info"></i>
                            {{ app()->getLocale() === 'ar' ? 'البريد الإلكتروني للدعم' : 'Support Email' }}
                        </label>
                        <input
                            type="email"
                            name="hospital_email"
                            class="form-control @error('hospital_email') is-invalid @enderror"
                            value="{{ old('hospital_email', $settings['hospital_email']) }}"
                            placeholder="support@hospital.com"
                        >
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="form-label">
                                {{ app()->getLocale() === 'ar' ? 'عنوان المستشفى (عربي)' : 'Address (Arabic)' }}
                            </label>
                            <input
                                type="text"
                                name="hospital_address_ar"
                                class="form-control"
                                value="{{ old('hospital_address_ar', $settings['hospital_address_ar']) }}"
                            >
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label">
                                {{ app()->getLocale() === 'ar' ? 'عنوان المستشفى (إنجليزي)' : 'Address (English)' }}
                            </label>
                            <input
                                type="text"
                                name="hospital_address_en"
                                class="form-control"
                                value="{{ old('hospital_address_en', $settings['hospital_address_en']) }}"
                            >
                        </div>
                    </div>

                    <div class="form-group mb-0 mt-3 justify-content-end">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save ml-1 mr-1"></i>
                            {{ app()->getLocale() === 'ar' ? 'حفظ التعديلات' : 'Save Changes' }}
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
