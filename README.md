# Human Resource Management

Hệ thống quản lý nhân sự (HRM) sử dụng Laravel, PHP, MySQL, HTML, CSS và JavaScript.

## Công nghệ sử dụng

- Backend: PHP, Laravel.
- Database: MySQL.
- Frontend: Blade, HTML, CSS, JavaScript thuần.
- Package manager: Composer.

## Cấu trúc thư mục chính

```text
app/
  Http/Controllers/     Controller xử lý request
  Models/               Model Eloquent
bootstrap/              Cấu hình bootstrap của Laravel
config/                 Cấu hình ứng dụng, database, session, cache
database/
  migrations/           File tạo/sửa bảng database
  seeders/              Dữ liệu mẫu
public/                 Entry point web và tài nguyên public
resources/
  views/                Blade templates
routes/
  web.php               Route web
storage/                File runtime, log, cache
tests/                  Kiểm thử
```

## Yêu cầu môi trường

- PHP 8.3 trở lên.
- Composer.
- MySQL.
- Các extension PHP cần thiết cho Laravel.

## Cài đặt và chạy dự án

1. Cài dependencies PHP:

```bash
composer install
```

2. Tạo file môi trường:

```bash
cp .env.example .env
php artisan key:generate
```

Trên Windows PowerShell có thể dùng:

```powershell
Copy-Item .env.example .env
php artisan key:generate
```

3. Cấu hình database MySQL trong `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hrm
DB_USERNAME=root
DB_PASSWORD=
```

4. Chạy migration:

```bash
php artisan migrate
```

5. Chạy server local:

```bash
php artisan serve
```

Mặc định ứng dụng sẽ chạy tại:

```text
http://127.0.0.1:8000
```

## Quy ước phát triển

- Đặt controller trong `app/Http/Controllers`.
- Đặt model trong `app/Models`.
- Tạo migration cho mỗi thay đổi cấu trúc database.
- Giao diện dùng Blade trong `resources/views`.
- CSS và JavaScript thuần nên đặt trong `public/css` và `public/js` nếu cần load trực tiếp.
- Các request bất đồng bộ nên trả về JSON và được gọi bằng `fetch`.
- Không commit file `.env`, thư mục `vendor/`, cache hoặc file runtime.
