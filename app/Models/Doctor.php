<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model implements TranslatableContract
{
    use HasFactory, SoftDeletes, Translatable;

    /**
     * The attributes that are translatable via Astrotomic.
     *
     * @var array<int, string>
     */
    public array $translatedAttributes = [
        'name',
        'title',
        'bio',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'section_id',
        'license_number',
        'experience_years',
        'consultation_fee',
        'rating',
        'is_available',
        'appointments_per_day',
        'sort_order',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
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
     * Section relation
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    /**
     * Localized Doctor full name with fallback to linked user name.
     */
    public function getNameAttribute(): string
    {
        $translated = $this->getTranslation()?->name;
        if (!empty($translated)) {
            return $translated;
        }

        return $this->user?->name ?? __('messages.doctor');
    }

    /**
     * Doctor avatar with reliable fallback.
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
     * Localized Section Name
     */
    public function getSectionNameAttribute(): string
    {
        return $this->section?->name ?? '';
    }
}
