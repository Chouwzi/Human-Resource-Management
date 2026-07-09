@extends('layouts.app')

@section('title', 'Duyệt đơn nghỉ phép')
@section('header_title', 'Danh sách đơn chờ duyệt')

@section('content')
@include('admin.hrm.partials.flash')

<div class="content-grid pending-grid">
    <div class="content-card">
        <h4 class="content-card-header pending-header">Đơn chờ xử lý</h4>

        <div class="table-responsive m-0">
            <table class="table table-custom table-dense">
                <thead>
                    <tr>
                        <th class="w-5">STT</th>
                        <th style="width: 18%; text-align: left;">Nhân viên</th>
                        <th style="width: 12%;">Loại đơn</th>
                        <th style="width: 10%;">Ngày bắt đầu</th>
                        <th style="width: 10%;">Ngày kết thúc</th>
                        <th style="width: 7%;">Số ngày</th>
                        <th style="width: 18%; text-align: center;">Lý do</th>
                        <th style="width: 20%; text-align: center;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendingLeaves as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="text-left">
                            <strong>{{ $item->emp_name }}</strong><br>
                            <span class="text-muted-sm">Mã NV: {{ $item->emp_id }}</span>
                        </td>
                        <td>
                            <strong>
                                @if($item->leave_type == 'annual') Nghỉ phép năm
                                @elseif($item->leave_type == 'sick') Nghỉ ốm
                                @elseif($item->leave_type == 'unpaid') Nghỉ không lương
                                @else Việc cá nhân
                                @endif
                            </strong>
                        </td>
                        <td>{{ $item->start_date }}</td>
                        <td>{{ $item->end_date }}</td>
                        <td><strong>{{ $item->days }}</strong> ngày</td>
                        <td class="reason-ellipsis" title="Xem chi tiết lý do: {{ $item->reason }}">
                             {{ $item->reason }}
                        </td>
                        <td class="text-center">

                            <form action="{{ route('admin.leaves.approve', $item->id) }}" method="POST" id="form-approve-{{ $item->id }}" class="form-action">
                                @csrf
                                <button type="button" onclick="confirmApprove('{{ $item->id }}')" class="btn btn-success btn-action" title="Phê duyệt đơn nghỉ phép này">
                                    Duyệt
                                </button>
                            </form>

                            <form action="{{ route('admin.leaves.reject', $item->id) }}" method="POST" id="form-reject-{{ $item->id }}" class="form-action form-reject">
                                @csrf
                                <button type="button" onclick="confirmReject('{{ $item->id }}')" class="btn btn-outline-danger btn-action" title="Từ chối đơn nghỉ phép này">
                                    Từ chối
                                </button>
                            </form>

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center" style="padding: 2rem 0; color: var(--text-muted);">
                            Hiện không có đơn nghỉ phép nào đang chờ xử lý.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    <div class="content-card" style="margin-top: 2rem;">
        <h4 class="content-card-header pending-header">Lịch sử đơn đã xử lý</h4>

        <div class="table-responsive m-0">
            <table class="table table-custom table-dense">
                <thead>
                    <tr>
                        <th class="w-5">STT</th>
                        <th style="width: 18%; text-align: left;">Nhân viên</th>
                        <th style="width: 12%;">Loại đơn</th>
                        <th style="width: 10%;">Ngày bắt đầu</th>
                        <th style="width: 10%;">Ngày kết thúc</th>
                        <th style="width: 7%;">Số ngày</th>
                        <th style="width: 18%; text-align: center;">Lý do</th>
                        <th style="width: 20%; text-align: center;">Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($processedLeaves as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="text-left">
                            <strong>{{ $item->emp_name }}</strong><br>
                            <span class="text-muted-sm">Mã NV: {{ $item->emp_id }}</span>
                        </td>
                        <td>
                            <strong>
                                @if($item->leave_type == 'annual') Nghỉ phép năm
                                @elseif($item->leave_type == 'sick') Nghỉ ốm
                                @elseif($item->leave_type == 'unpaid') Nghỉ không lương
                                @else Việc cá nhân
                                @endif
                            </strong>
                        </td>
                        <td>{{ $item->start_date }}</td>
                        <td>{{ $item->end_date }}</td>
                        <td><strong>{{ $item->days }}</strong> ngày</td>
                        <td class="reason-ellipsis" title="Xem chi tiết lý do: {{ $item->reason }}">
                             {{ $item->reason }}
                        </td>
                        <td class="text-center">
                            @if($item->status == 'approved')
                                <span class="badge badge-success" title="Đơn đã được duyệt bởi {{ $item->approved_by }}">Đã duyệt</span>
                                @if($item->approved_by)
                                <div style="font-size: 0.72rem; color: var(--text-muted); margin-top: 3px;" title="Người phê duyệt: {{ $item->approved_by }}">
                                    Bởi: {{ $item->approved_by }}
                                </div>
                                @endif
                            @elseif($item->status == 'rejected')
                                <span class="badge badge-danger" title="Đơn đã bị từ chối bởi {{ $item->approved_by }}">Từ chối</span>
                                @if($item->approved_by)
                                <div style="font-size: 0.72rem; color: var(--text-muted); margin-top: 3px;" title="Người từ chối: {{ $item->approved_by }}">
                                    Bởi: {{ $item->approved_by }}
                                </div>
                                @endif
                            @else
                                <span class="badge badge-secondary" title="Trạng thái đơn: {{ $item->status }}">{{ $item->status }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center" style="padding: 2rem 0; color: var(--text-muted);">
                            Hiện chưa có lịch sử đơn nghỉ phép đã xử lý.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
