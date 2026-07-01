@extends('layouts.app')

@section('content')
<div class="admin-container">
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="page-title">Quản Lý Nhân Viên</h2>
            <p class="text-muted">Xem, thêm, sửa và cập nhật thông tin nhân sự trong công ty.</p>
        </div>
        <a href="#" class="btn btn-primary d-flex align-items-center gap-2">
            <i class="fas fa-user-plus"></i> Thêm Nhân Viên Mới
        </a>
    </div>

    <div class="card card-filter mb-4 shadow-sm border-0">
        <div class="card-body">
            <form action="#" method="GET" class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Tìm theo mã NV, tên, email...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="department_id" class="form-select">
                        <option value="">-- Tất cả phòng ban --</option>
                        <option value="1">Phòng Công nghệ thông tin</option>
                        <option value="2">Phòng Nhân sự</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="position_id" class="form-select">
                        <option value="">-- Tất cả chức vụ --</option>
                        <option value="1">Lập trình viên</option>
                        <option value="2">Trưởng phòng</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary w-100">Lọc kết quả</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card card-table shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-uppercase fs-7">
                        <tr>
                            <th class="ps-4" style="width: 100px;">Mã NV</th>
                            <th>Nhân viên</th>
                            <th>Thông tin liên hệ</th>
                            <th>Phòng ban</th>
                            <th>Chức vụ</th>
                            <th>Trạng thái</th>
                            <th class="text-end pe-4" style="width: 150px;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">NV-2026</td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-placeholder rounded-circle bg-primary-soft text-primary d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                                        KL
                                    </div>
                                    <div>
                                        <div class="fw-bold mb-0">Kim Long</div>
                                        <small class="text-muted">Ngày vào làm: 01/06/2026</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>long.kim@example.com</div>
                                <small class="text-muted">0901234567</small>
                            </td>
                            <td><span class="badge bg-info-soft text-info">Phòng CNTT</span></td>
                            <td><span class="text-dark">Lập trình viên Backend</span></td>
                            <td><span class="badge bg-success">Đang làm việc</span></td>
                            <td class="text-end pe-4">
                                <div class="btn-group gap-1">
                                    <a href="#" class="btn btn-sm btn-icon btn-light" title="Sửa"><i class="fas fa-edit text-warning"></i></a>
                                    <button type="button" class="btn btn-sm btn-icon btn-light" title="Xóa" onclick="return confirm('Bạn có chắc chắn muốn xóa nhân viên này?')">
                                        <i class="fas fa-trash-alt text-danger"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">NV-2027</td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-placeholder rounded-circle bg-success-soft text-success d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                                        CM
                                    </div>
                                    <div>
                                        <div class="fw-bold mb-0">Chun Ming</div>
                                        <small class="text-muted">Ngày vào làm: 15/06/2026</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>ming.chun@example.com</div>
                                <small class="text-muted">0907654321</small>
                            </td>
                            <td><span class="badge bg-info-soft text-info">Phòng Nhân Sự</span></td>
                            <td><span class="text-dark">Trưởng phòng</span></td>
                            <td><span class="badge bg-warning text-dark">Thử việc</span></td>
                            <td class="text-end pe-4">
                                <div class="btn-group gap-1">
                                    <a href="#" class="btn btn-sm btn-icon btn-light" title="Sửa"><i class="fas fa-edit text-warning"></i></a>
                                    <button type="button" class="btn btn-sm btn-icon btn-light" title="Xóa" onclick="return confirm('Bạn có chắc chắn muốn xóa nhân viên này?')">
                                        <i class="fas fa-trash-alt text-danger"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center p-3 shadow-sm-top">
            <small class="text-muted">Hiển thị 1 - 2 trong tổng số 2 nhân viên</small>
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item disabled"><a class="page-link" href="#">Trước</a></li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">Sau</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>
@endsection