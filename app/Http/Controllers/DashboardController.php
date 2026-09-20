<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ContactInquiry;
use App\Models\PageView;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the main application dashboard with real-time analytics & incoming leads.
     */
    public function index()
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $now->copy()->subMonth()->endOfMonth();

        // 1. Total Page Views & Unique Visitors this month
        $currentMonthViews = PageView::where('viewed_at', '>=', $startOfMonth)->count();

        // Count unique visitors using persistent visitor_id cookie (or ip_address fallback)
        $uniqueVisitors = PageView::where('viewed_at', '>=', $startOfMonth)
            ->whereNotNull('visitor_id')
            ->distinct('visitor_id')
            ->count('visitor_id');

        if ($uniqueVisitors === 0) {
            $uniqueVisitors = PageView::where('viewed_at', '>=', $startOfMonth)
                ->distinct('ip_address')
                ->count('ip_address');
        }

        // 2. Growth calculation vs previous month
        $lastMonthViews = PageView::whereBetween('viewed_at', [$startOfLastMonth, $endOfLastMonth])->count();
        $viewsGrowth = $lastMonthViews > 0 
            ? round((($currentMonthViews - $lastMonthViews) / $lastMonthViews) * 100, 1)
            : 0;

        // 3. Top Pages (Most Visited)
        $topPages = PageView::select('path', 'title', DB::raw('count(*) as total_views'))
            ->groupBy('path', 'title')
            ->orderBy('total_views', 'desc')
            ->take(5)
            ->get();

        // 4. Device Breakdown percentages
        $totalViewsAll = max(1, PageView::count());
        $desktopViews = PageView::where('device_type', 'desktop')->count();
        $mobileViews = PageView::where('device_type', 'mobile')->count();
        $tabletViews = PageView::where('device_type', 'tablet')->count();

        $deviceStats = [
            'desktop_pct' => round(($desktopViews / $totalViewsAll) * 100),
            'mobile_pct' => round(($mobileViews / $totalViewsAll) * 100),
            'tablet_pct' => round(($tabletViews / $totalViewsAll) * 100),
        ];

        // 5. Daily Trend Dataset for Last 7 Days Chart
        $chartLabels = [];
        $chartData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $chartLabels[] = $date->format('d M');
            $chartData[] = PageView::whereDate('viewed_at', $date->toDateString())->count();
        }

        // 6. Content & Inquiries Counters
        $publishedArticlesCount = Article::where('status', 'published')->count();
        $publishedPortfolioCount = Portfolio::where('status', 'published')->count();
        $recentInquiries = ContactInquiry::orderBy('created_at', 'desc')->take(4)->get();
        $unreadInquiriesCount = ContactInquiry::where('status', 'new')->count();

        return view('dashboard', compact(
            'currentMonthViews',
            'uniqueVisitors',
            'viewsGrowth',
            'topPages',
            'deviceStats',
            'chartLabels',
            'chartData',
            'publishedArticlesCount',
            'publishedPortfolioCount',
            'recentInquiries',
            'unreadInquiriesCount'
        ));
    }
}
