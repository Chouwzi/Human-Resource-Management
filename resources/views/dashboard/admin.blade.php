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
'position' => '', // Dữ liệu giả lập nối từ position_id
'phone' => '0901234567',
'hire_date' => '15/05/2025',
'status' => 'active',
'status_label' => 'Chính thức',
'status_class' => 'success' // Xanh lá
],
(object)[
'employee_code' => 'NV002',
'full_name' => 'Trần Nhật Minh',
'position' => 'Chuyên viên Nhân sự',
'phone' => '0987654321',
'hire_date' => '10/06/2026',
'status' => 'probation',
'status_label' => 'Thử việc',
'status_class' => 'warning' // Vàng cam
],
(object)[
'employee_code' => 'NV003',
'full_name' => 'Hoàng Thế Đoàn',
'position' => 'Kế toán viên',
'phone' => '0912345678',
'hire_date' => '01/01/2025',
'status' => 'resigned',
'status_label' => 'Đã nghỉ việc',
'status_class' => 'danger' // Đỏ
]
];
@endphp

<div class="alert alert-success">
    <i class="fas fa-check-circle"></i> Chào mừng bạn quay trở lại giao diện Quản trị viên!
</div>

<div
    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <div
        style="background: var(--bg-card); padding: 1.5rem; border-radius: 0.5rem; border: 1px solid var(--border-color); display: flex; align-items: center; gap: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
        <div
            style="width: 50px; height: 50px; border-radius: 50%; background: #e0e7ff; color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
            <i class="fas fa-users"></i>
        </div>
        <div>
            <div style="color: var(--text-muted); font-size: 0.875rem; font-weight: 500;">Tổng Nhân Sự</div>
            <div style="color: var(--text-main); font-size: 1.5rem; font-weight: 700;">{{ $totalEmployees }}</div>
        </div>
    </div>

    <div
        style="background: var(--bg-card); padding: 1.5rem; border-radius: 0.5rem; border: 1px solid var(--border-color); display: flex; align-items: center; gap: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
        <div
            style="width: 50px; height: 50px; border-radius: 50%; background: #fef3c7; color: var(--warning); display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
            <i class="fas fa-file-signature"></i>
        </div>
        <div>
            <div style="color: var(--text-muted); font-size: 0.875rem; font-weight: 500;">Đơn Chờ Duyệt</div>
            <div style="color: var(--text-main); font-size: 1.5rem; font-weight: 700;">{{ $pendingLeaves }}</div>
        </div>
    </div>
</div>

<div style="margin-bottom: 20px; display: flex; gap: 10px;">
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
                    <button class="btn btn-secondary" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;">Sửa</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection