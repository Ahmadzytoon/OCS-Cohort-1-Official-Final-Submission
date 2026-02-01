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
    Schema::table('photographer_portfolio', function (Blueprint $table) {
        $table->string('category')->nullable()->after('image_path');
        $table->string('title')->nullable()->after('category');
        $table->text('description')->nullable()->after('title');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('photographer_portfolio', function (Blueprint $table) {
            //
        });
    }
};
