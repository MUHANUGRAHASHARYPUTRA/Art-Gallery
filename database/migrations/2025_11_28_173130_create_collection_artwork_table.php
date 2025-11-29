<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('collection_artwork', function (Blueprint $table) {
        $table->id();
        $table->foreignId('collection_id')->constrained()->onDelete('cascade');
        $table->foreignId('artwork_id')->constrained()->onDelete('cascade');
        $table->timestamps();
        
        $table->unique(['collection_id', 'artwork_id']); // Cegah duplikat
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collection_artwork');
    }
};
