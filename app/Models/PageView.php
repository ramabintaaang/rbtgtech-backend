<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;

class PageView extends Model
{
    use HasFactory, Prunable;

    protected $fillable = [
        'ip_address',
        'visitor_id',
        'path',
        'title',
        'referrer',
        'device_type',
        'user_agent',
        'viewed_at',
    ];

    protected $casts = [
        'viewed_at' => 'datetime',
    ];

    /**
     * Automatic Database Pruning Rule:
     * Deletes raw page view logs older than 90 days to keep the DB lightweight & fast.
     */
    public function prunable()
    {
        return static::where('viewed_at', '<', now()->subDays(90));
    }

    /**
     * Helper to detect device type from User-Agent string
     */
    public static function parseDeviceType(?string $userAgent): string
    {
        if (!$userAgent) return 'desktop';
        
        $ua = strtolower($userAgent);
        if (str_contains($ua, 'ipad') || str_contains($ua, 'tablet') || str_contains($ua, 'playbook')) {
            return 'tablet';
        }
        if (str_contains($ua, 'mobile') || str_contains($ua, 'iphone') || str_contains($ua, 'android')) {
            return 'mobile';
        }
        return 'desktop';
    }
}
