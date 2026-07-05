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
            <select name="department_id" required>
                <option value="">-- Chọn phòng ban --</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}" @selected(old('department_id', $editingPosition->department_id ?? '') == $department->id)>{{ $department->name }}</option>
                @endforeach
            </select>
            @error('department_id')<small class="form-error">{{ $message }}</small>@enderror

            <label>Tên chức vụ</label>
            <input name="name" value="{{ old('name', $editingPosition->name ?? '') }}" required maxlength="150">
            @error('name')<small class="form-error">{{ $message }}</small>@enderror

            <label>Lương mặc định</label>
            <input type="number" name="default_salary" value="{{ old('default_salary', $editingPosition->default_salary ?? 0) }}" min="0" step="100000" required>
            @error('default_salary')<small class="form-error">{{ $message }}</small>@enderror

            <label>Mô tả</label>
            <input name="description" value="{{ old('description', $editingPosition->description ?? '') }}" maxlength="255">

            <button class="btn btn-primary" type="submit">{{ $editingPosition ? 'Cập nhật' : 'Thêm mới' }}</button>
            @if($editingPosition)
                <a href="{{ route('admin.positions.index') }}" class="btn btn-secondary">Hủy</a>
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
                        <td class="table-actions">
                            <a href="{{ route('admin.positions.index', ['edit_position' => $position->id]) }}" class="btn btn-secondary btn-sm">Sửa</a>
                            @if(session('user_role') === 'admin')
                            <form method="POST" action="{{ route('admin.positions.destroy', $position) }}">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Xóa chức vụ này?')">Xóa</button>
                            </form>
                            @endif
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
