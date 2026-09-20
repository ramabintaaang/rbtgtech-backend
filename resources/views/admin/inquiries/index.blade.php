@extends('layouts.app')

@section('title', 'Pesan Masuk (Inbox) - RBTGTech')

@section('content')
<div class="px-margin-desktop py-lg max-w-[1440px] mx-auto flex flex-col gap-lg">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-md">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <h1 class="text-headline-lg font-headline-lg text-on-surface">Pesan Masuk (Inbox)</h1>
                <span id="unreadBadge" class="bg-emerald-100 text-emerald-800 border border-emerald-300 px-3 py-0.5 rounded-full text-xs font-bold font-mono">0 Pesan Baru</span>
            </div>
            <p class="text-body-lg font-body-lg text-on-surface-variant">Kelola pesan penawaran proyek dan konsultasi yang dikirim pengunjung via form kontak Astro.</p>
        </div>
    </div>

    <!-- Stat KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter">
        <div class="bg-surface-container-lowest p-5 rounded-2xl border border-outline-variant soft-shadow flex items-center justify-between">
            <div>
                <p class="text-label-sm text-on-surface-variant font-medium">Total Pesan</p>
                <h3 class="text-headline-md font-bold text-on-surface mt-1" id="statTotalInquiries">0</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-primary-fixed flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-[24px]">mail</span>
            </div>
        </div>

        <div class="bg-surface-container-lowest p-5 rounded-2xl border border-outline-variant soft-shadow flex items-center justify-between">
            <div>
                <p class="text-label-sm text-on-surface-variant font-medium">Belum Dibaca (Baru)</p>
                <h3 class="text-headline-md font-bold text-emerald-600 mt-1" id="statNewInquiries">0</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-700">
                <span class="material-symbols-outlined text-[24px]">mark_email_unread</span>
            </div>
        </div>

        <div class="bg-surface-container-lowest p-5 rounded-2xl border border-outline-variant soft-shadow flex items-center justify-between">
            <div>
                <p class="text-label-sm text-on-surface-variant font-medium">Sudah Dibalas</p>
                <h3 class="text-headline-md font-bold text-indigo-600 mt-1" id="statRepliedInquiries">0</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-700">
                <span class="material-symbols-outlined text-[24px]">reply</span>
            </div>
        </div>

        <div class="bg-surface-container-lowest p-5 rounded-2xl border border-outline-variant soft-shadow flex items-center justify-between">
            <div>
                <p class="text-label-sm text-on-surface-variant font-medium">Pengirim Ber-WhatsApp</p>
                <h3 class="text-headline-md font-bold text-emerald-600 mt-1" id="statWaInquiries">0</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-500/20 flex items-center justify-center text-emerald-700">
                <span class="material-symbols-outlined text-[24px]">chat</span>
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-surface-container-lowest p-4 rounded-2xl soft-shadow border border-outline-variant flex flex-wrap gap-md items-center justify-between">
        <div class="flex flex-wrap items-center gap-md flex-grow">
            <!-- Search -->
            <div class="relative flex-grow max-w-md">
                <input 
                    type="text" 
                    id="searchInput" 
                    oninput="debounceLoadInquiries()" 
                    placeholder="Cari nama pengirim, email, subjek..." 
                    class="w-full bg-surface-container-low border border-outline-variant rounded-full pl-10 pr-4 py-2 text-body-md focus:border-primary focus:ring-0 outline-none"
                />
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">search</span>
            </div>

            <!-- Status Filter -->
            <select id="statusFilter" onchange="loadInquiriesData()" class="bg-surface-container-low border border-outline-variant rounded-full px-4 py-2 text-body-md text-on-surface focus:border-primary outline-none">
                <option value="">Semua Status</option>
                <option value="new">Belum Dibaca (Baru)</option>
                <option value="read">Sudah Dibaca</option>
                <option value="replied">Sudah Dibalas</option>
                <option value="archived">Diarsipkan</option>
            </select>
        </div>

        <button type="button" onclick="resetInquiryFilters()" class="text-error text-label-md font-label-md flex items-center gap-1 hover:underline cursor-pointer">
            <span class="material-symbols-outlined text-[16px]">close</span> Reset Filter
        </button>
    </div>

    <!-- Inquiries Table Card -->
    <div class="bg-surface-container-lowest rounded-2xl soft-shadow border border-outline-variant overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low border-b border-outline-variant text-on-surface-variant text-label-md font-label-md">
                        <th class="py-4 px-6 font-bold">Pengirim & Kontak</th>
                        <th class="py-4 px-6 font-bold">Subjek & Pesan</th>
                        <th class="py-4 px-6 font-bold">Tanggal</th>
                        <th class="py-4 px-6 font-bold">Status</th>
                        <th class="py-4 px-6 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody id="inquiriesTableBody" class="divide-y divide-surface-container">
                    <tr>
                        <td colspan="5" class="py-12 text-center text-on-surface-variant">
                            <span class="material-symbols-outlined text-[36px] animate-spin block mb-2 text-primary">sync</span>
                            Memuat inbox pesan masuk...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Slide-Over Drawer Modal to View Full Message -->
