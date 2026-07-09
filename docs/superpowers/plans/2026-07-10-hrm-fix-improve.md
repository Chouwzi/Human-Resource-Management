# HRM Fix & Improve Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Fix toàn bộ P0 bugs + bổ sung tính năng thiếu sót phát hiện qua browser test thực tế.

**Architecture:** Laravel monolith, session-based auth, Blade views, không có FE riêng. Mỗi fix là thay đổi nhỏ trong 1-2 file, không refactor cấu trúc.

**Tech Stack:** PHP 8.5 / Laravel 13, Blade templates, Carbon, MySQL

## Global Constraints

- Không thay đổi cấu trúc DB (không tạo migration mới trừ task nào ghi rõ)
- Giữ nguyên naming convention hiện tại (snake_case cho DB, camelCase cho methods)
- Tất cả text hiển thị dùng tiếng Việt
- Blade confirm dialog dùng `onclick="return confirm('...')"` — không thêm JS library mới
- Commit theo format: `fix(module): mô tả ngắn` hoặc `feat(module): mô tả ngắn`

---

### Task 1: Validate chấm công thủ công admin — check_in < check_out

**Files:**
- Modify: `app/Http/Controllers/AdminHrmController.php` — method `storeAttendance`

**Problem:** Admin nhập check_in = check_out = 00:59, hệ thống chấp nhận, worked_minutes = 0, hiển thị "Đúng giờ (Về sớm)" — sai logic.

- [ ] **Step 1: Đọc method storeAttendance**

```bash
grep -n "storeAttendance" app/Http/Controllers/AdminHrmController.php
```

Tìm đúng line number rồi đọc toàn bộ method.

- [ ] **Step 2: Thêm validation check_out > check_in**

Trong `storeAttendance`, sau khi parse `check_in_at` và `check_out_at`, thêm:

```php
// Validate: nếu có cả check_in và check_out, check_out phải sau check_in ít nhất 1 phút
if ($request->filled('check_in_at') && $request->filled('check_out_at')) {
    $checkIn  = \Carbon\Carbon::parse($request->work_date . ' ' . $request->check_in_at);
    $checkOut = \Carbon\Carbon::parse($request->work_date . ' ' . $request->check_out_at);
    if ($checkOut->lte($checkIn)) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Giờ check-out phải sau giờ check-in.');
    }
}
```

- [ ] **Step 3: Test thủ công**

Vào `/admin/attendance`, chọn nhân viên, nhập check_in = check_out = 08:00, bấm Lưu.
Expected: flash error "Giờ check-out phải sau giờ check-in.", không tạo record.

- [ ] **Step 4: Test valid case**

Nhập check_in = 08:00, check_out = 17:00, bấm Lưu.
Expected: tạo record thành công.

- [ ] **Step 5: Commit**

```bash
git add app/Http/Controllers/AdminHrmController.php
git commit -m "fix(attendance): validate check_out must be after check_in"
```

---

### Task 2: Fix badge trạng thái nhân viên — `active`/`probation` → tiếng Việt

**Files:**
- Modify: `resources/views/admin/hrm/employees.blade.php`

**Problem:** Trang `/admin/employees` hiển thị raw DB value `active`, `probation` thay vì "Đang làm", "Thử việc".

- [ ] **Step 1: Tìm chỗ render status trong employees view**

```bash
grep -n "status\|active\|probation\|inactive" resources/views/admin/hrm/employees.blade.php
```

- [ ] **Step 2: Thay raw status bằng map có label tiếng Việt**

Tìm đoạn render badge status trong bảng danh sách (phần `@forelse($employees`), thay:

