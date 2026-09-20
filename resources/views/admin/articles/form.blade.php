@extends('layouts.app')

@section('title', $article->exists ? 'Edit Artikel - RBTG Tech' : 'Buat Artikel Baru - RBTG Tech')

@push('head')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
<style>
    /* Override Quill snow theme to match design system */
    .ql-toolbar.ql-snow { border-color: #c2c6d6; border-radius: 0.75rem 0.75rem 0 0; background: #f2f3fe; }
    .ql-container.ql-snow { border-color: #c2c6d6; border-radius: 0 0 0.75rem 0.75rem; font-family: 'Manrope', sans-serif; font-size: 15px; }
    .ql-editor { min-height: 350px; padding: 20px 24px; line-height: 1.75; }
    .ql-editor.ql-blank::before { color: #727785; font-style: normal; }
    .ql-editor h2 { font-size: 1.4rem; font-weight: 700; margin: 1.25rem 0 0.5rem; }
    .ql-editor h3 { font-size: 1.15rem; font-weight: 600; margin: 1rem 0 0.5rem; }
    .ql-editor p { margin-bottom: 0.75rem; }
    .ql-editor ul, .ql-editor ol { padding-left: 1.5rem; margin-bottom: 0.75rem; }
    .ql-editor blockquote { border-left: 4px solid #0056c5; padding-left: 1rem; color: #424654; margin: 1rem 0; }
    .ql-snow .ql-picker-options { z-index: 9999; }
</style>
@endpush

@section('content')
<div class="px-margin-desktop py-lg max-w-[1440px] mx-auto flex flex-col gap-lg">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-md">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.articles.index') }}" class="p-2 text-on-surface-variant hover:text-primary rounded-lg transition-colors">
                <span class="material-symbols-outlined text-[24px]">arrow_back</span>
            </a>
            <div>
                <h1 class="text-headline-lg font-headline-lg text-on-surface">
                    {{ $article->exists ? 'Edit Artikel' : 'Buat Artikel Baru' }}
                </h1>
                <p class="text-body-lg text-on-surface-variant">Tulis artikel berkualitas dan optimalkan SEO gaya RBTGTech SEO untuk frontend Astro.</p>
            </div>
        </div>
    </div>

    <!-- Error Summary -->
    @if ($errors->any())
        <div class="p-4 rounded-xl bg-error-container text-on-error-container text-body-md flex items-start gap-3">
            <span class="material-symbols-outlined text-error text-[20px] shrink-0 mt-0.5">error</span>
            <div>
                <p class="font-bold mb-1">Terdapat kesalahan pengisian form:</p>
                <ul class="list-disc pl-5 space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form 
        id="articleForm" 
        action="{{ $article->exists ? route('admin.articles.update', $article->id) : route('admin.articles.store') }}" 
        method="POST" 
        enctype="multipart/form-data"
        class="grid grid-cols-1 lg:grid-cols-3 gap-gutter"
    >
        @csrf
        @if ($article->exists)
            @method('PUT')
        @endif

        <input type="hidden" name="seo_score" id="seoScoreInput" value="{{ old('seo_score', $article->seo_score ?? 75) }}">

        <!-- Left Column: Form Controls (Spans 2 Cols) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Article Main Form Card -->
            <div class="bg-surface-container-lowest rounded-2xl p-6 soft-shadow border border-outline-variant space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-label-md font-label-md text-on-surface font-bold mb-2">Judul Artikel <span class="text-error">*</span></label>
                    <input 
                        type="text" 
                        id="title" 
                        name="title" 
                        required 
                        value="{{ old('title', $article->title) }}" 
                        placeholder="Contoh: Panduan Praktis Strategi SEO Technical di 2026" 
                        class="w-full bg-surface-container-low border border-outline-variant rounded-xl p-4 text-headline-sm font-bold text-on-surface focus:border-primary outline-none"
                    />
                    <div class="flex justify-between text-label-sm text-on-surface-variant mt-1">
                        <span>Panjang rekomendasi: 50-60 karakter</span>
                        <span id="titleCharCount">0 karakter</span>
                    </div>
                </div>

                <!-- Slug / Permalink -->
                <div>
                    <label for="slug" class="block text-label-md font-label-md text-on-surface font-bold mb-2">URL Slug / Permalink <span class="text-error">*</span></label>
                    <div class="flex items-center bg-surface-container-low border border-outline-variant rounded-xl overflow-hidden focus-within:border-primary">
                        <span class="px-3 text-label-md text-on-surface-variant font-mono bg-surface-container-high/50 border-r border-outline-variant py-3 select-none">rbtgtech.com/artikel/</span>
                        <input 
                            type="text" 
                            id="slug" 
                            name="slug" 
                            required 
                            value="{{ old('slug', $article->slug) }}" 
                            placeholder="panduan-praktis-strategi-seo" 
                            class="w-full bg-transparent px-3 py-3 text-body-md font-mono text-primary outline-none"
                        />
                    </div>
                </div>

                <!-- Summary / Meta Description -->
                <div>
                    <label for="summary" class="block text-label-md font-label-md text-on-surface font-bold mb-2">Ringkasan / Meta Description SEO</label>
                    <textarea 
                        id="summary" 
                        name="summary" 
                        rows="3" 
                        placeholder="Tulis ringkasan menarik 120-160 karakter untuk ditampilkan di SERP Google..." 
                        class="w-full bg-surface-container-low border border-outline-variant rounded-xl p-3 text-body-md text-on-surface focus:border-primary outline-none"
                    >{{ old('summary', $article->summary) }}</textarea>
                    <div class="flex justify-between text-label-sm text-on-surface-variant mt-1">
                        <span>Panjang rekomendasi: 120-160 karakter</span>
                        <span id="summaryCharCount">0 karakter</span>
                    </div>
                </div>

                <!-- Full Content Editor (Quill.js) -->
                <div>
                    <label class="block text-label-md font-label-md text-on-surface font-bold mb-2">Konten Artikel Lengkap <span class="text-error">*</span></label>
                    <div id="quillEditor" class="bg-surface-container-low border border-outline-variant rounded-xl min-h-[350px]"></div>
                    <textarea name="content" id="contentInput" class="hidden">{{ old('content', $article->content) }}</textarea>
                    <div class="flex justify-between text-label-sm text-on-surface-variant mt-2">
                        <span>Gunakan Subheading (H2, H3) untuk struktur artikel yang rapi.</span>
                        <span id="wordCount">0 kata</span>
                    </div>
                </div>
            </div>

            <!-- Taxonomy & Publication Details Card -->
            <div class="bg-surface-container-lowest rounded-2xl p-6 soft-shadow border border-outline-variant grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Category -->
                <div>
                    <label for="category" class="block text-label-md font-label-md text-on-surface font-bold mb-2">Kategori <span class="text-error">*</span></label>
                    <select id="category" name="category" required class="w-full bg-surface-container-low border border-outline-variant rounded-xl p-3 text-body-md text-on-surface focus:border-primary outline-none">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->name }}" {{ old('category', $article->category) == $cat->name ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-label-md font-label-md text-on-surface font-bold mb-2">Status Publikasi <span class="text-error">*</span></label>
                    <select id="status" name="status" required class="w-full bg-surface-container-low border border-outline-variant rounded-xl p-3 text-body-md text-on-surface focus:border-primary outline-none">
                        <option value="published" {{ old('status', $article->status) == 'published' ? 'selected' : '' }}>Published (Terbit di Astro Website)</option>
                        <option value="draft" {{ old('status', $article->status) == 'draft' ? 'selected' : '' }}>Draft (Konsep Internal)</option>
                    </select>
                </div>

                <!-- Featured Image Upload Zone -->
                <div class="md:col-span-2 space-y-2">
                    <label class="block text-label-md font-label-md text-on-surface font-bold">Gambar Utama (Featured Image)</label>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <!-- Preview Box -->
                        <div class="relative group rounded-xl overflow-hidden border border-outline-variant bg-surface-container-low aspect-video flex items-center justify-center">
                            <img id="imagePreview" src="{{ old('image_url', $article->image_url ?? '/logo-rbtgtech.png') }}" alt="Featured Image Preview" class="w-full h-full object-cover" />
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white text-xs font-bold">
                                Pratinjau Gambar
                            </div>
                        </div>

                        <!-- Upload Zone & File Input -->
                        <div class="md:col-span-2 space-y-3">
                            <div class="border-2 border-dashed border-outline-variant hover:border-primary rounded-xl p-4 text-center cursor-pointer transition-colors bg-surface-container-low" onclick="document.getElementById('image_file').click()">
                                <input type="file" id="image_file" name="image_file" accept="image/*" class="hidden" onchange="previewSelectedImage(this)" />
                                <span class="material-symbols-outlined text-[28px] text-primary block mb-1">cloud_upload</span>
                                <p class="text-label-md font-bold text-on-surface">Pilih / Upload Gambar Baru</p>
                                <p class="text-xs text-on-surface-variant mt-0.5">Format: JPG, PNG, WEBP, SVG (Maks. 5MB). Otomatis disimpan di <code class="bg-surface-container px-1 py-0.5 rounded text-primary">storage/articles/</code></p>
                            </div>

                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-on-surface-variant uppercase">Atau URL:</span>
                                <input 
                                    type="text" 
                                    id="image_url" 
                                    name="image_url" 
                                    value="{{ old('image_url', $article->image_url ?? '') }}" 
                                    placeholder="Paste URL gambar luar (opsional)..." 
                                    oninput="document.getElementById('imagePreview').src = this.value || '/logo-rbtgtech.png'; runRankMathSEOAnalysis();" 
                                    class="flex-1 bg-surface-container-low border border-outline-variant rounded-xl p-2.5 text-body-md text-on-surface text-xs focus:border-primary outline-none"
                                />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tags Input -->
                <div class="md:col-span-2">
                    <label for="tags_input" class="block text-label-md font-label-md text-on-surface font-bold mb-2">Tags (Pisahkan dengan koma)</label>
                    <input 
                        type="text" 
                        id="tags_input" 
                        name="tags_input" 
                        value="{{ old('tags_input', is_array($article->tags) ? implode(', ', $article->tags) : '') }}" 
                        placeholder="Astro, Laravel, SEO, Architecture" 
                        class="w-full bg-surface-container-low border border-outline-variant rounded-xl p-3 text-body-md text-on-surface focus:border-primary outline-none"
                    />
                </div>
            </div>
        </div>

        <!-- Right Column: RankMath SEO Analysis & Suggestion Panel -->
        <div class="flex flex-col gap-lg">
            <!-- RankMath SEO Score Card -->
            <div class="bg-surface-container-lowest rounded-2xl p-6 soft-shadow border border-outline-variant sticky top-24 space-y-6">
                <!-- RankMath Header & Meter -->
                <div class="flex items-center justify-between border-b border-outline-variant/40 pb-4">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[24px]">troubleshoot</span>
                        <h2 class="text-headline-sm font-headline-sm font-bold text-on-surface">RBTGTech SEO</h2>
                    </div>
                    <!-- Score Meter Badge -->
                    <div id="seoScoreBadge" class="flex items-center gap-2 px-3 py-1.5 rounded-full font-bold text-headline-sm border shadow-sm transition-all duration-300 bg-emerald-100 text-emerald-800 border-emerald-300">
                        <span id="seoScoreValue">85</span>
                        <span class="text-xs opacity-75">/ 100</span>
                    </div>
                </div>

                <!-- Focus Keyword Field -->
                <div>
                    <label for="focus_keyword" class="block text-label-md font-label-md text-on-surface font-bold mb-2">Focus Keyword (Kata Kunci Utama)</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[18px]">key</span>
                        <input 
                            type="text" 
                            id="focus_keyword" 
                            name="focus_keyword" 
                            value="{{ old('focus_keyword', $article->focus_keyword ?? '') }}" 
                            placeholder="Contoh: Astro Laravel Enterprise" 
                            class="w-full bg-surface-container-low border border-outline-variant rounded-xl pl-9 pr-4 py-2.5 text-body-md text-on-surface focus:border-primary outline-none"
                        />
                    </div>
                    <p class="text-label-sm text-on-surface-variant mt-1">Masukkan kata kunci target untuk mengaktifkan analisis otomatis RBTGTech SEO.</p>
                </div>

                <!-- Google SERP Live Snippet Preview -->
                <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-label-sm font-bold text-on-surface flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px] text-primary">preview</span> Google SERP Preview
                        </span>
                        <!-- Device Toggle Tabs -->
                        <div class="flex items-center gap-1 bg-surface-container-high p-1 rounded-lg">
                            <button type="button" id="serpTabDesktop" onclick="setSerpDevice('desktop')" class="px-2 py-1 rounded text-[11px] font-bold flex items-center gap-1 transition-all bg-white text-primary shadow-xs cursor-pointer">
                                <span class="material-symbols-outlined text-[14px]">computer</span> Desktop
                            </button>
                            <button type="button" id="serpTabMobile" onclick="setSerpDevice('mobile')" class="px-2 py-1 rounded text-[11px] font-bold flex items-center gap-1 transition-all text-on-surface-variant hover:text-primary cursor-pointer">
                                <span class="material-symbols-outlined text-[14px]">smartphone</span> Mobile
                            </button>
                            <button type="button" id="serpTabTablet" onclick="setSerpDevice('tablet')" class="px-2 py-1 rounded text-[11px] font-bold flex items-center gap-1 transition-all text-on-surface-variant hover:text-primary cursor-pointer">
                                <span class="material-symbols-outlined text-[14px]">tablet_mac</span> Tablet
                            </button>
                        </div>
                    </div>

                    <!-- SERP Card Preview Container -->
                    <div id="serpCardContainer" class="bg-white p-3.5 rounded-xl border border-slate-200 shadow-sm space-y-1.5 transition-all duration-300">
                        <!-- Site Breadcrumb & Favicon -->
                        <div id="serpHeaderRow" class="text-[12px] text-slate-700 flex items-center gap-1.5 font-sans">
                            <img src="{{ asset('logo-rbtgtech.png') }}" alt="Favicon" class="w-4 h-4 object-contain rounded-full border border-slate-200" />
                            <span class="text-slate-900 font-semibold">rbtgtech.com</span>
                            <span class="text-slate-400">› artikel ›</span>
                            <span id="serpSlug" class="text-slate-600 font-mono text-xs">slug</span>
                        </div>

                        <!-- SERP Title -->
                        <h4 id="serpTitle" class="text-[16px] text-[#1a0dab] font-semibold hover:underline cursor-pointer line-clamp-1 leading-snug">
                            Judul Artikel SEO Preview
                        </h4>

                        <!-- SERP Description -->
                        <p id="serpDesc" class="text-[13px] text-[#4d5156] line-clamp-2 leading-relaxed">
                            Ringkasan artikel akan muncul di sini sebagai meta deskripsi pencarian Google.
                        </p>
                    </div>
                </div>

                <!-- RankMath Real-Time Checklist -->
                <div>
                    <h3 class="text-label-md font-bold text-on-surface mb-3 flex items-center justify-between">
                        <span>Checklist Analisis SEO</span>
                        <span id="passedChecklistCount" class="text-xs text-primary font-bold">0/8 Lolos</span>
                    </h3>
                    <ul class="space-y-2.5 text-body-md text-sm">
                        <!-- Rule 1: Focus Keyword in Title -->
                        <li id="ruleTitle" class="flex items-start gap-2.5 text-on-surface-variant">
                            <span class="material-symbols-outlined text-[18px] text-rose-500 shrink-0 mt-0.5">cancel</span>
                            <span>Focus Keyword terdapat di Judul Artikel</span>
                        </li>
                        <!-- Rule 2: Focus Keyword in Slug -->
                        <li id="ruleSlug" class="flex items-start gap-2.5 text-on-surface-variant">
                            <span class="material-symbols-outlined text-[18px] text-rose-500 shrink-0 mt-0.5">cancel</span>
                            <span>Focus Keyword terdapat di URL Slug</span>
                        </li>
                        <!-- Rule 3: Focus Keyword in Meta Description -->
                        <li id="ruleDesc" class="flex items-start gap-2.5 text-on-surface-variant">
                            <span class="material-symbols-outlined text-[18px] text-rose-500 shrink-0 mt-0.5">cancel</span>
                            <span>Focus Keyword di Meta Description</span>
                        </li>
                        <!-- Rule 4: Focus Keyword in Content Intro -->
                        <li id="ruleContentIntro" class="flex items-start gap-2.5 text-on-surface-variant">
                            <span class="material-symbols-outlined text-[18px] text-rose-500 shrink-0 mt-0.5">cancel</span>
                            <span>Focus Keyword di awal Paragraf Konten</span>
                        </li>
                        <!-- Rule 5: Content Length Check -->
                        <li id="ruleLength" class="flex items-start gap-2.5 text-on-surface-variant">
                            <span class="material-symbols-outlined text-[18px] text-rose-500 shrink-0 mt-0.5">cancel</span>
                            <span>Panjang Konten (Minimal 300 kata)</span>
                        </li>
                        <!-- Rule 6: Title Length Check -->
                        <li id="ruleTitleLength" class="flex items-start gap-2.5 text-on-surface-variant">
                            <span class="material-symbols-outlined text-[18px] text-rose-500 shrink-0 mt-0.5">cancel</span>
                            <span>Panjang Judul Ideal (50-60 karakter)</span>
                        </li>
                        <!-- Rule 7: Heading Structure -->
                        <li id="ruleHeadings" class="flex items-start gap-2.5 text-on-surface-variant">
                            <span class="material-symbols-outlined text-[18px] text-rose-500 shrink-0 mt-0.5">cancel</span>
                            <span>Menggunakan Subheading (H2 / H3)</span>
                        </li>
                        <!-- Rule 8: Featured Image -->
                        <li id="ruleImage" class="flex items-start gap-2.5 text-on-surface-variant">
                            <span class="material-symbols-outlined text-[18px] text-rose-500 shrink-0 mt-0.5">cancel</span>
                            <span>Memiliki Gambar Utama (Featured Image)</span>
                        </li>
                    </ul>
                </div>

                <!-- Submit Action Buttons -->
                <div class="pt-4 border-t border-outline-variant space-y-3">
                    <button 
                        type="submit" 
                        class="w-full bg-primary hover:bg-surface-tint text-on-primary font-bold text-label-md py-3.5 rounded-xl flex items-center justify-center gap-2 transition-all soft-shadow"
                    >
                        <span class="material-symbols-outlined text-[20px]">save</span>
                        <span>{{ $article->exists ? 'Simpan Perubahan' : 'Terbitkan Artikel' }}</span>
                    </button>
                    <a 
                        href="{{ route('admin.articles.index') }}" 
                        class="w-full bg-surface-container-low hover:bg-surface-container-high text-on-surface font-semibold text-label-md py-3 rounded-xl flex items-center justify-center transition-colors"
                    >
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Scripts for Quill Editor & RankMath Engine -->
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script>
// Device Switcher for Google SERP Live Preview (Desktop, Mobile, Tablet)
window.setSerpDevice = function(mode) {
    const desktopBtn = document.getElementById('serpTabDesktop');
    const mobileBtn = document.getElementById('serpTabMobile');
    const tabletBtn = document.getElementById('serpTabTablet');
    const container = document.getElementById('serpCardContainer');
    const titleEl = document.getElementById('serpTitle');
    const descEl = document.getElementById('serpDesc');

    if (!desktopBtn || !mobileBtn || !tabletBtn || !container) return;

    [desktopBtn, mobileBtn, tabletBtn].forEach(btn => {
        btn.className = 'px-2 py-1 rounded text-[11px] font-bold flex items-center gap-1 transition-all text-on-surface-variant hover:text-primary cursor-pointer';
    });

    if (mode === 'desktop') {
        desktopBtn.className = 'px-2 py-1 rounded text-[11px] font-bold flex items-center gap-1 transition-all bg-white text-primary shadow-xs cursor-pointer';
        container.className = 'bg-white p-3.5 rounded-xl border border-slate-200 shadow-sm space-y-1.5 transition-all duration-300 w-full';
        titleEl.className = 'text-[16px] text-[#1a0dab] font-semibold hover:underline cursor-pointer line-clamp-1 leading-snug';
        descEl.className = 'text-[13px] text-[#4d5156] line-clamp-2 leading-relaxed';
    } else if (mode === 'mobile') {
        mobileBtn.className = 'px-2 py-1 rounded text-[11px] font-bold flex items-center gap-1 transition-all bg-white text-primary shadow-xs cursor-pointer';
        container.className = 'bg-white p-3.5 rounded-2xl border border-slate-200 shadow-md space-y-1.5 transition-all duration-300 max-w-[320px] mx-auto border-l-4 border-l-primary';
        titleEl.className = 'text-[15px] text-[#1a0dab] font-semibold hover:underline cursor-pointer line-clamp-2 leading-snug';
        descEl.className = 'text-[12px] text-[#4d5156] line-clamp-3 leading-relaxed';
    } else if (mode === 'tablet') {
        tabletBtn.className = 'px-2 py-1 rounded text-[11px] font-bold flex items-center gap-1 transition-all bg-white text-primary shadow-xs cursor-pointer';
        container.className = 'bg-white p-3.5 rounded-xl border border-slate-200 shadow-sm space-y-1.5 transition-all duration-300 max-w-[450px] mx-auto';
        titleEl.className = 'text-[16px] text-[#1a0dab] font-semibold hover:underline cursor-pointer line-clamp-2 leading-snug';
        descEl.className = 'text-[13px] text-[#4d5156] line-clamp-2 leading-relaxed';
    }
};

document.addEventListener('DOMContentLoaded', function() {
    // 1. Initialize Quill WYSIWYG Editor
    const quill = new Quill('#quillEditor', {
        theme: 'snow',
        placeholder: 'Mulai menulis artikel berkualitas tinggi di sini...',
        modules: {
            toolbar: [
                [{ 'header': [2, 3, 4, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                ['blockquote', 'code-block'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link', 'image'],
                ['clean']
            ]
        }
    });

    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    const summaryInput = document.getElementById('summary');
    const focusKeywordInput = document.getElementById('focus_keyword');
    const imageUrlInput = document.getElementById('image_url');
    const contentInput = document.getElementById('contentInput');
    const form = document.getElementById('articleForm');

    let manualSlug = {{ $article->exists ? 'true' : 'false' }};

    // 2. BUG FIX: Load existing article HTML content into Quill via clipboard API
    //    (Setting innerHTML directly or relying on the DOM causes Quill to lose formatting)
    const existingContent = contentInput.value.trim();
    if (existingContent && existingContent !== '') {
        quill.clipboard.dangerouslyPasteHTML(existingContent);
    }

    // Auto slug generator on title typing
    titleInput.addEventListener('input', function() {
        if (!manualSlug) {
            slugInput.value = titleInput.value
                .toLowerCase()
                .trim()
                .replace(/[^\w\s-]/g, '')
                .replace(/[\s_-]+/g, '-')
                .replace(/^-+|-+$/g, '');
        }
        runRankMathSEOAnalysis();
    });

    slugInput.addEventListener('input', function() {
        manualSlug = true;
        runRankMathSEOAnalysis();
    });

    summaryInput.addEventListener('input', runRankMathSEOAnalysis);
    focusKeywordInput.addEventListener('input', runRankMathSEOAnalysis);
    imageUrlInput.addEventListener('input', runRankMathSEOAnalysis);

    // Synchronize Quill HTML to hidden content field on text change
    quill.on('text-change', function() {
        contentInput.value = quill.root.innerHTML;
        runRankMathSEOAnalysis();
    });

    form.addEventListener('submit', function() {
        contentInput.value = quill.root.innerHTML;
    });

    // 2. RankMath Live SEO Engine & Score Calculator
    function runRankMathSEOAnalysis() {
        const title = titleInput.value.trim();
        const slug = slugInput.value.trim();
        const summary = summaryInput.value.trim();
        const focusKeyword = focusKeywordInput.value.trim().toLowerCase();
        const contentText = quill.getText().trim();
        const contentHtml = quill.root.innerHTML;
        const imageUrl = imageUrlInput.value.trim();

        // Update Char / Word Counts
        document.getElementById('titleCharCount').textContent = `${title.length} karakter`;
        document.getElementById('summaryCharCount').textContent = `${summary.length} karakter`;

        const words = contentText ? contentText.split(/\s+/).filter(w => w.length > 0) : [];
        const wordCount = words.length;
        document.getElementById('wordCount').textContent = `${wordCount} kata`;

        // Update SERP Live Preview
        document.getElementById('serpTitle').textContent = title || 'Judul Artikel SEO Preview';
        document.getElementById('serpSlug').textContent = slug || 'slug';
        document.getElementById('serpDesc').textContent = summary || 'Ringkasan artikel akan muncul di sini sebagai meta deskripsi pencarian Google.';

        let passedChecks = 0;
        let score = 20; // Base score

        // Helper check updater
        function updateCheck(ruleId, isPassed, points = 10) {
            const el = document.getElementById(ruleId);
            const icon = el.querySelector('span');
            if (isPassed) {
                icon.textContent = 'check_circle';
                icon.className = 'material-symbols-outlined text-[18px] text-emerald-600 shrink-0 mt-0.5';
                el.classList.remove('text-on-surface-variant');
                el.classList.add('text-on-surface', 'font-medium');
                passedChecks++;
                score += points;
            } else {
                icon.textContent = 'cancel';
                icon.className = 'material-symbols-outlined text-[18px] text-rose-500 shrink-0 mt-0.5';
                el.classList.remove('text-on-surface', 'font-medium');
                el.classList.add('text-on-surface-variant');
            }
        }

        // Smart Multi-Word / Token Keyword Matcher Helper
        function checkKeywordMatch(targetText, focusKw, threshold = 0.5) {
            if (!focusKw || focusKw.length === 0 || !targetText) return false;
            const lowerTarget = targetText.toLowerCase();
            const lowerKw = focusKw.toLowerCase().trim();

            // Direct exact substring match
            if (lowerTarget.includes(lowerKw)) return true;

            // Tokenize words (ignoring short connectors like 'dan', '&', 'di')
            const words = lowerKw.split(/[\s\-_&]+/).filter(w => w.length > 2);
            if (words.length === 0) return false;

            const matchedWords = words.filter(word => lowerTarget.includes(word));
            return (matchedWords.length / words.length) >= threshold;
        }

        // Rule 1: Focus Keyword in Title
        const hasFkInTitle = checkKeywordMatch(title, focusKeyword, 0.66);
        updateCheck('ruleTitle', hasFkInTitle, 10);

        // Rule 2: Focus Keyword in Slug
        const hasFkInSlug = checkKeywordMatch(slug.replace(/-/g, ' '), focusKeyword, 0.66);
        updateCheck('ruleSlug', hasFkInSlug, 10);

        // Rule 3: Focus Keyword in Summary / Meta Description
        const hasFkInDesc = checkKeywordMatch(summary, focusKeyword, 0.5);
        updateCheck('ruleDesc', hasFkInDesc, 10);

        // Rule 4: Focus Keyword in Content Intro
        const hasFkInIntro = checkKeywordMatch(contentText.substring(0, 500), focusKeyword, 0.5);
        updateCheck('ruleContentIntro', hasFkInIntro, 10);

        // Rule 5: Content Length (>= 150 words)
        const isGoodLength = wordCount >= 150;
        updateCheck('ruleLength', isGoodLength, 10);

        // Rule 6: Title Length (35-85 chars)
        const isTitleLengthGood = title.length >= 35 && title.length <= 85;
        updateCheck('ruleTitleLength', isTitleLengthGood, 10);

        // Rule 7: Heading structure (H2 or H3 present)
        const hasHeadings = /<h[23][^>]*>/i.test(contentHtml) || contentText.includes('1.') || contentText.includes('2.');
        updateCheck('ruleHeadings', hasHeadings, 10);

        // Rule 8: Featured Image
        const imageFileInput = document.getElementById('image_file');
        const hasImage = (imageFileInput && imageFileInput.files && imageFileInput.files.length > 0) || imageUrl.length > 0 || (document.getElementById('imagePreview') && !document.getElementById('imagePreview').src.includes('placeholder')) || /<img[^>]+/i.test(contentHtml);
        updateCheck('ruleImage', hasImage, 10);

        // Final score capping 0-100
        const finalScore = Math.min(100, Math.max(0, score));
        document.getElementById('seoScoreValue').textContent = finalScore;
        document.getElementById('seoScoreInput').value = finalScore;
        document.getElementById('passedChecklistCount').textContent = `${passedChecks}/8 Lolos`;

        // Update Score Badge Color
        const badge = document.getElementById('seoScoreBadge');
        if (finalScore >= 80) {
            badge.className = 'flex items-center gap-2 px-3 py-1.5 rounded-full font-bold text-headline-sm border shadow-sm transition-all duration-300 bg-emerald-100 text-emerald-800 border-emerald-300';
        } else if (finalScore >= 50) {
            badge.className = 'flex items-center gap-2 px-3 py-1.5 rounded-full font-bold text-headline-sm border shadow-sm transition-all duration-300 bg-amber-100 text-amber-800 border-amber-300';
        } else {
            badge.className = 'flex items-center gap-2 px-3 py-1.5 rounded-full font-bold text-headline-sm border shadow-sm transition-all duration-300 bg-rose-100 text-rose-800 border-rose-300';
        }
    }

    window.previewSelectedImage = function(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').src = e.target.result;
                runRankMathSEOAnalysis();
            };
            reader.readAsDataURL(input.files[0]);
        }
    };

    // 3. BUG FIX: Delay initial analysis slightly so Quill has fully rendered
    //    the pre-loaded content before the SEO checklist runs its checks.
    setTimeout(runRankMathSEOAnalysis, 150);
});
</script>
@endsection
