<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('studio_portfolio', function (Blueprint $table) {
            $table->id();

            $table->foreignId('studio_id')
                ->constrained('studios')
                ->cascadeOnDelete();

            $table->string('image_path', 255);
            $table->timestamp('uploaded_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('studio_portfolio');
    }
};
