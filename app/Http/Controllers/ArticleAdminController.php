<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleAdminController extends Controller
{
    /**
     * Display a listing of articles.
     */
    public function index()
    {
        $categories = Category::forType('article')->orderBy('sort_order', 'asc')->get();
        return view('admin.articles.index', compact('categories'));
    }

    /**
     * Get JSON dataset of articles for AJAX SPA.
     */
    public function data(Request $request)
    {
        $query = Article::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('summary', 'like', "%{$search}%")
                  ->orWhere('focus_keyword', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $articles = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'status' => 'success',
            'data' => $articles
        ]);
    }

    /**
     * Show the form for creating a new article.
     */
    public function create()
    {
        $article = new Article();
        $categories = Category::forType('article')->orderBy('sort_order', 'asc')->get();
        return view('admin.articles.form', compact('article', 'categories'));
    }

    /**
     * Store a newly created article in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:articles,slug',
            'summary' => 'nullable|string',
            'content' => 'required|string',
            'category' => 'required|string',
            'author_name' => 'nullable|string',
            'author_role' => 'nullable|string',
            'author_avatar' => 'nullable|string',
            'image_url' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
            'tags_input' => 'nullable|string',
            'status' => 'required|in:published,draft',
            'focus_keyword' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'canonical_url' => 'nullable|string',
            'seo_score' => 'nullable|integer|min:0|max:100',
        ]);

        // Process image upload
        $imageUrl = $validated['image_url'] ?? '/logo-rbtgtech.png';
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/articles', $filename);
            $imageUrl = '/storage/articles/' . $filename;
        }

        // Process tags
        $tags = [];
        if (!empty($validated['tags_input'])) {
            $tags = array_map('trim', explode(',', $validated['tags_input']));
        }

        // Estimate reading time
        $wordCount = str_word_count(strip_tags($validated['content']));
        $readTime = max(1, ceil($wordCount / 200)) . ' menit';

        $article = new Article();
        $article->title = $validated['title'];
        $article->slug = Str::slug($validated['slug']);
        $article->summary = $validated['summary'] ?? '';
        $article->content = $validated['content'];
        $article->category = $validated['category'];
        $article->author_name = ($validated['author_name'] ?? null) ?: 'Tim Engineering rbtgtech';
        $article->author_role = ($validated['author_role'] ?? null) ?: 'Lead Systems Architect';
        $article->author_avatar = ($validated['author_avatar'] ?? null) ?: '/logo-rbtgtech.png';
        $article->image_url = $imageUrl;
        $article->tags = $tags;
        $article->read_time = $readTime;
        $article->status = $validated['status'];
        $article->published_at = $validated['status'] === 'published' ? now() : null;
        $article->focus_keyword = $validated['focus_keyword'] ?? '';
        $article->meta_title = ($validated['meta_title'] ?? null) ?: $validated['title'];
        $article->canonical_url = $validated['canonical_url'] ?? '';
        $article->seo_score = $validated['seo_score'] ?? 75;
        $article->save();

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil disimpan!');
    }

    /**
     * Show the form for editing the specified article.
     */
    public function edit(Article $article)
    {
        $categories = Category::forType('article')->orderBy('sort_order', 'asc')->get();
        return view('admin.articles.form', compact('article', 'categories'));
    }

    /**
     * Update the specified article in storage.
     */
    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:articles,slug,' . $article->id,
            'summary' => 'nullable|string',
            'content' => 'required|string',
            'category' => 'required|string',
            'author_name' => 'nullable|string',
            'author_role' => 'nullable|string',
            'author_avatar' => 'nullable|string',
            'image_url' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
            'tags_input' => 'nullable|string',
            'status' => 'required|in:published,draft',
            'focus_keyword' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'canonical_url' => 'nullable|string',
            'seo_score' => 'nullable|integer|min:0|max:100',
        ]);

        // Process image upload
        $imageUrl = ($validated['image_url'] ?? null) ?: ($article->image_url ?: '/logo-rbtgtech.png');
        if ($request->hasFile('image_file')) {
            // Unlink old stored file if exists
            if ($article->image_url && str_starts_with($article->image_url, '/storage/articles/')) {
                $oldPath = public_path($article->image_url);
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }

            $file = $request->file('image_file');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/articles', $filename);
            $imageUrl = '/storage/articles/' . $filename;
        }

        // Process tags
        $tags = [];
        if (!empty($validated['tags_input'])) {
            $tags = array_map('trim', explode(',', $validated['tags_input']));
        }

        // Estimate reading time
        $wordCount = str_word_count(strip_tags($validated['content']));
        $readTime = max(1, ceil($wordCount / 200)) . ' menit';

        $article->title = $validated['title'];
        $article->slug = Str::slug($validated['slug']);
        $article->summary = $validated['summary'] ?? '';
        $article->content = $validated['content'];
        $article->category = $validated['category'];
        $article->author_name = ($validated['author_name'] ?? null) ?: 'Tim Engineering rbtgtech';
        $article->author_role = ($validated['author_role'] ?? null) ?: 'Lead Systems Architect';
        $article->author_avatar = ($validated['author_avatar'] ?? null) ?: '/logo-rbtgtech.png';
        $article->image_url = $imageUrl;
        $article->tags = $tags;
        $article->read_time = $readTime;
        $article->status = $validated['status'];
        if ($validated['status'] === 'published' && !$article->published_at) {
            $article->published_at = now();
        }
        $article->focus_keyword = $validated['focus_keyword'] ?? '';
        $article->meta_title = ($validated['meta_title'] ?? null) ?: $validated['title'];
        $article->canonical_url = $validated['canonical_url'] ?? '';
        $article->seo_score = $validated['seo_score'] ?? 75;
        $article->save();

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diperbarui!');
    }

    /**
     * Remove the specified article from storage.
     */
    public function destroy(Article $article)
    {
        if ($article->image_url && str_starts_with($article->image_url, '/storage/articles/')) {
            $oldPath = public_path($article->image_url);
            if (file_exists($oldPath)) {
                @unlink($oldPath);
            }
        }

        $article->delete();
        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus!');
    }
}
