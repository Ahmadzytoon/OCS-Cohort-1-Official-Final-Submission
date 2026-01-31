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
        Schema::table('customer_profiles', function (Blueprint $table) {
            $table->string('address_line', 255)->nullable()->after('zip_code');
            $table->string('city', 100)->nullable()->after('address_line');
            $table->string('unit', 50)->nullable()->after('city');
            $table->string('preferred_language', 10)->nullable()->after('unit');
            $table->string('notifications', 20)->nullable()->after('preferred_language');
            $table->text('default_notes')->nullable()->after('notifications');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'address_line',
                'city',
                'unit',
                'preferred_language',
                'notifications',
                'default_notes',
            ]);
        });
    }
};
