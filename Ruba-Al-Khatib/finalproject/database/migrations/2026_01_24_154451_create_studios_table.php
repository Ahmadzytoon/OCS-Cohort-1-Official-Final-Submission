<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('studios', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('studio_name', 255);
            $table->text('description')->nullable();
            $table->string('phone_number', 20)->nullable();

            // {"Mon":"09-17", ...}
            $table->json('working_hours')->nullable();

            $table->text('address')->nullable();

            $table->decimal('location_lat', 10, 8)->nullable();
            $table->decimal('location_lng', 11, 8)->nullable();

            $table->json('services')->nullable();
            $table->unsignedInteger('team_size')->nullable();

            $table->json('equipment_tags')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('studios');
    }
};
