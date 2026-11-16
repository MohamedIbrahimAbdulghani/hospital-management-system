<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    /**
     * The attributes that are translatable via Astrotomic.
     *
     * @var array<int, string>
     */
    public array $translatedAttributes = ['name'];

    /**
     * Allow mass assignment for translatable arrays.
     *
     * @var array<string>
     */
    protected $guarded = [];

    /**
     * Doctors working in this section.
     */
    public function doctors(): HasMany
    {
        return $this->hasMany(Doctor::class, 'section_id');
    }
}
