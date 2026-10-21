<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'specialization_id',
        'name_en',
        'license_number',
        'title',
        'bio',
        'experience_years',
        'consultation_fee',
        'rating',
        'is_available',
        'appointments_per_day',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_available' => 'boolean',
            'consultation_fee' => 'decimal:2',
            'rating' => 'decimal:2',
            'experience_years' => 'integer',
            'appointments_per_day' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    /**
     * User account relation
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Specialization relation
     */
    public function specialization(): BelongsTo
    {
        return $this->belongsTo(Specialization::class, 'specialization_id');
    }

    /**
     * Doctor full name from linked user (supports bilingual name_en)
     */
    public function getNameAttribute(): string
    {
        if (app()->getLocale() === 'en' && !empty($this->attributes['name_en'])) {
            return $this->attributes['name_en'];
        }

        return $this->user?->name ?? __('messages.doctor');
    }

    /**
     * Doctor avatar with reliable fallback
     */
    public function getAvatarUrlAttribute(): string
    {
        $avatar = $this->user?->avatar;
        if ($avatar && file_exists(public_path($avatar))) {
            return asset($avatar);
        }

        // Clean SVG/UI avatar fallback
        $name = urlencode($this->user?->name ?? 'Doctor');
        return "https://ui-avatars.com/api/?name={$name}&background=1e40af&color=ffffff&size=256&bold=true";
    }

    /**
     * Localized Specialization Name
     */
    public function getSpecializationNameAttribute(): string
    {
        return $this->specialization?->name ?? '';
    }
}
