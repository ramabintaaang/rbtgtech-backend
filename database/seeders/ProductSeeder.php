<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'title' => 'ESB Resto & POS Cloud Solution',
                'slug' => 'esb-resto-pos-cloud-solution',
                'category' => 'F&B & Resto System',
                'tagline' => 'Sistem Kasir, Dapur, Multi-outlet & Laporan Resto Real-time',
                'summary' => 'Solusi manajemen bisnis restoran, kafe, dan franchise terintegrasi dengan modul Kasir POS, Kitchen Display System (KDS), stok otomatis, dan QR Menu meja.',
                'description' => 'ESB Resto & POS Cloud Solution dirancang khusus untuk meningkatkan efisiensi operasional restoran dari skala tunggal hingga jaringan franchise multi-cabang. Terintegrasi langsung dengan payment gateway (QRIS, E-Wallet, Kartu) dan pelaporan keuangan real-time.',
                'features' => [
                    'Kasir POS Responsive (Web & Tablet)',
                    'Kitchen Display System (KDS) Real-time Synchronized',
                    'Manajemen Stok Bahan Baku & HPP Otomatis',
                    'Digital QR Order Meja (Self Service Order)',
                    'Laporan Penjualan & Profitability Multi-outlet',
                    'Integrasi Payment Gateway QRIS & E-Wallet'
                ],
                'tech_stack' => ['Laravel', 'Astro', 'Tailwind CSS', 'PostgreSQL', 'WebSockets'],
                'demo_url' => 'https://demo-resto.rbtgtech.com',
                'image_url' => '/logo-rbtgtech.png',
                'price_label' => 'Mulai Rp 2.500.000 / Lisensi',
                'status' => 'published',
                'sort_order' => 1,
            ],
            [
                'title' => 'SIM Sekolah & Smart Edu Platform',
                'slug' => 'sim-sekolah-smart-edu-platform',
                'category' => 'Sistem Pendidikan',
                'tagline' => 'Platform Manajemen Akademik, SPP Online & Presensi Siswa',
                'summary' => 'Sistem Informasi Manajemen Sekolah terpadu untuk SD, SMP, SMA, dan SMK. Dilengkapi portal guru, murid, orang tua, e-learning, serta rekap absensi.',
                'description' => 'SIM Sekolah & Smart Edu Platform menyatukan seluruh tata kelola sekolah dalam satu portal terpusat. Memudahkan absensi digital, ujian berbasis komputer (CBT), rekapitulasi nilai rapor kurikulum merdeka, serta pembayar SPP otomatis melalui WhatsApp notification.',
                'features' => [
                    'Portal Akademik & Rapor Kurikulum Merdeka',
                    'Pembayaran SPP & Keuangan dengan WA Gateway Notification',
                    'Absensi Digital Guru & Siswa (RFID / QR / Biometrik)',
                    'Ujian Online CBT (Computer Based Test)',
                    'Perpustakaan Digital & E-Learning Portal',
                    'Portal Orang Tua & Notifikasi Real-time'
                ],
                'tech_stack' => ['Laravel', 'Vue.js', 'MySQL', 'Tailwind CSS'],
                'demo_url' => 'https://demo-sekolah.rbtgtech.com',
                'image_url' => '/logo-rbtgtech.png',
                'price_label' => 'Paket Lisensi / Langganan Sekolah',
                'status' => 'published',
                'sort_order' => 2,
            ],
            [
                'title' => 'Omnichannel All in One AI',
                'slug' => 'omnichannel-all-in-one',
                'category' => 'SaaS & AI Communication',
                'tagline' => 'Pusat Komunikasi Multi-Channel Terpadu dengan Autonomous AI CS 24/7 & Multi-Agent Cloud',
                'summary' => 'Satukan seluruh chat WhatsApp, Instagram DM, Telegram, dan Marketplace dalam satu inbox web terpusat. Ditenagai AI Customer Service cerdas 24/7 dan multi-agent cloud—seluruh tim bisa membalas bersamaan tanpa lagi rebutan atau menunggu HP fisik admin.',
                'description' => 'Omnichannel All-in-One AI Platform hadir menyelesaikan kendala terbesar operasional customer service bisnis modern: ketergantungan fatal pada satu smartphone fisik dan lambatnya respon saat jam istirahat atau hari libur. Sistem ini mengonsolidasikan seluruh saluran interaksi pelanggan (WhatsApp Official API, Instagram Direct, Telegram, Facebook Messenger, hingga chat marketplace) ke dalam satu dashboard berbasis cloud. Ditenagai kecerdasan buatan (Autonomous AI Customer Service) yang dilatih menggunakan data produk, SOP, dan FAQ bisnis Anda, sistem mampu membalas pesan pelanggan seketika dengan gaya bahasa natural dan ramah selama 24 jam non-stop. Ketika transaksi membutuhkan asistensi khusus, sistem secara cerdas mendistribusikan percakapan ke multi-agent (seluruh tim CS dapat login bersamaan dari laptop/tablet manapun dengan 1 nomor WhatsApp yang sama), menghilangkan alasan klasik "HP dibawa admin keluar" selamanya.',
                'features' => [
                    'Autonomous AI Customer Service 24/7 (Balas Chat Cerdas & Instan Tanpa Kenal Libur)',
                    'Single Centralized Cloud Inbox (WhatsApp, Instagram, Telegram, TikTok & Web Chat)',
                    'Multi-Agent & Multi-Device (Banyak Staf CS Bisa Login Bersamaan dari Laptop/Tablet)',
                    'Bebas Ketergantungan HP Fisik (Sistem Berjalan di Cloud 100%, Chat Tetap Masuk & Terbalas)',
                    'Smart Human Handover & Ticket Routing (Eskalasi Mulus dari AI ke Agen Manusia)',
                    'Integrasi Katalog Produk, Pengecekan Stok & Generate Invoice Otomatis',
                    'Broadcast & Segmentasi Pelanggan Terjadwal dengan Perlindungan Anti-Banned',
                    'Live Performance Dashboard (Pantau Metrik Kecepatan Respon & Sentimen Pelanggan)'
                ],
                'tech_stack' => ['Laravel API', 'Astro JS', 'OpenAI & Gemini AI Engine', 'WebSockets', 'PostgreSQL', 'Redis'],
                'demo_url' => 'https://demo-omnichannel.rbtgtech.com',
                'image_url' => '/images/products/omnichannel-ai.jpg',
                'price_label' => 'Early Access / Private Beta',
                'status' => 'coming_soon',
                'sort_order' => 3,
            ],
            [
                'title' => 'RBTGLabs Overlay Streaming',
                'slug' => 'rbtglabs',
                'category' => 'Broadcasting & Creator Tech',
                'tagline' => 'Suite Dynamic Web Overlay 60 FPS, Alert Donasi Interaktif & Widget Creator Multi-Platform',
                'summary' => 'Ubah siaran live streaming Anda menjadi tayangan sekelas broadcast profesional dan esports. Ekosistem widget overlay berbasis browser source ultra-ringan (OBS & vMix) dengan integrasi otomatis donasi lokal (Saweria, Trakteer, Sociabuzz), live chat agregator, dynamic subathon goal bar, dan panel kontrol cloud real-time tanpa membebani performa CPU gaming Anda.',
                'description' => 'RBTGLabs Interactive Streaming Overlay dirancang khusus untuk memenuhi kebutuhan content creator, gaming streamer, podcaster, hingga event organizer turnamen esports yang ingin menghadirkan visual siaran interaktif berstandar profesional. Banyak streamer menghadapi kendala overlay animasi berbasis video file yang memakan beban CPU tinggi sehingga menyebabkan frame drop saat bermain game berat. RBTGLabs menyelesaikan masalah tersebut dengan arsitektur Browser Source (HTML5 Canvas & WebSockets) yang super ringan dengan penggunaan resource CPU kurang dari 1% pada rendering 60 FPS yang sangat mulus. Sistem ini mengintegrasikan seluruh event interaksi penonton secara real-time: notifikasi donasi Saweria, Trakteer, Sociabuzz lengkap dengan custom sound bite & TTS, live chat multi-platform yang bersih dari spam, leaderboard donatur, dan gamifikasi interaktif yang dapat diatur on-the-fly dari Cloud Control Panel.',
                'features' => [
                    'OBS & vMix Ultra-Lightweight Browser Source (Beban CPU < 1% & Zero Frame Drop)',
                    'Multi-Platform Donation Alert Engine (Saweria, Trakteer, Sociabuzz & Midtrans)',
                    'Custom 3D & Lottie Notification Animation (60 FPS Smooth Render with Sound Bite)',
                    'Unified Live Chat Box (Agregator Multi-Channel YouTube, Twitch & TikTok)',
                    'Dynamic Goal Bar (Donation Tracker, Follower Target & Subathon Countdown Timer)',
                    'Cloud Control Dashboard (Ubah Warna, Tema & Teks On-The-Fly Tanpa Restart OBS)',
                    'Esports Scoreboard & Match Bracket Overlay Modul',
                    'Audience Gamification Widget (Giveaway Wheel, Live Poll & Emote Rain)'
                ],
                'tech_stack' => ['HTML5 Canvas & WebGL', 'WebSockets Engine', 'Node.js & Python', 'Tailwind CSS & Lottie', 'Laravel Cloud API', 'OBS Browser Source SDK'],
                'demo_url' => 'https://labs.rbtgtech.com/overlay-demo',
                'image_url' => '/images/products/rbtglabs-overlay.jpg',
                'price_label' => 'Mulai Rp 450.000 / Setup',
                'status' => 'published',
                'sort_order' => 4,
            ],
        ];

        foreach ($products as $p) {
            Product::updateOrCreate(['slug' => $p['slug']], $p);
        }
    }
}
