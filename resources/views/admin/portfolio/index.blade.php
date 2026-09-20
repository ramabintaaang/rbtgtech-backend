@extends('layouts.app')

@section('title', 'Portofolio Proyek - RBTGTech')

@section('content')
<div class="px-margin-desktop py-lg max-w-[1440px] mx-auto flex flex-col gap-lg" id="spaContainer">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-md">
        <div>
            <h1 class="text-headline-lg font-headline-lg text-on-surface mb-1">Portofolio Proyek</h1>
            <p class="text-body-lg font-body-lg text-on-surface-variant">Kelola studi kasus proyek, teknologi, dan optimasi SEO secara real-time.</p>
        </div>
        <button 
            type="button" 
            onclick="openPortfolioDrawer()" 
            class="bg-primary hover:bg-surface-tint text-on-primary font-bold text-label-md px-6 py-2.5 rounded-full flex items-center gap-2 transition-all soft-shadow self-start md:self-auto cursor-pointer"
        >
            <span class="material-symbols-outlined text-[20px]">add</span>
            Tambah Proyek Baru
        </button>
    </div>

    <!-- Stat KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter">
        <div class="bg-surface-container-lowest p-5 rounded-2xl border border-outline-variant soft-shadow flex items-center justify-between">
            <div>
                <p class="text-label-sm text-on-surface-variant font-medium">Total Proyek</p>
                <h3 class="text-headline-md font-bold text-on-surface mt-1" id="statTotal">0</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-primary-fixed flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-[24px]">folder_special</span>
            </div>
        </div>

        <div class="bg-surface-container-lowest p-5 rounded-2xl border border-outline-variant soft-shadow flex items-center justify-between">
            <div>
                <p class="text-label-sm text-on-surface-variant font-medium">Terpublikasi di Web</p>
                <h3 class="text-headline-md font-bold text-emerald-600 mt-1" id="statPublished">0</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-700">
                <span class="material-symbols-outlined text-[24px]">verified</span>
            </div>
        </div>

        <div class="bg-surface-container-lowest p-5 rounded-2xl border border-outline-variant soft-shadow flex items-center justify-between">
            <div>
                <p class="text-label-sm text-on-surface-variant font-medium">Enterprise Systems</p>
                <h3 class="text-headline-md font-bold text-primary mt-1" id="statEnterprise">0</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-primary-container/30 flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-[24px]">domain</span>
            </div>
        </div>

        <div class="bg-surface-container-lowest p-5 rounded-2xl border border-outline-variant soft-shadow flex items-center justify-between">
            <div>
                <p class="text-label-sm text-on-surface-variant font-medium">Rata-Rata SEO Score</p>
                <h3 class="text-headline-md font-bold text-on-surface mt-1" id="statAvgSeo">0/100</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center text-amber-700">
                <span class="material-symbols-outlined text-[24px]">troubleshoot</span>
            </div>
        </div>
    </div>

    <!-- AJAX Filters & Search -->
    <div class="bg-surface-container-lowest p-4 rounded-2xl soft-shadow border border-outline-variant flex flex-wrap gap-md items-center justify-between">
        <div class="flex flex-wrap items-center gap-md flex-grow">
            <!-- Search -->
            <div class="relative flex-grow max-w-md">
                <input 
                    type="text" 
                    id="searchInput" 
                    oninput="debounceLoadData()" 
                    placeholder="Cari judul proyek, klien, kata kunci..." 
                    class="w-full bg-surface-container-low border border-outline-variant rounded-full pl-10 pr-4 py-2 text-body-md focus:border-primary focus:ring-0 outline-none"
                />
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">search</span>
            </div>

            <!-- Category Filter -->
            <select id="categoryFilter" onchange="loadPortfolioData()" class="bg-surface-container-low border border-outline-variant rounded-full px-4 py-2 text-body-md text-on-surface focus:border-primary outline-none">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                @endforeach
            </select>

            <!-- Status Filter -->
            <select id="statusFilter" onchange="loadPortfolioData()" class="bg-surface-container-low border border-outline-variant rounded-full px-4 py-2 text-body-md text-on-surface focus:border-primary outline-none">
                <option value="">Semua Status</option>
                <option value="published">Terpublikasi</option>
                <option value="draft">Draf</option>
            </select>

            <!-- Per Page Limit -->
            <select id="filterPerPage" onchange="currentPage=1; renderPortfolioTable(portfolioData)" class="bg-surface-container-low border border-outline-variant rounded-full px-4 py-2 text-body-md text-on-surface focus:border-primary outline-none">
                <option value="10">10 Baris</option>
                <option value="25">25 Baris</option>
                <option value="50">50 Baris</option>
                <option value="100">100 Baris</option>
                <option value="all">Semua</option>
            </select>
        </div>

        <button type="button" onclick="resetFilters()" class="text-error text-label-md font-label-md flex items-center gap-1 hover:underline cursor-pointer">
            <span class="material-symbols-outlined text-[16px]">close</span> Reset Filter
        </button>
    </div>

    <!-- Portfolio Table / Cards Container -->
    <div class="bg-surface-container-lowest rounded-2xl soft-shadow border border-outline-variant overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low border-b border-outline-variant text-on-surface-variant text-label-md font-label-md">
                        <th class="py-4 px-6 font-bold cursor-pointer select-none hover:text-primary transition-colors" onclick="sortBy('title')">
                            <div class="flex items-center gap-1">
                                <span>Proyek & Client</span>
                                <span id="sortIcon-title" class="material-symbols-outlined text-[16px]">swap_vert</span>
                            </div>
                        </th>
                        <th class="py-4 px-6 font-bold cursor-pointer select-none hover:text-primary transition-colors" onclick="sortBy('category')">
                            <div class="flex items-center gap-1">
                                <span>Kategori & Tahun</span>
                                <span id="sortIcon-category" class="material-symbols-outlined text-[16px]">swap_vert</span>
                            </div>
                        </th>
                        <th class="py-4 px-6 font-bold cursor-pointer select-none hover:text-primary transition-colors" onclick="sortBy('tech_stack')">
                            <div class="flex items-center gap-1">
                                <span>Tech Stack</span>
                                <span id="sortIcon-tech_stack" class="material-symbols-outlined text-[16px]">swap_vert</span>
                            </div>
                        </th>
                        <th class="py-4 px-6 font-bold cursor-pointer select-none hover:text-primary transition-colors" onclick="sortBy('seo_score')">
                            <div class="flex items-center gap-1">
                                <span>SEO Score</span>
                                <span id="sortIcon-seo_score" class="material-symbols-outlined text-[16px]">swap_vert</span>
                            </div>
                        </th>
                        <th class="py-4 px-6 font-bold cursor-pointer select-none hover:text-primary transition-colors" onclick="sortBy('status')">
                            <div class="flex items-center gap-1">
                                <span>Status</span>
                                <span id="sortIcon-status" class="material-symbols-outlined text-[16px]">swap_vert</span>
                            </div>
                        </th>
                        <th class="py-4 px-6 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody id="portfolioTableBody" class="divide-y divide-surface-container">
                    <!-- Loaded via JavaScript AJAX -->
                    <tr>
                        <td colspan="6" class="py-12 text-center text-on-surface-variant">
                            <span class="material-symbols-outlined text-[36px] animate-spin block mb-2 text-primary">sync</span>
                            Memuat data portofolio via AJAX...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="tablePagination"></div>
    </div>
