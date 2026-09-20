<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Lead;
use Illuminate\Support\Facades\Http;

class LeadAdminController extends Controller
{
    /**
     * Render the admin dashboard for leads.
     */
    public function index()
    {
        return view('admin.leads.index');
    }

    /**
     * Return JSON representation of leads with filters.
     */
    public function data(Request $request)
    {
        $query = Lead::query();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // City filter
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Website availability filter
        if ($request->filled('website_filter')) {
            $filter = $request->website_filter;
            if ($filter === 'no_website') {
                $query->where(function ($q) {
                    $q->whereNull('website')
                      ->orWhere('website', '')
                      ->orWhere('website', 'like', '%instagram.com%')
                      ->orWhere('website', 'like', '%facebook.com%')
                      ->orWhere('website', 'like', '%linktr.ee%')
                      ->orWhere('website', 'like', '%tiktok.com%')
                      ->orWhere('website', 'like', '%g.page%')
                      ->orWhere('website', 'like', '%g.co%')
                      ->orWhere('website', 'like', '%google.com%');
                });
            } elseif ($filter === 'has_website') {
                $query->whereNotNull('website')
                      ->where('website', '!=', '')
                      ->where('website', 'not like', '%instagram.com%')
                      ->where('website', 'not like', '%facebook.com%')
                      ->where('website', 'not like', '%linktr.ee%')
                      ->where('website', 'not like', '%tiktok.com%')
                      ->where('website', 'not like', '%g.page%')
                      ->where('website', 'not like', '%g.co%')
                      ->where('website', 'not like', '%google.com%');
            }
        }

        $leads = $query->orderBy('created_at', 'desc')->get();

        // Append custom attributes to JSON output
        $leads->each->makeVisible(['wa_phone_number', 'has_website']);
        $leads->each->append(['wa_phone_number', 'has_website']);

        // Fetch distinct cities present in the database to build filter options
        $cities = Lead::select('city')
            ->distinct()
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->orderBy('city', 'asc')
            ->pluck('city');

        return response()->json([
            'status' => 'success',
            'data' => $leads,
            'cities' => $cities
        ]);
    }

