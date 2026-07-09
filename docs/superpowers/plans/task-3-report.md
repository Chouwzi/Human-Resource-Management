# Báo cáo kết quả thực hiện Task 3

## 1. Yêu cầu & Thiết kế
- Thêm thuộc tính động `effective_status` (accessor) vào model `Contract` để tự động xác định trạng thái thực tế dựa trên ngày kết thúc (`end_date`) và trạng thái gốc (`status`).
- Trạng thái `terminated` (đã chấm chấm dứt) luôn được giữ nguyên.
- Trạng thái `active` có ngày kết thúc `end_date` đã qua sẽ tự động chuyển thành `expired` (hết hạn).
- Hiển thị badge trạng thái chính xác trên giao diện quản trị hợp đồng dùng accessor này.

## 2. Chi tiết triển khai
- **Model `app/Models/Contract.php`**: Thêm method `getEffectiveStatusAttribute`.
- **View `resources/views/admin/hrm/contracts.blade.php`**: Chuyển sang đọc `$contract->effective_status`, hiển thị màu badge tương ứng:
  - `active` -> lá cây (`badge-success`)
  - `expired` -> đỏ (`badge-danger`)
  - `terminated` -> vàng (`badge-warning`)

## 3. Kết quả kiểm thử
- Bổ sung unit/feature test `accessor_trang_thai_khoa_qua_han_dung_logic` vào `tests/Feature/ContractControllerTest.php`.
- Chạy PHPUnit: tất cả 5/5 bài test thành công, đạt 16 assertions qua bộ lọc `ContractControllerTest`.
