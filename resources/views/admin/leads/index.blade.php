@extends('layouts.app')

@section('title', 'Prospecting Leads CRM - RBTGTech')

@section('content')
<div class="px-margin-desktop py-lg max-w-[1440px] mx-auto flex flex-col gap-lg" id="spaContainer">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-md">
        <div>
            <h1 class="text-headline-lg font-headline-lg text-on-surface mb-1">Prospecting & Lead CRM</h1>
            <p class="text-body-lg font-body-lg text-on-surface-variant">Cari bisnis di Google Maps, saring yang belum punya website, dan tawarkan jasa web development via WhatsApp.</p>
        </div>
        <div class="flex items-center gap-3">
            <button 
                type="button" 
                onclick="openScrapeDrawer()" 
                class="bg-primary hover:bg-surface-tint text-on-primary font-bold text-label-md px-6 py-2.5 rounded-full flex items-center gap-2 transition-all soft-shadow cursor-pointer"
            >
                <span class="material-symbols-outlined text-[20px]">travel_explore</span>
                Cari Leads Baru
            </button>
        </div>
    </div>

    <!-- Stat KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter">
        <!-- Total Leads -->
        <div class="bg-surface-container-lowest p-5 rounded-2xl border border-outline-variant soft-shadow flex items-center justify-between">
            <div>
                <p class="text-label-sm text-on-surface-variant font-medium">Total Prospek</p>
                <h3 class="text-headline-md font-bold text-on-surface mt-1" id="statTotal">0</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-primary-fixed flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-[24px]">group</span>
            </div>
        </div>

        <!-- No Website -->
        <div class="bg-surface-container-lowest p-5 rounded-2xl border border-outline-variant soft-shadow flex items-center justify-between">
            <div>
                <p class="text-label-sm text-on-surface-variant font-medium">Belum Punya Web</p>
                <h3 class="text-headline-md font-bold text-amber-600 mt-1" id="statNoWebsite">0</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center text-amber-700">
                <span class="material-symbols-outlined text-[24px]">language_javascript</span>
            </div>
        </div>

        <!-- Contacted -->
        <div class="bg-surface-container-lowest p-5 rounded-2xl border border-outline-variant soft-shadow flex items-center justify-between">
            <div>
                <p class="text-label-sm text-on-surface-variant font-medium">Sudah Dihubungi</p>
                <h3 class="text-headline-md font-bold text-blue-600 mt-1" id="statContacted">0</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                <span class="material-symbols-outlined text-[24px]">chat</span>
            </div>
        </div>

        <!-- Deal / Close -->
        <div class="bg-surface-container-lowest p-5 rounded-2xl border border-outline-variant soft-shadow flex items-center justify-between">
            <div>
                <p class="text-label-sm text-on-surface-variant font-medium">Deal (Klien Baru)</p>
                <h3 class="text-headline-md font-bold text-emerald-600 mt-1" id="statDeal">0</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-700">
                <span class="material-symbols-outlined text-[24px]">handshake</span>
            </div>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-surface-container-lowest p-4 rounded-2xl border border-outline-variant soft-shadow flex flex-col md:flex-row gap-4 items-center justify-between">
        <!-- Search query -->
        <div class="relative w-full md:w-80">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">search</span>
            <input 
                type="text" 
                id="searchQuery" 
                oninput="debounceSearch()"
                placeholder="Cari nama cafe, alamat, telepon..." 
                class="w-full pl-10 pr-4 py-2 bg-surface rounded-full border border-outline-variant text-body-md focus:outline-none focus:border-primary transition-colors"
            />
        </div>
        
        <!-- Dropdown filters -->
        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            <!-- Filter Kota -->
            <select id="filterCity" onchange="loadLeads()" class="bg-surface border border-outline-variant text-on-surface px-4 py-2 rounded-full text-label-md outline-none">
                <option value="">Semua Kota</option>
            </select>

            <!-- Filter Website -->
            <select id="filterWebsite" onchange="loadLeads()" class="bg-surface border border-outline-variant text-on-surface px-4 py-2 rounded-full text-label-md outline-none">
                <option value="">Semua Website</option>
                <option value="no_website">Belum Punya Website (Prioritas)</option>
                <option value="has_website">Sudah Punya Website</option>
            </select>

            <!-- Filter Status -->
            <select id="filterStatus" onchange="loadLeads()" class="bg-surface border border-outline-variant text-on-surface px-4 py-2 rounded-full text-label-md outline-none">
                <option value="">Semua Status</option>
                <option value="new">Baru (New)</option>
                <option value="contacted">Sudah Dihubungi (Contacted)</option>
                <option value="interested">Tertarik (Interested)</option>
                <option value="deal">Berhasil Deal (Deal)</option>
                <option value="rejected">Ditolak (Rejected)</option>
            </select>

            <!-- Per Page Limit -->
            <select id="filterPerPage" onchange="currentPage=1; renderLeadsTable(leadsData)" class="bg-surface border border-outline-variant text-on-surface px-4 py-2 rounded-full text-label-md outline-none">
                <option value="10">10 Baris</option>
                <option value="25">25 Baris</option>
                <option value="50">50 Baris</option>
                <option value="100">100 Baris</option>
                <option value="all">Semua</option>
            </select>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant soft-shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low border-b border-outline-variant text-label-md text-on-surface-variant font-semibold">
                        <th class="py-4 px-6 w-[25%] cursor-pointer select-none hover:text-primary transition-colors" onclick="sortBy('name')">
                            <div class="flex items-center gap-1">
                                <span>Nama Bisnis & Rating</span>
                                <span id="sortIcon-name" class="material-symbols-outlined text-[16px]">swap_vert</span>
                            </div>
                        </th>
                        <th class="py-4 px-6 w-[30%] cursor-pointer select-none hover:text-primary transition-colors" onclick="sortBy('address')">
                            <div class="flex items-center gap-1">
                                <span>Alamat</span>
                                <span id="sortIcon-address" class="material-symbols-outlined text-[16px]">swap_vert</span>
                            </div>
                        </th>
                        <th class="py-4 px-6 w-[15%] cursor-pointer select-none hover:text-primary transition-colors" onclick="sortBy('website')">
                            <div class="flex items-center gap-1">
                                <span>Status Website</span>
                                <span id="sortIcon-website" class="material-symbols-outlined text-[16px]">swap_vert</span>
                            </div>
                        </th>
                        <th class="py-4 px-6 w-[15%]">Outreach</th>
                        <th class="py-4 px-6 w-[10%] cursor-pointer select-none hover:text-primary transition-colors" onclick="sortBy('status')">
                            <div class="flex items-center gap-1">
                                <span>CRM Status</span>
                                <span id="sortIcon-status" class="material-symbols-outlined text-[16px]">swap_vert</span>
                            </div>
                        </th>
                        <th class="py-4 px-6 w-[5%] text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody id="leadsListTable" class="divide-y divide-outline-variant/30 text-body-md">
                    <!-- Loading state -->
                    <tr>
                        <td colspan="6" class="py-8 text-center text-on-surface-variant">
                            <div class="flex justify-center items-center gap-2">
                                <span class="material-symbols-outlined animate-spin text-primary">progress_activity</span>
                                <span>Memuat data prospek...</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="tablePagination"></div>
    </div>
