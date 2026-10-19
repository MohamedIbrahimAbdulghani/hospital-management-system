@extends('Dashboard.layouts.master')

@section('title', __('بوابة المريض - المستشفى'))

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">{{ __('بوابة المريض') }}</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('أهلاً بك') }}، {{ Auth::user()->name }}</span>
        </div>
    </div>
    <div class="d-flex my-xl-auto right-content">
        <div class="mb-3 mb-xl-0">
            <span class="btn btn-outline-primary btn-sm">
                <i class="fas fa-heartbeat text-danger ml-1"></i> {{ __('ملفك الطبي نشط') }}
            </span>
        </div>
    </div>
</div>
@endsection

@section('content')
<!-- Row: Patient Statistics -->
<div class="row row-sm">
    <div class="col-xl-4 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-primary-gradient shadow-sm">
            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="mb-3 tx-14 text-white font-weight-bold">{{ __('المواعيد القادمة') }}</h6>
                    <i class="fas fa-calendar-check text-white-50 tx-24"></i>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <div>
                            <h4 class="tx-22 font-weight-bold mb-1 text-white">0</h4>
                            <p class="mb-0 tx-12 text-white op-7">{{ __('مواعيد كشف مسجلة') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-success-gradient shadow-sm">
            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="mb-3 tx-14 text-white font-weight-bold">{{ __('الروشتات والتقارير الطبية') }}</h6>
                    <i class="fas fa-file-medical text-white-50 tx-24"></i>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <div>
                            <h4 class="tx-22 font-weight-bold mb-1 text-white">0</h4>
                            <p class="mb-0 tx-12 text-white op-7">{{ __('روشتة وفحص طبي متاح للتحميل') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-info-gradient shadow-sm">
            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="mb-3 tx-14 text-white font-weight-bold">{{ __('الفواتير والمدفوعات') }}</h6>
                    <i class="fas fa-receipt text-white-50 tx-24"></i>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <div>
                            <h4 class="tx-22 font-weight-bold mb-1 text-white">0.00 ج.م</h4>
                            <p class="mb-0 tx-12 text-white op-7">{{ __('جميع الفواتير مسددة') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Row: Quick Patient Actions -->
<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <h4 class="card-title mg-b-0">{{ __('الخدمات المتاحة لك') }}</h4>
                <p class="tx-12 text-muted mb-2">{{ __('احجز كشفك الطبي، استعرض تاريخك الصحي، وتواصل مع أطبائك') }}</p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="p-4 border rounded text-center">
                            <i class="fas fa-calendar-alt tx-30 text-primary mb-2"></i>
                            <h6 class="font-weight-bold">{{ __('حجز كشف جديد') }}</h6>
                            <p class="tx-12 text-muted">{{ __('اختر التخصص، الطبيب المناسب، والميعاد الملائم لك') }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="p-4 border rounded text-center">
                            <i class="fas fa-file-pdf tx-30 text-danger mb-2"></i>
                            <h6 class="font-weight-bold">{{ __('تحميل الروشتات (PDF)') }}</h6>
                            <p class="tx-12 text-muted">{{ __('استعراض وتحميل الوصفات الطبية المعتمدة إلكترونياً') }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="p-4 border rounded text-center">
                            <i class="fas fa-comments tx-30 text-success mb-2"></i>
                            <h6 class="font-weight-bold">{{ __('استشارة الطبيب المباشرة') }}</h6>
                            <p class="tx-12 text-muted">{{ __('شات فوري مع طبيبك المعالج بعد الكشف') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
