<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('photographers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->text('bio')->nullable();
            $table->unsignedInteger('years_of_experience')->nullable();

            // JSON array: ["Weddings","Graduation"...]
            $table->json('photography_types')->nullable();

            $table->decimal('starting_price', 10, 2)->nullable();
            $table->string('city', 100)->nullable();

            $table->string('instagram_url', 255)->nullable();
            $table->string('website_url', 255)->nullable();
            $table->string('behance_url', 255)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('photographers');
    }
};
