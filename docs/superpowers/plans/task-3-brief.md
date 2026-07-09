# Task 3: Hợp đồng hết hạn tự động hiển thị đúng trạng thái

**Files to modify:**
- `app/Models/Contract.php` — thêm accessor `getEffectiveStatusAttribute`
- `resources/views/admin/hrm/contracts.blade.php` — dùng accessor thay vì raw status

**Requirements:**
1. Thêm accessor vào `app/Models/Contract.php`:
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
2. Cập nhật `resources/views/admin/hrm/contracts.blade.php` để dùng `effective_status`. Tìm đoạn render badge trạng thái (phần `@forelse($contracts`), thay thế bằng:
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
3. Chạy tests để đảm bảo không lỗi syntax hay logic.
4. Ghi báo cáo report `task-3-report.md`.
5. Commit: `fix(contracts): auto-detect expired contracts using end_date accessor`
