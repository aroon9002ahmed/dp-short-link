<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Link extends Model
{
    protected $fillable = [
        'short_code',
        'original_url',
        'clicks',
        'is_active',
        'expires_at',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Link $link) {
            if (empty($link->short_code)) {
                $link->short_code = static::generateUniqueShortCode();
            }
            if (empty($link->created_by)) {
                $link->created_by = Auth::id();
            }
            $link->url_hash = hash('sha256', $link->original_url);
        });

        static::updating(function (Link $link) {
            if ($link->isDirty('original_url')) {
                $link->url_hash = hash('sha256', $link->original_url);
            }
        });
    }

    public static function generateUniqueShortCode(int $length = 6): string
    {
        do {
            $shortCode = \Illuminate\Support\Str::random($length);
        } while (static::where('short_code', $shortCode)->exists());

        return $shortCode;
    }

    public function creator(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }
}
