<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InvoiceAdminController extends Controller
{
    /**
     * Display listing of invoices.
     */
    public function index(Request $request)
    {
        $query = Invoice::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhere('billed_to', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $invoices = $query->orderBy('invoice_date', 'desc')
                          ->orderBy('id', 'desc')
                          ->paginate(15)
                          ->withQueryString();

        $totalCount = Invoice::count();
        $totalPaid = Invoice::where('status', 'paid')->sum('total_amount');
        $totalUnpaid = Invoice::where('status', 'unpaid')->sum('total_amount');

        return view('admin.invoices.index', compact('invoices', 'totalCount', 'totalPaid', 'totalUnpaid'));
    }

    /**
     * Show form for creating new invoice.
     */
    public function create()
    {
        $defaultInvoiceNumber = Invoice::generateNextInvoiceNumber();
        $defaultDate = Carbon::now()->format('Y-m-d');

        return view('admin.invoices.create', compact('defaultInvoiceNumber', 'defaultDate'));
    }

    /**
     * Store newly created invoice.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_number' => 'required|string|max:100|unique:invoices,invoice_number',
            'invoice_date' => 'required|date',
            'billed_to' => 'required|string|max:255',
            'billed_address' => 'nullable|string|max:500',
            'billed_phone' => 'nullable|string|max:50',
            'items' => 'required|array|min:1',
            'items.*.item' => 'required|string|max:255',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0',
            'status' => 'required|in:unpaid,paid,cancelled',
            'account_name' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'thank_you_text' => 'nullable|string|max:255',
            'issuer_name' => 'nullable|string|max:255',
            'issuer_contact' => 'nullable|string|max:255',
            'issuer_website' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Process items and calculate totals
        $cleanedItems = [];
        $totalAmount = 0;

        foreach ($validated['items'] as $rawItem) {
            $qty = (float) $rawItem['quantity'];
            $unitPrice = (float) $rawItem['unit_price'];
            $lineTotal = $qty * $unitPrice;

            $cleanedItems[] = [
                'item' => trim($rawItem['item']),
                'quantity' => $qty,
                'unit_price' => $unitPrice,
                'total' => $lineTotal,
            ];

            $totalAmount += $lineTotal;
        }

        $invoice = Invoice::create([
            'invoice_number' => trim($validated['invoice_number']),
            'invoice_date' => $validated['invoice_date'],
            'billed_to' => trim($validated['billed_to']),
            'billed_address' => $validated['billed_address'] ?? null,
            'billed_phone' => $validated['billed_phone'] ?? null,
            'items' => $cleanedItems,
            'total_amount' => $totalAmount,
            'status' => $validated['status'],
            'account_name' => (!empty($validated['account_name'])) ? $validated['account_name'] : 'RAMA BINTANG',
            'bank_name' => (!empty($validated['bank_name'])) ? $validated['bank_name'] : 'Bank Mandiri',
            'account_number' => (!empty($validated['account_number'])) ? $validated['account_number'] : '1350019554706',
            'thank_you_text' => (!empty($validated['thank_you_text'])) ? $validated['thank_you_text'] : 'Thank you!',
            'issuer_name' => (!empty($validated['issuer_name'])) ? $validated['issuer_name'] : 'Rama Bintang',
            'issuer_contact' => (!empty($validated['issuer_contact'])) ? $validated['issuer_contact'] : 'Semarang, Indonesia - 0895360531176',
            'issuer_website' => (!empty($validated['issuer_website'])) ? $validated['issuer_website'] : 'www.rbtgtech.com',
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('admin.invoices.print', $invoice->id)
            ->with('success', 'Nota berhasil dibuat! Silakan tinjau atau cetak.');
    }

    /**
     * Show print view for the invoice (matches user template 100%).
     */
    public function print(Invoice $invoice)
    {
        return view('admin.invoices.print', compact('invoice'));
    }

    /**
     * Show invoice detail (redirects to print view).
     */
    public function show(Invoice $invoice)
    {
        return redirect()->route('admin.invoices.print', $invoice->id);
    }

    /**
     * Show form for editing an invoice.
     */
    public function edit(Invoice $invoice)
    {
        return view('admin.invoices.edit', compact('invoice'));
    }

    /**
     * Update specified invoice.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'invoice_number' => 'required|string|max:100|unique:invoices,invoice_number,' . $invoice->id,
            'invoice_date' => 'required|date',
            'billed_to' => 'required|string|max:255',
            'billed_address' => 'nullable|string|max:500',
            'billed_phone' => 'nullable|string|max:50',
            'items' => 'required|array|min:1',
            'items.*.item' => 'required|string|max:255',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0',
            'status' => 'required|in:unpaid,paid,cancelled',
            'account_name' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'thank_you_text' => 'nullable|string|max:255',
            'issuer_name' => 'nullable|string|max:255',
            'issuer_contact' => 'nullable|string|max:255',
            'issuer_website' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        $cleanedItems = [];
        $totalAmount = 0;

        foreach ($validated['items'] as $rawItem) {
            $qty = (float) $rawItem['quantity'];
            $unitPrice = (float) $rawItem['unit_price'];
            $lineTotal = $qty * $unitPrice;

            $cleanedItems[] = [
                'item' => trim($rawItem['item']),
                'quantity' => $qty,
                'unit_price' => $unitPrice,
                'total' => $lineTotal,
            ];

            $totalAmount += $lineTotal;
        }

        $invoice->update([
            'invoice_number' => trim($validated['invoice_number']),
            'invoice_date' => $validated['invoice_date'],
            'billed_to' => trim($validated['billed_to']),
            'billed_address' => $validated['billed_address'] ?? null,
            'billed_phone' => $validated['billed_phone'] ?? null,
            'items' => $cleanedItems,
            'total_amount' => $totalAmount,
            'status' => $validated['status'],
            'account_name' => (!empty($validated['account_name'])) ? $validated['account_name'] : 'RAMA BINTANG',
            'bank_name' => (!empty($validated['bank_name'])) ? $validated['bank_name'] : 'Bank Mandiri',
            'account_number' => (!empty($validated['account_number'])) ? $validated['account_number'] : '1350019554706',
            'thank_you_text' => (!empty($validated['thank_you_text'])) ? $validated['thank_you_text'] : 'Thank you!',
            'issuer_name' => (!empty($validated['issuer_name'])) ? $validated['issuer_name'] : 'Rama Bintang',
            'issuer_contact' => (!empty($validated['issuer_contact'])) ? $validated['issuer_contact'] : 'Semarang, Indonesia - 0895360531176',
            'issuer_website' => (!empty($validated['issuer_website'])) ? $validated['issuer_website'] : 'www.rbtgtech.com',
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('admin.invoices.print', $invoice->id)
            ->with('success', 'Nota berhasil diperbarui!');
    }

    /**
     * Delete an invoice.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('admin.invoices.index')
            ->with('success', 'Nota #' . $invoice->invoice_number . ' berhasil dihapus.');
    }

    /**
     * Toggle invoice status (paid <-> unpaid).
     */
    public function toggleStatus(Invoice $invoice)
    {
        $newStatus = $invoice->status === 'paid' ? 'unpaid' : 'paid';
        $invoice->update(['status' => $newStatus]);

        return back()->with('success', "Status nota #{$invoice->invoice_number} diubah menjadi: {$newStatus}");
    }
}
