<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Category;
use App\Models\Report; // Pastikan import ini ada
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Halaman Utama Admin Dashboard.
     */
    public function index()
    {
        // UPDATE: Menggunakan key yang sesuai dengan View baru ('total_users', dll)
        $stats = [
            'total_users' => User::count(),
            'total_artworks' => Artwork::count(),
            'total_categories' => Category::count(),
            'pending_curators' => User::where('role', 'curator')->where('status', 'pending')->count(),
        ];

        return view('dashboard.admin.home', compact('stats'));
    }

    /**
     * Halaman Manajemen Kategori (List & Form).
     */
    public function categories()
    {
        $categories = Category::withCount('artworks')->latest()->get();
        return view('dashboard.admin.categories', compact('categories'));
    }

    /**
     * Simpan Kategori Baru.
     */
    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return back()->with('success', 'Category created successfully!');
    }

    /**
     * Update Kategori.
     */
    public function updateCategory(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return back()->with('success', 'Category updated!');
    }

    /**
     * Hapus Kategori.
     */
    public function destroyCategory(Category $category)
    {
        if ($category->artworks()->count() > 0) {
            return back()->with('error', 'Cannot delete category containing artworks.');
        }

        $category->delete();
        return back()->with('success', 'Category deleted!');
    }

    // --- USER MANAGEMENT ---

    public function users()
    {
        $users = User::whereIn('role', ['member', 'curator'])
                    ->orderByRaw("FIELD(status, 'pending', 'active')")
                    ->latest()
                    ->get();

        return view('dashboard.admin.users', compact('users'));
    }

    public function approveUser(User $user)
    {
        if ($user->status !== 'pending') {
            return back()->with('error', 'User is already active.');
        }

        $user->update(['status' => 'active']);

        return back()->with('success', 'User approved successfully!');
    }

    /**
     * Update Role & Status User (Edit).
     */
   /**
     */
    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,curator,member',
            'status' => 'required|in:active,pending,suspended',
        ]);

        // PERBAIKAN: Gunakan Auth::id() alih-alih auth()->id()
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot change your own role or status.');
        }

        $user->update([
            'role' => $request->role,
            'status' => $request->status,
        ]);

        return back()->with('success', 'User updated successfully.');
    }

    public function destroyUser(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Cannot delete admin.');
        }

        $user->delete();
        return back()->with('success', 'User removed.');
    }

    // --- MODERATION ---

    public function moderation()
    {
        $reports = Report::with(['reporter', 'artwork'])->where('status', 'pending')->latest()->get();
        return view('dashboard.admin.moderation', compact('reports'));
    }

    public function takeDown(Report $report)
    {
        $artwork = $report->artwork;
        if ($artwork) {
            $artwork->delete();
        }

        $report->update(['status' => 'resolved']);
        Report::where('artwork_id', $report->artwork_id)->update(['status' => 'resolved']);

        return back()->with('success', 'Content taken down successfully.');
    }

    public function dismissReport(Report $report)
    {
        $report->update(['status' => 'dismissed']);
        return back()->with('success', 'Report dismissed.');
    }
}