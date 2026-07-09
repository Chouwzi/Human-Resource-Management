# Task 6: Thêm trang hợp đồng cá nhân cho Employee

**Files to create:**
- `resources/views/user/contracts/index.blade.php`

**Files to modify:**
- `routes/web.php` — thêm route `GET /contracts` cho role `employee`
- `app/Http/Controllers/SalaryController.php` — thêm method `contracts`
- `resources/views/layouts/app.blade.php` — thêm link vào sidebar employee

**Requirements:**
1. Thêm method `contracts` vào `app/Http/Controllers/SalaryController.php`:
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
2. Thêm route `GET /contracts` vào `routes/web.php` trong group `require.role:employee`:
   ```php
   Route::get('/contracts', [SalaryController::class, 'contracts'])->name('user.contracts.index');
   ```
3. Tạo file `resources/views/user/contracts/index.blade.php` với bảng hiển thị danh sách hợp đồng (Mã HĐ, loại hợp đồng, thời hạn bắt đầu/kết thúc, mức lương, số giờ/tuần, trạng thái hiệu lực có dùng `effective_status` đã cài ở Task 3).
4. Thêm link vào sidebar employee trong `resources/views/layouts/app.blade.php`:
   ```blade
   <a href="{{ route('user.contracts.index') }}" class="nav-link {{ request()->is('contracts*') ? 'active' : '' }}">
       <i class="fas fa-file-contract"></i>
       <span>Hợp đồng</span>
   </a>
   ```
5. Test: tạo test case mới để kiểm duyệt Employee xem được hợp đồng của mình, và không xem được của người khác (auth/phân quyền).
6. Viết báo cáo `task-6-report.md`.
7. Commit: `feat(employee): add personal contracts view at /contracts`
