<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('photographer_portfolio', function (Blueprint $table) {
            $table->id();

            $table->foreignId('photographer_id')
                ->constrained('photographers')
                ->cascadeOnDelete();

            $table->string('image_path', 255);
            $table->timestamp('uploaded_at')->useCurrent();

            // بدون timestamps لأنك مستخدمة uploaded_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('photographer_portfolio');
    }
};
