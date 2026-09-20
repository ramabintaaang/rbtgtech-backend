<?php

use App\Http\Controllers\ArticleAdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryAdminController;
use App\Http\Controllers\ContactInquiryAdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceAdminController;
use App\Http\Controllers\LeadAdminController;
use App\Http\Controllers\PortfolioAdminController;
use App\Http\Controllers\ProductAdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/clear-cache', function () {
    $baseDir = base_path();
    $results = [];

    $bootstrapCacheFiles = glob($baseDir . '/bootstrap/cache/*.php');
    if ($bootstrapCacheFiles) {
        foreach ($bootstrapCacheFiles as $file) {
            if (basename($file) !== '.gitignore') {
                @unlink($file);
                $results[] = 'Deleted: ' . basename($file);
            }
        }
    }

    try {
        \Illuminate\Support\Facades\Artisan::call('optimize:clear');
        $results[] = 'Artisan optimize:clear executed successfully';
    } catch (\Throwable $e) {
        $results[] = 'Artisan note: ' . $e->getMessage();
    }

    return response()->json([
        'status' => 'success',
        'message' => 'Cache cleared successfully',
        'details' => $results
    ]);
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Article & Blog Management Routes (AJAX)
    Route::get('admin/articles/data', [ArticleAdminController::class, 'data'])->name('admin.articles.data');
    Route::resource('admin/articles', ArticleAdminController::class)->names('admin.articles');

    // Portfolio SPA Management Routes (AJAX)
    Route::get('admin/portfolio/data', [PortfolioAdminController::class, 'data'])->name('admin.portfolio.data');
    Route::resource('admin/portfolio', PortfolioAdminController::class)->names('admin.portfolio');

    // Product Master SPA Management Routes (AJAX)
    Route::get('admin/products/data', [ProductAdminController::class, 'data'])->name('admin.products.data');
    Route::resource('admin/products', ProductAdminController::class)->names('admin.products');

    // Category Master SPA Management Routes (AJAX)
    Route::get('admin/categories/data', [CategoryAdminController::class, 'data'])->name('admin.categories.data');
    Route::resource('admin/categories', CategoryAdminController::class)->names('admin.categories');

    // Contact Inquiries SPA Inbox Routes (AJAX)
    Route::get('admin/inquiries/data', [ContactInquiryAdminController::class, 'data'])->name('admin.inquiries.data');
    Route::post('admin/inquiries/{id}/status', [ContactInquiryAdminController::class, 'updateStatus'])->name('admin.inquiries.status');
    Route::resource('admin/inquiries', ContactInquiryAdminController::class)->only(['index', 'show', 'destroy'])->names('admin.inquiries');

    // Leads CRM & Scraper Routes (AJAX)
    Route::get('admin/leads/data', [LeadAdminController::class, 'data'])->name('admin.leads.data');
    Route::post('admin/leads/scrape', [LeadAdminController::class, 'scrape'])->name('admin.leads.scrape');
    Route::post('admin/leads/{id}/status', [LeadAdminController::class, 'updateStatus'])->name('admin.leads.status');
    Route::resource('admin/leads', LeadAdminController::class)->names('admin.leads');

    // Invoices / Nota Generator Routes
    Route::get('admin/invoices/{invoice}/print', [InvoiceAdminController::class, 'print'])->name('admin.invoices.print');
    Route::post('admin/invoices/{invoice}/toggle-status', [InvoiceAdminController::class, 'toggleStatus'])->name('admin.invoices.toggle-status');
    Route::resource('admin/invoices', InvoiceAdminController::class)->names('admin.invoices');
});
