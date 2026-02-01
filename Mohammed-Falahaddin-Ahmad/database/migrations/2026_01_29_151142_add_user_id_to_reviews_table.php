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
        Schema::table('reviews', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('book_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Make these nullable as we'll use Auth::user() for new reviews
            $table->string('customer_name')->nullable()->change();
            $table->string('customer_email')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            
            $table->string('customer_name')->nullable(false)->change();
            $table->string('customer_email')->nullable(false)->change();
        });
    }
};
