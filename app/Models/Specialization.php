<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Specialization extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'icon',
        'description',
        'description_en',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Get name according to current application locale
     */
    public function getNameAttribute(): string
    {
        return app()->getLocale() === 'ar' ? $this->name_ar : ($this->name_en ?: $this->name_ar);
    }

    /**
     * Get description according to current application locale
     */
    public function getDescriptionAttribute(): string
    {
        if (app()->getLocale() === 'ar') {
            return $this->attributes['description'] ?? '';
        }

        return $this->description_en ?: ($this->attributes['description'] ?? '');
    }

    /**
     * Doctors with this specialization
     */
    public function doctors(): HasMany
    {
        return $this->hasMany(Doctor::class, 'specialization_id');
    }
}
