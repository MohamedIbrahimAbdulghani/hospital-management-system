@extends('Dashboard.layouts.master')

@section('title', __('بوابة الطبيب - المستشفى'))

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">{{ __('لوحة تحكم الطبيب') }}</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ د. {{ Auth::user()->name }}</span>
        </div>
    </div>
    <div class="d-flex my-xl-auto right-content">
        <div class="mb-3 mb-xl-0">
            <span class="btn btn-outline-success btn-sm">
                <i class="fas fa-circle text-success ml-1"></i> {{ __('العيادة نشطة ومتاحة للحجز') }}
            </span>
        </div>
    </div>
</div>
@endsection

@section('content')
<!-- Row: Doctor Overview Cards -->
<div class="row row-sm">
    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-primary-gradient shadow-sm">
            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="mb-3 tx-14 text-white font-weight-bold">{{ __('مواعيد اليوم') }}</h6>
                    <i class="fas fa-calendar-check text-white-50 tx-24"></i>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <div>
                            <h4 class="tx-22 font-weight-bold mb-1 text-white">0</h4>
                            <p class="mb-0 tx-12 text-white op-7">{{ __('كشف مجدول اليوم') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-success-gradient shadow-sm">
            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="mb-3 tx-14 text-white font-weight-bold">{{ __('الكشوفات المكتملة') }}</h6>
                    <i class="fas fa-clipboard-check text-white-50 tx-24"></i>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <div>
                            <h4 class="tx-22 font-weight-bold mb-1 text-white">0</h4>
                            <p class="mb-0 tx-12 text-white op-7">{{ __('تمت كتابة الروشتة والتقرير') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-info-gradient shadow-sm">
            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="mb-3 tx-14 text-white font-weight-bold">{{ __('التقييم العام') }}</h6>
                    <i class="fas fa-star text-white-50 tx-24"></i>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <div>
                            <h4 class="tx-22 font-weight-bold mb-1 text-white">5.0 / 5.0</h4>
                            <p class="mb-0 tx-12 text-white op-7">{{ __('تقييم المرضى للعيادة') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-purple-gradient shadow-sm">
            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="mb-3 tx-14 text-white font-weight-bold">{{ __('سعر الكشف') }}</h6>
                    <i class="fas fa-money-bill-wave text-white-50 tx-24"></i>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <div>
                            <h4 class="tx-22 font-weight-bold mb-1 text-white">{{ $doctor?->consultation_fee ?? 0 }} ج.م</h4>
                            <p class="mb-0 tx-12 text-white op-7">{{ $doctor?->specialization?->name ?? __('عام') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Row: Doctor Appointments Schedule -->
<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title mg-b-0">{{ __('جدول كشوفات اليوم') }}</h4>
                </div>
                <p class="tx-12 text-muted mb-2">{{ __('قائمة المرضى المنتظرين في العيادة للكشف الطبي') }}</p>
            </div>
            <div class="card-body">
                <div class="text-center py-5">
                    <i class="fas fa-notes-medical tx-50 text-muted mb-3"></i>
                    <h5 class="text-muted">{{ __('لا توجد مواعيد مجدولة لهذا اليوم حتى الآن') }}</h5>
                    <p class="tx-13 text-muted">{{ __('سيتم إدراج أي كشف جديد يحدده الاستقبال أو يحجزه المريض هنا تلقائياً') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
