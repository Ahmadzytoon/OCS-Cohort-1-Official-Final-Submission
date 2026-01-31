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
    Schema::table('availability_slots', function (Blueprint $table) {
        $table->dropColumn(['start_datetime', 'end_datetime']);
        $table->time('start_time');
        $table->time('end_time');
    });
}

public function down(): void
{
    Schema::table('availability_slots', function (Blueprint $table) {
        $table->dropColumn(['start_time', 'end_time']);
        $table->dateTime('start_datetime');
        $table->dateTime('end_datetime');
    });
}

};
