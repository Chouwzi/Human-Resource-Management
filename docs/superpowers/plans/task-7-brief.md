# Task 7: Thêm tab lịch sử nghỉ phép đã xử lý cho Admin/HR

**Files to modify:**
- `app/Http/Controllers/LeaveController.php` — method `pending`
- `resources/views/admin/leaves/pending.blade.php`

**Problem:**
`/admin/leaves/pending` chỉ thấy đơn pending, không có lịch sử đơn đã duyệt/từ chối. Admin không biết đã xử lý những đơn nào gần đây.

**Requirements:**
1. Cấu hình `pending()` trong `app/Http/Controllers/LeaveController.php` để lấy thêm danh sách lịch sử đơn đã xử lý (`approved`, `rejected`):
   ```php
   $processedLeaves = \App\Models\Leave::with('employee')
                       ->whereIn('status', ['approved', 'rejected'])
                       ->orderBy('updated_at', 'desc')
                       ->limit(50)
                       ->get();
   ```
   Đồng thời trả về view qua `compact('pendingLeaves', 'processedLeaves')`.
2. Trong `resources/views/admin/leaves/pending.blade.php`, hiển thị bảng lịch sử này sau bảng đơn chờ xử lý (với thông tin Nhân viên, Loại đơn, Thời gian nghỉ, Lý do và Trạng thái dạng Badge tiếng Việt "Đã duyệt" / "Từ chối").
3. Test layout và data hiển thị đúng logic nghỉ phép.
4. Ghi báo cáo `task-7-report.md`.
5. Commit: `feat(leaves): add processed leave history table for admin/HR`
