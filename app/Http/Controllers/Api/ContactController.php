<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactInquiry;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Process incoming contact form submission from Astro frontend.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'nullable|string|max:255',
            'budget_range' => 'nullable|string|max:100',
            'message' => 'required|string',
        ]);

        $inquiry = ContactInquiry::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => ($validated['subject'] ?? null) ?: 'Konsultasi / Penawaran Proyek',
            'budget_range' => ($validated['budget_range'] ?? null) ?: 'Diskusi Harga',
            'message' => $validated['message'],
            'status' => 'new',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Pesan Anda telah berhasil terkirim ke tim RBTG Tech! Kami akan segera menghubungi Anda.',
            'data' => [
                'id' => $inquiry->id,
                'created_at' => $inquiry->created_at->format('d M Y H:i'),
            ]
        ], 201);
    }
}
