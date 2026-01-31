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
    Schema::create('bookings', function (Blueprint $table) {
        $table->id();

        $table->foreignId('customer_user_id')
              ->constrained('users')
              ->onDelete('cascade');

        $table->foreignId('provider_user_id')
              ->constrained('users')
              ->onDelete('cascade');

        $table->foreignId('service_category_id')
              ->constrained('service_categories')
              ->onDelete('cascade');

        $table->foreignId('availability_slot_id')
              ->constrained('availability_slots')
              ->onDelete('cascade');

        $table->decimal('hours', 4, 2);
        $table->text('service_address');
        $table->string('zip_code', 10);
        $table->text('customer_note')->nullable();

        $table->decimal('hourly_rate', 10, 2);
        $table->decimal('base_cost', 10, 2);
        $table->decimal('options_cost', 10, 2)->default(0);
        $table->decimal('total_cost', 10, 2);

        $table->enum('status', [
            'pending',
            'accepted',
            'rejected',
            'completed'
        ])->default('pending');

        $table->text('rejection_reason')->nullable();

        $table->timestamps();

        $table->unique(['availability_slot_id'], 'u_booking_slot');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
