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
        Schema::create('leaves', function (Blueprint $table) {
        $table->id();
        $table->string('emp_id');       // Mã nhân viên
        $table->string('emp_name');     // Tên nhân viên
        $table->string('leave_type');    // Loại nghỉ phép (annual, sick, unpaid, personal)
        $table->date('start_date');     // Từ ngày
        $table->date('end_date');       // Đến ngày
        $table->integer('days');        // Tổng số ngày nghỉ
        $table->text('reason');         // Lý do nghỉ
        $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled'])->default('pending'); // Trạng thái
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
