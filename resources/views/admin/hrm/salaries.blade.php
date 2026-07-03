@extends('layouts.app')

@section('title', 'Bảng lương')
@section('header_title', 'Bảng Lương Đơn Giản')

@section('content')
@include('admin.hrm.partials.flash')

<div class="content-card">
    <h4 class="content-card-header">Tạo hoặc cập nhật bảng lương</h4>
    <form method="POST" action="{{ route('admin.salaries.store') }}" class="hrm-form hrm-form-grid">
        @csrf
        <div>
            <label>Nhân viên</label>
            <select name="employee_id" required>
                <option value="">-- Chọn nhân viên --</option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}" @selected(old('employee_id') == $employee->id)>
                        {{ $employee->employee_code }} - {{ $employee->full_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Tháng / năm</label>
            <div class="month-year">
                <input name="month" class="form-control" type="number" min="1" max="12" value="{{ old('month', now()->month) }}" required>
                <input name="year" class="form-control" type="number" min="2020" max="2100" value="{{ old('year', now()->year) }}" required>
            </div>
        </div>
        <div>
            <label>Lương cơ bản</label>
            <input name="base_salary" class="form-control" type="number" min="0" step="100000" value="{{ old('base_salary', 8000000) }}" required>
        </div>
        <div>
            <label>Phụ cấp</label>
            <input name="allowance" class="form-control" type="number" min="0" step="100000" value="{{ old('allowance', 0) }}">
        </div>
        <div>
            <label>Thưởng</label>
            <input name="bonus" class="form-control" type="number" min="0" step="100000" value="{{ old('bonus', 0) }}">
        </div>
        <div>
            <label>Khấu trừ</label>
            <input name="deduction" class="form-control" type="number" min="0" step="100000" value="{{ old('deduction', 0) }}">
        </div>
        <div>
            <label>Trạng thái</label>
            <select name="status">
                <option value="draft">Nháp</option>
                <option value="paid">Đã trả</option>
            </select>
        </div>
        <div class="hrm-form-full">
            <button class="btn btn-primary" type="submit">Lưu bảng lương</button>
        </div>
    </form>
</div>

<div class="content-card">
    <h4 class="content-card-header">Danh sách bảng lương</h4>
    <div class="table-responsive m-0">
        <table class="table">
            <thead>
                <tr>
                    <th>Tháng</th>
                    <th>Nhân viên</th>
                    <th>Gross</th>
                    <th>Net</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                @forelse($salaries as $salary)
                <tr>
                    <td>{{ $salary->month }}/{{ $salary->year }}</td>
                    <td>{{ $salary->employee->full_name }}</td>
                    <td>{{ number_format($salary->gross_salary) }} VND</td>
                    <td><strong>{{ number_format($salary->net_salary) }} VND</strong></td>
                    <td><span class="badge badge-{{ $salary->status === 'paid' ? 'success' : 'warning' }}">{{ $salary->status }}</span></td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center">Chưa có bảng lương.</td></tr>
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
.month-year { display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; }
@media (max-width: 900px) { .hrm-form-grid { grid-template-columns: 1fr; } }
</style>
@endpush
