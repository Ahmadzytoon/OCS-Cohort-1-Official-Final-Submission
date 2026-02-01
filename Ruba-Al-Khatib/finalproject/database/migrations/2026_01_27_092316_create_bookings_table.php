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
    // This table already exists (created by 2026_01_25_202217_create_bookings_table)
    // so we skip to avoid "already exists" error.
}

public function down(): void
{
    // skip
}

};
