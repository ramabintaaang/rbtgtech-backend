# 🤖 Panduan API Artikel untuk AI Agent (rbtgtech)

Dokumentasi ini dibuat khusus agar **AI Agent** (atau skrip otomatisasi eksternal) dapat mempublikasikan, memperbarui, atau menghapus artikel ke website rbtgtech melalui HTTP REST API.

---

## 🔑 Autentikasi API Key

Endpoint pembuatan dan pengelolaan artikel diamankan menggunakan **API Key**.  
Sertakan salah satu header berikut pada setiap request:

- **Header X-API-KEY**:
  ```http
  X-API-KEY: rbtgtech_agent_secret_2026
  ```
- *Atau* **Header Bearer Token**:
  ```http
  Authorization: Bearer rbtgtech_agent_secret_2026
  ```

*(Catatan: Kunci API ini dapat Anda ubah kapan saja melalui file `.env` pada variabel `ARTICLE_API_KEY`)*.

---

## 📌 1. Endpoint Membuat Artikel Baru (POST)

- **URL (Lokal)**: `http://127.0.0.1:8000/api/articles`
- **URL (Produksi)**: `https://admin.rbtgtech.com/api/articles`
- **Method**: `POST`
- **Headers**:
  - `Content-Type: application/json`
  - `X-API-KEY: rbtgtech_agent_secret_2026`

### 📥 Request Body (JSON)

| Field | Tipe | Wajib? | Deskripsi & Nilai Default |
| :--- | :--- | :--- | :--- |
| `title` | String | **Wajib** | Judul artikel (Contoh: *"Tren Artificial Intelligence 2026"*) |
| `content` | String (HTML/Text) | **Wajib** | Isi artikel lengkap (Dukung tag HTML seperti `<p>`, `<h2>`, `<ul>`, `<code>`) |
| `slug` | String | *Opsional* | URL slug artikel. Jika dikosongkan, **otomatis digenerate** dari judul (misal: `tren-artificial-intelligence-2026`). Jika bentrok, otomatis ditambahkan `-2`, `-3`. |
| `summary` | String | *Opsional* | Ringkasan/Meta Description. Jika kosong, otomatis mengambil 180 karakter pertama dari `content`. |
| `category` | String | *Opsional* | Kategori artikel. Default: `"Artificial Intelligence"`. Pilihan lain: `"Teknologi"`, `"Web Development"`, `"SEO & Digital"`. |
| `tags` | Array / String | *Opsional* | Tag artikel, contoh: `["AI", "LLM", "NextGen"]` atau string `"AI, LLM, NextGen"`. |
| `image_url` | String | *Opsional* | URL gambar cover artikel. Default: `"/images/articles/article-ai-agent.jpg"`. |
| `read_time` | String | *Opsional* | Estimasi waktu baca. Jika kosong, **otomatis dihitung** berdasarkan jumlah kata (kecepatan rata-rata 200 kata/menit). |
| `author_name` | String | *Opsional* | Nama penulis. Default: `"Rama Bintang"`. |
| `author_role` | String | *Opsional* | Jabatan penulis. Default: `"Founder & Lead Software Architect"`. |
| `author_avatar` | String | *Opsional* | Avatar penulis. Default: `"/images/rama-builder.jpg"`. |
| `status` | String | *Opsional* | Status: `"published"` (langsung tayang) atau `"draft"`. Default: `"published"`. |
| `published_at` | String | *Opsional* | Tanggal rilis format `YYYY-MM-DD`. Default: waktu saat ini (`now()`). |
| `focus_keyword`| String | *Opsional* | Kata kunci utama untuk optimasi SEO. |
| `meta_title` | String | *Opsional* | Judul meta tag Google. Default sama dengan `title`. |
| `canonical_url`| String | *Opsional* | URL kanonikal artikel. Default: `https://rbtgtech.com/artikel/{slug}`. |
| `seo_score` | Integer | *Opsional* | Nilai skor SEO (0 - 100). Default: `90`. |

---

### 💻 Contoh Request Payload (JSON Minimal)

