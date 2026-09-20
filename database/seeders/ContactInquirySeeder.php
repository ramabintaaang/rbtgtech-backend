<?php

namespace Database\Seeders;

use App\Models\ContactInquiry;
use Illuminate\Database\Seeder;

class ContactInquirySeeder extends Seeder
{
    public function run(): void
    {
        // Truncate previous sample data first
        ContactInquiry::truncate();

        $inquiries = [
            [
                'name' => 'PT Solusi Nusa Digital',
                'email' => 'halo@solusinusa.co.id',
                'phone' => '081298765432', // Visitor's phone number
                'subject' => 'Penawaran Project Web App Enterprise',
                'message' => 'Halo tim RBTG Tech, kami berencana membangun platform perbankan digital berbasis mikroarsitektur Laravel dan Astro. Mohon kirimkan jadwal konsultasi dan proposal penawaran.',
                'status' => 'new',
            ],
            [
                'name' => 'Bpk. Hendra Wijaya',
                'email' => 'hendra@techcorp.id',
                'phone' => '082134567890', // Visitor's phone number
                'subject' => 'Konsultasi Cloud Architecture & Migration',
                'message' => 'Saya tertarik dengan studi kasus Fintech RBTG Tech. Apakah tim Anda melayani migrasi infrastruktur AWS dan optimasi Redis caching?',
                'status' => 'read',
            ],
            [
                'name' => 'Ibu Maya Putri',
                'email' => 'maya@healthmed.co.id',
                'phone' => '087899887766', // Visitor's phone number
                'subject' => 'Pengembangan Telemedicine Portal',
                'message' => 'Kami ingin berdiskusi mengenai pembuatan portal rekam medis terenkripsi berbasis Astro JS.',
                'status' => 'replied',
            ],
        ];

        foreach ($inquiries as $data) {
            ContactInquiry::create($data);
        }
    }
}
