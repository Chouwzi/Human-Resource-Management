@extends('layouts.app')

@section('title', 'Chấm công')
@section('header_title', 'Quản lý chấm công')

@section('content')
@include('admin.hrm.partials.flash')

<div class="content-card">
    <h4 class="content-card-header">Nhập chấm công</h4>
    <form method="POST" action="{{ route('admin.attendance.store') }}" class="hrm-form hrm-form-grid">
        @csrf
        <div>
            <label>Nhân viên</label>
            <select name="employee_id" required>
                <option value="">-- Chọn nhân viên --</option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}" @selected(old('employee_id') == $employee->id)>{{ $employee->employee_code }} - {{ $employee->full_name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Ngày làm việc</label>
            <input name="work_date" type="date" value="{{ old('work_date', now()->toDateString()) }}" required>
        </div>
        <div>
            <label>Check-in</label>
            <input name="check_in_at" type="time" value="{{ old('check_in_at', '08:00') }}">
        </div>
        <div>
            <label>Check-out</label>
            <input name="check_out_at" type="time" value="{{ old('check_out_at', '17:00') }}">
        </div>
        <div>
            <label>Trạng thái</label>
            <select name="status" required>
                <option value="present">Có mặt</option>
                <option value="late">Đi muộn</option>
                <option value="absent">Vắng</option>
                <option value="leave">Nghỉ phép</option>
            </select>
        </div>
        <div>
            <label>Ghi chú</label>
            <input name="note" value="{{ old('note') }}" maxlength="255">
        </div>
        <div class="hrm-form-full">
            <button class="btn btn-primary" type="submit">Lưu chấm công</button>
        </div>
    </form>
</div>

<div class="content-card">
    <div class="content-card-header-flex">
        <h4>Bảng chấm công</h4>
        <div style="display: flex; gap: 1rem; align-items: center;">
            <!-- Nút Chốt công -->
            <form method="POST" action="{{ route('attendance.finalize') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="btn btn-secondary" onclick="return confirm('Chốt công cho ngày hôm nay?')">
                    <i class="fas fa-check-circle"></i> Chốt công hôm nay
                </button>
            </form>

            <!-- Nút Xuất CSV -->
            <a href="{{ route('admin.attendance.export', ['month' => $month, 'year' => $year]) }}" class="btn btn-primary">
                <i class="fas fa-file-csv"></i> Xuất CSV
            </a>

            <!-- Lọc theo tháng -->
            <form method="GET" action="{{ route('admin.attendance.index') }}" style="display: flex; align-items: center; gap: 0.5rem; margin: 0;">
                <select name="month" style="padding: 0.35rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                    @for($m=1; $m<=12; $m++)
                        <option value="{{ sprintf('%02d', $m) }}" @selected($month == $m)>Tháng {{ $m }}</option>
                    @endfor
                </select>
                <button type="submit" class="btn btn-secondary" style="padding: 0.35rem 0.75rem;">Lọc</button>
            </form>
        </div>
    </div>
    <div class="table-responsive m-0">
        <table class="table">
            <thead>
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
            </thead>
            <tbody>
                @forelse($logs as $log)
                @php
                    $statusMap = [
                        'present' => ['class' => 'badge-success', 'text' => 'Đúng giờ'],
                        'late'    => ['class' => 'badge-warning', 'text' => 'Đi muộn'],
                        'absent'  => ['class' => 'badge-danger', 'text' => 'Vắng mặt'],
                        'leave'   => ['class' => 'badge-info', 'text' => 'Nghỉ phép']
                    ];
                    $s = $statusMap[$log->status] ?? ['class' => '', 'text' => $log->status];
                @endphp
                <tr>
                    <td><strong>{{ date('d/m/Y', strtotime($log->work_date)) }}</strong></td>
                    <td>{{ $log->employee->full_name }}</td>
                    <td>{{ $log->check_in_at ? \Carbon\Carbon::parse($log->check_in_at)->format('H:i') : '-' }}</td>
                    <td>{{ $log->check_out_at ? \Carbon\Carbon::parse($log->check_out_at)->format('H:i') : '-' }}</td>
                    <td>{{ $log->worked_minutes }} phút</td>
                    <td style="color: var(--info);">{{ $log->overtime_minutes }} phút</td>
                    <td>
                        <span class="badge {{ $s['class'] }}">{{ $s['text'] }}</span>
                        @if($log->note)
                            <br><small style="color: var(--text-muted);">({{ $log->note }})</small>
                        @endif
                    </td>
                    <td>
                        <div class="table-actions">
                            <form method="POST" action="{{ route('admin.attendance.destroy', $log) }}">
                                @csrf
                                @method('DELETE')
                                @php $logDate = date('d/m/Y', strtotime($log->work_date)); @endphp
                                <button class="btn btn-danger btn-sm" type="submit"
                                    onclick="return confirm('Xóa chấm công ngày {{ $logDate }} của {{ $log->employee->full_name }}?')">
                                    Xóa
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center" style="color: var(--text-muted); padding: 2rem 0;">Chưa có dữ liệu chấm công.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('styles')
@include('admin.hrm.partials.styles')
<style>
.hrm-form-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
.hrm-form-full { grid-column: 1 / -1; }
@media (max-width: 900px) { .hrm-form-grid { grid-template-columns: 1fr; } }
</style>
@endpush
