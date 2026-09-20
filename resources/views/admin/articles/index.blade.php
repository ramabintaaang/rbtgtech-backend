@extends('layouts.app')

@section('title', 'Manajemen Artikel & Blog - RBTG Tech')

@section('content')
<div class="px-margin-desktop py-lg max-w-[1440px] mx-auto flex flex-col gap-lg" id="spaContainer">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-md">
        <div>
            <h1 class="text-headline-lg font-headline-lg text-on-surface">Artikel & Blog Management</h1>
            <p class="text-body-lg font-body-lg text-on-surface-variant">Kelola artikel teknologi, berita, dan optimasi SEO untuk frontend Astro.</p>
        </div>
        <a href="{{ route('admin.articles.create') }}" class="bg-primary hover:bg-surface-tint text-on-primary font-bold text-label-md px-6 py-2.5 rounded-full flex items-center gap-2 transition-colors self-start md:self-auto soft-shadow">
            <span class="material-symbols-outlined text-[20px]">add</span>
            Buat Artikel Baru
        </a>
    </div>

    <!-- Filters & Search -->
    <div class="bg-surface-container-lowest p-4 rounded-2xl soft-shadow border border-outline-variant flex flex-wrap gap-md items-center justify-between">
        <div class="flex flex-wrap items-center gap-md flex-grow">
            <!-- Search -->
            <div class="relative flex-grow max-w-md">
                <input 
                    type="text" 
                    id="searchInput" 
                    oninput="debounceLoadArticles()" 
                    placeholder="Cari judul, kata kunci SEO..." 
                    class="w-full bg-surface-container-low border border-outline-variant rounded-full pl-10 pr-4 py-2 text-body-md focus:border-primary focus:ring-0 outline-none"
                />
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">search</span>
            </div>

            <!-- Category Filter -->
            <select id="categoryFilter" onchange="loadArticlesData()" class="bg-surface-container-low border border-outline-variant rounded-full px-4 py-2 text-body-md text-on-surface focus:border-primary outline-none">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                @endforeach
            </select>

            <!-- Status Filter -->
            <select id="statusFilter" onchange="loadArticlesData()" class="bg-surface-container-low border border-outline-variant rounded-full px-4 py-2 text-body-md text-on-surface focus:border-primary outline-none">
                <option value="">Semua Status</option>
                <option value="published">Terpublikasi</option>
                <option value="draft">Draf</option>
            </select>

            <!-- Per Page Limit -->
            <select id="filterPerPage" onchange="currentPage=1; renderArticlesTable(articlesData)" class="bg-surface-container-low border border-outline-variant rounded-full px-4 py-2 text-body-md text-on-surface focus:border-primary outline-none">
                <option value="10">10 Baris</option>
                <option value="25">25 Baris</option>
                <option value="50">50 Baris</option>
                <option value="100">100 Baris</option>
                <option value="all">Semua</option>
            </select>
        </div>

        <button type="button" onclick="resetArticlesFilters()" class="text-error text-label-md font-label-md flex items-center gap-1 hover:underline cursor-pointer">
            <span class="material-symbols-outlined text-[16px]">close</span> Reset Filter
        </button>
    </div>

    <!-- Articles Table Card -->
    <div class="bg-surface-container-lowest rounded-2xl soft-shadow border border-outline-variant overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low border-b border-outline-variant text-on-surface-variant text-label-md font-label-md">
                        <th class="py-4 px-6 font-bold cursor-pointer select-none hover:text-primary transition-colors" onclick="sortBy('title')">
                            <div class="flex items-center gap-1">
                                <span>Artikel & Permalink</span>
                                <span id="sortIcon-title" class="material-symbols-outlined text-[16px]">swap_vert</span>
                            </div>
                        </th>
                        <th class="py-4 px-6 font-bold cursor-pointer select-none hover:text-primary transition-colors" onclick="sortBy('category')">
                            <div class="flex items-center gap-1">
                                <span>Kategori</span>
                                <span id="sortIcon-category" class="material-symbols-outlined text-[16px]">swap_vert</span>
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
                        <th class="py-4 px-6 font-bold cursor-pointer select-none hover:text-primary transition-colors" onclick="sortBy('created_at')">
                            <div class="flex items-center gap-1">
                                <span>Tanggal</span>
                                <span id="sortIcon-created_at" class="material-symbols-outlined text-[16px]">swap_vert</span>
                            </div>
                        </th>
                        <th class="py-4 px-6 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody id="articlesTableBody" class="divide-y divide-surface-container text-body-md">
                    <tr>
                        <td colspan="6" class="py-12 text-center text-on-surface-variant">
                            <span class="material-symbols-outlined text-[36px] animate-spin block mb-2 text-primary">sync</span>
                            Memuat data artikel...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="tablePagination"></div>
    </div>
</div>

<script>
let articlesData = [];
let currentPage = 1;
let sortColumn = 'created_at';
let sortDirection = 'desc';
let debounceTimer;

document.addEventListener('DOMContentLoaded', () => {
    loadArticlesData();
});

async function loadArticlesData() {
    const search = document.getElementById('searchInput').value.trim();
    const category = document.getElementById('categoryFilter').value;
    const status = document.getElementById('statusFilter').value;

    const params = new URLSearchParams();
    if (search) params.append('search', search);
    if (category) params.append('category', category);
    if (status) params.append('status', status);

    try {
        const response = await fetch(`/admin/articles/data?${params.toString()}`, {
            headers: { 'Accept': 'application/json' }
        });
        const result = await response.json();

        if (result.status === 'success') {
            articlesData = result.data;
            renderArticlesTable(articlesData);
        }
    } catch (err) {
        console.error('Error fetching articles:', err);
    }
}