```json
{
  "title": "Revolusi Autonomous AI Agent di Era Bisnis Modern 2026",
  "content": "<p>Tahun 2026 menandai pergeseran besar dari sekadar chatbot statis menuju AI Agent yang mandiri...</p><h2>Mengapa Bisnis Membutuhkan Agentic Workflow?</h2><p>Agen AI modern mampu mengeksekusi multi-langkah dan berkomunikasi langsung melalui API...</p>",
  "category": "Artificial Intelligence",
  "tags": ["AI Agent", "Machine Learning", "Otomasi"]
}
```

---

### 📤 Contoh Response Sukses (HTTP 201 Created)

```json
{
  "status": "success",
  "message": "Artikel berhasil dibuat dan dipublikasikan!",
  "data": {
    "id": 15,
    "title": "Revolusi Autonomous AI Agent di Era Bisnis Modern 2026",
    "slug": "revolusi-autonomous-ai-agent-di-era-bisnis-modern-2026",
    "summary": "Tahun 2026 menandai pergeseran besar dari sekadar chatbot statis menuju AI Agent yang mandiri...",
    "category": "Artificial Intelligence",
    "author": {
      "name": "Rama Bintang",
      "avatar": "/images/rama-builder.jpg",
      "role": "Founder & Lead Software Architect"
    },
    "published_at": "2026-09-20",
    "read_time": "3 menit",
    "image_url": "/images/articles/article-ai-agent.jpg",
    "tags": ["AI Agent", "Machine Learning", "Otomasi"]
  },
  "urls": {
    "public_article_url": "https://rbtgtech.com/artikel/revolusi-autonomous-ai-agent-di-era-bisnis-modern-2026",
    "admin_edit_url": "https://admin.rbtgtech.com/admin/articles/15/edit"
  }
}
```

---

## 🧪 Contoh Pemanggilan Kode untuk AI Agent

### 1. cURL (Bash / Terminal / CLI)
```bash
curl -X POST https://admin.rbtgtech.com/api/articles \
  -H "Content-Type: application/json" \
  -H "X-API-KEY: rbtgtech_agent_secret_2026" \
  -d '{
    "title": "Judul Artikel dari AI Agent",
    "content": "<p>Paragraf isi artikel yang dihasilkan AI...</p>",
    "category": "Artificial Intelligence",
    "tags": ["AI", "Tech"]
  }'
```

### 2. Python (Requests / OpenAI Agent Tool)
```python
import requests

url = "https://admin.rbtgtech.com/api/articles"
headers = {
    "Content-Type": "application/json",
    "X-API-KEY": "rbtgtech_agent_secret_2026"
}
payload = {
    "title": "Masa Depan Web Engineering dengan Headless Architecture",
    "content": "<p>Headless architecture memisahkan frontend responsif dan backend REST API...</p>",
    "category": "Web Development",
    "tags": ["Astro", "Laravel", "Headless"]
}

response = requests.post(url, json=payload, headers=headers)
print(response.status_code)
print(response.json())
```

### 3. JavaScript / TypeScript (Fetch / Node.js)
```typescript
const res = await fetch("https://admin.rbtgtech.com/api/articles", {
  method: "POST",
  headers: {
    "Content-Type": "application/json",
    "X-API-KEY": "rbtgtech_agent_secret_2026"
  },
  body: JSON.stringify({
    title: "Mengapa Bisnis Membutuhkan Sistem Enterprise Terdistribusi",
    content: "<p>Ketersediaan sistem tinggi (high availability) adalah kunci skala bisnis...</p>",
    category: "Teknologi",
    tags: ["Enterprise", "Cloud", "Architecture"]
  })
});

const data = await res.json();
console.log(data);
```

---

## 🔄 Endpoint Tambahan

- **Lihat Semua Artikel**: `GET /api/articles` (Publik)
- **Lihat Detail Artikel**: `GET /api/articles/{slug}` (Publik)
- **Update Artikel**: `PUT /api/articles/{id_atau_slug}` (Membutuhkan API Key)
- **Hapus Artikel**: `DELETE /api/articles/{id_atau_slug}` (Membutuhkan API Key)