</div>

<!-- Drawer 1: Scrape Modal Form -->
<div id="scrapeDrawer" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-xs" onclick="closeScrapeDrawer()"></div>
    <div class="absolute right-0 top-0 bottom-0 w-full max-w-lg bg-surface p-6 overflow-y-auto shadow-2xl flex flex-col justify-between border-l border-outline-variant/40">
        <div>
            <div class="flex items-center justify-between pb-4 mb-6 border-b border-outline-variant">
                <div>
                    <h2 class="text-headline-sm font-bold text-on-surface">Cari Prospek Google Maps</h2>
                    <p class="text-body-sm text-on-surface-variant">Masukkan lokasi dan tipe bisnis untuk ditarik datanya.</p>
                </div>
                <button type="button" onclick="closeScrapeDrawer()" class="p-2 text-on-surface-variant hover:text-on-surface rounded-full hover:bg-surface-container-high transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <form id="scrapeForm" onsubmit="submitScrapeForm(event)" class="space-y-5">
                <div>
                    <label class="block text-label-md font-semibold text-on-surface mb-1">Tipe Bisnis / Kategori <span class="text-rose-500">*</span></label>
                    <input 
                        type="text" 
                        id="scrapeKeyword" 
                        required 
                        placeholder="Contoh: coffee shop, cafe, dental clinic" 
                        class="w-full px-4 py-2.5 rounded-xl bg-white border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none text-body-md"
                    />
                </div>

                <div>
                    <label class="block text-label-md font-semibold text-on-surface mb-1">Kota / Wilayah <span class="text-rose-500">*</span></label>
                    <input 
                        type="text" 
                        id="scrapeCity" 
                        required 
                        placeholder="Contoh: Bandung, Jakarta Selatan, Surabaya" 
                        class="w-full px-4 py-2.5 rounded-xl bg-white border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none text-body-md"
                    />
                </div>

                @if(!env('SERP_API_KEY') || env('SERP_API_KEY') === 'mock')
                <div class="bg-amber-50 border border-amber-200 text-amber-800 p-4 rounded-xl text-body-md flex gap-2.5">
                    <span class="material-symbols-outlined text-amber-600 shrink-0">info</span>
                    <div>
                        <strong class="block mb-0.5 text-label-md">Mode Demo Aktif</strong>
                        <p class="text-xs leading-relaxed">
                            Variabel <code>SERP_API_KEY</code> belum diatur di file <code>.env</code>. Pencarian akan menggunakan data simulasi/mock agar Anda bisa menguji coba alur kerja CRM tanpa API Key.
                        </p>
                    </div>
                </div>
                @endif

                <div class="pt-4 flex justify-end gap-3 border-t border-outline-variant">
                    <button type="button" onclick="closeScrapeDrawer()" class="px-5 py-2.5 rounded-full border border-outline-variant text-on-surface font-semibold hover:bg-surface-container-high transition-colors">
                        Batal
                    </button>
                    <button type="submit" id="btnSubmitScrape" class="px-6 py-2.5 rounded-full bg-primary text-on-primary font-bold hover:bg-surface-tint transition-all shadow-md flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">travel_explore</span>
                        Mulai Cari & Impor
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Drawer 2: Edit Lead Detail & Notes Modal -->
<div id="leadDrawer" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-xs" onclick="closeLeadDrawer()"></div>
    <div class="absolute right-0 top-0 bottom-0 w-full max-w-lg bg-surface p-6 overflow-y-auto shadow-2xl flex flex-col justify-between border-l border-outline-variant/40">
        <div>
            <div class="flex items-center justify-between pb-4 mb-6 border-b border-outline-variant">
                <div>
                    <h2 class="text-headline-sm font-bold text-on-surface" id="leadDrawerTitle">Edit Prospek</h2>
                    <p class="text-body-sm text-on-surface-variant">Update kontak atau tambahkan catatan follow-up.</p>
                </div>
                <button type="button" onclick="closeLeadDrawer()" class="p-2 text-on-surface-variant hover:text-on-surface rounded-full hover:bg-surface-container-high transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <form id="leadForm" onsubmit="submitLeadForm(event)" class="space-y-5">
                <input type="hidden" id="leadId" name="id" />

                <!-- Nama Bisnis (Read-Only) -->
                <div>
                    <label class="block text-label-md font-semibold text-on-surface mb-1">Nama Bisnis</label>
                    <input 
                        type="text" 
                        id="leadName" 
                        disabled 
                        class="w-full px-4 py-2.5 rounded-xl bg-surface-container-low border border-outline-variant outline-none text-body-md text-on-surface-variant cursor-not-allowed"
                    />
                </div>

                <!-- No Telepon -->
                <div>
                    <label class="block text-label-md font-semibold text-on-surface mb-1">No. Telepon / WhatsApp</label>
                    <input 
                        type="text" 
                        id="leadPhone" 
                        name="phone"
                        placeholder="Contoh: 08123456789" 
                        class="w-full px-4 py-2.5 rounded-xl bg-white border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none text-body-md"
                    />
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-label-md font-semibold text-on-surface mb-1">Email</label>
                    <input 
                        type="email" 
                        id="leadEmail" 
                        name="email"
                        placeholder="Contoh: cafe@email.com" 
                        class="w-full px-4 py-2.5 rounded-xl bg-white border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none text-body-md"
                    />
                </div>

                <!-- Website -->
                <div>
                    <label class="block text-label-md font-semibold text-on-surface mb-1">Website URL</label>
                    <input 
                        type="text" 
                        id="leadWebsite" 
                        name="website"
                        placeholder="https://instagram.com/cafe atau kosongkan" 
                        class="w-full px-4 py-2.5 rounded-xl bg-white border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none text-body-md"
                    />
                </div>

                <!-- Status CRM -->
                <div>
                    <label class="block text-label-md font-semibold text-on-surface mb-1">Status Prospek</label>
                    <select id="leadStatus" name="status" class="w-full px-4 py-2.5 rounded-xl bg-white border border-outline-variant focus:border-primary outline-none text-body-md font-semibold">
                        <option value="new">Baru (New)</option>
                        <option value="contacted">Sudah Dihubungi (Contacted)</option>
                        <option value="interested">Tertarik (Interested)</option>
                        <option value="deal">Berhasil Deal (Deal)</option>
                        <option value="rejected">Ditolak (Rejected)</option>
                    </select>
                </div>

                <!-- Notes / Catatan Tindak Lanjut -->
                <div>
                    <label class="block text-label-md font-semibold text-on-surface mb-1">Catatan Tindak Lanjut (Notes)</label>
                    <textarea 
                        id="leadNotes" 
                        name="notes" 
                        rows="5" 
                        placeholder="Tulis riwayat obrolan, penawaran harga, atau jadwal janji temu dengan pemilik..." 
                        class="w-full px-4 py-2.5 rounded-xl bg-white border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none text-body-md resize-none"
                    ></textarea>
                </div>

                <div class="pt-4 flex justify-end gap-3 border-t border-outline-variant">
                    <button type="button" onclick="closeLeadDrawer()" class="px-5 py-2.5 rounded-full border border-outline-variant text-on-surface font-semibold hover:bg-surface-container-high transition-colors">
                        Batal
                    </button>
                    <button type="submit" id="btnSubmitLead" class="px-6 py-2.5 rounded-full bg-primary text-on-primary font-bold hover:bg-surface-tint transition-all shadow-md">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let leadsData = [];
