@extends('layouts.app')

@section('title', 'Bảng lương')
@section('header_title', 'Quản lý bảng lương')

@section('content')
@include('admin.hrm.partials.flash')

<div class="content-card">
    <h4 class="content-card-header">Tạo hoặc cập nhật bảng lương</h4>
    <form method="POST" action="{{ route('admin.salaries.store') }}" class="hrm-form hrm-form-grid">
        @csrf
        <div>
            <label>Nhân viên</label>
            <select name="employee_id" id="employee_salary_select" title="Chọn nhân viên cần tính lương" required>
                <option value="">-- Chọn nhân viên --</option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}" 
                            data-default-salary="{{ $employee->position->default_salary ?? 0 }}"
                            @selected(old('employee_id') == $employee->id)>
                        {{ $employee->employee_code }} - {{ $employee->full_name }} ({{ $employee->position->name ?? 'Không có chức vụ' }})
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Tháng / năm</label>
            <div class="month-year">
                <input name="month" type="number" min="1" max="12" title="Nhập tháng (1-12)" value="{{ old('month', now()->month) }}" required>
                <input name="year" type="number" min="2020" max="2100" title="Nhập năm (2020-2100)" value="{{ old('year', now()->year) }}" required>
            </div>
        </div>
        <div>
            <label>Lương cơ bản</label>
            <input name="base_salary" type="number" min="0" step="100000" title="Nhập mức lương cơ bản (VND)" value="{{ old('base_salary', 8000000) }}" required>
        </div>
        <div>
            <label>Phụ cấp</label>
            <input name="allowance" type="number" min="0" step="100000" title="Nhập phụ cấp thêm (VND)" value="{{ old('allowance', 0) }}">
        </div>
        <div>
            <label>Thưởng</label>
            <input name="bonus" type="number" min="0" step="100000" title="Nhập các khoản thưởng hiệu suất (VND)" value="{{ old('bonus', 0) }}">
        </div>
        <div>
            <label>Khấu trừ</label>
            <input name="deduction" type="number" min="0" step="100000" title="Nhập các khoản khấu trừ (VND)" value="{{ old('deduction', 0) }}">
        </div>
        <div>
            <label>Trạng thái</label>
            <select name="status" title="Chọn trạng thái thanh toán bảng lương">
                <option value="draft">Nháp</option>
                <option value="paid">Đã trả</option>
            </select>
        </div>
        <div class="hrm-form-full">
            <button class="btn btn-primary" type="submit" title="Lưu thông tin bảng lương vừa nhập">Lưu bảng lương</button>
        </div>
    </form>
</div>

<div class="content-card">
    <div class="content-card-header-flex" style="flex-wrap: wrap; gap: 1rem;">
        <h4>Danh sách bảng lương</h4>
        <form method="GET" action="{{ route('admin.salaries.index') }}" style="display: flex; gap: 0.5rem; flex-wrap: wrap; align-items: center; margin: 0;">
            <select name="department_id" title="Lọc theo phòng ban" style="padding: 0.35rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                <option value="">-- Tất cả phòng ban --</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" @selected($department_id == $dept->id)>{{ $dept->name }}</option>
                @endforeach
            </select>

            <select name="position_id" title="Lọc theo chức vụ" style="padding: 0.35rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                <option value="">-- Tất cả chức vụ --</option>
                @foreach($positions as $pos)
                    <option value="{{ $pos->id }}" @selected($position_id == $pos->id)>{{ $pos->name }}</option>
                @endforeach
            </select>

            <div style="display: flex; gap: 0.25rem; align-items: center;">
                <input name="month" type="number" min="1" max="12" placeholder="Tháng" title="Lọc theo tháng" value="{{ $month }}" style="width: 70px; padding: 0.35rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                <input name="year" type="number" min="2020" max="2100" placeholder="Năm" title="Lọc theo năm" value="{{ $year }}" style="width: 85px; padding: 0.35rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
            </div>

            <button type="submit" class="btn btn-secondary" style="padding: 0.35rem 0.75rem;">Lọc</button>
            <a href="{{ route('admin.salaries.index') }}" class="btn btn-secondary" style="padding: 0.35rem 0.75rem; background: #9ca3af; border-color: #9ca3af; text-decoration: none;" title="Xóa bộ lọc">Xóa</a>
            <a href="{{ route('admin.salaries.export', request()->all()) }}" class="btn btn-primary" style="padding: 0.35rem 0.75rem; text-decoration: none;" title="Xuất danh sách lương ra file CSV">
                <i class="fas fa-file-csv"></i> Xuất CSV
            </a>
        </form>
    </div>
    <div class="table-responsive m-0">
        <table class="table table-dense">
            <thead>
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
            </thead>
            <tbody>
                @forelse($salaries as $salary)
                <tr>
                    <td>{{ $salary->month }}/{{ $salary->year }}</td>
                    <td>{{ $salary->employee->full_name }}</td>
                    <td>{{ number_format($salary->base_salary) }}</td>
                    <td>{{ number_format($salary->allowance) }}</td>
                    <td>{{ number_format($salary->bonus) }}</td>
                    <td>{{ number_format($salary->deduction) }}</td>
                    <td>{{ number_format($salary->gross_salary) }} VND</td>
                    <td><strong>{{ number_format($salary->net_salary) }} VND</strong></td>
                    <td><span class="badge badge-{{ $salary->status === 'paid' ? 'success' : 'warning' }}" title="{{ $salary->status === 'paid' ? 'Bảng lương đã thanh toán thành công' : 'Bảng lương nháp đang trong quá trình tính toán' }}">{{ $salary->status === 'paid' ? 'Đã trả' : 'Nháp' }}</span></td>
                    <td>
                        <div class="table-actions">
                            <form method="POST" action="{{ route('admin.salaries.destroy', $salary) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit" title="Xóa bảng lương này"
                                    onclick="return confirm('Xóa bảng lương tháng {{ $salary->month }}/{{ $salary->year }} của {{ $salary->employee->full_name }}?')">
                                    <i class="fas fa-trash-alt"></i> Xóa
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="10" class="text-center">Chưa có bảng lương.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('styles')
@include('admin.hrm.partials.styles')
<style>
.month-year { display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const employeeSelect = document.getElementById('employee_salary_select');
    const baseSalaryInput = document.querySelector('input[name="base_salary"]');

    if (employeeSelect && baseSalaryInput) {
        employeeSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const defaultSalary = selectedOption.getAttribute('data-default-salary');
            
            if (defaultSalary && parseInt(defaultSalary) > 0) {
                baseSalaryInput.value = defaultSalary;
            }
        });
    }
});
</script>
@endpush

