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
        Schema::create('attendances', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('employee_id');
        $table->date('work_date'); // Ngày chấm công (Y-m-d)
        $table->time('check_in')->nullable();
        $table->time('check_out')->nullable();
        $table->integer('worked_minutes')->default(0); // Số phút làm việc chính thức
        $table->integer('overtime_minutes')->default(0); // Số phút tăng ca
        
        // Các trạng thái: present (đúng giờ), late (đi muộn), early_leave (về sớm), absent (vắng)
        $table->string('status')->default('present'); 
        $table->timestamps();

        //  CHẶN TRÙNG: Mỗi nhân viên chỉ có duy nhất 1 bản ghi mỗi ngày
        $table->unique(['employee_id', 'work_date']);
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
