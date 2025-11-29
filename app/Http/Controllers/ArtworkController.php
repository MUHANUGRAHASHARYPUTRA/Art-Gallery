<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Favorite; 
use App\Models\Like;    
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Tambahan untuk otorisasi

class ArtworkController extends Controller
{
    use AuthorizesRequests; // Gunakan trait ini

    /**
     * Menampilkan form upload karya.
     */
    public function create()
    {
        $categories = Category::all();
        return view('artworks.create', compact('categories'));
    }

    /**
     * Menyimpan karya baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('artworks', 'public');
        }

        Artwork::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('dashboard')->with('success', 'Artwork uploaded successfully!');
    }

    /**
     * Menampilkan detail karya (Public).
     */
    public function show(Artwork $artwork)
    {
        $artwork->load(['comments.user', 'likes']);
        return view('artworks.show', compact('artwork'));
    }

    // --- FITUR BARU PHASE 5 ---

    /**
     * Menampilkan daftar karya milik user yang sedang login.
     */
    public function manage()
    {
        $artworks = Artwork::where('user_id', Auth::id())->latest()->get();
        return view('artworks.manage', compact('artworks'));
    }

    /**
     * Menampilkan form edit.
     */
    public function edit(Artwork $artwork)
    {
        // Pastikan yang mengedit adalah pemiliknya
        if ($artwork->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::all();
        return view('artworks.edit', compact('artwork', 'categories'));
    }

    /**
     * Menyimpan perubahan edit.
     */
    public function update(Request $request, Artwork $artwork)
    {
        if ($artwork->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'image' => 'nullable|image|max:5120', // Image opsional saat edit
        ]);

        $data = [
            'title' => $request->title,
            'category_id' => $request->category_id,
            'description' => $request->description,
        ];

        // Jika ada gambar baru, hapus yang lama dan upload yang baru
        if ($request->hasFile('image')) {
            if ($artwork->image_path && Storage::disk('public')->exists($artwork->image_path)) {
                Storage::disk('public')->delete($artwork->image_path);
            }
            $data['image_path'] = $request->file('image')->store('artworks', 'public');
        }

        $artwork->update($data);

        return redirect()->route('artworks.manage')->with('success', 'Artwork updated!');
    }

    /**
     * Menghapus karya.
     */
    public function destroy(Artwork $artwork)
    {
        if ($artwork->user_id !== Auth::id()) {
            abort(403);
        }

        // Hapus file gambar dari storage
        if ($artwork->image_path && Storage::disk('public')->exists($artwork->image_path)) {
            Storage::disk('public')->delete($artwork->image_path);
        }

        $artwork->delete();

        return redirect()->route('artworks.manage')->with('success', 'Artwork deleted!');
    }

    // --- INTERAKSI ---

    public function comment(Request $request, Artwork $artwork)
    {
        $request->validate(['body' => 'required|string|max:1000']);

        Comment::create([
            'user_id' => Auth::id(),
            'artwork_id' => $artwork->id,
            'body' => $request->body
        ]);

        return back()->with('success', 'Comment posted!');
    }

    public function like(Artwork $artwork)
    {
        $user = Auth::user();
        
        $existingLike = Like::where('user_id', $user->id)
                            ->where('artwork_id', $artwork->id)
                            ->first();

        if ($existingLike) {
            $existingLike->delete();
        } else {
            Like::create([
                'user_id' => $user->id,
                'artwork_id' => $artwork->id
            ]);
        }

        return back();
    }


    /**
     * Member melaporkan karya.
     */
    public function report(Request $request, Artwork $artwork)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        // Cek apakah user sudah pernah melaporkan karya ini sebelumnya (opsional, biar ga spam)
        $existing = \App\Models\Report::where('user_id', Auth::id())
                        ->where('artwork_id', $artwork->id)
                        ->first();

        if ($existing) {
            return back()->with('error', 'You have already reported this artwork.');
        }

        \App\Models\Report::create([
            'user_id' => Auth::id(),
            'artwork_id' => $artwork->id,
            'reason' => $request->reason,
        ]);

        return back()->with('success', 'Report submitted to moderators.');
    }

    // Jangan lupa import: 

    /**
     * Toggle Favorite (Simpan/Hapus dari koleksi).
     */
    public function favorite(Artwork $artwork)
    {
        $user = Auth::user();
        
        $existing = \App\Models\Favorite::where('user_id', $user->id)
                        ->where('artwork_id', $artwork->id)
                        ->first();

        if ($existing) {
            $existing->delete(); // Unfavorite
        } else {
            \App\Models\Favorite::create([
                'user_id' => $user->id,
                'artwork_id' => $artwork->id
            ]); // Favorite
        }

        return back();
    }

    /**
     * Halaman My Favorites (Dashboard).
     */
    public function myFavorites()
    {
        // Ambil artwork yang ada di tabel favorites user ini
        $favorites = Artwork::whereHas('favorites', function($q) {
            $q->where('user_id', Auth::id());
        })->with(['user', 'category'])->latest()->get();

        return view('artworks.favorites', compact('favorites'));
    }
}