</div>

<!-- Slide-Over Drawer / Modal for Create & Edit -->
<div id="drawerBackdrop" class="fixed inset-0 bg-black/40 backdrop-blur-xs z-50 hidden transition-opacity duration-300 opacity-0" onclick="closePortfolioDrawer()"></div>

<div id="portfolioDrawer" class="fixed inset-y-0 right-0 z-50 w-full max-w-2xl bg-surface-container-lowest shadow-2xl border-l border-outline-variant flex flex-col transform translate-x-full transition-transform duration-300 ease-in-out">
    <!-- Drawer Header -->
    <div class="px-6 py-4 border-b border-outline-variant/40 flex justify-between items-center bg-surface-container-low">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary-fixed flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-[24px]">folder_special</span>
            </div>
            <div>
                <h2 id="drawerTitle" class="text-headline-sm font-bold text-on-surface">Tambah Proyek Baru</h2>
                <p class="text-label-sm text-on-surface-variant">Isi detail studi kasus proyek dan optimalkan RBTGTech SEO.</p>
            </div>
        </div>
        <button type="button" onclick="closePortfolioDrawer()" class="p-2 text-on-surface-variant hover:text-error rounded-lg transition-colors cursor-pointer">
            <span class="material-symbols-outlined text-[24px]">close</span>
        </button>
    </div>

    <!-- Drawer Body Form -->
    <form id="portfolioForm" onsubmit="savePortfolio(event)" class="flex-1 overflow-y-auto p-6 space-y-6">
        @csrf
        <input type="hidden" id="portfolioId" name="id" value="">
        <input type="hidden" id="seoScoreInput" name="seo_score" value="85">

        <!-- Error Banner -->
        <div id="formErrorBanner" class="hidden p-4 rounded-xl bg-error-container text-on-error-container text-body-md flex items-start gap-3">
            <span class="material-symbols-outlined text-error text-[20px] shrink-0 mt-0.5">error</span>
            <div id="formErrorMessage">Terdapat kesalahan pengisian form.</div>
        </div>

        <!-- Project Title -->
        <div>
            <label for="title" class="block text-label-md font-bold text-on-surface mb-2">Judul Proyek <span class="text-error">*</span></label>
            <input 
                type="text" 
                id="title" 
                name="title" 
                required 
                oninput="onTitleInput()" 
                placeholder="Contoh: Fintech Core Platform & Enterprise Dashboard" 
                class="w-full bg-surface-container-low border border-outline-variant rounded-xl px-4 py-3 text-headline-sm font-semibold text-on-surface focus:border-primary outline-none"
            />
        </div>

        <!-- Slug Permastring -->
        <div>
            <label for="slug" class="block text-label-md font-bold text-on-surface mb-2">URL Slug / Permalink <span class="text-error">*</span></label>
            <div class="flex items-center gap-2 bg-surface-container-low border border-outline-variant rounded-xl px-3 py-2 text-body-md text-on-surface">
                <span class="text-on-surface-variant font-mono text-xs select-none">rbtgtech.com/portfolio/</span>
                <input 
                    type="text" 
                    id="slug" 
                    name="slug" 
                    required 
                    oninput="isManualSlug = true; runSeoAnalysis()" 
                    placeholder="fintech-core-platform" 
                    class="w-full bg-transparent border-none font-mono text-xs text-primary focus:ring-0 outline-none p-0"
                />
            </div>
        </div>

        <!-- Category & Client & Year -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label for="category" class="block text-label-md font-bold text-on-surface mb-2">Kategori <span class="text-error">*</span></label>
                <select id="category" name="category" required class="w-full bg-surface-container-low border border-outline-variant rounded-xl p-3 text-body-md text-on-surface focus:border-primary outline-none">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="client" class="block text-label-md font-bold text-on-surface mb-2">Nama Klien</label>
                <input 
                    type="text" 
                    id="client" 
                    name="client" 
                    placeholder="PT Bank Nusa Digital" 
                    class="w-full bg-surface-container-low border border-outline-variant rounded-xl p-3 text-body-md text-on-surface focus:border-primary outline-none"
                />
            </div>

            <div>
                <label for="year" class="block text-label-md font-bold text-on-surface mb-2">Tahun Proyek</label>
                <input 
                    type="text" 
                    id="year" 
                    name="year" 
                    value="2026" 
                    placeholder="2026" 
                    class="w-full bg-surface-container-low border border-outline-variant rounded-xl p-3 text-body-md text-on-surface focus:border-primary outline-none"
                />
            </div>
        </div>

        <!-- Summary / Short Excerpt -->
        <div>
            <label for="summary" class="block text-label-md font-bold text-on-surface mb-2">Ringkasan Singkat / Meta Description</label>
            <textarea 
                id="summary" 
                name="summary" 
                rows="2" 
                oninput="runSeoAnalysis()" 
                placeholder="Ringkasan 1-2 kalimat mengenai proyek..."
                class="w-full bg-surface-container-low border border-outline-variant rounded-xl p-3 text-body-md text-on-surface focus:border-primary outline-none"
            ></textarea>
        </div>

        <!-- Detailed Description -->
        <div>
            <label for="description" class="block text-label-md font-bold text-on-surface mb-2">Deskripsi Lengkap Proyek</label>
            <textarea 
                id="description" 
                name="description" 
                rows="4" 
                oninput="runSeoAnalysis()" 
                placeholder="Penjelasan detail ekosistem proyek dan arsitektur..."
                class="w-full bg-surface-container-low border border-outline-variant rounded-xl p-3 text-body-md text-on-surface focus:border-primary outline-none"
            ></textarea>
        </div>

        <!-- Challenge & Solution -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="challenge" class="block text-label-md font-bold text-on-surface mb-2">Tantangan Klien (Challenge)</label>
                <textarea 
                    id="challenge" 
                    name="challenge" 
                    rows="3" 
                    placeholder="Masalah utama yang dihadapi klien..."
                    class="w-full bg-surface-container-low border border-outline-variant rounded-xl p-3 text-body-md text-on-surface focus:border-primary outline-none"
                ></textarea>
            </div>

            <div>
                <label for="solution" class="block text-label-md font-bold text-on-surface mb-2">Solusi RBTGTech (Solution)</label>
                <textarea 
                    id="solution" 
                    name="solution" 
                    rows="3" 
                    placeholder="Arsitektur dan pendekatan solusi yang kami berikan..."
                    class="w-full bg-surface-container-low border border-outline-variant rounded-xl p-3 text-body-md text-on-surface focus:border-primary outline-none"
                ></textarea>
            </div>
        </div>

        <!-- Results (Newline separated) -->
        <div>
            <label for="results_input" class="block text-label-md font-bold text-on-surface mb-2">Hasil & Impact Klien (1 Poin Per Baris)</label>
            <textarea 
                id="results_input" 
                name="results_input" 
                rows="3" 
                placeholder="Peningkatan kecepatan transaksi hingga 300%&#10;Uptime sistem mencapai 99.99%"
                class="w-full bg-surface-container-low border border-outline-variant rounded-xl p-3 text-body-md text-on-surface focus:border-primary outline-none font-sans"
            ></textarea>
        </div>

        <!-- Tech Stack Tags -->
        <div>
            <label for="tech_stack_input" class="block text-label-md font-bold text-on-surface mb-2">Tech Stack (Pisahkan Koma)</label>
            <input 
                type="text" 
                id="tech_stack_input" 
                name="tech_stack_input" 
                placeholder="Laravel, Astro, Tailwind CSS, Redis" 
                class="w-full bg-surface-container-low border border-outline-variant rounded-xl p-3 text-body-md text-on-surface focus:border-primary outline-none"
            />
        </div>

        <!-- Featured Cover Image Upload & Preview Zone -->
        <div class="space-y-2">
            <label class="block text-label-md font-bold text-on-surface">Gambar Cover Portofolio</label>
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-center">
                <!-- Preview Box -->
                <div class="relative group rounded-xl overflow-hidden border border-outline-variant bg-surface-container-low aspect-video flex items-center justify-center shadow-inner">
                    <img id="portfolioImagePreview" src="/logo-rbtgtech.png" alt="Cover Preview" class="w-full h-full object-cover transition-transform group-hover:scale-105" onerror="this.src='/logo-rbtgtech.png'" />
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white text-xs font-bold pointer-events-none">
                        Pratinjau Cover
                    </div>
                </div>

                <!-- Upload Zone & Options -->
                <div class="sm:col-span-2 space-y-3">
                    <div class="border-2 border-dashed border-outline-variant hover:border-primary rounded-xl p-4 text-center cursor-pointer transition-colors bg-surface-container-low" onclick="document.getElementById('image_file').click()">
                        <input type="file" id="image_file" name="image_file" accept="image/*" class="hidden" onchange="previewPortfolioImage(this)" />
                        <span class="material-symbols-outlined text-[28px] text-primary block mb-1">cloud_upload</span>
                        <p class="text-label-md font-bold text-on-surface">Pilih / Upload Gambar Cover</p>
                        <p class="text-xs text-on-surface-variant mt-0.5">Format: JPG, PNG, WEBP (Maks. 5MB). Otomatis tersimpan di <code class="bg-surface-container px-1 py-0.5 rounded text-primary">storage/portfolios/</code></p>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-on-surface-variant uppercase shrink-0">Atau URL:</span>
                        <input 
                            type="text" 
                            id="image_url" 
                            name="image_url" 
                            placeholder="https://... atau URL gambar eksternal" 
                            oninput="document.getElementById('portfolioImagePreview').src = this.value || '/logo-rbtgtech.png'; runSeoAnalysis();" 
                            class="flex-1 bg-surface-container-low border border-outline-variant rounded-xl p-2.5 text-xs text-on-surface focus:border-primary outline-none"
                        />
                        <button type="button" onclick="resetPortfolioImage()" class="px-2.5 py-2 text-xs font-bold text-on-surface-variant hover:text-error bg-surface-container rounded-lg transition-colors shrink-0" title="Reset ke Logo Default">
                            Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status & Live URL -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="status" class="block text-label-md font-bold text-on-surface mb-2">Status Publikasi <span class="text-error">*</span></label>
                <select id="status" name="status" required class="w-full bg-surface-container-low border border-outline-variant rounded-xl p-3 text-body-md text-on-surface focus:border-primary outline-none">
                    <option value="published">Published (Tampil di Astro Web)</option>
                    <option value="draft">Draft (Konsep Internal)</option>
                </select>
            </div>

            <div>
                <label for="live_url" class="block text-label-md font-bold text-on-surface mb-2">Live Demo URL (Opsional)</label>
                <input 
                    type="text" 
                    id="live_url" 
                    name="live_url" 
                    placeholder="https://client-website.com" 
                    class="w-full bg-surface-container-low border border-outline-variant rounded-xl p-3 text-body-md text-on-surface focus:border-primary outline-none"
                />
            </div>
        </div>

        <!-- RBTGTech SEO Live Analysis Panel inside Drawer -->
        <div class="bg-surface-container-low p-5 rounded-2xl border border-outline-variant space-y-4">
            <div class="flex items-center justify-between border-b border-outline-variant/40 pb-3">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-[20px]">troubleshoot</span>
                    <h3 class="text-headline-sm font-bold text-on-surface">RBTGTech SEO Meter</h3>
                </div>
                <div id="drawerSeoBadge" class="flex items-center gap-1.5 px-3 py-1 rounded-full font-bold text-headline-sm border bg-emerald-100 text-emerald-800 border-emerald-300">
                    <span id="drawerSeoScore">85</span>
                    <span class="text-xs opacity-75">/ 100</span>
                </div>
            </div>

            <div>
                <label for="focus_keyword" class="block text-label-md font-bold text-on-surface mb-1">Focus Keyword Target</label>
                <input 
                    type="text" 
                    id="focus_keyword" 
                    name="focus_keyword" 
                    oninput="runSeoAnalysis()" 
                    placeholder="Contoh: Fintech Enterprise Dashboard" 
                    class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-3 py-2 text-body-md text-on-surface focus:border-primary outline-none"
                />
            </div>

            <!-- Real-Time Checklist -->
            <ul class="space-y-2 text-xs">
                <li id="seoRuleTitle" class="flex items-center gap-2 text-on-surface-variant">
                    <span class="material-symbols-outlined text-[16px] text-rose-500">cancel</span>
                    <span>Focus Keyword terdapat di Judul Proyek</span>
                </li>
                <li id="seoRuleSlug" class="flex items-center gap-2 text-on-surface-variant">
                    <span class="material-symbols-outlined text-[16px] text-rose-500">cancel</span>
                    <span>Focus Keyword terdapat di URL Slug</span>
                </li>
                <li id="seoRuleDesc" class="flex items-center gap-2 text-on-surface-variant">
                    <span class="material-symbols-outlined text-[16px] text-rose-500">cancel</span>
                    <span>Focus Keyword di Ringkasan / Meta Description</span>
                </li>
                <li id="seoRuleImage" class="flex items-center gap-2 text-on-surface-variant">
                    <span class="material-symbols-outlined text-[16px] text-rose-500">cancel</span>
                    <span>Gambar Utama & Case Study Lengkap</span>
                </li>
            </ul>
        </div>
    </form>

    <!-- Drawer Footer Actions -->
    <div class="px-6 py-4 border-t border-outline-variant bg-surface-container-low flex items-center justify-end gap-3">
        <button type="button" onclick="closePortfolioDrawer()" class="px-5 py-2.5 rounded-xl text-on-surface font-semibold hover:bg-surface-container-high transition-colors cursor-pointer">
            Batal
        </button>
        <button type="button" onclick="document.getElementById('portfolioForm').requestSubmit()" class="bg-primary hover:bg-surface-tint text-on-primary font-bold px-6 py-2.5 rounded-xl transition-all soft-shadow flex items-center gap-2 cursor-pointer">
            <span class="material-symbols-outlined text-[18px]">save</span>
            <span id="saveBtnText">Simpan Proyek</span>
        </button>
    </div>
