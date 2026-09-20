@extends('layouts.app')

@section('title', 'Master Kategori - RBTGTech')

@section('content')
<div class="px-margin-desktop py-lg max-w-[1440px] mx-auto flex flex-col gap-lg">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-md">
        <div>
            <h1 class="text-headline-lg font-headline-lg text-on-surface mb-1">Master Kategori</h1>
            <p class="text-body-lg font-body-lg text-on-surface-variant">Kelola daftar kategori terpusat untuk Artikel & Blog serta Portofolio Proyek RBTG Tech.</p>
        </div>
        <button 
            type="button" 
            onclick="openCategoryDrawer()" 
            class="bg-primary hover:bg-surface-tint text-on-primary font-bold text-label-md px-6 py-2.5 rounded-full flex items-center gap-2 transition-all soft-shadow self-start md:self-auto cursor-pointer"
        >
            <span class="material-symbols-outlined text-[20px]">add</span>
            Tambah Kategori Baru
        </button>
    </div>

    <!-- Filters & Search -->
    <div class="bg-surface-container-lowest p-4 rounded-2xl soft-shadow border border-outline-variant flex flex-wrap gap-md items-center justify-between">
        <div class="flex flex-wrap items-center gap-md flex-grow">
            <!-- Search -->
            <div class="relative flex-grow max-w-md">
                <input 
                    type="text" 
                    id="searchInput" 
                    oninput="debounceLoadCategories()" 
                    placeholder="Cari nama kategori, deskripsi SEO..." 
                    class="w-full bg-surface-container-low border border-outline-variant rounded-full pl-10 pr-4 py-2 text-body-md focus:border-primary focus:ring-0 outline-none"
                />
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">search</span>
            </div>

            <!-- Type Filter -->
            <select id="typeFilter" onchange="loadCategoryData()" class="bg-surface-container-low border border-outline-variant rounded-full px-4 py-2 text-body-md text-on-surface focus:border-primary outline-none">
                <option value="">Semua Modul</option>
                <option value="article">Artikel & Blog</option>
                <option value="portfolio">Portofolio Proyek</option>
                <option value="both">Keduanya (Global)</option>
            </select>

            <!-- Per Page Limit -->
            <select id="filterPerPage" onchange="currentPage=1; renderCategoryTable(categoriesData)" class="bg-surface-container-low border border-outline-variant rounded-full px-4 py-2 text-body-md text-on-surface focus:border-primary outline-none">
                <option value="10">10 Baris</option>
                <option value="25">25 Baris</option>
                <option value="50">50 Baris</option>
                <option value="100">100 Baris</option>
                <option value="all">Semua</option>
            </select>
        </div>

        <button type="button" onclick="resetCategoryFilters()" class="text-error text-label-md font-label-md flex items-center gap-1 hover:underline cursor-pointer">
            <span class="material-symbols-outlined text-[16px]">close</span> Reset Filter
        </button>
    </div>

    <!-- Category Grid / Table Card -->
    <div class="bg-surface-container-lowest rounded-2xl soft-shadow border border-outline-variant overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low border-b border-outline-variant text-on-surface-variant text-label-md font-label-md">
                        <th class="py-4 px-6 font-bold cursor-pointer select-none hover:text-primary transition-colors" onclick="sortBy('name')">
                            <div class="flex items-center gap-1">
                                <span>Kategori & Icon</span>
                                <span id="sortIcon-name" class="material-symbols-outlined text-[16px]">swap_vert</span>
                            </div>
                        </th>
                        <th class="py-4 px-6 font-bold cursor-pointer select-none hover:text-primary transition-colors" onclick="sortBy('slug')">
                            <div class="flex items-center gap-1">
                                <span>URL Slug</span>
                                <span id="sortIcon-slug" class="material-symbols-outlined text-[16px]">swap_vert</span>
                            </div>
                        </th>
                        <th class="py-4 px-6 font-bold cursor-pointer select-none hover:text-primary transition-colors" onclick="sortBy('type')">
                            <div class="flex items-center gap-1">
                                <span>Modul Target</span>
                                <span id="sortIcon-type" class="material-symbols-outlined text-[16px]">swap_vert</span>
                            </div>
                        </th>
                        <th class="py-4 px-6 font-bold cursor-pointer select-none hover:text-primary transition-colors" onclick="sortBy('description')">
                            <div class="flex items-center gap-1">
                                <span>Deskripsi SEO Kategori</span>
                                <span id="sortIcon-description" class="material-symbols-outlined text-[16px]">swap_vert</span>
                            </div>
                        </th>
                        <th class="py-4 px-6 font-bold cursor-pointer select-none hover:text-primary transition-colors" onclick="sortBy('sort_order')">
                            <div class="flex items-center gap-1">
                                <span>Urutan</span>
                                <span id="sortIcon-sort_order" class="material-symbols-outlined text-[16px]">swap_vert</span>
                            </div>
                        </th>
                        <th class="py-4 px-6 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody id="categoryTableBody" class="divide-y divide-surface-container">
                    <tr>
                        <td colspan="6" class="py-12 text-center text-on-surface-variant">
                            <span class="material-symbols-outlined text-[36px] animate-spin block mb-2 text-primary">sync</span>
                            Memuat data master kategori...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="tablePagination"></div>
    </div>
