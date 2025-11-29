<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Menampilkan Profil Publik Kreator (Phase 12).
     */
    public function show(User $user)
    {
        // Ambil karya milik user ini
        $artworks = $user->artworks()->latest()->get();
        
        // Hitung total like yang didapat
        $totalLikes = $user->artworks()->withCount('likes')->get()->sum('likes_count');

        return view('profile.show', compact('user', 'artworks', 'totalLikes'));
    }

    /**
     * Action Follow/Unfollow (Phase 13).
     * INI METHOD YANG SEBELUMNYA HILANG
     */
    public function follow(User $user)
    {
        /** @var \App\Models\User $currentUser */
        $currentUser = Auth::user();

        // Tidak boleh follow diri sendiri
        if ($currentUser->id === $user->id) {
            return back()->with('error', 'You cannot follow yourself.');
        }

        if ($user->isFollowedBy($currentUser)) {
            // Unfollow
            $currentUser->followings()->detach($user->id);
        } else {
            // Follow
            $currentUser->followings()->attach($user->id);
        }

        return back();
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}