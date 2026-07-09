# Task 8: Export chấm công CSV cho Admin

**Files to modify:**
- `routes/web.php` — thêm route export
- `app/Http/Controllers/AdminHrmController.php` — thêm method `exportAttendance`
- `resources/views/admin/hrm/attendance.blade.php` — thêm nút Export

**Requirements:**
1. Thêm route export vào `routes/web.php` trong group `require.role:admin` (hoặc admin/hr prefix admin):
   ```php
   Route::get('/attendance/export', [AdminHrmController::class, 'exportAttendance'])->name('admin.attendance.export');
   ```
2. Thêm method `exportAttendance` vào `app/Http/Controllers/AdminHrmController.php` để lọc chấm công theo tháng, xuất ra file CSV với header UTF-8 BOM để Excel hiển thị được đúng tiếng Việt. Columns bao gồm: Ngày, Mã NV, Họ tên, Check-in, Check-out, Phút làm, Tăng ca, Trạng thái, Ghi chú.
3. Thêm nút "Xuất CSV" vào `resources/views/admin/hrm/attendance.blade.php`, nằm cạnh nút "Chốt công hôm nay". Truyền tham số `month` và `year` hiện tại.
4. Viết tests tự động để xác nhận route `/admin/attendance/export` chạy thành công, trả về stream CSV với các content-type/disposition headers chuẩn, người dùng bình thường không thể truy cập (phân quyền).
5. Ghi báo cáo report `task-8-report.md`.
6. Commit: `feat(attendance): add CSV export for admin`
