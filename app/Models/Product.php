<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'tagline',
        'summary',
        'description',
        'features',
        'tech_stack',
        'demo_url',
        'image_url',
        'gallery',
        'price_label',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'features' => 'array',
        'tech_stack' => 'array',
        'gallery' => 'array',
        'sort_order' => 'integer',
    ];

    /**
     * Format payload for Astro frontend API consumption
     */
    public function toAstroArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'category' => $this->category ?? 'SaaS & Ready System',
            'tagline' => $this->tagline ?? '',
            'summary' => $this->summary ?? '',
            'description' => $this->description ?? '',
            'features' => is_array($this->features) ? $this->features : [],
            'tech_stack' => is_array($this->tech_stack) ? $this->tech_stack : ['Laravel', 'Astro', 'Tailwind CSS'],
            'demo_url' => $this->demo_url ?? '',
            'image_url' => $this->image_url ?: '/logo-rbtgtech.png',
            'gallery' => is_array($this->gallery) ? $this->gallery : [],
            'price_label' => $this->price_label ?? 'Konsultasi / Sewa',
            'status' => $this->status ?? 'published',
            'sort_order' => $this->sort_order ?? 0,
        ];
    }
}
