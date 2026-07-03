# Checklist nộp bài cuối kỳ

## Chạy lại dự án từ thư mục sạch

- [ ] Clone repository từ GitHub.
- [ ] Chạy `composer install`.
- [ ] Copy `.env.example` thành `.env`.
- [ ] Chạy `php artisan key:generate`.
- [ ] Tạo database MySQL tên `hrm`.
- [ ] Chạy `php artisan migrate:fresh --seed`.
- [ ] Chạy `php artisan serve` và mở `http://127.0.0.1:8000`.

## Kiểm tra cấu hình và source

- [ ] `.env.example` có đủ cấu hình DB, session, cache, queue, mail log.
- [ ] Không commit `.env`.
- [ ] Không commit `vendor/`.
- [ ] Không commit file cache, log, runtime ngoài các file `.gitignore` placeholder.
- [ ] README có hướng dẫn chạy dự án và tài khoản demo.

## Kiểm tra demo chính

- [ ] Admin/HR đăng nhập được.
- [ ] Nhân viên đăng nhập được.
- [ ] Dashboard hiển thị được.
- [ ] CRUD nhân viên chạy được.
- [ ] Luồng nghỉ phép chạy được: gửi, duyệt, từ chối.
- [ ] Chấm công và bảng lương đơn giản có dữ liệu demo.
- [ ] Các trang chính không vỡ layout trên desktop và mobile cơ bản.

## Tài liệu nộp

- [ ] Link GitHub trỏ đúng repository.
- [ ] Slide có giới thiệu đề tài HRM và phạm vi đồ án.
- [ ] Slide có sơ đồ chức năng và database/ERD.
- [ ] Slide có phân công thành viên và mức độ hoàn thành.
- [ ] Có phần hạn chế và hướng phát triển.
