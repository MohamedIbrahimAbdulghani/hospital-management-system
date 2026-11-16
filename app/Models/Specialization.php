<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Specialization extends Model implements TranslatableContract
{
    use HasFactory, Translatable; // use Translatable to add transaltion methods

    /**
     * The attributes that are translatable via Astrotomic.
     *
     * @var array<int, string>
     */

    // To define which attributes needs to be transalte
    public array $translatedAttributes = [
        'name',
        'description',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'icon',
        'sort_order',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Doctors associated with this specialization.
     */
    public function doctors(): HasMany
    {
        return $this->hasMany(Doctor::class, 'specialization_id');
    }
}
