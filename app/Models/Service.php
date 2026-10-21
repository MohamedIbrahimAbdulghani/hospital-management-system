<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_ar',
        'title_en',
        'description_ar',
        'description_en',
        'icon',
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
     * Get title according to current application locale.
     */
    public function getTitleAttribute(): string
    {
        return app()->getLocale() === 'ar'
            ? ($this->title_ar ?: ($this->title_en ?? ''))
            : ($this->title_en ?: ($this->title_ar ?? ''));
    }

    /**
     * Get description according to current application locale.
     */
    public function getDescriptionAttribute(): string
    {
        return app()->getLocale() === 'ar'
            ? ($this->description_ar ?: ($this->description_en ?? ''))
            : ($this->description_en ?: ($this->description_ar ?? ''));
    }
}
