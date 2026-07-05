@extends('layouts.app')

@section('title', 'Tổng quan nhân sự (HR)')
@section('header_title', 'Tổng quan nhân sự')

@section('content')

<div class="dashboard-welcome">
    <div>
        <h3 class="welcome-title">Xin chào, HR {{ session('user_name') }}!</h3>
        <p class="welcome-subtitle">Quản lý nhân sự, duyệt đơn nghỉ phép và theo dõi chấm công.</p>
    </div>
    <div>
        <span class="badge badge-info status-badge">Nhân sự (HR)</span>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card stat-card-flex">
        <div class="stat-icon bg-indigo">
            <i class="fas fa-users"></i>
        </div>
        <div>
            <div class="stat-card-title">Tổng nhân viên</div>
            <div class="stat-card-value">{{ $totalEmployees }}</div>
        </div>
    </div>

    <div class="stat-card stat-card-flex">
        <div class="stat-icon" style="background:#dcfce7; color:#15803d;">
            <i class="fas fa-user-check"></i>
        </div>
        <div>
            <div class="stat-card-title">Đang làm việc</div>
            <div class="stat-card-value">{{ $activeEmployees }}</div>
        </div>
    </div>

    <div class="stat-card stat-card-flex">
        <div class="stat-icon bg-warning-light">
            <i class="fas fa-file-signature"></i>
        </div>
        <div>
            <div class="stat-card-title">Đơn chờ duyệt</div>
            <div class="stat-card-value">{{ $pendingLeavesCount }}</div>
        </div>
    </div>
</div>

<div class="action-bar">
    <a href="{{ route('admin.employees.index') }}" class="btn btn-primary">
        <i class="fas fa-plus" style="margin-right:6px;"></i> Thêm nhân viên
    </a>
    <a href="{{ route('admin.leaves.pending') }}" class="btn btn-secondary">
        <i class="fas fa-clipboard-check" style="margin-right:6px;"></i> Duyệt nghỉ phép
        @if($pendingLeavesCount > 0)
            <span class="badge badge-warning" style="margin-left:6px;">{{ $pendingLeavesCount }}</span>
        @endif
    </a>
    <a href="{{ route('admin.attendance.index') }}" class="btn btn-secondary">
        <i class="fas fa-calendar-alt" style="margin-right:6px;"></i> Chấm công
    </a>
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
                <td>
                    <span class="badge badge-{{ $emp->status === 'active' ? 'success' : ($emp->status === 'probation' ? 'warning' : 'secondary') }}">
                        {{ $emp->status === 'active' ? 'Đang làm' : ($emp->status === 'probation' ? 'Thử việc' : 'Đã nghỉ') }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.employees.index', ['edit_employee' => $emp->id]) }}" class="btn btn-secondary btn-sm">Sửa</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
