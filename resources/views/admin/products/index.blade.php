@extends('layouts.app')

@section('title', 'Master Produk & Solusi - RBTGTech')

@section('content')
<div class="px-margin-desktop py-lg max-w-[1440px] mx-auto flex flex-col gap-lg" id="spaContainer">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-md">
        <div>
            <h1 class="text-headline-lg font-headline-lg text-on-surface mb-1">Produk Digital & Solusi</h1>
            <p class="text-body-lg font-body-lg text-on-surface-variant">Kelola katalog produk siap pakai (SaaS, ESB, SIM Sekolah) lengkap dengan modul & link demo.</p>
        </div>
        <button 
            type="button" 
            onclick="openProductDrawer()" 
            class="bg-primary hover:bg-surface-tint text-on-primary font-bold text-label-md px-6 py-2.5 rounded-full flex items-center gap-2 transition-all soft-shadow self-start md:self-auto cursor-pointer"
        >
            <span class="material-symbols-outlined text-[20px]">add</span>
            Tambah Produk Baru
        </button>
    </div>

    <!-- Stat KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-gutter">
        <div class="bg-surface-container-lowest p-5 rounded-2xl border border-outline-variant soft-shadow flex items-center justify-between">
            <div>
                <p class="text-label-sm text-on-surface-variant font-medium">Total Produk</p>
                <h3 class="text-headline-md font-bold text-on-surface mt-1" id="statTotal">0</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-primary-fixed flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-[24px]">inventory_2</span>
            </div>
        </div>

        <div class="bg-surface-container-lowest p-5 rounded-2xl border border-outline-variant soft-shadow flex items-center justify-between">
            <div>
                <p class="text-label-sm text-on-surface-variant font-medium">Terpublikasi di Website</p>
                <h3 class="text-headline-md font-bold text-emerald-600 mt-1" id="statPublished">0</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-700">
                <span class="material-symbols-outlined text-[24px]">verified</span>
            </div>
        </div>

        <div class="bg-surface-container-lowest p-5 rounded-2xl border border-outline-variant soft-shadow flex items-center justify-between">
            <div>
                <p class="text-label-sm text-on-surface-variant font-medium">Memiliki Live Demo</p>
                <h3 class="text-headline-md font-bold text-primary mt-1" id="statDemo">0</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-primary-container/30 flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-[24px]">devices</span>
            </div>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-surface-container-lowest p-4 rounded-2xl border border-outline-variant soft-shadow flex flex-col md:flex-row gap-4 items-center justify-between">
        <div class="relative w-full md:w-96">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">search</span>
            <input 
                type="text" 
                id="searchQuery" 
                oninput="debounceSearch()"
                placeholder="Cari nama produk, tagline, atau kata kunci..." 
                class="w-full pl-10 pr-4 py-2 bg-surface rounded-full border border-outline-variant text-body-md focus:outline-none focus:border-primary transition-colors"
            />
        </div>
        <div class="flex items-center gap-3 w-full md:w-auto">
            <!-- Filter Status -->
            <select id="filterStatus" onchange="loadProducts()" class="bg-surface border border-outline-variant text-on-surface px-4 py-2 rounded-full text-label-md outline-none">
                <option value="">Semua Status</option>
                <option value="published">Terpublikasi (Published)</option>
                <option value="coming_soon">Segera Hadir (Coming Soon)</option>
                <option value="in_development">Pengembangan (In Dev)</option>
                <option value="draft">Draft</option>
            </select>

            <!-- Per Page Limit -->
            <select id="filterPerPage" onchange="currentPage=1; renderProductsTable(productsData)" class="bg-surface border border-outline-variant text-on-surface px-4 py-2 rounded-full text-label-md outline-none">
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
                        <th class="py-4 px-6 cursor-pointer select-none hover:text-primary transition-colors" onclick="sortBy('title')">
                            <div class="flex items-center gap-1">
                                <span>Produk & Tagline</span>
                                <span id="sortIcon-title" class="material-symbols-outlined text-[16px]">swap_vert</span>
                            </div>
                        </th>
                        <th class="py-4 px-6 cursor-pointer select-none hover:text-primary transition-colors" onclick="sortBy('category')">
                            <div class="flex items-center gap-1">
                                <span>Kategori</span>
                                <span id="sortIcon-category" class="material-symbols-outlined text-[16px]">swap_vert</span>
                            </div>
                        </th>
                        <th class="py-4 px-6 cursor-pointer select-none hover:text-primary transition-colors" onclick="sortBy('price_label')">
                            <div class="flex items-center gap-1">
                                <span>Label Harga</span>
                                <span id="sortIcon-price_label" class="material-symbols-outlined text-[16px]">swap_vert</span>
                            </div>
                        </th>
                        <th class="py-4 px-6 cursor-pointer select-none hover:text-primary transition-colors" onclick="sortBy('demo_url')">
                            <div class="flex items-center gap-1">
                                <span>Live Demo</span>
                                <span id="sortIcon-demo_url" class="material-symbols-outlined text-[16px]">swap_vert</span>
                            </div>
                        </th>
                        <th class="py-4 px-6 cursor-pointer select-none hover:text-primary transition-colors" onclick="sortBy('status')">
                            <div class="flex items-center gap-1">
                                <span>Status</span>
                                <span id="sortIcon-status" class="material-symbols-outlined text-[16px]">swap_vert</span>
                            </div>
                        </th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody id="productListTable" class="divide-y divide-outline-variant/30 text-body-md">
                    <!-- Loading state -->
                    <tr>
                        <td colspan="6" class="py-8 text-center text-on-surface-variant">
                            <div class="flex justify-center items-center gap-2">
                                <span class="material-symbols-outlined animate-spin text-primary">progress_activity</span>
                                <span>Memuat data produk...</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="tablePagination"></div>
    </div>