let searchTimeout = null;
let currentPage = 1;
let sortColumn = 'name';
let sortDirection = 'asc';

document.addEventListener('DOMContentLoaded', () => {
    loadLeads();
});

function loadLeads() {
    const search = document.getElementById('searchQuery')?.value || '';
    const status = document.getElementById('filterStatus')?.value || '';
    const websiteFilter = document.getElementById('filterWebsite')?.value || '';
    const city = document.getElementById('filterCity')?.value || '';

    const url = new URL('/admin/leads/data', window.location.origin);
    if (search) url.searchParams.append('search', search);
    if (status) url.searchParams.append('status', status);
    if (websiteFilter) url.searchParams.append('website_filter', websiteFilter);
    if (city) url.searchParams.append('city', city);

    fetch(url)
        .then(res => res.json())
        .then(res => {
            if (res.status === 'success') {
                leadsData = res.data;
                currentPage = 1; // Reset page on new filters/search
                renderLeadsTable(leadsData);
                updateKPIStats(leadsData);
                if (res.cities) {
                    updateCityDropdown(res.cities);
                }
            }
        })
        .catch(err => console.error('Error fetching leads:', err));
}

function sortBy(column) {
    if (sortColumn === column) {
        sortDirection = sortDirection === 'asc' ? 'desc' : 'asc';
    } else {
        sortColumn = column;
        sortDirection = 'asc';
    }
    currentPage = 1;
    renderLeadsTable(leadsData);
}

