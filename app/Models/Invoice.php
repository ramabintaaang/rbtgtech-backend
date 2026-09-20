<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'invoice_date',
        'billed_to',
        'billed_address',
        'billed_phone',
        'items',
        'total_amount',
        'status',
        'account_name',
        'bank_name',
        'account_number',
        'thank_you_text',
        'issuer_name',
        'issuer_contact',
        'issuer_website',
        'notes',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'items' => 'array',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Generate automatic sequential invoice number with format: INV{YYYYMMDD}-{seq}
     * Example: INV20260920-001
     */
    public static function generateNextInvoiceNumber(?Carbon $date = null): string
    {
        $date = $date ?? Carbon::now();
        $datePrefix = 'INV' . $date->format('Ymd') . '-';

        $latestInvoice = self::where('invoice_number', 'like', $datePrefix . '%')
            ->orderBy('invoice_number', 'desc')
            ->first();

        if ($latestInvoice) {
            $lastSeq = (int) substr($latestInvoice->invoice_number, -3);
            $nextSeq = str_pad($lastSeq + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $nextSeq = '001';
        }

        return $datePrefix . $nextSeq;
    }

    /**
     * Formatted date for display matching reference: e.g. "19 Sept 2026"
     */
    public function getFormattedDateAttribute(): string
    {
        if (!$this->invoice_date) {
            return '';
        }

        $carbon = Carbon::parse($this->invoice_date);
        $month = $carbon->format('M');
        if (strtolower($month) === 'sep') {
            $month = 'Sept';
        }
        return $carbon->format('d') . ' ' . $month . ' ' . $carbon->format('Y');
    }

    /**
     * Helper to format amounts like: "Rp. 450.000" or "Rp 450.000"
     */
    public static function formatRupiah($amount, bool $withDot = false): string
    {
        $formatted = number_format((float) $amount, 0, ',', '.');
        return $withDot ? 'Rp. ' . $formatted : 'Rp ' . $formatted;
    }
}
