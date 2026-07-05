@extends('layouts.app')

@section('title', 'Tạo Đơn Nghỉ Phép')
@section('header_title', 'Đăng Ký Nghỉ Phép')

@section('content')
<div class="content-grid" style="display: block; max-width: 800px; margin: 0 auto;">
    
    <div class="content-card">
        <h4 class="content-card-header">Thông Tin Đơn Nghỉ Phép</h4>

        <form action="{{ route('leaves.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">Loại Nghỉ Phép <span style="color: var(--danger);">*</span></label>
                <select name="leave_type" class="form-control" required>
                    <option value="">-- Chọn loại nghỉ phép --</option>
                    <option value="annual">Nghỉ phép năm</option>
                    <option value="sick">Nghỉ ốm</option>
                    <option value="unpaid">Nghỉ không lương</option>
                    <option value="personal">Việc cá nhân</option>
                </select>
            </div>

            <div class="grid-2-cols">
                <div class="form-group m-0">
                    <label class="form-label">Từ ngày <span style="color: var(--danger);">*</span></label>
                    <input type="date" name="start_date" id="start_date" class="form-control" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                </div>
                
                <div class="form-group m-0">
                    <label class="form-label">Đến ngày <span style="color: var(--danger);">*</span></label>
                    <input type="date" name="end_date" id="end_date" class="form-control" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                </div>
            </div>

            <div class="form-group" style="margin-top: 1.5rem;">
                <label class="form-label">Lý do nghỉ <span style="color: var(--danger);">*</span></label>
                <textarea name="reason" id="reasonTextarea" class="form-control" rows="4" placeholder="Vui lòng nhập lý do chi tiết (tối đa 50 ký tự)..." maxlength="50" required></textarea>
                
                <div id="charCountNotice" style="font-size: 0.85rem; color: var(--text-muted, #6c757d); margin-top: 0.3rem;">
                    Còn lại tối đa 50 ký tự.
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('leaves.index') }}" class="btn btn-secondary">Hủy Bỏ</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane mr-2"></i> Gửi Đơn
                </button>
            </div>

        </form>
    </div>

</div>
@endsection