@extends('layouts.dashboard')

@section('title', 'Quản lý Phòng ban')
@section('header_title', 'Danh sách Phòng ban')

@section('content')
<div class="admin-container">
    <div class="table-toolbar">
        <div class="toolbar-left">
            <button class="btn btn-primary"><i class="fas fa-plus"></i> Thêm Phòng ban</button>
        </div>

        <div class="toolbar-right">
            <div class="search-box" style="width: 250px;">
                <input type="text" class="search-input" placeholder="Tìm tên phòng ban...">
                <i class="fas fa-search search-icon" style="top: 50%; transform: translateY(-50%);"></i>
            </div>
        </div>
    </div>

    <div class="table-responsive content-card" style="padding: 20px;">
        <table class="admin-table" style="margin-bottom: 0;">
            <thead>
                <tr>
                    <th>Mã PB</th>
                    <th>Tên Phòng Ban</th>
                    <th>Trưởng Phòng</th>
                    <th>Số Nhân Viên</th>
                    <th>Trạng Thái</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>PB001</td>
                    <td>Công nghệ thông tin</td>
                    <td>Nguyễn Văn A</td>
                    <td>15</td>
                    <td><span class="badge badge-success">Hoạt động</span></td>
                    <td>
                        <button class="btn-icon text-primary"><i class="fas fa-edit"></i></button>
                        <button class="btn-icon text-danger"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>PB002</td>
                    <td>Hành chính Nhân sự</td>
                    <td>Trần Thị B</td>
                    <td>5</td>
                    <td><span class="badge badge-success">Hoạt động</span></td>
                    <td>
                        <button class="btn-icon text-primary"><i class="fas fa-edit"></i></button>
                        <button class="btn-icon text-danger"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>PB003</td>
                    <td>Marketing</td>
                    <td><em style="color: #9ca3af;">Chưa bổ nhiệm</em></td>
                    <td>8</td>
                    <td><span class="badge badge-warning">Tạm ngưng</span></td>
                    <td>
                        <button class="btn-icon text-primary"><i class="fas fa-edit"></i></button>
                        <button class="btn-icon text-danger"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection