<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'mobil' => ['required', 'string', 'max:255'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'komentar' => ['required', 'string'],
        ]);

        try {
            $review = Review::create($validated);

            return back()->with('success', 'Ulasan berhasil dikirim! Terima kasih atas feedback Anda.');
        } catch (\Exception $e) {
            Log::error('Error saving review: '.$e->getMessage());

            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan ulasan. Silakan coba lagi.');
        }
    }
}
