@extends('layouts.app')

@section('title', 'Dashboard Quản Trị')
@section('header_title', 'Tổng Quan Hệ Thống')

@section('content')

@php
// Lấy số liệu thật từ database cho dashboard quản trị.
$pendingLeavesCount = \App\Models\Leave::where('status', 'pending')->count();
$totalEmployees = \App\Models\Employee::count();
$recentEmployees = \App\Models\Employee::with('position')->latest()->take(5)->get();
@endphp

<div class="alert alert-success">
    <i class="fas fa-check-circle"></i> Chào mừng bạn quay trở lại giao diện Quản trị viên!
</div>

<div class="stats-grid">
    <div class="stat-card stat-card-flex">
        <div class="stat-icon bg-indigo">
            <i class="fas fa-users"></i>
        </div>
        <div>
            <div class="stat-card-title">Tổng Nhân Sự</div>
            <div class="stat-card-value">{{ $totalEmployees }}</div>
        </div>
    </div>

    <div class="stat-card stat-card-flex">
        <div class="stat-icon bg-warning-light">
            <i class="fas fa-file-signature"></i>
        </div>
        <div>
            <div class="stat-card-title">Đơn Chờ Duyệt</div>
            <div class="stat-card-value">{{ $pendingLeavesCount }}</div>
        </div>
    </div>
</div>

<div class="action-bar">
    <a href="{{ route('admin.employees.index') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Thêm Nhân Viên Mới</a>
    <a href="{{ route('admin.salaries.index') }}" class="btn btn-secondary"><i class="fas fa-file-export"></i> Xem Bảng Lương</a>
</div>

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Mã NV</th>
                <th>Họ Tên</th>
                <th>Chức Vụ</th>
                <th>Điện Thoại</th>
                <th>Ngày Vào Làm</th>
                <th>Trạng Thái</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentEmployees as $emp)
            <tr>
                <td><strong>{{ $emp->employee_code }}</strong></td>
                <td>{{ $emp->full_name }}</td>
                <td>{{ $emp->position->name ?? 'Chưa có' }}</td>
                <td>{{ $emp->phone }}</td>
                <td>{{ \Carbon\Carbon::parse($emp->hire_date)->format('d/m/Y') }}</td>
                <td><span class="badge badge-{{ $emp->status === 'active' ? 'success' : ($emp->status === 'probation' ? 'warning' : 'secondary') }}">{{ $emp->status }}</span></td>
                <td>
                    <a href="{{ route('admin.employees.index', ['edit_employee' => $emp->id]) }}" class="btn btn-secondary btn-sm">Sửa</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