</div>

<!-- Slide-Over Drawer / Modal for Add & Edit Category -->
<div id="drawerBackdrop" class="fixed inset-0 bg-black/40 backdrop-blur-xs z-50 hidden transition-opacity duration-300 opacity-0" onclick="closeCategoryDrawer()"></div>

<div id="categoryDrawer" class="fixed inset-y-0 right-0 z-50 w-full max-w-lg bg-surface-container-lowest shadow-2xl border-l border-outline-variant flex flex-col transform translate-x-full transition-transform duration-300 ease-in-out">
    <!-- Header -->
    <div class="px-6 py-4 border-b border-outline-variant/40 flex justify-between items-center bg-surface-container-low">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary-fixed flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-[24px]">category</span>
            </div>
            <div>
                <h2 id="drawerTitle" class="text-headline-sm font-bold text-on-surface">Tambah Kategori Baru</h2>
                <p class="text-label-sm text-on-surface-variant">Atur nama, icon, dan deskripsi SEO kategori.</p>
            </div>
        </div>
        <button type="button" onclick="closeCategoryDrawer()" class="p-2 text-on-surface-variant hover:text-error rounded-lg transition-colors cursor-pointer">
            <span class="material-symbols-outlined text-[24px]">close</span>
        </button>
    </div>

    <!-- Form Body -->
    <form id="categoryForm" onsubmit="saveCategory(event)" class="flex-1 overflow-y-auto p-6 space-y-5">
        @csrf
        <input type="hidden" id="categoryId" name="id" value="">

        <!-- Error Banner -->
        <div id="formErrorBanner" class="hidden p-4 rounded-xl bg-error-container text-on-error-container text-body-md flex items-start gap-3">
            <span class="material-symbols-outlined text-error text-[20px] shrink-0 mt-0.5">error</span>
            <div id="formErrorMessage">Terdapat kesalahan pengisian form.</div>
        </div>

        <!-- Name Input -->
        <div>
            <label for="name" class="block text-label-md font-bold text-on-surface mb-2">Nama Kategori <span class="text-error">*</span></label>
            <input 
                type="text" 
                id="name" 
                name="name" 
                required 
                oninput="onNameInput()" 
                placeholder="Contoh: Cloud Architecture" 
                class="w-full bg-surface-container-low border border-outline-variant rounded-xl px-4 py-3 text-headline-sm font-semibold text-on-surface focus:border-primary outline-none"
            />
        </div>

        <!-- Slug Input -->
        <div>
            <label for="slug" class="block text-label-md font-bold text-on-surface mb-2">URL Slug <span class="text-error">*</span></label>
            <input 
                type="text" 
                id="slug" 
                name="slug" 
                required 
                placeholder="cloud-architecture" 
                class="w-full bg-surface-container-low border border-outline-variant rounded-xl p-3 font-mono text-xs text-primary focus:border-primary outline-none"
            />
        </div>

        <!-- Type Selection -->
        <div>
            <label for="type" class="block text-label-md font-bold text-on-surface mb-2">Target Penggunaan Modul <span class="text-error">*</span></label>
            <select id="type" name="type" required class="w-full bg-surface-container-low border border-outline-variant rounded-xl p-3 text-body-md text-on-surface focus:border-primary outline-none">
                <option value="both">Keduanya (Artikel & Portofolio)</option>
                <option value="article">Khusus Artikel & Blog</option>
                <option value="portfolio">Khusus Portofolio Proyek</option>
            </select>
        </div>

        <!-- Icon Picker & Color Variant -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="icon" class="block text-label-md font-bold text-on-surface mb-2">Material Icon</label>
                <select id="icon" name="icon" class="w-full bg-surface-container-low border border-outline-variant rounded-xl p-3 text-body-md text-on-surface focus:border-primary outline-none">
                    <option value="folder">Folder (Bawaan)</option>
                    <option value="devices">Devices (Teknologi)</option>
                    <option value="search">Search (SEO)</option>
                    <option value="account_tree">Account Tree (Arsitektur)</option>
                    <option value="campaign">Campaign (Berita)</option>
                    <option value="domain">Domain (Enterprise)</option>
                    <option value="shopping_bag">Shopping Bag (E-Commerce)</option>
                    <option value="medical_services">Medical Services (Healthcare)</option>
                    <option value="cloud">Cloud (Infrastruktur)</option>
                    <option value="star">Star (Spesial)</option>
                </select>
            </div>

            <div>
                <label for="sort_order" class="block text-label-md font-bold text-on-surface mb-2">Urutan Tampil</label>
                <input 
                    type="number" 
                    id="sort_order" 
                    name="sort_order" 
                    value="1" 
                    class="w-full bg-surface-container-low border border-outline-variant rounded-xl p-3 text-body-md text-on-surface focus:border-primary outline-none"
                />
            </div>
        </div>

        <!-- Description / SEO Meta Description -->
        <div>
            <label for="description" class="block text-label-md font-bold text-on-surface mb-2">Deskripsi SEO Kategori</label>
            <textarea 
                id="description" 
                name="description" 
                rows="3" 
                placeholder="Penjelasan deskriptif kategori yang akan tampil pada halaman landing kategori Astro..."
                class="w-full bg-surface-container-low border border-outline-variant rounded-xl p-3 text-body-md text-on-surface focus:border-primary outline-none"
            ></textarea>
        </div>
    </form>

    <!-- Footer Actions -->
    <div class="px-6 py-4 border-t border-outline-variant bg-surface-container-low flex items-center justify-end gap-3">
        <button type="button" onclick="closeCategoryDrawer()" class="px-5 py-2.5 rounded-xl text-on-surface font-semibold hover:bg-surface-container-high transition-colors cursor-pointer">
            Batal
        </button>
        <button type="button" onclick="document.getElementById('categoryForm').requestSubmit()" class="bg-primary hover:bg-surface-tint text-on-primary font-bold px-6 py-2.5 rounded-xl transition-all soft-shadow flex items-center gap-2 cursor-pointer">
            <span class="material-symbols-outlined text-[18px]">save</span>
            <span id="saveBtnText">Simpan Kategori</span>
        </button>
    </div>
