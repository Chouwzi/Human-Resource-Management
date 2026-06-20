@extends('layouts.dashboard')

@section('title', 'Chấm Công')
@section('header_title', 'Chấm Công (Hôm nay)')

@section('content')
<div class="admin-container">
    <div class="table-toolbar">
        <div class="toolbar-left">
            <button class="btn btn-outline"><i class="fas fa-file-excel"></i> Xuất Báo Cáo</button>
        </div>
        <div class="toolbar-right" style="display: flex; gap: 10px; align-items: center;">
            <label for="attendance-date" style="font-size: 14px; font-weight: 500; color: #4b5563;">Ngày:</label>
            <input type="date" id="attendance-date" class="filter-select" value="2026-06-21">
        </div>
    </div>

    <div class="table-responsive content-card" style="padding: 20px;">
        <table class="admin-table" style="margin-bottom: 0;">
            <thead>
                <tr>
                    <th>Mã NV</th>
                    <th>Nhân Viên</th>
                    <th>Giờ Đến (Check-in)</th>
                    <th>Giờ Về (Check-out)</th>
                    <th>Trạng Thái</th>
                    <th>Ghi Chú</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>NV001</td>
                    <td>Trung Nguyên</td>
                    <td><span style="color: #166534; font-weight: 600;">07:50</span></td>
                    <td><span style="color: #166534; font-weight: 600;">17:05</span></td>
                    <td><span class="badge badge-success">Đúng giờ</span></td>
                    <td></td>
                </tr>
                <tr>
                    <td>NV002</td>
                    <td>Nhật Minh</td>
                    <td><span style="color: #991b1b; font-weight: 600;">08:15</span></td>
                    <td>--:--</td>
                    <td><span class="badge badge-warning">Đi muộn</span></td>
                    <td style="color: #6b7280; font-size: 13px;">Quên thẻ</td>
                </tr>
                <tr>
                    <td>NV003</td>
                    <td>Duy Nam</td>
                    <td><span style="color: #166534; font-weight: 600;">07:55</span></td>
                    <td><span style="color: #166534; font-weight: 600;">17:00</span></td>
                    <td><span class="badge badge-success">Đúng giờ</span></td>
                    <td></td>
                </tr>
                <tr>
                    <td>NV004</td>
                    <td>Hồ Văn Mạnh</td>
                    <td>--:--</td>
                    <td>--:--</td>
                    <td><span class="badge badge-danger">Vắng mặt</span></td>
                    <td style="color: #6b7280; font-size: 13px;">Chưa rõ lý do</td>
                </tr>
                <tr>
                    <td>NV005</td>
                    <td>Thế Đoàn</td>
                    <td><span style="color: #166534; font-weight: 600;">08:00</span></td>
                    <td>--:--</td>
                    <td><span class="badge badge-success">Đúng giờ</span></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection