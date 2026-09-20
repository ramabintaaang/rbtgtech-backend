# 📋 Catatan Deployment & Lanjutan Project RBTG Tech ke cPanel

Dokumen ini berisi rangkuman progress yang telah diselesaikan hari ini dan panduan langkah demi langkah untuk melanjutkan deployment besok.

---

## ✅ Progress yang Selesai Hari Ini

1. **Fitur Upload Gambar Featured Image di Admin Products:**
   - Fitur upload file gambar (`image_file`) dan input manual URL dengan instant preview 16:9 sudah aktif di `http://127.0.0.1:8000/admin/products`.
   - Validasi file (JPG, PNG, WEBP, SVG maks 5MB) dan pembersihan gambar lama di controller `ProductAdminController.php`.

2. **Produk Baru Lengkap dengan Konten & Visual:**
   - **RBTGLabs Overlay Streaming** (Slug: `rbtglabs`) — *Broadcasting & Creator Tech (Dynamic Web Overlay 60 FPS, Alert Donasi Saweria/Trakteer/Sociabuzz, Chat Agregator, OBS/vMix lightweight)*.
   - **Omnichannel All in One AI** (Slug: `omnichannel-all-in-one`) — *SaaS & AI Communication (Autonomous AI CS 24/7, Multi-Agent Cloud, Single Centralized Inbox)*.
   - Gambar produk sudah di-generate dan tersimpan di database & static assets.

3. **Konfigurasi Produksi Astro Frontend:**
   - Dibuatkan file `.env.production` dengan target API: `PUBLIC_LARAVEL_API_URL=https://admin.rbtgtech.com`.
   - Test build lokal `npm run build` sukses meng-generate 23 halaman statis ke folder `dist/`.

4. **Upload Awal Backend Laravel ke cPanel:**
   - File Laravel sudah di-upload ke subdomain `admin.rbtgtech.com`.

---

## 🚀 Checklist Lanjutan Besok (Step-by-Step)

### 1. Set PHP 8.3 Khusus Subdomain `admin.rbtgtech.com` (Aman untuk WP Lain)
> **Catatan:** MultiPHP Manager bersifat per-domain, domain WordPress Anda yang lain **TIDAK AKAN** terpengaruh!
1. Buka **cPanel** &rarr; masuk menu **MultiPHP Manager**.
2. Centang **hanya** baris `admin.rbtgtech.com` (biarkan domain WP tidak dicentang).
3. Pilih versi **PHP 8.3** di pojok kanan atas, lalu klik **Apply**.

---

### 2. Pastikan Document Root Subdomain Mengarah ke Folder `/public`
Agar tidak muncul tampilan *Index of /* dan file inti aman:
1. Buka **cPanel** &rarr; menu **Domains** (atau **Subdomains**).
2. Klik **Manage** di sebelah `admin.rbtgtech.com`.
3. Pastikan **Document Root** berakhiran `/public` (contoh: `admin.rbtgtech.com/public` atau `laravel/public`).
4. Klik **Update**.

---

### 3. Setup Database MySQL di cPanel
1. Buka **cPanel** &rarr; menu **MySQL® Databases**:
   - Buat Database baru (contoh: `user_rbtgdb`).
   - Buat User baru (contoh: `user_rbtguser`) dan catat passwordnya.
   - Masukkan user ke database dengan centang **ALL PRIVILEGES**.
2. Buka menu **phpMyAdmin**:
   - Pilih database tadi &rarr; klik tab **Import** &rarr; unggah file backup SQL dari lokal.
3. Edit file **`.env`** di folder Laravel cPanel:
   ```env
   APP_NAME="RBTG Tech"
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://admin.rbtgtech.com

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=user_rbtgdb
   DB_USERNAME=user_rbtguser
   DB_PASSWORD=password_db_anda
   ```

---

### 4. Buat Symlink Storage (Untuk Upload Gambar Produk & Artikel)
- **Jika ada Terminal di cPanel:**
  ```bash
  php artisan storage:link
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  ```
- **Jika tidak ada Terminal:**
  Buat file `symlink.php` di dalam folder `public` milik Laravel:
  ```php
  <?php
  symlink('/home/USER_CPANEL/admin.rbtgtech.com/storage/app/public', '/home/USER_CPANEL/admin.rbtgtech.com/public/storage');
  echo "Symlink Berhasil!";
  ```
  Akses sekali via browser: `https://admin.rbtgtech.com/symlink.php`, lalu hapus filenya.

---

### 5. Upload Website Astro ke `public_html` (Domain Utama `rbtgtech.com`)
1. Di komputer lokal:
   ```bash
   cd /Users/Rama/rbtgtech-astro
   npm run build
   ```
2. Buka folder `rbtgtech-astro/dist/`.
3. Zip seluruh isi folder `dist/` tersebut.
4. Di cPanel **File Manager**, buka folder **`public_html/`** (milik domain `rbtgtech.com`).
5. Upload dan **Extract** file zip tadi tepat di dalam `public_html/`.

---

## 🎯 Target Akhir:
- Website Pengunjung: **`https://rbtgtech.com`**
- Login Admin Panel: **`https://admin.rbtgtech.com/admin`**