</div>

<!-- Animated Toast Notification Container -->
<div id="toastContainer" class="fixed bottom-6 right-6 z-50 flex flex-col gap-2"></div>

<!-- JavaScript SPA AJAX Logic -->
<script>
let portfolioData = [];
let isEditing = false;
let isManualSlug = false;
let optimizedCoverFile = null;
let currentPage = 1;
let sortColumn = 'created_at';
let sortDirection = 'desc';

document.addEventListener('DOMContentLoaded', function() {
    loadPortfolioData();
});

// 1. Fetch JSON Data via AJAX (No Page Reload)
async function loadPortfolioData() {
    const tbody = document.getElementById('portfolioTableBody');
    const search = document.getElementById('searchInput').value.trim();
    const category = document.getElementById('categoryFilter').value;
    const status = document.getElementById('statusFilter').value;

    const params = new URLSearchParams();
    if (search) params.append('search', search);
    if (category) params.append('category', category);
    if (status) params.append('status', status);

    try {
        const response = await fetch(`/admin/portfolio/data?${params.toString()}`, {
            headers: { 'Accept': 'application/json' }
        });
        const result = await response.json();
        
        if (result.status === 'success') {
            portfolioData = result.data;
            currentPage = 1; // Reset page on new filter
            renderPortfolioTable(portfolioData);
            updateKpiStats(portfolioData);
        }
    } catch (err) {
        console.error('Failed to load portfolio data:', err);
        showToast('Gagal memuat data portofolio dari server', 'error');
    }
}

