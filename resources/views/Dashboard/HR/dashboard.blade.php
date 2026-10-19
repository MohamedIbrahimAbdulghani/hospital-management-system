@extends('Dashboard.layouts.master')

@section('title', __('لوحة تحكم الموارد البشرية والاستقبال - المستشفى'))

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">{{ __('لوحة التحكم') }}</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('الموارد البشرية وشؤون المرضى (HR)') }}</span>
        </div>
    </div>
    <div class="d-flex my-xl-auto right-content">
        <div class="mb-3 mb-xl-0">
            <span class="btn btn-outline-info btn-sm">
                <i class="fas fa-user-tie ml-1"></i> {{ Auth::user()->name }}
            </span>
        </div>
    </div>
</div>
@endsection

@section('content')
<!-- Row: HR Overview Cards -->
<div class="row row-sm">
    <div class="col-xl-4 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-primary-gradient shadow-sm">
            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="mb-3 tx-14 text-white font-weight-bold">{{ __('الأطباء المسجلين') }}</h6>
                    <i class="fas fa-user-md text-white-50 tx-24"></i>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <div>
                            <h4 class="tx-22 font-weight-bold mb-1 text-white">{{ $stats['doctors_count'] }}</h4>
                            <p class="mb-0 tx-12 text-white op-7">{{ __('متابعة الدوام والعقود والعيادات') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-danger-gradient shadow-sm">
            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="mb-3 tx-14 text-white font-weight-bold">{{ __('سجلات المرضى') }}</h6>
                    <i class="fas fa-users text-white-50 tx-24"></i>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <div>
                            <h4 class="tx-22 font-weight-bold mb-1 text-white">{{ $stats['patients_count'] }}</h4>
                            <p class="mb-0 tx-12 text-white op-7">{{ __('ملفات المرضى والتأمين الطبي') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-warning-gradient shadow-sm">
            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="mb-3 tx-14 text-white font-weight-bold">{{ __('فريق الموارد البشرية') }}</h6>
                    <i class="fas fa-id-card-alt text-white-50 tx-24"></i>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <div>
                            <h4 class="tx-22 font-weight-bold mb-1 text-white">{{ $stats['hr_staff_count'] }}</h4>
                            <p class="mb-0 tx-12 text-white op-7">{{ __('طاقم الاستقبال والإدارة') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Row: HR Main Modules -->
<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <h4 class="card-title mg-b-0">{{ __('مهام الاستقبال وشؤون المستشفى') }}</h4>
                <p class="tx-12 text-muted mb-2">{{ __('تسجيل المرضى، حجز المواعيد، الفواتير، وإنشاء حسابات الطاقم الطبي') }}</p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="p-4 border rounded text-center">
                            <i class="fas fa-calendar-plus tx-30 text-primary mb-2"></i>
                            <h6 class="font-weight-bold">{{ __('حجز موعد مريض') }}</h6>
                            <p class="tx-12 text-muted">{{ __('تسجيل كشف جديد لمريض لدى أحد أطباء المستشفى') }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="p-4 border rounded text-center">
                            <i class="fas fa-user-plus tx-30 text-success mb-2"></i>
                            <h6 class="font-weight-bold">{{ __('فتح ملف مريض جديد') }}</h6>
                            <p class="tx-12 text-muted">{{ __('تسجيل مريض جديد بالرقم القومي وبيانات التأمين') }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="p-4 border rounded text-center">
                            <i class="fas fa-file-invoice-dollar tx-30 text-warning mb-2"></i>
                            <h6 class="font-weight-bold">{{ __('الفواتير والدفع') }}</h6>
                            <p class="tx-12 text-muted">{{ __('إصدار فواتير الكشوفات والتحصيل نقداً أو بالفيزا') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