function goToPage(page) {
    currentPage = page;
    renderLeadsTable(leadsData);
}

function updateSortIcons() {
    const columns = ['name', 'address', 'website', 'status'];
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

function updateCityDropdown(cities) {
    const select = document.getElementById('filterCity');
    if (!select) return;
    const currentValue = select.value;
    
    // Reset but keep "Semua Kota"
    select.innerHTML = '<option value="">Semua Kota</option>';
    
    cities.forEach(c => {
        const option = document.createElement('option');
        option.value = c;
        option.textContent = c;
        if (c === currentValue) {
            option.selected = true;
        }
        select.appendChild(option);
    });
}

function updateKPIStats(data) {
    // Total
    document.getElementById('statTotal').innerText = data.length;
    // No Website
    document.getElementById('statNoWebsite').innerText = data.filter(l => !l.has_website).length;
    // Contacted
    document.getElementById('statContacted').innerText = data.filter(l => ['contacted', 'interested'].includes(l.status)).length;
    // Deal
    document.getElementById('statDeal').innerText = data.filter(l => l.status === 'deal').length;
}

function renderLeadsTable(items) {
    const tbody = document.getElementById('leadsListTable');
    updateSortIcons();
    
    if (!items || items.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="py-12 text-center text-on-surface-variant font-medium">
                    Belum ada data prospek. Klik tombol <strong>"Cari Leads Baru"</strong> untuk mencari dari Google Maps.
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

    let html = '';
    paginatedItems.forEach(l => {
        // Rating calculation
        let ratingHtml = '';
        if (l.rating) {
            ratingHtml = `
                <div class="flex items-center gap-1 mt-0.5">
                    <span class="material-symbols-outlined text-[16px] text-amber-500 fill-1">star</span>
                    <span class="text-label-sm text-on-surface font-semibold">${l.rating}</span>
                    <span class="text-[11px] text-on-surface-variant font-medium">(${l.user_ratings_total})</span>
                </div>
            `;
        } else {
            ratingHtml = `<span class="text-[11px] text-on-surface-variant">Belum ada review</span>`;
        }

        // Website rendering
        let websiteHtml = '';
        if (!l.website) {
            websiteHtml = `
                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] bg-red-100 text-red-800 font-bold">
                    <span class="material-symbols-outlined text-[13px]">language</span> Tanpa Web
                </span>
            `;
        } else if (!l.has_website) {
            // Instagram / Social link only
            let typeLabel = 'Medsos Saja';
            if (l.website.includes('instagram.com')) typeLabel = 'Instagram';
            else if (l.website.includes('linktr.ee')) typeLabel = 'Linktree';
            else if (l.website.includes('facebook.com')) typeLabel = 'Facebook';

            websiteHtml = `
                <div class="flex flex-col gap-1 items-start">
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] bg-amber-100 text-amber-800 font-bold">
                        <span class="material-symbols-outlined text-[13px]">link</span> ${typeLabel}
                    </span>
                    <a href="${escapeHtml(l.website)}" target="_blank" class="text-label-sm text-primary hover:underline font-semibold truncate max-w-[120px]">${escapeHtml(l.website)}</a>
                </div>
            `;
        } else {
            websiteHtml = `
                <div class="flex flex-col gap-1 items-start">
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] bg-emerald-100 text-emerald-800 font-bold">
                        <span class="material-symbols-outlined text-[13px]">public</span> Ada Website
                    </span>
                    <a href="${escapeHtml(l.website)}" target="_blank" class="text-label-sm text-primary hover:underline font-semibold truncate max-w-[120px]">${escapeHtml(l.website)}</a>
                </div>
            `;
        }

        // WhatsApp & Email Outreach
        let phoneHtml = '';
        let waButtonHtml = '';
        let emailHtml = '';

        if (l.wa_phone_number) {
            const encodedText = encodeURIComponent(getWhatsAppTemplate(l.name));
            const waUrl = `https://wa.me/${l.wa_phone_number}?text=${encodedText}`;
            
            waButtonHtml = `
                <a 
                    href="${waUrl}" 
                    target="_blank" 
                    onclick="updateStatusDirectly(${l.id}, 'contacted')"
                    class="inline-flex items-center gap-1 bg-[#25D366] hover:bg-[#20ba59] text-white text-[11px] font-bold px-2.5 py-1 rounded-full shadow-sm transition-all hover:scale-105 active:scale-95"
                >
                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                        <path d="M12.012 2c-5.506 0-9.989 4.478-9.99 9.984a9.96 9.96 0 001.33 4.982L2 22l5.164-1.354a9.938 9.938 0 004.846 1.254h.004c5.507 0 9.99-4.474 9.99-9.986 0-2.67-1.037-5.18-2.92-7.062A9.925 9.925 0 0012.012 2zm5.859 14.14c-.252.712-1.463 1.307-2.01 1.352-.497.04-1.147.06-2.532-.496-5.466-2.193-8.89-7.712-9.162-8.08-.273-.368-2.222-2.962-2.222-5.65 0-2.687 1.378-4.01 1.87-4.563.49-.554.81-.692 1.084-.692.274 0 .548.01.787.018.246.008.577-.093.901.693.332.805 1.134 2.766 1.233 2.964.099.198.166.429.034.693-.133.264-.265.43-.53.727-.266.297-.557.66-.797.884-.262.247-.534.516-.23 1.038.304.521 1.352 2.224 2.909 3.613 2.003 1.788 3.687 2.34 4.202 2.593.515.253.818.211 1.127-.148.309-.36 1.332-1.547 1.688-2.075.357-.528.712-.442 1.202-.26 1.488.552 2.453 1.22 2.68 1.42.227.198.227.3.113.495-.114.198-.567.89-.82 1.603z"/>
                    </svg>
                    WhatsApp
                </a>
            `;
        } else {
            waButtonHtml = `<span class="text-on-surface-variant text-[11px] font-medium italic">No WA: -</span>`;
        }

        if (l.email) {
            const subject = encodeURIComponent(`Penawaran Kerja Sama Pembuatan Website - RBTGTech`);
            const emailBody = encodeURIComponent(getEmailTemplate(l.name));
            const mailtoUrl = `mailto:${l.email}?subject=${subject}&body=${emailBody}`;
            
            emailHtml = `
                <a 
                    href="${mailtoUrl}" 
                    target="_blank" 
                    onclick="updateStatusDirectly(${l.id}, 'contacted')"
                    class="inline-flex items-center gap-1 bg-[#4f46e5] hover:bg-[#4338ca] text-white text-[11px] font-bold px-2.5 py-1 rounded-full shadow-sm transition-all hover:scale-105 active:scale-95"
                >
                    <span class="material-symbols-outlined text-[13px]">mail</span>
                    Email
                </a>
            `;
        } else {
            emailHtml = `
                <button 
                    type="button" 
                    onclick="editLead(${l.id})"
                    class="inline-flex items-center gap-1 text-on-surface-variant/70 hover:text-primary transition-colors text-[11px] font-bold py-1"
                >
                    <span class="material-symbols-outlined text-[13px]">add_circle</span> Email
                </button>
            `;
        }

        phoneHtml = `
            <div class="flex flex-col gap-2 items-start w-full">
                <div class="flex flex-col gap-0.5 text-label-sm">
                    ${l.phone ? `<span class="font-semibold text-on-surface font-mono">${escapeHtml(l.phone)}</span>` : ''}
                    ${l.email ? `<span class="text-on-surface-variant font-mono truncate max-w-[170px]" title="${escapeHtml(l.email)}">${escapeHtml(l.email)}</span>` : ''}
                </div>
                <div class="flex flex-wrap gap-1.5 items-center w-full">
                    ${waButtonHtml}
                    ${emailHtml}
                </div>
            </div>
        `;

        // Status Badge Selector
        let statusClass = '';
        let statusText = '';
        switch(l.status) {
            case 'new':
                statusClass = 'bg-surface-container-high text-on-surface';
                statusText = 'Baru (New)';
                break;
            case 'contacted':
                statusClass = 'bg-blue-100 text-blue-800';
                statusText = 'Dihubungi';
                break;
            case 'interested':
                statusClass = 'bg-amber-100 text-amber-800';
                statusText = 'Tertarik';
                break;
            case 'deal':
                statusClass = 'bg-emerald-100 text-emerald-800';
                statusText = 'Deal 🎉';
                break;
            case 'rejected':
                statusClass = 'bg-red-100 text-red-800';
                statusText = 'Ditolak';
                break;
        }

        const statusSelectHtml = `
            <div class="relative inline-block text-left">
                <select 
                    onchange="changeLeadStatus(${l.id}, this.value)" 
                    class="px-2.5 py-1 rounded-full text-label-sm font-bold outline-none cursor-pointer border-0 ${statusClass}"
                >
                    <option value="new" ${l.status === 'new' ? 'selected' : ''}>Baru (New)</option>
                    <option value="contacted" ${l.status === 'contacted' ? 'selected' : ''}>Dihubungi</option>
                    <option value="interested" ${l.status === 'interested' ? 'selected' : ''}>Tertarik</option>
                    <option value="deal" ${l.status === 'deal' ? 'selected' : ''}>Deal</option>
                    <option value="rejected" ${l.status === 'rejected' ? 'selected' : ''}>Ditolak</option>
                </select>
            </div>
        `;

        html += `
            <tr class="hover:bg-surface-container-low/50 transition-colors">
                <!-- Name & Rating -->
                <td class="py-4 px-6 align-top">
                    <div class="font-bold text-on-surface text-body-lg flex items-center gap-1.5 flex-wrap font-headline-sm">
                        ${l.maps_url 
                            ? `<a href="${escapeHtml(l.maps_url)}" target="_blank" class="hover:text-primary hover:underline transition-colors flex items-center gap-1">
                                   <span>${escapeHtml(l.name)}</span>
                                   <span class="material-symbols-outlined text-[16px] text-on-surface-variant">open_in_new</span>
                               </a>` 
                            : `<span>${escapeHtml(l.name)}</span>`
                        }
                        ${l.city ? `<span class="px-2 py-0.5 rounded-full text-[10px] bg-surface-container-high text-on-surface font-semibold">${escapeHtml(l.city)}</span>` : ''}
                    </div>
                    ${ratingHtml}
                </td>

                <!-- Address -->
                <td class="py-4 px-6 align-top text-on-surface-variant text-label-md">
                    <div class="line-clamp-2 text-body-md font-body-md" title="${escapeHtml(l.address || '-')}">
                        ${escapeHtml(l.address || '-')}
                    </div>
                </td>

                <!-- Website -->
                <td class="py-4 px-6 align-top">
                    ${websiteHtml}
                </td>

                <!-- Outreach WA -->
                <td class="py-4 px-6 align-top">
                    ${phoneHtml}
                </td>

                <!-- CRM Status -->
                <td class="py-4 px-6 align-top">
                    ${statusSelectHtml}
                </td>

                <!-- Action buttons -->
                <td class="py-4 px-6 align-top text-right space-x-1 whitespace-nowrap">
                    <button type="button" onclick="editLead(${l.id})" class="p-1.5 text-primary hover:bg-primary/10 rounded-lg transition-colors" title="Edit Catatan Prospek">
                        <span class="material-symbols-outlined text-[20px]">edit_note</span>
                    </button>
                    <button type="button" onclick="deleteLead(${l.id})" class="p-1.5 text-error hover:bg-error/10 rounded-lg transition-colors" title="Hapus Prospek">
                        <span class="material-symbols-outlined text-[20px]">delete</span>
                    </button>
                </td>
            </tr>
        `;
    });
    tbody.innerHTML = html;

    rbtgTable.renderPagination('tablePagination', items.length, currentPage, perPageVal, 'goToPage');
}

// Scrape Drawer
function openScrapeDrawer() {
    document.getElementById('scrapeKeyword').value = '';
    document.getElementById('scrapeCity').value = '';
    document.getElementById('scrapeDrawer').classList.remove('hidden');
}
function closeScrapeDrawer() {
    document.getElementById('scrapeDrawer').classList.add('hidden');
}

function submitScrapeForm(e) {
    e.preventDefault();
    const keyword = document.getElementById('scrapeKeyword').value;
    const city = document.getElementById('scrapeCity').value;
    const btn = document.getElementById('btnSubmitScrape');

    btn.disabled = true;
    btn.innerHTML = `<span class="material-symbols-outlined animate-spin text-[18px]">progress_activity</span> Mencari Leads...`;

    fetch('/admin/leads/scrape', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ keyword: keyword, city: city })
    })
    .then(res => res.json())
    .then(res => {
        btn.disabled = false;
        btn.innerHTML = `<span class="material-symbols-outlined text-[18px]">travel_explore</span> Mulai Cari & Impor`;
        
        if (res.status === 'success') {
            alert(res.message);
            closeScrapeDrawer();
            loadLeads();
        } else {
            alert('Gagal mencari leads: ' + (res.message || 'Terjadi kesalahan'));
        }
    })
    .catch(err => {
        btn.disabled = false;
        btn.innerHTML = `<span class="material-symbols-outlined text-[18px]">travel_explore</span> Mulai Cari & Impor`;
        alert('Terjadi kesalahan jaringan');
    });
}

