<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryAdminController extends Controller
{
    /**
     * Display category master SPA view.
     */
    public function index()
    {
        return view('admin.categories.index');
    }

    /**
     * Get JSON data of categories for AJAX SPA.
     */
    public function data(Request $request)
    {
        $query = Category::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        $categories = $query->orderBy('sort_order', 'asc')
            ->orderBy('name', 'asc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $categories
        ]);
    }

    /**
     * Store new category via AJAX.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'type' => 'required|in:article,portfolio,both',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
            'color' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        $category = new Category();
        $category->name = $validated['name'];
        $category->slug = Str::slug($validated['slug']);
        $category->type = $validated['type'];
        $category->description = $validated['description'] ?? '';
        $category->icon = ($validated['icon'] ?? null) ?: 'folder';
        $category->color = ($validated['color'] ?? null) ?: 'primary';
        $category->sort_order = $validated['sort_order'] ?? 0;
        $category->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Kategori baru berhasil ditambahkan!',
            'data' => $category
        ]);
    }

    /**
     * Show single category JSON for edit modal.
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $category
        ]);
    }

    /**
     * Update category via AJAX.
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $category->id,
            'type' => 'required|in:article,portfolio,both',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
            'color' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        $category->name = $validated['name'];
        $category->slug = Str::slug($validated['slug']);
        $category->type = $validated['type'];
        $category->description = $validated['description'] ?? '';
        $category->icon = ($validated['icon'] ?? null) ?: 'folder';
        $category->color = ($validated['color'] ?? null) ?: 'primary';
        $category->sort_order = $validated['sort_order'] ?? 0;
        $category->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Kategori berhasil diperbarui!',
            'data' => $category
        ]);
    }

    /**
     * Delete category via AJAX.
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Kategori berhasil dihapus!'
        ]);
    }
}
