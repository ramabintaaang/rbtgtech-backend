<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    /**
     * Validate AI Agent or API Client authorization
     */
    protected function isAuthorized(Request $request): bool
    {
        $configuredKey = env('ARTICLE_API_KEY', 'rbtgtech_agent_secret_2026');
        if (empty($configuredKey)) {
            return true;
        }

        $providedKey = $request->header('X-API-KEY')
            ?: $request->bearerToken()
            ?: $request->input('api_key');

        return $providedKey === $configuredKey;
    }

    /**
     * Display a listing of published articles for Astro frontend.
     */
    public function index()
    {
        $articles = Article::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->get()
            ->map(fn($article) => $article->toAstroArray());

        return response()->json([
            'status' => 'success',
            'data' => $articles
        ]);
    }

    /**
     * Display the specified article by slug for Astro frontend.
     */
    public function show($slug)
    {
        $article = Article::where('slug', $slug)
            ->orWhere('id', $slug)
            ->first();

        if (!$article) {
            return response()->json([
                'status' => 'error',
                'message' => 'Artikel tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $article->toAstroArray()
        ]);
    }

    /**
     * Store a newly created article via API (for AI Agents, Automation, or CMS).
     */
    public function store(Request $request)
    {
        // 1. Check Authorization
        if (!$this->isAuthorized($request)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized: API Key tidak valid atau belum disertakan. Gunakan header Authorization: Bearer <KEY> atau X-API-KEY: <KEY>.'
            ], 401);
        }

        // 2. Validate Input
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'slug' => 'nullable|string|max:255',
            'summary' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'author_name' => 'nullable|string|max:100',
            'author_role' => 'nullable|string|max:100',
            'author_avatar' => 'nullable|string|max:255',
            'image_url' => 'nullable|string|max:1000',
            'tags' => 'nullable',
            'read_time' => 'nullable|string|max:50',
            'status' => 'nullable|in:published,draft',
            'published_at' => 'nullable|date',
            'focus_keyword' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'canonical_url' => 'nullable|string|max:500',
            'seo_score' => 'nullable|integer|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi data gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $input = $validator->validated();

        // 3. Resolve Unique Slug
        $baseSlug = !empty($input['slug']) ? Str::slug($input['slug']) : Str::slug($input['title']);
        $slug = $baseSlug;
        $counter = 1;
        while (Article::where('slug', $slug)->exists()) {
            $counter++;
            $slug = "{$baseSlug}-{$counter}";
        }

        // 4. Resolve Content & Summary
        $content = $input['content'];
        $summary = !empty($input['summary']) 
            ? $input['summary'] 
            : Str::limit(trim(strip_tags($content)), 180, '...');

        // 5. Resolve Read Time (Default ~200 words/min)
        $readTime = $input['read_time'] ?? null;
        if (empty($readTime)) {
            $words = str_word_count(strip_tags($content));
            $minutes = max(1, (int) ceil($words / 200));
            $readTime = "{$minutes} menit";
        }

        // 6. Resolve Tags (Array or comma-separated string)
        $tags = $input['tags'] ?? ['Artificial Intelligence', 'Teknologi'];
        if (is_string($tags)) {
            $tags = array_values(array_filter(array_map('trim', explode(',', $tags))));
        }

        // 7. Resolve Cover Image
        $imageUrl = $input['image_url'] ?? '/images/articles/article-ai-agent.jpg';

        // 8. Resolve Status & Published At
        $status = $input['status'] ?? 'published';
        $publishedAt = $input['published_at'] ?? ($status === 'published' ? now() : null);

        // 9. Resolve Author Info
        $authorName = $input['author_name'] ?? 'Rama Bintang';
        $authorRole = $input['author_role'] ?? 'Founder & Lead Software Architect';
        $authorAvatar = $input['author_avatar'] ?? '/images/rama-builder.jpg';

        // 10. Resolve SEO
        $metaTitle = $input['meta_title'] ?? $input['title'];
        $canonicalUrl = $input['canonical_url'] ?? "https://rbtgtech.com/artikel/{$slug}";
        $seoScore = $input['seo_score'] ?? 90;
        $focusKeyword = $input['focus_keyword'] ?? ($tags[0] ?? $input['title']);

        // 11. Create Article
        $article = Article::create([
            'title' => $input['title'],
            'slug' => $slug,
            'summary' => $summary,
            'content' => $content,
            'category' => $input['category'] ?? 'Artificial Intelligence',
            'author_name' => $authorName,
            'author_role' => $authorRole,
            'author_avatar' => $authorAvatar,
            'image_url' => $imageUrl,
            'tags' => $tags,
            'read_time' => $readTime,
            'status' => $status,
            'published_at' => $publishedAt,
            'focus_keyword' => $focusKeyword,
            'meta_title' => $metaTitle,
            'canonical_url' => $canonicalUrl,
            'seo_score' => $seoScore,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Artikel berhasil dibuat dan dipublikasikan!',
            'data' => $article->toAstroArray(),
            'urls' => [
                'public_article_url' => "https://rbtgtech.com/artikel/{$article->slug}",
                'local_test_url' => "http://localhost:4321/artikel/{$article->slug}",
                'admin_edit_url' => url("/admin/articles/{$article->id}/edit")
            ]
        ], 201);
    }

    /**
     * Update the specified article via API.
     */
    public function update(Request $request, $id)
    {
        if (!$this->isAuthorized($request)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized: API Key tidak valid.'
            ], 401);
        }

        $article = Article::where('id', $id)
            ->orWhere('slug', $id)
            ->first();

        if (!$article) {
            return response()->json([
                'status' => 'error',
                'message' => 'Artikel tidak ditemukan'
            ], 404);
        }

        $data = $request->all();

        if (isset($data['title'])) {
            $article->title = $data['title'];
        }
        if (isset($data['slug']) && !empty($data['slug'])) {
            $article->slug = Str::slug($data['slug']);
        }
        if (isset($data['summary'])) {
            $article->summary = $data['summary'];
        }
        if (isset($data['content'])) {
            $article->content = $data['content'];
            if (empty($data['read_time'])) {
                $words = str_word_count(strip_tags($data['content']));
                $article->read_time = max(1, (int) ceil($words / 200)) . ' menit';
            }
        }
        if (isset($data['category'])) {
            $article->category = $data['category'];
        }
        if (isset($data['image_url'])) {
            $article->image_url = $data['image_url'];
        }
        if (isset($data['tags'])) {
            $article->tags = is_array($data['tags']) 
                ? $data['tags'] 
                : array_values(array_filter(array_map('trim', explode(',', $data['tags']))));
        }
        if (isset($data['status'])) {
            $article->status = $data['status'];
            if ($data['status'] === 'published' && !$article->published_at) {
                $article->published_at = now();
            }
        }
        if (isset($data['focus_keyword'])) {
            $article->focus_keyword = $data['focus_keyword'];
        }
        if (isset($data['meta_title'])) {
            $article->meta_title = $data['meta_title'];
        }
        if (isset($data['canonical_url'])) {
            $article->canonical_url = $data['canonical_url'];
        }
        if (isset($data['seo_score'])) {
            $article->seo_score = (int) $data['seo_score'];
        }

        $article->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Artikel berhasil diperbarui!',
            'data' => $article->toAstroArray()
        ]);
    }

    /**
     * Remove the specified article via API.
     */
    public function destroy(Request $request, $id)
    {
        if (!$this->isAuthorized($request)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized: API Key tidak valid.'
            ], 401);
        }

        $article = Article::where('id', $id)
            ->orWhere('slug', $id)
            ->first();

        if (!$article) {
            return response()->json([
                'status' => 'error',
                'message' => 'Artikel tidak ditemukan'
            ], 404);
        }

        $article->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Artikel berhasil dihapus.'
        ]);
    }
}
