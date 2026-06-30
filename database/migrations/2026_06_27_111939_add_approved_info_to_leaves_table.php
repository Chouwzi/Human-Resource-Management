<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('leaves', function (Blueprint $table) {
        // Thêm cột lưu tên người duyệt và thời gian duyệt (cho phép null vì lúc mới tạo đơn chưa ai duyệt)
        $table->string('approved_by')->nullable()->after('status');
        $table->timestamp('approved_at')->nullable()->after('approved_by');
    });
}

public function down()
{
    Schema::table('leaves', function (Blueprint $table) {
        $table->dropColumn(['approved_by', 'approved_at']);
    });
}
};