// Edit Lead Drawer
function openLeadDrawer() {
    document.getElementById('leadDrawer').classList.remove('hidden');
}
function closeLeadDrawer() {
    document.getElementById('leadDrawer').classList.add('hidden');
}

function editLead(id) {
    const lead = leadsData.find(l => l.id === id);
    if (!lead) return;

    document.getElementById('leadId').value = lead.id;
    document.getElementById('leadName').value = lead.name;
    document.getElementById('leadPhone').value = lead.phone || '';
    document.getElementById('leadEmail').value = lead.email || '';
    document.getElementById('leadWebsite').value = lead.website || '';
    document.getElementById('leadStatus').value = lead.status;
    document.getElementById('leadNotes').value = lead.notes || '';

    document.getElementById('leadDrawerTitle').innerText = 'Kelola Prospek: ' + lead.name;
    openLeadDrawer();
}

function submitLeadForm(e) {
    e.preventDefault();
    const id = document.getElementById('leadId').value;
    const btn = document.getElementById('btnSubmitLead');

    btn.disabled = true;
    btn.innerText = 'Menyimpan...';

    const payload = {
        phone: document.getElementById('leadPhone').value,
        email: document.getElementById('leadEmail').value,
        website: document.getElementById('leadWebsite').value,
        status: document.getElementById('leadStatus').value,
        notes: document.getElementById('leadNotes').value,
    };

    fetch(`/admin/leads/${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify(payload)
    })
    .then(res => res.json())
    .then(res => {
        btn.disabled = false;
        btn.innerText = 'Simpan Perubahan';
        if (res.status === 'success') {
            closeLeadDrawer();
            loadLeads();
        } else {
            alert('Gagal memperbarui prospek');
        }
    })
    .catch(err => {
        btn.disabled = false;
        btn.innerText = 'Simpan Perubahan';
        alert('Terjadi kesalahan jaringan');
    });
}

// Change status directly in table row
function changeLeadStatus(id, newStatus) {
    fetch(`/admin/leads/${id}/status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ status: newStatus })
    })
    .then(res => res.json())
    .then(res => {
        if (res.status === 'success') {
            loadLeads();
        } else {
            alert('Gagal memperbarui status');
        }
    });
}

