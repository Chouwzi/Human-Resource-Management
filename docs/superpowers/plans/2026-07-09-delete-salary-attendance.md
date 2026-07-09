# Delete Salary & Attendance Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Thêm Delete cho Salary và Attendance để đủ CRUD hoàn chỉnh trước demo.

**Architecture:** Theo pattern hiện tại của Contracts — thêm route DELETE, method destroy trong `AdminHrmController`, nút xóa trong table view dùng form POST với `@method('DELETE')`.

**Tech Stack:** Laravel 13.8, Blade templates, PHP 8.3

## Global Constraints

- Chỉ admin mới được xóa (middleware `require.role:admin` — giống contracts/departments)
- Dùng `@method('DELETE')` + `@csrf` trong form (không có JS fetch)
- Confirm trước khi xóa bằng `onclick="return confirm(...)"` — giống pattern contracts hiện tại
- Không thêm migration, không thay đổi model

---

### Task 1: Delete Salary

**Files:**
- Modify: `routes/web.php` — thêm route DELETE salary
- Modify: `app/Http/Controllers/AdminHrmController.php` — thêm `destroySalary`
- Modify: `resources/views/admin/hrm/salaries.blade.php` — thêm cột Actions + nút xóa

**Interfaces:**
- Consumes: `Salary` model (đã có), route group `middleware('require.role:admin')` (đã có ở dòng ~95 web.php)
- Produces: route `admin.salaries.destroy`, method `AdminHrmController::destroySalary(Salary $salary)`

- [ ] **Step 1: Thêm route DELETE vào web.php**

Mở `routes/web.php`, trong block `Route::prefix('admin')->name('admin.')->middleware('require.role:admin')`, sau dòng `Route::post('/salaries', ...)` thêm:

```php
Route::delete('/salaries/{salary}', [AdminHrmController::class, 'destroySalary'])->name('salaries.destroy');
```

- [ ] **Step 2: Thêm method destroySalary vào AdminHrmController**

Mở `app/Http/Controllers/AdminHrmController.php`, sau method `storeSalary` thêm:

```php
public function destroySalary(Salary $salary): RedirectResponse
{
    $salary->delete();

    return back()->with('success', 'Đã xóa bảng lương.');
}
```

- [ ] **Step 3: Thêm cột Actions và nút xóa vào salaries.blade.php**

Trong `resources/views/admin/hrm/salaries.blade.php`, sửa `<thead>`:

```html
<tr>
    <th>Tháng</th>
    <th>Nhân viên</th>
    <th>Gross</th>
    <th>Net</th>
    <th>Trạng thái</th>
    <th>Thao tác</th>
</tr>
```

Sửa mỗi `<tr>` trong `@forelse($salaries as $salary)`, thêm `<td>` cuối:

```html
<td>
    <div class="table-actions">
        <form method="POST" action="{{ route('admin.salaries.destroy', $salary) }}">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm" type="submit"
                onclick="return confirm('Xóa bảng lương tháng {{ $salary->month }}/{{ $salary->year }} của {{ $salary->employee->full_name }}?')">
                Xóa
            </button>
        </form>
    </div>
</td>
```

- [ ] **Step 4: Kiểm tra thủ công**

```
php artisan serve
```

Login admin → vào /admin/salaries → bấm Xóa → confirm dialog xuất hiện → xóa thành công → flash "Đã xóa bảng lương."

- [ ] **Step 5: Commit**

```bash
git add routes/web.php app/Http/Controllers/AdminHrmController.php resources/views/admin/hrm/salaries.blade.php
git commit -m "feat(salaries): add delete salary for admin"
```

---

### Task 2: Delete Attendance

**Files:**
- Modify: `routes/web.php` — thêm route DELETE attendance
- Modify: `app/Http/Controllers/AdminHrmController.php` — thêm `destroyAttendance`
- Modify: `resources/views/admin/hrm/attendance.blade.php` — thêm cột Actions + nút xóa

**Interfaces:**
- Consumes: `AttendanceLog` model (đã có), route group `middleware('require.role:admin')` (đã có)
- Produces: route `admin.attendance.destroy`, method `AdminHrmController::destroyAttendance(AttendanceLog $log)`

