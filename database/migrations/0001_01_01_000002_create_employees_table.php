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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users');
            $table->foreignId('position_id')->constrained('positions');
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->string('employee_code', 30)->unique();
            $table->string('full_name', 150);
            $table->enum('gender', ['male', 'female', 'other']);
            $table->date('date_of_birth');
            $table->string('phone', 30);
            $table->string('address', 500);
            $table->string('citizen_id', 30)->unique();
            $table->date('hire_date');
            $table->enum('status', ['probation', 'active', 'resigned'])->default('probation');
            $table->timestamps();

            $table->foreign('manager_id')
                  ->references('id')
                  ->on('employees')
                  ->nullOnDelete();

            $table->index('position_id', 'idx_employees_position');
            $table->index('manager_id', 'idx_employees_manager');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
