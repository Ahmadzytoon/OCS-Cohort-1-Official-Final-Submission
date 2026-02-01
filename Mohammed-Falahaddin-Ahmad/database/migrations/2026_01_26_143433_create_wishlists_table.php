<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wishlists', function (Blueprint $table) { // PLURAL TABLE NAME
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            // Named index to avoid length issues
            $table->unique(['user_id', 'book_id'], 'wishlists_user_book_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wishlists'); // PLURAL
    }
};