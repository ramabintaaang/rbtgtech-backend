<?php

namespace App\Http\Controllers;

use App\Models\ContactInquiry;
use Illuminate\Http\Request;

class ContactInquiryAdminController extends Controller
{
    /**
     * Display main Contact Inquiries Inbox SPA view.
     */
    public function index()
    {
        return view('admin.inquiries.index');
    }

    /**
     * Get JSON data of inquiries for AJAX SPA.
     */
    public function data(Request $request)
    {
        $query = ContactInquiry::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $inquiries = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'status' => 'success',
            'data' => $inquiries,
            'unread_count' => ContactInquiry::where('status', 'new')->count()
        ]);
    }

    /**
     * Show single inquiry detail & auto mark status as 'read'.
     */
    public function show($id)
    {
        $inquiry = ContactInquiry::findOrFail($id);

        if ($inquiry->status === 'new') {
            $inquiry->status = 'read';
            $inquiry->save();
        }

        return response()->json([
            'status' => 'success',
            'data' => $inquiry
        ]);
    }

    /**
     * Update inquiry status via AJAX.
     */
    public function updateStatus(Request $request, $id)
    {
        $inquiry = ContactInquiry::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:new,read,replied,archived'
        ]);

        $inquiry->status = $validated['status'];
        $inquiry->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Status pesan berhasil diperbarui!',
            'data' => $inquiry
        ]);
    }

    /**
     * Delete inquiry via AJAX.
     */
    public function destroy($id)
    {
        $inquiry = ContactInquiry::findOrFail($id);
        $inquiry->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Pesan berhasil dihapus!'
        ]);
    }
}