<div id="drawerBackdrop" class="fixed inset-0 bg-black/40 backdrop-blur-xs z-50 hidden transition-opacity duration-300 opacity-0" onclick="closeInquiryDrawer()"></div>

<div id="inquiryDrawer" class="fixed inset-y-0 right-0 z-50 w-full max-w-xl bg-surface-container-lowest shadow-2xl border-l border-outline-variant flex flex-col transform translate-x-full transition-transform duration-300 ease-in-out">
    <!-- Header -->
    <div class="px-6 py-4 border-b border-outline-variant/40 flex justify-between items-center bg-surface-container-low">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary-fixed flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-[24px]">mark_email_read</span>
            </div>
            <div>
                <h2 class="text-headline-sm font-bold text-on-surface">Detail Pesan Masuk</h2>
                <p class="text-label-sm text-on-surface-variant" id="drawerDateText">Tanggal pengiriman</p>
            </div>
        </div>
        <button type="button" onclick="closeInquiryDrawer()" class="p-2 text-on-surface-variant hover:text-error rounded-lg transition-colors cursor-pointer">
            <span class="material-symbols-outlined text-[24px]">close</span>
        </button>
    </div>

    <!-- Body Content -->
    <div class="flex-1 overflow-y-auto p-6 space-y-6">
        <input type="hidden" id="currentInquiryId" value="">

        <!-- Sender Card -->
        <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant space-y-2">
            <div class="flex justify-between items-start">
                <div>
                    <h3 id="drawerName" class="font-bold text-headline-sm text-on-surface">Nama Pengirim</h3>
                    <p id="drawerEmail" class="text-body-md text-primary font-mono text-xs">email@domain.com</p>
                </div>
                <div id="drawerWaBtnContainer"></div>
            </div>
            <div class="pt-2 border-t border-outline-variant/40 flex justify-between items-center text-xs text-on-surface-variant">
                <span>No. Telepon: <strong id="drawerPhone" class="text-on-surface">085158442711</strong></span>
                <span id="drawerStatusBadge"></span>
            </div>
        </div>

        <!-- Subject -->
        <div>
            <label class="block text-label-sm font-bold text-on-surface-variant uppercase tracking-wider mb-1">Subjek Inquiry</label>
            <div id="drawerSubject" class="text-headline-sm font-bold text-on-surface p-3 bg-surface-container-low rounded-xl border border-outline-variant">
                Subjek Pesan
            </div>
        </div>

        <!-- Message Body -->
        <div>
            <label class="block text-label-sm font-bold text-on-surface-variant uppercase tracking-wider mb-1">Isi Pesan Lengkap</label>
            <div id="drawerMessage" class="text-body-lg text-on-surface p-4 bg-surface-container-low rounded-xl border border-outline-variant whitespace-pre-wrap leading-relaxed min-h-[160px]">
                Isi pesan...
            </div>
        </div>

        <!-- Update Status Selection -->
        <div>
            <label for="drawerStatusSelect" class="block text-label-md font-bold text-on-surface mb-2">Ubah Status Pesan Ini</label>
            <div class="flex items-center gap-3">
                <select id="drawerStatusSelect" class="flex-1 bg-surface-container-low border border-outline-variant rounded-xl p-3 text-body-md text-on-surface focus:border-primary outline-none">
                    <option value="new">Belum Dibaca (Baru)</option>
                    <option value="read">Sudah Dibaca</option>
                    <option value="replied">Sudah Dibalas / Selesai</option>
                    <option value="archived">Diarsipkan</option>
                </select>
                <button type="button" onclick="updateInquiryStatusFromDrawer()" class="bg-primary hover:bg-surface-tint text-on-primary font-bold px-5 py-3 rounded-xl transition-all soft-shadow cursor-pointer">
                    Update Status
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Toast Container -->
<div id="toastContainer" class="fixed bottom-6 right-6 z-50 flex flex-col gap-2"></div>

