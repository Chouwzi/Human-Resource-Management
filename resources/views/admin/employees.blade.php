@extends('layouts.dashboard')

@section('title', 'Quản lý Nhân sự')
@section('header_title', 'Danh sách Nhân viên')

@section('content')
<div class="admin-container">
    <div class="table-toolbar">
        <div class="toolbar-left">
            <button class="btn btn-primary"><i class="fas fa-plus"></i> Thêm Nhân viên</button>
            <button class="btn btn-outline"><i class="fas fa-file-export"></i> Xuất Excel</button>
        </div>
        <div class="toolbar-right">
            <select class="filter-select">
                <option value="">Tất cả phòng ban</option>
                <option value="IT">Công nghệ thông tin</option>
                <option value="HR">Hành chính Nhân sự</option>
                <option value="MKT">Marketing</option>
            </select>
        </div>
    </div>

    <div class="table-responsive content-card" style="padding: 20px;">
        <table class="admin-table" style="margin-bottom: 0;">
            <thead>
                <tr>
                    <th>Mã NV</th>
                    <th>Họ và Tên</th>
                    <th>Email</th>
                    <th>Phòng Ban</th>
                    <th>Trạng Thái</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>NV001</td>
                    <td>Nguyễn Văn A</td>
                    <td>nva@gmail.com</td>
                    <td>Công nghệ thông tin</td>
                    <td><span class="badge badge-success">Đang làm việc</span></td>
                    <td>
                        <button class="btn-icon text-primary"><i class="fas fa-edit"></i></button>
                        <button class="btn-icon text-danger"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>NV002</td>
                    <td>Trần Thị B</td>
                    <td>ttb@gmail.com</td>
                    <td>Hành chính Nhân sự</td>
                    <td><span class="badge badge-warning">Nghỉ phép</span></td>
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