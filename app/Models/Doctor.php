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
        'license_number',
        'title',
        'bio',
        'experience_years',
        'consultation_fee',
        'rating',
        'is_available',
        'appointments_per_day',
    ];

    protected function casts(): array
    {
        return [
            'is_available' => 'boolean',
            'consultation_fee' => 'decimal:2',
            'rating' => 'decimal:2',
            'experience_years' => 'integer',
            'appointments_per_day' => 'integer',
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
}
