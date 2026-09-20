@extends('layouts.app')

@section('title', 'Manajemen Nota & Invoice - RBTGTech')

@section('content')
<div class="px-margin-desktop py-lg max-w-[1440px] mx-auto flex flex-col gap-lg" x-data="{ deleteModalOpen: false, deleteActionUrl: '', deleteInvoiceNumber: '' }">
    <!-- Header Section -->
    <header class="flex flex-col md:flex-row md:items-end justify-between gap-md">
        <div>
            <div class="flex items-center gap-2 text-label-md text-on-surface-variant mb-1">
                <a href="{{ route('dashboard') }}" class="hover:text-primary transition-colors">Dashboard</a>
                <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                <span class="text-primary font-bold">Nota & Invoice</span>
            </div>
            <h1 class="text-headline-lg font-headline-lg text-on-surface">Manajemen Nota & Invoice</h1>
            <p class="text-body-lg font-body-lg text-on-surface-variant">Buat, kelola, dan cetak nota resmi klien RBTGTech secara instan.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.invoices.create') }}" class="bg-primary hover:bg-surface-tint text-on-primary rounded-full px-6 py-2.5 flex items-center gap-2 transition-all font-label-md text-label-md shadow-sm">
                <span class="material-symbols-outlined text-[20px]">add_circle</span>
                <span>Buat Nota Baru</span>
            </a>
        </div>
    </header>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl p-4 flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                <p class="font-medium text-body-md">{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>
    @endif

    <!-- Metric Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
        <div class="bg-surface-container-lowest rounded-2xl p-6 soft-shadow border border-outline-variant/60 flex items-center justify-between">
            <div>
                <span class="text-label-sm font-bold text-on-surface-variant uppercase tracking-wider">Total Nota Terbit</span>
                <h3 class="text-headline-md font-bold text-on-surface mt-2">{{ number_format($totalCount) }}</h3>
                <p class="text-body-sm text-on-surface-variant mt-0.5">Semua riwayat transaksi</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-primary-container/20 flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-[26px]">receipt_long</span>
            </div>
        </div>

        <div class="bg-surface-container-lowest rounded-2xl p-6 soft-shadow border border-outline-variant/60 flex items-center justify-between">
            <div>
                <span class="text-label-sm font-bold text-emerald-700 uppercase tracking-wider">Total Terbayar (Lunas)</span>
                <h3 class="text-headline-md font-bold text-emerald-600 mt-2">Rp {{ number_format($totalPaid, 0, ',', '.') }}</h3>
                <p class="text-body-sm text-on-surface-variant mt-0.5">Invoice berstatus Lunas</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center text-emerald-700">
                <span class="material-symbols-outlined text-[26px]">paid</span>
            </div>
        </div>

        <div class="bg-surface-container-lowest rounded-2xl p-6 soft-shadow border border-outline-variant/60 flex items-center justify-between">
            <div>
                <span class="text-label-sm font-bold text-amber-700 uppercase tracking-wider">Pending / Belum Lunas</span>
                <h3 class="text-headline-md font-bold text-amber-600 mt-2">Rp {{ number_format($totalUnpaid, 0, ',', '.') }}</h3>
                <p class="text-body-sm text-on-surface-variant mt-0.5">Menunggu konfirmasi bayar</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-100 flex items-center justify-center text-amber-700">
                <span class="material-symbols-outlined text-[26px]">hourglass_top</span>
            </div>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-surface-container-lowest rounded-2xl p-4 soft-shadow border border-outline-variant/60 flex flex-col md:flex-row gap-4 items-center justify-between">
        <form method="GET" action="{{ route('admin.invoices.index') }}" class="flex flex-col sm:flex-row gap-3 w-full md:w-auto flex-grow">
            <div class="relative flex-grow max-w-md">
                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">search</span>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari nomor nota atau nama klien..." 
                    class="w-full pl-10 pr-4 py-2 bg-surface-container-low rounded-xl border border-outline-variant/40 text-on-surface placeholder:text-on-surface-variant/60 focus:outline-none focus:ring-2 focus:ring-primary/50 text-body-md"
                >
            </div>

            <select 
                name="status" 
                onchange="this.form.submit()" 
                class="px-4 py-2 bg-surface-container-low rounded-xl border border-outline-variant/40 text-on-surface text-body-md focus:outline-none focus:ring-2 focus:ring-primary/50"
            >
                <option value="">Semua Status</option>
                <option value="unpaid" {{ request('status') === 'unpaid' ? 'selected' : '' }}>Belum Lunas</option>
                <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Lunas</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
            </select>

            <button type="submit" class="bg-surface-container-high hover:bg-outline-variant/40 text-on-surface px-4 py-2 rounded-xl text-label-md font-semibold transition-colors">
                Filter
            </button>

            @if(request('search') || request('status'))
                <a href="{{ route('admin.invoices.index') }}" class="text-error hover:underline text-label-md font-semibold flex items-center gap-1 self-center">
                    <span class="material-symbols-outlined text-[18px]">clear</span> Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Invoices Table -->
    <div class="bg-surface-container-lowest rounded-2xl soft-shadow border border-outline-variant/60 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-outline-variant/40 bg-surface-container-low/40 text-label-sm font-bold uppercase tracking-wider text-on-surface-variant">
                        <th class="py-4 px-6">Nomor Invoice</th>
                        <th class="py-4 px-6">Tanggal</th>
                        <th class="py-4 px-6">Klien (Billed To)</th>
                        <th class="py-4 px-6 text-center">Items</th>
                        <th class="py-4 px-6 text-right">Total Tagihan</th>
                        <th class="py-4 px-6 text-center">Status</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/20 text-body-md text-on-surface">
                    @forelse($invoices as $invoice)
                        <tr class="hover:bg-surface-container-low/30 transition-colors">
                            <td class="py-4 px-6">
                                <a href="{{ route('admin.invoices.print', $invoice->id) }}" class="font-bold text-primary hover:underline flex items-center gap-1.5" title="Klik untuk lihat & cetak">
                                    <span class="material-symbols-outlined text-[18px]">receipt</span>
                                    <span>{{ $invoice->invoice_number }}</span>
                                </a>
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap text-on-surface-variant">
                                {{ $invoice->formatted_date }}
                            </td>
                            <td class="py-4 px-6">
                                <span class="font-semibold text-on-surface">{{ $invoice->billed_to }}</span>
                                @if($invoice->billed_phone)
                                    <span class="block text-label-sm text-on-surface-variant">{{ $invoice->billed_phone }}</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span class="bg-surface-container-high px-2.5 py-0.5 rounded-full text-label-sm font-semibold text-on-surface-variant">
                                    {{ count($invoice->items ?? []) }} item
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right font-bold text-on-surface whitespace-nowrap">
                                Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-6 text-center whitespace-nowrap">
                                <form method="POST" action="{{ route('admin.invoices.toggle-status', $invoice->id) }}" class="inline">
                                    @csrf
                                    <button 
                                        type="submit" 
                                        title="Klik untuk ubah status"
                                        class="cursor-pointer transition-transform hover:scale-105 inline-flex items-center gap-1 px-3 py-1 rounded-full text-label-sm font-bold {{ $invoice->status === 'paid' ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : ($invoice->status === 'cancelled' ? 'bg-red-100 text-red-800 border border-red-200' : 'bg-amber-100 text-amber-800 border border-amber-200') }}"
                                    >
                                        <span class="material-symbols-outlined text-[14px]">{{ $invoice->status === 'paid' ? 'check_circle' : 'pending' }}</span>
                                        <span>{{ $invoice->status === 'paid' ? 'LUNAS' : ($invoice->status === 'cancelled' ? 'DIBATALKAN' : 'BELUM LUNAS') }}</span>
                                    </button>
                                </form>
                            </td>
                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <a 
                                        href="{{ route('admin.invoices.print', $invoice->id) }}" 
                                        class="p-2 text-primary hover:bg-primary-container/20 rounded-xl transition-colors" 
                                        title="Cetak Nota / Save PDF"
                                    >
                                        <span class="material-symbols-outlined text-[20px]">print</span>
                                    </a>
                                    <a 
                                        href="{{ route('admin.invoices.edit', $invoice->id) }}" 
                                        class="p-2 text-on-surface-variant hover:bg-surface-container-high rounded-xl transition-colors" 
                                        title="Edit Nota"
                                    >
                                        <span class="material-symbols-outlined text-[20px]">edit</span>
                                    </a>
                                    <button 
                                        type="button" 
                                        @click="deleteModalOpen = true; deleteActionUrl = '{{ route('admin.invoices.destroy', $invoice->id) }}'; deleteInvoiceNumber = '{{ $invoice->invoice_number }}'"
                                        class="p-2 text-error hover:bg-error-container/20 rounded-xl transition-colors" 
                                        title="Hapus Nota"
                                    >
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-on-surface-variant">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <div class="w-16 h-16 rounded-full bg-surface-container-high flex items-center justify-center text-on-surface-variant">
                                        <span class="material-symbols-outlined text-[32px]">receipt_long</span>
                                    </div>
                                    <p class="text-title-md font-semibold text-on-surface">Belum ada nota yang dibuat</p>
                                    <p class="text-body-md max-w-md">Klik tombol di bawah untuk membuat nota baru untuk klien Anda.</p>
                                    <a href="{{ route('admin.invoices.create') }}" class="mt-2 bg-primary text-on-primary rounded-full px-5 py-2 text-label-md font-semibold hover:bg-surface-tint transition-colors">
                                        + Buat Nota Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($invoices->hasPages())
            <div class="p-4 border-t border-outline-variant/30">
                {{ $invoices->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div 
        x-show="deleteModalOpen" 
        x-cloak 
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-on-surface/40 backdrop-blur-xs"
    >
        <div 
            @click.outside="deleteModalOpen = false" 
            class="bg-surface-container-lowest rounded-3xl p-6 max-w-md w-full soft-shadow border border-outline-variant/60 flex flex-col gap-4"
        >
            <div class="flex items-center gap-3 text-error">
                <div class="w-12 h-12 rounded-2xl bg-error-container/30 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[28px]">warning</span>
                </div>
                <div>
                    <h3 class="text-title-lg font-bold text-on-surface">Hapus Nota?</h3>
                    <p class="text-body-sm text-on-surface-variant">Tindakan ini tidak dapat dibatalkan.</p>
                </div>
            </div>

            <p class="text-body-md text-on-surface">
                Apakah Anda yakin ingin menghapus nota <span class="font-bold text-primary" x-text="deleteInvoiceNumber"></span>?
            </p>

            <div class="flex items-center justify-end gap-3 mt-2">
                <button 
                    type="button" 
                    @click="deleteModalOpen = false" 
                    class="px-5 py-2.5 rounded-full border border-outline-variant text-on-surface hover:bg-surface-container-high transition-colors font-semibold text-label-md"
                >
                    Batal
                </button>
                <form :action="deleteActionUrl" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button 
                        type="submit" 
                        class="px-5 py-2.5 rounded-full bg-error text-on-error hover:bg-error/90 transition-colors font-semibold text-label-md shadow-sm"
                    >
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
