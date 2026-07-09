# Báo cáo kết quả thực hiện Task 7: Thêm tab lịch sử nghỉ phép đã xử lý cho Admin/HR

## Chi tiết thay đổi

1. **app/Models/Leave.php**
   - Thêm quan hệ `employee()` dạng `belongsTo` từ Model `Leave` sang Model `Employee` thông qua khoá ngoại `emp_id` liên kết với trường `user_id` trên bảng `employees`. Việc này hỗ trợ eager loading thông tin nhân sự.

2. **app/Http/Controllers/LeaveController.php**
   - Cập nhật phương thức `pending()` nhằm truy vấn thêm danh sách lịch sử các đơn nghỉ phép đã xử lý (`approved`, `rejected`), sắp xếp theo thời gian cập nhật mới nhất (`updated_at` giảm dần), giới hạn tối đa 50 bản ghi.
   - Truy xuất hồ sơ nhân sự đi kèm thông qua eager loading `with('employee')`.
   - Chuyển biến `$processedLeaves` xuống view `admin.leaves.pending` qua hàm `compact`.

3. **resources/views/admin/leaves/pending.blade.php**
   - Bổ sung thêm card danh sách "Lịch sử đơn đã xử lý" hiển thị ngay bên dưới danh sách đơn chờ duyệt.
   - Thể hiện đầy đủ các thông tin: Mã nhân viên, Họ và tên nhân viên, Loại đơn nghỉ phép (đã Việt hóa), Thời gian nghỉ phép, Số ngày nghỉ phép, Lý do nghỉ phép và badge trạng thái phân loại rõ ràng (Đã duyệt / Từ chối) cũng như thông tin người duyệt (`approved_by`) sau khi được xử lý.

4. **Kiểm thử tự động**
   - Bổ sung 2 test case mới vào `tests/Feature/LeaveControllerTest.php`:
     - `admin_xem_duoc_don_cho_duyet_va_lich_su_da_xu_ly`: Xác thực người quản trị khi truy cập `/admin/leaves/pending` có thể hiển thị cả đơn chờ duyệt cùng danh sách các đơn đã duyệt và từ chối một cách chính xác.
     - `unit_leave_relationship_employee`: Kiểm tra tính toàn vẹn của quan hệ `employee` trên model `Leave`.

## Kết quả kiểm thử
- Chạy toàn bộ các test cases thành công:
  - Tổng số: 36 tests
  - Số lượng assertions: 118
  - Trạng thái: Passed 100%

## Rà soát mã nguồn bổ sung
- Mọi chức năng vận hành mượt mà, đúng yêu cầu nghiệp vụ quản lý nghỉ phép của phòng ban nhân sự.
