@extends('layouts.app')

@section('title', 'Trang Cá Nhân')
@section('header_title', 'Tổng Quan Khung Làm Việc')

@section('content')

@php
// Dữ liệu demo cá nhân hóa, bổ sung thông tin lương tháng gần nhất
$myInfo = (object)[
    'employee_code' => 'NV001',
    'full_name' => 'Nguyễn Trung Nguyên',
    'position' => 'Lập trình viên Backend',
    'hire_date' => '15/05/2025',
    'status_label' => 'Chính thức',
    'status_class' => 'success',

    // Thống kê cá nhân
    'leave_balance' => 12,
    'leave_taken' => 2,
    'attendance_today' => '08:00 AM',

    // Thông tin lương
    'salary_month' => 'Tháng 05/2026',
    'salary_status' => 'Đã thanh toán'
];

// Lịch sử xin nghỉ phép
$myLeaves = [
    (object)['type' => 'Nghỉ ốm', 'date' => '10/06/2026', 'days' => 1, 'status' => 'Đã duyệt', 'status_class' => 'success'],
    (object)['type' => 'Việc cá nhân', 'date' => '25/06/2026', 'days' => 2, 'status' => 'Chờ duyệt', 'status_class' => 'warning'],
];
@endphp

<div class="dashboard-welcome">
    <div>
        <h3 class="welcome-title">Xin chào, {{ $myInfo->full_name }}! 👋</h3>
        <p class="welcome-subtitle">Chúc bạn một ngày làm việc hiệu quả.</p>
    </div>
    <div>
        <span class="badge badge-{{ $myInfo->status_class }} status-badge">
            Trạng thái: {{ $myInfo->status_label }}
        </span>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-title">Check-in Hôm Nay</div>
        <div class="stat-card-value">{{ $myInfo->attendance_today ?? 'Chưa chấm công' }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-title">Phép Năm Còn Lại</div>
        <div class="stat-card-value">
            {{ $myInfo->leave_balance - $myInfo->leave_taken }} 
            <span class="stat-card-subtext">/ {{ $myInfo->leave_balance }} ngày</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-title">Lương {{ $myInfo->salary_month }}</div>
        <div class="stat-card-value success">{{ $myInfo->salary_status }}</div>
    </div>
</div>

<div class="content-grid">
    <div class="content-card">
        <h4 class="content-card-header">Thông Tin Hồ Sơ</h4>

        <div class="profile-info-list">
            <div class="profile-info-item">
                <span class="profile-info-label">Mã Nhân Viên</span>
                <strong class="profile-info-value">{{ $myInfo->employee_code }}</strong>
            </div>
            <div class="profile-info-item">
                <span class="profile-info-label">Chức Vụ</span>
                <strong class="profile-info-value">{{ $myInfo->position }}</strong>
            </div>
            <div class="profile-info-item">
                <span class="profile-info-label">Ngày Vào Làm</span>
                <strong class="profile-info-value">{{ $myInfo->hire_date }}</strong>
            </div>
        </div>

        <div class="card-actions">
            <button class="btn btn-secondary w-100">Cập nhật hồ sơ</button>
        </div>
    </div>

    <div class="content-card">
        <div class="content-card-header-flex">
            <h4>Đơn Nghỉ Phép Gần Đây</h4>
            <a href="#" class="link-view-all">Xem tất cả</a>
        </div>

        @if(count($myLeaves) > 0)
        <div class="table-responsive m-0">
            <table class="table" style="min-width: unset;">
                <thead>
                    <tr>
                        <th>Loại Đơn</th>
                        <th>Ngày Nghỉ</th>
                        <th>Trạng Thái</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($myLeaves as $leave)
                    <tr>
                        <td><strong>{{ $leave->type }}</strong><br><small class="text-muted">{{ $leave->days }} ngày</small></td>
                        <td>{{ $leave->date }}</td>
                        <td><span class="badge badge-{{ $leave->status_class }}">{{ $leave->status }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="card-actions" style="color: var(--text-muted); padding: 2rem 0;">
            <p>Chưa có lịch sử nghỉ phép nào.</p>
        </div>
        @endif

        <div class="card-actions">
            <button class="btn btn-primary w-100">Tạo đơn nghỉ phép mới</button>
        </div>
    </div>
</div>

@endsection