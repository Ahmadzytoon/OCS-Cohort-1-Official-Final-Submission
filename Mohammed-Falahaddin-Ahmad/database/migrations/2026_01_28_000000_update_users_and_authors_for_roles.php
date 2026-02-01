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
        // Update users table to include role
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'user', 'author'])->default('user')->after('email');
        });

        // Update authors table to link to a user
        Schema::table('authors', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade')->after('id');
            $table->string('image')->nullable()->after('biography');
            $table->decimal('total_earnings', 15, 2)->default(0.00)->after('image');
        });

        // Create Plans Table
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->enum('duration_type', ['month', 'year']);
            $table->integer('book_limit')->default(-1); // -1 for unlimited
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Create Subscriptions Table
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('plan_id')->constrained()->onDelete('cascade');
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->enum('status', ['active', 'expired', 'cancelled'])->default('active');
            $table->timestamps();
        });

        // Create Earnings Table
        Schema::create('earnings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('order_item_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 15, 2);
            $table->decimal('platform_commission', 15, 2);
            $table->timestamps();
        });

        // Add sales_count to books table (Fix for QueryException)
        Schema::table('books', function (Blueprint $table) {
            $table->integer('sales_count')->default(0)->after('stock_quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('earnings');
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('plans');
        
        Schema::table('authors', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'image', 'total_earnings']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });

        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('sales_count');
        });
    }
};
