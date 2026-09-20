<?php

declare(strict_types=1);

/**
 * Standalone Cache & Bootstrap Cleaner for Laravel
 * Dapat diakses langsung via browser tanpa bergantung pada koneksi database.
 */

$baseDir = dirname(__DIR__);
$results = [];

// 1. Bersihkan bootstrap/cache/*.php
$bootstrapCacheFiles = glob($baseDir . '/bootstrap/cache/*.php');
if ($bootstrapCacheFiles) {
    foreach ($bootstrapCacheFiles as $file) {
        if (basename($file) !== '.gitignore') {
            if (@unlink($file)) {
                $results[] = "Berhasil menghapus: bootstrap/cache/" . basename($file);
            } else {
                $results[] = "Gagal menghapus (permission): bootstrap/cache/" . basename($file);
            }
        }
    }
} else {
    $results[] = "Folder bootstrap/cache sudah bersih (tidak ada file cache).";
}

// 2. Bersihkan storage/framework/views/*
$viewFiles = glob($baseDir . '/storage/framework/views/*.php');
if ($viewFiles) {
    $deletedViews = 0;
    foreach ($viewFiles as $file) {
        if (@unlink($file)) {
            $deletedViews++;
        }
    }
    $results[] = "Berhasil menghapus {$deletedViews} file cache view/blade.";
}

// 3. Coba jalankan Artisan jika memungkinkan
$artisanMessage = "Artisan tidak dijalankan (mode standalone aman).";
try {
    if (file_exists($baseDir . '/vendor/autoload.php')) {
        require_once $baseDir . '/vendor/autoload.php';
        $app = require_once $baseDir . '/bootstrap/app.php';
        $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
        
        Illuminate\Support\Facades\Artisan::call('optimize:clear');
        $artisanMessage = "Artisan optimize:clear berhasil dieksekusi:\n" . Illuminate\Support\Facades\Artisan::output();
    }
} catch (\Throwable $e) {
    $artisanMessage = "Catatan: Artisan belum bisa dieksekusi karena: " . $e->getMessage() . " (File cache tetap berhasil dibersihkan secara manual di atas).";
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clear Cache - RBTG Tech</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background: #0f172a;
            color: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }
        .card {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 12px;
            padding: 28px;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.4);
        }
        h1 {
            color: #38bdf8;
            font-size: 1.5rem;
            margin-top: 0;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        ul {
            list-style: none;
            padding: 0;
            margin: 1rem 0;
        }
        li {
            padding: 8px 12px;
            margin-bottom: 6px;
            background: #0f172a;
            border-left: 4px solid #10b981;
            border-radius: 4px;
            font-size: 0.9rem;
            font-family: monospace;
        }
        pre {
            background: #0f172a;
            padding: 12px;
            border-radius: 6px;
            overflow-x: auto;
            font-size: 0.82rem;
            color: #94a3b8;
            border: 1px solid #334155;
            white-space: pre-wrap;
        }
        .btn {
            display: inline-block;
            background: #0284c7;
            color: white;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 6px;
            font-weight: 600;
            margin-top: 1rem;
            font-size: 0.9rem;
            transition: background 0.2s;
        }
        .btn:hover {
            background: #0369a1;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>⚡ Pembersihan Cache Selesai</h1>
        <p>File cache konfigurasi, route, dan blade telah dibersihkan:</p>
        <ul>
            <?php foreach ($results as $item): ?>
                <li>✓ <?= htmlspecialchars($item) ?></li>
            <?php endforeach; ?>
        </ul>

        <p style="margin-top: 1.5rem; font-size: 0.88rem; color: #94a3b8;">Status Eksekusi:</p>
        <pre><?= htmlspecialchars($artisanMessage) ?></pre>

        <a href="/" class="btn">&larr; Kembali ke Website / Login</a>
    </div>
</body>
</html>
