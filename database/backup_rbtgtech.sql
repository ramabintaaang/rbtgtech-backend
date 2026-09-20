-- MySQL dump 10.13  Distrib 8.0.31, for macos12 (arm64)
--
-- Host: localhost    Database: rbtgtech
-- ------------------------------------------------------
-- Server version	8.0.31

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `articles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `summary` text COLLATE utf8mb4_unicode_ci,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Teknologi',
  `author_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Tim Engineering rbtgtech',
  `author_role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Lead Systems Architect',
  `author_avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '/logo-rbtgtech.png',
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` json DEFAULT NULL,
  `read_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '5 menit',
  `status` enum('published','draft') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `published_at` timestamp NULL DEFAULT NULL,
  `focus_keyword` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `canonical_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_score` int NOT NULL DEFAULT '85',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `articles_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articles`
--

LOCK TABLES `articles` WRITE;
/*!40000 ALTER TABLE `articles` DISABLE KEYS */;
INSERT INTO `articles` VALUES (1,'Mengapa Astro & Laravel Adalah Kombinasi Sistem Enterprise Terbaik di 2026','mengapa-astro-dan-laravel-kombinasi-sistem-enterprise-terbaik','Menggabungkan kecepatan rendering statis frontend Astro dengan keandalan backend RESTful API Laravel untuk performa dan keamanan maksimal.','<p>Dalam lanskap pengembangan web modern, performa tinggi, keamanan ketat, dan optimasi SEO maksimal adalah tiga pilar utama yang dicari oleh setiap perusahaan teknologi. Menggabungkan <strong>Astro JS</strong> di sisi frontend dengan <strong>Laravel API</strong> di sisi backend memberikan arsitektur modern yang memisahkan tanggung jawab (decoupled design) dengan sempurna.</p><h2>1. Kecepatan Performa dengan Zero JavaScript Default</h2><p>Astro menghadirkan konsep <em>Islands Architecture</em> yang meminimalkan pengiriman JavaScript ke browser pengguna. Halaman dapat di-render secara statis (SSG) atau Server-Side Rendered (SSR) dengan waktu muat di bawah 1 detik.</p><h2>2. Laravel Sebagai Headless CMS & Backend REST API</h2><p>Laravel menyediakan fondasi backend yang sangat matang: ORM Eloquent, otentikasi Sanctum/Passport, queue management, serta arsitektur API yang aman. Menggunakan Laravel sebagai API backend memberikan fleksibilitas untuk melayani web client, mobile apps, dan integrasi pihak ketiga sekaligus.</p><h2>3. Strategi SEO & Jamstack Modern</h2><p>Dengan Astro, meta tag, Open Graph, dan JSON-LD schema dihasilkan secara langsung saat build atau per request server. Mesin pencari seperti Google dapat membaca seluruh struktur konten tanpa harus menunggu eksekusi client-side JavaScript.</p><h2>Kesimpulan</h2><p>Bagi bisnis yang menginginkan kehadiran digital yang sangat cepat, aman, dan mudah di-scale, arsitektur headless Astro + Laravel adalah investasi teknologi jangka panjang yang paling rasional.</p>','Teknologi','Admin','Administrator','/logo-rbtgtech.png','/images/articles/article-astro-laravel.jpg','[\"Astro\", \"Laravel\", \"SEO\", \"Architecture\"]','5 menit','published','2026-03-12 03:00:00','Astro Laravel Enterprise','Mengapa Astro & Laravel Kombinasi Sistem Enterprise Terbaik 2026','http://localhost:4321/artikel/mengapa-astro-dan-laravel-kombinasi-sistem-enterprise-terbaik',92,'2026-08-03 09:42:32','2026-09-07 10:22:23'),(2,'Panduan Praktis Strategi SEO Technical untuk Aplikasi Web Modern','panduan-praktis-strategi-seo-technical-aplikasi-web-modern','Langkah demi langkah mengoptimalkan Core Web Vitals, Structured Data JSON-LD, serta kecepatan muat halaman untuk menduduki peringkat teratas Google.','<p>SEO Technical tidak lagi sebatas tentang keyword density. Di tahun 2026, algoritma pencari memprioritaskan pengalaman pengguna secara nyata: skor Core Web Vitals, keramahan perangkat seluler, serta kepastian struktur data.</p><h2>Kunci Utama SEO Technical:</h2><ul><li><strong>Core Web Vitals Optimization:</strong> Pastikan LCP (Largest Contentful Paint) di bawah 2.5 detik dan CLS (Cumulative Layout Shift) mendekati 0.</li><li><strong>Structured Data JSON-LD:</strong> Berikan informasi kaya kepada bot pencari menggunakan standar schema.org untuk Organization, Breadcrumb, dan BlogPosting.</li><li><strong>Canonical URLs & Clean Routing:</strong> Hindari konten duplikat dengan konsistensi URL canonical di setiap header halaman.</li></ul>','SEO & Digital','Admin','Administrator','/logo-rbtgtech.png','/images/articles/article-seo-technical.jpg','[\"SEO\", \"Performance\", \"Core Web Vitals\"]','4 menit','published','2026-01-20 08:30:00','SEO Technical Web Modern','Panduan Praktis Strategi SEO Technical Aplikasi Web 2026','http://localhost:4321/artikel/panduan-praktis-strategi-seo-technical-aplikasi-web-modern',88,'2026-08-03 09:42:32','2026-09-07 10:22:23'),(3,'Desain Sistem Skalabel: Membangun Web Enterprise Tahan Beban Tinggi','desain-sistem-skalabel-membangun-web-enterprise-tahan-beban-tinggi','Panduan komprehensif merancang arsitektur sistem web enterprise berskala tinggi: dari strategi horizontal scaling, multi-tier caching, read/write database splitting, asynchronous queue, hingga pola resiliensi menghadapi lonjakan jutaan request harian.','<p>Dalam lanskap bisnis digital saat ini, ketersediaan sistem tanpa henti (<em>high availability</em>) dan latensi respons super cepat adalah tolok ukur kesuksesan aplikasi tingkat korporat. Lonjakan traffic tak terduga—baik dari kampanye promosi, flash sale, maupun integrasi API mitra—sering kali membuat aplikasi web tradisional tumbang karena bottleneck pada basis data atau kehabisan alokasi thread komputasi. <strong>Desain sistem skalabel</strong> bukan sekadar menambah kapasitas RAM atau CPU server, melainkan membangun arsitektur perangkat lunak yang tangguh, modular, dan mampu bertumbuh secara elastis seiring peningkatan beban kerja pengguna.</p><h2>1. Prinsip Dasar: Dari Skalabilitas Vertikal Menuju Horizontal</h2><p>Banyak organisasi memulai dengan <em>vertical scaling</em> (scale-up)—meningkatkan spesifikasi satu mesin server. Meskipun mudah diterapkan di awal, pendekatan ini memiliki batas fisik (<em>hardware ceiling</em>) dan menimbulkan <strong>Single Point of Failure (SPOF)</strong>. Jika server tersebut mengalami crash, seluruh layanan mati total.</p><p>Sebaliknya, sistem enterprise modern mengadopsi <strong>Horizontal Scaling (scale-out)</strong>—menambah puluhan hingga ratusan instance server berukuran sedang di balik <em>Load Balancer</em> (seperti NGINX, HAProxy, atau AWS Application Load Balancer). Agar horizontal scaling berjalan lancar, aplikasi web wajib bersifat <strong>Stateless</strong>:</p><ul><li><strong>Session Management Terpusat:</strong> Jangan simpan user session di memory lokal web server. Gunakan distributed memory cache seperti <strong>Redis Cluster</strong> atau basis data sesi terisolasi.</li><li><strong>Penyimpanan Berkas Statis & Media:</strong> File upload tidak boleh disimpan di local disk server aplikasi; alirkan seluruh aset media ke Object Storage terdistribusi seperti AWS S3, Google Cloud Storage, atau MinIO yang terhubung dengan Content Delivery Network (CDN).</li></ul><h2>2. Arsitektur Basis Data Tahan Beban: Pola Read/Write Splitting</h2><p>Dalam mayoritas aplikasi web enterprise, pola lalu lintas data umumnya didominasi oleh operasi pembacaan (Read) hingga 80-90%, sedangkan operasi penulisan (Write) berkisar 10-20%. Membebankan seluruh query ke satu database server adalah penyebab utama database bottleneck.</p><p>Solusi standar industri adalah menerapkan <strong>Database Replication (Master-Replica)</strong>:</p><ul><li><strong>Primary / Master Node:</strong> Dikhususkan secara eksklusif untuk mengeksekusi operasi transaksi penulisan data (<em>INSERT, UPDATE, DELETE</em>).</li><li><strong>Read Replica Nodes:</strong> Terdiri dari beberapa server replika yang menduplikasi data secara asinkron dari Master Node dan melayani seluruh query pembacaan (<em>SELECT</em>).</li><li><strong>Connection Pooling:</strong> Mencegah kehabisan koneksi database di saat traffic tinggi dengan menggunakan connection pooler seperti PgBouncer untuk PostgreSQL atau ProxySQL untuk MySQL.</li></ul><h2>3. Multi-Tier Caching Strategy: Memotong Beban hingga 90%</h2><p>Strategi caching yang dirancang dengan benar mampu mengurangi beban database hingga lebih dari 90% sekaligus memangkas waktu muat (latency) menjadi di bawah 10 milidetik. Sistem enterprise menerapkan caching multi-tingkat:</p><ul><li><strong>Edge Caching (CDN):</strong> Menyajikan HTML statis, file JavaScript, CSS, dan media langsung dari server terdekat dengan lokasi fisik pengguna melalui jaringan CDN global (seperti Cloudflare atau CloudFront).</li><li><strong>In-Memory Application Caching:</strong> Menyimpan hasil query database yang sering diakses (seperti katalog produk, konfigurasi situs, atau profil pengguna) di Redis menggunakan pola <em>Cache-Aside Pattern</em>.</li><li><strong>HTTP Reverse Proxy:</strong> Memanfaatkan caching proxy pada web server untuk menyimpan respons API publik yang identik dalam jangka waktu tertentu (Time-To-Live / TTL).</li></ul><h2>4. Pemrosesan Asinkron dengan Asynchronous Message Queue</h2><p>Salah satu kesalahan fatal yang sering memperlambat aplikasi web adalah memproses tugas-tugas berat di dalam siklus HTTP request pengguna (<em>synchronous processing</em>). Mengirim email notifikasi, memproses dokumen PDF, kompresi video, atau memanggil webhook pihak ketiga di dalam controller akan mengunci koneksi pengguna dan menghabiskan resource web worker.</p><p>Pindahkan seluruh pekerjaan non-kritis ke background worker menggunakan <strong>Message Broker</strong> seperti <strong>RabbitMQ, Redis Queue, atau Apache Kafka</strong>:</p><ul><li>Server web hanya bertugas menerima request, memvalidasi data, menaruh pesan pekerjaan (job) ke dalam antrean (queue), dan langsung mengembalikan respons HTTP 200/202 ke browser pengguna dalam hitungan milidetik.</li><li>Pekerja background (Queue Workers) yang berjalan di server terpisah akan mengambil dan mengeksekusi job tersebut secara bertahap tanpa mengganggu responsivitas antarmuka utama pengguna.</li></ul><h2>5. Pola Resiliensi: Circuit Breaker & Graceful Degradation</h2><p>Ketika sebuah sistem terdiri dari puluhan service terdistribusi atau bergantung pada API pihak ketiga (misalnya Payment Gateway atau Logistik), kegagalan pada salah satu service dapat memicu <em>cascading failure</em> yang merembet ke seluruh sistem.</p><p>Terapkan pola <strong>Circuit Breaker</strong>:</p><ul><li>Jika sebuah external API mengalami timeout atau error beruntun, circuit breaker akan terbuka secara otomatis untuk menghentikan pemanggilan sementara waktu dan langsung mengembalikan respons <em>fallback</em> (misalnya pesan: <em>\"Metode pembayaran ini sedang dalam pemeliharaan, silakan gunakan metode alternatif\"</em>).</li><li>Hal ini mencegah worker thread terkunci berlama-lama menunggu respons yang tidak kunjung datang.</li><li>Kombinasikan dengan <strong>Adaptive Rate Limiting</strong> untuk melindungi endpoint API dari lonjakan request berlebih atau serangan brute force bot.</li></ul><h2>6. Observability: Monitoring Proaktif & Alerting Real-time</h2><p>Sistem tidak dapat disebut andal jika tim engineering baru mengetahui adanya masalah setelah menerima komplain dari pengguna. Observabilitas tingkat enterprise mencakup tiga pilar utama:</p><ul><li><strong>Distributed Tracing:</strong> Melacak perjalanan setiap request pengguna dari frontend melintasi seluruh mikroservis backend (misalnya menggunakan OpenTelemetry atau Jaeger).</li><li><strong>Application Performance Monitoring (APM):</strong> Memantau penggunaan CPU, memory consumption, durasi eksekusi query SQL, dan error rate per endpoint secara real-time.</li><li><strong>Centralized Logging:</strong> Mengumpulkan log dari ratusan container ke dalam satu platform terpusat (seperti Elasticsearch / Grafana Loki) untuk investigasi insiden secara cepat.</li></ul><h2>Kesimpulan</h2><p>Merancang aplikasi web enterprise tahan beban tinggi bukanlah proses instan, melainkan penerapan disiplin arsitektur yang konsisten: memastikan sistem bersifat <em>stateless</em>, memisahkan pemrosesan berat ke <em>queue</em>, memanfaatkan <em>caching</em> secara agresif, serta melindungi database dengan pola replikasi. Dengan fondasi arsitektur yang kokoh, bisnis Anda dapat bertumbuh secara eksponensial tanpa rasa cemas akan ancaman downtime.</p>','Arsitektur Sistem','Admin','Administrator','/logo-rbtgtech.png','/images/articles/article-system-scale.jpg','[\"Scalability\", \"System Architecture\", \"High Availability\", \"Database Replication\", \"Microservices\", \"Redis\"]','8 menit','published','2025-11-08 02:15:00','Desain Sistem Skalabel Web Enterprise','Desain Sistem Skalabel: Membangun Web Enterprise Tahan Beban Tinggi','http://localhost:4321/artikel/desain-sistem-skalabel-membangun-web-enterprise-tahan-beban-tinggi',98,'2026-08-03 09:42:32','2026-09-07 10:24:40'),(4,'Revolusi Generative AI & Autonomous Agent: Bagaimana Bisnis Modern Memanfaatkan AI di 2026','revolusi-generative-ai-autonomous-agent-bisnis-modern-2026','Evolusi dari sekadar chatbot interaktif menuju sistem agen AI otonom yang mampu mengeksekusi alur kerja kompleks, meningkatkan produktivitas tim, dan mengoptimalkan keputusan bisnis secara real-time.','<p>Memasuki tahun 2026, adopsi <strong>Artificial Intelligence (AI)</strong> di tingkat enterprise telah mengalami lompatan transformatif. Jika beberapa tahun ke belakang perbincangan masih berkisar pada <em>generative chat interfaces</em> sederhana, kini fokus bergeser ke <strong>Autonomous AI Agents</strong>—agen otonom yang tidak hanya menjawab pertanyaan, melainkan mampu merencanakan, membagi tugas, dan mengeksekusi tindakan nyata di berbagai sistem software.</p><h2>1. Dari Chatbot Reaktif Menuju Agentic AI Berorientasi Tindakan</h2><p>Perbedaan mendasar antara LLM standar dengan <em>Agentic Workflow</em> terletak pada otonomi eksekusi. Agen AI modern dilengkapi dengan kemampuan <strong>Function Calling</strong> dan akses ke API eksternal. Agen dapat menerima instruksi tingkat tinggi dari manajer, misalnya: <em>\\\"Lakukan audit performa server bulan lalu dan susun laporan ke Slack\\\"</em>, lalu secara otomatis menjalankan query database, menyusun data, membuat visualisasi, hingga mengirimkannya ke channel terkait.</p><h2>2. Arsitektur Multi-Agent dalam Operasional Enterprise</h2><p>Dalam skala bisnis besar, mengandalkan satu model untuk semua urusan terbukti tidak efisien. Paradigma terkini menggunakan <strong>Multi-Agent Systems</strong>, di mana beberapa agen terspesialisasi bekerja sama:</p><ul><li><strong>Researcher Agent:</strong> Bertugas mengumpulkan data relevan dari dokumen internal perusahaan maupun riset pasar terkini.</li><li><strong>Coder / Builder Agent:</strong> Mengubah spesifikasi kebutuhan teknis menjadi skrip otomatisasi atau konfigurasi sistem.</li><li><strong>Critic / Evaluator Agent:</strong> Melakukan validasi output sebelum diserahkan kepada pengguna untuk memastikan akurasi dan menekan tingkat halusinasi.</li></ul><h2>3. Strategi Implementasi yang Aman dan Terukur</h2><p>Meskipun potensi efisiensi sangat besar, adopsi AI di lingkungan bisnis menuntut kehati-hatian ekstra. Pendekatan <em>Human-in-the-Loop (HITL)</em> tetap menjadi standar emas, terutama untuk tindakan berisiko tinggi seperti transfer finansial atau modifikasi database produksi. Selain itu, enkripsi data in-transit dan privasi informasi rahasia perusahaan adalah harga mati yang tidak bisa ditawar.</p><h2>Kesimpulan</h2><p>Artificial Intelligence bukan lagi sekadar eksperimen inovasi, melainkan diferensiator kompetitif utama. Perusahaan yang mengintegrasikan alur kerja agen otonom secara terstruktur akan bergerak berkali-kali lipat lebih cepat dan efisien dibandingkan pesaingnya.</p>','Artificial Intelligence','Admin','Administrator','/logo-rbtgtech.png','/images/articles/article-ai-agent.jpg','[\"Artificial Intelligence\", \"AI Agents\", \"Autonomous AI\", \"Machine Learning\", \"Enterprise\"]','6 menit','published','2026-09-02 02:30:00','Generative AI Autonomous Agent Bisnis','Revolusi Generative AI & Autonomous Agent untuk Bisnis Modern 2026','http://localhost:4321/artikel/revolusi-generative-ai-autonomous-agent-bisnis-modern-2026',96,'2026-09-07 10:13:41','2026-09-07 10:22:23'),(5,'Panduan Praktis Integrasi LLM & RAG pada Arsitektur Web Modern','panduan-praktis-integrasi-llm-rag-arsitektur-web-modern','Cara menghubungkan Large Language Model dengan basis data private perusahaan menggunakan Retrieval-Augmented Generation (RAG) dan Vector Database untuk jawaban yang akurat dan minim halusinasi.','<p>Salah satu tantangan terbesar saat memanfaatkan Large Language Model (LLM) untuk kebutuhan perusahaan adalah <em>knowledge cutoff</em> dan ketidaktahuan model terhadap data privat internal perusahaan. Menjawab tantangan ini, <strong>Retrieval-Augmented Generation (RAG)</strong> telah menjadi arsitektur standar industri yang menjembatani model kecerdasan buatan dengan basis pengetahuan bisnis.</p><h2>1. Bagaimana Arsitektur RAG Bekerja?</h2><p>Alih-alih melakukan <em>fine-tuning</em> yang memakan biaya besar dan waktu komputasi lama, RAG bekerja dengan metode dinamis yang jauh lebih lincah:</p><ul><li><strong>Chunking & Embedding:</strong> Dokumen internal (PDF, manual panduan, database SOP, catatan pelanggan) dipecah menjadi potongan teks terstruktur dan diubah menjadi vektor numerik melalui embedding model.</li><li><strong>Vector Database Storage:</strong> Vektor disimpan dalam database khusus pencarian semantik (seperti pgvector, Pinecone, atau Milvus).</li><li><strong>Semantic Retrieval:</strong> Ketika user mengajukan pertanyaan, sistem mencari potongan dokumen yang paling relevan secara semantik berdasarkan kedekatan jarak vektor (cosine similarity).</li><li><strong>Augmented Context Generation:</strong> Potongan konteks dokumen tersebut disuntikkan ke dalam prompt LLM sehingga model dapat memberikan respons yang presisi berdasarkan data riil perusahaan.</li></ul><h2>2. Optimasi Latensi dan Biaya Token</h2><p>Dalam implementasi produksi, kecepatan respons dan efisiensi biaya adalah kunci. Beberapa praktik terbaik yang diterapkan tim engineering rbtgtech meliputi:</p><ul><li><strong>Streaming Response via Server-Sent Events (SSE):</strong> Pengguna tidak perlu menunggu respons selesai di-generate secara penuh; teks dialirkan kata demi kata (token streaming) secara instan.</li><li><strong>Prompt & Embedding Caching:</strong> Pertanyaan berulang disimpan pada Redis cache untuk menghemat biaya API eksternal dan memotong latensi hingga 90%.</li><li><strong>Hybrid Search:</strong> Menggabungkan pencarian kata kunci (full-text search) dengan pencarian semantik untuk memastikan akurasi maksimal pada istilah teknis spesifik.</li></ul><h2>Kesimpulan</h2><p>Dengan mengadopsi RAG, perusahaan dapat memiliki asisten cerdas internal yang selalu up-to-date dengan data bisnis tanpa risiko kebocoran data sensitif ke publik.</p>','Artificial Intelligence','Admin','Administrator','/logo-rbtgtech.png','/images/articles/article-llm-rag.jpg','[\"RAG\", \"Vector Database\", \"LLM\", \"AI Integration\", \"Web Architecture\"]','5 menit','published','2026-07-16 07:15:00','Panduan RAG LLM Web Modern','Panduan Praktis Integrasi LLM & RAG pada Arsitektur Web Modern','http://localhost:4321/artikel/panduan-praktis-integrasi-llm-rag-arsitektur-web-modern',94,'2026-09-07 10:13:41','2026-09-07 10:22:23'),(6,'Keamanan Data & Privasi dalam Implementasi Enterprise AI','keamanan-data-dan-privasi-implementasi-enterprise-ai','Memahami tata kelola data, kepatuhan regulasi privasi, dan strategi mitigasi risiko prompt injection saat mengimplementasikan kecerdasan buatan di level korporasi.','<p>Kehadiran kecerdasan buatan membuka peluang efisiensi luar biasa, namun bagi sektor korporat, perbankan, dan kesehatan, risiko kebocoran data sensitif adalah ancaman nyata. Tanpa strategi keamanan yang matang, implementasi AI dapat menimbulkan celah kerentanan baru yang merugikan reputasi bisnis.</p><h2>1. Bahaya Shadow AI & Kebocoran Kekayaan Intelektual</h2><p>Banyak karyawan menggunakan tool AI publik pihak ketiga tanpa protokol keamanan resmi. Data rahasia perusahaan seperti kode program sumber (source code), laporan keuangan kuartal, hingga data pribadi konsumen dapat tersimpan di server pihak ketiga dan berpotensi dijadikan bahan pelatihan model generasi berikutnya.</p><h2>2. Strategi Perlindungan: On-Premise vs Enterprise Private API</h2><p>Untuk memastikan kedaulatan data (<em>data sovereignty</em>), perusahaan memiliki dua opsi arsitektur utama:</p><ul><li><strong>Private Enterprise Cloud API:</strong> Memanfaatkan penyedia model besar dengan jaminan klausul Zero-Data Retention (ZDR), di mana request data dijamin tidak disimpan atau digunakan untuk melatih model publik.</li><li><strong>Self-Hosted Open Weights Models:</strong> Menjalankan model open-source berkinerja tinggi (seperti model keluarga Gemma atau Llama) secara mandiri di server lokal / Virtual Private Cloud internal yang terisolasi total dari internet publik.</li></ul><h2>3. Mitigasi Prompt Injection & Jailbreak Attacks</h2><p>Sama halnya dengan serangan SQL Injection pada aplikasi web tradisional, AI model juga rentan terhadap serangan <strong>Prompt Injection</strong>, di mana penyerang berusaha memanipulasi instruksi sistem untuk membocorkan data tersembunyi. Solusinya adalah menerapkan layer validasi input & output (Guardrails) sebelum dan sesudah data berinteraksi dengan model cerdas.</p><h2>Kesimpulan</h2><p>Implementasi AI yang sukses bukan hanya tentang seberapa canggih model yang digunakan, tetapi seberapa andal tata kelola keamanan dan privasi yang memayunginya.</p>','Artificial Intelligence','Admin','Administrator','/logo-rbtgtech.png','/images/articles/article-ai-security.jpg','[\"AI Security\", \"Data Privacy\", \"Enterprise AI\", \"Cyber Security\"]','5 menit','published','2026-05-28 04:00:00','Keamanan Data Privasi Enterprise AI','Keamanan Data & Privasi dalam Implementasi Enterprise AI','http://localhost:4321/artikel/keamanan-data-dan-privasi-implementasi-enterprise-ai',91,'2026-09-07 10:13:41','2026-09-07 10:22:23');
/*!40000 ALTER TABLE `articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('article','portfolio','both') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'both',
  `description` text COLLATE utf8mb4_unicode_ci,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'folder',
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'primary',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Teknologi','teknologi','article','Artikel seputar perkembangan teknologi web stack modern, Astro JS, dan Laravel framework.','devices','primary',1,'2026-08-03 09:54:12','2026-08-03 09:54:12'),(2,'SEO & Digital','seo-digital','article','Strategi optimasi mesin pencari (SEO), Core Web Vitals, dan visibilitas digital.','search','emerald',2,'2026-08-03 09:54:12','2026-08-03 09:54:12'),(3,'Arsitektur Sistem','arsitektur-sistem','article','Prinsip perancangan sistem enterprise, mikroarsitektur, dan desain skalabilitas tinggi.','account_tree','indigo',3,'2026-08-03 09:54:12','2026-08-03 09:54:12'),(4,'Berita Perusahaan','berita-perusahaan','article','Kabar terbaru, pencapaian tim, dan pengumuman resmi RBTG Tech.','campaign','amber',4,'2026-08-03 09:54:12','2026-08-03 09:54:12'),(5,'Enterprise System','enterprise-system','portfolio','Studi kasus pengembangan sistem inti perusahaan skala besar dan perbankan.','domain','primary',5,'2026-08-03 09:54:12','2026-08-03 09:54:12'),(6,'E-Commerce','e-commerce','portfolio','Platform perdagangan omnichannel dan integrasi ekosistem e-commerce.','shopping_bag','rose',6,'2026-08-03 09:54:12','2026-08-03 09:54:12'),(7,'Healthcare Tech','healthcare-tech','portfolio','Aplikasi kesehatan terpadu, rekam medis terenkripsi, dan telemedicine.','medical_services','teal',7,'2026-08-03 09:54:12','2026-08-03 09:54:12'),(8,'Cloud Solutions','cloud-solutions','portfolio','Migrasi infrastruktur cloud, DevOps automation, dan mikro-servis.','cloud','sky',8,'2026-08-03 09:54:12','2026-08-03 09:54:12'),(9,'Company Profile','company-profile','portfolio','Pengembangan website profil perusahaan interaktif, modern, dan profesional.','business','amber',9,'2026-08-09 05:07:57','2026-08-09 05:07:57'),(10,'Artificial Intelligence','artificial-intelligence','article','Eksplorasi kecerdasan buatan, Machine Learning, Generative AI, dan integrasi AI agents untuk transformasi bisnis.','smart_toy','purple',5,'2026-09-07 10:13:41','2026-09-07 10:13:41');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_inquiries`
--

DROP TABLE IF EXISTS `contact_inquiries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact_inquiries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Konsultasi / Penawaran Proyek',
  `budget_range` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Diskusi Harga',
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('new','read','replied','archived') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_inquiries_status_index` (`status`),
  KEY `contact_inquiries_created_at_index` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_inquiries`
--

LOCK TABLES `contact_inquiries` WRITE;
/*!40000 ALTER TABLE `contact_inquiries` DISABLE KEYS */;
INSERT INTO `contact_inquiries` VALUES (1,'PT Solusi Nusa Digital','halo@solusinusa.co.id','081298765432','Penawaran Project Web App Enterprise','Diskusi Harga','Halo tim RBTG Tech, kami berencana membangun platform perbankan digital berbasis mikroarsitektur Laravel dan Astro. Mohon kirimkan jadwal konsultasi dan proposal penawaran.','read','2026-08-03 10:31:36','2026-08-03 10:35:00'),(2,'Bpk. Hendra Wijaya','hendra@techcorp.id','082134567890','Konsultasi Cloud Architecture & Migration','Diskusi Harga','Saya tertarik dengan studi kasus Fintech RBTG Tech. Apakah tim Anda melayani migrasi infrastruktur AWS dan optimasi Redis caching?','read','2026-08-03 10:31:36','2026-08-03 10:31:36'),(3,'Ibu Maya Putri','maya@healthmed.co.id','087899887766','Pengembangan Telemedicine Portal','Diskusi Harga','Kami ingin berdiskusi mengenai pembuatan portal rekam medis terenkripsi berbasis Astro JS.','replied','2026-08-03 10:31:36','2026-08-03 10:31:36'),(4,'Budi Santoso','budi@gmail.com','081299887766','Pembuatan Web Compro','Kurang dari 5 Juta','Saya butuh web compro kilat budget kurang dari 5 juta.','read','2026-08-03 10:45:28','2026-08-03 10:46:57');
/*!40000 ALTER TABLE `contact_inquiries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leads`
--

DROP TABLE IF EXISTS `leads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `leads` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` decimal(3,2) DEFAULT NULL,
  `user_ratings_total` int NOT NULL DEFAULT '0',
  `address` text COLLATE utf8mb4_unicode_ci,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `maps_url` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leads`
--

LOCK TABLES `leads` WRITE;
/*!40000 ALTER TABLE `leads` DISABLE KEYS */;
INSERT INTO `leads` VALUES (1,'Klinik Gigi Semarang Mayjend Sutoyo - Sozo Dental','semarang',4.90,2330,'Jl. Mayjend Sutoyo No.93, Karangkidul, Kec. Semarang Tengah, Kota Semarang, Jawa Tengah 50136, Indonesia','+62 856-0201-3377',NULL,'https://www.sozodental.com/',NULL,'new',NULL,'2026-08-05 09:36:53','2026-08-05 09:36:53'),(2,'3KDC Klinik Gigi Semarang','semarang',5.00,1266,'Jl. Singosari Raya No.77A, Pleburan, Kec. Semarang Sel., Kota Semarang, Jawa Tengah 50241, Indonesia','+62 811-2607-706',NULL,'https://linktr.ee/3kdentalcare',NULL,'new',NULL,'2026-08-05 09:36:53','2026-08-05 09:36:53'),(3,'Klinik Gigi Semarang - FDC Semarang','semarang',4.90,1537,'Jl. Setia Budi No.119-A, Srondol Kulon, Kec. Banyumanik, Kota Semarang, Jawa Tengah 50269, Indonesia','+62 811-1927-6577',NULL,'https://fdcdentalclinic.co.id/lokasi/fdc-semarang',NULL,'new',NULL,'2026-08-05 09:36:53','2026-08-05 09:36:53'),(4,'Hai Gigi Premier | Spesialis Veneer dan Implan Gigi Semarang','semarang',5.00,412,'2CC5+MCX, Jl. Indraprasta No.11A, Pindrikan Lor, Kec. Semarang Tengah, Kota Semarang, Jawa Tengah 50131, Indonesia','+62 819-2741-9191',NULL,'https://haigigi.com/',NULL,'new',NULL,'2026-08-05 09:36:53','2026-08-05 09:36:53'),(5,'Klinik Gigi Praktek Dokter Gigi dan Dokter Gigi Spesialis Ortodonti','semarang',4.70,295,'3 e, Jl. Pleburan Barat, Pleburan, Kec. Semarang Sel., Kota Semarang, Jawa Tengah 50144, Indonesia','+62 878-3839-9469',NULL,NULL,NULL,'new',NULL,'2026-08-05 09:36:53','2026-08-05 09:36:53'),(6,'Hai Gigi Klinik','semarang',5.00,1384,'Jl. Cemara Raya No.9a, Padangsari, Banyumanik, Semarang City, Central Java 50267, Indonesia','+62 851-7514-9191',NULL,'https://haigigi.com/',NULL,'new',NULL,'2026-08-05 09:36:53','2026-08-05 09:36:53'),(7,'Drg Cecilia & Ririn SpOrt, Klinik Dokter Gigi Semarang Dentist Ortodonti','semarang',4.70,403,'Jl. Melati Utara No.16, Brumbungan, Semarang Tengah, Semarang City, Central Java 50135, Indonesia','+62 821-3733-7377',NULL,'https://linktr.ee/doktergigisemarang',NULL,'new',NULL,'2026-08-05 09:36:53','2026-08-05 09:36:53'),(8,'Klinik Gigi Joy Dental Setia Budi Semarang','semarang',5.00,446,'Jl. Setia Budi No.84F, Sumurboto, Banyumanik, Semarang City, Central Java 50269, Indonesia','+62 819-0357-9191',NULL,'https://klinikjoydental.com/klinik-dokter-gigi-semarang/',NULL,'new',NULL,'2026-08-05 09:36:53','2026-08-05 09:36:53'),(9,'Audy Dental Semarang | Klinik Dokter Gigi Spesialis','semarang',5.00,1876,'Sebelah PHD, Jl. Gajahmada, RT.007/RW.005, Miroto, Semarang Tengah, Semarang City, Central Java 50134, Indonesia','+62 24 86578341',NULL,'http://www.audydental.com/',NULL,'new',NULL,'2026-08-05 09:36:53','2026-08-05 09:36:53'),(10,'DENTFAM - Klinik Dokter Gigi Semarang | Drg Kristina & Drg Frans Praba ( spesialis gigi, bedah mulut, kawat gigi )','semarang',4.90,103,'Jl. Seroja I No.8, Karangkidul, Semarang Tengah, Semarang City, Central Java 50241, Indonesia','+62 812-2881-0080',NULL,'https://www.dentfam.com/',NULL,'new',NULL,'2026-08-05 09:36:53','2026-08-05 09:36:53'),(11,'Nana Dental Care Talangsari | Praktek Dokter Gigi','semarang',5.00,676,'Jl. Talangsari, Bendan Duwur, Kec. Gajahmungkur, Kota Semarang, Jawa Tengah 50235, Indonesia','+62 851-6818-5025',NULL,'https://nanadentalcare.com/',NULL,'new',NULL,'2026-08-05 09:36:53','2026-08-05 09:36:53'),(12,'GiO Dental Care & Clinic SEMARANG','semarang',5.00,1511,'Jl. Setia Budi No.55, Srondol Kulon, Kec. Banyumanik, Kota Semarang, Jawa Tengah 50263, Indonesia','+62 812-1155-8987',NULL,'https://www.giodentalcare.com/',NULL,'new',NULL,'2026-08-05 09:36:53','2026-08-05 09:36:53'),(13,'Klinik Gigi MGW Dental Care | Drg Michael, Drg Meliana, Drg Alvita (spesialis gigi, gusi-implan, konservasi, kawat gigi)','semarang',4.90,86,'Jalan Dokter Cipto No.202, Karangturi, Kec. Semarang Tim., Kota Semarang, Jawa Tengah 50124, Indonesia','+62 899-7779-191',NULL,'https://www.instagram.com/mgwdental/',NULL,'new',NULL,'2026-08-05 09:36:53','2026-08-05 09:36:53'),(14,'Prodenta Klinik Gigi Semarang','semarang',5.00,181,'Jl. Ngesrep Tim. V No.107A, Sumurboto, Banyumanik, Semarang City, Central Java 50269, Indonesia','+62 878-4318-4363',NULL,'https://www.prodentadental.com/',NULL,'new',NULL,'2026-08-05 09:36:53','2026-08-05 09:36:53'),(15,'Klinik Gigi Joy Dental Majapahit Semarang | Dokter Gigi Semarang','semarang',5.00,13,'Jl. Majapahit No.91D, Pandean Lamper, Gayamsari, Semarang City, Central Java 50249, Indonesia','+62 819-0757-9191',NULL,'https://klinikjoydental.com/klinik-dokter-gigi-semarang/',NULL,'new',NULL,'2026-08-05 09:36:53','2026-08-05 09:36:53'),(16,'MY DENTIST WONODRI','semarang',4.80,300,'Jl. Wonodri Sendang Raya No.15e, Wonodri, Kec. Semarang Sel., Kota Semarang, Jawa Tengah 50242, Indonesia','+62 821-2430-0700',NULL,'http://www.instagram.com/mydentist_semarang',NULL,'new',NULL,'2026-08-05 09:36:53','2026-08-05 09:36:53'),(17,'HS Dentist','semarang',5.00,1180,'Ruko Gaia Residence No.B-07, Kedungmundu, Kec. Tembalang, Kota Semarang, Jawa Tengah 50273, Indonesia','+62 811-2991-914',NULL,NULL,NULL,'contacted',NULL,'2026-08-05 09:36:53','2026-08-05 09:44:33'),(18,'Beaudent Semarang','semarang',4.60,620,'Jl. Kartini Raya No.10-13, Rejosari, Kec. Semarang Tim., Kota Semarang, Jawa Tengah 50124, Indonesia','+62 817-2356-161',NULL,'https://www.beaudent.id/',NULL,'new',NULL,'2026-08-05 09:36:53','2026-08-05 09:36:53'),(19,'Klinik Gigi Dokter Glo (drg. Gloria Fortuna, Sp.KG & teams)','semarang',5.00,297,'Jl. Dr. Wahidin No.111B, Kaliwiru, Candisari, Semarang City, Central Java 50253, Indonesia','+62 816-806-161',NULL,'https://www.instagram.com/dokter.glo/',NULL,'new',NULL,'2026-08-05 09:36:53','2026-08-05 09:36:53'),(20,'Happy Dental Clinic Queen City Semarang','semarang',4.90,247,'Queen City Semarang, Jl. Pemuda No.27-31 Lt. 2, Unit L2-23B, Pandansari, Kec. Semarang Tengah, Kota Semarang, Jawa Tengah 50139, Indonesia','+62 852-9324-5770',NULL,'https://happydentalclinic.com/',NULL,'new',NULL,'2026-08-05 09:36:53','2026-08-05 09:36:53');
/*!40000 ALTER TABLE `leads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_08_03_162738_create_personal_access_tokens_table',1),(5,'2026_08_03_170000_create_articles_table',2),(6,'2026_08_03_180000_create_portfolios_table',3),(7,'2026_08_03_190000_create_categories_table',4),(8,'2026_08_04_000000_create_page_views_table',5),(9,'2026_08_04_010000_create_contact_inquiries_table',6),(10,'2026_08_04_020000_add_visitor_id_to_page_views_table',7),(11,'2026_08_04_030000_add_budget_range_to_contact_inquiries_table',8),(12,'2026_08_05_100000_create_products_table',9),(15,'2026_08_05_155555_create_leads_table',10),(16,'2026_09_03_165932_change_image_url_to_text_in_portfolios_table',11);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `page_views`
--

DROP TABLE IF EXISTS `page_views`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `page_views` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visitor_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referrer` text COLLATE utf8mb4_unicode_ci,
  `device_type` enum('desktop','mobile','tablet') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'desktop',
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `viewed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `page_views_path_index` (`path`),
  KEY `page_views_viewed_at_index` (`viewed_at`),
  KEY `page_views_device_type_index` (`device_type`),
  KEY `page_views_visitor_id_index` (`visitor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page_views`
--

LOCK TABLES `page_views` WRITE;
/*!40000 ALTER TABLE `page_views` DISABLE KEYS */;
INSERT INTO `page_views` VALUES (1,'127.0.0.1','v_msdils39_pbv2tql','/contact','Hubungi Kami | rbtgtech - Mari Mulai Proyek Anda','http://localhost:4321/artikel/mengapa-astro-dan-laravel-kombinasi-sistem-enterprise-terbaik','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-03 10:43:14','2026-08-03 10:43:14','2026-08-03 10:43:14'),(2,'127.0.0.1','v_msdils39_pbv2tql','/portfolio','Portofolio | rbtgtech - Inovasi Digital Tanpa Batas','http://localhost:4321/contact','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-03 10:48:23','2026-08-03 10:48:23','2026-08-03 10:48:23'),(3,'127.0.0.1','v_msdils39_pbv2tql','/about','Tentang Kami | rbtgtech — Mitra Teknologi Terpercaya','http://localhost:4321/portfolio','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-03 10:48:26','2026-08-03 10:48:26','2026-08-03 10:48:26'),(4,'127.0.0.1','v_msdils39_pbv2tql','/','rbtgtech — Your Perfect Solutions','Direct Traffic','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 08:32:45','2026-08-05 08:32:45','2026-08-05 08:32:45'),(5,'127.0.0.1','v_msdils39_pbv2tql','/contact','Hubungi Kami | rbtgtech - Mari Mulai Proyek Anda','http://localhost:4321/','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 08:33:32','2026-08-05 08:33:32','2026-08-05 08:33:32'),(6,'127.0.0.1','v_msdils39_pbv2tql','/portfolio','Portofolio | rbtgtech - Inovasi Digital Tanpa Batas','http://localhost:4321/contact','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 08:34:57','2026-08-05 08:34:57','2026-08-05 08:34:57'),(7,'127.0.0.1','v_msdils39_pbv2tql','/about','Tentang Kami | rbtgtech — Mitra Teknologi Terpercaya','http://localhost:4321/portfolio','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 08:35:01','2026-08-05 08:35:01','2026-08-05 08:35:01'),(8,'127.0.0.1','v_msdils39_pbv2tql','/artikel','Artikel & Wawasan Teknologi | rbtgtech','http://localhost:4321/about','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 08:35:09','2026-08-05 08:35:09','2026-08-05 08:35:09'),(9,'127.0.0.1','v_msdils39_pbv2tql','/artikel/mengapa-astro-dan-laravel-kombinasi-sistem-enterprise-terbaik','Mengapa Astro & Laravel Adalah Kombinasi Sistem Enterprise Terbaik di 2026 | rbtgtech Blog','http://localhost:4321/artikel','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 08:35:11','2026-08-05 08:35:11','2026-08-05 08:35:11'),(10,'127.0.0.1','v_msdils39_pbv2tql','/artikel/panduan-praktis-strategi-seo-technical-aplikasi-web-modern','Panduan Praktis Strategi SEO Technical untuk Aplikasi Web Modern | rbtgtech Blog','http://localhost:4321/artikel','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 08:37:06','2026-08-05 08:37:06','2026-08-05 08:37:06'),(11,'127.0.0.1','v_msdils39_pbv2tql','/contact','Hubungi Kami | rbtgtech - Mari Mulai Proyek Anda','http://localhost:4321/artikel/panduan-praktis-strategi-seo-technical-aplikasi-web-modern','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 08:40:00','2026-08-05 08:40:00','2026-08-05 08:40:00'),(12,'127.0.0.1','v_msdils39_pbv2tql','/portfolio','Portofolio | rbtgtech - Inovasi Digital Tanpa Batas','http://localhost:4321/contact','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 08:40:16','2026-08-05 08:40:16','2026-08-05 08:40:16'),(13,'127.0.0.1','v_msdils39_pbv2tql','/','rbtgtech — Your Perfect Solutions','http://localhost:4321/portfolio','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 08:40:19','2026-08-05 08:40:19','2026-08-05 08:40:19'),(14,'127.0.0.1','v_msdils39_pbv2tql','/about','Tentang Kami | rbtgtech — Mitra Teknologi Terpercaya','http://localhost:4321/','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 08:40:36','2026-08-05 08:40:36','2026-08-05 08:40:36'),(15,'127.0.0.1','v_msdils39_pbv2tql','/portfolio/fintech-core-platform-enterprise-dashboard','Fintech Core Platform & Enterprise Dashboard — Studi Kasus Portofolio | rbtgtech','http://localhost:4321/portfolio','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 08:41:10','2026-08-05 08:41:10','2026-08-05 08:41:10'),(16,'127.0.0.1','v_msdils39_pbv2tql','/portfolio','Portofolio | rbtgtech - Inovasi Digital Tanpa Batas','http://localhost:4321/about','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 08:45:23','2026-08-05 08:45:23','2026-08-05 08:45:23'),(17,'127.0.0.1','v_msdils39_pbv2tql','/produk','Produk & Solusi Digital Siap Pakai | rbtgtech','http://localhost:4321/portfolio','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 08:46:48','2026-08-05 08:46:48','2026-08-05 08:46:48'),(18,'127.0.0.1','v_msdils39_pbv2tql','/produk/esb-resto-pos-cloud-solution','ESB Resto & POS Cloud Solution | Produk rbtgtech','http://localhost:4321/produk','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 08:46:57','2026-08-05 08:46:57','2026-08-05 08:46:57'),(19,'127.0.0.1','v_msdils39_pbv2tql','/produk/sim-sekolah-smart-edu-platform','SIM Sekolah & Smart Edu Platform | Produk rbtgtech','http://localhost:4321/produk','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 08:48:58','2026-08-05 08:48:58','2026-08-05 08:48:58'),(20,'127.0.0.1','v_msdils39_pbv2tql','/produk/sim-sekolah-smart-edu-platform','SIM Sekolah & Smart Edu Platform | Produk rbtgtech','http://localhost:4321/produk','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 09:28:00','2026-08-05 09:28:00','2026-08-05 09:28:00'),(21,'127.0.0.1','v_msdils39_pbv2tql','/portfolio','Portofolio | rbtgtech - Inovasi Digital Tanpa Batas','http://localhost:4321/produk/sim-sekolah-smart-edu-platform','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 10:17:19','2026-08-05 10:17:19','2026-08-05 10:17:19'),(22,'127.0.0.1','v_msdils39_pbv2tql','/artikel','Artikel & Wawasan Teknologi | rbtgtech','http://localhost:4321/portfolio','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 10:17:20','2026-08-05 10:17:20','2026-08-05 10:17:20'),(23,'127.0.0.1','v_msdils39_pbv2tql','/contact','Hubungi Kami | rbtgtech - Mari Mulai Proyek Anda','http://localhost:4321/artikel','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-05 10:17:21','2026-08-05 10:17:21','2026-08-05 10:17:21'),(24,'127.0.0.1','v_msdils39_pbv2tql','/','rbtgtech — Your Perfect Solutions','Direct Traffic','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-09 04:36:20','2026-08-09 04:36:20','2026-08-09 04:36:20'),(25,'127.0.0.1','v_msdils39_pbv2tql','/produk','Produk & Solusi Digital Siap Pakai | rbtgtech','http://localhost:4321/','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-09 04:37:01','2026-08-09 04:37:01','2026-08-09 04:37:01'),(26,'127.0.0.1','v_msdils39_pbv2tql','/portfolio','Portofolio | rbtgtech - Inovasi Digital Tanpa Batas','http://localhost:4321/produk','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-09 04:37:27','2026-08-09 04:37:27','2026-08-09 04:37:27'),(27,'127.0.0.1','v_msdils39_pbv2tql','/about','Tentang Kami | rbtgtech — Mitra Teknologi Terpercaya','http://localhost:4321/portfolio','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-09 04:37:36','2026-08-09 04:37:36','2026-08-09 04:37:36'),(28,'127.0.0.1','v_msdils39_pbv2tql','/artikel','Artikel & Wawasan Teknologi | rbtgtech','http://localhost:4321/about','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-09 04:37:41','2026-08-09 04:37:41','2026-08-09 04:37:41'),(29,'127.0.0.1','v_msdils39_pbv2tql','/artikel/desain-sistem-skalabel-membangun-web-enterprise-tahan-beban-tinggi','Desain Sistem Skalabel: Membangun Web Enterprise Tahan Beban Tinggi | rbtgtech Blog','http://localhost:4321/artikel','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-09 04:37:45','2026-08-09 04:37:45','2026-08-09 04:37:45'),(30,'127.0.0.1','v_msdils39_pbv2tql','/contact','Hubungi Kami | rbtgtech - Mari Mulai Proyek Anda','http://localhost:4321/artikel/desain-sistem-skalabel-membangun-web-enterprise-tahan-beban-tinggi','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-09 04:37:46','2026-08-09 04:37:46','2026-08-09 04:37:46'),(31,'127.0.0.1','v_msdils39_pbv2tql','/portfolio','Portofolio | rbtgtech - Inovasi Digital Tanpa Batas','http://localhost:4321/contact','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-09 04:57:42','2026-08-09 04:57:42','2026-08-09 04:57:42'),(32,'127.0.0.1','v_msdils39_pbv2tql','/portfolio/fintech-core-platform-enterprise-dashboard','Fintech Core Platform & Enterprise Dashboard — Studi Kasus Portofolio | rbtgtech','http://localhost:4321/portfolio','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-09 04:57:53','2026-08-09 04:57:53','2026-08-09 04:57:53'),(33,'127.0.0.1','v_msdils39_pbv2tql','/about','Tentang Kami | rbtgtech — Mitra Teknologi Terpercaya','http://localhost:4321/portfolio','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-09 04:58:45','2026-08-09 04:58:45','2026-08-09 04:58:45'),(34,'127.0.0.1','v_msdils39_pbv2tql','/artikel','Artikel & Wawasan Teknologi | rbtgtech','http://localhost:4321/about','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-09 04:58:48','2026-08-09 04:58:48','2026-08-09 04:58:48'),(35,'127.0.0.1','v_msdils39_pbv2tql','/contact','Hubungi Kami | rbtgtech - Mari Mulai Proyek Anda','http://localhost:4321/artikel','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-09 04:58:51','2026-08-09 04:58:51','2026-08-09 04:58:51'),(36,'127.0.0.1','v_msdils39_pbv2tql','/produk','Produk & Solusi Digital Siap Pakai | rbtgtech','http://localhost:4321/portfolio','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-09 04:58:55','2026-08-09 04:58:55','2026-08-09 04:58:55'),(37,'127.0.0.1','v_msdils39_pbv2tql','/artikel','Artikel & Wawasan Teknologi | rbtgtech','http://localhost:4321/portfolio','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-09 05:04:05','2026-08-09 05:04:05','2026-08-09 05:04:05'),(38,'127.0.0.1','v_msdils39_pbv2tql','/about','Tentang Kami | rbtgtech — Mitra Teknologi Terpercaya','http://localhost:4321/artikel','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-09 05:04:08','2026-08-09 05:04:08','2026-08-09 05:04:08'),(39,'127.0.0.1','v_msdils39_pbv2tql','/portfolio','Portofolio | rbtgtech - Inovasi Digital Tanpa Batas','http://localhost:4321/about','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-09 05:04:10','2026-08-09 05:04:10','2026-08-09 05:04:10'),(40,'127.0.0.1','v_msdils39_pbv2tql','/portfolio','Portofolio | rbtgtech - Inovasi Digital Tanpa Batas','http://localhost:4321/portfolio','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-09 05:09:58','2026-08-09 05:09:58','2026-08-09 05:09:58'),(41,'127.0.0.1','v_msdils39_pbv2tql','/produk','Produk & Solusi Digital Siap Pakai | rbtgtech','http://localhost:4321/portfolio','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-09 05:10:12','2026-08-09 05:10:12','2026-08-09 05:10:12'),(42,'127.0.0.1','v_msdils39_pbv2tql','/produk','Produk & Solusi Digital Siap Pakai | rbtgtech','http://localhost:4321/produk','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-08-09 06:10:27','2026-08-09 06:10:27','2026-08-09 06:10:27'),(43,'127.0.0.1','v_msdils39_pbv2tql','/','rbtgtech — Your Perfect Solutions','Direct Traffic','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-03 09:28:56','2026-09-03 09:28:56','2026-09-03 09:28:56'),(44,'127.0.0.1','v_msdils39_pbv2tql','/produk','Produk & Solusi Digital Siap Pakai | rbtgtech','http://localhost:4321/','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-03 09:29:21','2026-09-03 09:29:21','2026-09-03 09:29:21'),(45,'127.0.0.1','v_msdils39_pbv2tql','/portfolio','Portofolio | rbtgtech - Inovasi Digital Tanpa Batas','http://localhost:4321/produk','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-03 09:29:22','2026-09-03 09:29:22','2026-09-03 09:29:22'),(46,'127.0.0.1','v_msdils39_pbv2tql','/produk/esb-resto-pos-cloud-solution','ESB Resto & POS Cloud Solution | Produk rbtgtech','http://localhost:4321/produk','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-03 09:29:39','2026-09-03 09:29:39','2026-09-03 09:29:39'),(47,'127.0.0.1','v_msdils39_pbv2tql','/produk/sim-sekolah-smart-edu-platform','SIM Sekolah & Smart Edu Platform | Produk rbtgtech','http://localhost:4321/produk','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-03 09:30:06','2026-09-03 09:30:06','2026-09-03 09:30:06'),(48,'127.0.0.1','v_msdils39_pbv2tql','/portfolio','Portofolio | rbtgtech - Inovasi Digital Tanpa Batas','http://localhost:4321/produk','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-03 09:35:14','2026-09-03 09:35:14','2026-09-03 09:35:14'),(49,'127.0.0.1','v_msdils39_pbv2tql','/contact','Hubungi Kami | rbtgtech - Mari Mulai Proyek Anda','http://localhost:4321/portfolio','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-03 09:38:25','2026-09-03 09:38:25','2026-09-03 09:38:25'),(50,'127.0.0.1','v_msdils39_pbv2tql','/about','Tentang Kami | rbtgtech — Mitra Teknologi Terpercaya','http://localhost:4321/portfolio','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-03 09:38:30','2026-09-03 09:38:30','2026-09-03 09:38:30'),(51,'127.0.0.1','v_msdils39_pbv2tql','/produk','Produk & Solusi Digital Siap Pakai | rbtgtech','http://localhost:4321/portfolio','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-03 09:40:06','2026-09-03 09:40:06','2026-09-03 09:40:06'),(52,'127.0.0.1','v_msdils39_pbv2tql','/portfolio','Portofolio | rbtgtech - Inovasi Digital Tanpa Batas','http://localhost:4321/produk','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-03 09:40:18','2026-09-03 09:40:18','2026-09-03 09:40:18'),(53,'127.0.0.1','v_msdils39_pbv2tql','/artikel','Artikel & Wawasan Teknologi | rbtgtech','http://localhost:4321/about','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-03 09:40:20','2026-09-03 09:40:20','2026-09-03 09:40:20'),(54,'127.0.0.1','v_msdils39_pbv2tql','/artikel/mengapa-astro-dan-laravel-kombinasi-sistem-enterprise-terbaik','Mengapa Astro & Laravel Adalah Kombinasi Sistem Enterprise Terbaik di 2026 | rbtgtech Blog','http://localhost:4321/artikel','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-03 09:40:24','2026-09-03 09:40:24','2026-09-03 09:40:24'),(55,'127.0.0.1','v_msdils39_pbv2tql','/','rbtgtech — Your Perfect Solutions','http://localhost:4321/portfolio','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-03 09:42:14','2026-09-03 09:42:14','2026-09-03 09:42:14'),(56,'127.0.0.1','v_msdils39_pbv2tql','/portfolio','Portofolio | rbtgtech - Inovasi Digital Tanpa Batas','http://localhost:4321/produk','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-03 09:45:46','2026-09-03 09:45:46','2026-09-03 09:45:46'),(57,'127.0.0.1','v_msdils39_pbv2tql','/portfolio/taxgbc-guna-bersama-consulting','TaxGBC Guna Bersama Consulting — Studi Kasus Portofolio | rbtgtech','http://localhost:4321/portfolio','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-03 09:45:53','2026-09-03 09:45:53','2026-09-03 09:45:53'),(58,'127.0.0.1','v_msdils39_pbv2tql','/portfolio','Portofolio | rbtgtech - Inovasi Digital Tanpa Batas','http://localhost:4321/produk','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-03 10:04:22','2026-09-03 10:04:22','2026-09-03 10:04:22'),(59,'127.0.0.1','v_msdils39_pbv2tql','/portfolio/taxgbc-guna-bersama-consulting','TaxGBC Guna Bersama Consulting — Studi Kasus Portofolio | rbtgtech','http://localhost:4321/portfolio','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-03 10:04:28','2026-09-03 10:04:28','2026-09-03 10:04:28'),(60,'127.0.0.1','v_msdils39_pbv2tql','/portfolio','Portofolio | rbtgtech - Inovasi Digital Tanpa Batas','http://localhost:4321/portfolio','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-03 10:15:04','2026-09-03 10:15:04','2026-09-03 10:15:04'),(61,'127.0.0.1','v_msdils39_pbv2tql','/portfolio/taxgbc-guna-bersama-consulting','TaxGBC Guna Bersama Consulting — Studi Kasus Portofolio | rbtgtech','http://localhost:4321/portfolio','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-03 10:15:08','2026-09-03 10:15:08','2026-09-03 10:15:08'),(62,'127.0.0.1','v_msdils39_pbv2tql','/about','Tentang Kami | rbtgtech — Mitra Teknologi Terpercaya','http://localhost:4321/portfolio','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-03 10:16:11','2026-09-03 10:16:11','2026-09-03 10:16:11'),(63,'127.0.0.1','v_msdils39_pbv2tql','/artikel','Artikel & Wawasan Teknologi | rbtgtech','http://localhost:4321/about','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-03 10:16:12','2026-09-03 10:16:12','2026-09-03 10:16:12'),(64,'127.0.0.1','v_msdils39_pbv2tql','/produk','Produk & Solusi Digital Siap Pakai | rbtgtech','http://localhost:4321/artikel','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-03 10:26:31','2026-09-03 10:26:31','2026-09-03 10:26:31'),(65,'127.0.0.1','v_msdils39_pbv2tql','/produk/omnichannel-all-in-one','Omnichannel All in One | Produk rbtgtech','http://localhost:4321/produk','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-03 10:27:22','2026-09-03 10:27:22','2026-09-03 10:27:22'),(66,'127.0.0.1','v_msdils39_pbv2tql','/produk/esb-resto-pos-cloud-solution','ESB Resto & POS Cloud Solution | Produk rbtgtech','http://localhost:4321/produk','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-03 10:27:24','2026-09-03 10:27:24','2026-09-03 10:27:24'),(67,'127.0.0.1','v_msdils39_pbv2tql','/','rbtgtech — Your Perfect Solutions','http://localhost:4321/produk','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-03 10:27:33','2026-09-03 10:27:33','2026-09-03 10:27:33'),(68,'127.0.0.1','v_msdils39_pbv2tql','/','rbtgtech — Your Perfect Solutions','Direct Traffic','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 10:11:04','2026-09-07 10:11:04','2026-09-07 10:11:04'),(69,'127.0.0.1','v_msdils39_pbv2tql','/produk','Produk & Solusi Digital Siap Pakai | rbtgtech','http://localhost:4321/','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 10:11:14','2026-09-07 10:11:14','2026-09-07 10:11:14'),(70,'127.0.0.1','v_msdils39_pbv2tql','/portfolio','Portofolio | rbtgtech - Inovasi Digital Tanpa Batas','http://localhost:4321/','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 10:11:20','2026-09-07 10:11:20','2026-09-07 10:11:20'),(71,'127.0.0.1','v_msdils39_pbv2tql','/about','Tentang Kami | rbtgtech — Mitra Teknologi Terpercaya','http://localhost:4321/portfolio','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 10:11:26','2026-09-07 10:11:26','2026-09-07 10:11:26'),(72,'127.0.0.1','v_msdils39_pbv2tql','/artikel','Artikel & Wawasan Teknologi | rbtgtech','http://localhost:4321/about','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 10:11:31','2026-09-07 10:11:31','2026-09-07 10:11:31'),(73,'127.0.0.1','v_msdils39_pbv2tql','/contact','Hubungi Kami | rbtgtech - Mari Mulai Proyek Anda','http://localhost:4321/artikel','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 10:11:33','2026-09-07 10:11:33','2026-09-07 10:11:33'),(74,'127.0.0.1','v_msdils39_pbv2tql','/portfolio/taxgbc-guna-bersama-consulting','TaxGBC Guna Bersama Consulting — Studi Kasus Portofolio | rbtgtech','http://localhost:4321/portfolio','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 10:12:36','2026-09-07 10:12:36','2026-09-07 10:12:36'),(75,'127.0.0.1','v_msdils39_pbv2tql','/portfolio/healthcare-management-telemedicine-portal','Healthcare Management & Telemedicine Portal — Studi Kasus Portofolio | rbtgtech','http://localhost:4321/portfolio','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 10:12:48','2026-09-07 10:12:48','2026-09-07 10:12:48'),(76,'127.0.0.1','v_msdils39_pbv2tql','/artikel/revolusi-generative-ai-autonomous-agent-bisnis-modern-2026','Revolusi Generative AI & Autonomous Agent: Bagaimana Bisnis Modern Memanfaatkan AI di 2026 | rbtgtech Blog','http://localhost:4321/artikel','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 10:15:01','2026-09-07 10:15:01','2026-09-07 10:15:01'),(77,'127.0.0.1','v_msdils39_pbv2tql','/artikel/panduan-praktis-integrasi-llm-rag-arsitektur-web-modern','Panduan Praktis Integrasi LLM & RAG pada Arsitektur Web Modern | rbtgtech Blog','http://localhost:4321/artikel','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 10:15:13','2026-09-07 10:15:13','2026-09-07 10:15:13'),(78,'127.0.0.1','v_msdils39_pbv2tql','/artikel/keamanan-data-dan-privasi-implementasi-enterprise-ai','Keamanan Data & Privasi dalam Implementasi Enterprise AI | rbtgtech Blog','http://localhost:4321/artikel','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 10:16:08','2026-09-07 10:16:08','2026-09-07 10:16:08'),(79,'127.0.0.1','v_msdils39_pbv2tql','/artikel','Artikel & Wawasan Teknologi | rbtgtech','http://localhost:4321/portfolio','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 10:20:09','2026-09-07 10:20:09','2026-09-07 10:20:09'),(80,'127.0.0.1','v_msdils39_pbv2tql','/portfolio','Portofolio | rbtgtech - Inovasi Digital Tanpa Batas','http://localhost:4321/artikel','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 10:20:18','2026-09-07 10:20:18','2026-09-07 10:20:18'),(81,'127.0.0.1','v_msdils39_pbv2tql','/','rbtgtech — Your Perfect Solutions','http://localhost:4321/portfolio','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 10:20:50','2026-09-07 10:20:50','2026-09-07 10:20:50'),(82,'127.0.0.1','v_msdils39_pbv2tql','/portfolio/fintech-core-platform-enterprise-dashboard','Fintech Core Platform & Enterprise Dashboard — Studi Kasus Portofolio | rbtgtech','http://localhost:4321/','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 10:21:08','2026-09-07 10:21:08','2026-09-07 10:21:08'),(83,'127.0.0.1','v_msdils39_pbv2tql','/portfolio/taxgbc-guna-bersama-consulting','TaxGBC Guna Bersama Consulting — Studi Kasus Portofolio | rbtgtech','http://localhost:4321/','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 10:21:15','2026-09-07 10:21:15','2026-09-07 10:21:15'),(84,'127.0.0.1','v_msdils39_pbv2tql','/portfolio/interior-dc-kudus','interior DC Kudus — Studi Kasus Portofolio | rbtgtech','http://localhost:4321/','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 10:21:22','2026-09-07 10:21:22','2026-09-07 10:21:22'),(85,'127.0.0.1','v_msdils39_pbv2tql','/produk','Produk & Solusi Digital Siap Pakai | rbtgtech','http://localhost:4321/','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 10:21:48','2026-09-07 10:21:48','2026-09-07 10:21:48'),(86,'127.0.0.1','v_msdils39_pbv2tql','/about','Tentang Kami | rbtgtech — Mitra Teknologi Terpercaya','http://localhost:4321/portfolio','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 10:22:03','2026-09-07 10:22:03','2026-09-07 10:22:03'),(87,'127.0.0.1','v_msdils39_pbv2tql','/contact','Hubungi Kami | rbtgtech - Mari Mulai Proyek Anda','http://localhost:4321/artikel','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 10:22:06','2026-09-07 10:22:06','2026-09-07 10:22:06'),(88,'127.0.0.1','v_msdils39_pbv2tql','/artikel/desain-sistem-skalabel-membangun-web-enterprise-tahan-beban-tinggi','Desain Sistem Skalabel: Membangun Web Enterprise Tahan Beban Tinggi | rbtgtech Blog','http://localhost:4321/artikel','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 10:23:17','2026-09-07 10:23:17','2026-09-07 10:23:17'),(89,'127.0.0.1','v_msdils39_pbv2tql','/artikel/panduan-praktis-strategi-seo-technical-aplikasi-web-modern','Panduan Praktis Strategi SEO Technical untuk Aplikasi Web Modern | rbtgtech Blog','http://localhost:4321/artikel','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 10:23:20','2026-09-07 10:23:20','2026-09-07 10:23:20'),(90,'127.0.0.1','v_msdils39_pbv2tql','/artikel/panduan-praktis-integrasi-llm-rag-arsitektur-web-modern','Panduan Praktis Integrasi LLM & RAG pada Arsitektur Web Modern | rbtgtech Blog','http://localhost:4321/artikel','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 10:23:25','2026-09-07 10:23:25','2026-09-07 10:23:25'),(91,'127.0.0.1','v_msdils39_pbv2tql','/artikel/keamanan-data-dan-privasi-implementasi-enterprise-ai','Keamanan Data & Privasi dalam Implementasi Enterprise AI | rbtgtech Blog','http://localhost:4321/artikel','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 10:23:49','2026-09-07 10:23:49','2026-09-07 10:23:49'),(92,'127.0.0.1','v_msdils39_pbv2tql','/produk/esb-resto-pos-cloud-solution','ESB Resto & POS Cloud Solution | Produk rbtgtech','http://localhost:4321/produk','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 10:25:12','2026-09-07 10:25:12','2026-09-07 10:25:12'),(93,'127.0.0.1','v_msdils39_pbv2tql','/produk/sim-sekolah-smart-edu-platform','SIM Sekolah & Smart Edu Platform | Produk rbtgtech','http://localhost:4321/produk','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 10:25:27','2026-09-07 10:25:27','2026-09-07 10:25:27'),(94,'127.0.0.1','v_msdils39_pbv2tql','/artikel','Artikel & Wawasan Teknologi | rbtgtech','http://localhost:4321/about','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 10:25:49','2026-09-07 10:25:49','2026-09-07 10:25:49'),(95,'127.0.0.1','v_msdils39_pbv2tql','/portfolio','Portofolio | rbtgtech - Inovasi Digital Tanpa Batas','http://localhost:4321/artikel/desain-sistem-skalabel-membangun-web-enterprise-tahan-beban-tinggi','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 10:25:56','2026-09-07 10:25:56','2026-09-07 10:25:56'),(96,'127.0.0.1','v_msdils39_pbv2tql','/produk','Produk & Solusi Digital Siap Pakai | rbtgtech','http://localhost:4321/portfolio','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 10:27:30','2026-09-07 10:27:30','2026-09-07 10:27:30'),(97,'127.0.0.1','v_msdils39_pbv2tql','/produk/omnichannel-all-in-one','Omnichannel All in One | Produk rbtgtech','http://localhost:4321/produk','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 10:27:34','2026-09-07 10:27:34','2026-09-07 10:27:34'),(98,'127.0.0.1','v_msdils39_pbv2tql','/','rbtgtech — Your Perfect Solutions','http://localhost:4321/produk','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 10:29:02','2026-09-07 10:29:02','2026-09-07 10:29:02'),(99,'127.0.0.1','v_msdils39_pbv2tql','/about','Tentang Kami | rbtgtech — Mitra Teknologi Terpercaya','http://localhost:4321/portfolio','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 10:29:07','2026-09-07 10:29:07','2026-09-07 10:29:07'),(100,'127.0.0.1','v_msdils39_pbv2tql','/contact','Hubungi Kami | rbtgtech - Mari Mulai Proyek Anda','http://localhost:4321/artikel','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 10:29:09','2026-09-07 10:29:09','2026-09-07 10:29:09'),(101,'127.0.0.1','v_msdils39_pbv2tql','/portfolio','Portofolio | rbtgtech - Inovasi Digital Tanpa Batas','http://localhost:4321/portfolio','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 10:31:56','2026-09-07 10:31:56','2026-09-07 10:31:56'),(102,'127.0.0.1','v_msdils39_pbv2tql','/produk','Produk & Solusi Digital Siap Pakai | rbtgtech','http://localhost:4321/portfolio','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 10:32:41','2026-09-07 10:32:41','2026-09-07 10:32:41'),(103,'127.0.0.1','v_msdils39_pbv2tql','/produk/omnichannel-all-in-one','Omnichannel All in One AI | Produk rbtgtech','http://localhost:4321/produk','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 10:36:11','2026-09-07 10:36:11','2026-09-07 10:36:11'),(104,'127.0.0.1','v_msdils39_pbv2tql','/produk','Produk & Solusi Digital Siap Pakai | rbtgtech','http://localhost:4321/portfolio','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 10:40:29','2026-09-07 10:40:29','2026-09-07 10:40:29'),(105,'127.0.0.1','v_msdils39_pbv2tql','/produk/rbtglabs','RBTGLabs Overlay Streaming | Produk rbtgtech','http://localhost:4321/produk','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 10:44:19','2026-09-07 10:44:19','2026-09-07 10:44:19'),(106,'127.0.0.1','v_msdils39_pbv2tql','/','rbtgtech — Your Perfect Solutions','http://localhost:4321/produk/rbtglabs','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 10:46:08','2026-09-07 10:46:08','2026-09-07 10:46:08'),(107,'127.0.0.1','v_msdils39_pbv2tql','/','rbtgtech — Your Perfect Solutions','http://localhost:4321/produk/rbtglabs','desktop','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 10:55:45','2026-09-07 10:55:45','2026-09-07 10:55:45');
/*!40000 ALTER TABLE `page_views` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `portfolios`
--

DROP TABLE IF EXISTS `portfolios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `portfolios` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Enterprise System',
  `client` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2026',
  `summary` text COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `challenge` text COLLATE utf8mb4_unicode_ci,
  `solution` text COLLATE utf8mb4_unicode_ci,
  `results` json DEFAULT NULL,
  `image_url` text COLLATE utf8mb4_unicode_ci,
  `gallery` json DEFAULT NULL,
  `tech_stack` json DEFAULT NULL,
  `live_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('published','draft') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `focus_keyword` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `canonical_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_score` int NOT NULL DEFAULT '85',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `portfolios_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `portfolios`
--

LOCK TABLES `portfolios` WRITE;
/*!40000 ALTER TABLE `portfolios` DISABLE KEYS */;
INSERT INTO `portfolios` VALUES (1,'Fintech Core Platform & Enterprise Dashboard','fintech-core-platform-enterprise-dashboard','Enterprise System','PT Bank Nusa Digital','2026','Platform perbankan digital terpadu yang memproses jutaan transaksi harian dengan latensi rendah dan kepatuhan regulasi finansial.','Sistem perbankan inti generasi baru yang dirancang untuk kecepatan transaksi dan analisis keuangan real-time.','Client membutuhkan migrasi dari sistem legacy yang lambat ke platform mikroarsitektur terdistribusi tanpa menyebabkan downtime operasional perbankan.','Kami merancang API gateway berbasis Laravel microservices yang terhubung ke frontend dashboard berkinerja tinggi, dilengkapi sistem caching Redis dan queue worker.','[\"Peningkatan kecepatan transaksi hingga 300%\", \"Uptime sistem mencapai 99.99%\", \"Kapasitas beban pengguna aktif meningkat 5x lipat\"]','https://lh3.googleusercontent.com/aida-public/AB6AXuC8PG6LZ_xog1u35WvCdLZrEQtuYI6YiFXwTsQb8q1Ae3nS6-FH3uxPXgOXfyHbz-IA_WP4_oS-0RCQR6nkokm_6KUqnw2RFckoP2SOsCwQzipAaciCKXiUWXuWiLaAWTpHIR38ItopTBFvvJoWDa4hfccYtHsUyYiv6NdBfkGC37sGg6VSWABqzrt11f6Yp3-EIzX2nclxfvnuZ_FAT9ZePy0xZcKpCY__cF_Mw7iSMKED_2_vGxLD',NULL,'[\"Laravel\", \"Astro\", \"Tailwind CSS\", \"Redis\", \"PostgreSQL\"]',NULL,'published','Fintech Enterprise Dashboard','Fintech Core Platform & Enterprise Dashboard - Case Study','http://localhost:4321/portfolio/fintech-core-platform-enterprise-dashboard',90,'2026-08-03 09:50:34','2026-09-03 09:59:56'),(2,'E-Commerce Ecosystem & Omnichannel Integration','e-commerce-ecosystem-omnichannel-integration','E-Commerce','Global Brand Fashion Group','2025','Ekosistem perdagangan omnichannel yang mengintegrasikan persediaan fisik dan toko online secara real-time.','Solusi platform perdagangan terpadu yang mempermudah pengelolaan inventori multi-gudang dan otomatisasi pesanan.','Menghubungkan ratusan titik POS toko fisik dengan platform toko online berkecepatan tinggi.','Integrasi API RESTful berbasis Laravel dengan arsitektur headless frontend yang dipersonalisasi untuk pembeli.','[\"Sinkronisasi stok real-time dalam hitungan milidetik\", \"Peningkatan tingkat konversi penjualan hingga 45%\"]','https://lh3.googleusercontent.com/aida-public/AB6AXuCI7se4EiBr0Vq4e3-TKVz9kP7p7Eg___fIcMp7oGuXVBnlPdYiYRkp0RfAgaGEunrHU-wTt3h23qKjKFozmoQSGbgLkcD4mzn8cLuc2DbNLvuwd2VpeP_pIHrzx50OIrOtY6cMeOJ6ETTPhZ6cWLJbHIep-Vd5H9QsivTG2WVTTomOBy6NGENMt5gsxqCu5W2RpIG2JAXgAsPeX27Bi-AuYcceLxOv7PyR67HnClI6p1bv22zz2mJq',NULL,'[\"Laravel API\", \"Astro JS\", \"Tailwind\", \"MySQL\"]',NULL,'published','E-Commerce Omnichannel Integration','E-Commerce Ecosystem Omnichannel Integration - RBTGTech','http://localhost:4321/portfolio/e-commerce-ecosystem-omnichannel-integration',88,'2026-08-03 09:50:34','2026-09-03 09:59:56'),(3,'Healthcare Management & Telemedicine Portal','healthcare-management-telemedicine-portal','Healthcare Tech','Medica Health Systems','2025','Portal rekam medis terenkripsi dan layanan konsultasi dokter online real-time.','Aplikasi kesehatan terpadu untuk pasien, tenaga medis, dan manajemen rumah sakit.','Menjamin keamanan data medis pasien (HIPAA compliant) dengan antarmuka yang sangat responsif.','Implementasi enkripsi end-to-end pada Laravel API backend dengan frontend intuitif berbasis Astro.','[\"Dipercayai oleh lebih dari 50.000 pasien aktif bulanan\", \"Waktu tunggu konsultasi berkurang hingga 60%\"]','https://lh3.googleusercontent.com/aida-public/AB6AXuArSHOEP40tyxvWKnpf2qqn1wSCVOeHUBt0_kILKzSfIa0xBUTzulRwaMskXmzMgqidLGca13XX8ZqaiiFRYaaQkUMyI1CYhDb-GxeD9LV8_5wuIeoAubhWYCIM6X9gj4K2ZI_xDggovtqkMyhbeSOxK2Cp7HHgYgeF4JJ0eP9LjbOqMNs0ZkESFpn8xBygqVwq7ITAyGBkv7pj8Ogq0J4mrVaOL1DaQoQlfSoYLvO1uK_ilmwPh7sc',NULL,'[\"Laravel\", \"Astro\", \"WebSockets\", \"Tailwind CSS\"]',NULL,'published','Healthcare Telemedicine Portal','Healthcare Management & Telemedicine Portal - RBTGTech','http://localhost:4321/portfolio/healthcare-management-telemedicine-portal',85,'2026-08-03 09:50:34','2026-09-03 09:59:56'),(4,'Company Profile: TaxGBC Guna Bersama Consulting','taxgbc-guna-bersama-consulting','Company Profile','Guna Bersama Consulting','2025','Platform profil korporat interaktif dan sistem konsultasi perpajakan bisnis dengan kalkulator simulasi pajak real-time.','Solusi website perusahaan konsultan pajak terkemuka untuk meningkatkan kredibilitas merek dan akuisisi klien korporasi.','Membangun kehadiran digital yang kredibel, elegan, dengan kepatuhan informasi finansial yang akurat.','Arsitektur headless modern menggunakan Laravel backend dan Astro Jamstack frontend berkecepatan tinggi.','[\"Skor Core Web Vitals 99/100\", \"Pertumbuhan konsultasi masuk naik 80% dalam 2 bulan\"]','/storage/portfolios/1788455059_taxgbc-solusi-pajak-bisnis-anda-09-04-2026-12-03-am.png',NULL,'[\"Wordrpess\", \"Elementor\", \"YoastSEO\"]','https://taxgbc.com/','published','TaxGBC Guna Bersama Consulting','Company Profile: TaxGBC Guna Bersama Consulting','',85,'2026-09-03 09:45:43','2026-09-07 10:32:26'),(7,'Company Profile : DC Interior Kudus','interior-dc-kudus','Company Profile','DC Interior','2026','','','','','[]','/storage/portfolios/1788455702_interior-dc-kemewahan-di-setiap-sudut-beranda-09-04-2026-12-06-am-1.webp',NULL,'[]','https://interiordc.com/','published','','Company Profile : DC Interior Kudus','',50,'2026-09-03 10:15:02','2026-09-07 10:35:49'),(8,'Company Profile : RGS Rumput Sintetis','company-profile-rgs-rumput-sintetis','Company Profile','RGS Rumput Sintetis','2025','','','','','[]','/storage/portfolios/1788802272_rgs-semarang-rumput-sintetis-interior-custom-furniture-09-08-2026-12-19-am-1.webp',NULL,'[]','https://rgsrumputsintetis.com/','published','rumput sintetis','Company Profile : RGS Rumput Sintetis','',85,'2026-09-07 10:31:12','2026-09-07 10:35:02');
/*!40000 ALTER TABLE `portfolios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'SaaS & Ready System',
  `tagline` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `summary` text COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `features` json DEFAULT NULL,
  `tech_stack` json DEFAULT NULL,
  `demo_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gallery` json DEFAULT NULL,
  `price_label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Konsultasi / Sewa',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'ESB Resto & POS Cloud Solution','esb-resto-pos-cloud-solution','F&B & Resto System','Sistem Kasir, Dapur, Multi-outlet & Laporan Resto Real-time','Solusi manajemen bisnis restoran, kafe, dan franchise terintegrasi dengan modul Kasir POS, Kitchen Display System (KDS), stok otomatis, dan QR Menu meja.','ESB Resto & POS Cloud Solution dirancang khusus untuk meningkatkan efisiensi operasional restoran dari skala tunggal hingga jaringan franchise multi-cabang. Terintegrasi langsung dengan payment gateway (QRIS, E-Wallet, Kartu) dan pelaporan keuangan real-time.','[\"Kasir POS Responsive (Web & Tablet)\", \"Kitchen Display System (KDS) Real-time Synchronized\", \"Manajemen Stok Bahan Baku & HPP Otomatis\", \"Digital QR Order Meja (Self Service Order)\", \"Laporan Penjualan & Profitability Multi-outlet\", \"Integrasi Payment Gateway QRIS & E-Wallet\"]','[\"Laravel\", \"Astro\", \"Tailwind CSS\", \"PostgreSQL\", \"WebSockets\"]','https://demo-resto.rbtgtech.com','/logo-rbtgtech.png',NULL,'Mulai Rp 2.500.000 / Lisensi','published',1,'2026-08-05 08:45:02','2026-08-05 08:45:02'),(2,'SIM Sekolah & Smart Edu Platform','sim-sekolah-smart-edu-platform','Sistem Pendidikan','Platform Manajemen Akademik, SPP Online & Presensi Siswa','Sistem Informasi Manajemen Sekolah terpadu untuk SD, SMP, SMA, dan SMK. Dilengkapi portal guru, murid, orang tua, e-learning, serta rekap absensi.','SIM Sekolah & Smart Edu Platform menyatukan seluruh tata kelola sekolah dalam satu portal terpusat. Memudahkan absensi digital, ujian berbasis komputer (CBT), rekapitulasi nilai rapor kurikulum merdeka, serta pembayar SPP otomatis melalui WhatsApp notification.','[\"Portal Akademik & Rapor Kurikulum Merdeka\", \"Pembayaran SPP & Keuangan dengan WA Gateway Notification\", \"Absensi Digital Guru & Siswa (RFID / QR / Biometrik)\", \"Ujian Online CBT (Computer Based Test)\", \"Perpustakaan Digital & E-Learning Portal\", \"Portal Orang Tua & Notifikasi Real-time\"]','[\"Laravel\", \"Vue.js\", \"MySQL\", \"Tailwind CSS\"]','https://demo-sekolah.rbtgtech.com','/logo-rbtgtech.png',NULL,'Paket Lisensi / Langganan Sekolah','published',2,'2026-08-05 08:45:02','2026-08-05 08:45:02'),(3,'Omnichannel All in One AI','omnichannel-all-in-one','SaaS & AI Communication','Pusat Komunikasi Multi-Channel Terpadu dengan Autonomous AI CS 24/7 & Multi-Agent Cloud','Satukan seluruh chat WhatsApp, Instagram DM, Telegram, dan Marketplace dalam satu inbox web terpusat. Ditenagai AI Customer Service cerdas 24/7 dan multi-agent cloud—seluruh tim bisa membalas bersamaan tanpa lagi rebutan atau menunggu HP fisik admin.','Omnichannel All-in-One AI Platform hadir menyelesaikan kendala terbesar operasional customer service bisnis modern: ketergantungan fatal pada satu smartphone fisik dan lambatnya respon saat jam istirahat atau hari libur. Sistem ini mengonsolidasikan seluruh saluran interaksi pelanggan (WhatsApp Official API, Instagram Direct, Telegram, Facebook Messenger, hingga chat marketplace) ke dalam satu dashboard berbasis cloud. Ditenagai kecerdasan buatan (Autonomous AI Customer Service) yang dilatih menggunakan data produk, SOP, dan FAQ bisnis Anda, sistem mampu membalas pesan pelanggan seketika dengan gaya bahasa natural dan ramah selama 24 jam non-stop. Ketika transaksi membutuhkan asistensi khusus, sistem secara cerdas mendistribusikan percakapan ke multi-agent (seluruh tim CS dapat login bersamaan dari laptop/tablet manapun dengan 1 nomor WhatsApp yang sama), menghilangkan alasan klasik \"HP dibawa admin keluar\" selamanya.','[\"Autonomous AI Customer Service 24/7 (Balas Chat Cerdas & Instan Tanpa Kenal Libur)\", \"Single Centralized Cloud Inbox (WhatsApp, Instagram, Telegram, TikTok & Web Chat)\", \"Multi-Agent & Multi-Device (Banyak Staf CS Bisa Login Bersamaan dari Laptop/Tablet)\", \"Bebas Ketergantungan HP Fisik (Sistem Berjalan di Cloud 100%, Chat Tetap Masuk & Terbalas)\", \"Smart Human Handover & Ticket Routing (Eskalasi Mulus dari AI ke Agen Manusia)\", \"Integrasi Katalog Produk, Pengecekan Stok & Generate Invoice Otomatis\", \"Broadcast & Segmentasi Pelanggan Terjadwal dengan Perlindungan Anti-Banned\", \"Live Performance Dashboard (Pantau Metrik Kecepatan Respon & Sentimen Pelanggan)\"]','[\"Laravel API\", \"Astro JS\", \"OpenAI & Gemini AI Engine\", \"WebSockets\", \"PostgreSQL\", \"Redis\"]','https://demo-omnichannel.rbtgtech.com','/images/products/omnichannel-ai.jpg',NULL,'Early Access / Private Beta','coming_soon',3,'2026-09-03 10:27:16','2026-09-07 10:31:40'),(4,'RBTGLabs Overlay Streaming','rbtglabs','Broadcasting & Creator Tech','Suite Dynamic Web Overlay 60 FPS, Alert Donasi Interaktif & Widget Creator Multi-Platform','Ubah siaran live streaming Anda menjadi tayangan sekelas broadcast profesional dan esports. Ekosistem widget overlay berbasis browser source ultra-ringan (OBS & vMix) dengan integrasi otomatis donasi lokal (Saweria, Trakteer, Sociabuzz), live chat agregator, dynamic subathon goal bar, dan panel kontrol cloud real-time tanpa membebani performa CPU gaming Anda.','RBTGLabs Interactive Streaming Overlay dirancang khusus untuk memenuhi kebutuhan content creator, gaming streamer, podcaster, hingga event organizer turnamen esports yang ingin menghadirkan visual siaran interaktif berstandar profesional. Banyak streamer menghadapi kendala overlay animasi berbasis video file yang memakan beban CPU tinggi sehingga menyebabkan frame drop saat bermain game berat. RBTGLabs menyelesaikan masalah tersebut dengan arsitektur Browser Source (HTML5 Canvas & WebSockets) yang super ringan dengan penggunaan resource CPU kurang dari 1% pada rendering 60 FPS yang sangat mulus. Sistem ini mengintegrasikan seluruh event interaksi penonton secara real-time: notifikasi donasi Saweria, Trakteer, Sociabuzz lengkap dengan custom sound bite & TTS, live chat multi-platform yang bersih dari spam, leaderboard donatur, dan gamifikasi interaktif yang dapat diatur on-the-fly dari Cloud Control Panel.','[\"OBS & vMix Ultra-Lightweight Browser Source (Beban CPU < 1% & Zero Frame Drop)\", \"Multi-Platform Donation Alert Engine (Saweria, Trakteer, Sociabuzz & Midtrans)\", \"Custom 3D & Lottie Notification Animation (60 FPS Smooth Render with Sound Bite)\", \"Unified Live Chat Box (Agregator Multi-Channel YouTube, Twitch & TikTok)\", \"Dynamic Goal Bar (Donation Tracker, Follower Target & Subathon Countdown Timer)\", \"Cloud Control Dashboard (Ubah Warna, Tema & Teks On-The-Fly Tanpa Restart OBS)\", \"Esports Scoreboard & Match Bracket Overlay Modul\", \"Audience Gamification Widget (Giveaway Wheel, Live Poll & Emote Rain)\"]','[\"HTML5 Canvas & WebGL\", \"WebSockets Engine\", \"Node.js & Python\", \"Tailwind CSS & Lottie\", \"Laravel Cloud API\", \"OBS Browser Source SDK\"]','https://labs.rbtgtech.com/overlay-demo','/images/products/rbtglabs-overlay.jpg',NULL,'Mulai Rp 450.000 / Setup','published',4,'2026-09-07 10:27:22','2026-09-07 10:45:31');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('t8PSHavSadjUhDDi1C4PkiJICJWndUYwgUlP3Nwi',NULL,'127.0.0.1','curl/7.84.0','eyJfdG9rZW4iOiJ0bmF6OU1sS1pyWHJ0WTg2bVVFSHZ0bUxReHVMQldLaE9LSHk2dmZLIiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2FkbWluXC9wcm9kdWN0cyJ9LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2FkbWluXC9wcm9kdWN0cyIsInJvdXRlIjoiYWRtaW4ucHJvZHVjdHMuaW5kZXgifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1788802606),('zLMp4cA50fwEZYTzlihJ39reUbuZJ4Y3fsHgJOmh',2,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJOREtjV2luYUdVeWJrd0wxN0p2MlhmSnpab0E1YlUwZXVTdjZLa2laIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pblwvcHJvZHVjdHNcL2RhdGEiLCJyb3V0ZSI6ImFkbWluLnByb2R1Y3RzLmRhdGEifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJ1cmwiOltdLCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6Mn0=',1788803386);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','admin@gmail.com',NULL,'$2y$12$IcW6y3NE50OnVGvPmcxaZuK9XcQ3xSD93q6s4BHxoEVYZHpTYVLli',NULL,'2026-08-03 09:36:14','2026-09-03 09:27:20'),(2,'Admin','admin@rbtgtech.com',NULL,'$2y$12$IcW6y3NE50OnVGvPmcxaZuK9XcQ3xSD93q6s4BHxoEVYZHpTYVLli',NULL,'2026-08-03 09:37:52','2026-09-03 09:27:20');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-08 14:17:05
