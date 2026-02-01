<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('customer_id');

            // polymorphic provider: photographer / studio
            $table->string('provider_type'); // Photographer أو Studio (بنحددها تحت)
            $table->unsignedBigInteger('provider_id');

            $table->unsignedBigInteger('session_type_id')->nullable();

            $table->date('booking_date');
            $table->time('booking_time')->nullable();

            $table->string('location_type')->nullable();
            $table->string('location_address')->nullable();

            $table->decimal('price', 10, 2)->nullable();

            $table->enum('status', ['pending','approved','rejected','completed','canceled'])
                ->default('pending');

            $table->text('notes')->nullable();

            $table->timestamps();

            // FK customer -> users
            $table->foreign('customer_id')->references('id')->on('users')->cascadeOnDelete();

            // Indexes مهمة للسرعة
            $table->index(['provider_type', 'provider_id']);
            $table->index(['booking_date', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
