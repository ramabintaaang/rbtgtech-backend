<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'budget_range',
        'message',
        'status',
    ];

    protected $appends = [
        'whatsapp_url',
    ];

    /**
     * Accessor for 1-Click WhatsApp Direct Chat Link
     */
    public function getWhatsAppUrlAttribute(): ?string
    {
        if (!$this->phone) {
            return null;
        }

        // Clean phone number (replace leading 0 or +62 with 62)
        $phone = preg_replace('/[^0-9]/', '', $this->phone);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        $budgetInfo = $this->budget_range ? " (Estimasi Budget: {$this->budget_range})" : "";
        $text = rawurlencode("Halo {$this->name}, terima kasih telah menghubungi tim RBTG Tech terkait: '{$this->subject}'{$budgetInfo}. Apakah ada yang bisa kami bantu?");

        return "https://wa.me/{$phone}?text={$text}";
    }
}