</div>

<!-- Toast Container -->
<div id="toastContainer" class="fixed bottom-6 right-6 z-50 flex flex-col gap-2"></div>

<script>
let categoriesData = [];
let isEditing = false;
let isManualSlug = false;
let currentPage = 1;
let sortColumn = 'sort_order';
let sortDirection = 'asc';

document.addEventListener('DOMContentLoaded', function() {
    loadCategoryData();
});

async function loadCategoryData() {
    const search = document.getElementById('searchInput').value.trim();
    const type = document.getElementById('typeFilter').value;

    const params = new URLSearchParams();
    if (search) params.append('search', search);
    if (type) params.append('type', type);

    try {
        const response = await fetch(`/admin/categories/data?${params.toString()}`, {
            headers: { 'Accept': 'application/json' }
        });
        const result = await response.json();

        if (result.status === 'success') {
            categoriesData = result.data;
            currentPage = 1;
            renderCategoryTable(categoriesData);
        }
    } catch (err) {
        showToast('Gagal memuat data master kategori', 'error');
    }
}

let debounceTimer;
function debounceLoadCategories() {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(loadCategoryData, 300);
}

function resetCategoryFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('typeFilter').value = '';
    currentPage = 1;
    loadCategoryData();
}

function sortBy(column) {
    if (sortColumn === column) {
        sortDirection = sortDirection === 'asc' ? 'desc' : 'asc';
    } else {
        sortColumn = column;
        sortDirection = 'asc';
    }
    currentPage = 1;
    renderCategoryTable(categoriesData);
}

