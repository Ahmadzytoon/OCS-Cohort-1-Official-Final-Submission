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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('subscription_id');
            $table->unsignedBigInteger('company_id');

            $table->decimal('amount', 10, 2)->default(0);
            $table->string('currency', 10)->default('USD');
            $table->enum('status', ['paid', 'pending', 'failed', 'refunded'])->default('paid');
            $table->timestamp('paid_at')->nullable();

            $table->string('provider')->nullable();       // Stripe / PayPal ...
            $table->string('reference')->nullable();      // transaction id
            $table->string('card_last4')->nullable();     // 4242

            $table->timestamps();

            // Indexes
            $table->index(['company_id', 'subscription_id']);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
