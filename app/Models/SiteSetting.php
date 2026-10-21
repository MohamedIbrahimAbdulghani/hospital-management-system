<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    use HasFactory;

    protected $table = 'site_settings';

    protected $fillable = [
        'key',
        'value',
        'group',
    ];

    /**
     * Cache key for site settings.
     */
    public const CACHE_KEY = 'site_settings_all';

    /**
     * Retrieve a setting value by key with optional fallback.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $settings = Cache::rememberForever(self::CACHE_KEY, function () {
            try {
                return static::all()->pluck('value', 'key')->toArray();
            } catch (\Throwable $e) {
                return [];
            }
        });

        return $settings[$key] ?? $default;
    }

    /**
     * Set or update a setting value by key and invalidate cache.
     */
    public static function set(string $key, mixed $value, string $group = 'general'): self
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group]
        );

        Cache::forget(self::CACHE_KEY);

        return $setting;
    }

    /**
     * Invalidate cached settings.
     */
    public static function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
