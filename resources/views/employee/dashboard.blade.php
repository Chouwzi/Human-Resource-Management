@extends('layouts.dashboard')

@section('title', 'Không gian làm việc')
@section('header_title', 'Tổng quan cá nhân')

@section('content')
<div class="admin-container">
    <div class="stats-grid">
        <a href="{{ route('employee.attendance') }}" class="stat-card" style="text-decoration: none; color: inherit;">
            <div class="stat-icon"><i class="fas fa-calendar-check text-success"></i></div>
            <div class="stat-details">
                <span class="stat-label">Ngày Công Của Tôi</span>
                <h3 class="stat-value">22</h3>
            </div>
        </a>

        <a href="{{ route('employee.leaves') }}" class="stat-card" style="text-decoration: none; color: inherit;">
            <div class="stat-icon"><i class="fas fa-file-alt text-warning"></i></div>
            <div class="stat-details">
                <span class="stat-label">Đơn Nghỉ Của Tôi</span>
                <h3 class="stat-value">2</h3>
            </div>
        </a>

        <div class="stat-card"
            style="text-decoration: none; color: inherit; display: flex; flex-direction: column; justify-content: center; min-height: 130px;">
            <div style="display: flex; align-items: center; gap: 15px; width: 100%;">
                <div class="stat-icon"><i class="fas fa-clock text-primary"></i></div>
                <div class="stat-details">
                    <span class="stat-label">Chấm Công Hôm Nay</span>
                    <h3 class="stat-value" style="font-size: 16px; margin-top: 2px; color: #10b981;">
                        07:55 AM
                    </h3>
                </div>
            </div>

            <div style="margin-top: 12px; width: 100%; border-top: 1px solid #f3f4f6; padding-top: 10px;">
                <a href="{{ route('employee.attendance') }}"
                    style="text-decoration: none; width: 100%; background: #10b981; color: white; border: none; padding: 8px 12px; border-radius: 6px; font-weight: 600; font-size: 13px; display: flex; justify-content: center; align-items: center; gap: 6px; text-align: center;">
                    <i class="fas fa-sign-in-alt"></i> Check-in (Vào làm)
                </a>
            </div>
        </div>
    </div>

    <div style="display: flex; gap: 20px; margin-top: 20px; flex-wrap: wrap;">

        <div class="section-card content-card" style="flex: 1; min-width: 250px; margin-bottom: 0;">
            <h3 style="margin-top: 0; border-bottom: 1px solid #e5e7eb; padding-bottom: 10px; margin-bottom: 15px;">
                <i class="fas fa-id-card" style="color: #6b7280; margin-right: 8px;"></i> Hồ Sơ Cá Nhân
            </h3>
            <div style="line-height: 1.8; color: #374151;">
                <p><strong>Mã NV:</strong> <span style="color: #2563eb; font-weight: 600;">NV001</span></p>
                <p><strong>Họ & Tên:</strong> Nguyễn Trung Nguyên</p>
                <p><strong>Phòng Ban:</strong> Công nghệ thông tin</p>
                <p><strong>Chức Vụ:</strong> Thực tập sinh Data Science</p>
                <p><strong>Email:</strong> nguyennt7698@ut.edu.vn</p>
            </div>
        </div>

        <div class="section-card content-card" style="flex: 2; min-width: 250px; margin-bottom: 0;">
            <div
                style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e5e7eb; padding-bottom: 10px; margin-bottom: 15px;">
                <h3 style="margin: 0;"><i class="fas fa-history" style="color: #6b7280; margin-right: 8px;"></i> Đơn
                    Nghỉ Gần Nhất</h3>
                <a href="{{ route('employee.leaves') }}"
                    style="font-size: 14px; color: #2563eb; text-decoration: none; font-weight: 500;">
                    Xem tất cả <i class="fas fa-arrow-right" style="margin-left: 4px; font-size: 12px;"></i>
                </a>
            </div>

            <div style="overflow-x: auto;">
                <table class="styled-table admin-table bg-white" style="margin-top: 0; min-width: 500px; width: 100%;">
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Lý do</th>
                            <th>Ngày nghỉ</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>ĐNP001</strong></td>
                            <td>Về quê giải quyết việc gia đình</td>
                            <td>25/06/2026</td>
                            <td><span class="badge badge-warning">Chờ duyệt</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection