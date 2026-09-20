@extends('layouts.app')

@section('title', 'Dashboard - RBTGTech')

@section('content')
<div class="px-margin-desktop py-lg max-w-[1440px] mx-auto flex flex-col gap-lg">
    <!-- Welcome Section -->
    <header class="flex flex-col md:flex-row md:items-end justify-between gap-md">
        <div>
            <h1 class="text-headline-lg font-headline-lg text-on-surface mb-1">Selamat datang kembali, {{ Auth::user()->name ?? 'Admin' }}</h1>
            <p class="text-body-lg font-body-lg text-on-surface-variant">Ringkasan performa real-time dan manajemen konten RBTG Tech.</p>
        </div>
        <div class="flex items-center gap-3 self-start md:self-auto flex-wrap">
            <a href="https://analytics.google.com/analytics/web/#/p461757274/reports/intelligenthome" target="_blank" rel="noopener noreferrer" class="bg-surface-container-high hover:bg-outline-variant/50 text-on-surface rounded-full px-5 py-2.5 flex items-center gap-2 transition-all font-label-md text-label-md border border-outline-variant/60 shadow-xs" title="Buka Google Analytics rbtgtech di Tab Baru">
                <span class="material-symbols-outlined text-[18px] text-amber-500">analytics</span>
                <span>Google Analytics</span>
                <span class="material-symbols-outlined text-[14px] text-on-surface-variant">open_in_new</span>
            </a>
            <a href="{{ route('admin.articles.create') }}" class="bg-primary hover:bg-surface-tint text-on-primary rounded-full px-5 py-2.5 flex items-center gap-2 transition-all font-label-md text-label-md shadow-sm">
                <span class="material-symbols-outlined text-[18px]">add</span>
                Buat Artikel
            </a>
            <a href="{{ route('admin.portfolio.index') }}" class="bg-surface-container-high hover:bg-outline-variant/50 text-on-surface rounded-full px-5 py-2.5 flex items-center gap-2 transition-all font-label-md text-label-md">
                <span class="material-symbols-outlined text-[18px]">folder_special</span>
                Kelola Portofolio
            </a>
        </div>
    </header>

    <!-- Top Grid Stat KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-gutter">
        <!-- Monthly Views Card -->
        <div class="bg-surface-container-lowest rounded-2xl p-6 soft-shadow border border-outline-variant flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-label-sm font-bold text-on-surface-variant uppercase tracking-wider">Trafik Pengunjung (Bulan Ini)</span>
                <div class="w-10 h-10 rounded-xl bg-primary-fixed flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[22px]">bar_chart</span>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-baseline gap-2">
                    <h2 class="text-headline-lg font-bold text-on-surface">{{ number_format($currentMonthViews) }}</h2>
                    <span class="text-label-sm font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">
                        +{{ $viewsGrowth }}% vs bulan lalu
                    </span>
                </div>
                <p class="text-body-md text-on-surface-variant mt-1">Total page views dari pengunjung Astro frontend.</p>
            </div>
        </div>

        <!-- Unique Visitors Card -->
        <div class="bg-surface-container-lowest rounded-2xl p-6 soft-shadow border border-outline-variant flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-label-sm font-bold text-on-surface-variant uppercase tracking-wider">Unique Visitors</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-700">
                    <span class="material-symbols-outlined text-[22px]">group</span>
                </div>
            </div>
            <div class="mt-4">
                <h2 class="text-headline-lg font-bold text-on-surface">{{ number_format($uniqueVisitors) }}</h2>
                <p class="text-body-md text-on-surface-variant mt-1">Pengunjung unik terdeteksi via IP address.</p>
            </div>
        </div>

        <!-- Published Articles Card -->
        <div class="bg-surface-container-lowest rounded-2xl p-6 soft-shadow border border-outline-variant flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-label-sm font-bold text-on-surface-variant uppercase tracking-wider">Artikel Terpublikasi</span>
                <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-700">
                    <span class="material-symbols-outlined text-[22px]">article</span>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-baseline justify-between">
                    <h2 class="text-headline-lg font-bold text-on-surface">{{ $publishedArticlesCount }}</h2>
                    <a href="{{ route('admin.articles.index') }}" class="text-primary text-label-md font-bold hover:underline">Kelola →</a>
                </div>
                <p class="text-body-md text-on-surface-variant mt-1">Tampil di Astro `/artikel`.</p>
            </div>
        </div>

        <!-- Published Portfolios Card -->
        <div class="bg-surface-container-lowest rounded-2xl p-6 soft-shadow border border-outline-variant flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-label-sm font-bold text-on-surface-variant uppercase tracking-wider">Portofolio Proyek</span>
                <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center text-amber-700">
                    <span class="material-symbols-outlined text-[22px]">folder_special</span>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-baseline justify-between">
                    <h2 class="text-headline-lg font-bold text-on-surface">{{ $publishedPortfolioCount }}</h2>
                    <a href="{{ route('admin.portfolio.index') }}" class="text-primary text-label-md font-bold hover:underline">Kelola →</a>
                </div>
                <p class="text-body-md text-on-surface-variant mt-1">Studi kasus aktif di Astro `/portfolio`.</p>
            </div>
        </div>
    </div>

    <!-- Middle Section: Traffic Trend & Top Pages -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-gutter">
        <!-- 7-Day Traffic Trend Bar Chart (Spans 2 Cols) -->
        <div class="lg:col-span-2 bg-surface-container-lowest rounded-2xl p-6 soft-shadow border border-outline-variant flex flex-col">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-headline-sm font-bold text-on-surface">Trend Kunjungan 7 Hari Terakhir</h2>
                    <p class="text-body-md text-on-surface-variant">Data kunjungan harian yang dikirim otomatis dari Astro frontend.</p>
                </div>
                <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 px-3 py-1 rounded-full text-xs font-bold font-mono">Live Telemetry</span>
            </div>

            <!-- Bar Visualizer -->
            <div class="flex-1 flex items-end justify-between gap-3 pt-6 pb-2 min-h-[200px]">
                @php
                    $maxCount = max(1, max($chartData));
                @endphp
                @foreach($chartData as $index => $count)
                    @php
                        $heightPct = min(100, max(15, round(($count / $maxCount) * 100)));
                        $isToday = $index === 6;
                    @endphp
                    <div class="flex-1 flex flex-col items-center gap-2 group">
                        <span class="text-xs font-bold text-on-surface opacity-80 group-hover:opacity-100 transition-opacity">{{ $count }}</span>
                        <div class="w-full rounded-t-xl transition-all duration-300 {{ $isToday ? 'bg-primary shadow-md' : 'bg-primary-container/40 hover:bg-primary' }}" style="height: {{ $heightPct }}%"></div>
                        <span class="text-label-sm font-medium text-on-surface-variant">{{ $chartLabels[$index] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Top Visited Pages List -->
        <div class="bg-surface-container-lowest rounded-2xl p-6 soft-shadow border border-outline-variant flex flex-col">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-headline-sm font-bold text-on-surface">Halaman Terpopuler</h2>
                <span class="material-symbols-outlined text-primary text-[20px]">trending_up</span>
            </div>
            <p class="text-body-md text-on-surface-variant mb-4">Urutan halaman Astro yang paling banyak diakses.</p>

            <div class="space-y-3 flex-1 overflow-y-auto">
                @forelse($topPages as $page)
                    <div class="p-3 bg-surface-container-low rounded-xl border border-outline-variant/50 flex items-center justify-between">
                        <div class="max-w-[70%]">
                            <h3 class="font-bold text-on-surface text-label-md line-clamp-1">{{ $page->title ?: $page->path }}</h3>
                            <p class="font-mono text-xs text-primary line-clamp-1">{{ $page->path }}</p>
                        </div>
                        <span class="bg-primary-container/30 text-primary font-bold text-xs px-2.5 py-1 rounded-full shrink-0">
                            {{ number_format($page->total_views) }} views
                        </span>
                    </div>
                @empty
                    <div class="p-4 text-center text-on-surface-variant text-body-md">
                        Belum ada log halaman yang dikunjungi.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Bottom Section: Device Breakdown & Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
        <!-- Device Usage Distribution -->
        <div class="bg-surface-container-lowest rounded-2xl p-6 soft-shadow border border-outline-variant flex flex-col justify-between">
            <div>
                <h2 class="text-headline-sm font-bold text-on-surface mb-1">Perangkat Pengunjung</h2>
                <p class="text-body-md text-on-surface-variant mb-4">Distribusi tipe perangkat yang digunakan pengunjung.</p>

                <div class="space-y-3">
                    <div>
                        <div class="flex justify-between text-label-sm font-semibold mb-1">
                            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-primary"></span> Desktop / Laptop</span>
                            <span>{{ $deviceStats['desktop_pct'] }}%</span>
                        </div>
                        <div class="h-2 w-full bg-surface-container-high rounded-full overflow-hidden">
                            <div class="h-full bg-primary" style="width: {{ $deviceStats['desktop_pct'] }}%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-label-sm font-semibold mb-1">
                            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Mobile Smartphone</span>
                            <span>{{ $deviceStats['mobile_pct'] }}%</span>
                        </div>
                        <div class="h-2 w-full bg-surface-container-high rounded-full overflow-hidden">
                            <div class="h-full bg-emerald-500" style="width: {{ $deviceStats['mobile_pct'] }}%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-label-sm font-semibold mb-1">
                            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span> Tablet / iPad</span>
                            <span>{{ $deviceStats['tablet_pct'] }}%</span>
                        </div>
                        <div class="h-2 w-full bg-surface-container-high rounded-full overflow-hidden">
                            <div class="h-full bg-amber-500" style="width: {{ $deviceStats['tablet_pct'] }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Contact Leads -->
        <div class="bg-surface-container-lowest rounded-2xl p-6 soft-shadow border border-outline-variant md:col-span-2 flex flex-col justify-between">
            <div class="flex justify-between items-center mb-2">
                <div class="flex items-center gap-2">
                    <h2 class="text-headline-sm font-bold text-on-surface">Pesan & Inquiry Masuk Terbaru</h2>
                    @if($unreadInquiriesCount > 0)
                        <span class="bg-emerald-100 text-emerald-800 border border-emerald-300 px-2.5 py-0.5 rounded-full text-xs font-bold font-mono">{{ $unreadInquiriesCount }} Baru</span>
                    @endif
                </div>
                <a href="{{ route('admin.inquiries.index') }}" class="text-primary text-label-md font-bold hover:underline">Buka Inbox →</a>
            </div>
            <p class="text-body-md text-on-surface-variant mb-4">Pesan penawaran dan konsultasi yang dikirim pengunjung situs web RBTG Tech.</p>

            <div class="space-y-3">
                @forelse($recentInquiries as $inquiry)
                    <div class="p-3.5 bg-surface-container-low rounded-xl border border-outline-variant/40 flex items-center justify-between">
                        <div class="max-w-[70%]">
                            <h3 class="font-bold text-on-surface text-label-md line-clamp-1">{{ $inquiry->subject }}</h3>
                            <p class="text-body-md text-on-surface-variant text-xs line-clamp-1">Pengirim: {{ $inquiry->name }} ({{ $inquiry->email }})</p>
                        </div>
                        <div class="flex items-center gap-2">
                            @if($inquiry->whatsapp_url)
                                <a href="{{ $inquiry->whatsapp_url }}" target="_blank" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-3 py-1.5 rounded-lg flex items-center gap-1 transition-all soft-shadow">
                                    <span class="material-symbols-outlined text-[14px]">chat</span> WA
                                </a>
                            @endif
                            @if($inquiry->status === 'new')
                                <span class="text-xs bg-emerald-100 text-emerald-800 font-bold px-2.5 py-1 rounded-full border border-emerald-300">Baru</span>
                            @elseif($inquiry->status === 'replied')
                                <span class="text-xs bg-indigo-100 text-indigo-800 font-bold px-2.5 py-1 rounded-full border border-indigo-300">Selesai</span>
                            @else
                                <span class="text-xs bg-surface-container-high text-on-surface-variant font-bold px-2.5 py-1 rounded-full">Dibaca</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-center text-on-surface-variant text-body-md">
                        Belum ada pesan masuk di inbox.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