function goToPage(page) {
    currentPage = page;
    renderCategoryTable(categoriesData);
}

function updateSortIcons() {
    const columns = ['name', 'slug', 'type', 'description', 'sort_order'];
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

function renderCategoryTable(items) {
    const tbody = document.getElementById('categoryTableBody');
    updateSortIcons();

    if (items.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="py-12 text-center text-on-surface-variant">
                    <span class="material-symbols-outlined text-[48px] block mb-2 opacity-50">category</span>
                    Belum ada kategori yang tersimpan.
                </td>
            </tr>
        `;
        document.getElementById('tablePagination').innerHTML = '';
        return;
    }

    const sortedItems = [...items].sort((a, b) => {
        let valA = a[sortColumn] || '';
        let valB = b[sortColumn] || '';
        if (typeof valA === 'string') valA = valA.toLowerCase();
        if (typeof valB === 'string') valB = valB.toLowerCase();
        if (valA < valB) return sortDirection === 'asc' ? -1 : 1;
        if (valA > valB) return sortDirection === 'asc' ? 1 : -1;
        return 0;
    });

    const perPageVal = document.getElementById('filterPerPage').value;
    const paginatedItems = perPageVal === 'all' ? sortedItems : sortedItems.slice((currentPage - 1) * perPageVal, currentPage * perPageVal);
    
    const totalPages = perPageVal === 'all' ? 1 : Math.ceil(sortedItems.length / perPageVal);

    tbody.innerHTML = paginatedItems.map(cat => {
        let typeBadge = '<span class="bg-primary-container/30 text-primary px-2.5 py-1 rounded-full text-xs font-semibold">Artikel & Portofolio</span>';
        if (cat.type === 'article') {
            typeBadge = '<span class="bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-1 rounded-full text-xs font-semibold">Artikel & Blog</span>';
        } else if (cat.type === 'portfolio') {
            typeBadge = '<span class="bg-indigo-50 text-indigo-700 border border-indigo-200 px-2.5 py-1 rounded-full text-xs font-semibold">Portofolio Proyek</span>';
        }

        return `
            <tr class="hover:bg-surface-container-low/50 transition-colors">
                <td class="py-4 px-6">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-surface-container-high flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-[20px]">${escapeHtml(cat.icon || 'folder')}</span>
                        </div>
                        <span class="font-bold text-on-surface text-label-md">${escapeHtml(cat.name)}</span>
                    </div>
                </td>
                <td class="py-4 px-6 text-body-md font-mono text-xs text-primary">
                    /${escapeHtml(cat.slug)}
                </td>
                <td class="py-4 px-6">
                    ${typeBadge}
                </td>
                <td class="py-4 px-6 text-body-md text-on-surface-variant max-w-sm">
                    <p class="line-clamp-2 text-xs">${escapeHtml(cat.description || '-')}</p>
                </td>
                <td class="py-4 px-6 font-mono text-xs text-on-surface font-semibold">
                    #${cat.sort_order || 0}
                </td>
                <td class="py-4 px-6 text-right space-x-2">
                    <button type="button" onclick="editCategory(${cat.id})" class="p-2 text-primary hover:bg-primary-fixed/50 rounded-lg transition-colors cursor-pointer" title="Edit Kategori">
                        <span class="material-symbols-outlined text-[20px]">edit</span>
                    </button>
                    <button type="button" onclick="deleteCategory(${cat.id})" class="p-2 text-error hover:bg-error-container/30 rounded-lg transition-colors cursor-pointer" title="Hapus Kategori">
                        <span class="material-symbols-outlined text-[20px]">delete</span>
                    </button>
                </td>
            </tr>
        `;
    }).join('');

    rbtgTable.renderPagination('tablePagination', items.length, currentPage, perPageVal, 'goToPage');
}

function openCategoryDrawer() {
    isEditing = false;
    isManualSlug = false;
    document.getElementById('categoryForm').reset();
    document.getElementById('categoryId').value = '';
    document.getElementById('drawerTitle').textContent = 'Tambah Kategori Baru';
    document.getElementById('saveBtnText').textContent = 'Simpan Kategori';
    document.getElementById('formErrorBanner').classList.add('hidden');

    const backdrop = document.getElementById('drawerBackdrop');
    const drawer = document.getElementById('categoryDrawer');

    backdrop.classList.remove('hidden');
    setTimeout(() => {
        backdrop.classList.remove('opacity-0');
        drawer.classList.remove('translate-x-full');
    }, 10);
}

function closeCategoryDrawer() {
    const backdrop = document.getElementById('drawerBackdrop');
    const drawer = document.getElementById('categoryDrawer');

    backdrop.classList.add('opacity-0');
    drawer.classList.add('translate-x-full');

    setTimeout(() => {
        backdrop.classList.add('hidden');
    }, 300);
}

function onNameInput() {
    if (!isManualSlug) {
        const name = document.getElementById('name').value;
        document.getElementById('slug').value = name
            .toLowerCase()
            .trim()
            .replace(/[^\w\s-]/g, '')
            .replace(/[\s_-]+/g, '-')
            .replace(/^-+|-+$/g, '');
    }
}

async function editCategory(id) {
    try {
        const response = await fetch(`/admin/categories/${id}`, {
            headers: { 'Accept': 'application/json' }
        });
        const result = await response.json();

        if (result.status === 'success') {
            const cat = result.data;
            isEditing = true;
            isManualSlug = true;

            document.getElementById('categoryId').value = cat.id;
            document.getElementById('name').value = cat.name || '';
            document.getElementById('slug').value = cat.slug || '';
            document.getElementById('type').value = cat.type || 'both';
            document.getElementById('icon').value = cat.icon || 'folder';
            document.getElementById('sort_order').value = cat.sort_order || 1;
            document.getElementById('description').value = cat.description || '';

            document.getElementById('drawerTitle').textContent = 'Edit Kategori';
            document.getElementById('saveBtnText').textContent = 'Simpan Perubahan';
            document.getElementById('formErrorBanner').classList.add('hidden');

            const backdrop = document.getElementById('drawerBackdrop');
            const drawer = document.getElementById('categoryDrawer');

            backdrop.classList.remove('hidden');
            setTimeout(() => {
                backdrop.classList.remove('opacity-0');
                drawer.classList.remove('translate-x-full');
            }, 10);
        }
    } catch (err) {
        showToast('Gagal memuat data detail kategori', 'error');
    }
}

async function saveCategory(event) {
    event.preventDefault();
    const id = document.getElementById('categoryId').value;
    const isUpdate = id && id !== '';

    const url = isUpdate ? `/admin/categories/${id}` : '/admin/categories';
    const method = isUpdate ? 'PUT' : 'POST';

    const formData = new FormData(document.getElementById('categoryForm'));
    const data = Object.fromEntries(formData.entries());

    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'X-HTTP-Method-Override': method
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (response.ok && result.status === 'success') {
            closeCategoryDrawer();
            showToast(result.message, 'success');
            loadCategoryData();
        } else {
            const errorMsg = result.message || Object.values(result.errors || {}).flat().join('<br>') || 'Terjadi kesalahan saat menyimpan kategori.';
            document.getElementById('formErrorMessage').innerHTML = errorMsg;
            document.getElementById('formErrorBanner').classList.remove('hidden');
        }
    } catch (err) {
        showToast('Gagal menyimpan data kategori', 'error');
    }
}

async function deleteCategory(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus kategori ini?')) return;

    try {
        const response = await fetch(`/admin/categories/${id}`, {
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
            loadCategoryData();
        } else {
            showToast(result.message || 'Gagal menghapus kategori', 'error');
        }
    } catch (err) {
        showToast('Gagal menghapus kategori dari server', 'error');
    }
}

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
