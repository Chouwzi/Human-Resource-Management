@extends('layouts.app')

@section('title', 'Lịch Sử & Đăng Ký Nghỉ Phép')
@section('header_title', 'Quản Lý Nghỉ Phép Của Tôi')

@section('content')
<div class="leave-split-layout">

    {{-- ===== CỘT TRÁI: Form đăng ký đơn mới ===== --}}
    <div class="leave-form-section">
        <div class="content-card">
            <h4 class="content-card-header">
                <i class="fas fa-pen-to-square" style="color: var(--primary-color);"></i>
                Tạo Đơn Nghỉ Phép Mới
            </h4>

            @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert-error">{{ session('error') }}</div>
            @endif

            <form action="{{ route('leaves.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="leave_type">Loại nghỉ phép</label>
                    <select name="leave_type" id="leave_type" required>
                        <option value="annual">Nghỉ phép năm (Có lương)</option>
                        <option value="sick">Nghỉ ốm (Có BHXH)</option>
                        <option value="unpaid">Nghỉ không lương</option>
                        <option value="personal">Việc riêng cá nhân</option>
                    </select>
                    @error('leave_type')<span class="form-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="start_date">Ngày bắt đầu</label>
                    <input type="date" name="start_date" id="start_date"
                           value="{{ old('start_date') }}" required>
                    @error('start_date')<span class="form-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="end_date">Ngày kết thúc</label>
                    <input type="date" name="end_date" id="end_date"
                           value="{{ old('end_date') }}" required>
                    @error('end_date')<span class="form-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="reason">Lý do chi tiết</label>
                    <textarea name="reason" id="reason" rows="3"
                              placeholder="Nhập lý do nghỉ phép..." required>{{ old('reason') }}</textarea>
                    @error('reason')<span class="form-error">{{ $message }}</span>@enderror
                </div>

                <button type="submit" class="btn btn-primary" style="width:100%; padding: 0.7rem;">
                    <i class="fas fa-paper-plane"></i> Gửi Đơn Nghỉ Phép
                </button>
            </form>
        </div>
    </div>

    {{-- ===== CỘT PHẢI: Bảng lịch sử đơn của tôi ===== --}}
    <div class="leave-history-section">
        <div class="content-card">
            <h4 class="content-card-header">
                <i class="fas fa-clock-rotate-left" style="color: var(--primary-color);"></i>
                Lịch Sử Đơn Của Tôi
            </h4>

            <div class="table-responsive m-0">
                <table class="table" style="min-width: 650px;">
                    <thead>
                        <tr>
                            <th style="width:5%">STT</th>
                            <th style="width:18%">Loại Đơn</th>
                            <th style="width:22%">Thời Gian</th>
                            <th style="width:8%">Ngày</th>
                            <th style="width:22%">Lý Do</th>
                            <th style="width:13%; text-align:center">Trạng Thái</th>
                            <th style="width:12%; text-align:center">Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leavesHistory as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>
                                    @if($item->leave_type == 'annual') Nghỉ phép năm
                                    @elseif($item->leave_type == 'sick') Nghỉ ốm
                                    @elseif($item->leave_type == 'unpaid') Nghỉ không lương
                                    @else Việc cá nhân
                                    @endif
                                </strong>
                            </td>
                            <td>{{ $item->start_date }} → {{ $item->end_date }}</td>
                            <td>{{ $item->days }} ngày</td>
                            <td class="reason-ellipsis" title="{{ $item->reason }}">{{ $item->reason }}</td>

                            <td style="text-align:center">
                                @if($item->status == 'approved')
                                    <span class="badge badge-success">Đã duyệt</span>
                                    @if($item->approved_by)
                                    <div style="font-size:0.72rem; color:#6b7280; margin-top:3px;">
                                        <i class="fas fa-user-check" style="font-size:0.68rem;"></i> {{ $item->approved_by }}
                                    </div>
                                    @endif
                                @elseif($item->status == 'pending')
                                    <span class="badge badge-warning">Chờ duyệt</span>
                                @elseif($item->status == 'rejected')
                                    <span class="badge badge-danger">Từ chối</span>
                                    @if($item->approved_by)
                                    <div style="font-size:0.72rem; color:#6b7280; margin-top:3px;">
                                        <i class="fas fa-user-times" style="font-size:0.68rem;"></i> {{ $item->approved_by }}
                                    </div>
                                    @endif
                                @elseif($item->status == 'cancelled')
                                    <span class="badge badge-secondary">Đã hủy</span>
                                @endif
                            </td>

                            <td style="text-align:center">
                                @if($item->status == 'pending')
                                    <form action="{{ route('leaves.cancel', $item->id) }}" method="POST"
                                          id="form-cancel-{{ $item->id }}" style="display:inline-block;">
                                        @csrf
                                        <button type="button"
                                                onclick="confirmCancel('{{ $item->id }}')"
                                                class="btn btn-danger"
                                                style="padding:0.25rem 0.6rem; font-size:0.75rem;">
                                            <i class="fas fa-trash-alt"></i> Hủy
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('leaves.destroy', $item->id) }}" method="POST"
                                          id="form-delete-{{ $item->id }}" style="display:inline-block;">
                                        @csrf @method('DELETE')
                                        <button type="button"
                                                onclick="confirmDeleteLeave('{{ $item->id }}')"
                                                class="btn btn-secondary"
                                                style="padding:0.25rem 0.6rem; font-size:0.75rem;">
                                            <i class="fas fa-trash-alt"></i> Xóa
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" style="text-align:center; padding:2rem; color:#9ca3af; font-style:italic;">
                                Bạn chưa tạo đơn nghỉ phép nào.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
.leave-split-layout {
    display: flex;
    gap: 1.5rem;
    align-items: flex-start;
}
.leave-form-section {
    flex: 0 0 320px;
    min-width: 280px;
}
.leave-history-section {
    flex: 1;
    min-width: 0;
    overflow-x: auto;
}
.form-group {
    margin-bottom: 1rem;
}
.form-group label {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.35rem;
}
.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 0.5rem 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    box-sizing: border-box;
    transition: border-color 0.2s;
    font-family: inherit;
}
.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--primary-color, #4f46e5);
    box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
}
.form-group textarea { resize: vertical; }
.form-error { font-size: 0.78rem; color: #dc2626; margin-top: 0.2rem; display: block; }
.alert-success {
    background: #d1fae5; color: #065f46;
    padding: 0.75rem 1rem; border-radius: 0.5rem;
    margin-bottom: 1rem; font-size: 0.875rem;
}
.alert-error {
    background: #fee2e2; color: #991b1b;
    padding: 0.75rem 1rem; border-radius: 0.5rem;
    margin-bottom: 1rem; font-size: 0.875rem;
}
.reason-ellipsis {
    max-width: 180px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
@media (max-width: 900px) {
    .leave-split-layout { flex-direction: column; }
    .leave-form-section { flex: none; width: 100%; }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmCancel(id) {
    Swal.fire({
        title: 'Hủy đơn này?',
        text: 'Bạn chắc chắn muốn hủy đơn nghỉ phép này không?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Hủy đơn',
        cancelButtonText: 'Thôi'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('form-cancel-' + id).submit();
        }
    });
}
function confirmDeleteLeave(id) {
    Swal.fire({
        title: 'Xóa đơn này?',
        text: 'Đơn đã xóa sẽ không khôi phục được.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Xóa vĩnh viễn',
        cancelButtonText: 'Thôi'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('form-delete-' + id).submit();
        }
    });
}
</script>
@endpush