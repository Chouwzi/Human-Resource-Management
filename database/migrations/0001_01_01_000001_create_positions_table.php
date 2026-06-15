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
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained('departments');
            $table->string('name', 150);
            $table->string('description', 255)->nullable();
            $table->decimal('default_salary', 15, 2)->default(0);
            $table->timestamps();

            $table->unique(['department_id', 'name'], 'uq_positions_department_name');
            $table->index('department_id', 'idx_positions_department');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('positions');
    }
};
