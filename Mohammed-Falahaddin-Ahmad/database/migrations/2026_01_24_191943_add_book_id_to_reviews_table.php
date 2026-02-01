<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBookIdToReviewsTable extends Migration
{
    public function up(): void
{
    Schema::table('reviews', function (Blueprint $table) {
        // Only add column if it doesn't exist
        if (!Schema::hasColumn('reviews', 'book_id')) {
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
        }
    });
}
    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['book_id']);
            $table->dropColumn('book_id');
        });
    }
}