@extends('layouts.app')

@section('title', 'Phòng ban')
@section('header_title', 'Quản lý cơ cấu tổ chức')

@section('content')
@include('admin.hrm.partials.flash')

<div class="content-grid">
    <div class="content-card">
        <h4 class="content-card-header">{{ $editingDepartment ? 'Cập nhật phòng ban' : 'Thêm phòng ban' }}</h4>
        <form method="POST" action="{{ $editingDepartment ? route('admin.departments.update', $editingDepartment) : route('admin.departments.store') }}" class="hrm-form">
            @csrf
            @if($editingDepartment) @method('PUT') @endif
            <label>Tên phòng ban</label>
            <input name="name" value="{{ old('name', $editingDepartment->name ?? '') }}" title="Nhập tên phòng ban" required maxlength="150">
            @error('name')<small class="form-error">{{ $message }}</small>@enderror

            <label>Mô tả</label>
            <input name="description" value="{{ old('description', $editingDepartment->description ?? '') }}" title="Nhập mô tả chức năng của phòng ban" maxlength="255">
            @error('description')<small class="form-error">{{ $message }}</small>@enderror

            <button class="btn btn-primary" type="submit" title="{{ $editingDepartment ? 'Lưu lại các thay đổi của phòng ban này' : 'Tạo phòng ban mới' }}">{{ $editingDepartment ? 'Cập nhật' : 'Thêm mới' }}</button>
            @if($editingDepartment)
                <a href="{{ route('admin.departments.index') }}" class="btn btn-secondary" title="Hủy bỏ chỉnh sửa và quay lại">Hủy</a>
            @endif
        </form>
    </div>

    <div class="content-card">
        <div class="content-card-header-flex">
            <h4>Danh sách phòng ban</h4>
            <a href="{{ route('admin.positions.index') }}" class="btn btn-secondary" title="Chuyển đến trang quản lý chức vụ">Quản lý chức vụ</a>
        </div>
        <div class="table-responsive m-0">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tên phòng ban</th>
                        <th>Mô tả</th>
                        <th>Số chức vụ</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($departments as $department)
                    <tr>
                        <td><strong>{{ $department->name }}</strong></td>
                        <td>{{ $department->description ?: 'Chưa có' }}</td>
                        <td>{{ $department->positions_count }}</td>
                        <td>
                            <div class="table-actions">
                                <a href="{{ route('admin.departments.index', ['edit_department' => $department->id]) }}" class="btn btn-secondary btn-sm" title="Chỉnh sửa thông tin phòng ban này">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                @if(session('user_role') === 'admin')
                                <form method="POST" action="{{ route('admin.departments.destroy', $department) }}">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" title="Xóa phòng ban này" onclick="return confirm('Xóa phòng ban này?')">
                                        <i class="fas fa-trash-alt"></i> Xóa
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center">Chưa có phòng ban.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
@include('admin.hrm.partials.styles')
@endpush
