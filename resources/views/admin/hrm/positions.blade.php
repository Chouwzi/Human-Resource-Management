@extends('layouts.app')

@section('title', 'Chức vụ')
@section('header_title', 'Quản lý chức vụ')

@section('content')
@include('admin.hrm.partials.flash')

<div class="content-grid">
    <div class="content-card">
        <h4 class="content-card-header">{{ $editingPosition ? 'Cập nhật chức vụ' : 'Thêm chức vụ' }}</h4>
        <form method="POST" action="{{ $editingPosition ? route('admin.positions.update', $editingPosition) : route('admin.positions.store') }}" class="hrm-form">
            @csrf
            @if($editingPosition) @method('PUT') @endif
            <label>Phòng ban</label>
            <select name="department_id" title="Chọn phòng ban trực thuộc cho chức vụ này" required>
                <option value="">-- Chọn phòng ban --</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}" @selected(old('department_id', $editingPosition->department_id ?? '') == $department->id)>{{ $department->name }}</option>
                @endforeach
            </select>
            @error('department_id')<small class="form-error">{{ $message }}</small>@enderror

            <label>Tên chức vụ</label>
            <input name="name" value="{{ old('name', $editingPosition->name ?? '') }}" title="Nhập tên chức danh chức vụ" required maxlength="150">
            @error('name')<small class="form-error">{{ $message }}</small>@enderror

            <label>Lương mặc định</label>
            <input type="number" name="default_salary" value="{{ old('default_salary', $editingPosition->default_salary ?? 0) }}" min="0" step="100000" title="Nhập mức lương cơ bản mặc định (VND)" required>
            @error('default_salary')<small class="form-error">{{ $message }}</small>@enderror

            <label>Mô tả</label>
            <input name="description" value="{{ old('description', $editingPosition->description ?? '') }}" title="Nhập mô tả ngắn gọn về nhiệm vụ của chức vụ" maxlength="255">

            <button class="btn btn-primary" type="submit" title="{{ $editingPosition ? 'Lưu lại các thay đổi của chức vụ này' : 'Tạo chức vụ mới' }}">{{ $editingPosition ? 'Cập nhật' : 'Thêm mới' }}</button>
            @if($editingPosition)
                <a href="{{ route('admin.positions.index') }}" class="btn btn-secondary" title="Hủy chỉnh sửa và quay lại">Hủy</a>
            @endif
        </form>
    </div>

    <div class="content-card">
        <h4 class="content-card-header">Danh sách chức vụ</h4>
        <div class="table-responsive m-0">
            <table class="table">
                <thead>
                    <tr>
                        <th>Chức vụ</th>
                        <th>Phòng ban</th>
                        <th>Lương mặc định</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($positions as $position)
                    <tr>
                        <td><strong>{{ $position->name }}</strong></td>
                        <td>{{ $position->department->name }}</td>
                        <td>{{ number_format($position->default_salary) }} VND</td>
                        <td>
                            <div class="table-actions">
                                <a href="{{ route('admin.positions.index', ['edit_position' => $position->id]) }}" class="btn btn-secondary btn-sm" title="Chỉnh sửa thông tin chức vụ này">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                @if(session('user_role') === 'admin')
                                <form method="POST" action="{{ route('admin.positions.destroy', $position) }}">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" title="Xóa chức vụ này" onclick="return confirm('Xóa chức vụ này?')">
                                        <i class="fas fa-trash-alt"></i> Xóa
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center">Chưa có chức vụ.</td></tr>
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
