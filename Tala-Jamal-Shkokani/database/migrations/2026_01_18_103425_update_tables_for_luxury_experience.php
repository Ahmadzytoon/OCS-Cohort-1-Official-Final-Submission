<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('image')->nullable()->after('price');
            $table->string('aesthetic')->nullable()->after('image'); // alt, luxury, soft, mix
            $table->string('price_tier')->nullable()->after('aesthetic'); // luxury, aspirational, accessible, treat
            $table->integer('discover_score')->default(0)->after('price_tier');
            $table->integer('view_count')->default(0)->after('discover_score');
            $table->integer('wishlist_count')->default(0)->after('view_count');
            $table->integer('recent_purchases')->default(0)->after('wishlist_count');
            $table->string('brand_name')->nullable()->after('recent_purchases');
            $table->json('occasions')->nullable()->after('brand_name');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('primary_aesthetic')->nullable()->after('style_persona');
            $table->string('secondary_aesthetic')->nullable()->after('primary_aesthetic');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'image',
                'aesthetic',
                'price_tier',
                'discover_score',
                'view_count',
                'wishlist_count',
                'recent_purchases',
                'brand_name',
                'occasions'
            ]);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['primary_aesthetic', 'secondary_aesthetic']);
        });
    }
};
