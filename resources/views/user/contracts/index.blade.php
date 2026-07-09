@extends('layouts.app')

@section('title', 'Hợp đồng cá nhân')
@section('header_title', 'Hợp đồng cá nhân')

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
    <h4 class="content-card-header">Danh sách hợp đồng lao động</h4>
    <div class="table-responsive m-0">
        <table class="table">
            <thead>
                <tr>
                    <th>Mã HĐ</th>
                    <th>Loại hợp đồng</th>
                    <th>Ngày bắt đầu</th>
                    <th>Ngày kết thúc</th>
                    <th>Mức lương</th>
                    <th>Số giờ/tuần</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contracts as $contract)
                    @php
                        $typeMap = [
                            'probation' => 'Thử việc',
                            'fixed_term' => 'Có thời hạn',
                            'indefinite' => 'Không xác định thời hạn',
                        ];
                        $contractStatusMap = [
                            'active'     => ['class' => 'badge-success', 'text' => 'Đang hiệu lực'],
                            'expired'    => ['class' => 'badge-danger',  'text' => 'Hết hạn'],
                            'terminated' => ['class' => 'badge-warning', 'text' => 'Đã chấm dứt'],
                        ];
                        $effectiveStatus = $contract->effective_status;
                        $cs = $contractStatusMap[$effectiveStatus] ?? ['class' => 'badge-secondary', 'text' => $effectiveStatus];
                    @endphp
                    <tr>
                        <td><strong>{{ $contract->contract_code }}</strong></td>
                        <td>{{ $typeMap[$contract->contract_type] ?? $contract->contract_type }}</td>
                        <td>{{ $contract->start_date ? $contract->start_date->format('d/m/Y') : '' }}</td>
                        <td>{{ $contract->end_date ? $contract->end_date->format('d/m/Y') : 'Không thời hạn' }}</td>
                        <td>{{ number_format($contract->salary) }} VND</td>
                        <td>{{ $contract->working_hours_per_week }}</td>
                        <td>
                            <span class="badge {{ $cs['class'] }}">
                                {{ $cs['text'] }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Bạn chưa có hợp đồng lao động nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
