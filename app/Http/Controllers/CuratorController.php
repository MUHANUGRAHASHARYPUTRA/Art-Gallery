<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Challenge;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CuratorController extends Controller
{
    // --- CHALLENGE MANAGEMENT ---

    /**
     * Dashboard Curator: List Challenge milik sendiri.
     */
    public function manage()
    {
        $challenges = Challenge::where('user_id', Auth::id())->withCount('submissions')->latest()->get();
        return view('dashboard.curator.challenges', compact('challenges'));
    }

    /**
     * Form Create Challenge.
     */
    public function create()
    {
        return view('challenges.create');
    }

    /**
     * Simpan Challenge Baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'banner' => 'nullable|image|max:5120',
        ]);

        $data = $request->except('banner');
        $data['user_id'] = Auth::id();

        if ($request->hasFile('banner')) {
            $data['banner_path'] = $request->file('banner')->store('challenges', 'public');
        }

        Challenge::create($data);

        return redirect()->route('curator.challenges')->with('success', 'Challenge created!');
    }

    /**
     * Form Edit Challenge.
     */
    public function edit(Challenge $challenge)
    {
        if ($challenge->user_id !== Auth::id()) abort(403);
        return view('challenges.edit', compact('challenge'));
    }

    /**
     * Update Challenge.
     */
    public function update(Request $request, Challenge $challenge)
    {
        if ($challenge->user_id !== Auth::id()) abort(403);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'banner' => 'nullable|image|max:5120',
        ]);

        $data = $request->except('banner');

        if ($request->hasFile('banner')) {
            if ($challenge->banner_path) Storage::disk('public')->delete($challenge->banner_path);
            $data['banner_path'] = $request->file('banner')->store('challenges', 'public');
        }

        $challenge->update($data);

        return redirect()->route('curator.challenges')->with('success', 'Challenge updated!');
    }

    /**
     * Hapus Challenge.
     */
    public function destroy(Challenge $challenge)
    {
        if ($challenge->user_id !== Auth::id()) abort(403);
        
        if ($challenge->banner_path) Storage::disk('public')->delete($challenge->banner_path);
        $challenge->delete();

        return back()->with('success', 'Challenge deleted.');
    }

    // --- PUBLIC VIEWS & SUBMISSIONS ---

    /**
     * Halaman Detail Challenge (Public).
     */
    public function show(Challenge $challenge)
    {
        // Load submisi dan karya pemenang
        $submissions = $challenge->submissions()->with('artwork.user')->latest()->get();
        
        // Cek apakah user yang login punya karya untuk disubmit (dropdown)
        $myArtworks = [];
        if (Auth::check() && Auth::user()->role === 'member') {
            // Ambil karya yg belum disubmit ke challenge ini
            $submittedIds = $challenge->submissions->pluck('artwork_id')->toArray();
            $myArtworks = Artwork::where('user_id', Auth::id())
                                ->whereNotIn('id', $submittedIds)
                                ->get();
        }

        return view('challenges.show', compact('challenge', 'submissions', 'myArtworks'));
    }

    /**
     * Member Submit Karya ke Challenge.
     */
    public function submit(Request $request, Challenge $challenge)
    {
        $request->validate([
            'artwork_id' => 'required|exists:artworks,id'
        ]);

        // Pastikan karya milik user sendiri
        $artwork = Artwork::findOrFail($request->artwork_id);
        if ($artwork->user_id !== Auth::id()) abort(403);

        Submission::create([
            'challenge_id' => $challenge->id,
            'artwork_id' => $artwork->id,
        ]);

        return back()->with('success', 'Artwork submitted successfully!');
    }

    /**
     * Curator Memilih Pemenang.
     */
    public function selectWinner(Request $request, Challenge $challenge, Submission $submission)
    {
        if ($challenge->user_id !== Auth::id()) abort(403);
        
        // Validasi input rank (1, 2, atau 3)
        $request->validate([
            'rank' => 'required|integer|min:1|max:3'
        ]);

        // Update rank submisi ini
        $submission->update(['winner_rank' => $request->rank]);

        return back()->with('success', 'Winner selected!');
    }

    /**
     * Halaman Riwayat Submisi Member.
     */
    public function mySubmissions()
    {
        // Ambil submission milik user yg login
        $submissions = Submission::whereHas('artwork', function($q) {
            $q->where('user_id', Auth::id());
        })->with(['challenge', 'artwork'])->latest()->get();

        return view('dashboard.user.submissions', compact('submissions'));
    }
}