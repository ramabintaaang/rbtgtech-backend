@extends('layouts.app')

@section('title', 'Buat Nota Baru - RBTGTech')

@section('content')
<div class="px-margin-desktop py-lg max-w-[1200px] mx-auto flex flex-col gap-lg" 
     x-data="{
        items: [
            { item: 'SSD 128GB + Servis', quantity: 1, unit_price: 450000 }
        ],
        addItem() {
            this.items.push({ item: '', quantity: 1, unit_price: 0 });
        },
        removeItem(index) {
            if (this.items.length > 1) {
                this.items.splice(index, 1);
            }
        },
        rowTotal(item) {
            let q = parseFloat(item.quantity) || 0;
            let p = parseFloat(item.unit_price) || 0;
            return q * p;
        },
        grandTotal() {
            return this.items.reduce((acc, curr) => acc + this.rowTotal(curr), 0);
        },
        formatRupiah(amount) {
            return 'Rp ' + (amount || 0).toLocaleString('id-ID');
        }
     }">
    
    <!-- Navigation & Title -->
    <header class="flex flex-col md:flex-row md:items-end justify-between gap-md">
        <div>
            <div class="flex items-center gap-2 text-label-md text-on-surface-variant mb-1">
                <a href="{{ route('admin.invoices.index') }}" class="hover:text-primary transition-colors">Nota & Invoice</a>
                <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                <span class="text-primary font-bold">Buat Nota Baru</span>
            </div>
            <h1 class="text-headline-lg font-headline-lg text-on-surface">Buat Nota / Invoice Baru</h1>
            <p class="text-body-lg font-body-lg text-on-surface-variant">Nomor invoice otomatis, penerima dan baris item dinamis dengan hitungan realtime.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.invoices.index') }}" class="px-5 py-2.5 rounded-full border border-outline-variant text-on-surface hover:bg-surface-container-high transition-colors font-semibold text-label-md">
                Kembali
            </a>
        </div>
    </header>

    @if ($errors->any())
        <div class="bg-error-container/40 border border-error text-error rounded-2xl p-4 flex flex-col gap-1">
            <div class="flex items-center gap-2 font-bold">
                <span class="material-symbols-outlined">error</span>
                <span>Terdapat kesalahan pada input Anda:</span>
            </div>
            <ul class="list-disc list-inside text-body-sm pl-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.invoices.store') }}" class="flex flex-col gap-lg">
        @csrf

        <!-- Card 1: Informasi Utama Nota & Klien -->
        <div class="bg-surface-container-lowest rounded-3xl p-6 sm:p-8 soft-shadow border border-outline-variant/60 flex flex-col gap-6">
            <div class="flex items-center gap-3 border-b border-outline-variant/30 pb-4">
                <div class="w-10 h-10 rounded-xl bg-primary-container/20 flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[24px]">description</span>
                </div>
                <div>
                    <h2 class="text-title-lg font-bold text-on-surface">Informasi Nota & Penerima (Billed To)</h2>
                    <p class="text-body-sm text-on-surface-variant">Data penomoran resmi dan pihak yang ditagihkan.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Nomor Invoice -->
                <div>
                    <label class="block text-label-md font-bold text-on-surface mb-1.5">
                        Nomor Invoice <span class="text-primary text-xs font-normal">(Otomatis)</span>
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">tag</span>
                        <input 
                            type="text" 
                            name="invoice_number" 
                            value="{{ old('invoice_number', $defaultInvoiceNumber) }}" 
                            required 
                            class="w-full pl-10 pr-4 py-2.5 bg-surface-container-low rounded-xl border border-outline-variant/50 text-on-surface font-semibold focus:outline-none focus:ring-2 focus:ring-primary/50 text-body-md"
                        >
                    </div>
                </div>

                <!-- Tanggal Invoice -->
                <div>
                    <label class="block text-label-md font-bold text-on-surface mb-1.5">
                        Tanggal Invoice
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">calendar_today</span>
                        <input 
                            type="date" 
                            name="invoice_date" 
                            value="{{ old('invoice_date', $defaultDate) }}" 
                            required 
                            class="w-full pl-10 pr-4 py-2.5 bg-surface-container-low rounded-xl border border-outline-variant/50 text-on-surface font-medium focus:outline-none focus:ring-2 focus:ring-primary/50 text-body-md"
                        >
                    </div>
                </div>

                <!-- Status Pembayaran -->
                <div>
                    <label class="block text-label-md font-bold text-on-surface mb-1.5">
                        Status Pembayaran
                    </label>
                    <select 
                        name="status" 
                        class="w-full px-4 py-2.5 bg-surface-container-low rounded-xl border border-outline-variant/50 text-on-surface font-semibold focus:outline-none focus:ring-2 focus:ring-primary/50 text-body-md"
                    >
                        <option value="unpaid" {{ old('status') === 'unpaid' ? 'selected' : '' }}>⏳ Belum Lunas (Unpaid)</option>
                        <option value="paid" {{ old('status') === 'paid' ? 'selected' : '' }}>✅ Lunas (Paid)</option>
                        <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>❌ Dibatalkan</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2 border-t border-outline-variant/20">
                <!-- Billed To (Penerima) -->
                <div>
                    <label class="block text-label-md font-bold text-on-surface mb-1.5">
                        BILLED TO (Nama Klien / Instansi) <span class="text-error">*</span>
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">business</span>
                        <input 
                            type="text" 
                            name="billed_to" 
                            value="{{ old('billed_to', 'Lab IBL') }}" 
                            placeholder="Contoh: Lab IBL, PT ABC, Bpk. Ahmad" 
                            required 
                            class="w-full pl-10 pr-4 py-2.5 bg-surface-container-low rounded-xl border border-outline-variant/50 text-on-surface font-semibold focus:outline-none focus:ring-2 focus:ring-primary/50 text-body-md"
                        >
                    </div>
                </div>

                <!-- Kontak / Telepon Klien (Opsional) -->
                <div>
                    <label class="block text-label-md font-bold text-on-surface mb-1.5">
                        No. Telepon / WhatsApp Klien <span class="text-on-surface-variant text-xs font-normal">(Opsional)</span>
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">phone</span>
                        <input 
                            type="text" 
                            name="billed_phone" 
                            value="{{ old('billed_phone') }}" 
                            placeholder="Contoh: 081234567890" 
                            class="w-full pl-10 pr-4 py-2.5 bg-surface-container-low rounded-xl border border-outline-variant/50 text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/50 text-body-md"
                        >
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Rincian Item Nota (Dinamis dengan Alpine.js) -->
        <div class="bg-surface-container-lowest rounded-3xl p-6 sm:p-8 soft-shadow border border-outline-variant/60 flex flex-col gap-6">
            <div class="flex items-center justify-between border-b border-outline-variant/30 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-primary-container/20 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-[24px]">list_alt</span>
                    </div>
                    <div>
                        <h2 class="text-title-lg font-bold text-on-surface">Daftar Item / Jasa Layanan</h2>
                        <p class="text-body-sm text-on-surface-variant">Tambahkan satu atau lebih baris item tagihan.</p>
                    </div>
                </div>
                <button 
                    type="button" 
                    @click="addItem()" 
                    class="bg-surface-container-high hover:bg-outline-variant/40 text-primary rounded-full px-4 py-2 flex items-center gap-2 transition-all font-label-md text-label-md font-bold"
                >
                    <span class="material-symbols-outlined text-[18px]">add</span>
                    Tambah Baris Item
                </button>
            </div>

            <!-- Tabel Item -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b-2 border-on-surface text-label-md font-bold uppercase tracking-wider text-on-surface">
                            <th class="py-3 px-3 w-12 text-center">#</th>
                            <th class="py-3 px-3">Deskripsi Item / Layanan</th>
                            <th class="py-3 px-3 w-28 text-center">Quantity</th>
                            <th class="py-3 px-3 w-44 text-right">Unit Price (Rp)</th>
                            <th class="py-3 px-3 w-48 text-right">Total (Rp)</th>
                            <th class="py-3 px-3 w-16 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/30">
                        <template x-for="(item, index) in items" :key="index">
                            <tr class="hover:bg-surface-container-low/30 transition-colors">
                                <td class="py-3 px-3 text-center text-on-surface-variant font-bold text-body-md" x-text="index + 1"></td>
                                <td class="py-3 px-3">
                                    <input 
                                        type="text" 
                                        :name="'items[' + index + '][item]'" 
                                        x-model="item.item" 
                                        placeholder="Contoh: SSD 128GB + Servis" 
                                        required 
                                        class="w-full px-3 py-2 bg-surface-container-low rounded-xl border border-outline-variant/40 text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/50 text-body-md font-medium"
                                    >
                                </td>
                                <td class="py-3 px-3">
                                    <input 
                                        type="number" 
                                        :name="'items[' + index + '][quantity]'" 
                                        x-model.number="item.quantity" 
                                        min="1" 
                                        step="1" 
                                        required 
                                        class="w-full px-3 py-2 text-center bg-surface-container-low rounded-xl border border-outline-variant/40 text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/50 text-body-md font-semibold"
                                    >
                                </td>
                                <td class="py-3 px-3">
                                    <input 
                                        type="number" 
                                        :name="'items[' + index + '][unit_price]'" 
                                        x-model.number="item.unit_price" 
                                        min="0" 
                                        step="1000" 
                                        required 
                                        class="w-full px-3 py-2 text-right bg-surface-container-low rounded-xl border border-outline-variant/40 text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/50 text-body-md font-semibold"
                                    >
                                </td>
                                <td class="py-3 px-3 text-right font-bold text-on-surface whitespace-nowrap text-body-md" x-text="formatRupiah(rowTotal(item))"></td>
                                <td class="py-3 px-3 text-center">
                                    <button 
                                        type="button" 
                                        @click="removeItem(index)" 
                                        :disabled="items.length <= 1"
                                        class="p-1.5 text-error hover:bg-error-container/20 disabled:opacity-30 disabled:cursor-not-allowed rounded-lg transition-colors"
                                        title="Hapus baris ini"
                                    >
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                    <tfoot>
                        <tr class="border-t-2 border-on-surface">
                            <td colspan="4" class="py-4 px-6 text-right font-bold text-headline-md text-on-surface">
                                Total
                            </td>
                            <td class="py-4 px-3 text-right font-bold text-headline-md text-on-surface whitespace-nowrap" x-text="formatRupiah(grandTotal())"></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="flex justify-start">
                <button 
                    type="button" 
                    @click="addItem()" 
                    class="border-2 border-dashed border-outline-variant hover:border-primary text-primary hover:bg-primary/5 rounded-2xl py-3 px-6 w-full flex items-center justify-center gap-2 font-bold text-label-md transition-all"
                >
                    <span class="material-symbols-outlined">add_circle</span>
                    + Tambah Baris Item Baru
                </button>
            </div>
        </div>

        <!-- Card 3: Informasi Pembayaran & Footer Nota (Default Rekening Anda) -->
        <div class="bg-surface-container-lowest rounded-3xl p-6 sm:p-8 soft-shadow border border-outline-variant/60 flex flex-col gap-6" x-data="{ showAdvanced: false }">
            <div class="flex items-center justify-between border-b border-outline-variant/30 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-primary-container/20 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-[24px]">account_balance</span>
                    </div>
                    <div>
                        <h2 class="text-title-lg font-bold text-on-surface">Informasi Rekening & Footer Nota</h2>
                        <p class="text-body-sm text-on-surface-variant">Default sudah terisi rekening Mandiri Rama Bintang (dapat disesuaikan jika perlu).</p>
                    </div>
                </div>
                <button 
                    type="button" 
                    @click="showAdvanced = !showAdvanced" 
                    class="text-label-md font-semibold text-primary hover:underline flex items-center gap-1"
                >
                    <span x-text="showAdvanced ? 'Sembunyikan Opsi Rekening' : 'Edit Info Rekening & Kontak'"></span>
                    <span class="material-symbols-outlined text-[18px]" :class="{ 'rotate-180': showAdvanced }">expand_more</span>
                </button>
            </div>

            <!-- Preview Rekening Saat Ini -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-surface-container-low p-4 rounded-2xl border border-outline-variant/30">
                <div>
                    <span class="text-label-sm font-bold text-on-surface-variant uppercase">Payment Information:</span>
                    <p class="text-body-md font-bold text-on-surface mt-1">RAMA BINTANG</p>
                    <p class="text-body-sm text-on-surface-variant">Bank Mandiri — <span class="font-semibold text-on-surface">1350019554706</span></p>
                </div>
                <div>
                    <span class="text-label-sm font-bold text-on-surface-variant uppercase">Kontak & Tanda Tangan:</span>
                    <p class="text-body-md font-bold text-on-surface mt-1">Rama Bintang</p>
                    <p class="text-body-sm text-on-surface-variant">Semarang, Indonesia - 0895360531176 | www.rbtgtech.com</p>
                </div>
            </div>

            <!-- Form Edit Advanced Info (Hidden by default) -->
            <div x-show="showAdvanced" x-transition class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-2">
                <div>
                    <label class="block text-label-sm font-bold text-on-surface mb-1">Nama Pemilik Rekening</label>
                    <input 
                        type="text" 
                        name="account_name" 
                        value="{{ old('account_name', 'RAMA BINTANG') }}" 
                        class="w-full px-3 py-2 bg-surface-container-low rounded-xl border border-outline-variant/40 text-on-surface text-body-md"
                    >
                </div>
                <div>
                    <label class="block text-label-sm font-bold text-on-surface mb-1">Nama Bank</label>
                    <input 
                        type="text" 
                        name="bank_name" 
                        value="{{ old('bank_name', 'Bank Mandiri') }}" 
                        class="w-full px-3 py-2 bg-surface-container-low rounded-xl border border-outline-variant/40 text-on-surface text-body-md"
                    >
                </div>
                <div>
                    <label class="block text-label-sm font-bold text-on-surface mb-1">Nomor Rekening</label>
                    <input 
                        type="text" 
                        name="account_number" 
                        value="{{ old('account_number', '1350019554706') }}" 
                        class="w-full px-3 py-2 bg-surface-container-low rounded-xl border border-outline-variant/40 text-on-surface text-body-md"
                    >
                </div>
                <div>
                    <label class="block text-label-sm font-bold text-on-surface mb-1">Pesan Penutup</label>
                    <input 
                        type="text" 
                        name="thank_you_text" 
                        value="{{ old('thank_you_text', 'Thank you!') }}" 
                        class="w-full px-3 py-2 bg-surface-container-low rounded-xl border border-outline-variant/40 text-on-surface text-body-md"
                    >
                </div>
                <div>
                    <label class="block text-label-sm font-bold text-on-surface mb-1">Nama Footer / Signature</label>
                    <input 
                        type="text" 
                        name="issuer_name" 
                        value="{{ old('issuer_name', 'Rama Bintang') }}" 
                        class="w-full px-3 py-2 bg-surface-container-low rounded-xl border border-outline-variant/40 text-on-surface text-body-md"
                    >
                </div>
                <div>
                    <label class="block text-label-sm font-bold text-on-surface mb-1">Kontak Footer</label>
                    <input 
                        type="text" 
                        name="issuer_contact" 
                        value="{{ old('issuer_contact', 'Semarang, Indonesia - 0895360531176') }}" 
                        class="w-full px-3 py-2 bg-surface-container-low rounded-xl border border-outline-variant/40 text-on-surface text-body-md"
                    >
                </div>
            </div>
        </div>

        <!-- Tombol Aksi Simpan -->
        <div class="flex items-center justify-end gap-4 py-4">
            <a href="{{ route('admin.invoices.index') }}" class="px-6 py-3 rounded-full border border-outline-variant text-on-surface hover:bg-surface-container-high transition-colors font-semibold text-label-md">
                Batal
            </a>
            <button 
                type="submit" 
                class="bg-primary hover:bg-surface-tint text-on-primary rounded-full px-8 py-3.5 flex items-center gap-2.5 transition-all font-bold text-label-lg shadow-md hover:shadow-lg transform active:scale-98"
            >
                <span class="material-symbols-outlined text-[22px]">print</span>
                <span>Simpan & Tampilkan Nota Siap Cetak</span>
            </button>
        </div>
    </form>
</div>
@endsection
