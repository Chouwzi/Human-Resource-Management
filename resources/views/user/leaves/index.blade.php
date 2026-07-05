@extends('layouts.app')

@section('title', 'Lịch Sử Nghỉ Phép')
@section('header_title', 'Lịch Sử Đơn Nghỉ Phép')

@section('content')
<div class="leave-history-container">

    <div class="content-card">
        <h4 class="content-card-header">
            <i class="fas fa-clock-rotate-left" style="color: var(--primary-color);"></i>
            Lịch Sử Đơn Của Tôi
        </h4>

        {{-- Giữ lại thông báo lỗi/thành công phòng trường hợp xóa/hủy đơn --}}
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        <div class="table-responsive m-0">
            <table class="table" style="min-width: 800px;">
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
                        <td>{{ $item->start_date }} &rarr; {{ $item->end_date }}</td>
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
                            Bạn chưa có dữ liệu nghỉ phép nào.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
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
    max-width: 250px; /* Nới rộng độ dài hiển thị lý do vì bảng đã chiếm full màn hình */
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
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