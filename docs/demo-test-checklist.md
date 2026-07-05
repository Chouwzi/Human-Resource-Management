# Checklist kiểm thử demo HRM

Tài khoản demo sau khi chạy `php artisan migrate:fresh --seed`:

- Admin: `admin@example.com` / `password`
- HR: `hr@example.com` / `password`
- Nhân viên: `employee@example.com` / `password`

## Luồng đăng nhập và phân quyền

- [ ] Khách chưa đăng nhập vào `/admin` phải bị chuyển về trang đăng nhập.
- [ ] Admin/HR đăng nhập thành công và vào dashboard quản trị.
- [ ] Nhân viên đăng nhập thành công và vào dashboard cá nhân.
- [ ] Nhân viên truy cập route admin phải bị chặn `403`.
- [ ] Đăng xuất xóa session và quay về trang đăng nhập.

## CRUD phòng ban, chức vụ, nhân viên

- [ ] Admin/HR tạo, sửa, xóa phòng ban chưa có chức vụ.
- [ ] Không xóa được phòng ban đang có chức vụ.
- [ ] Admin/HR tạo, sửa, xóa chức vụ chưa có nhân viên.
- [ ] Không xóa được chức vụ đang có nhân viên.
- [ ] Admin/HR tạo nhân viên với email, mã nhân viên, CCCD không trùng.
- [ ] Admin/HR tìm kiếm nhân viên theo tên, mã nhân viên hoặc CCCD.
- [ ] Admin/HR lọc nhân viên theo phòng ban.
- [ ] Khóa nhân viên chuyển trạng thái nhân viên sang `resigned` và user sang `locked`.

## Nghỉ phép

- [ ] Nhân viên gửi đơn nghỉ phép hợp lệ.
- [ ] Nhân viên không gửi được đơn có ngày kết thúc trước ngày bắt đầu.
- [ ] Nhân viên chỉ hủy hoặc xóa được đơn của chính mình.
- [ ] Admin/HR xem danh sách đơn chờ duyệt.
- [ ] Admin/HR duyệt hoặc từ chối đơn nghỉ phép.

## Chấm công

- [ ] Admin/HR nhập chấm công theo nhân viên và ngày làm việc.
- [ ] Không tạo trùng chấm công theo `employee_id + work_date`; thao tác sau cập nhật bản ghi cũ.
- [ ] Hệ thống tính `worked_minutes` và `overtime_minutes` đơn giản từ check-in/check-out.

## Bảng lương

- [ ] Admin/HR tạo bảng lương theo tháng/năm.
- [ ] Không tạo trùng bảng lương theo `employee_id + month + year`; thao tác sau cập nhật bản ghi cũ.
- [ ] Hệ thống tính gross/net theo công thức `base + allowance + bonus - deduction`.

## Ghi chú lỗi chặn demo

- MySQL local cần chạy trước khi migrate/test.
- Nếu `php artisan test` lỗi kết nối DB, kiểm tra lại `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` trong `.env`.
