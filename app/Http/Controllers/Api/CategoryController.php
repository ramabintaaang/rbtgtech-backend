<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories for Astro frontend.
     */
    public function index(Request $request)
    {
        $query = Category::query();

        if ($request->filled('type')) {
            $query->forType($request->input('type'));
        }

        $categories = $query->orderBy('sort_order', 'asc')
            ->orderBy('name', 'asc')
            ->get()
            ->map(fn($cat) => $cat->toAstroArray());

        return response()->json([
            'status' => 'success',
            'data' => $categories
        ]);
    }
}
