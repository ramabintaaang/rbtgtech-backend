<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PortfolioAdminController extends Controller
{
    /**
     * Display main portfolio admin SPA view.
     */
    public function index()
    {
        $categories = \App\Models\Category::forType('portfolio')->orderBy('sort_order', 'asc')->get();
        return view('admin.portfolio.index', compact('categories'));
    }

    /**
     * Get JSON dataset of portfolios for AJAX SPA.
     */
    public function data(Request $request)
    {
        $query = Portfolio::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('client', 'like', "%{$search}%")
                  ->orWhere('summary', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $portfolios = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'status' => 'success',
            'data' => $portfolios
        ]);
    }

    /**
     * Store new portfolio via AJAX.
     */
    public function store(Request $request)
    {
        // Auto-sanitize slug or derive from title
        $rawSlug = $request->input('slug') ?: $request->input('title');
        $slug = Str::slug($rawSlug);
        if (empty($slug)) {
            $slug = 'proyek-' . time();
        }

        // Ensure unique slug automatically
        $originalSlug = $slug;
        $counter = 1;
        while (Portfolio::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }
        $request->merge(['slug' => $slug]);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:portfolios,slug',
            'category' => 'required|string',
            'client' => 'nullable|string',
            'year' => 'nullable|string',
            'summary' => 'nullable|string',
            'description' => 'nullable|string',
            'challenge' => 'nullable|string',
            'solution' => 'nullable|string',
            'results_input' => 'nullable|string',
            'image_url' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
            'tech_stack_input' => 'nullable|string',
            'live_url' => 'nullable|string',
            'status' => 'required|in:published,draft',
            'focus_keyword' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'canonical_url' => 'nullable|string',
            'seo_score' => 'nullable|integer|min:0|max:100',
        ], [
            'title.required' => 'Judul proyek wajib diisi.',
            'category.required' => 'Kategori proyek wajib dipilih.',
            'status.required' => 'Status publikasi wajib dipilih.',
            'image_file.image' => 'File yang diunggah harus berupa format gambar (JPG, PNG, WEBP, GIF, SVG).',
            'image_file.mimes' => 'Format gambar harus JPEG, PNG, JPG, GIF, WEBP, atau SVG.',
            'image_file.max' => 'Ukuran file gambar maksimal 5MB.',
        ]);

        $results = [];
        if (!empty($validated['results_input'])) {
            $results = array_filter(array_map('trim', explode("\n", $validated['results_input'])));
        }

        $techStack = [];
        if (!empty($validated['tech_stack_input'])) {
            $techStack = array_filter(array_map('trim', explode(',', $validated['tech_stack_input'])));
        }

        // Process cover image upload
        $imageUrl = ($validated['image_url'] ?? null) ?: '/logo-rbtgtech.png';
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('portfolios', $filename, 'public');
            $imageUrl = '/storage/portfolios/' . $filename;
        }

        $portfolio = new Portfolio();
        $portfolio->title = $validated['title'];
        $portfolio->slug = Str::slug($validated['slug']);
        $portfolio->category = $validated['category'];
        $portfolio->client = ($validated['client'] ?? null) ?: 'Klien RBTG Tech';
        $portfolio->year = ($validated['year'] ?? null) ?: date('Y');
        $portfolio->summary = $validated['summary'] ?? '';
        $portfolio->description = $validated['description'] ?? '';
        $portfolio->challenge = $validated['challenge'] ?? '';
        $portfolio->solution = $validated['solution'] ?? '';
        $portfolio->results = array_values($results);
        $portfolio->image_url = $imageUrl;
        $portfolio->tech_stack = array_values($techStack);
        $portfolio->live_url = $validated['live_url'] ?? '';
        $portfolio->status = $validated['status'];
        $portfolio->focus_keyword = $validated['focus_keyword'] ?? '';
        $portfolio->meta_title = ($validated['meta_title'] ?? null) ?: $validated['title'];
        $portfolio->canonical_url = $validated['canonical_url'] ?? '';
        $portfolio->seo_score = $validated['seo_score'] ?? 85;
        $portfolio->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Proyek portofolio berhasil ditambahkan!',
            'data' => $portfolio
        ]);
    }

    /**
     * Show single portfolio item JSON for edit modal.
     */
    public function show($id)
    {
        $portfolio = Portfolio::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $portfolio
        ]);
    }

    /**
     * Update portfolio item via AJAX.
     */
    public function update(Request $request, $id)
    {
        $portfolio = Portfolio::findOrFail($id);

        // Auto-sanitize slug or derive from title
        $rawSlug = $request->input('slug') ?: $request->input('title');
        $slug = Str::slug($rawSlug);
        if (empty($slug)) {
            $slug = 'proyek-' . $portfolio->id;
        }

        // Ensure unique slug excluding this portfolio
        $originalSlug = $slug;
        $counter = 1;
        while (Portfolio::where('slug', $slug)->where('id', '!=', $portfolio->id)->exists()) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }
        $request->merge(['slug' => $slug]);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:portfolios,slug,' . $portfolio->id,
            'category' => 'required|string',
            'client' => 'nullable|string',
            'year' => 'nullable|string',
            'summary' => 'nullable|string',
            'description' => 'nullable|string',
            'challenge' => 'nullable|string',
            'solution' => 'nullable|string',
            'results_input' => 'nullable|string',
            'image_url' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
            'tech_stack_input' => 'nullable|string',
            'live_url' => 'nullable|string',
            'status' => 'required|in:published,draft',
            'focus_keyword' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'canonical_url' => 'nullable|string',
            'seo_score' => 'nullable|integer|min:0|max:100',
        ], [
            'title.required' => 'Judul proyek wajib diisi.',
            'category.required' => 'Kategori proyek wajib dipilih.',
            'status.required' => 'Status publikasi wajib dipilih.',
            'image_file.image' => 'File yang diunggah harus berupa format gambar (JPG, PNG, WEBP, GIF, SVG).',
            'image_file.mimes' => 'Format gambar harus JPEG, PNG, JPG, GIF, WEBP, atau SVG.',
            'image_file.max' => 'Ukuran file gambar maksimal 5MB.',
        ]);

        $results = [];
        if (!empty($validated['results_input'])) {
            $results = array_filter(array_map('trim', explode("\n", $validated['results_input'])));
        }

        $techStack = [];
        if (!empty($validated['tech_stack_input'])) {
            $techStack = array_filter(array_map('trim', explode(',', $validated['tech_stack_input'])));
        }

        // Process cover image upload
        $imageUrl = ($validated['image_url'] ?? null) ?: ($portfolio->image_url ?: '/logo-rbtgtech.png');
        if ($request->hasFile('image_file')) {
            // Remove old uploaded image if stored locally
            if ($portfolio->image_url && str_starts_with($portfolio->image_url, '/storage/portfolios/')) {
                $oldFile = str_replace('/storage/portfolios/', '', $portfolio->image_url);
                Storage::disk('public')->delete('portfolios/' . $oldFile);
            }

            $file = $request->file('image_file');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('portfolios', $filename, 'public');
            $imageUrl = '/storage/portfolios/' . $filename;
        }

        $portfolio->title = $validated['title'];
        $portfolio->slug = Str::slug($validated['slug']);
        $portfolio->category = $validated['category'];
        $portfolio->client = ($validated['client'] ?? null) ?: 'Klien RBTG Tech';
        $portfolio->year = ($validated['year'] ?? null) ?: date('Y');
        $portfolio->summary = $validated['summary'] ?? '';
        $portfolio->description = $validated['description'] ?? '';
        $portfolio->challenge = $validated['challenge'] ?? '';
        $portfolio->solution = $validated['solution'] ?? '';
        $portfolio->results = array_values($results);
        $portfolio->image_url = $imageUrl;
        $portfolio->tech_stack = array_values($techStack);
        $portfolio->live_url = $validated['live_url'] ?? '';
        $portfolio->status = $validated['status'];
        $portfolio->focus_keyword = $validated['focus_keyword'] ?? '';
        $portfolio->meta_title = ($validated['meta_title'] ?? null) ?: $validated['title'];
        $portfolio->canonical_url = $validated['canonical_url'] ?? '';
        $portfolio->seo_score = $validated['seo_score'] ?? 85;
        $portfolio->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Proyek portofolio berhasil diperbarui!',
            'data' => $portfolio
        ]);
    }

    /**
     * Delete portfolio item via AJAX.
     */
    public function destroy($id)
    {
        $portfolio = Portfolio::findOrFail($id);

        if ($portfolio->image_url && str_starts_with($portfolio->image_url, '/storage/portfolios/')) {
            $oldFile = str_replace('/storage/portfolios/', '', $portfolio->image_url);
            Storage::disk('public')->delete('portfolios/' . $oldFile);
        }

        $portfolio->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Proyek portofolio berhasil dihapus!'
        ]);
    }
}
