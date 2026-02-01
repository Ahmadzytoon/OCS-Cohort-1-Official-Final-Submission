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
        Schema::create('company_news', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('author_id')->constrained('users')->cascadeOnDelete(); // company_owner

            $table->string('title', 191);

            // category ثابتة + custom
            $table->enum('category', ['company', 'product', 'hr', 'achievement', 'announcement', 'other'])->nullable();
            $table->string('custom_category', 191)->nullable();

            // الصورة (اختياري)
            $table->string('image', 191)->nullable(); // path

            $table->longText('content');

            // الحالة
            $table->enum('status', ['draft', 'scheduled', 'published'])->default('draft');

            // مواعيد
            $table->timestamp('publish_at')->nullable();     // للـ scheduled
            $table->timestamp('published_at')->nullable();   // وقت ما يصير published فعلاً

            // إشعار لاحقاً
            $table->boolean('send_notification')->default(true);

            $table->timestamps();

            $table->index(['company_id', 'status']);
            $table->index(['company_id', 'publish_at']);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_news');
    }
};
