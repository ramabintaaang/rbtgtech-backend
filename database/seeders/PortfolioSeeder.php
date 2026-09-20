<?php

namespace Database\Seeders;

use App\Models\Portfolio;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $portfolios = [
            [
                'title' => 'Company Profile : RGS Rumput Sintetis',
                'slug' => 'company-profile-rgs-rumput-sintetis',
                'category' => 'Company Profile',
                'client' => 'RGS Rumput Sintetis Semarang',
                'year' => '2025',
                'summary' => 'Platform katalog digital dan website profil kontraktor rumput sintetis terkemuka untuk residensial, dekorasi interior, taman bermain, dan lapangan olahraga di Jawa Tengah.',
                'description' => "RGS Rumput Sintetis Semarang merupakan distributor dan kontraktor spesialis rumput sintetis berkualitas tinggi yang melayani kebutuhan taman hunian, kafe, playground anak, hingga lapangan mini soccer dan futsal berstandar nasional. Rama Bintang merekayasa website company profile interaktif ini untuk mengubah cara RGS menjangkau konsumen dari yang sebelumnya mengandalkan direct message manual menjadi sistem katalog mandiri yang terstruktur.\n\nWebsite ini menyajikan katalog varian rumput sintetis lengkap (tipe Swiss, Jepang, Golf, hingga Futsal 50mm) dengan informasi densitas helai, ketebalan, serta spesifikasi drainase air secara gamblang. Ditunjang dengan fitur panduan pemilihan produk interaktif, kalkulator estimasi kebutuhan luasan meter persegi, dan integrasi WhatsApp link generator cerdas yang langsung menyertakan rincian produk yang ingin dikonsultasikan oleh calon klien.",
                'challenge' => 'Banyak calon pembeli awam bingung menentukan spesifikasi rumput yang cocok untuk kebutuhan indoor vs outdoor, serta enggan memesan karena ketidakjelasan simulasi total biaya pemasangan. Selain itu, ketergantungan pada marketplace memotong margin laba bisnis hingga 15% dan tingginya biaya iklan berbayar tanpa adanya aset digital jangka panjang.',
                'solution' => 'Membangun website katalog modern berkecepatan tinggi dengan visualisasi resolusi tinggi yang terkompresi tanpa mengurangi detail tekstur rumput. Mengimplementasikan strategi Local SEO terarah untuk kata kunci dominan di Jawa Tengah, menyediakan edukasi panduan perawatan, serta alur navigasi seamless dari galeri proyek langsung menuju konsultasi survei lokasi via WhatsApp.',
                'results' => [
                    'Meraih peringkat 1 di pencarian Google untuk kata kunci "Rumput Sintetis Semarang" dan sekitarnya',
                    'Lonjakan permintaan survei lokasi dan order langsung sebesar 140% dalam kuartal pertama',
                    'Memangkas waktu edukasi customer service hingga 50% karena katalog spesifikasi dan FAQ sangat transparan',
                    'Kemandirian penjualan direct channel meningkat pesat tanpa tergerus potongan komisi marketplace'
                ],
                'image_url' => '/storage/portfolios/1788802272_rgs-semarang-rumput-sintetis-interior-custom-furniture-09-08-2026-12-19-am-1.webp',
                'tech_stack' => ['WordPress', 'Elementor Pro', 'Local SEO Engine', 'LiteSpeed Cache', 'Responsive UI'],
                'live_url' => 'https://rgsrumputsintetis.com/',
                'status' => 'published',
                'focus_keyword' => 'Rumput Sintetis Semarang',
                'meta_title' => 'Company Profile : RGS Rumput Sintetis - Portofolio RBTGTech',
                'canonical_url' => 'https://rgsrumputsintetis.com/',
                'seo_score' => 95,
            ],
            [
                'title' => 'Company Profile : DC Interior Kudus',
                'slug' => 'interior-dc-kudus',
                'category' => 'Company Profile',
                'client' => 'DC Interior Kudus',
                'year' => '2026',
                'summary' => 'Website profil showcase arsitektur dan interior mewah dengan galeri portofolio visual interaktif, katalog material kustom, dan sistem reservasi konsultasi desainer.',
                'description' => "DC Interior Kudus adalah studio arsitektur dan spesialis custom furniture interior premium untuk hunian mewah, villa, kafe, dan ruang perkantoran komersial di wilayah Kudus, Jepara, Pati, dan Semarang. Untuk mencerminkan kemewahan dan ketelitian setiap karya pengerjaan, Rama Bintang merancang identitas website berkelas dengan konsep dark luxury minimalis dan layout galeri modern yang memikat mata calon klien sejak detik pertama.\n\nSetiap proyek dipamerkan dengan format case study mendalam—menampilkan perbandingan 3D render konsep arsitektur hingga foto riil hasil instalasi setelah selesai dikerjakan. Pengunjung dapat mengeksplorasi portofolio berdasarkan zona ruangan (kitchen set, backdrop TV, master bedroom, walk-in closet, office space), melihat pilihan material finishing (HPL anti-gores, marmer alam, kayu solid), serta memesan janji temu konsultasi desain secara langsung.",
                'challenge' => 'Sebelum memiliki website resmi, DC Interior hanya membagikan karya melalui feed media sosial yang acak dan tidak terorganisir. Calon klien kelas atas sering kali kesulitan melihat portofolio proyek secara menyeluruh dan memerlukan validasi kredibilitas formal sebelum bersedia menginvestasikan ratusan juta rupiah untuk renovasi interior hunian mereka.',
                'solution' => 'Mengembangkan website profil brand prestige dengan arsitektur visual responsif berkecepatan tinggi. Memanfaatkan optimasi gambar WebP generasi baru agar visual definisi tinggi dapat dimuat dengan instan di perangkat mobile tanpa lag, dipadukan dengan call-to-action konsultasi eksklusif yang mempermudah calon klien mengirimkan denah denah awal proyek langsung ke tim arsitek.',
                'results' => [
                    'Peningkatan prospek proyek renovasi interior bernilai tinggi sebesar 120% dalam 2 bulan pertama',
                    'Skor Core Web Vitals mobile mencapai 95+ dengan waktu muat di bawah 1.5 detik meskipun sarat galeri visual foto HD',
                    'Menduduki halaman pertama Google untuk keyword "Jasa Interior Kudus" dan "Custom Furniture Kudus"',
                    'Mempercepat proses closing deal klien karena portofolio hasil pengerjaan tersaji kredibel dan profesional'
                ],
                'image_url' => '/storage/portfolios/1788455702_interior-dc-kemewahan-di-setiap-sudut-beranda-09-04-2026-12-06-am-1.webp',
                'tech_stack' => ['WordPress', 'Elementor Pro', 'Yoast SEO', 'WebP Optimizer', 'Modern Luxury UI'],
                'live_url' => 'https://interiordc.com/',
                'status' => 'published',
                'focus_keyword' => 'Jasa Interior Kudus',
                'meta_title' => 'Company Profile : DC Interior Kudus - Portofolio RBTGTech',
                'canonical_url' => 'https://interiordc.com/',
                'seo_score' => 94,
            ],
            [
                'title' => 'Company Profile: TaxGBC Guna Bersama Consulting',
                'slug' => 'taxgbc-guna-bersama-consulting',
                'category' => 'Company Profile',
                'client' => 'Guna Bersama Consulting',
                'year' => '2025',
                'summary' => 'Platform profil korporat interaktif kantor konsultan pajak dan akuntansi enterprise dengan portal wawasan regulasi HPP, simulasi pajak, dan booking konsultasi terenkripsi.',
                'description' => "TaxGBC (PT Guna Bersama Consulting) adalah kantor konsultan pajak dan keuangan independen yang mendampingi perusahaan multinasional, entitas korporasi nasional, hingga pelaku bisnis skala menengah dalam kepatuhan perpajakan (Tax Compliance), pendampingan pemeriksaan pajak (Tax Audit Assistance), restrukturisasi bisnis, serta penyusunan Transfer Pricing Documentation (TP Doc).\n\nRama Bintang merekayasa ulang seluruh kehadiran digital TaxGBC agar memancarkan otoritas, profesionalisme hukum yang kokoh, dan standar keamanan data tinggi. Platform ini dirancang dengan arsitektur informasi terstruktur yang membagi layanan pajak perseorangan dan korporasi secara spesifik, dilengkapi portal publikasi artikel perpajakan dinamis untuk membangun thought leadership, serta modul reservasi sesi konsultasi advisory yang aman dan terenkripsi.",
                'challenge' => 'Sektor jasa konsultasi pajak korporasi menuntut tingkat kepatuhan (trust & authority) yang sangat ketat. Situs web sebelumnya memiliki navigasi yang membingungkan bagi eksekutif C-level, lambat diakses, dan belum teroptimasi untuk mesin pencari, sehingga sulit bersaing dengan firma audit multinasional di peringkat Google.',
                'solution' => 'Membangun arsitektur website korporat berstandar institusi keuangan dengan tipografi formal yang modern, struktur internal linking berbasis topik regulasi UU Perpajakan, optimasi skema schema.org Organization & ProfessionalService, serta sistem caching server terdistribusi Cloudflare yang menghasilkan waktu muat sub-detik.',
                'results' => [
                    'Skor Core Web Vitals dan SEO teknis mencapai 99/100',
                    'Pertumbuhan konsultasi masuk dari klien perusahaan skala menengah dan besar naik 85% dalam 3 bulan',
                    'Peningkatan durasi baca artikel wawasan regulasi perpajakan hingga 3x lipat dibanding website lama',
                    'Membangun kredibilitas instan di mata direktur keuangan (CFO) dan manajer akuntansi perusahaan klien'
                ],
                'image_url' => '/storage/portfolios/1788455059_taxgbc-solusi-pajak-bisnis-anda-09-04-2026-12-03-am.png',
                'tech_stack' => ['WordPress', 'Elementor Pro', 'Yoast SEO Premium', 'Cloudflare CDN', 'PHP 8.2'],
                'live_url' => 'https://taxgbc.com/',
                'status' => 'published',
                'focus_keyword' => 'Konsultan Pajak Perusahaan TaxGBC',
                'meta_title' => 'Company Profile: TaxGBC Guna Bersama Consulting - Case Study',
                'canonical_url' => 'https://taxgbc.com/',
                'seo_score' => 96,
            ],
            [
                'title' => 'Fintech Core Platform & Enterprise Dashboard',
                'slug' => 'fintech-core-platform-enterprise-dashboard',
                'category' => 'Enterprise System',
                'client' => 'PT Bank Nusa Digital',
                'year' => '2026',
                'summary' => 'Platform perbankan digital terpadu dengan arsitektur microservices terdistribusi yang memproses jutaan transaksi finansial harian dengan latensi sub-detik dan kepatuhan standar OJK.',
                'description' => "Sistem perbankan inti (core banking) dan dashboard manajemen operasional generasi baru yang dirancang untuk menangani beban transaksi perbankan digital skala besar. Platform ini mencakup modul pemrosesan transfer dana antar-bank real-time (terintegrasi protokol BI-FAST), manajemen rekening nasabah multi-tier, otomatisasi kliring dan rekonsiliasi kasir harian, hingga sistem deteksi kecurangan (Fraud Detection System) yang beroperasi secara otonom.\n\nSistem mengadopsi arsitektur decoupled di mana backend Laravel Microservices bertindak sebagai API gateway berkinerja tinggi yang terhubung dengan antrean Redis terdistribusi dan basis data PostgreSQL dengan pemisahan operasi Read/Write. Frontend dashboard eksekutif dibangun menggunakan Astro yang menyajikan visualisasi analitik likuiditas dan metrik finansial tanpa jeda render, dipersenjatai proteksi otentikasi multi-faktor (MFA) dan audit logging forensik yang memenuhi standar regulasi OJK.",
                'challenge' => 'Infrastruktur monolith lama perbankan sering mengalami kegagalan proses transaksi dan lonjakan latensi respons (timeout) hingga 15 detik pada saat jam sibuk awal bulan. Kebutuhan migrasi data jutaan akun nasabah harus dilakukan secara bertahap tanpa toleransi adanya downtime operasional perbankan (Zero-Downtime Migration).',
                'solution' => 'Membangun arsitektur microservices modern dengan API Gateway terisolasi, mengimplementasikan antrean asinkron RabbitMQ & Redis Cluster untuk buffering request puncak, menerapkan pola Database Replication (Master-Replica), serta membangun dashboard analitik front-end yang ringan dengan Astro Islands Architecture.',
                'results' => [
                    'Peningkatan kecepatan transaksi hingga 300% dengan latensi rata-rata turun di bawah 120 milidetik',
                    'Pencapaian SLA Uptime sistem perbankan sebesar 99.99% tanpa gangguan pada periode gajian',
                    'Throughput beban transaksi harian melonjak 5x lipat hingga lebih dari 2.500 TPS (Transactions Per Second)',
                    'Proses rekonsiliasi kasir dan pembukuan harian otomatis terpangkas dari 4 jam menjadi hanya 8 menit'
                ],
                'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuC8PG6LZ_xog1u35WvCdLZrEQtuYI6YiFXwTsQb8q1Ae3nS6-FH3uxPXgOXfyHbz-IA_WP4_oS-0RCQR6nkokm_6KUqnw2RFckoP2SOsCwQzipAaciCKXiUWXuWiLaAWTpHIR38ItopTBFvvJoWDa4hfccYtHsUyYiv6NdBfkGC37sGg6VSWABqzrt11f6Yp3-EIzX2nclxfvnuZ_FAT9ZePy0xZcKpCY__cF_Mw7iSMKED_2_vGxLD',
                'tech_stack' => ['Laravel Microservices', 'Astro', 'Redis Cluster', 'PostgreSQL', 'Tailwind CSS', 'Docker', 'RabbitMQ'],
                'live_url' => null,
                'status' => 'published',
                'focus_keyword' => 'Fintech Core Banking Platform',
                'meta_title' => 'Fintech Core Platform & Enterprise Dashboard - Case Study',
                'canonical_url' => 'http://localhost:4321/portfolio/fintech-core-platform-enterprise-dashboard',
                'seo_score' => 95,
            ],
            [
                'title' => 'E-Commerce Ecosystem & Omnichannel Integration',
                'slug' => 'e-commerce-ecosystem-omnichannel-integration',
                'category' => 'E-Commerce',
                'client' => 'Global Brand Fashion Group',
                'year' => '2025',
                'summary' => 'Ekosistem perdagangan ritel modern yang mengintegrasikan puluhan gerai fisik (POS) dengan website e-commerce headless dan multi-marketplace dalam sinkronisasi persediaan real-time.',
                'description' => "Solusi sistem perdagangan ritel terpadu (omnichannel commerce) yang menyatukan seluruh kanal penjualan online dan offline ke dalam satu kendali terpusat. Platform ini dirancang untuk memecahkan problematika krusial industri fashion ritel: perbedaan stok fisik toko vs marketplace yang sering memicu pembatalan pesanan sepihak dan kerugian biaya retur.\n\nSistem mencakup modul manajemen inventori multi-gudang cerdas dengan Smart Order Routing (pesanan otomatis dialihkan ke cabang toko terdekat dari alamat konsumen demi ongkos kirim termurah), integrasi POS kasir offline, sinkronisasi produk instan ke marketplace (Shopee, Tokopedia, TikTok Shop), program keanggotaan loyalty QR digital, serta storefront e-commerce headless berbasis Astro yang memberikan sensasi belanja super cepat dan mulus.",
                'challenge' => 'Klien mengoperasikan lebih dari 80 toko cabang fisik dan 4 channel marketplace besar. Sinkronisasi manual yang lambat menyebabkan persentase overselling mencapai 12% setiap kali diadakan flash sale diskon besar, memicu ulasan negatif dan penalti toko dari pihak marketplace.',
                'solution' => 'Membangun middleware integrasi berbasis Laravel API dengan antrean Redis dan WebSockets terpadu. Setiap ada pergerakan stok di kasir fisik cabang manapun, kuota produk di seluruh toko online dan marketplace otomatis diperbarui dalam hitungan di bawah 500 milidetik. Menghadirkan antarmuka belanja headless ultra-cepat dengan optimasi checkout 1-klik.',
                'results' => [
                    'Akurasi sinkronisasi stok multi-cabang mencapai 100% tanpa ada insiden overselling atau penalti toko',
                    'Peningkatan tingkat konversi checkout website sebesar 45% berkat kecepatan loading instan',
                    'Efisiensi penghematan biaya logistik pengiriman mencapai 28% lewat algoritma smart order routing',
                    'Tingkat pembelian ulang (repeat order) anggota loyalty melonjak 60% dalam tempo 6 bulan'
                ],
                'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCI7se4EiBr0Vq4e3-TKVz9kP7p7Eg___fIcMp7oGuXVBnlPdYiYRkp0RfAgaGEunrHU-wTt3h23qKjKFozmoQSGbgLkcD4mzn8cLuc2DbNLvuwd2VpeP_pIHrzx50OIrOtY6cMeOJ6ETTPhZ6cWLJbHIep-Vd5H9QsivTG2WVTTomOBy6NGENMt5gsxqCu5W2RpIG2JAXgAsPeX27Bi-AuYcceLxOv7PyR67HnClI6p1bv22zz2mJq',
                'tech_stack' => ['Laravel API', 'Astro JS', 'Tailwind CSS', 'MySQL Enterprise', 'Redis', 'WebSockets', 'Payment Gateway'],
                'live_url' => null,
                'status' => 'published',
                'focus_keyword' => 'Omnichannel E-Commerce Integration',
                'meta_title' => 'E-Commerce Ecosystem & Omnichannel Integration - Case Study',
                'canonical_url' => 'http://localhost:4321/portfolio/e-commerce-ecosystem-omnichannel-integration',
                'seo_score' => 93,
            ],
            [
                'title' => 'Healthcare Management & Telemedicine Portal',
                'slug' => 'healthcare-management-telemedicine-portal',
                'category' => 'Healthcare Tech',
                'client' => 'Medica Health Systems',
                'year' => '2025',
                'summary' => 'Sistem Informasi Manajemen Rumah Sakit (SIMRS) dan portal konsultasi dokter online real-time dengan integrasi Rekam Medis Elektronik (RME) terenkripsi dan e-prescribing farmasi.',
                'description' => "Aplikasi ekosistem kesehatan terpadu yang dirancang untuk memodernisasi tata kelola operasional rumah sakit dan memperluas jangkauan layanan medis kepada masyarakat luas. Melalui portal pasien berbasis web responsif, pengguna dapat melakukan reservasi tiket antrean poliklinik secara mandiri, melakukan video konsultasi telemedis langsung dengan dokter spesialis, serta mengakses riwayat diagnosa dan hasil laboratorium secara aman.\n\nDi sisi internal rumah sakit, sistem mengintegrasikan modul Rekam Medis Elektronik (RME) yang mematuhi standar interoperabilitas SatuSehat Kemenkes RI, modul monitoring keterisian tempat tidur rawat inap (Bed Management), pemrosesan resep digital (e-prescribing) yang terhubung langsung ke gudang farmasi, serta pelaporan keuangan klaim asuransi kesehatan yang akurat dan transparan.",
                'challenge' => 'Antrean fisik pendaftaran pasien di rumah sakit sering mengular hingga berjam-jam, memicu ketidakpuasan pasien dan kelelahan staf administrasi. Selain itu, catatan medis pasien terdahulu masih berbasis kertas manual yang rentan hilang, rusak, atau lambat dicari saat situasi darurat medis.',
                'solution' => 'Mengembangkan portal telemedis dan sistem RME berbasis cloud dengan protokol enkripsi AES-256 end-to-end. Memanfaatkan WebRTC untuk sesi video call konsultasi dokter dengan latensi rendah tanpa perlu aplikasi tambahan, serta membangun antarmuka web intuitif berbasis Astro yang mudah dioperasikan oleh pasien lansia sekalipun.',
                'results' => [
                    'Melayani lebih dari 50.000 pasien aktif bulanan dengan tingkat kepuasan layanan 4.8/5',
                    'Memangkas waktu tunggu antrean di loket fisik rumah sakit hingga 60%',
                    'Efisiensi pemrosesan dan penyiapan resep farmasi melonjak 75% berkat sistem e-prescribing terpadu',
                    'Kepatuhan audit standar privasi dan keamanan data rekam medis elektronik 100%'
                ],
                'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuArSHOEP40tyxvWKnpf2qqn1wSCVOeHUBt0_kILKzSfIa0xBUTzulRwaMskXmzMgqidLGca13XX8ZqaiiFRYaaQkUMyI1CYhDb-GxeD9LV8_5wuIeoAubhWYCIM6X9gj4K2ZI_xDggovtqkMyhbeSOxK2Cp7HHgYgeF4JJ0eP9LjbOqMNs0ZkESFpn8xBygqVwq7ITAyGBkv7pj8Ogq0J4mrVaOL1DaQoQlfSoYLvO1uK_ilmwPh7sc',
                'tech_stack' => ['Laravel API', 'Astro', 'WebSockets', 'WebRTC', 'PostgreSQL', 'Tailwind CSS', 'Redis'],
                'live_url' => null,
                'status' => 'published',
                'focus_keyword' => 'SIMRS Telemedicine Portal',
                'meta_title' => 'Healthcare Management & Telemedicine Portal - Case Study',
                'canonical_url' => 'http://localhost:4321/portfolio/healthcare-management-telemedicine-portal',
                'seo_score' => 92,
            ],
        ];

        foreach ($portfolios as $portfolioData) {
            Portfolio::updateOrCreate(
                ['slug' => $portfolioData['slug']],
                $portfolioData
            );
        }
    }
}
