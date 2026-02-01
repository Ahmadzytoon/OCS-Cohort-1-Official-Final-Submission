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
    Schema::table('knowledge_entries', function (Blueprint $table) {
        $table->text('approval_comment')->nullable()->after('approved_by');
        $table->text('rejection_comment')->nullable()->after('rejection_reason');
    });
}

public function down(): void
{
    Schema::table('knowledge_entries', function (Blueprint $table) {
        $table->dropColumn(['approval_comment', 'rejection_comment']);
    });
}



};