// Direct change to contacted when Clicking WA Button
function updateStatusDirectly(id, status) {
    // Just a fast fire-and-forget state change to 'contacted'
    fetch(`/admin/leads/${id}/status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ status: status })
    })
    .then(() => {
        // Reload leads to reflect status change in table
        setTimeout(loadLeads, 1000);
    });
}

function deleteLead(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus prospek ini dari CRM?')) return;

    fetch(`/admin/leads/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(res => {
        if (res.status === 'success') {
            loadLeads();
        }
    });
}

function debounceSearch() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        loadLeads();
    }, 300);
}

function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/[&<>"']/g, function(m) {
        return {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        }[m];
    });
}

// Pre-defined cold outreach template message
function getWhatsAppTemplate(businessName) {
    return `Halo Kak, perkenalkan kami dari tim *RBTGTech* (rbtgtech.com). Kami sempat melihat profil *${businessName}* di Google Maps dan kami sangat mengapresiasi reputasi baik bisnis/layanan Anda! 😊

Kami perhatikan saat ini *${businessName}* belum mencantumkan website resmi. Di era digital sekarang, memiliki website profil/layanan sangat membantu meningkatkan kredibilitas di mata calon pelanggan, memudahkan mereka melihat informasi produk/jasa, serta mengarahkan pemesanan/reservasi langsung ke WhatsApp.

Kebetulan kami memiliki program pembuatan website profil bisnis (Company Profile) profesional & cepat dengan penawaran menarik. Jika berminat atau sekadar ingin berkonsultasi santai, kami siap membantu. Terima kasih banyak ya Kak!`;
}

