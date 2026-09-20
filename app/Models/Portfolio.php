<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'client',
        'year',
        'summary',
        'description',
        'challenge',
        'solution',
        'results',
        'image_url',
        'gallery',
        'tech_stack',
        'live_url',
        'status',
        'focus_keyword',
        'meta_title',
        'canonical_url',
        'seo_score',
    ];

    protected $casts = [
        'results' => 'array',
        'gallery' => 'array',
        'tech_stack' => 'array',
        'seo_score' => 'integer',
    ];

    /**
     * Format payload for Astro frontend API consumption
     */
    public function toAstroArray(): array
    {
        $imageUrl = $this->image_url ?: '/logo-rbtgtech.png';
        if (str_starts_with($imageUrl, '/storage/')) {
            $imageUrl = url($imageUrl);
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'category' => $this->category ?? 'Enterprise System',
            'client' => $this->client ?? 'Klien RBTG Tech',
            'summary' => $this->summary ?? '',
            'description' => $this->description ?? '',
            'challenge' => $this->challenge ?? '',
            'solution' => $this->solution ?? '',
            'results' => is_array($this->results) ? $this->results : [],
            'image_url' => $imageUrl,
            'gallery' => is_array($this->gallery) ? $this->gallery : [],
            'tech_stack' => is_array($this->tech_stack) ? $this->tech_stack : ['Laravel', 'Astro', 'Tailwind CSS'],
            'live_url' => $this->live_url ?? '',
            'year' => (string) ($this->year ?? '2026'),
            'seo' => [
                'title' => $this->meta_title ?: $this->title,
                'description' => $this->summary,
                'image' => $imageUrl,
                'canonicalUrl' => $this->canonical_url,
                'type' => 'website',
            ],
        ];
    }
}
