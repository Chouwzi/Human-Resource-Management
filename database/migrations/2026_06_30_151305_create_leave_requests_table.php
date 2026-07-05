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
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->foreignId('leave_type_id')->constrained('leave_types')->onDelete('cascade');
            $table->unsignedBigInteger('approver_id')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('total_days', 5, 2)->default(1);
            $table->string('reason', 500);
            $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled'])->default('pending');
            $table->dateTime('approved_at')->nullable();
            $table->timestamps();

            // Approver FK definition
            $table->foreign('approver_id')->references('id')->on('employees')->nullOnDelete();

            // Indexes
            $table->index(['employee_id', 'status'], 'idx_leave_employee_status');
            $table->index(['approver_id', 'status'], 'idx_leave_approver_status');
            $table->index('leave_type_id', 'idx_leave_type');
            $table->index('status', 'idx_leave_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
    }
};
