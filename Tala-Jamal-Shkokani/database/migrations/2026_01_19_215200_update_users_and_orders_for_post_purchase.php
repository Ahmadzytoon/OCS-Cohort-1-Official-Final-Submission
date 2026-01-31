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
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('total_spent', 10, 2)->default(0)->after('password');
            $table->timestamp('last_purchase_at')->nullable()->after('total_spent');
            $table->string('loyalty_tier')->default('standard')->after('last_purchase_at');
            $table->json('preferred_aesthetics')->nullable()->after('loyalty_tier');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->string('tracking_number')->nullable()->after('order_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['total_spent', 'last_purchase_at', 'loyalty_tier', 'preferred_aesthetics']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('tracking_number');
        });
    }
};
