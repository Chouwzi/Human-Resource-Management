# Task 1: Validate chấm công thủ công admin — check_in < check_out

**Files to modify:**
- `app/Http/Controllers/AdminHrmController.php` — method `storeAttendance`

**Problem:**
Admin nhập check_in = check_out = 00:59, hệ thống chấp nhận, worked_minutes = 0, hiển thị "Đúng giờ (Về sớm)" — sai logic.

**Requirements:**
Trong `storeAttendance`, sau khi parse `check_in_at` và `check_out_at`, thêm:
- Validate: nếu có cả check_in và check_out, check_out phải sau check_in ít nhất 1 phút.
- Nếu lte (lớn hơn hoặc bằng check-in, tức là check-out <= check-in), redirect back với `error` và input cũ:
  ```php
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
