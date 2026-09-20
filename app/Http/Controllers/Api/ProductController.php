<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of published product items for Astro frontend.
     */
    public function index()
    {
        $products = Product::whereIn('status', ['published', 'coming_soon', 'in_development'])
            ->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn($item) => $item->toAstroArray());

        return response()->json([
            'status' => 'success',
            'data' => $products
        ]);
    }

    /**
     * Display the specified product item by slug for Astro frontend.
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->whereIn('status', ['published', 'coming_soon', 'in_development'])
            ->first();

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $product->toAstroArray()
        ]);
    }
}
