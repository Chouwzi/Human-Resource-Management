# Báo cáo kết quả thực hiện Task 6: Thêm trang hợp đồng cá nhân cho Employee

## Chi tiết thay đổi

1. **app/Http/Controllers/SalaryController.php**
   - Thêm phương thức `contracts()` để tìm hồ sơ nhân sự của tài khoản hiện tại, lấy danh sách tất cả các hợp đồng lao động đã ký xếp theo thứ tự ngày bắt đầu mới nhất trước, và trả về view `user.contracts.index`.
   - Nếu không tìm thấy hồ sơ nhân sự thì trả về trang trước kèm theo cảnh báo lỗi.

2. **routes/web.php**
   - Thêm route `GET /contracts` định danh là `user.contracts.index` nằm trong nhóm middleware `require.role:employee` để nhân viên của công ty có thể xem được danh sách hợp đồng cá nhân.

3. **resources/views/user/contracts/index.blade.php** (Tạo mới)
   - Tạo biểu mẫu hiển thị bao gồm: Thông tin nhân sự cá nhân (Mã nhân viên, họ tên, chức vụ).
   - Danh sách bảng hợp đồng lao động: Mã hợp đồng, loại hợp đồng (Thử việc, Có thời hạn, Không xác định thời hạn), ngày bắt đầu, ngày kết thúc, mức lương thỏa thuận, số giờ làm việc trên tuần và trạng thái hiệu lực (sử dụng thuộc tính `effective_status` tự động cập nhật).

4. **resources/views/layouts/app.blade.php**
   - Thêm đường dẫn "Hợp đồng" vào menu thành viên khi đăng nhập ở vai trò **Nhân viên**.

5. **Kiểm thử tự động**
   - Bổ sung các test case trong `tests/Feature/ContractControllerTest.php`:
     - Kiểm tra tài khoản vai trò **Nhân viên** chỉ có thể xem được thông tin chi tiết và danh sách hợp đồng của chính mình, không xem được hợp đồng của người khác.
     - Kiểm tra tài khoản vai trò **Admin** và **HR** không xem được route hiển thị hợp đồng cá nhân này (Tránh nhầm lẫn với phân hệ Quản lý).

## Kết quả kiểm thử
- Chạy PHPUnit thành công tất cả 34 test cases (110 assertions), bao gồm cả các test mới bổ sung cho chức năng xem và bảo mật hợp đồng cá nhân.

## Rà soát mã nguồn bổ sung
- Tất cả chức năng hoạt động chính xác theo yêu cầu dự án. Luồng đăng nhập và kiểm soát quyền hạn được bảo đảm chặt chẽ.
