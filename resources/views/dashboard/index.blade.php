@extends('layouts.dashboard')

@section('title', 'Bảng Điều Khiển')
@section('header_title', 'Chào buổi sáng, ' . (auth()->check() ? auth()->user()->name : ''))

@section('content')
<div class="stats-grid">
    @if(auth()->check() && auth()->user()->role == 'admin')
    <a href="{{ route('admin.employees') }}" class="stat-card" style="text-decoration: none; color: inherit;">
        <div class="icon-circle icon-blue"><i class="fas fa-users"></i></div>
        <div class="stat-info">
            <span class="stat-label">Tổng Nhân Sự</span>
            <h3 class="stat-value">{{ $totalEmployees ?? 0 }}</h3>
        </div>
    </a>

    <a href="{{ route('admin.departments') }}" class="stat-card" style="text-decoration: none; color: inherit;">
        <div class="icon-circle icon-purple"><i class="fas fa-sitemap"></i></div>
        <div class="stat-info">
            <span class="stat-label">Phòng Ban</span>
            <h3 class="stat-value">{{ $totalDepartments ?? 0 }}</h3>
        </div>
    </a>

    <a href="{{ route('admin.leaves') }}" class="stat-card" style="text-decoration: none; color: inherit;">
        <div class="icon-circle icon-orange"><i class="fas fa-file-signature"></i></div>
        <div class="stat-info">
            <span class="stat-label">Đơn Chờ Duyệt</span>
            <h3 class="stat-value">{{ $pendingLeaves ?? 0 }}</h3>
        </div>
    </a>

    <a href="{{ route('admin.attendance') }}" class="stat-card" style="text-decoration: none; color: inherit;">
        <div class="icon-circle icon-green"><i class="fas fa-user-check"></i></div>
        <div class="stat-info">
            <span class="stat-label">Chấm Công (Hôm nay)</span>
            <h3 class="stat-value">{{ $todayAttendance ?? 0 }}</h3>
        </div>
    </a>