    /**
     * Trigger Google Maps scraping using SerpApi (with offline mock fallback).
     */
    public function scrape(Request $request)
    {
        $keyword = $request->input('keyword');
        $city = $request->input('city');
        
        if (!$keyword || !$city) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kata kunci pencarian dan Kota wajib diisi.'
            ], 422);
        }

        $apiKey = env('SERP_API_KEY');

        // Fallback to mock search if no API key is configured or set to mock
        if (!$apiKey || $apiKey === 'mock') {
            return $this->scrapeMock($keyword, $city);
        }

        try {
            // Combine keyword and city for Google Maps search
            $searchQuery = "{$keyword} {$city}";

            $response = Http::get('https://serpapi.com/search.json', [
                'engine' => 'google_maps',
                'q' => $searchQuery,
                'api_key' => $apiKey
            ]);

            if ($response->failed()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal memanggil SerpApi: ' . $response->body()
                ], 500);
            }

            $data = $response->json();
            $places = $data['local_results'] ?? [];

            if (empty($places)) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Tidak ditemukan hasil pencarian dari Google Maps.',
                    'imported_count' => 0
                ]);
            }

            $imported = 0;
            $skipped = 0;

            foreach ($places as $place) {
                // Check if lead already exists based on name and address or phone
                $exists = Lead::where('name', $place['title'] ?? '')
                    ->where(function ($q) use ($place) {
                        $q->where('address', $place['address'] ?? '---')
                          ->orWhere('phone', $place['phone'] ?? '---');
                    })
                    ->exists();

                if ($exists) {
                    $skipped++;
                    continue;
                }

                Lead::create([
                    'name' => $place['title'] ?? '',
                    'city' => $city,
                    'rating' => $place['rating'] ?? null,
                    'user_ratings_total' => $place['reviews'] ?? 0,
                    'address' => $place['address'] ?? null,
                    'phone' => $place['phone'] ?? null,
                    'website' => $place['website'] ?? null,
                    'maps_url' => $place['link'] ?? null,
                    'status' => 'new',
                ]);
                $imported++;
            }

            return response()->json([
                'status' => 'success',
                'message' => "Berhasil mengimpor {$imported} prospek baru di {$city}. (Lewati {$skipped} karena sudah ada)",
                'imported_count' => $imported
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memproses data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);
        $lead->update($request->only(['notes', 'status', 'phone', 'email', 'website']));

        return response()->json([
            'status' => 'success',
            'data' => $lead
        ]);
    }

    /**
     * Update only the lead's CRM status.
     */
    public function updateStatus(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);
        $lead->update([
            'status' => $request->status
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $lead
        ]);
    }

    /**
     * Delete a lead.
     */
    public function destroy($id)
    {
        $lead = Lead::findOrFail($id);
        $lead->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }

    /**
     * Helper to mock scraping results for local development and testing.
     */
    private function scrapeMock($keyword, $city)
    {
        $city = trim($city) ?: 'Bandung';

        $mockPlaces = [
            [
                'title' => "Mimiti Coffee & Space $city",
                'rating' => 4.6,
                'reviews' => 1240,
                'address' => "Jl. Bukit Pakar Timur No.7, $city",
                'phone' => "081234567890",
                'email' => "hello@mimiticoffee.com",
                'website' => "https://instagram.com/mimiticoffee",
                'link' => "https://maps.google.com/?cid=123"
            ],
            [
                'title' => "Two Hands Full $city",
                'rating' => 4.5,
                'reviews' => 890,
                'address' => "Jl. Sukajadi No.198, $city",
                'phone' => "087812345678",
                'email' => "info@twohandsfull.com",
                'website' => null,
                'link' => "https://maps.google.com/?cid=456"
            ],
            [
                'title' => "Blue Doors Coffee $city",
                'rating' => 4.7,
                'reviews' => 450,
                'address' => "Jl. Alkateri No.2, $city",
                'phone' => "08119876543",
                'email' => "contact@bluedoors.co.id",
                'website' => "https://blue-doors.com",
                'link' => "https://maps.google.com/?cid=789"
            ],
            [
                'title' => "Kopi Toko Djawa $city",
                'rating' => 4.6,
                'reviews' => 3120,
                'address' => "Jl. Braga No.81, $city",
                'phone' => "089987654321",
                'email' => "tokodjawa@gmail.com",
                'website' => "https://linktr.ee/kopitokodjawa",
                'link' => "https://maps.google.com/?cid=101"
            ],
            [
                'title' => "Sejiwa Coffee Shop $city",
                'rating' => 4.4,
                'reviews' => 2400,
                'address' => "Jl. Progo No.15, $city",
                'phone' => "081122334455",
                'email' => "support@sejiwacoffee.com",
                'website' => null,
                'link' => "https://maps.google.com/?cid=202"
            ]
        ];

        $imported = 0;
        $skipped = 0;

        foreach ($mockPlaces as $place) {
            $exists = Lead::where('name', $place['title'])
                ->where(function ($q) use ($place) {
                    $q->where('address', $place['address'])
                      ->orWhere('phone', $place['phone']);
                })
                ->exists();

            if ($exists) {
                $skipped++;
                continue;
            }

            Lead::create([
                'name' => $place['title'],
                'city' => $city,
                'rating' => $place['rating'],
                'user_ratings_total' => $place['reviews'],
                'address' => $place['address'],
                'phone' => $place['phone'],
                'email' => $place['email'] ?? null,
                'website' => $place['website'],
                'maps_url' => $place['link'],
                'status' => 'new',
            ]);
            $imported++;
        }

        return response()->json([
            'status' => 'success',
            'message' => "MOCK: Berhasil mengimpor {$imported} prospek baru di kota {$city}. (Di-skip {$skipped} karena duplikat)",
            'imported_count' => $imported
        ]);
    }
}
