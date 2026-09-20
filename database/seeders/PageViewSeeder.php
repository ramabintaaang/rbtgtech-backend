<?php

namespace Database\Seeders;

use App\Models\PageView;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PageViewSeeder extends Seeder
{
    public function run(): void
    {
        $paths = [
            '/' => 'RBTG Tech - Modern Enterprise Software & System Architecture',
            '/portfolio' => 'Portofolio Proyek & Case Study - RBTG Tech',
            '/artikel' => 'Artikel & Blog Teknologi - RBTG Tech',
            '/artikel/mengapa-astro-laravel-enterprise' => 'Mengapa Astro & Laravel Adalah Kombinasi Enterprise Terbaik',
            '/portfolio/fintech-core-platform-enterprise-dashboard' => 'Fintech Core Platform Case Study',
            '/tentang-kami' => 'Tentang Kami - RBTG Tech',
            '/kontak' => 'Hubungi Kami - RBTG Tech',
        ];

        $referrers = [
            'https://www.google.com/',
            'https://www.google.co.id/',
            'Direct Traffic',
            'https://t.co/',
            'https://www.linkedin.com/',
        ];

        $devices = ['desktop', 'desktop', 'desktop', 'mobile', 'mobile', 'tablet'];

        // Seed 300 page views over the last 30 days
        for ($i = 0; $i < 350; $i++) {
            $daysAgo = rand(0, 30);
            $viewedAt = Carbon::now()->subDays($daysAgo)->subHours(rand(0, 23))->subMinutes(rand(0, 59));
            $pathKey = array_rand($paths);

            PageView::create([
                'ip_address' => '182.1.' . rand(1, 255) . '.' . rand(1, 255),
                'path' => $pathKey,
                'title' => $paths[$pathKey],
                'referrer' => $referrers[array_rand($referrers)],
                'device_type' => $devices[array_rand($devices)],
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7)',
                'viewed_at' => $viewedAt,
                'created_at' => $viewedAt,
            ]);
        }
    }
}
