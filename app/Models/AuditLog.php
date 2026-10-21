<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

class AuditLog extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'email',
        'ip_address',
        'user_agent',
        'action',
        'details',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'details' => 'array',
            'created_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Record an audit log entry conveniently.
     *
     * @param  string  $action
     * @param  string|null  $email
     * @param  int|null  $userId
     * @param  array<string, mixed>|null  $details
     * @param  Request|null  $request
     * @return static
     */
    public static function record(
        string $action,
        ?string $email = null,
        ?int $userId = null,
        ?array $details = null,
        ?Request $request = null
    ): self {
        $req = $request ?: request();

        return static::create([
            'user_id' => $userId ?: $req?->user()?->id,
            'email' => $email ?: $req?->user()?->email,
            'ip_address' => $req?->ip(),
            'user_agent' => $req ? substr((string) $req->userAgent(), 0, 500) : null,
            'action' => $action,
            'details' => $details,
            'created_at' => now(),
        ]);
    }
}
