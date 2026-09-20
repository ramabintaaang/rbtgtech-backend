<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PageView;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    /**
     * Record visitor page view hit from Astro frontend with Visitor Cookie & Deduplication.
     */
    public function track(Request $request)
    {
        $validated = $request->validate([
            'path' => 'required|string|max:500',
            'title' => 'nullable|string|max:255',
            'referrer' => 'nullable|string|max:500',
            'visitor_id' => 'nullable|string|max:100',
        ]);

        $ip = $request->ip();
        $path = $validated['path'];
        $visitorId = $validated['visitor_id'] ?? null;

        // 1. DEDUPLICATION SAFEGUARD:
        // Prevent counting repeated page refreshes from same Visitor Cookie OR IP within 5 minutes.
        $recentHitQuery = PageView::where('path', $path)
            ->where('viewed_at', '>=', now()->subMinutes(5));

        if ($visitorId) {
            $recentHitQuery->where(function ($q) use ($visitorId, $ip) {
                $q->where('visitor_id', $visitorId)
                  ->orWhere('ip_address', $ip);
            });
        } else {
            $recentHitQuery->where('ip_address', $ip);
        }

        if ($recentHitQuery->exists()) {
            return response()->json([
                'status' => 'skipped',
                'message' => 'Hit debounced: recent visit recorded within 5 minutes'
            ], 200);
        }

        $userAgent = $request->header('User-Agent');
        $deviceType = PageView::parseDeviceType($userAgent);

        $pageView = PageView::create([
            'ip_address' => $ip,
            'visitor_id' => $visitorId,
            'path' => $path,
            'title' => $validated['title'] ?? '',
            'referrer' => $validated['referrer'] ?? 'Direct Traffic',
            'device_type' => $deviceType,
            'user_agent' => substr($userAgent ?? '', 0, 500),
            'viewed_at' => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Telemetry tracked with visitor fingerprint',
            'data' => $pageView
        ], 201);
    }
}
