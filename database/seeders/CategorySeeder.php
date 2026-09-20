<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // Article Categories
            [
                'name' => 'Teknologi',
                'slug' => 'teknologi',
                'type' => 'article',
                'description' => 'Artikel seputar perkembangan teknologi web stack modern, Astro JS, dan Laravel framework.',
                'icon' => 'devices',
                'color' => 'primary',
                'sort_order' => 1,
            ],
            [
                'name' => 'SEO & Digital',
                'slug' => 'seo-digital',
                'type' => 'article',
                'description' => 'Strategi optimasi mesin pencari (SEO), Core Web Vitals, dan visibilitas digital.',
                'icon' => 'search',
                'color' => 'emerald',
                'sort_order' => 2,
            ],
            [
                'name' => 'Arsitektur Sistem',
                'slug' => 'arsitektur-sistem',
                'type' => 'article',
                'description' => 'Prinsip perancangan sistem enterprise, mikroarsitektur, dan desain skalabilitas tinggi.',
                'icon' => 'account_tree',
                'color' => 'indigo',
                'sort_order' => 3,
            ],
            [
                'name' => 'Berita Perusahaan',
                'slug' => 'berita-perusahaan',
                'type' => 'article',
                'description' => 'Kabar terbaru, pencapaian tim, dan pengumuman resmi RBTG Tech.',
                'icon' => 'campaign',
                'color' => 'amber',
                'sort_order' => 4,
            ],
            [
                'name' => 'Artificial Intelligence',
                'slug' => 'artificial-intelligence',
                'type' => 'article',
                'description' => 'Eksplorasi kecerdasan buatan, Machine Learning, Generative AI, dan integrasi AI agents untuk transformasi bisnis.',
                'icon' => 'smart_toy',
                'color' => 'purple',
                'sort_order' => 5,
            ],

            // Portfolio Categories
            [
                'name' => 'Enterprise System',
                'slug' => 'enterprise-system',
                'type' => 'portfolio',
                'description' => 'Studi kasus pengembangan sistem inti perusahaan skala besar dan perbankan.',
                'icon' => 'domain',
                'color' => 'primary',
                'sort_order' => 5,
            ],
            [
                'name' => 'E-Commerce',
                'slug' => 'e-commerce',
                'type' => 'portfolio',
                'description' => 'Platform perdagangan omnichannel dan integrasi ekosistem e-commerce.',
                'icon' => 'shopping_bag',
                'color' => 'rose',
                'sort_order' => 6,
            ],
            [
                'name' => 'Healthcare Tech',
                'slug' => 'healthcare-tech',
                'type' => 'portfolio',
                'description' => 'Aplikasi kesehatan terpadu, rekam medis terenkripsi, dan telemedicine.',
                'icon' => 'medical_services',
                'color' => 'teal',
                'sort_order' => 7,
            ],
            [
                'name' => 'Cloud Solutions',
                'slug' => 'cloud-solutions',
                'type' => 'portfolio',
                'description' => 'Migrasi infrastruktur cloud, DevOps automation, dan mikro-servis.',
                'icon' => 'cloud',
                'color' => 'sky',
                'sort_order' => 8,
            ],
            [
                'name' => 'Company Profile',
                'slug' => 'company-profile',
                'type' => 'portfolio',
                'description' => 'Pengembangan website profil perusahaan interaktif, modern, dan profesional.',
                'icon' => 'business',
                'color' => 'amber',
                'sort_order' => 9,
            ],
        ];

        foreach ($categories as $catData) {
            Category::updateOrCreate(
                ['slug' => $catData['slug']],
                $catData
            );
        }
    }
}
