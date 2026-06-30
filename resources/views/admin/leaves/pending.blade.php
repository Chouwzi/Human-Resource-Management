@extends('layouts.app')

@section('title', 'Duyệt Đơn Nghỉ Phép')
@section('header_title', 'Danh Sách Đơn Chờ Duyệt')

@section('content')
<div class="content-grid pending-grid">
    <div class="content-card">
        <h4 class="content-card-header pending-header">Đơn Chờ Xử Lý</h4>

        <div class="table-responsive m-0">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th class="w-5">STT</th>
                        <th class="w-20 text-left">Nhân Viên</th>
                        <th class="w-15">Loại Đơn</th>
                        <th class="w-20">Thời Gian</th>
                        <th class="w-20 text-left">Lý Do</th>
                        <th class="w-20 text-center">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingLeaves as $index => $item)
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
                        <td>
                            {{ $item->start_date }} → {{ $item->end_date }}<br>
                            <span class="text-muted-sm">({{ $item->days }} ngày)</span>
                        </td>
                        <td class="reason-ellipsis" title="{{ $item->reason }}">
                             {{ $item->reason }}
                        </td>
                        <td class="text-center">
                            
                            <form action="{{ route('admin.leaves.approve', $item->id) }}" method="POST" id="form-approve-{{ $item->id }}" class="form-action">
                                @csrf
                                <button type="button" onclick="confirmApprove('{{ $item->id }}')" class="btn btn-success btn-action" title="Phê duyệt">
                                    <i class="fas fa-check"></i> Duyệt
                                </button>
                            </form>
                            
                            <form action="{{ route('admin.leaves.reject', $item->id) }}" method="POST" id="form-reject-{{ $item->id }}" class="form-action form-reject">                                @csrf
                                <button type="button" onclick="confirmReject('{{ $item->id }}')" class="btn btn-danger btn-action" title="Từ chối">
                                    <i class="fas fa-times"></i> Từ chối
                                </button>
                            </form>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush