@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- Khu vực thanh công cụ -->
    <div class="card p-3 mb-4">
        <!-- Dùng d-flex và justify-content-between để ép 2 khối ra 2 góc -->
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            
            <!-- KHỐI BÊN TRÁI: Nút Chốt công -->
            <div>
                <form method="POST" action="{{ route('attendance.finalize') }}" class="m-0">
                    @csrf
                    <input type="hidden" name="target_date" value="{{ date('Y-m-d') }}">
                    <!-- Bạn có thể đổi btn-light/btn-secondary tùy theo màu bạn muốn ở ảnh -->
                    <button type="submit" class="btn btn-light border font-weight-bold shadow-sm">
                        <i class="fas fa-check-circle"></i> Chốt công hôm nay ({{ date('d/m/Y') }})
                    </button>
                </form>
            </div>

            <!-- KHỐI BÊN PHẢI: Form lọc dữ liệu -->
            <div>
                <!-- Thêm d-flex vào form để Nhãn - Select - Nút nằm trên 1 hàng ngang -->
                <form method="GET" action="{{ route('attendance.index') }}" class="d-flex align-items-center m-0 gap-2">
                    <label class="form-label mb-0 font-weight-bold" style="white-space: nowrap;">Lọc theo tháng:</label>
                    
                    <select name="month" class="form-select form-control" style="width: auto; min-width: 120px;">
                        @for($m=1; $m<=12; $m++)
                            <option value="{{ sprintf('%02d', $m) }}" {{ $month == $m ? 'selected' : '' }}>
                                Tháng {{ $m }}
                            </option>
                        @endfor
                    </select>
                    
                    <button type="submit" class="btn btn-primary" style="background-color: #5a67d8; border: none;">
                        Lọc dữ liệu
                    </button>
                </form>
            </div>

        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm p-3">
        <h5 class="mb-3">Bảng Tổng Hợp Chấm Công Toàn Công Ty</h5>
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Ngày</th>
                        <th>Nhân Viên</th>
                        <th>Vào Làm</th>
                        <th>Tan Làm</th>
                        <th>Phút Làm</th>
                        <th>Tăng Ca</th>
                        <th>Trạng Thái</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $item)
                    @php
                        $statusMap = [
                            'present'     => ['class' => 'badge-success', 'text' => 'Đúng giờ'],
                            'late'        => ['class' => 'badge-warning', 'text' => 'Đi muộn'],
                            'early_leave' => ['class' => 'badge-orange',  'text' => 'Về sớm'],
                            'absent'      => ['class' => 'badge-danger',  'text' => 'Vắng mặt'],
                            'on_leave'    => ['class' => 'badge-info',    'text' => 'Nghỉ phép']
                        ];
                        // Nếu trạng thái không tồn tại, dùng class mặc định
                        $s = $statusMap[$item->status] ?? ['class' => '', 'text' => 'Khác'];
                    @endphp

                    <span class="badge {{ $s['class'] }}">{{ $s['text'] }}</span>
                    <tr>
                        <td><strong>{{ date('d/m/Y', strtotime($item->work_date)) }}</strong></td>
                        <td class="text-primary font-weight-bold">{{ $item->user->name ?? $item->user->email ?? 'ID: '.$item->employee_id }}</td>
                        <td class="text-success">{{ $item->check_in ?? '--:--' }}</td>
                        <td class="text-danger">{{ $item->check_out ?? '--:--' }}</td>
                        <td>{{ $item->worked_minutes }} p</td>
                        <td class="text-info">{{ $item->overtime_minutes }} p</td>
                        <td><span class="badge" {!! $s['attr'] !!}>{{ $s['text'] }}</span></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary" onclick="openModal('{{ $item->id }}')">Sửa</button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-muted p-4">Không có dữ liệu chấm công.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@foreach($attendances as $item)
<div id="modal{{ $item->id }}" class="my-modal" style="display: none;">
    <div class="my-modal-content">
        <div class="my-modal-header">
            <h5>Sửa chấm công - {{ date('d/m/Y', strtotime($item->work_date)) }}</h5>
            <button class="close-btn" type="button" onclick="closeModal('{{ $item->id }}')">&times;</button>
        </div>
        <form action="{{ route('attendance.update', $item->id) }}" method="POST">
            @csrf
            <div class="my-modal-body">
                <div class="form-group mb-3">
                    <label class="font-weight-bold">Giờ Vào</label>
                    <input type="time" name="check_in" class="form-control" value="{{ $item->check_in ? date('H:i', strtotime($item->check_in)) : '' }}">
                </div>
                <div class="form-group mb-3">
                    <label class="font-weight-bold">Giờ Ra</label>
                    <input type="time" name="check_out" class="form-control" value="{{ $item->check_out ? date('H:i', strtotime($item->check_out)) : '' }}">
                </div>
                <div class="form-group mb-3">
                    <label class="font-weight-bold">Trạng Thái</label>
                    <select name="status" class="form-control">
                        <option value="present" {{ $item->status == 'present' ? 'selected' : '' }}>Đúng giờ</option>
                        <option value="late" {{ $item->status == 'late' ? 'selected' : '' }}>Đi muộn</option>
                        <option value="early_leave" {{ $item->status == 'early_leave' ? 'selected' : '' }}>Về sớm</option>
                        <option value="absent" {{ $item->status == 'absent' ? 'selected' : '' }}>Vắng mặt</option>
                        <option value="on_leave" {{ $item->status == 'on_leave' ? 'selected' : '' }}>Nghỉ phép</option>
                    </select>
                </div>
            </div>
            <div class="my-modal-footer text-right">
                <button type="button" class="btn btn-secondary" onclick="closeModal('{{ $item->id }}')">Đóng</button>
                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
            </div>
        </form>
    </div>
</div>
@endforeach
@endsection