function getEmailTemplate(businessName) {
    return `Yth. Pemilik/Pengelola ${businessName},

Perkenalkan, kami dari tim RBTGTech (rbtgtech.com), penyedia jasa pembuatan website & solusi sistem digital profesional untuk profil bisnis dan UMKM.

Kami sempat mengunjungi profil ${businessName} di Google Maps & sangat mengapresiasi reputasi bisnis/layanan Anda yang sangat baik. Kami melihat potensi besar bagi ${businessName} untuk menjangkau lebih banyak klien/pelanggan baru dengan memiliki website resmi tersendiri.

Dengan memiliki website resmi, ${businessName} dapat:
1. Mempermudah pelanggan melihat daftar layanan, jadwal operasional, dan lokasi.
2. Meningkatkan kepercayaan publik dan kredibilitas profesional bisnis Anda di internet.
3. Memudahkan calon pelanggan melakukan kontak langsung atau mengajukan reservasi secara instan.

Saat ini kami memiliki paket pembuatan website premium khusus profil bisnis yang ramah di kantong dengan performa tinggi & ramah SEO.

Jika Bapak/Ibu berminat atau ingin melihat portofolio/demo desain kami, silakan balas email ini atau hubungi kami melalui WhatsApp. Kami dengan senang hati akan membantu berdiskusi santai.

Terima kasih atas waktu dan perhatiannya. Sukses selalu untuk ${businessName}!

Salam hangat,
Tim RBTGTech
Website: https://rbtgtech.com`;
}
</script>
@endsection
