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
            <input name="email" type="email" title="Nhập địa chỉ email đăng nhập" value="{{ old('email', $editingEmployee->user->email ?? '') }}" required>
            @error('email')<small class="form-error">{{ $message }}</small>@enderror
        </div>
        <div>
            <label>Mật khẩu {{ $editingEmployee ? '(bỏ trống nếu không đổi)' : '' }}</label>
            <input name="password" type="password" title="Nhập mật khẩu tài khoản" {{ $editingEmployee ? '' : 'required' }}>
            @error('password')<small class="form-error">{{ $message }}</small>@enderror
        </div>
        <div>
            <label>Mã nhân viên</label>
            <input name="employee_code" title="Mã định danh nhân viên (Tự động tạo)" value="{{ old('employee_code', $editingEmployee ? $editingEmployee->employee_code : $nextEmployeeCode) }}" readonly style="background-color: #f3f4f6; cursor: not-allowed;" required>
            @error('employee_code')<small class="form-error">{{ $message }}</small>@enderror
        </div>
        <div>
            <label>Họ tên</label>
            <input name="full_name" title="Nhập họ và tên đầy đủ" value="{{ old('full_name', $editingEmployee->full_name ?? '') }}" required>
            @error('full_name')<small class="form-error">{{ $message }}</small>@enderror
        </div>
        <div>
            <label>Chức vụ</label>
            <select name="position_id" title="Chọn phòng ban và vị trí công tác" required>
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
            <select name="manager_id" title="Chọn cấp quản lý trực tiếp nếu có">
                <option value="">Không có</option>
                @foreach($managers as $manager)
                    <option value="{{ $manager->id }}" @selected(old('manager_id', $editingEmployee->manager_id ?? '') == $manager->id)>{{ $manager->full_name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Giới tính</label>
            <select name="gender" title="Chọn giới tính" required>
                <option value="male" @selected(old('gender', $editingEmployee->gender ?? '') === 'male')>Nam</option>
                <option value="female" @selected(old('gender', $editingEmployee->gender ?? '') === 'female')>Nữ</option>
                <option value="other" @selected(old('gender', $editingEmployee->gender ?? '') === 'other')>Khác</option>
            </select>
        </div>
        <div>
            <label>Ngày sinh</label>
            <input name="date_of_birth" type="date" title="Chọn ngày sinh" value="{{ old('date_of_birth', $editingEmployee->date_of_birth ?? '') }}" required>
        </div>
        <div>
            <label>Số điện thoại</label>
            <input name="phone" title="Nhập số điện thoại liên hệ" value="{{ old('phone', $editingEmployee->phone ?? '') }}" required>
        </div>
        <div>
            <label>CCCD/CMND</label>
            <input name="citizen_id" title="Nhập số căn cước công dân hoặc số chứng minh nhân dân" value="{{ old('citizen_id', $editingEmployee->citizen_id ?? '') }}" required>
            @error('citizen_id')<small class="form-error">{{ $message }}</small>@enderror
        </div>
        <div>
            <label>Ngày vào làm</label>
            <input name="hire_date" type="date" title="Chọn ngày chính thức nhận việc" value="{{ old('hire_date', $editingEmployee->hire_date ?? '') }}" required>
        </div>
        <div>
            <label>Trạng thái</label>
            <select name="status" title="Chọn trạng thái công tác" required>
                <option value="probation" @selected(old('status', $editingEmployee->status ?? '') === 'probation')>Thử việc</option>
                <option value="active" @selected(old('status', $editingEmployee->status ?? '') === 'active')>Đang làm</option>
                <option value="resigned" @selected(old('status', $editingEmployee->status ?? '') === 'resigned')>Đã nghỉ</option>
            </select>
        </div>
        <div class="hrm-form-full">
            <label>Địa chỉ</label>
            <input name="address" title="Nhập địa chỉ nơi ở hiện tại" value="{{ old('address', $editingEmployee->address ?? '') }}" required>
        </div>
        <div class="hrm-form-full">
            <button class="btn btn-primary" type="submit" title="{{ $editingEmployee ? 'Lưu lại các thay đổi của nhân viên này' : 'Tạo hồ sơ nhân viên mới' }}">{{ $editingEmployee ? 'Cập nhật' : 'Thêm mới' }}</button>
            @if($editingEmployee)
                <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary" title="Hủy bỏ chỉnh sửa và quay lại">Hủy</a>
            @endif
        </div>
    </form>
</div>

<div class="content-card">
    <h4 class="content-card-header">Tìm kiếm nhân viên</h4>
    <form method="GET" action="{{ route('admin.employees.index') }}" class="hrm-filter">
        <input name="keyword" value="{{ request('keyword') }}" title="Nhập họ tên, mã định danh hoặc số CCCD cần tìm" placeholder="Tên, mã nhân viên, CCCD">
        <select name="department_id" title="Lọc danh sách theo phòng ban">
            <option value="">Tất cả phòng ban</option>
            @foreach($departments as $department)
                <option value="{{ $department->id }}" @selected(request('department_id') == $department->id)>{{ $department->name }}</option>
            @endforeach
        </select>
        <button class="btn btn-secondary" type="submit" title="Lọc danh sách nhân sự">Lọc</button>
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
                                'active'    => ['class' => 'badge-success', 'text' => 'Đang làm', 'title' => 'Nhân viên đang công tác chính thức'],
                                'probation' => ['class' => 'badge-warning', 'text' => 'Thử việc', 'title' => 'Nhân viên đang trong thời gian thử việc'],
                                'resigned'  => ['class' => 'badge-danger',  'text' => 'Đã nghỉ', 'title' => 'Nhân viên đã thôi việc'],
                                'inactive'  => ['class' => 'badge-danger',  'text' => 'Đã nghỉ', 'title' => 'Nhân viên đã thôi việc'],
                            ];
                            $s = $statusMap[$employee->status] ?? ['class' => '', 'text' => $employee->status, 'title' => 'Trạng thái nhân viên'];
                        @endphp
                        <span class="badge {{ $s['class'] }}" title="{{ $s['title'] }}">{{ $s['text'] }}</span>
                    </td>
                    <td>
                        <div class="table-actions">
                            <a href="{{ route('admin.employees.index', ['edit_employee' => $employee->id]) }}" class="btn btn-secondary btn-sm" title="Chỉnh sửa thông tin nhân sự này">
                                <i class="fas fa-edit"></i> Sửa
                            </a>
                            @if(session('user_role') === 'admin')
                            <form method="POST" action="{{ route('admin.employees.destroy', $employee) }}">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" title="Vô hiệu hóa nhân viên này" onclick="return confirm('Vô hiệu hóa nhân viên này?')">
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
