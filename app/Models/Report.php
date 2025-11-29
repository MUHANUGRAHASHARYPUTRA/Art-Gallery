<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'artwork_id', 'reason', 'status'];

    // Siapa yang lapor?
    public function reporter()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Karya apa yang dilaporkan?
    public function artwork()
    {
        return $this->belongsTo(Artwork::class);
    }
}