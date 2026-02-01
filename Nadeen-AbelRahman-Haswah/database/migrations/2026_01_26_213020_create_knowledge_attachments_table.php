<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('knowledge_attachments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('knowledge_entry_id')
                ->constrained('knowledge_entries')
                ->cascadeOnDelete();

            $table->enum('type', ['image', 'pdf', 'doc', 'video', 'audio', 'file', 'url'])->default('file');

            $table->string('path')->nullable(); // للملفات المخزنة
            $table->string('url')->nullable();  // للروابط

            $table->string('original_name')->nullable();
            $table->unsignedBigInteger('size')->nullable();
            $table->string('mime')->nullable();

            $table->foreignId('uploaded_by')->constrained('users')->cascadeOnDelete();

            $table->timestamps();

            $table->index(['knowledge_entry_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('knowledge_attachments');
    }
};
