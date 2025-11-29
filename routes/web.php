<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArtworkController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CuratorController;
use App\Http\Controllers\CollectionController;
use App\Models\Artwork;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// --- HOMEPAGE (PUBLIC GALLERY WITH FILTER & SEARCH) ---
Route::get('/', function (Request $request) {
    $query = Artwork::with(['user', 'category'])->latest();

    // Filter by Search (Title or Creator Name)
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('title', 'like', '%' . $search . '%')
              ->orWhereHas('user', function($u) use ($search) {
                  $u->where('name', 'like', '%' . $search . '%');
              });
        });
    }

    // Filter by Category
    if ($request->filled('category')) {
        $query->whereHas('category', function($q) use ($request) {
            $q->where('slug', $request->category);
        });
    }

    $artworks = $query->get();
    $categories = Category::all();
    
    // Active Challenges Section
    $activeChallenges = \App\Models\Challenge::where('end_date', '>=', now())->latest()->take(3)->get();

    return view('welcome', compact('artworks', 'categories', 'activeChallenges'));
})->name('home');

// --- DASHBOARD (REDIRECT BASED ON ROLE) ---
Route::get('/dashboard', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

// --- MEMBER ROUTES ---
Route::middleware('auth')->group(function () {
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/creator/{user}/follow', [ProfileController::class, 'follow'])->name('profile.follow');

    // Artwork Management (Member CRUD)
    Route::get('/my-artworks', [ArtworkController::class, 'manage'])->name('artworks.manage');
    Route::get('/artworks/create', [ArtworkController::class, 'create'])->name('artworks.create');
    Route::post('/artworks', [ArtworkController::class, 'store'])->name('artworks.store');
    Route::get('/artworks/{artwork}/edit', [ArtworkController::class, 'edit'])->name('artworks.edit');
    Route::put('/artworks/{artwork}', [ArtworkController::class, 'update'])->name('artworks.update');
    Route::delete('/artworks/{artwork}', [ArtworkController::class, 'destroy'])->name('artworks.destroy');

    // Interactions
    Route::post('/artworks/{artwork}/comment', [ArtworkController::class, 'comment'])->name('artworks.comment');
    Route::post('/artworks/{artwork}/like', [ArtworkController::class, 'like'])->name('artworks.like');
    Route::post('/artworks/{artwork}/favorite', [ArtworkController::class, 'favorite'])->name('artworks.favorite');
    Route::get('/my-favorites', [ArtworkController::class, 'myFavorites'])->name('artworks.favorites');
    Route::post('/artworks/{artwork}/report', [ArtworkController::class, 'report'])->name('artworks.report');

    // Challenges & Submissions
    Route::post('/challenges/{challenge}/submit', [CuratorController::class, 'submit'])->name('challenges.submit');
    Route::get('/my-submissions', [CuratorController::class, 'mySubmissions'])->name('challenges.my_submissions');

    // Collections / Moodboards (Phase 15)
    Route::get('/collections', [CollectionController::class, 'index'])->name('collections.index');
    Route::post('/collections', [CollectionController::class, 'store'])->name('collections.store');
    Route::get('/collections/{collection}', [CollectionController::class, 'show'])->name('collections.show');
    Route::delete('/collections/{collection}', [CollectionController::class, 'destroy'])->name('collections.destroy');
    Route::post('/artworks/{artwork}/collect', [CollectionController::class, 'toggleArtwork'])->name('collections.toggle');
});

// --- ADMIN ROUTES ---
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard & Stats
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Category Management
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::put('/categories/{category}', [AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminController::class, 'destroyCategory'])->name('categories.destroy');

    // User Management (Approval, Update Role, Suspend)
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::patch('/users/{user}/approve', [AdminController::class, 'approveUser'])->name('users.approve');
    Route::patch('/users/{user}/update', [AdminController::class, 'updateUser'])->name('users.update'); // <-- Update Role/Status
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');

    // Moderation Queue
    Route::get('/moderation', [AdminController::class, 'moderation'])->name('moderation');
    Route::delete('/moderation/{report}/takedown', [AdminController::class, 'takeDown'])->name('moderation.takedown');
    Route::patch('/moderation/{report}/dismiss', [AdminController::class, 'dismissReport'])->name('moderation.dismiss');
});

// --- CURATOR ROUTES ---
Route::middleware(['auth', 'verified'])->prefix('curator')->name('curator.')->group(function () {
    // Halaman Pending (Bisa diakses tanpa middleware 'curator' penuh)
    Route::get('/pending', function() {
        if (Auth::user()->role !== 'curator') return redirect('/');
        if (Auth::user()->status === 'active') return redirect()->route('curator.challenges');
        return view('auth.pending');
    })->name('pending');

    // Grup yang butuh status Active (Middleware Curator Custom)
    Route::middleware('curator')->group(function() {
        Route::get('/challenges', [CuratorController::class, 'manage'])->name('challenges');
        Route::get('/challenges/create', [CuratorController::class, 'create'])->name('challenges.create');
        Route::post('/challenges', [CuratorController::class, 'store'])->name('challenges.store');
        Route::get('/challenges/{challenge}/edit', [CuratorController::class, 'edit'])->name('challenges.edit');
        Route::put('/challenges/{challenge}', [CuratorController::class, 'update'])->name('challenges.update');
        Route::delete('/challenges/{challenge}', [CuratorController::class, 'destroy'])->name('challenges.destroy');
        Route::patch('/challenges/{challenge}/submissions/{submission}/winner', [CuratorController::class, 'selectWinner'])->name('challenges.winner');
    });
});

// --- PUBLIC ROUTES (WILDCARDS LAST) ---
// Penting: Route dengan {parameter} diletakkan paling bawah agar tidak konflik dengan route statis
Route::get('/challenges/{challenge}', [CuratorController::class, 'show'])->name('challenges.show');
Route::get('/creator/{user}', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/artworks/{artwork}', [ArtworkController::class, 'show'])->name('artworks.show');

require __DIR__.'/auth.php';