<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();

            // client | photographer | studio
            $table->string('for', 30);

            // basic | premium | vip | free | pro | starter | ...
            $table->string('code', 50);

            // Display name
            $table->string('name', 100);

            // Monthly price in JOD (integer)
            $table->unsignedInteger('price_jod')->default(0);

            // Feature flags / limits (json)
            $table->json('features')->nullable();

            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort')->default(0);

            $table->timestamps();

            $table->unique(['for', 'code']);
            $table->index(['for', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
