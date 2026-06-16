# Quy tắc làm việc nhóm — HRM Project

## Mục lục

- [1. Gitflow](#1-gitflow)
- [2. Quy tắc đặt tên branch](#2-quy-tắc-đặt-tên-branch)
- [3. Quy tắc commit message](#3-quy-tắc-commit-message)
- [4. Quy trình Issue → PR → Merge](#4-quy-trình-issue--pr--merge)
- [5. Quy tắc đặt tên code (Laravel)](#5-quy-tắc-đặt-tên-code-laravel)
- [6. Quy tắc database](#6-quy-tắc-database)
- [7. Quy tắc chung](#7-quy-tắc-chung)

---

## 1. Gitflow

### Sơ đồ nhánh

```
main ────────────────────────────────────── production (ổn định)
  │
  └── develop ───────────────────────────── tích hợp code nhóm
        │
        ├── feature/1-core-database ──────── tính năng mới
        ├── feature/2-auth-login ─────────── tính năng mới
        └── hotfix/fix-login-crash ───────── sửa lỗi khẩn cấp
```

### Mô tả các nhánh

| Nhánh | Mục đích | Tạo từ | Merge vào |
|-------|----------|--------|-----------|
| `main` | Code ổn định, đã kiểm tra | — | — |
| `develop` | Tích hợp tất cả feature | `main` | `main` |
| `feature/*` | Phát triển tính năng mới | `develop` | `develop` |
| `hotfix/*` | Sửa lỗi khẩn cấp trên production | `main` | `main` + `develop` |

### Quy trình làm việc

```bash
# 1. Lấy code mới nhất
git checkout develop
git pull origin develop

# 2. Tạo nhánh feature
git checkout -b feature/<issue-number>-<mô-tả-ngắn>

# 3. Code và commit (nhiều commit nhỏ)
git add .
git commit -m "feat(scope): mô tả thay đổi"

# 4. Push và tạo Pull Request
git push origin feature/<issue-number>-<mô-tả-ngắn>
# Lên GitHub tạo PR vào develop

# 5. Sau khi PR được review → merge vào develop
# 6. Khi develop ổn định → merge vào main
```

---

## 2. Quy tắc đặt tên branch

### Format

```
<loại>/<số-issue>-<mô-tả-ngắn-bằng-tiếng-anh>
```

### Ví dụ

| ✅ Đúng | ❌ Sai |
|---------|--------|
| `feature/1-core-database-schema` | `feature1` |
| `feature/2-auth-login-logout-role` | `new-branch` |
| `feature/14-business-database` | `database` |
| `hotfix/fix-login-crash` | `fix` |

### Quy tắc

- Dùng **chữ thường**, phân cách bằng **dấu gạch ngang** (`-`).
- Bắt đầu bằng `feature/`, `hotfix/`, hoặc `bugfix/`.
- Gắn **số issue** ngay sau `/` để dễ truy vết.
- Mô tả ngắn gọn, **2-4 từ tiếng Anh**.

---

## 3. Quy tắc commit message

### Format — Conventional Commits

```
<type>(<scope>): <mô tả ngắn>

[body — giải thích chi tiết nếu cần]

[footer — Closes #issue_number]
```

### Các type cho phép

| Type | Khi nào dùng | Ví dụ |
|------|-------------|-------|
| `feat` | Thêm tính năng mới | `feat(db): add employees migration` |
| `fix` | Sửa lỗi | `fix(auth): handle null user on login` |
| `docs` | Thay đổi tài liệu | `docs: update README setup guide` |
| `style` | Format code, không đổi logic | `style: fix indentation in UserController` |
| `refactor` | Tái cấu trúc, không đổi hành vi | `refactor(auth): extract validation logic` |
| `test` | Thêm/sửa test | `test(auth): add login unit tests` |
| `chore` | Cấu hình, tooling, CI/CD | `chore: update .env.example` |

### Quy tắc

- Dòng đầu **không quá 72 ký tự**.
- Dùng **tiếng Anh**, viết **thường** chữ cái đầu mô tả.
- Dùng **thì hiện tại**: `add`, `fix`, `update` (không dùng `added`, `fixed`).
- Scope trong ngoặc `()` là phần module liên quan: `db`, `auth`, `employee`, `ui`...
- Dòng cuối ghi `Closes #<số>` để auto-close issue khi merge vào `main`.

### Ví dụ commit đầy đủ

```
feat(db): add core database migrations for roles, users, employees

- Create roles migration: id, name (unique), description
- Rewrite users migration: role_id FK, email, password, status enum
- Create employees migration: self-reference manager_id

Closes #1
```

---

## 4. Quy trình Issue → PR → Merge

### Bước 1: Nhận issue

- Mỗi thành viên được assign issue trên GitHub.
- Đọc kỹ **phạm vi** và **tiêu chí hoàn thành** trong issue.
- Một issue = một branch = một PR.

### Bước 2: Tạo branch và làm việc

```bash
git checkout develop
git pull origin develop
git checkout -b feature/<issue-number>-<mô-tả>
```

### Bước 3: Tạo Pull Request

- PR title: copy tên issue, ví dụ: `[BE1] Database cốt lõi: roles, users, departments, positions, employees`.
- PR description: mô tả những gì đã làm, checklist, screenshot nếu có UI.
- Target branch: **`develop`** (không phải `main`).
- Gắn label tương ứng nếu có.

### Bước 4: Review và Merge

- **Tối thiểu 1 người review** trước khi merge.
- Người review kiểm tra: code chạy được, đúng convention, đúng scope issue.
- Sau khi approve → **Squash and Merge** hoặc **Merge commit**.
- Xoá branch sau khi merge.

---

## 5. Quy tắc đặt tên code (Laravel)

### Model

| Thành phần | Quy tắc | Ví dụ |
|-----------|---------|-------|
| Model class | **Số ít, PascalCase** | `Employee`, `LeaveRequest` |
| Bảng DB | **Số nhiều, snake_case** | `employees`, `leave_requests` |
| Migration | `create_<bảng>_table` | `create_employees_table` |
| Factory | `<Model>Factory` | `EmployeeFactory` |
| Seeder | `<Model>Seeder` | `EmployeeSeeder` |

### Controller

| Quy tắc | Ví dụ |
|---------|-------|
| **Số ít, PascalCase + Controller** | `EmployeeController` |
| Method CRUD theo Laravel resource | `index`, `create`, `store`, `show`, `edit`, `update`, `destroy` |

### Route

```php
// Resource route — sinh đầy đủ 7 route CRUD
Route::resource('employees', EmployeeController::class);

// Route đặt tên rõ ràng
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
```

### View (Blade)

| Quy tắc | Ví dụ |
|---------|-------|
| Thư mục = tên resource (số nhiều) | `resources/views/employees/` |
| File = tên action | `index.blade.php`, `create.blade.php`, `edit.blade.php` |
| Layout chung | `resources/views/layouts/app.blade.php` |
| Component | `resources/views/components/` |

### Biến và Method

| Loại | Quy tắc | Ví dụ |
|------|---------|-------|
| Biến | **camelCase** | `$employeeCode`, `$totalDays` |
| Method | **camelCase** | `getFullName()`, `calculateSalary()` |
| Constant | **UPPER_SNAKE_CASE** | `MAX_LEAVE_DAYS` |
| Relationship | Số ít/nhiều tùy quan hệ | `$employee->position` (belongsTo), `$department->positions` (hasMany) |

---

## 6. Quy tắc database

### Đặt tên

| Thành phần | Quy tắc | Ví dụ |
|-----------|---------|-------|
| Bảng | **Số nhiều, snake_case** | `employees`, `leave_requests` |
| Cột | **snake_case** | `full_name`, `date_of_birth` |
| Cột khoá ngoại | `<bảng_số_ít>_id` | `employee_id`, `department_id` |
| Cột boolean | Bắt đầu bằng `is_` hoặc `has_` | `is_paid`, `has_insurance` |
| Cột enum status | Đặt tên `status` | `status` với giá trị `active`, `locked` |
| Cột thời gian | Đuôi `_at` | `approved_at`, `paid_at` |

### Index

| Loại | Prefix | Ví dụ |
|------|--------|-------|
| Unique | `uq_` | `uq_positions_department_name` |
| Index thường | `idx_` | `idx_users_role` |
| Foreign key | Laravel tự đặt | `employees_user_id_foreign` |

### Migration

- Mỗi thay đổi schema = **một file migration riêng**.
- **Không sửa migration cũ** đã chạy trên máy người khác — tạo migration mới.
- Luôn viết cả `up()` và `down()`.
- Test bằng `php artisan migrate:fresh` trước khi commit.

---

## 7. Quy tắc chung

### Không commit

- File `.env` (chứa thông tin nhạy cảm).
- Thư mục `vendor/` (dùng `composer install` để tải lại).
- Thư mục `node_modules/` nếu có.
- File runtime: `storage/logs/*`, `storage/framework/cache/*`.
- File IDE: `.idea/`, `.vscode/` (trừ settings chung nhóm).

### Code style

- Chạy `php artisan pint` trước khi commit để format code theo chuẩn Laravel.
- Không để code `dd()`, `dump()`, `var_dump()` trong commit.
- Comment bằng tiếng Việt hoặc tiếng Anh, **nhất quán trong một file**.

### Giao tiếp

- Cập nhật tiến độ trên **GitHub Issues**.
- Nếu bị block, comment lên issue hoặc báo nhóm ngay.
- Review PR trong **24 giờ** kể từ khi được assign review.

---

## Tóm tắt nhanh

```
Branch:   feature/<issue>-<mô-tả>
Commit:   feat(scope): mô tả ngắn
PR:       feature/* → develop → main
Tên bảng: snake_case, số nhiều
Tên model: PascalCase, số ít
Tên cột:  snake_case
Index:    idx_ hoặc uq_
```
