<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'summary',
        'content',
        'category',
        'author_name',
        'author_role',
        'author_avatar',
        'image_url',
        'tags',
        'read_time',
        'status',
        'published_at',
        'focus_keyword',
        'meta_title',
        'canonical_url',
        'seo_score',
    ];

    protected $casts = [
        'tags' => 'array',
        'published_at' => 'datetime',
        'seo_score' => 'integer',
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
            'summary' => $this->summary ?? '',
            'content' => $this->content ?? '',
            'category' => $this->category ?? 'Teknologi',
            'author' => [
                'name' => $this->author_name ?? 'Tim Engineering rbtgtech',
                'avatar' => $this->author_avatar ?: '/logo-rbtgtech.png',
                'role' => $this->author_role ?? 'Lead Systems Architect',
            ],
            'published_at' => $this->published_at ? $this->published_at->format('Y-m-d') : date('Y-m-d'),
            'image_url' => $this->image_url ?: '/logo-rbtgtech.png',
            'tags' => is_array($this->tags) ? $this->tags : [],
            'read_time' => $this->read_time ?: '5 menit',
            'seo' => [
                'title' => $this->meta_title ?: $this->title,
                'description' => $this->summary,
                'image' => $this->image_url ?: '/logo-rbtgtech.png',
                'canonicalUrl' => $this->canonical_url,
                'type' => 'article',
                'publishDate' => $this->published_at ? $this->published_at->format('Y-m-d') : date('Y-m-d'),
                'author' => $this->author_name ?? 'Tim Engineering rbtgtech',
            ],
        ];
    }
}
