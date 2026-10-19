@extends('Dashboard.layouts.master')

@section('title', __('لوحة تحكم مدير النظام - المستشفى'))

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">{{ __('لوحة التحكم') }}</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('مدير النظام (Admin)') }}</span>
        </div>
    </div>
    <div class="d-flex my-xl-auto right-content">
        <div class="mb-3 mb-xl-0">
            <span class="btn btn-outline-primary btn-sm">
                <i class="fas fa-calendar-alt ml-1"></i> {{ now()->translatedFormat('l، d F Y') }}
            </span>
        </div>
    </div>
</div>
@endsection

@section('content')
<!-- Row: Statistics Cards -->
<div class="row row-sm">
    <!-- Doctors Card -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-primary-gradient shadow-sm">
            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="mb-3 tx-14 text-white font-weight-bold">{{ __('إجمالي الأطباء') }}</h6>
                    <i class="fas fa-user-md text-white-50 tx-24"></i>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <div>
                            <h4 class="tx-22 font-weight-bold mb-1 text-white">{{ $stats['doctors_count'] }}</h4>
                            <p class="mb-0 tx-12 text-white op-7">{{ __('طبيب مسجل في النظام') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Patients Card -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-danger-gradient shadow-sm">
            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="mb-3 tx-14 text-white font-weight-bold">{{ __('إجمالي المرضى') }}</h6>
                    <i class="fas fa-procedures text-white-50 tx-24"></i>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <div>
                            <h4 class="tx-22 font-weight-bold mb-1 text-white">{{ $stats['patients_count'] }}</h4>
                            <p class="mb-0 tx-12 text-white op-7">{{ __('ملف مريض نشط') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Specializations Card -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-success-gradient shadow-sm">
            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="mb-3 tx-14 text-white font-weight-bold">{{ __('الأقسام والتخصصات') }}</h6>
                    <i class="fas fa-stethoscope text-white-50 tx-24"></i>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <div>
                            <h4 class="tx-22 font-weight-bold mb-1 text-white">{{ $stats['specializations_count'] }}</h4>
                            <p class="mb-0 tx-12 text-white op-7">{{ __('تخصص طبي متاح') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Staff Card -->
    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-warning-gradient shadow-sm">
            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="mb-3 tx-14 text-white font-weight-bold">{{ __('طاقم الإدارة والـ HR') }}</h6>
                    <i class="fas fa-id-badge text-white-50 tx-24"></i>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <div>
                            <h4 class="tx-22 font-weight-bold mb-1 text-white">{{ $stats['staff_count'] }}</h4>
                            <p class="mb-0 tx-12 text-white op-7">{{ __('موظف ومسؤول') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Row: Quick Actions & Management Shortcuts -->
<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0">{{ __('الإجراءات الإدارية السريعة') }}</h4>
                </div>
                <p class="tx-12 text-muted mb-2">{{ __('إدارة حسابات المستشفى، الأطباء، والموظفين') }}</p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="p-3 border rounded text-center hover:bg-light transition">
                            <i class="fas fa-user-plus tx-30 text-primary mb-2"></i>
                            <h6 class="font-weight-bold">{{ __('إضافة طبيب جديد') }}</h6>
                            <p class="tx-12 text-muted">{{ __('إنشاء حساب طبيب وتعيين التخصص والعيادة') }}</p>
                            <span class="badge badge-primary">{{ __('لوحة الإدارة') }}</span>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="p-3 border rounded text-center hover:bg-light transition">
                            <i class="fas fa-users-cog tx-30 text-info mb-2"></i>
                            <h6 class="font-weight-bold">{{ __('إضافة موظف HR') }}</h6>
                            <p class="tx-12 text-muted">{{ __('إنشاء حساب موارد بشرية بكلمة مرور مؤقتة') }}</p>
                            <span class="badge badge-info">{{ __('لوحة الإدارة') }}</span>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="p-3 border rounded text-center hover:bg-light transition">
                            <i class="fas fa-shield-alt tx-30 text-warning mb-2"></i>
                            <h6 class="font-weight-bold">{{ __('الأدوار والصلاحيات') }}</h6>
                            <p class="tx-12 text-muted">{{ __('إدارة أذونات Spatie وتخصيص الصلاحيات') }}</p>
                            <span class="badge badge-warning">{{ __('Spatie RBAC') }}</span>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="p-3 border rounded text-center hover:bg-light transition">
                            <i class="fas fa-hospital tx-30 text-success mb-2"></i>
                            <h6 class="font-weight-bold">{{ __('الأقسام الطبية') }}</h6>
                            <p class="tx-12 text-muted">{{ __('إدارة وتحديث التخصصات والعيادات') }}</p>
                            <span class="badge badge-success">{{ __('التخصصات') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
