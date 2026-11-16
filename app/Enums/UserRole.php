<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case DOCTOR = 'doctor';
    case HR = 'hr';
    case PATIENT = 'patient';

    /**
     * Get a human-readable translated label for the role.
     */
    public function label(): string
    {
        return match ($this) {
            self::ADMIN => __('Admin'),
            self::DOCTOR => __('Doctor'),
            self::HR => __('HR Staff'),
            self::PATIENT => __('Patient'),
        };
    }

    /**
     * Get all raw string values of the roles.
     *
     * @return array<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
