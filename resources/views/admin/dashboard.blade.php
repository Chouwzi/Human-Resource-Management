@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')
@section('header_title', 'Tổng quan ')

@section('content')
<div class="admin-container">
    <div class="stats-grid">

        <a href="{{ route('admin.employees') }}" class="stat-card card-employees"
            style="text-decoration: none; color: inherit;">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <div class="stat-details">
                <span class="stat-label">Nhân Viên</span>
                <h3 class="stat-value">{{ $total_employees ?? 0 }}</h3>
            </div>
        </a>

        <a href="{{ route('admin.departments') }}" class="stat-card card-departments"
            style="text-decoration: none; color: inherit;">
            <div class="stat-icon"><i class="fas fa-sitemap"></i></div>
            <div class="stat-details">
                <span class="stat-label">Phòng Ban</span>
                <h3 class="stat-value">{{ $total_departments ?? 0 }}</h3>
            </div>
        </a>

        <a href="{{ route('admin.leaves') }}" class="stat-card card-pending"
            style="text-decoration: none; color: inherit;">
            <div class="stat-icon"><i class="fas fa-file-signature"></i></div>
            <div class="stat-details">
                <span class="stat-label">Đơn Chờ Duyệt</span>
                <h3 class="stat-value text-warning">{{ $pending_leaves ?? 0 }}</h3>
            </div>
        </a>

        <a href="{{ route('admin.attendance') }}" class="stat-card card-attendance"
            style="text-decoration: none; color: inherit;">
            <div class="stat-icon"><i class="fas fa-user-check"></i></div>
            <div class="stat-details">
                <span class="stat-label">Chấm Công (Hôm nay)</span>
                <h3 class="stat-value text-success">{{ $attendance_today ?? 0 }}</h3>
            </div>
        </a>

    </div>

    <div class="admin-management-area">
    </div>
</div>
@endsection