function debounceLoadArticles() {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        currentPage = 1;
        loadArticlesData();
    }, 300);
}

function resetArticlesFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('categoryFilter').value = '';
    document.getElementById('statusFilter').value = '';
    currentPage = 1;
    loadArticlesData();
}

function sortBy(column) {
    if (sortColumn === column) {
        sortDirection = sortDirection === 'asc' ? 'desc' : 'asc';
    } else {
        sortColumn = column;
        sortDirection = 'asc';
    }
    currentPage = 1;
    renderArticlesTable(articlesData);
}

function goToPage(page) {
    currentPage = page;
    renderArticlesTable(articlesData);
}

function updateSortIcons() {
    const columns = ['title', 'category', 'seo_score', 'status', 'created_at'];
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

function renderArticlesTable(items) {
    const tbody = document.getElementById('articlesTableBody');
    updateSortIcons();

    if (items.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="py-12 text-center text-on-surface-variant">
                    <span class="material-symbols-outlined text-[48px] block mb-2 opacity-50">article</span>
                    Belum ada artikel yang cocok dengan filter Anda.
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

    tbody.innerHTML = paginatedItems.map(a => {
        const seoScore = a.seo_score || 0;
        const seoBadgeColor = seoScore >= 80 ? 'bg-emerald-100 text-emerald-800 border-emerald-300' : (seoScore >= 50 ? 'bg-amber-100 text-amber-800 border-amber-300' : 'bg-rose-100 text-rose-800 border-rose-300');
        
        const statusBadge = a.status === 'published' 
            ? `<span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-1 rounded-full text-label-sm font-semibold">
                   <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Published
               </span>`
            : `<span class="inline-flex items-center gap-1 bg-slate-100 text-slate-700 border border-slate-300 px-2.5 py-1 rounded-full text-label-sm font-semibold">
                   <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Draft
               </span>`;

        const pubDate = a.published_at ? formatDateString(a.published_at) : (a.created_at ? formatDateString(a.created_at) : '-');
        
        const keywordHtml = a.focus_keyword 
            ? `<span class="inline-flex items-center gap-1 text-[11px] text-secondary font-medium mt-1 bg-secondary-container/40 px-2 py-0.5 rounded">
                   <span class="material-symbols-outlined text-[12px]">key</span> ${escapeHtml(a.focus_keyword)}
               </span>`
            : '';

        return `
            <tr class="hover:bg-surface-container-low/50 transition-colors">
                <td class="py-4 px-6 max-w-xs">
                    <h3 class="font-bold text-on-surface text-label-md line-clamp-1 mb-0.5">${escapeHtml(a.title)}</h3>
                    <p class="text-[11px] text-primary font-mono truncate">/artikel/${escapeHtml(a.slug)}</p>
                    ${keywordHtml}
                </td>
                <td class="py-4 px-6">
                    <span class="bg-surface-container-high px-3 py-1 rounded-full text-label-sm font-semibold text-on-surface">
                        ${escapeHtml(a.category || 'Berita')}
                    </span>
                </td>
                <td class="py-4 px-6">
                    <span class="inline-flex items-center justify-center font-bold text-xs border rounded-lg px-2.5 py-1 ${seoBadgeColor}">
                        ⚡ ${seoScore}/100
                    </span>
                </td>
                <td class="py-4 px-6">
                    ${statusBadge}
                </td>
                <td class="py-4 px-6 text-on-surface-variant text-sm">
                    ${pubDate}
                </td>
                <td class="py-4 px-6 text-right space-x-2 whitespace-nowrap">
                    <a href="/admin/articles/${a.id}/edit" class="inline-flex items-center p-2 text-primary hover:bg-primary-fixed/50 rounded-lg transition-colors" title="Edit Artikel">
                        <span class="material-symbols-outlined text-[20px]">edit</span>
                    </a>
                    <button type="button" onclick="deleteArticle(${a.id})" class="p-2 text-error hover:bg-error-container/30 rounded-lg transition-colors cursor-pointer" title="Hapus Artikel">
                        <span class="material-symbols-outlined text-[20px]">delete</span>
                    </button>
                </td>
            </tr>
        `;
    }).join('');

    rbtgTable.renderPagination('tablePagination', items.length, currentPage, perPageVal, 'goToPage');
}

async function deleteArticle(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus artikel ini?')) return;

    try {
        const response = await fetch(`/admin/articles/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-HTTP-Method-Override': 'DELETE'
            }
        });
        const result = await response.json();

        if (response.ok && result.status === 'success') {
            loadArticlesData();
        } else {
            alert(result.message || 'Gagal menghapus artikel');
        }
    } catch (err) {
        alert('Gagal menghubungi server untuk menghapus artikel');
    }
}

function formatDateString(dateStr) {
    try {
        const d = new Date(dateStr);
        if (isNaN(d.getTime())) return dateStr;
        const day = String(d.getDate()).padStart(2, '0');
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        const month = months[d.getMonth()];
        const year = d.getFullYear();
        return `${day} ${month} ${year}`;
    } catch(e) {
        return dateStr;
    }
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
