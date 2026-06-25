@extends('layouts.app')

@section('title', 'Dashboard Quản Trị')
@section('header_title', 'Tổng Quan Hệ Thống')

@section('content')

@php
// Dữ liệu demo bám sát 100% các cột trong migration 'employees'
$totalEmployees = 12;
$pendingLeaves = 3;

$recentEmployees = [
    (object)[
        'employee_code' => 'NV001',
        'full_name' => 'Nguyễn Trung Nguyên',
        'position' => '', 
        'phone' => '0901234567',
        'hire_date' => '15/05/2025',
        'status' => 'active',
        'status_label' => 'Chính thức',
        'status_class' => 'success'
    ],
    (object)[
        'employee_code' => 'NV002',
        'full_name' => 'Trần Nhật Minh',
        'position' => 'Chuyên viên Nhân sự',
        'phone' => '0987654321',
        'hire_date' => '10/06/2026',
        'status' => 'probation',
        'status_label' => 'Thử việc',
        'status_class' => 'warning'
    ],
    (object)[
        'employee_code' => 'NV003',
        'full_name' => 'Hoàng Thế Đoàn',
        'position' => 'Kế toán viên',
        'phone' => '0912345678',
        'hire_date' => '01/01/2025',
        'status' => 'resigned',
        'status_label' => 'Đã nghỉ việc',
        'status_class' => 'danger' 
    ]
];
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
            <div class="stat-card-value">{{ $pendingLeaves }}</div>
        </div>
    </div>
</div>

<div class="action-bar">
    <button class="btn btn-primary"><i class="fas fa-plus"></i> Thêm Nhân Viên Mới</button>
    <button class="btn btn-secondary"><i class="fas fa-file-export"></i> Xuất Báo Cáo</button>
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
                <td>{{ $emp->position }}</td>
                <td>{{ $emp->phone }}</td>
                <td>{{ $emp->hire_date }}</td>
                <td><span class="badge badge-{{ $emp->status_class }}">{{ $emp->status_label }}</span></td>
                <td>
                    <button class="btn btn-secondary btn-sm">Sửa</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection