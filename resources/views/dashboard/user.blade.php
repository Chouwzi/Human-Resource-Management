@extends('layouts.app')

@section('title', 'Trang Cá Nhân')
@section('header_title', 'Tổng Quan Khung Làm Việc')

@section('content')

@php
$statusMap = [
    'active' => ['label' => 'Đang làm', 'class' => 'success'],
    'probation' => ['label' => 'Thử việc', 'class' => 'warning'],
    'resigned' => ['label' => 'Đã nghỉ', 'class' => 'secondary'],
];
$employeeStatus = $statusMap[$employee?->status] ?? ['label' => 'Chưa có hồ sơ', 'class' => 'secondary'];

$salaryStatusMap = [
    'paid' => 'Đã thanh toán',
    'draft' => 'Đang xử lý',
];
$salaryMonth = $latestSalary
    ? 'Tháng '.str_pad((string) $latestSalary->month, 2, '0', STR_PAD_LEFT).'/'.$latestSalary->year
    : 'Chưa có kỳ lương';
$salaryStatus = $latestSalary ? ($salaryStatusMap[$latestSalary->status] ?? $latestSalary->status) : 'Chưa có dữ liệu';
$checkInToday = $todayAttendance?->check_in_at
    ? \Carbon\Carbon::parse($todayAttendance->check_in_at)->format('H:i')
    : 'Chưa chấm công';
$leaveTypeMap = [
    'annual' => 'Nghỉ phép năm',
    'sick' => 'Nghỉ ốm',
    'unpaid' => 'Nghỉ không lương',
    'personal' => 'Nghỉ việc riêng',
];
@endphp

<div class="dashboard-welcome">
    <div>
        <h3 class="welcome-title">Xin chào, {{ $employee?->full_name ?? session('user_name') }}!</h3>
        <p class="welcome-subtitle">Chúc bạn một ngày làm việc hiệu quả.</p>
    </div>
    <div>
        <span class="badge badge-{{ $employeeStatus['class'] }} status-badge">
            Trạng thái: {{ $employeeStatus['label'] }}
        </span>
    </div>
</div>

@if(! $employee)
<div class="alert alert-error">Không tìm thấy hồ sơ nhân sự của tài khoản này.</div>
@endif

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-title">Check-in Hôm Nay</div>
        <div class="stat-card-value">{{ $checkInToday }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-title">Nghỉ Phép Đã Duyệt</div>
        <div class="stat-card-value">
            {{ (int) $approvedLeaveDays }}
            <span class="stat-card-subtext">ngày trong năm</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-title">Lương {{ $salaryMonth }}</div>
        <div class="stat-card-value {{ $latestSalary?->status === 'paid' ? 'success' : '' }}">{{ $salaryStatus }}</div>
    </div>
</div>

<div class="content-grid">
    <div class="content-card">
        <h4 class="content-card-header">Thông Tin Hồ Sơ</h4>

        <div class="profile-info-list">
            <div class="profile-info-item">
                <span class="profile-info-label">Mã Nhân Viên</span>
                <strong class="profile-info-value">{{ $employee?->employee_code ?? 'Chưa có' }}</strong>
            </div>
            <div class="profile-info-item">
                <span class="profile-info-label">Chức Vụ</span>
                <strong class="profile-info-value">{{ $employee?->position?->name ?? 'Chưa có' }}</strong>
            </div>
            <div class="profile-info-item">
                <span class="profile-info-label">Ngày Vào Làm</span>
                <strong class="profile-info-value">
                    {{ $employee?->hire_date ? \Carbon\Carbon::parse($employee->hire_date)->format('d/m/Y') : 'Chưa có' }}
                </strong>
            </div>
        </div>
    </div>

    <div class="content-card">
        <div class="content-card-header-flex">
            <h4>Đơn Nghỉ Phép Gần Đây</h4>
            <a href="{{ route('leaves.index') }}" class="link-view-all">Xem tất cả</a>
        </div>

        @if($recentLeaves->count() > 0)
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
                    @foreach($recentLeaves as $leave)
                    @php
                        $statusMap = [
                            'pending'   => ['label' => 'Chờ duyệt', 'class' => 'warning'],
                            'approved'  => ['label' => 'Đã duyệt',  'class' => 'success'],
                            'rejected'  => ['label' => 'Từ chối',   'class' => 'danger'],
                            'cancelled' => ['label' => 'Đã hủy',    'class' => 'secondary'],
                        ];
                        $s = $statusMap[$leave->status] ?? ['label' => $leave->status, 'class' => 'secondary'];
                    @endphp
                    <tr>
                        <td>
                            <strong>{{ $leaveTypeMap[$leave->leave_type] ?? $leave->leave_type }}</strong><br>
                            <small class="text-muted">{{ $leave->days }} ngày</small>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('d/m/Y') }}</td>
                        <td><span class="badge badge-{{ $s['class'] }}">{{ $s['label'] }}</span></td>
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
            <a href="{{ route('leaves.create') }}" class="btn btn-primary w-100" style="text-decoration: none; box-sizing: border-box;">Tạo đơn nghỉ phép mới</a>
        </div>
    </div>
</div>

@endsection
