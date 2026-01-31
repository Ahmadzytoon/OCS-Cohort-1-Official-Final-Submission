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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();

            $table->string('workspace_name')->unique();
            $table->string('slug')->unique();

            $table->string('logo')->nullable();

            $table->enum('company_size', ['1-10', '11-50', '51-200', '200+'])->nullable();

            $table->enum('industry', [
                'it-software',
                'accounting',
                'marketing',
                'hr',
                'manufacturing',
                'other'
            ])->nullable();

            $table->string('other_industry')->nullable();

            // خلّيه الآن رقم فقط، وبعدين لما نعمل subscriptions بنعمل FK
            $table->unsignedBigInteger('current_subscription_id')->nullable()->index();

            $table->boolean('is_active')->default(true);
            $table->timestamp('activated_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
