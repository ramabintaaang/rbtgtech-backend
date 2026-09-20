<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    /**
     * Display a listing of published portfolio items for Astro frontend.
     */
    public function index()
    {
        $portfolios = Portfolio::where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn($item) => $item->toAstroArray());

        return response()->json([
            'status' => 'success',
            'data' => $portfolios
        ]);
    }

    /**
     * Display the specified portfolio item by slug for Astro frontend.
     */
    public function show($slug)
    {
        $item = Portfolio::where('slug', $slug)
            ->where('status', 'published')
            ->first();

        if (!$item) {
            return response()->json([
                'status' => 'error',
                'message' => 'Portofolio tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $item->toAstroArray()
        ]);
    }
}