</div>

<!-- Drawer / Modal Form -->
<div id="productDrawer" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-xs" onclick="closeProductDrawer()"></div>
    <div class="absolute right-0 top-0 bottom-0 w-full max-w-2xl bg-surface p-6 overflow-y-auto shadow-2xl flex flex-col justify-between border-l border-outline-variant/40">
        <div>
            <div class="flex items-center justify-between pb-4 mb-6 border-b border-outline-variant">
                <div>
                    <h2 class="text-headline-sm font-bold text-on-surface" id="drawerTitle">Tambah Produk Baru</h2>
                    <p class="text-body-sm text-on-surface-variant">Lengkapi detail sistem digital untuk dipublikasikan.</p>
                </div>
                <button type="button" onclick="closeProductDrawer()" class="p-2 text-on-surface-variant hover:text-on-surface rounded-full hover:bg-surface-container-high transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <form id="productForm" onsubmit="submitProductForm(event)" enctype="multipart/form-data" class="space-y-5">
                <input type="hidden" id="productId" name="id" />

                <!-- Nama Produk -->
                <div>
                    <label class="block text-label-md font-semibold text-on-surface mb-1">Nama Produk <span class="text-rose-500">*</span></label>
                    <input 
                        type="text" 
                        id="formTitle" 
                        name="title" 
                        required 
                        oninput="generateSlug(this.value)"
                        placeholder="Contoh: ESB Resto & POS System" 
                        class="w-full px-4 py-2.5 rounded-xl bg-white border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none text-body-md"
                    />
                </div>

                <!-- Slug -->
                <div>
                    <label class="block text-label-md font-semibold text-on-surface mb-1">Slug URL <span class="text-rose-500">*</span></label>
                    <input 
                        type="text" 
                        id="formSlug" 
                        name="slug" 
                        required 
                        placeholder="esb-resto-pos-system" 
                        class="w-full px-4 py-2.5 rounded-xl bg-white border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none text-body-md font-mono"
                    />
                </div>

                <!-- Kategori & Label Harga -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-label-md font-semibold text-on-surface mb-1">Kategori Produk</label>
                        <input 
                            type="text" 
                            id="formCategory" 
                            name="category" 
                            placeholder="Contoh: F&B / Resto, Pendidikan, Enterprise" 
                            class="w-full px-4 py-2.5 rounded-xl bg-white border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none text-body-md"
                        />
                    </div>
                    <div>
                        <label class="block text-label-md font-semibold text-on-surface mb-1">Label Harga / Lisensi</label>
                        <input 
                            type="text" 
                            id="formPriceLabel" 
                            name="price_label" 
                            placeholder="Contoh: Mulai Rp 2.500.000 / Lisensi" 
                            class="w-full px-4 py-2.5 rounded-xl bg-white border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none text-body-md"
                        />
                    </div>
                </div>

                <!-- Tagline -->
                <div>
                    <label class="block text-label-md font-semibold text-on-surface mb-1">Tagline Singkat</label>
                    <input 
                        type="text" 
                        id="formTagline" 
                        name="tagline" 
                        placeholder="Contoh: Sistem Manajemen Resto & Kasir Cloud All-in-One" 
                        class="w-full px-4 py-2.5 rounded-xl bg-white border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none text-body-md"
                    />
                </div>

                <!-- Ringkasan Singkat -->
                <div>
                    <label class="block text-label-md font-semibold text-on-surface mb-1">Ringkasan Singkat</label>
                    <textarea 
                        id="formSummary" 
                        name="summary" 
                        rows="2" 
                        placeholder="Penjelasan ringkas mengenai solusi produk ini..." 
                        class="w-full px-4 py-2.5 rounded-xl bg-white border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none text-body-md resize-none"
                    ></textarea>
                </div>

                <!-- Deskripsi Lengkap -->
                <div>
                    <label class="block text-label-md font-semibold text-on-surface mb-1">Deskripsi Lengkap</label>
                    <textarea 
                        id="formDescription" 
                        name="description" 
                        rows="4" 
                        placeholder="Penjelasan fitur unggulan, arsitektur, dan cara kerja sistem..." 
                        class="w-full px-4 py-2.5 rounded-xl bg-white border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none text-body-md resize-none"
                    ></textarea>
                </div>

                <!-- Fitur Utama (Pisahkan dengan Koma / Baris Baru) -->
                <div>
                    <label class="block text-label-md font-semibold text-on-surface mb-1">Modul / Fitur Utama (Satu per baris)</label>
                    <textarea 
                        id="formFeaturesText" 
                        rows="3" 
                        placeholder="Kasir POS Multi-outlet&#10;Manajemen Stok & Bahan Baku&#10;Laporan Penjualan Real-time&#10;Integrasi QRIS Payment" 
                        class="w-full px-4 py-2.5 rounded-xl bg-white border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none text-body-md resize-none font-mono text-sm"
                    ></textarea>
                </div>

                <!-- Teknologi / Tech Stack -->
                <div>
                    <label class="block text-label-md font-semibold text-on-surface mb-1">Teknologi / Tech Stack (Satu per baris)</label>
                    <textarea 
                        id="formTechStackText" 
                        rows="2" 
                        placeholder="Laravel&#10;Astro&#10;Tailwind CSS" 
                        class="w-full px-4 py-2.5 rounded-xl bg-white border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none text-body-md resize-none font-mono text-sm"
                    ></textarea>
                </div>

                <!-- URL Live Demo -->
                <div>
                    <label class="block text-label-md font-semibold text-on-surface mb-1">URL Live Demo</label>
                    <input 
                        type="url" 
                        id="formDemoUrl" 
                        name="demo_url" 
                        placeholder="https://demo-resto.rbtgtech.com" 
                        class="w-full px-4 py-2.5 rounded-xl bg-white border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none text-body-md"
                    />
                </div>

                <!-- Gambar Unggulan (Featured Image) Upload & Preview -->
                <div class="space-y-2">
                    <label class="block text-label-md font-semibold text-on-surface">Gambar Unggulan Produk (Featured Image)</label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-center">
                        <!-- Preview Box -->
                        <div class="relative group rounded-xl overflow-hidden border border-outline-variant bg-surface-container-low aspect-video flex items-center justify-center shadow-inner">
                            <img id="productImagePreview" src="/logo-rbtgtech.png" alt="Preview Gambar" class="w-full h-full object-cover transition-transform group-hover:scale-105" onerror="this.src='/logo-rbtgtech.png'" />
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white text-xs font-bold pointer-events-none">
                                Pratinjau
                            </div>
                        </div>

                        <!-- Upload Zone & Direct URL -->
                        <div class="sm:col-span-2 space-y-3">
                            <div class="border-2 border-dashed border-outline-variant hover:border-primary rounded-xl p-4 text-center cursor-pointer transition-colors bg-surface-container-low hover:bg-surface-container" onclick="document.getElementById('product_image_file').click()">
                                <input type="file" id="product_image_file" name="image_file" accept="image/*" class="hidden" onchange="previewProductImage(this)" />
                                <span class="material-symbols-outlined text-[28px] text-primary block mb-1">cloud_upload</span>
                                <p class="text-label-md font-bold text-on-surface">Pilih / Upload File Gambar</p>
                                <p class="text-xs text-on-surface-variant mt-0.5">Format: JPG, PNG, WEBP, SVG (Maks. 5MB). Otomatis tersimpan ke <code class="bg-surface-container px-1 py-0.5 rounded text-primary font-mono text-[11px]">storage/products/</code></p>
                            </div>

                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-on-surface-variant uppercase shrink-0">Atau URL:</span>
                                <input 
                                    type="text" 
                                    id="formImageUrl" 
                                    name="image_url" 
                                    placeholder="/logo-rbtgtech.png atau URL eksternal" 
                                    oninput="document.getElementById('productImagePreview').src = this.value || '/logo-rbtgtech.png'" 
                                    class="flex-1 bg-white border border-outline-variant rounded-xl p-2.5 text-xs text-on-surface focus:border-primary outline-none"
                                />
                                <button type="button" onclick="resetProductImage()" class="px-2.5 py-2 text-xs font-bold text-on-surface-variant hover:text-error bg-surface-container-high rounded-lg transition-colors shrink-0" title="Reset ke Logo Default">
                                    Reset
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status & Urutan -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-label-md font-semibold text-on-surface mb-1">Status Publikasi</label>
                        <select id="formStatus" name="status" class="w-full px-4 py-2.5 rounded-xl bg-white border border-outline-variant focus:border-primary outline-none text-body-md font-semibold">
                            <option value="published">Terpublikasi (Published)</option>
                            <option value="coming_soon">Segera Hadir (Coming Soon)</option>
                            <option value="in_development">Pengembangan (In Dev)</option>
                            <option value="draft">Draft (Disembunyikan)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-label-md font-semibold text-on-surface mb-1">Urutan Tampilan (Sort Order)</label>
                        <input 
                            type="number" 
                            id="formSortOrder" 
                            name="sort_order" 
                            value="0" 
                            class="w-full px-4 py-2.5 rounded-xl bg-white border border-outline-variant focus:border-primary outline-none text-body-md"
                        />
                    </div>
                </div>

                <div class="pt-4 flex justify-end gap-3 border-t border-outline-variant">
                    <button type="button" onclick="closeProductDrawer()" class="px-5 py-2.5 rounded-full border border-outline-variant text-on-surface font-semibold hover:bg-surface-container-high transition-colors">
                        Batal
                    </button>
                    <button type="submit" id="btnSubmitForm" class="px-6 py-2.5 rounded-full bg-primary text-on-primary font-bold hover:bg-surface-tint transition-all shadow-md">
                        Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let productsData = [];