```blade
{{-- TÌM đoạn tương tự: --}}
<span class="badge ...">{{ $emp->status }}</span>

{{-- THAY bằng: --}}
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

- [ ] **Step 3: Kiểm tra trên browser**

Vào `/admin/employees`. Expected: cột Trạng thái hiển thị "Đang làm" / "Thử việc" thay vì `active` / `probation`.

- [ ] **Step 4: Commit**

```bash
git add resources/views/admin/hrm/employees.blade.php
git commit -m "fix(employees): display Vietnamese status labels instead of raw DB values"
```

---

### Task 3: Hợp đồng hết hạn tự động hiển thị đúng trạng thái

**Files:**
- Modify: `app/Models/Contract.php` — thêm accessor `getDisplayStatusAttribute`
- Modify: `resources/views/admin/hrm/contracts.blade.php` — dùng accessor thay vì raw status

**Problem:** HD003 hết hạn 31/03/2026 nhưng DB status = `active`, hiển thị "Đang hiệu lực". Không có auto-expire.

- [ ] **Step 1: Thêm accessor vào Contract model**

Mở `app/Models/Contract.php`, thêm method sau `employee()`:

```php
public function getEffectiveStatusAttribute(): string
{
    if ($this->status === 'terminated') {
        return 'terminated';
    }
    if ($this->end_date && $this->end_date->isPast()) {
        return 'expired';
    }
    return $this->status;
}
```

Thêm `'end_date' => 'date'` đã có trong casts — không cần thêm.

- [ ] **Step 2: Update blade contracts để dùng effective_status**

Trong `resources/views/admin/hrm/contracts.blade.php`, tìm đoạn render badge trạng thái (phần `@forelse($contracts`):

```bash
grep -n "status\|hiệu lực\|expired\|badge" resources/views/admin/hrm/contracts.blade.php
```

Thay đoạn render status badge thành:

```blade
@php
    $contractStatusMap = [
        'active'     => ['class' => 'badge-success', 'text' => 'Đang hiệu lực'],
        'expired'    => ['class' => 'badge-danger',  'text' => 'Hết hạn'],
        'terminated' => ['class' => 'badge-warning', 'text' => 'Đã chấm dứt'],
    ];
    $cs = $contractStatusMap[$contract->effective_status] ?? ['class' => '', 'text' => $contract->effective_status];
@endphp
<span class="badge {{ $cs['class'] }}">{{ $cs['text'] }}</span>
```

- [ ] **Step 3: Test trên browser**

Vào `/admin/contracts`. HD003 (Hoàng Thế Đoàn, hết hạn 31/03/2026).
Expected: hiển thị badge đỏ "Hết hạn" thay vì "Đang hiệu lực".

- [ ] **Step 4: Commit**

```bash
git add app/Models/Contract.php resources/views/admin/hrm/contracts.blade.php
git commit -m "fix(contracts): auto-detect expired contracts using end_date accessor"
```

---

### Task 4: Fix route GET /login trả 405

**Files:**
- Modify: `routes/web.php`

**Problem:** Developer/user gõ `/login` nhận 405 Method Not Allowed. Route tên `login` trỏ `GET /` nhưng không có `GET /login`.

- [ ] **Step 1: Thêm redirect route**

Mở `routes/web.php`, sau dòng `Route::get('/', ...)`, thêm:

```php
// Redirect /login về trang đăng nhập thực tế (tránh 405 khi user gõ nhầm)
Route::get('/login', fn() => redirect()->route('login'));
```

- [ ] **Step 2: Test**

Truy cập `http://127.0.0.1:8000/login`.
Expected: redirect về `/` không lỗi.

- [ ] **Step 3: Commit**

```bash
git add routes/web.php
git commit -m "fix(auth): add GET /login redirect to avoid 405 error"
```

---

### Task 5: Thêm link Positions vào sidebar Admin và HR

**Files:**
- Modify: `resources/views/layouts/app.blade.php`

**Problem:** `/admin/positions` tồn tại và có dữ liệu nhưng không có link trong sidebar — không thể navigate tới nếu không biết URL.

- [ ] **Step 1: Tìm sidebar trong layout**

```bash
grep -n "departments\|sidebar\|nav" resources/views/layouts/app.blade.php | head -30
```

- [ ] **Step 2: Thêm link Positions vào sidebar sau Cơ cấu tổ chức**

Trong phần sidebar dành cho admin/hr (tìm đoạn `admin/departments`), thêm link:

```blade
{{-- Thêm ngay sau link Cơ cấu tổ chức --}}
<a href="{{ route('admin.positions.index') }}" class="nav-link {{ request()->is('admin/positions*') ? 'active' : '' }}">
    <i class="fas fa-briefcase"></i>
    <span>Chức vụ</span>
</a>
```

- [ ] **Step 3: Test**

Đăng nhập admin, kiểm tra sidebar có link "Chức vụ". Click vào, vào được `/admin/positions`.
Đăng nhập HR, kiểm tra sidebar cũng thấy link "Chức vụ".

- [ ] **Step 4: Commit**

```bash
git add resources/views/layouts/app.blade.php
git commit -m "feat(nav): add Positions link to admin and HR sidebar"
```

---

### Task 6: Thêm trang hợp đồng cá nhân cho Employee

**Files:**
- Create: `resources/views/user/contracts/index.blade.php`
- Modify: `routes/web.php` — thêm route `GET /contracts`
- Modify: `app/Http/Controllers/SalaryController.php` — thêm method `contracts` (hoặc tạo controller riêng nếu file quá dài)
- Modify: `resources/views/layouts/app.blade.php` — thêm link vào sidebar employee

**Problem:** Employee không xem được hợp đồng của mình, không có route `/contracts` cho role employee.

- [ ] **Step 1: Thêm method contracts vào SalaryController**

Mở `app/Http/Controllers/SalaryController.php`, thêm method:

```php
public function contracts()
{
    $employee = \App\Models\Employee::where('user_id', session('user_id'))->first();
    if (!$employee) {
        return redirect()->back()->with('error', 'Không tìm thấy hồ sơ nhân sự!');
    }
    $contracts = \App\Models\Contract::where('employee_id', $employee->id)
                    ->orderBy('start_date', 'desc')
                    ->get();
    return view('user.contracts.index', compact('contracts', 'employee'));
}
```

- [ ] **Step 2: Thêm route**

Trong `routes/web.php`, trong group `require.role:employee`, thêm:

```php
Route::get('/contracts', [SalaryController::class, 'contracts'])->name('user.contracts.index');
```

- [ ] **Step 3: Tạo view**

Tạo file `resources/views/user/contracts/index.blade.php`:

```blade
@extends('layouts.app')

@section('title', 'Hợp đồng của tôi')
@section('header_title', 'Hợp đồng cá nhân')

@section('content')
<div class="content-card">
    <h4 class="content-card-header">Danh sách hợp đồng</h4>
    <div class="table-responsive m-0">
        <table class="table">
            <thead>
                <tr>
                    <th>Mã HĐ</th>
                    <th>Loại</th>
                    <th>Thời hạn</th>
                    <th>Lương</th>
                    <th>Giờ/tuần</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contracts as $contract)
                @php
                    $statusMap = [
                        'active'     => ['class' => 'badge-success', 'text' => 'Đang hiệu lực'],
                        'expired'    => ['class' => 'badge-danger',  'text' => 'Hết hạn'],
                        'terminated' => ['class' => 'badge-warning', 'text' => 'Đã chấm dứt'],
                    ];
                    $cs = $statusMap[$contract->effective_status] ?? ['class' => '', 'text' => $contract->effective_status];
                    $typeMap = [
                        'probation'  => 'Thử việc',
                        'fixed_term' => 'Có thời hạn',
                        'indefinite' => 'Không xác định thời hạn',
                    ];
                @endphp
                <tr>
                    <td><strong>{{ $contract->contract_code }}</strong></td>
                    <td>{{ $typeMap[$contract->contract_type] ?? $contract->contract_type }}</td>
                    <td>
                        {{ $contract->start_date->format('d/m/Y') }}
                        @if($contract->end_date) — {{ $contract->end_date->format('d/m/Y') }} @endif
                    </td>
                    <td>{{ number_format($contract->salary) }} VND</td>
                    <td>{{ number_format($contract->working_hours_per_week, 0) }}</td>
                    <td><span class="badge {{ $cs['class'] }}">{{ $cs['text'] }}</span></td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center">Chưa có hợp đồng nào.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('styles')
@include('admin.hrm.partials.styles')
@endpush
```

- [ ] **Step 4: Thêm link vào sidebar employee**

Trong `resources/views/layouts/app.blade.php`, phần sidebar employee, thêm:

```blade
<a href="{{ route('user.contracts.index') }}" class="nav-link {{ request()->is('contracts*') ? 'active' : '' }}">
    <i class="fas fa-file-contract"></i>
    <span>Hợp đồng</span>
</a>
```

- [ ] **Step 5: Test**

Đăng nhập `employee@example.com`, kiểm tra sidebar thấy link "Hợp đồng", click vào thấy danh sách hợp đồng của NV002.

- [ ] **Step 6: Commit**

```bash
git add routes/web.php \
        app/Http/Controllers/SalaryController.php \
        resources/views/user/contracts/index.blade.php \
        resources/views/layouts/app.blade.php
git commit -m "feat(employee): add personal contracts view at /contracts"
```

---

### Task 7: Thêm tab lịch sử nghỉ phép đã xử lý cho Admin/HR

**Files:**
- Modify: `resources/views/admin/leaves/pending.blade.php`
- Modify: `app/Http/Controllers/LeaveController.php` — method `pending` thêm query lịch sử

**Problem:** `/admin/leaves/pending` chỉ thấy đơn pending, không có lịch sử. Admin không biết đã duyệt/từ chối những đơn nào.

- [ ] **Step 1: Cập nhật LeaveController::pending để load thêm lịch sử**

Mở `app/Http/Controllers/LeaveController.php`, tìm method `pending`, thêm variable `$processedLeaves`:

```php
public function pending()
{
    $pendingLeaves = \App\Models\Leave::with('employee')
                        ->where('status', 'pending')
                        ->orderBy('created_at', 'desc')
                        ->get();

    $processedLeaves = \App\Models\Leave::with('employee')
                        ->whereIn('status', ['approved', 'rejected'])
                        ->orderBy('updated_at', 'desc')
                        ->limit(50)
                        ->get();

    return view('admin.leaves.pending', compact('pendingLeaves', 'processedLeaves'));
}
```

- [ ] **Step 2: Cập nhật view thêm bảng lịch sử**

Trong `resources/views/admin/leaves/pending.blade.php`, sau bảng đơn chờ xử lý, thêm:

```blade
<div class="content-card" style="margin-top: 2rem;">
    <h4 class="content-card-header">Lịch sử đã xử lý (50 gần nhất)</h4>
    <div class="table-responsive m-0">
        <table class="table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Nhân viên</th>
                    <th>Loại đơn</th>
                    <th>Thời gian</th>
                    <th>Lý do</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                @forelse($processedLeaves as $i => $leave)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>
                        <strong>{{ $leave->employee->full_name ?? 'N/A' }}</strong>
                    </td>
                    <td><strong>{{ $leave->leave_type }}</strong></td>
                    <td>
                        {{ $leave->start_date }} → {{ $leave->end_date }}
                    </td>
                    <td>{{ $leave->reason }}</td>
                    <td>
                        @if($leave->status === 'approved')
                            <span class="badge badge-success">Đã duyệt</span>
                        @else
                            <span class="badge badge-danger">Từ chối</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center">Chưa có lịch sử xử lý.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
```

- [ ] **Step 3: Test**

Vào `/admin/leaves/pending`. Expected: thấy 2 bảng — "Đơn chờ xử lý" và "Lịch sử đã xử lý".

- [ ] **Step 4: Commit**

```bash
git add app/Http/Controllers/LeaveController.php \
        resources/views/admin/leaves/pending.blade.php
git commit -m "feat(leaves): add processed leave history table for admin/HR"
```

---

### Task 8: Export chấm công CSV cho Admin

**Files:**
- Modify: `routes/web.php` — thêm route export
- Modify: `app/Http/Controllers/AdminHrmController.php` — thêm method `exportAttendance`
- Modify: `resources/views/admin/hrm/attendance.blade.php` — thêm nút Export

**Problem:** Không có cách xuất dữ liệu chấm công ra ngoài hệ thống.

- [ ] **Step 1: Thêm route export**

Trong `routes/web.php`, trong group `require.role:admin` (prefix `admin`), thêm:

```php
Route::get('/attendance/export', [AdminHrmController::class, 'exportAttendance'])->name('admin.attendance.export');
```

- [ ] **Step 2: Thêm method exportAttendance vào AdminHrmController**

```php
public function exportAttendance(Request $request)
{
    $month = $request->input('month', date('m'));
    $year  = $request->input('year', date('Y'));

    $logs = \App\Models\AttendanceLog::with('employee')
                ->whereMonth('work_date', $month)
                ->whereYear('work_date', $year)
                ->orderBy('work_date')
                ->get();

    $filename = "chamcong_{$year}_{$month}.csv";

    $headers = [
        'Content-Type'        => 'text/csv; charset=UTF-8',
        'Content-Disposition' => "attachment; filename=\"{$filename}\"",
    ];

    $callback = function () use ($logs) {
        $file = fopen('php://output', 'w');
        // BOM for Excel UTF-8
        fputs($file, "\xEF\xBB\xBF");
        fputcsv($file, ['Ngày', 'Mã NV', 'Họ tên', 'Check-in', 'Check-out', 'Phút làm', 'Tăng ca', 'Trạng thái', 'Ghi chú']);

        $statusMap = [
            'present' => 'Có mặt',
            'late'    => 'Đi muộn',
            'absent'  => 'Vắng',
            'leave'   => 'Nghỉ phép',
        ];

        foreach ($logs as $log) {
            fputcsv($file, [
                date('d/m/Y', strtotime($log->work_date)),
                $log->employee->employee_code ?? '',
                $log->employee->full_name ?? '',
                $log->check_in_at  ? \Carbon\Carbon::parse($log->check_in_at)->format('H:i')  : '',
                $log->check_out_at ? \Carbon\Carbon::parse($log->check_out_at)->format('H:i') : '',
                $log->worked_minutes,
                $log->overtime_minutes,
                $statusMap[$log->status] ?? $log->status,
                $log->note ?? '',
            ]);
        }
        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
```

- [ ] **Step 3: Thêm nút Export vào view attendance**

Trong `resources/views/admin/hrm/attendance.blade.php`, cạnh nút "Chốt công hôm nay", thêm:

```blade
<a href="{{ route('admin.attendance.export', ['month' => $month, 'year' => now()->year]) }}"
   class="btn btn-secondary">
    <i class="fas fa-download"></i> Xuất CSV
</a>
```

- [ ] **Step 4: Test**

Vào `/admin/attendance`, click "Xuất CSV". Expected: tải về file `.csv` mở được bằng Excel đúng tiếng Việt.

- [ ] **Step 5: Commit**

```bash
git add routes/web.php \
        app/Http/Controllers/AdminHrmController.php \
        resources/views/admin/hrm/attendance.blade.php
git commit -m "feat(attendance): add CSV export for admin"
```

---

## Self-Review

**Spec coverage:**
- ✅ Task 1: validate check_in < check_out
- ✅ Task 2: label trạng thái nhân viên
- ✅ Task 3: hợp đồng hết hạn auto-detect
- ✅ Task 4: route /login 405
- ✅ Task 5: link Positions sidebar
- ✅ Task 6: employee xem hợp đồng cá nhân
- ✅ Task 7: lịch sử nghỉ phép
- ✅ Task 8: export CSV chấm công

**Chưa implement trong plan này (để sprint sau):**
- Pagination danh sách nhân viên/chấm công
- Cảnh báo hợp đồng sắp hết hạn trên dashboard
- Sửa bảng lương (thiếu nút Sửa)

**Placeholder scan:** Không có TBD, mỗi step đều có code cụ thể.

**Type consistency:** Method `effective_status` accessor định nghĩa ở Task 3, dùng lại đúng ở Task 6 (`$contract->effective_status`).
