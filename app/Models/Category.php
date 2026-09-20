<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'description',
        'icon',
        'color',
        'sort_order',
    ];

    /**
     * Helper scope for filtering by type
     */
    public function scopeForType($query, $type)
    {
        return $query->where(function ($q) use ($type) {
            $q->where('type', $type)
              ->orWhere('type', 'both');
        });
    }

    /**
     * Format payload for Astro API
     */
    public function toAstroArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'type' => $this->type,
            'description' => $this->description ?? '',
            'icon' => $this->icon ?? 'folder',
            'color' => $this->color ?? 'primary',
        ];
    }
}
