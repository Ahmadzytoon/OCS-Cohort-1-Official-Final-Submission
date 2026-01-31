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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->default(0);

            $table->enum('billing_cycle', ['monthly', 'yearly', 'trial', 'lifetime'])->default('monthly');

            $table->integer('trial_days')->nullable(); // فقط لو billing_cycle = trial

            $table->integer('max_users')->default(0)->comment('0 = unlimited');
            $table->integer('max_departments')->default(0)->comment('0 = unlimited');
            $table->integer('max_knowledge_cards')->default(0)->comment('0 = unlimited');
            $table->integer('ai_requests_limit')->default(0)->comment('0 = unlimited');

            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0); 

            $table->timestamps();
            $table->softDeletes();

            $table->index('is_active');
            $table->index('billing_cycle');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