let debounceTimer;
function debounceLoadData() {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(loadPortfolioData, 300);
}

function resetFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('categoryFilter').value = '';
    document.getElementById('statusFilter').value = '';
    currentPage = 1;
    loadPortfolioData();
}

function sortBy(column) {
    if (sortColumn === column) {
        sortDirection = sortDirection === 'asc' ? 'desc' : 'asc';
    } else {
        sortColumn = column;
        sortDirection = 'asc';
    }
    currentPage = 1;
    renderPortfolioTable(portfolioData);
}

function goToPage(page) {
    currentPage = page;
    renderPortfolioTable(portfolioData);
}

function updateSortIcons() {
    const columns = ['title', 'category', 'tech_stack', 'seo_score', 'status'];
    columns.forEach(col => {
        const icon = document.getElementById(`sortIcon-${col}`);
        if (!icon) return;
        
        if (sortColumn === col) {
            icon.innerText = sortDirection === 'asc' ? 'arrow_upward' : 'arrow_downward';
            icon.classList.add('text-primary');
        } else {
            icon.innerText = 'swap_vert';
            icon.classList.remove('text-primary');
        }
    });
}

// 2. Render Portfolio Table DOM dynamically
function renderPortfolioTable(items) {
    const tbody = document.getElementById('portfolioTableBody');
    updateSortIcons();
    
    if (items.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="py-12 text-center text-on-surface-variant">
                    <span class="material-symbols-outlined text-[48px] block mb-2 opacity-50">folder_off</span>
                    Belum ada proyek portofolio yang cocok dengan pencarian.
                </td>
            </tr>
        `;
        document.getElementById('tablePagination').innerHTML = '';
        return;
    }

    // Client-side sort and paginate
    const sortedItems = rbtgTable.sort(items, sortColumn, sortDirection);
    const perPageVal = document.getElementById('filterPerPage').value;
    const paginatedItems = rbtgTable.paginate(sortedItems, currentPage, perPageVal);

    tbody.innerHTML = paginatedItems.map(item => {
        const score = item.seo_score || 85;
        const scoreClass = score >= 80 ? 'bg-emerald-100 text-emerald-800 border-emerald-300' : (score >= 50 ? 'bg-amber-100 text-amber-800 border-amber-300' : 'bg-rose-100 text-rose-800 border-rose-300');
        const techStack = Array.isArray(item.tech_stack) ? item.tech_stack : [];

        return `
            <tr id="row-portfolio-${item.id}" class="hover:bg-surface-container-low/50 transition-colors">
                <td class="py-4 px-6 max-w-xs">
                    <div class="flex items-center gap-3">
                        <img src="${item.image_url || '/logo-rbtgtech.png'}" alt="Cover" class="w-12 h-12 rounded-xl object-cover border border-outline-variant bg-surface-container shrink-0 shadow-xs" onerror="this.src='/logo-rbtgtech.png'" />
                        <div class="min-w-0">
                            <h3 class="font-bold text-on-surface text-label-md line-clamp-1 mb-0.5">${escapeHtml(item.title)}</h3>
                            <p class="text-body-md text-on-surface-variant line-clamp-1 font-mono text-xs text-primary">/portfolio/${escapeHtml(item.slug)}</p>
                            <p class="text-xs text-on-surface-variant mt-0.5">Client: <span class="font-semibold text-on-surface">${escapeHtml(item.client || '-')}</span></p>
                        </div>
                    </div>
                </td>
                <td class="py-4 px-6 text-body-md text-on-surface">
                    <span class="bg-surface-container-high px-3 py-1 rounded-full text-label-sm font-semibold text-on-surface block w-max mb-1">
                        ${escapeHtml(item.category)}
                    </span>
                    <span class="text-xs text-on-surface-variant font-mono">${escapeHtml(item.year || '2026')}</span>
                </td>
                <td class="py-4 px-6">
                    <div class="flex flex-wrap gap-1 max-w-xs">
                        ${techStack.slice(0, 3).map(t => `<span class="bg-primary-container/20 text-primary px-2 py-0.5 rounded text-[11px] font-medium">${escapeHtml(t)}</span>`).join('')}
                        ${techStack.length > 3 ? `<span class="text-[11px] text-on-surface-variant">+${techStack.length - 3}</span>` : ''}
                    </div>
                </td>
                <td class="py-4 px-6">
                    <span class="inline-flex items-center gap-1 font-bold text-xs border rounded-lg px-2.5 py-1 ${scoreClass}">
                        ⚡ ${score}/100
                    </span>
                </td>
                <td class="py-4 px-6">
                    ${item.status === 'published' 
                        ? '<span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-1 rounded-full text-label-sm font-semibold"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Published</span>'
                        : '<span class="inline-flex items-center gap-1 bg-slate-100 text-slate-700 border border-slate-300 px-2.5 py-1 rounded-full text-label-sm font-semibold"><span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Draft</span>'
                    }
                </td>
                <td class="py-4 px-6 text-right space-x-2">
                    <button type="button" onclick="editPortfolio(${item.id})" class="p-2 text-primary hover:bg-primary-fixed/50 rounded-lg transition-colors cursor-pointer" title="Edit Proyek">
                        <span class="material-symbols-outlined text-[20px]">edit</span>
                    </button>
                    <button type="button" onclick="deletePortfolio(${item.id})" class="p-2 text-error hover:bg-error-container/30 rounded-lg transition-colors cursor-pointer" title="Hapus Proyek">
                        <span class="material-symbols-outlined text-[20px]">delete</span>
                    </button>
                </td>
            </tr>
        `;
    }).join('');

    rbtgTable.renderPagination('tablePagination', items.length, currentPage, perPageVal, 'goToPage');
}

// 3. Update KPI Stat Cards
function updateKpiStats(items) {
    document.getElementById('statTotal').textContent = items.length;
    document.getElementById('statPublished').textContent = items.filter(i => i.status === 'published').length;
    document.getElementById('statEnterprise').textContent = items.filter(i => i.category === 'Enterprise System').length;
    
    if (items.length > 0) {
        const sum = items.reduce((acc, curr) => acc + (curr.seo_score || 85), 0);
        document.getElementById('statAvgSeo').textContent = `${Math.round(sum / items.length)}/100`;
    } else {
        document.getElementById('statAvgSeo').textContent = '0/100';
    }
}

// 4. Slide-Over Drawer Open & Close
function openPortfolioDrawer() {
    isEditing = false;
    isManualSlug = false;
    optimizedCoverFile = null;
    document.getElementById('portfolioForm').reset();
    document.getElementById('portfolioId').value = '';
    document.getElementById('image_file').value = '';
    document.getElementById('image_url').value = '';
    document.getElementById('portfolioImagePreview').src = '/logo-rbtgtech.png';
    document.getElementById('drawerTitle').textContent = 'Tambah Proyek Baru';
    document.getElementById('saveBtnText').textContent = 'Simpan Proyek';
    document.getElementById('formErrorBanner').classList.add('hidden');

    const backdrop = document.getElementById('drawerBackdrop');
    const drawer = document.getElementById('portfolioDrawer');

    backdrop.classList.remove('hidden');
    setTimeout(() => {
        backdrop.classList.remove('opacity-0');
        drawer.classList.remove('translate-x-full');
    }, 10);

    runSeoAnalysis();
}

function closePortfolioDrawer() {
    const backdrop = document.getElementById('drawerBackdrop');
    const drawer = document.getElementById('portfolioDrawer');

    backdrop.classList.add('opacity-0');
    drawer.classList.add('translate-x-full');

    setTimeout(() => {
        backdrop.classList.add('hidden');
    }, 300);
}

function previewPortfolioImage(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        if (file.size > 12 * 1024 * 1024) {
            alert('Ukuran gambar cover maksimal 12MB.');
            input.value = '';
            optimizedCoverFile = null;
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            const img = new Image();
            img.onload = function() {
                // Auto-scale to max 1600px width/height and compress to WebP if > 1.5MB or dimension > 1600px
                const maxDim = 1600;
                let w = img.width;
                let h = img.height;

                if (w > maxDim || h > maxDim || file.size > 1.5 * 1024 * 1024) {
                    if (w > h) {
                        if (w > maxDim) {
                            h = Math.round((h * maxDim) / w);
                            w = maxDim;
                        }
                    } else {
                        if (h > maxDim) {
                            w = Math.round((w * maxDim) / h);
                            h = maxDim;
                        }
                    }

                    const canvas = document.createElement('canvas');
                    canvas.width = w;
                    canvas.height = h;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, w, h);

                    canvas.toBlob(function(blob) {
                        if (blob) {
                            const cleanName = file.name.replace(/\.[^/.]+$/, "") + ".webp";
                            optimizedCoverFile = new File([blob], cleanName, {
                                type: "image/webp",
                                lastModified: Date.now()
                            });
                            document.getElementById('portfolioImagePreview').src = canvas.toDataURL('image/webp', 0.85);
                        } else {
                            optimizedCoverFile = file;
                            document.getElementById('portfolioImagePreview').src = e.target.result;
                        }
                        runSeoAnalysis();
                    }, 'image/webp', 0.85);
                } else {
                    optimizedCoverFile = file;
                    document.getElementById('portfolioImagePreview').src = e.target.result;
                    runSeoAnalysis();
                }
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}

function resetPortfolioImage() {
    optimizedCoverFile = null;
    document.getElementById('image_file').value = '';
    document.getElementById('image_url').value = '';
    document.getElementById('portfolioImagePreview').src = '/logo-rbtgtech.png';
    runSeoAnalysis();
}

function onTitleInput() {
    if (!isManualSlug) {
        const title = document.getElementById('title').value;
        document.getElementById('slug').value = title
            .toLowerCase()
            .trim()
            .replace(/[^\w\s-]/g, '')
            .replace(/[\s_-]+/g, '-')
            .replace(/^-+|-+$/g, '');
    }
    runSeoAnalysis();
}

// 5. Populate Edit Form via AJAX
async function editPortfolio(id) {
    try {
        const response = await fetch(`/admin/portfolio/${id}`, {
            headers: { 'Accept': 'application/json' }
        });
        const result = await response.json();

        if (result.status === 'success') {
            const item = result.data;
            isEditing = true;
            isManualSlug = true;
            optimizedCoverFile = null;

            document.getElementById('portfolioId').value = item.id;
            document.getElementById('title').value = item.title || '';
            document.getElementById('slug').value = item.slug || '';
            document.getElementById('category').value = item.category || 'Enterprise System';
            document.getElementById('client').value = item.client || '';
            document.getElementById('year').value = item.year || '2026';
            document.getElementById('summary').value = item.summary || '';
            document.getElementById('description').value = item.description || '';
            document.getElementById('challenge').value = item.challenge || '';
            document.getElementById('solution').value = item.solution || '';
            document.getElementById('results_input').value = Array.isArray(item.results) ? item.results.join('\n') : '';
            document.getElementById('tech_stack_input').value = Array.isArray(item.tech_stack) ? item.tech_stack.join(', ') : '';
            document.getElementById('image_url').value = item.image_url || '';
            document.getElementById('image_file').value = '';
            document.getElementById('portfolioImagePreview').src = item.image_url || '/logo-rbtgtech.png';
            document.getElementById('live_url').value = item.live_url || '';
            document.getElementById('status').value = item.status || 'published';
            document.getElementById('focus_keyword').value = item.focus_keyword || '';

            document.getElementById('drawerTitle').textContent = 'Edit Proyek Portofolio';
            document.getElementById('saveBtnText').textContent = 'Simpan Perubahan';
            document.getElementById('formErrorBanner').classList.add('hidden');

            const backdrop = document.getElementById('drawerBackdrop');
            const drawer = document.getElementById('portfolioDrawer');

            backdrop.classList.remove('hidden');
            setTimeout(() => {
                backdrop.classList.remove('opacity-0');
                drawer.classList.remove('translate-x-full');
            }, 10);

            runSeoAnalysis();
        }
    } catch (err) {
        showToast('Gagal memuat data detail proyek', 'error');
    }
}

// 6. Save (Create or Update) via AJAX with Image File Upload Support
async function savePortfolio(event) {
    event.preventDefault();
    const id = document.getElementById('portfolioId').value;
    const isUpdate = id && id !== '';

    const url = isUpdate ? `/admin/portfolio/${id}` : '/admin/portfolio';

    const formEl = document.getElementById('portfolioForm');
    const formData = new FormData(formEl);
    if (isUpdate) {
        formData.append('_method', 'PUT');
    }

    // Attach client-optimized cover file if available
    if (optimizedCoverFile) {
        formData.set('image_file', optimizedCoverFile);
    }

    const saveBtnText = document.getElementById('saveBtnText');
    const originalText = saveBtnText.textContent;
    saveBtnText.textContent = 'Menyimpan...';

    // Hide any previous error banner
    document.getElementById('formErrorBanner').classList.add('hidden');

    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') 
            || document.querySelector('input[name="_token"]')?.value;

        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
            },
            body: formData
        });

        let result = null;
        try {
            result = await response.json();
        } catch (jsonErr) {
            result = null;
        }

        if (response.ok && result && result.status === 'success') {
            closePortfolioDrawer();
            showToast(result.message, 'success');
            loadPortfolioData();
        } else if (response.status === 419) {
            showToast('Sesi login telah kedaluwarsa. Halaman akan dimuat ulang...', 'error');
            setTimeout(() => window.location.reload(), 1500);
        } else {
            let errorList = [];
            if (result && result.errors) {
                errorList = Object.values(result.errors).flat();
            } else if (result && result.message) {
                errorList = [result.message];
            } else {
                errorList = ['Terjadi kesalahan saat menyimpan data proyek (Kode: ' + response.status + ').'];
            }

            const errorHtml = errorList.map(msg => `• ${msg}`).join('<br>');
            document.getElementById('formErrorMessage').innerHTML = errorHtml;
            document.getElementById('formErrorBanner').classList.remove('hidden');
            document.getElementById('portfolioForm').scrollTo({ top: 0, behavior: 'smooth' });
            showToast(errorList[0] || 'Gagal menyimpan data proyek', 'error');
        }
    } catch (err) {
        console.error('Error savePortfolio:', err);
        document.getElementById('formErrorMessage').innerHTML = 'Terjadi kesalahan jaringan atau server saat mengirim data: ' + (err.message || 'Unknown error');
        document.getElementById('formErrorBanner').classList.remove('hidden');
        document.getElementById('portfolioForm').scrollTo({ top: 0, behavior: 'smooth' });
        showToast('Gagal menyimpan data proyek', 'error');
    } finally {
        saveBtnText.textContent = originalText;
    }
}

// 7. Delete Portfolio via AJAX (No Page Reload)
async function deletePortfolio(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus proyek ini secara permanen?')) return;

    try {
        const response = await fetch(`/admin/portfolio/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'X-HTTP-Method-Override': 'DELETE'
            }
        });

        const result = await response.json();

        if (response.ok && result.status === 'success') {
            showToast(result.message, 'success');
            loadPortfolioData();
        } else {
            showToast(result.message || 'Gagal menghapus proyek', 'error');
        }
    } catch (err) {
        showToast('Gagal menghubungkan ke server untuk menghapus data', 'error');
    }
}