let searchTimeout = null;
let currentPage = 1;
let sortColumn = 'sort_order';
let sortDirection = 'asc';

document.addEventListener('DOMContentLoaded', () => {
    loadProducts();
});

function loadProducts() {
    const search = document.getElementById('searchQuery')?.value || '';
    const status = document.getElementById('filterStatus')?.value || '';

    const url = new URL('/admin/products/data', window.location.origin);
    if (search) url.searchParams.append('search', search);
    if (status) url.searchParams.append('status', status);

    fetch(url)
        .then(res => res.json())
        .then(res => {
            if (res.status === 'success') {
                productsData = res.data;
                currentPage = 1; // Reset to page 1 on filter/search
                renderProductsTable(productsData);
                updateKPIStats(productsData);
            }
        })
        .catch(err => console.error('Error fetching products:', err));
}

function updateKPIStats(data) {
    document.getElementById('statTotal').innerText = data.length;
    document.getElementById('statPublished').innerText = data.filter(p => p.status === 'published').length;
    document.getElementById('statDemo').innerText = data.filter(p => p.demo_url && p.demo_url.trim() !== '').length;
}

function sortBy(column) {
    if (sortColumn === column) {
        sortDirection = sortDirection === 'asc' ? 'desc' : 'asc';
    } else {
        sortColumn = column;
        sortDirection = 'asc';
    }
    currentPage = 1;
    renderProductsTable(productsData);
}

