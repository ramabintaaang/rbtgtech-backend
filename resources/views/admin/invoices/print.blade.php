<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->invoice_number }} - {{ $invoice->billed_to }}</title>
    <link rel="icon" type="image/png" href="{{ asset('logo-rbtgtech.png') }}"/>
    
    <!-- Google Fonts: Plus Jakarta Sans for body & Playfair Display for Invoice Serif Title -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        serif: ['"Playfair Display"', 'Georgia', 'serif'],
                    }
                }
            }
        }
    </script>

    <style>
        @media print {
            @page {
                size: A4 portrait;
                margin: 12mm 15mm 15mm 15mm;
            }
            body {
                background: #ffffff !important;
                color: #000000 !important;
                padding: 0 !important;
                margin: 0 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .no-print {
                display: none !important;
            }
            .print-container {
                box-shadow: none !important;
                border: none !important;
                max-width: 100% !important;
                width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
                min-height: auto !important;
            }
        }

        .font-invoice-serif {
            font-family: 'Playfair Display', Georgia, serif;
            letter-spacing: 0.05em;
        }

        .font-signature-serif {
            font-family: 'Playfair Display', Georgia, serif;
        }
    </style>
</head>
<body class="bg-neutral-100 font-sans text-neutral-900 min-h-screen py-6 sm:py-10 px-4 flex flex-col items-center">

    <!-- Top Action Bar (Disembunyikan saat cetak) -->
    <div class="no-print w-full max-w-[850px] mb-6 flex flex-wrap items-center justify-between gap-4 bg-white/90 backdrop-blur-md px-6 py-3.5 rounded-2xl shadow-sm border border-neutral-200">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.invoices.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-neutral-600 hover:text-neutral-900 transition-colors">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                <span>Daftar Nota</span>
            </a>
            <span class="text-neutral-300">|</span>
            <span class="text-xs font-bold px-3 py-1 rounded-full {{ $invoice->status === 'paid' ? 'bg-emerald-100 text-emerald-800' : ($invoice->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800') }}">
                {{ $invoice->status === 'paid' ? 'LUNAS' : ($invoice->status === 'cancelled' ? 'DIBATALKAN' : 'BELUM LUNAS') }}
            </span>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.invoices.edit', $invoice->id) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full border border-neutral-300 text-sm font-semibold text-neutral-700 hover:bg-neutral-50 transition-colors">
                <span class="material-symbols-outlined text-[18px]">edit</span>
                <span>Edit Nota</span>
            </a>
            <button onclick="window.print()" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow-md transition-all">
                <span class="material-symbols-outlined text-[18px]">print</span>
                <span>Cetak / Simpan PDF</span>
            </button>
        </div>
    </div>

    <!-- Paper Container (Matches User's Reference Layout Exactly) -->
    <div class="print-container bg-white w-full max-w-[850px] min-h-[1130px] p-10 sm:p-14 shadow-lg border border-neutral-200/80 rounded-xl flex flex-col justify-between">
        
        <!-- Top Half: Header & Items Table -->
        <div class="flex flex-col">
            <!-- 1. Header: Logo (Left) and INVOICE text (Right) -->
            <div class="flex items-start justify-between">
                <div class="flex items-center">
                    <img src="{{ asset('logo-invoice.png') }}" alt="RBTGTECH Logo" class="h-20 md:h-24 w-auto object-contain -ml-2">
                </div>
                <div class="text-right">
                    <h1 class="font-invoice-serif text-[42px] leading-tight font-bold text-black tracking-widest uppercase">
                        INVOICE
                    </h1>
                </div>
            </div>

            <!-- 2. Billed To & Invoice Metadata -->
            <div class="flex items-start justify-between mt-12 mb-8">
                <!-- Left: BILLED TO -->
                <div class="flex flex-col">
                    <span class="font-bold text-black text-sm tracking-wide uppercase">
                        BILLED TO:
                    </span>
                    <span class="text-black text-base font-medium mt-1">
                        {{ $invoice->billed_to }}
                    </span>
                    @if($invoice->billed_address)
                        <span class="text-neutral-600 text-sm mt-0.5 max-w-xs leading-relaxed">
                            {{ $invoice->billed_address }}
                        </span>
                    @endif
                    @if($invoice->billed_phone)
                        <span class="text-neutral-600 text-sm mt-0.5">
                            {{ $invoice->billed_phone }}
                        </span>
                    @endif
                </div>

                <!-- Right: Invoice No & Date -->
                <div class="text-right flex flex-col">
                    <div class="text-black text-sm">
                        <span class="font-medium">Invoice No.</span>
                        <span class="font-semibold ml-1">{{ $invoice->invoice_number }}</span>
                    </div>
                    <div class="text-black text-sm mt-0.5 font-medium">
                        {{ $invoice->formatted_date }}
                    </div>
                </div>
            </div>

            <!-- 3. Table of Items -->
            <div class="w-full mt-2">
                <!-- Top Line -->
                <div class="border-t-[1.5px] border-neutral-900 w-full mb-3"></div>

                <!-- Table Header -->
                <div class="grid grid-cols-12 gap-2 text-sm font-bold text-black pb-3">
                    <div class="col-span-6 font-bold">Item</div>
                    <div class="col-span-2 text-center font-bold">Quantity</div>
                    <div class="col-span-2 text-right font-bold">Unit Price</div>
                    <div class="col-span-2 text-right font-bold">Total</div>
                </div>

                <!-- Header Underline -->
                <div class="border-t-[1.5px] border-neutral-900 w-full"></div>

                <!-- Table Rows -->
                <div class="divide-y divide-neutral-200">
                    @foreach($invoice->items as $item)
                        <div class="grid grid-cols-12 gap-2 py-4 text-sm text-black items-center">
                            <div class="col-span-6 font-medium pr-2">
                                {{ $item['item'] ?? '' }}
                            </div>
                            <div class="col-span-2 text-center font-normal">
                                {{ $item['quantity'] ?? 1 }}
                            </div>
                            <div class="col-span-2 text-right font-normal whitespace-nowrap">
                                Rp. {{ number_format($item['unit_price'] ?? 0, 0, ',', '.') }}
                            </div>
                            <div class="col-span-2 text-right font-normal whitespace-nowrap">
                                Rp. {{ number_format($item['total'] ?? 0, 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Table Bottom Line -->
                <div class="border-t-[1.5px] border-neutral-900 w-full mt-1 mb-5"></div>

                <!-- Grand Total Row -->
                <div class="flex items-baseline justify-end gap-10">
                    <span class="text-2xl font-bold text-black tracking-tight">
                        Total
                    </span>
                    <span class="text-2xl font-bold text-black tracking-tight whitespace-nowrap">
                        Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            <!-- 4. Thank you! message -->
            <div class="mt-28 mb-16">
                <p class="text-2xl font-normal text-black font-sans">
                    {{ $invoice->thank_you_text ?? 'Thank you!' }}
                </p>
            </div>
        </div>

        <!-- Bottom Half: Footer Information -->
        <div class="flex items-end justify-between pt-8 border-t border-transparent">
            <!-- Left: PAYMENT INFORMATION -->
            <div class="flex flex-col text-sm leading-relaxed">
                <span class="font-bold text-black tracking-wider text-xs uppercase mb-1">
                    PAYMENT INFORMATION
                </span>
                <span class="font-semibold text-black uppercase">
                    {{ $invoice->account_name ?? 'RAMA BINTANG' }}
                </span>
                <span class="text-black">
                    {{ $invoice->bank_name ?? 'Bank Mandiri' }}
                </span>
                <span class="font-medium text-black">
                    {{ $invoice->account_number ?? '1350019554706' }}
                </span>
            </div>

            <!-- Right: Signature / Contact -->
            <div class="text-right flex flex-col items-end">
                <span class="font-signature-serif text-2xl font-bold text-black italic tracking-wide">
                    {{ $invoice->issuer_name ?? 'Rama Bintang' }}
                </span>
                <span class="text-sm text-neutral-800 mt-1">
                    {{ $invoice->issuer_contact ?? 'Semarang, Indonesia - 0895360531176' }}
                </span>
                <a href="https://{{ $invoice->issuer_website ?? 'www.rbtgtech.com' }}" target="_blank" class="text-sm text-neutral-800 hover:underline">
                    {{ $invoice->issuer_website ?? 'www.rbtgtech.com' }}
                </a>
            </div>
        </div>

    </div>

</body>
</html>
