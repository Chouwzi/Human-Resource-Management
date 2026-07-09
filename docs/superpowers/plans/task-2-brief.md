# Task 2: Fix badge trạng thái nhân viên — active/probation -> tiếng Việt

**Files to modify:**
- `resources/views/admin/hrm/employees.blade.php`

**Problem:**
Trang `/admin/employees` hiển thị raw DB value `active`, `probation` thay vì "Đang làm", "Thử việc".

**Requirements:**
- Tìm đoạn render status trong bảng danh sách (phần `@forelse($employees)`), thay:
  ```blade
  {{ $emp->status }}
  ```
  bằng map có label tiếng Việt:
  ```blade
  @php
      $statusMap = [
          'active'    => ['class' => 'badge-success', 'text' => 'Đang làm'],
          'probation' => ['class' => 'badge-warning', 'text' => 'Thử việc'],
          'inactive'  => ['class' => 'badge-danger',  'text' => 'Đã nghỉ'],
      ];
      $s = $statusMap[$emp->status] ?? ['class' => '', 'text' => $emp->status];
  @endphp
  <span class="badge {{ $s['class'] }}">{{ $s['text'] }}</span>
  ```
- Kiểm tra hiển thị đúng tiếng Việt thay vì `active` / `probation`.
- Viết báo cáo `task-2-report.md`.
- Commit thay đổi: `fix(employees): display Vietnamese status labels instead of raw DB values`.
