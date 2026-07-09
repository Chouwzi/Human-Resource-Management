# Task 5: Thêm link Positions vào sidebar Admin và HR

**Files to modify:**
- `resources/views/layouts/app.blade.php`

**Problem:**
`/admin/positions` tồn tại và có dữ liệu nhưng không có link trong sidebar — không thể navigate tới nếu không biết URL.

**Requirements:**
1. Tìm phần sidebar dành cho admin/hr trong `resources/views/layouts/app.blade.php`.
2. Thêm link "Positions" ngay sau link "Cơ cấu tổ chức" (admin/departments):
   ```blade
   <a href="{{ route('admin.positions.index') }}" class="nav-link {{ request()->is('admin/positions*') ? 'active' : '' }}">
       <i class="fas fa-briefcase"></i>
       <span>Chức vụ</span>
   </a>
   ```
3. Test layout hiển thị và compile chuẩn, không gây lỗi cú pháp.
4. Ghi báo cáo `task-5-report.md`.
5. Commit: `feat(nav): add Positions link to admin and HR sidebar`