// 8. RBTGTech SEO Meter Analysis inside Drawer
function runSeoAnalysis() {
    const title = document.getElementById('title').value.trim();
    const slug = document.getElementById('slug').value.trim();
    const summary = document.getElementById('summary').value.trim();
    const focusKeyword = document.getElementById('focus_keyword').value.trim().toLowerCase();
    const imageUrl = document.getElementById('image_url').value.trim();
    const imageFileInput = document.getElementById('image_file');
    const hasImageFile = imageFileInput && imageFileInput.files && imageFileInput.files.length > 0;
    const previewSrc = document.getElementById('portfolioImagePreview').src || '';
    const hasValidImage = hasImageFile || imageUrl.length > 0 || (previewSrc && !previewSrc.includes('/logo-rbtgtech.png'));

    let score = 30;

    function checkRule(elementId, isPassed, points = 15) {
        const el = document.getElementById(elementId);
        const icon = el.querySelector('span');
        if (isPassed) {
            icon.textContent = 'check_circle';
            icon.className = 'material-symbols-outlined text-[16px] text-emerald-600';
            el.className = 'flex items-center gap-2 text-on-surface font-medium';
            score += points;
        } else {
            icon.textContent = 'cancel';
            icon.className = 'material-symbols-outlined text-[16px] text-rose-500';
            el.className = 'flex items-center gap-2 text-on-surface-variant';
        }
    }

    checkRule('seoRuleTitle', focusKeyword.length > 0 && title.toLowerCase().includes(focusKeyword), 20);
    checkRule('seoRuleSlug', focusKeyword.length > 0 && slug.toLowerCase().includes(focusKeyword.replace(/\s+/g, '-')), 15);
    checkRule('seoRuleDesc', focusKeyword.length > 0 && summary.toLowerCase().includes(focusKeyword), 15);
    checkRule('seoRuleImage', hasValidImage, 20);

    const finalScore = Math.min(100, Math.max(0, score));
    document.getElementById('drawerSeoScore').textContent = finalScore;
    document.getElementById('seoScoreInput').value = finalScore;

    const badge = document.getElementById('drawerSeoBadge');
    if (finalScore >= 80) {
        badge.className = 'flex items-center gap-1.5 px-3 py-1 rounded-full font-bold text-headline-sm border bg-emerald-100 text-emerald-800 border-emerald-300';
    } else if (finalScore >= 50) {
        badge.className = 'flex items-center gap-1.5 px-3 py-1 rounded-full font-bold text-headline-sm border bg-amber-100 text-amber-800 border-amber-300';
    } else {
        badge.className = 'flex items-center gap-1.5 px-3 py-1 rounded-full font-bold text-headline-sm border bg-rose-100 text-rose-800 border-rose-300';
    }
}

// Helper Toast Notification
function showToast(message, type = 'success') {
    const container = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    const isSuccess = type === 'success';

    toast.className = `p-4 rounded-xl shadow-lg border text-body-md flex items-center gap-3 transition-all duration-300 transform translate-y-4 opacity-0 ${
        isSuccess ? 'bg-emerald-900 text-white border-emerald-700' : 'bg-rose-900 text-white border-rose-700'
    }`;

    toast.innerHTML = `
        <span class="material-symbols-outlined text-[20px]">${isSuccess ? 'check_circle' : 'error'}</span>
        <span>${escapeHtml(message)}</span>
    `;

    container.appendChild(toast);

    setTimeout(() => {
        toast.classList.remove('translate-y-4', 'opacity-0');
    }, 10);

    setTimeout(() => {
        toast.classList.add('opacity-0', 'translate-y-4');
        setTimeout(() => toast.remove(), 300);
    }, 3500);
}

function escapeHtml(text) {
    if (!text) return '';
    return String(text)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}
</script>
@endsection
