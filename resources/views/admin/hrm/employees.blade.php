@extends('layouts.app')

@section('title', 'Nhân viên')
@section('header_title', 'Quản lý nhân sự')

@section('content')
@include('admin.hrm.partials.flash')

<div class="content-card">
    <h4 class="content-card-header">{{ $editingEmployee ? 'Cập nhật nhân viên' : 'Thêm nhân viên' }}</h4>
    <form method="POST" action="{{ $editingEmployee ? route('admin.employees.update', $editingEmployee) : route('admin.employees.store') }}" class="hrm-form hrm-form-grid">
        @csrf
        @if($editingEmployee) @method('PUT') @endif

        <div>
            <label>Email đăng nhập</label>
            <input name="email" type="email" value="{{ old('email', $editingEmployee->user->email ?? '') }}" required>
            @error('email')<small class="form-error">{{ $message }}</small>@enderror
        </div>
        <div>
            <label>Mật khẩu {{ $editingEmployee ? '(bỏ trống nếu không đổi)' : '' }}</label>
            <input name="password" type="password" {{ $editingEmployee ? '' : 'required' }}>
            @error('password')<small class="form-error">{{ $message }}</small>@enderror
        </div>
        <div>
            <label>Mã nhân viên</label>
            <input name="employee_code" value="{{ old('employee_code', $editingEmployee->employee_code ?? '') }}" required>
            @error('employee_code')<small class="form-error">{{ $message }}</small>@enderror
        </div>
        <div>
            <label>Họ tên</label>
            <input name="full_name" value="{{ old('full_name', $editingEmployee->full_name ?? '') }}" required>
            @error('full_name')<small class="form-error">{{ $message }}</small>@enderror
        </div>
        <div>
            <label>Chức vụ</label>
            <select name="position_id" required>
                <option value="">-- Chọn chức vụ --</option>
                @foreach($positions as $position)
                    <option value="{{ $position->id }}" @selected(old('position_id', $editingEmployee->position_id ?? '') == $position->id)>
                        {{ $position->name }} - {{ $position->department->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Quản lý trực tiếp</label>
            <select name="manager_id">
                <option value="">Không có</option>
                @foreach($managers as $manager)
                    <option value="{{ $manager->id }}" @selected(old('manager_id', $editingEmployee->manager_id ?? '') == $manager->id)>{{ $manager->full_name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Giới tính</label>
            <select name="gender" required>
                <option value="male" @selected(old('gender', $editingEmployee->gender ?? '') === 'male')>Nam</option>
                <option value="female" @selected(old('gender', $editingEmployee->gender ?? '') === 'female')>Nữ</option>
                <option value="other" @selected(old('gender', $editingEmployee->gender ?? '') === 'other')>Khác</option>
            </select>
        </div>
        <div>
            <label>Ngày sinh</label>
            <input name="date_of_birth" type="date" value="{{ old('date_of_birth', $editingEmployee->date_of_birth ?? '') }}" required>
        </div>
        <div>
            <label>Số điện thoại</label>
            <input name="phone" value="{{ old('phone', $editingEmployee->phone ?? '') }}" required>
        </div>
        <div>
            <label>CCCD/CMND</label>
            <input name="citizen_id" value="{{ old('citizen_id', $editingEmployee->citizen_id ?? '') }}" required>
            @error('citizen_id')<small class="form-error">{{ $message }}</small>@enderror
        </div>
        <div>
            <label>Ngày vào làm</label>
            <input name="hire_date" type="date" value="{{ old('hire_date', $editingEmployee->hire_date ?? '') }}" required>
        </div>
        <div>
            <label>Trạng thái</label>
            <select name="status" required>
                <option value="probation" @selected(old('status', $editingEmployee->status ?? '') === 'probation')>Thử việc</option>
                <option value="active" @selected(old('status', $editingEmployee->status ?? '') === 'active')>Đang làm</option>
                <option value="resigned" @selected(old('status', $editingEmployee->status ?? '') === 'resigned')>Đã nghỉ</option>
            </select>
        </div>
        <div class="hrm-form-full">
            <label>Địa chỉ</label>
            <input name="address" value="{{ old('address', $editingEmployee->address ?? '') }}" required>
        </div>
        <div class="hrm-form-full">
            <button class="btn btn-primary" type="submit">{{ $editingEmployee ? 'Cập nhật' : 'Thêm mới' }}</button>
            @if($editingEmployee)
                <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary">Hủy</a>
            @endif
        </div>
    </form>
</div>

<div class="content-card">
    <h4 class="content-card-header">Tìm kiếm nhân viên</h4>
    <form method="GET" action="{{ route('admin.employees.index') }}" class="hrm-filter">
        <input name="keyword" value="{{ request('keyword') }}" placeholder="Tên, mã nhân viên, CCCD">
        <select name="department_id">
            <option value="">Tất cả phòng ban</option>
            @foreach($departments as $department)
                <option value="{{ $department->id }}" @selected(request('department_id') == $department->id)>{{ $department->name }}</option>
            @endforeach
        </select>
        <button class="btn btn-secondary" type="submit">Lọc</button>
    </form>

    <div class="table-responsive m-0">
        <table class="table">
            <thead>
                <tr>
                    <th>Mã NV</th>
                    <th>Họ tên</th>
                    <th>Phòng ban</th>
                    <th>Chức vụ</th>
                    <th>Điện thoại</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $employee)
                <tr>
                    <td><strong>{{ $employee->employee_code }}</strong></td>
                    <td>{{ $employee->full_name }}<br><small>{{ $employee->user->email }}</small></td>
                    <td>{{ $employee->position->department->name }}</td>
                    <td>{{ $employee->position->name }}</td>
                    <td>{{ $employee->phone }}</td>
                    <td>
                        @php
                            $statusMap = [
                                'active'    => ['class' => 'badge-success', 'text' => 'Đang làm'],
                                'probation' => ['class' => 'badge-warning', 'text' => 'Thử việc'],
                                'resigned'  => ['class' => 'badge-danger',  'text' => 'Đã nghỉ'],
                                'inactive'  => ['class' => 'badge-danger',  'text' => 'Đã nghỉ'],
                            ];
                            $s = $statusMap[$employee->status] ?? ['class' => '', 'text' => $employee->status];
                        @endphp
                        <span class="badge {{ $s['class'] }}">{{ $s['text'] }}</span>
                    </td>
                    <td>
                        <div class="table-actions">
                            <a href="{{ route('admin.employees.index', ['edit_employee' => $employee->id]) }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-edit"></i> Sửa
                            </a>
                            @if(session('user_role') === 'admin')
                            <form method="POST" action="{{ route('admin.employees.destroy', $employee) }}">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Vô hiệu hóa nhân viên này?')">
                                    <i class="fas fa-lock"></i> Khóa
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center">Chưa có nhân viên phù hợp.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $employees->links() }}
</div>
@endsection

@push('styles')
@include('admin.hrm.partials.styles')
<style>
.hrm-filter {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 0.75rem;
    margin-bottom: 1rem;
}
@media (max-width: 900px) {
    .hrm-filter {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush
