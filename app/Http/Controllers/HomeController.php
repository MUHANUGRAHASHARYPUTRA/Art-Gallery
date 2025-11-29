<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index() {
        if (Auth::check()) {
            // FIX: Memberi tahu editor bahwa $user adalah Model User kita
            /** @var \App\Models\User $user */ 
            $user = Auth::user();
            
            // --- LOGIC ADMIN ---
            if($user->role == 'admin') {
                $stats = [
                    'total_users' => User::count(),
                    'total_artworks' => Artwork::count(),
                    'total_categories' => Category::count(),
                    'pending_curators' => User::where('role', 'curator')->where('status', 'pending')->count(),
                ];
                return view('dashboard.admin.home', compact('stats'));
            }
            
            // --- LOGIC CURATOR ---
            elseif ($user->role == 'curator') {
                if ($user->status === 'pending') {
                    return redirect()->route('curator.pending');
                }
                return redirect()->route('curator.challenges');
            }
            
            // --- LOGIC MEMBER (CREATOR) ---
            else {
                // Hitung Statistik Kreator
                $myArtworks = $user->artworks; // Mengakses sbg property (Collection)
                
                $stats = [
                    'artworks_count' => $myArtworks->count(),
                    'total_likes' => $myArtworks->loadCount('likes')->sum('likes_count'),
                    'total_comments' => $myArtworks->loadCount('comments')->sum('comments_count'),
                    'total_favorites' => \App\Models\Favorite::whereIn('artwork_id', $myArtworks->pluck('id'))->count(),
                ];

                // Mengakses sbg method (Query Builder) untuk filter latest()
                $recentArtworks = $user->artworks()->latest()->take(3)->get();

                return view('dashboard.user.home', compact('stats', 'recentArtworks'));
            }
        } else {
            return redirect('login');
        }
    }
}