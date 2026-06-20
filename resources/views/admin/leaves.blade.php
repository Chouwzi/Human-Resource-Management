@extends('layouts.dashboard')

@section('title', 'Quản lý Nghỉ phép')
@section('header_title', 'Đơn Nghỉ Chờ Duyệt')

@section('content')
<div class="admin-container">
    <div class="table-toolbar">
        <div class="toolbar-left">
            <button class="btn btn-outline"><i class="fas fa-file-export"></i> Xuất Danh sách</button>
        </div>
        <div class="toolbar-right">
            <select class="filter-select">
                <option value="pending">Chờ duyệt</option>
                <option value="approved">Đã phê duyệt</option>
                <option value="rejected">Đã từ chối</option>
                <option value="all">Tất cả đơn</option>
            </select>
        </div>
    </div>

    <div class="table-responsive content-card" style="padding: 20px;">
        <table class="admin-table" style="margin-bottom: 0;">
            <thead>
                <tr>
                    <th>Mã Đơn</th>
                    <th>Nhân Viên</th>
                    <th>Loại Nghỉ</th>
                    <th>Thời Gian Nghỉ</th>
                    <th>Lý Do</th>
                    <th>Trạng Thái</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>ĐNP001</td>
                    <td>Nguyễn Văn A</td>
                    <td>Nghỉ phép năm</td>
                    <td>22/06/2026 - 24/06/2026 (3 ngày)</td>
                    <td>Giải quyết công việc gia đình</td>
                    <td><span class="badge badge-warning">Chờ duyệt</span></td>
                    <td>
                        <button class="btn-icon text-success" title="Duyệt đơn"><i class="fas fa-check"></i></button>
                        <button class="btn-icon text-danger" title="Từ chối đơn"><i class="fas fa-times"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>ĐNP002</td>
                    <td>Trần Thị B</td>
                    <td>Nghỉ bệnh</td>
                    <td>25/06/2026 (1 ngày)</td>
                    <td>Đi khám bệnh định kỳ</td>
                    <td><span class="badge badge-warning">Chờ duyệt</span></td>
                    <td>
                        <button class="btn-icon text-success" title="Duyệt đơn"><i class="fas fa-check"></i></button>
                        <button class="btn-icon text-danger" title="Từ chối đơn"><i class="fas fa-times"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>ĐNP003</td>
                    <td>Lê Văn C</td>
                    <td>Nghỉ việc riêng</td>
                    <td>15/06/2026 (0.5 ngày)</td>
                    <td>Giải quyết thủ tục giấy tờ</td>
                    <td><span class="badge badge-success">Đã duyệt</span></td>
                    <td>
                        <span style="color: #9ca3af; font-size: 13px; font-style: italic;">Đã xử lý</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection