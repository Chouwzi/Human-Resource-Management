@extends('layouts.app')

@section('title', 'Lịch Sử Nghỉ Phép')
@section('header_title', 'Lịch Sử Đơn Nghỉ Phép')

@section('content')
<div class="content-grid" style="display: block;">

    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <a href="{{ route('leaves.create') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-2"></i> Tạo đơn nghỉ phép mới
            </a>
        </div>
    </div>

    <div class="content-card">
        <h4 class="content-card-header m-0" style="border: none; padding-bottom: 1rem;">Danh Sách Đơn Đã Gửi</h4>

        <div class="table-responsive m-0">
            <table class="table" style="min-width: 900px;">
                <thead>
                    <tr>
                        <th style="width: 5%;">STT</th>
                        <th style="width: 15%;">Loại Đơn</th>
                        <th style="width: 20%;">Thời Gian Nghỉ</th>
                        <th style="width: 10%;">Số Ngày</th>
                        <th style="width: 25%;">Lý Do</th>
                        <th style="width: 10%; text-align: center;">Trạng Thái</th>
                        <th style="width: 15%; text-align: center;">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leavesHistory as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td style="text-align: left;">
                            <strong>
                                @if($item->leave_type == 'annual')
                                    Nghỉ phép năm
                                @elseif($item->leave_type == 'sick')
                                    Nghỉ ốm
                                @elseif($item->leave_type == 'unpaid')
                                    Nghỉ không lương
                                @else
                                    Việc cá nhân
                                @endif
                            </strong>
                        </td>
                        <td>{{ $item->start_date }} → {{ $item->end_date }}</td>
                        <td>{{ $item->days }} ngày</td>
                        <td class="reason-ellipsis" title="{{ $item->reason }}">
                             {{ $item->reason }}
                        </td>
                        
                        <td style="text-align: center;">
                            @if($item->status == 'approved')
                                <span class="badge badge-success" style="display: inline-block; margin-bottom: 0.2rem;">Đã duyệt</span>
                                @if($item->approved_by)
                                <div style="font-size: 0.75rem; color: #6b7280; line-height: 1.2; margin-top: 4px;">
                                    <i class="fas fa-user-check" style="font-size: 0.7rem;"></i> {{ $item->approved_by }}
                                </div>
                                <div style="font-size: 0.7rem; color: #9ca3af;">
                                    {{ \Carbon\Carbon::parse($item->approved_at)->format('H:i d/m/Y') }}
                                </div>
                                @endif

                            @elseif($item->status == 'pending')
                                <span class="badge badge-warning">Chờ duyệt</span>

                            @elseif($item->status == 'rejected')
                                <span class="badge badge-danger" style="display: inline-block; margin-bottom: 0.2rem;">Từ chối</span>
                                @if($item->approved_by)
                                <div style="font-size: 0.75rem; color: #6b7280; line-height: 1.2; margin-top: 4px;">
                                    <i class="fas fa-user-times" style="font-size: 0.7rem;"></i> {{ $item->approved_by }}
                                </div>
                                <div style="font-size: 0.7rem; color: #9ca3af;">
                                    {{ \Carbon\Carbon::parse($item->approved_at)->format('H:i d/m/Y') }}
                                </div>
                                @endif

                            @elseif($item->status == 'cancelled')
                                <span class="badge badge-secondary" style="background-color: #6c757d; color: #fff;">Đã Hủy</span>
                            @else
                                <span class="badge badge-light">{{ $item->status }}</span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            @if($item->status == 'pending')
                                    <form action="{{ route('leaves.cancel', $item->id) }}" method="POST" id="form-cancel-{{ $item->id }}" style="display: inline-block;">                                    
                                        @csrf
                                        <button type="button" onclick="confirmCancel('{{ $item->id }}')" class="btn btn-danger" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;" title="Hủy đơn này">
                                            <i class="fas fa-trash-alt"></i> Hủy đơn
                                        </button>
                                    </form>
                            @else
                                <form action="{{ route('leaves.destroy', $item->id) }}" method="POST" id="form-delete-{{ $item->id }}" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDeleteLeave('{{ $item->id }}')" class="btn btn-secondary btn-sm" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;" title="Xóa vĩnh viễn đơn này">
                                        <i class="fas fa-trash-alt"></i> Xóa
                                    </button>
                                </form>
                            @endif
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