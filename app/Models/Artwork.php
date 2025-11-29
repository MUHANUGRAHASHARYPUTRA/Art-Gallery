<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artwork extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'image_path',
    ];

    // Karya dimiliki oleh satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Karya termasuk dalam satu Kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // Helper untuk cek apakah user yang login sudah like karya ini
    public function isLikedBy($user)
    {
        if (!$user) return false;
        return $this->likes->where('user_id', $user->id)->count() > 0;
    }
    // Relasi Favorites
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    // Helper: Cek apakah sudah difavorite oleh user tertentu
    public function isFavoritedBy($user)
    {
        if (!$user) return false;
        return $this->favorites->where('user_id', $user->id)->count() > 0;
    }
}