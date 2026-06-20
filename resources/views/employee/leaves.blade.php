@extends('layouts.dashboard')

@section('title', 'Đơn Nghỉ Phép Của Tôi')
@section('header_title', 'Quản lý đơn nghỉ phép')

@section('content')
<div class="admin-container">
    <div class="section-card content-card">

        <div
            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
            <h3 style="margin: 0;"><i class="fas fa-list-ul" style="color: #6b7280; margin-right: 8px;"></i> Lịch sử đơn
                từ</h3>

            <button
                style="background: #2563eb; color: white; border: none; padding: 10px 18px; border-radius: 6px; font-weight: 500; cursor: pointer; transition: 0.2s;">
                <i class="fas fa-plus"></i> Tạo đơn xin nghỉ
            </button>
        </div>

        <div style="overflow-x: auto; padding-bottom: 10px;">
            <table class="styled-table admin-table bg-white" style="width: 100%; min-width: 800px;">
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Loại nghỉ</th>
                        <th>Từ ngày - Đến ngày</th>
                        <th>Lý do</th>
                        <th>Ngày nộp</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>ĐNP001</strong></td>
                        <td>Nghỉ phép năm</td>
                        <td>25/06/2026 - 26/06/2026</td>
                        <td>Về quê giải quyết việc gia đình</td>
                        <td>19/06/2026</td>
                        <td><span class="badge badge-warning">Chờ duyệt</span></td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection