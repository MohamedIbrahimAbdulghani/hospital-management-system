<?php

namespace App\Enums;

enum Permission: string
{
    // Admin & System
    case ACCESS_ADMIN_DASHBOARD = 'admin.dashboard.access';
    case MANAGE_USERS = 'users.manage';
    case MANAGE_ROLES_PERMISSIONS = 'roles.manage';
    case MANAGE_SECTIONS = 'sections.manage';
    case VIEW_SYSTEM_LOGS = 'system_logs.view';

    // Doctor Management & Schedule
    case ACCESS_DOCTOR_DASHBOARD = 'doctor.dashboard.access';
    case MANAGE_DOCTORS = 'doctors.manage';
    case VIEW_DOCTOR_SCHEDULE = 'doctors.schedule.view';
    case MANAGE_DOCTOR_SCHEDULE = 'doctors.schedule.manage';

    // Patient Management
    case ACCESS_PATIENT_DASHBOARD = 'patient.dashboard.access';
    case MANAGE_PATIENTS = 'patients.manage';
    case VIEW_PATIENTS = 'patients.view';

    // HR Management
    case ACCESS_HR_DASHBOARD = 'hr.dashboard.access';
    case MANAGE_HR_STAFF = 'hr_staff.manage';

    // Appointments
    case VIEW_APPOINTMENTS = 'appointments.view';
    case BOOK_APPOINTMENTS = 'appointments.book';
    case RESCHEDULE_APPOINTMENTS = 'appointments.reschedule';
    case CANCEL_APPOINTMENTS = 'appointments.cancel';

    // Medical Records
    case VIEW_MEDICAL_RECORDS = 'medical_records.view';
    case CREATE_MEDICAL_RECORDS = 'medical_records.create';
    case EDIT_MEDICAL_RECORDS = 'medical_records.edit';
    case DOWNLOAD_MEDICAL_REPORTS = 'medical_records.download';

    // Invoices & Payments
    case MANAGE_INVOICES = 'invoices.manage';
    case VIEW_INVOICES = 'invoices.view';
    case PROCESS_PAYMENTS = 'payments.process';

    // Communication
    case CHAT_DIRECT = 'chat.direct';

    /**
     * Get all permission values.
     *
     * @return array<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
