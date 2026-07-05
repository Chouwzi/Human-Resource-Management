@extends('layouts.app')

@section('title', 'Lịch sử nghỉ phép')
@section('header_title', 'Lịch sử nghỉ phép')

@section('content')
<div class="content-card">
    <div class="content-card-header-flex">
        <h4>Lịch sử đơn nghỉ phép</h4>
        <a href="{{ route('leaves.create') }}" class="btn btn-primary">Tạo đơn mới</a>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert-error">{{ session('error') }}</div>
    @endif

    <div class="table-responsive m-0">
        <table class="table" style="min-width: 650px;">
            <thead>
                <tr>
                    <th style="width:5%">STT</th>
                    <th style="width:18%">Loại đơn</th>
                    <th style="width:22%">Thời gian</th>
                    <th style="width:8%">Ngày</th>
                    <th style="width:22%">Lý do</th>
                    <th style="width:13%; text-align:center">Trạng thái</th>
                    <th style="width:12%; text-align:center">Thao tác</th>
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
                    <td>{{ $item->start_date }} -> {{ $item->end_date }}</td>
                    <td>{{ $item->days }} ngày</td>
                    <td class="reason-ellipsis" title="{{ $item->reason }}">{{ $item->reason }}</td>

                    <td style="text-align:center">
                        @if($item->status == 'approved')
                            <span class="badge badge-success">Đã duyệt</span>
                            @if($item->approved_by)
                            <div class="approval-note">
                                <i class="fas fa-user-check"></i> {{ $item->approved_by }}
                            </div>
                            @endif
                        @elseif($item->status == 'pending')
                            <span class="badge badge-warning">Chờ duyệt</span>
                        @elseif($item->status == 'rejected')
                            <span class="badge badge-danger">Từ chối</span>
                            @if($item->approved_by)
                            <div class="approval-note">
                                <i class="fas fa-user-times"></i> {{ $item->approved_by }}
                            </div>
                            @endif
                        @elseif($item->status == 'cancelled')
                            <span class="badge badge-secondary">Đã hủy</span>
                        @endif
                    </td>

                    <td style="text-align:center">
                        @if($item->status == 'pending')
                            <form action="{{ route('leaves.cancel', $item->id) }}" method="POST"
                                  id="form-cancel-{{ $item->id }}" class="inline-action-form">
                                @csrf
                                <button type="button" onclick="confirmCancel('{{ $item->id }}')"
                                        class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash-alt"></i> Hủy
                                </button>
                            </form>
                        @else
                            <form action="{{ route('leaves.destroy', $item->id) }}" method="POST"
                                  id="form-delete-{{ $item->id }}" class="inline-action-form">
                                @csrf @method('DELETE')
                                <button type="button" onclick="confirmDeleteLeave('{{ $item->id }}')"
                                        class="btn btn-secondary btn-sm">
                                    <i class="fas fa-trash-alt"></i> Xóa
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center empty-state">
                        Bạn chưa tạo đơn nghỉ phép nào.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('styles')
<style>
.reason-ellipsis {
    max-width: 180px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.approval-note {
    font-size: 0.72rem;
    color: #6b7280;
    margin-top: 3px;
}
.inline-action-form {
    display: inline-block;
}
.empty-state {
    padding: 2rem;
    color: #9ca3af;
    font-style: italic;
}
.alert-success {
    background: #d1fae5;
    color: #065f46;
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
    font-size: 0.875rem;
}
.alert-error {
    background: #fee2e2;
    color: #991b1b;
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
    font-size: 0.875rem;
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
