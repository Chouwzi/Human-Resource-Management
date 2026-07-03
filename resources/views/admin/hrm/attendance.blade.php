@extends('layouts.app')

@section('title', 'Chấm công')
@section('header_title', 'Quản Lý Chấm Công')

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
    <h4 class="content-card-header">Bảng chấm công</h4>
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
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td>{{ $log->work_date }}</td>
                    <td>{{ $log->employee->full_name }}</td>
                    <td>{{ $log->check_in_at ? \Carbon\Carbon::parse($log->check_in_at)->format('H:i') : '-' }}</td>
                    <td>{{ $log->check_out_at ? \Carbon\Carbon::parse($log->check_out_at)->format('H:i') : '-' }}</td>
                    <td>{{ $log->worked_minutes }}</td>
                    <td>{{ $log->overtime_minutes }}</td>
                    <td><span class="badge badge-secondary">{{ $log->status }}</span></td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center">Chưa có dữ liệu chấm công.</td></tr>
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
