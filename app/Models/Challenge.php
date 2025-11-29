<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'rules',
        'start_date',
        'end_date',
        'banner_path',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // Challenge dibuat oleh Curator (User)
    public function curator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Challenge memiliki banyak submisi
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    // Helper: Cek apakah challenge masih aktif
    public function isActive()
    {
        $now = now()->startOfDay();
        return $now->gte($this->start_date) && $now->lte($this->end_date);
    }
}