- [ ] **Step 1: Thêm route DELETE vào web.php**

Trong block `Route::prefix('admin')->name('admin.')->middleware('require.role:admin')`, thêm:

```php
Route::delete('/attendance/{log}', [AdminHrmController::class, 'destroyAttendance'])->name('attendance.destroy');
```

- [ ] **Step 2: Thêm method destroyAttendance vào AdminHrmController**

Sau method `storeAttendance` thêm:

```php
public function destroyAttendance(AttendanceLog $log): RedirectResponse
{
    $log->delete();

    return back()->with('success', 'Đã xóa bản ghi chấm công.');
}
```

- [ ] **Step 3: Thêm cột Actions vào attendance.blade.php**

Sửa `<thead>` trong `attendance.blade.php`:

```html
<tr>
    <th>Ngày</th>
    <th>Nhân viên</th>
    <th>Check-in</th>
    <th>Check-out</th>
    <th>Phút làm</th>
    <th>Tăng ca</th>
    <th>Trạng thái</th>
    <th>Thao tác</th>
</tr>
```

Trong `@forelse($logs as $log)`, thêm `<td>` cuối trước `</tr>`:

```html
<td>
    <div class="table-actions">
        <form method="POST" action="{{ route('admin.attendance.destroy', $log) }}">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm" type="submit"
                onclick="return confirm('Xóa chấm công ngày {{ date(\'d/m/Y\', strtotime($log->work_date)) }} của {{ $log->employee->full_name }}?')">
                Xóa
            </button>
        </form>
    </div>
</td>
```

- [ ] **Step 4: Kiểm tra thủ công**

```
php artisan serve
```

Login admin → vào /admin/attendance → bấm Xóa → confirm → xóa thành công → flash "Đã xóa bản ghi chấm công."

- [ ] **Step 5: Commit**

```bash
git add routes/web.php app/Http/Controllers/AdminHrmController.php resources/views/admin/hrm/attendance.blade.php
git commit -m "feat(attendance): add delete attendance log for admin"
```

---

### Task 3: Thêm cột chi tiết vào Salary table (optional, demo value cao)

**Files:**
- Modify: `resources/views/admin/hrm/salaries.blade.php` — thêm cột lương cơ bản, phụ cấp, thưởng, khấu trừ

**Interfaces:**
- Consumes: `$salary->base_salary`, `$salary->allowance`, `$salary->bonus`, `$salary->deduction` (đã có trong model/DB)
- Produces: table hiển thị breakdown lương đầy đủ

- [ ] **Step 1: Sửa thead**

```html
<tr>
    <th>Tháng</th>
    <th>Nhân viên</th>
    <th>Lương CB</th>
    <th>Phụ cấp</th>
    <th>Thưởng</th>
    <th>Khấu trừ</th>
    <th>Gross</th>
    <th>Net</th>
    <th>Trạng thái</th>
    <th>Thao tác</th>
</tr>
```

- [ ] **Step 2: Sửa tbody row**

```html
<tr>
    <td>{{ $salary->month }}/{{ $salary->year }}</td>
    <td>{{ $salary->employee->full_name }}</td>
    <td>{{ number_format($salary->base_salary) }}</td>
    <td>{{ number_format($salary->allowance) }}</td>
    <td>{{ number_format($salary->bonus) }}</td>
    <td>{{ number_format($salary->deduction) }}</td>
    <td>{{ number_format($salary->gross_salary) }} VND</td>
    <td><strong>{{ number_format($salary->net_salary) }} VND</strong></td>
    <td><span class="badge badge-{{ $salary->status === 'paid' ? 'success' : 'warning' }}">{{ $salary->status }}</span></td>
    <td>
        <div class="table-actions">
            <form method="POST" action="{{ route('admin.salaries.destroy', $salary) }}">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm" type="submit"
                    onclick="return confirm('Xóa bảng lương tháng {{ $salary->month }}/{{ $salary->year }} của {{ $salary->employee->full_name }}?')">
                    Xóa
                </button>
            </form>
        </div>
    </td>
</tr>
```

- [ ] **Step 3: Commit**

```bash
git add resources/views/admin/hrm/salaries.blade.php
git commit -m "feat(salaries): show salary breakdown columns in table"
```
