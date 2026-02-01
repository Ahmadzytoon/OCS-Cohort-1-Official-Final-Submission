<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Book Title
            $table->string('isbn')->unique(); // ISBN
            $table->foreignId('author_id')->constrained()->onDelete('cascade'); // Author
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Category
            $table->decimal('price', 8, 2); // Price
            $table->integer('stock_quantity'); // Stock Quantity
            $table->enum('status', ['Active', 'Inactive'])->default('Active'); // Status
            $table->string('cover_image')->nullable(); // Book Cover Image (filename)
            $table->text('description')->nullable(); // Short description (for listing)
            $table->text('long_description')->nullable(); // Full description (for details tab)

            // Additional book metadata (for admin control & frontend display)
            $table->string('language')->nullable()->default('English');
            $table->string('format')->nullable()->default('Hardcover'); // e.g., Paperback, eBook, Audiobook
            $table->unsignedInteger('pages')->nullable(); // Number of pages
            $table->string('country')->nullable()->default('United States'); // Country of publication
            $table->year('publish_year')->nullable(); // Year of publication
            $table->date('publish_date')->nullable(); // Exact publication date (optional but useful)
            $table->string('dimensions')->nullable(); // e.g., "6 x 9 inches" or "15 x 23 cm"
            $table->decimal('weight', 8, 2)->nullable(); // Weight in kg (or lbs — be consistent)
            $table->string('tags')->nullable(); // Comma-separated tags: "Fiction, Bestseller, Adventure"

            $table->timestamps();
        });

        // Add database indexes for better query performance
        Schema::table('books', function (Blueprint $table) {
            $table->index('title');
            $table->index('isbn');
            $table->index('author_id');
            $table->index('category_id');
            $table->index('status')->nullable();
            $table->index('publish_year');
            $table->index('language');
            $table->index('format');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
}