function goToPage(page) {
    currentPage = page;
    renderProductsTable(productsData);
}

function updateSortIcons() {
    const columns = ['title', 'category', 'price_label', 'demo_url', 'status'];
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

function renderProductsTable(items) {
    const tbody = document.getElementById('productListTable');
    updateSortIcons();

    if (!items || items.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="py-12 text-center text-on-surface-variant font-medium">
                    Belum ada data produk. Klik tombol <strong>"Tambah Produk Baru"</strong> di atas.
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
    paginatedItems.forEach(p => {
        let statusBadge = '';
        if (p.status === 'published') {
            statusBadge = `<span class="inline-flex items-center gap-1 text-emerald-700 bg-emerald-100 px-3 py-1 rounded-full text-label-sm font-bold"><span class="material-symbols-outlined text-[14px]">check_circle</span> Published</span>`;
        } else if (p.status === 'coming_soon') {
            statusBadge = `<span class="inline-flex items-center gap-1 text-sky-700 bg-sky-100 px-3 py-1 rounded-full text-label-sm font-bold"><span class="material-symbols-outlined text-[14px]">rocket_launch</span> Coming Soon</span>`;
        } else if (p.status === 'in_development') {
            statusBadge = `<span class="inline-flex items-center gap-1 text-indigo-700 bg-indigo-100 px-3 py-1 rounded-full text-label-sm font-bold"><span class="material-symbols-outlined text-[14px]">engineering</span> In Dev</span>`;
        } else {
            statusBadge = `<span class="inline-flex items-center gap-1 text-amber-700 bg-amber-100 px-3 py-1 rounded-full text-label-sm font-bold"><span class="material-symbols-outlined text-[14px]">edit_note</span> Draft</span>`;
        }
        
        html += `
            <tr class="hover:bg-surface-container-low/50 transition-colors">
                <td class="py-4 px-6">
                    <div class="flex items-center gap-3">
                        <img src="${escapeHtml(p.image_url || '/logo-rbtgtech.png')}" alt="" class="w-14 h-10 object-cover rounded-lg border border-outline-variant bg-surface-container-low shrink-0 shadow-xs" onerror="this.src='/logo-rbtgtech.png'" />
                        <div class="min-w-0">
                            <div class="font-bold text-on-surface text-body-lg">${escapeHtml(p.title)}</div>
                            <div class="text-label-sm text-on-surface-variant truncate max-w-xs">${escapeHtml(p.tagline || p.summary || '-')}</div>
                        </div>
                    </div>
                </td>
                <td class="py-4 px-6 font-medium text-on-surface">
                    <span class="px-3 py-1 rounded-full text-label-sm bg-primary-container/20 text-primary font-semibold">
                        ${escapeHtml(p.category || 'Solusi Digital')}
                    </span>
                </td>
                <td class="py-4 px-6 font-semibold text-on-surface">
                    ${escapeHtml(p.price_label || 'Konsultasi')}
                </td>
                <td class="py-4 px-6">
                    ${p.demo_url ? `<a href="${escapeHtml(p.demo_url)}" target="_blank" class="text-primary font-bold flex items-center gap-1 hover:underline text-label-md"><span class="material-symbols-outlined text-[16px]">open_in_new</span> Live Demo</a>` : '<span class="text-on-surface-variant text-label-sm">-</span>'}
                </td>
                <td class="py-4 px-6">
                    ${statusBadge}
                </td>
                <td class="py-4 px-6 text-right space-x-2">
                    <button type="button" onclick="editProduct(${p.id})" class="p-2 text-primary hover:bg-primary/10 rounded-lg transition-colors" title="Edit Produk">
                        <span class="material-symbols-outlined text-[20px]">edit</span>
                    </button>
                    <button type="button" onclick="deleteProduct(${p.id})" class="p-2 text-error hover:bg-error/10 rounded-lg transition-colors" title="Hapus Produk">
                        <span class="material-symbols-outlined text-[20px]">delete</span>
                    </button>
                </td>
            </tr>
        `;
    });
    tbody.innerHTML = html;

    rbtgTable.renderPagination('tablePagination', items.length, currentPage, perPageVal, 'goToPage');
}

function previewProductImage(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('productImagePreview').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}

function resetProductImage() {
    const fileInput = document.getElementById('product_image_file');
    if (fileInput) fileInput.value = '';
    const urlInput = document.getElementById('formImageUrl');
    if (urlInput) urlInput.value = '';
    const preview = document.getElementById('productImagePreview');
    if (preview) preview.src = '/logo-rbtgtech.png';
}

function openProductDrawer() {
    document.getElementById('productForm').reset();
    document.getElementById('productId').value = '';
    const fileInput = document.getElementById('product_image_file');
    if (fileInput) fileInput.value = '';
    const preview = document.getElementById('productImagePreview');
    if (preview) preview.src = '/logo-rbtgtech.png';
    document.getElementById('drawerTitle').innerText = 'Tambah Produk Baru';
    document.getElementById('productDrawer').classList.remove('hidden');
}

function closeProductDrawer() {
    document.getElementById('productDrawer').classList.add('hidden');
}

function generateSlug(text) {
    if (document.getElementById('productId').value) return; // don't overwrite on edit unless empty
    const slug = text.toLowerCase()
        .replace(/[^\w\s-]/g, '')
        .replace(/[\s_-]+/g, '-')
        .replace(/^-+|-+$/g, '');
    document.getElementById('formSlug').value = slug;
}

function editProduct(id) {
    fetch(`/admin/products/${id}`)
        .then(res => res.json())
        .then(res => {
            if (res.status === 'success') {
                const p = res.data;
                document.getElementById('productId').value = p.id;
                document.getElementById('formTitle').value = p.title || '';
                document.getElementById('formSlug').value = p.slug || '';
                document.getElementById('formCategory').value = p.category || '';
                document.getElementById('formPriceLabel').value = p.price_label || '';
                document.getElementById('formTagline').value = p.tagline || '';
                document.getElementById('formSummary').value = p.summary || '';
                document.getElementById('formDescription').value = p.description || '';
                document.getElementById('formDemoUrl').value = p.demo_url || '';
                document.getElementById('formImageUrl').value = p.image_url || '';
                
                const fileInput = document.getElementById('product_image_file');
                if (fileInput) fileInput.value = '';
                const preview = document.getElementById('productImagePreview');
                if (preview) preview.src = p.image_url || '/logo-rbtgtech.png';

                document.getElementById('formStatus').value = p.status || 'published';
                document.getElementById('formSortOrder').value = p.sort_order || 0;

                const features = Array.isArray(p.features) ? p.features.join('\n') : '';
                document.getElementById('formFeaturesText').value = features;

                const techStack = Array.isArray(p.tech_stack) ? p.tech_stack.join('\n') : '';
                document.getElementById('formTechStackText').value = techStack;

                document.getElementById('drawerTitle').innerText = 'Edit Produk Digital';
                document.getElementById('productDrawer').classList.remove('hidden');
            }
        });
}

function submitProductForm(e) {
    e.preventDefault();
    const btn = document.getElementById('btnSubmitForm');
    const originalText = btn.innerText;
    btn.disabled = true;
    btn.innerText = 'Menyimpan...';

    const id = document.getElementById('productId').value;
    const isEdit = !!id;
    const url = isEdit ? `/admin/products/${id}` : '/admin/products';

    const formEl = document.getElementById('productForm');
    const formData = new FormData(formEl);
    if (isEdit) {
        formData.append('_method', 'PUT');
    }

    const featuresText = document.getElementById('formFeaturesText').value || '';
    const featuresArray = featuresText.split('\n').map(s => s.trim()).filter(s => s.length > 0);
    formData.delete('features');
    formData.delete('features[]');
    featuresArray.forEach(item => formData.append('features[]', item));

    const techStackText = document.getElementById('formTechStackText').value || '';
    const techStackArray = techStackText.split('\n').map(s => s.trim()).filter(s => s.length > 0);
    formData.delete('tech_stack');
    formData.delete('tech_stack[]');
    techStackArray.forEach(item => formData.append('tech_stack[]', item));

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

    fetch(url, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrfToken
        },
        body: formData
    })
    .then(res => res.json())
    .then(res => {
        btn.disabled = false;
        btn.innerText = originalText;
        if (res.status === 'success') {
            closeProductDrawer();
            loadProducts();
        } else {
            let errorMsg = res.message || 'Terjadi kesalahan saat menyimpan';
            if (res.errors) {
                const detailedErrors = Object.values(res.errors).flat().join('\n');
                errorMsg += '\n' + detailedErrors;
            }
            alert(errorMsg);
        }
    })
    .catch(err => {
        btn.disabled = false;
        btn.innerText = originalText;
        alert('Terjadi kesalahan jaringan/koneksi.');
    });
}

function deleteProduct(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus produk ini?')) return;

    fetch(`/admin/products/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(res => {
        if (res.status === 'success') {
            loadProducts();
        }
    });
}

function debounceSearch() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        loadProducts();
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
</script>
@endsection
