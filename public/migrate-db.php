<?php

/**
 * Web Migration & Seeder Runner for Shared Hosting (Without SSH/Terminal)
 * rbtgtech Admin Panel
 */

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

// Security validation: Only allow execution with the correct secret key
$secretKey = env('ARTICLE_API_KEY', 'rbtgtech_agent_secret_2026');
$providedKey = $_GET['key'] ?? '';

if (empty($providedKey) || $providedKey !== $secretKey) {
    http_response_code(403);
    die("<h2 style='color:red;font-family:sans-serif;'>403 Akses Ditolak</h2><p>Kunci rahasia (?key=...) tidak valid atau belum disertakan.</p>");
}

header('Content-Type: text/html; charset=utf-8');
echo "<!DOCTYPE html><html><head><title>Database Migration Runner - RBTGTech</title>";
echo "<style>body { font-family: monospace; background: #0f172a; color: #f8fafc; padding: 30px; line-height: 1.6; } pre { background: #1e293b; padding: 20px; border-radius: 12px; border: 1px solid #334155; } .success { color: #34d399; font-weight: bold; } h1 { font-family: sans-serif; color: #38bdf8; }</style></head><body>";
echo "<h1>🚀 RBTGTech Database Migration & Seeder Runner</h1>";
echo "<p>Menjalankan migrasi dan pembaruan data secara aman langsung di web hosting...</p>";

echo "<pre>";

try {
    echo "▶ 1. Menjalankan: php artisan migrate --force\n";
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    echo \Illuminate\Support\Facades\Artisan::output();

    echo "\n▶ 2. Menjalankan: php artisan db:seed --class=PortfolioSeeder --force\n";
    \Illuminate\Support\Facades\Artisan::call('db:seed', [
        '--class' => 'PortfolioSeeder',
        '--force' => true,
    ]);
    echo \Illuminate\Support\Facades\Artisan::output();

    echo "\n▶ 3. Menjalankan: php artisan optimize:clear\n";
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    echo \Illuminate\Support\Facades\Artisan::output();

    echo "\n<span class='success'>✅ SEMUA PROSES BERHASIL DISELESAIKAN!</span>\n";
    echo "Tabel invoices dan seluruh deskripsi portofolio terbaru telah tersinkronisasi.\n";
    echo "\n⚠️ CATATAN KEAMANAN: Demi keamanan web hosting, silakan HAPUS file 'public/migrate-db.php' ini melalui File Manager cPanel.";

} catch (\Throwable $e) {
    echo "\n❌ Terjadi Kesalahan:\n" . $e->getMessage() . "\n";
}

echo "</pre></body></html>";
