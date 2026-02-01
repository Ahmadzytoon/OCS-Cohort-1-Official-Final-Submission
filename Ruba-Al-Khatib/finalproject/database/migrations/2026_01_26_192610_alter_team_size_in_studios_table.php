<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('studios', function (Blueprint $table) {
            $table->string('team_size', 20)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('studios', function (Blueprint $table) {
            $table->unsignedInteger('team_size')->nullable()->change();
        });
    }
};
