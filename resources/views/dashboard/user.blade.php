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
(object)['type' => 'Việc cá nhân', 'date' => '25/06/2026', 'days' => 2, 'status' => 'Chờ duyệt', 'status_class' =>
'warning'],
];
@endphp

<div
    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
    <div>
        <h3 style="margin: 0; color: var(--text-main);">Xin chào, {{ $myInfo->full_name }}! 👋</h3>
        <p style="margin: 0.5rem 0 0 0; color: var(--text-muted);">Chúc bạn một ngày làm việc hiệu quả.</p>
    </div>
    <div>
        <span class="badge badge-{{ $myInfo->status_class }}" style="font-size: 0.875rem; padding: 0.5rem 1rem;">
            Trạng thái: {{ $myInfo->status_label }}
        </span>
    </div>
</div>

<div
    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">

    <div
        style="background: var(--bg-card); padding: 1.5rem; border-radius: 0.5rem; border: 1px solid var(--border-color); box-shadow: 0 1px 3px rgba(0,0,0,0.05); text-align: center;">
        <div style="color: var(--text-muted); font-size: 0.875rem; font-weight: 500; margin-bottom: 0.5rem;">Check-in
            Hôm Nay</div>
        <div style="color: var(--text-main); font-size: 1.5rem; font-weight: 700;">
            {{ $myInfo->attendance_today ?? 'Chưa chấm công' }}</div>
    </div>

    <div
        style="background: var(--bg-card); padding: 1.5rem; border-radius: 0.5rem; border: 1px solid var(--border-color); box-shadow: 0 1px 3px rgba(0,0,0,0.05); text-align: center;">
        <div style="color: var(--text-muted); font-size: 0.875rem; font-weight: 500; margin-bottom: 0.5rem;">Phép Năm
            Còn Lại</div>
        <div style="color: var(--text-main); font-size: 1.5rem; font-weight: 700;">
            {{ $myInfo->leave_balance - $myInfo->leave_taken }} <span
                style="font-size: 1rem; font-weight: 500; color: var(--text-muted);">/ {{ $myInfo->leave_balance }}
                ngày</span>
        </div>
    </div>

    <div
        style="background: var(--bg-card); padding: 1.5rem; border-radius: 0.5rem; border: 1px solid var(--border-color); box-shadow: 0 1px 3px rgba(0,0,0,0.05); text-align: center;">
        <div style="color: var(--text-muted); font-size: 0.875rem; font-weight: 500; margin-bottom: 0.5rem;">Lương
            {{ $myInfo->salary_month }}</div>
        <div style="color: var(--success); font-size: 1.5rem; font-weight: 700;">{{ $myInfo->salary_status }}</div>
    </div>

</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 1.5rem;">

    <div
        style="background: var(--bg-card); border-radius: 0.5rem; border: 1px solid var(--border-color); box-shadow: 0 1px 3px rgba(0,0,0,0.05); padding: 1.5rem;">
        <h4
            style="margin-top: 0; margin-bottom: 1.5rem; color: var(--primary); border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">
            Thông Tin Hồ Sơ</h4>

        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <div
                style="display: flex; justify-content: space-between; border-bottom: 1px dashed var(--border-color); padding-bottom: 0.5rem;">
                <span style="color: var(--text-muted);">Mã Nhân Viên</span>
                <strong style="color: var(--text-main);">{{ $myInfo->employee_code }}</strong>
            </div>
            <div
                style="display: flex; justify-content: space-between; border-bottom: 1px dashed var(--border-color); padding-bottom: 0.5rem;">
                <span style="color: var(--text-muted);">Chức Vụ</span>
                <strong style="color: var(--text-main);">{{ $myInfo->position }}</strong>
            </div>
            <div
                style="display: flex; justify-content: space-between; border-bottom: 1px dashed var(--border-color); padding-bottom: 0.5rem;">
                <span style="color: var(--text-muted);">Ngày Vào Làm</span>
                <strong style="color: var(--text-main);">{{ $myInfo->hire_date }}</strong>
            </div>
        </div>

        <div style="margin-top: 1.5rem; text-align: center;">
            <button class="btn btn-secondary" style="width: 100%;">Cập nhật hồ sơ</button>
        </div>
    </div>

    <div
        style="background: var(--bg-card); border-radius: 0.5rem; border: 1px solid var(--border-color); box-shadow: 0 1px 3px rgba(0,0,0,0.05); padding: 1.5rem;">
        <div
            style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem; margin-bottom: 1.5rem;">
            <h4 style="margin: 0; color: var(--primary);">Đơn Nghỉ Phép Gần Đây</h4>
            <a href="#" style="font-size: 0.875rem; color: var(--info); text-decoration: none;">Xem tất cả</a>
        </div>

        @if(count($myLeaves) > 0)
        <div class="table-responsive" style="margin: 0;">
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
                        <td><strong>{{ $leave->type }}</strong><br><small class="text-muted">{{ $leave->days }}
                                ngày</small></td>
                        <td>{{ $leave->date }}</td>
                        <td><span class="badge badge-{{ $leave->status_class }}">{{ $leave->status }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div style="text-align: center; color: var(--text-muted); padding: 2rem 0;">
            <p>Chưa có lịch sử nghỉ phép nào.</p>
        </div>
        @endif

        <div style="margin-top: 1.5rem; text-align: center;">
            <button class="btn btn-primary" style="width: 100%;">Tạo đơn nghỉ phép mới</button>
        </div>
    </div>

</div>

@endsection