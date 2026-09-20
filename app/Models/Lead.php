<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'name',
        'city',
        'rating',
        'user_ratings_total',
        'address',
        'phone',
        'email',
        'website',
        'maps_url',
        'status',
        'notes',
    ];

    /**
     * Get the phone number formatted for WhatsApp API.
     */
    public function getWaPhoneNumberAttribute()
    {
        if (!$this->phone) {
            return null;
        }

        // Remove any non-numeric characters
        $clean = preg_replace('/[^0-9]/', '', $this->phone);

        // If starts with 0, replace with 62 (Indonesia)
        if (str_starts_with($clean, '0')) {
            $clean = '62' . substr($clean, 1);
        }

        // If it starts with 8, prepend 62
        if (str_starts_with($clean, '8')) {
            $clean = '62' . $clean;
        }

        return $clean;
    }

    /**
     * Determine if the lead has a custom website vs just social media link.
     */
    public function getHasWebsiteAttribute()
    {
        if (!$this->website) {
            return false;
        }

        $web = strtolower($this->website);
        $socials = ['instagram.com', 'facebook.com', 'linktr.ee', 'g.page', 'tiktok.com', 'g.co', 'google.com'];
        foreach ($socials as $social) {
            if (str_contains($web, $social)) {
                return false;
            }
        }

        return true;
    }
}
