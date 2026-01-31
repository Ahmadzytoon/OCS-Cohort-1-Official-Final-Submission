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
        Schema::create('provider_option_pricings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provider_service_id')->constrained('provider_services')->onDelete('cascade');
            $table->foreignId('service_option_id')->constrained('service_options')->onDelete('cascade');
            $table->decimal('price',8,2);
            $table->unique(['provider_service_id', 'service_option_id'], 'u_ps_so');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provider_option_pricings');
    }
};