<script>
let inquiriesData = [];

document.addEventListener('DOMContentLoaded', function() {
    loadInquiriesData();
});

async function loadInquiriesData() {
    const search = document.getElementById('searchInput').value.trim();
    const status = document.getElementById('statusFilter').value;

    const params = new URLSearchParams();
    if (search) params.append('search', search);
    if (status) params.append('status', status);

    try {
        const response = await fetch(`/admin/inquiries/data?${params.toString()}`, {
            headers: { 'Accept': 'application/json' }
        });
        const result = await response.json();

        if (result.status === 'success') {
            inquiriesData = result.data;
            renderInquiriesTable(inquiriesData);
            updateKpiInquiryStats(inquiriesData, result.unread_count);
        }
    } catch (err) {
        showToast('Gagal memuat inbox pesan masuk', 'error');
    }
}

let debounceTimer;
function debounceLoadInquiries() {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(loadInquiriesData, 300);
}

function resetInquiryFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('statusFilter').value = '';
    loadInquiriesData();
}

function renderInquiriesTable(items) {
    const tbody = document.getElementById('inquiriesTableBody');

    if (items.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="py-12 text-center text-on-surface-variant">
                    <span class="material-symbols-outlined text-[48px] block mb-2 opacity-50">mail</span>
                    Belum ada pesan masuk di inbox.
                </td>
            </tr>
        `;
        return;
    }

    tbody.innerHTML = items.map(item => {
        let statusBadge = '<span class="bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-1 rounded-full text-xs font-semibold flex items-center gap-1 w-max"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Baru</span>';
        if (item.status === 'read') {
            statusBadge = '<span class="bg-sky-50 text-sky-700 border border-sky-200 px-2.5 py-1 rounded-full text-xs font-semibold flex items-center gap-1 w-max"><span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span> Dibaca</span>';
        } else if (item.status === 'replied') {
            statusBadge = '<span class="bg-indigo-50 text-indigo-700 border border-indigo-200 px-2.5 py-1 rounded-full text-xs font-semibold flex items-center gap-1 w-max"><span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span> Selesai</span>';
        } else if (item.status === 'archived') {
            statusBadge = '<span class="bg-slate-100 text-slate-700 border border-slate-300 px-2.5 py-1 rounded-full text-xs font-semibold flex items-center gap-1 w-max"><span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Arsip</span>';
        }

        const dateStr = item.created_at ? new Date(item.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' }) : '-';
        const waUrl = item.whatsapp_url;
        const budgetBadge = item.budget_range 
            ? `<span class="inline-flex items-center gap-1 bg-amber-50 text-amber-800 border border-amber-200 px-2 py-0.5 rounded text-[11px] font-bold shrink-0"><span class="material-symbols-outlined text-[13px]">payments</span> ${escapeHtml(item.budget_range)}</span>`
            : '';

        return `
            <tr class="hover:bg-surface-container-low/50 transition-colors ${item.status === 'new' ? 'bg-emerald-50/20 font-medium' : ''}">
                <td class="py-4 px-6 max-w-xs">
                    <h3 class="font-bold text-on-surface text-label-md line-clamp-1">${escapeHtml(item.name)}</h3>
                    <p class="text-body-md text-primary font-mono text-xs line-clamp-1">${escapeHtml(item.email)}</p>
                    <p class="text-xs text-on-surface-variant font-mono mt-0.5">${escapeHtml(item.phone || '-')}</p>
                </td>
                <td class="py-4 px-6 max-w-md">
                    <div class="flex flex-wrap items-center gap-2 mb-1">
                        <h4 class="font-bold text-on-surface text-body-md line-clamp-1">${escapeHtml(item.subject)}</h4>
                        ${budgetBadge}
                    </div>
                    <p class="text-body-md text-on-surface-variant line-clamp-2 text-xs">${escapeHtml(item.message)}</p>
                </td>
                <td class="py-4 px-6 text-xs text-on-surface-variant font-mono whitespace-nowrap">
                    ${dateStr}
                </td>
                <td class="py-4 px-6">
                    ${statusBadge}
                </td>
                <td class="py-4 px-6 text-right space-x-1 whitespace-nowrap">
                    ${waUrl ? `
                        <a href="${waUrl}" target="_blank" class="inline-flex items-center gap-1 bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-all soft-shadow" title="Balas via WhatsApp">
                            <span class="material-symbols-outlined text-[16px]">chat</span> WA
                        </a>
                    ` : ''}
                    <button type="button" onclick="openInquiryDetail(${item.id})" class="p-2 text-primary hover:bg-primary-fixed/50 rounded-lg transition-colors cursor-pointer" title="Lihat Detail Pesan">
                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                    </button>
                    <button type="button" onclick="deleteInquiry(${item.id})" class="p-2 text-error hover:bg-error-container/30 rounded-lg transition-colors cursor-pointer" title="Hapus Pesan">
                        <span class="material-symbols-outlined text-[20px]">delete</span>
                    </button>
                </td>
            </tr>
        `;
    }).join('');
}

function updateKpiInquiryStats(items, unreadCount) {
    document.getElementById('unreadBadge').textContent = `${unreadCount} Pesan Baru`;
    document.getElementById('statTotalInquiries').textContent = items.length;
    document.getElementById('statNewInquiries').textContent = unreadCount;
    document.getElementById('statRepliedInquiries').textContent = items.filter(i => i.status === 'replied').length;
    document.getElementById('statWaInquiries').textContent = items.filter(i => i.phone && i.phone !== '').length;
}

async function openInquiryDetail(id) {
    try {
        const response = await fetch(`/admin/inquiries/${id}`, {
            headers: { 'Accept': 'application/json' }
        });
        const result = await response.json();

        if (result.status === 'success') {
            const item = result.data;
            document.getElementById('currentInquiryId').value = item.id;
            document.getElementById('drawerName').textContent = item.name;
            document.getElementById('drawerEmail').textContent = item.email;
            document.getElementById('drawerPhone').textContent = item.phone || '-';
            document.getElementById('drawerSubject').textContent = item.subject;
            document.getElementById('drawerMessage').textContent = item.message;
            document.getElementById('drawerStatusSelect').value = item.status || 'read';

            const dateStr = item.created_at ? new Date(item.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' }) : '-';
            document.getElementById('drawerDateText').textContent = `Diterima pada: ${dateStr}`;

            const waBtnContainer = document.getElementById('drawerWaBtnContainer');
            if (item.whatsapp_url) {
                waBtnContainer.innerHTML = `
                    <a href="${item.whatsapp_url}" target="_blank" class="inline-flex items-center gap-1.5 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl text-xs font-bold transition-all soft-shadow">
                        <span class="material-symbols-outlined text-[18px]">chat</span> Balas WhatsApp
                    </a>
                `;
            } else {
                waBtnContainer.innerHTML = '';
            }

            const backdrop = document.getElementById('drawerBackdrop');
            const drawer = document.getElementById('inquiryDrawer');

            backdrop.classList.remove('hidden');
            setTimeout(() => {
                backdrop.classList.remove('opacity-0');
                drawer.classList.remove('translate-x-full');
            }, 10);

            loadInquiriesData();
        }
    } catch (err) {
        showToast('Gagal memuat detail pesan', 'error');
    }
}

function closeInquiryDrawer() {
    const backdrop = document.getElementById('drawerBackdrop');
    const drawer = document.getElementById('inquiryDrawer');

    backdrop.classList.add('opacity-0');
    drawer.classList.add('translate-x-full');

    setTimeout(() => {
        backdrop.classList.add('hidden');
    }, 300);
}

async function updateInquiryStatusFromDrawer() {
    const id = document.getElementById('currentInquiryId').value;
    const status = document.getElementById('drawerStatusSelect').value;

    try {
        const response = await fetch(`/admin/inquiries/${id}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status: status })
        });
        const result = await response.json();

        if (result.status === 'success') {
            showToast(result.message, 'success');
            closeInquiryDrawer();
            loadInquiriesData();
        }
    } catch (err) {
        showToast('Gagal memperbarui status pesan', 'error');
    }
}

async function deleteInquiry(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus pesan ini?')) return;

    try {
        const response = await fetch(`/admin/inquiries/${id}`, {
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
            showToast(result.message, 'success');
            loadInquiriesData();
        } else {
            showToast('Gagal menghapus pesan', 'error');
        }
    } catch (err) {
        showToast('Gagal terhubung ke server', 'error');
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
