# Task 4: Fix route GET /login trả 405

**Files to modify:**
- `routes/web.php`

**Problem:**
Developer/user gõ `/login` nhận 405 Method Not Allowed. Route tên `login` trỏ `GET /` nhưng không có `GET /login`.

**Requirements:**
1. Mở `routes/web.php`, sau dòng `Route::get('/', ...)`, thêm:
   ```php
   // Redirect /login về trang đăng nhập thực tế (tránh 405 khi user gõ nhầm)
   Route::get('/login', fn() => redirect()->route('login'));
   ```
2. Test chuyển hướng từ `/login` về `/`.
3. Báo cáo bằng file `task-4-report.md`.
4. Commit: `fix(auth): add GET /login redirect to avoid 405 error`
