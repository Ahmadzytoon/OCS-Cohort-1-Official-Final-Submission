<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('access_requests', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('department_id')->nullable();

            $table->string('name', 191);
            $table->string('email', 191);
            $table->string('phone', 191)->nullable();

            $table->text('message')->nullable();

            // الشخص شو طالب؟ (ممكن تخليها employee فقط، أو تسمحي employee/department_manager)
            $table->enum('requested_role', ['employee', 'department_manager'])->default('employee');

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            // بيانات قرار الرفض
            $table->string('rejection_reason', 191)->nullable();
            $table->text('rejection_message')->nullable();

            // بيانات قرار القبول
            $table->enum('approved_role', ['employee', 'department_manager'])->nullable();
            $table->string('position', 191)->nullable();

            // مين عالج الطلب؟ (Company owner أو Dept manager)
            $table->unsignedBigInteger('processed_by')->nullable();
            $table->timestamp('processed_at')->nullable();

            $table->timestamps();

            // Indexes
            $table->index(['company_id', 'department_id', 'status']);
            $table->unique(['company_id', 'email', 'status']); // يمنع نفس الايميل يعمل pending مكرر بنفس الشركة
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('access_requests');
    }
};
