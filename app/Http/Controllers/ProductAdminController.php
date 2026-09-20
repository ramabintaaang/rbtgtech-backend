<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductAdminController extends Controller
{
    /**
     * Display main products admin SPA view.
     */
    public function index()
    {
        return view('admin.products.index');
    }

    /**
     * Get JSON dataset of products for AJAX SPA.
     */
    public function data(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('tagline', 'like', "%{$search}%")
                  ->orWhere('summary', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $products = $query->orderBy('sort_order', 'asc')->orderBy('created_at', 'desc')->get();

        return response()->json([
            'status' => 'success',
            'data' => $products
        ]);
    }

    /**
     * Store new product via AJAX.
     */
    public function store(Request $request)
    {
        // Handle newline string format if submitted as text
        if ($request->has('features') && is_string($request->input('features'))) {
            $request->merge(['features' => array_values(array_filter(array_map('trim', explode("\n", $request->input('features')))))]);
        }
        if ($request->has('tech_stack') && is_string($request->input('tech_stack'))) {
            $request->merge(['tech_stack' => array_values(array_filter(array_map('trim', explode("\n", $request->input('tech_stack')))))]);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'category' => 'nullable|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'summary' => 'nullable|string',
            'description' => 'nullable|string',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string',
            'tech_stack' => 'nullable|array',
            'tech_stack.*' => 'nullable|string',
            'demo_url' => 'nullable|string|max:500',
            'image_url' => 'nullable|string|max:500',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
            'price_label' => 'nullable|string|max:255',
            'status' => 'required|string|in:published,draft,coming_soon,in_development',
            'sort_order' => 'nullable|integer',
        ], [
            'image_file.image' => 'File yang diunggah harus berupa gambar.',
            'image_file.mimes' => 'Format gambar harus JPG, PNG, WEBP, GIF, atau SVG.',
            'image_file.max' => 'Ukuran file gambar maksimal 5MB.',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Clean empty features/tech_stack array items
        if (isset($validated['features'])) {
            $validated['features'] = array_values(array_filter($validated['features']));
        }
        if (isset($validated['tech_stack'])) {
            $validated['tech_stack'] = array_values(array_filter($validated['tech_stack']));
        }

        // Process featured image upload
        $imageUrl = ($validated['image_url'] ?? null) ?: '/logo-rbtgtech.png';
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('products', $filename, 'public');
            $imageUrl = '/storage/products/' . $filename;
        }
        $validated['image_url'] = $imageUrl;
        unset($validated['image_file']);

        $product = Product::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Produk berhasil ditambahkan',
            'data' => $product
        ]);
    }

    /**
     * Show single product details for modal edit.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $product
        ]);
    }

    /**
     * Update product via AJAX.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Handle newline string format if submitted as text
        if ($request->has('features') && is_string($request->input('features'))) {
            $request->merge(['features' => array_values(array_filter(array_map('trim', explode("\n", $request->input('features')))))]);
        }
        if ($request->has('tech_stack') && is_string($request->input('tech_stack'))) {
            $request->merge(['tech_stack' => array_values(array_filter(array_map('trim', explode("\n", $request->input('tech_stack')))))]);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . $id,
            'category' => 'nullable|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'summary' => 'nullable|string',
            'description' => 'nullable|string',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string',
            'tech_stack' => 'nullable|array',
            'tech_stack.*' => 'nullable|string',
            'demo_url' => 'nullable|string|max:500',
            'image_url' => 'nullable|string|max:500',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
            'price_label' => 'nullable|string|max:255',
            'status' => 'required|string|in:published,draft,coming_soon,in_development',
            'sort_order' => 'nullable|integer',
        ], [
            'image_file.image' => 'File yang diunggah harus berupa gambar.',
            'image_file.mimes' => 'Format gambar harus JPG, PNG, WEBP, GIF, atau SVG.',
            'image_file.max' => 'Ukuran file gambar maksimal 5MB.',
        ]);

        if (isset($validated['features'])) {
            $validated['features'] = array_values(array_filter($validated['features']));
        }
        if (isset($validated['tech_stack'])) {
            $validated['tech_stack'] = array_values(array_filter($validated['tech_stack']));
        }

        // Process featured image upload
        $imageUrl = ($validated['image_url'] ?? null) ?: ($product->image_url ?: '/logo-rbtgtech.png');
        if ($request->hasFile('image_file')) {
            // Delete old uploaded image if stored locally
            if ($product->image_url && str_starts_with($product->image_url, '/storage/products/')) {
                $oldFile = str_replace('/storage/products/', '', $product->image_url);
                Storage::disk('public')->delete('products/' . $oldFile);
            }

            $file = $request->file('image_file');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('products', $filename, 'public');
            $imageUrl = '/storage/products/' . $filename;
        }
        $validated['image_url'] = $imageUrl;
        unset($validated['image_file']);

        $product->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Produk berhasil diperbarui',
            'data' => $product
        ]);
    }

    /**
     * Delete product.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Produk berhasil dihapus'
        ]);
    }
}
