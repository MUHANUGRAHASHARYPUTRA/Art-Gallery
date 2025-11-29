<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('challenge_id')->constrained()->onDelete('cascade');
            $table->foreignId('artwork_id')->constrained()->onDelete('cascade');
            // Kolom untuk menyimpan juara (misal: 1, 2, 3). Null berarti belum/bukan juara.
            $table->unsignedTinyInteger('winner_rank')->nullable(); 
            $table->timestamps();

            // Mencegah satu karya disubmit berkali-kali di challenge yang sama
            $table->unique(['challenge_id', 'artwork_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};