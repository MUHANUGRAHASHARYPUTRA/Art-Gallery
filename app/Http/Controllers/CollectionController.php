<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller
{
    /**
     * Menampilkan daftar koleksi user.
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $collections = $user->collections()->withCount('artworks')->latest()->get();
        return view('collections.index', compact('collections'));
    }

    /**
     * Membuat koleksi baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Collection::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
        ]);

        return back()->with('success', 'Collection created!');
    }

    /**
     * Menampilkan isi koleksi.
     */
    public function show(Collection $collection)
    {
        if ($collection->user_id !== Auth::id()) abort(403);
        
        $artworks = $collection->artworks()->with('user')->get();
        return view('collections.show', compact('collection', 'artworks'));
    }

    /**
     * Menghapus koleksi.
     */
    public function destroy(Collection $collection)
    {
        if ($collection->user_id !== Auth::id()) abort(403);
        $collection->delete();
        return redirect()->route('collections.index');
    }

    /**
     * Menambah/Menghapus artwork dari koleksi (Toggle).
     */
    public function toggleArtwork(Request $request, Artwork $artwork)
    {
        $request->validate([
            'collection_id' => 'required|exists:collections,id'
        ]);

        $collection = Collection::where('id', $request->collection_id)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();

        // Toggle logic
        if ($collection->artworks()->where('artwork_id', $artwork->id)->exists()) {
            $collection->artworks()->detach($artwork->id);
            $message = 'Removed from collection';
        } else {
            $collection->artworks()->attach($artwork->id);
            $message = 'Added to collection';
        }

        return back()->with('success', $message);
    }
}