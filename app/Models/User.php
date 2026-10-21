<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $role
 * @property string|null $phone
 * @property string|null $avatar
 * @property bool $is_active
 * @property bool $must_change_password
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property Carbon|null $two_factor_confirmed_at
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasRoles, Notifiable, SoftDeletes, TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'avatar',
        'is_active',
        'must_change_password',
    ];

    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'must_change_password' => 'boolean',
        ];
    }

    /**
     * The "booted" method of the model.
     * Automatically keeps Spatie roles synchronized with the role column.
     */
    protected static function booted(): void
    {
        static::saved(function (User $user) {
            if (! empty($user->role)) {
                try {
                    if (! $user->hasRole($user->role)) {
                        $user->syncRoles([$user->role]);
                    }
                } catch (\Spatie\Permission\Exceptions\RoleDoesNotExist $e) {
                    \Spatie\Permission\Models\Role::firstOrCreate([
                        'name' => $user->role,
                        'guard_name' => 'web',
                    ]);
                    $user->syncRoles([$user->role]);
                }
            }
        });
    }

    /**
     * Profile relation for Patient
     */
    public function patient(): HasOne
    {
        return $this->hasOne(Patient::class, 'user_id');
    }

    /**
     * Profile relation for Doctor
     */
    public function doctor(): HasOne
    {
        return $this->hasOne(Doctor::class, 'user_id');
    }

    /**
     * Profile relation for HR Staff
     */
    public function hrStaff(): HasOne
    {
        return $this->hasOne(HrStaff::class, 'user_id');
    }

    /**
     * Audit logs for this user
     */
    public function auditLogs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AuditLog::class, 'user_id');
    }

    /**
     * Check if user is Admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin' || $this->hasRole('admin');
    }

    /**
     * Check if user is Doctor
     */
    public function isDoctor(): bool
    {
        return $this->role === 'doctor' || $this->hasRole('doctor');
    }

    /**
     * Check if user is Patient
     */
    public function isPatient(): bool
    {
        return $this->role === 'patient' || $this->hasRole('patient');
    }

    /**
     * Check if user is HR
     */
    public function isHr(): bool
    {
        return $this->role === 'hr' || $this->hasRole('hr');
    }

    /**
     * Scope for active users
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        $initials = Str::initials($this->name, true);

        return Str::length($initials) > 1
            ? Str::substr($initials, 0, 1).Str::substr($initials, -1)
            : $initials;
    }
}
