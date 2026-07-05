@extends('layouts.app')

@section('title', 'Bảng lương cá nhân')
@section('header_title', 'Bảng lương cá nhân')

@section('content')
@include('admin.hrm.partials.flash')

<div class="content-card">
    <h4 class="content-card-header">Thông tin nhân viên</h4>
    <div class="profile-info-list">
        <div class="profile-info-item">
            <span class="profile-info-label">Mã nhân viên</span>
            <span class="profile-info-value">{{ $employee->employee_code }}</span>
        </div>
        <div class="profile-info-item">
            <span class="profile-info-label">Họ tên</span>
            <span class="profile-info-value">{{ $employee->full_name }}</span>
        </div>
        <div class="profile-info-item">
            <span class="profile-info-label">Chức vụ</span>
            <span class="profile-info-value">{{ $employee->position->name ?? 'Chưa cập nhật' }}</span>
        </div>
    </div>
</div>

<div class="content-card">
    <h4 class="content-card-header">Danh sách bảng lương</h4>
    <div class="table-responsive m-0">
        <table class="table">
            <thead>
                <tr>
                    <th>Tháng</th>
                    <th>Lương cơ bản</th>
                    <th>Phụ cấp</th>
                    <th>Thưởng</th>
                    <th>Khấu trừ</th>
                    <th>Thực nhận</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                @forelse($salaries as $salary)
                    <tr>
                        <td>{{ $salary->month }}/{{ $salary->year }}</td>
                        <td>{{ number_format($salary->base_salary) }} VND</td>
                        <td>{{ number_format($salary->allowance) }} VND</td>
                        <td>{{ number_format($salary->bonus) }} VND</td>
                        <td>{{ number_format($salary->deduction) }} VND</td>
                        <td><strong>{{ number_format($salary->net_salary) }} VND</strong></td>
                        <td>
                            <span class="badge badge-{{ $salary->status === 'paid' ? 'success' : 'warning' }}">
                                {{ $salary->status === 'paid' ? 'Đã trả' : 'Nháp' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Bạn chưa có bảng lương nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
