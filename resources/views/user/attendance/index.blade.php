@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card p-4 mb-4 text-center shadow-sm">
        <h4 class="mb-3">HỆ THỐNG CHẤM CÔNG HÀNG NGÀY</h4>
        <p class="text-muted">Hôm nay: {{ date('d/m/Y') }}</p>
        
        <div style="text-align: center;">
            
            <form method="POST" action="{{ route('attendance.checkin') }}" style="display: inline-block; margin: 0 5px;">
                @csrf
                <button type="submit" class="btn btn-info text-white fw-bold px-4 py-2">
                    <i class="fas fa-sign-in-alt"></i> Check-in
                </button>
            </form>

            <form method="POST" action="{{ route('attendance.checkout') }}" style="display: inline-block; margin: 0 5px;">
                @csrf
                <button type="submit" class="btn btn-danger text-white fw-bold px-4 py-2">
                    <i class="fas fa-sign-out-alt"></i> Check-out
                </button>
            </form>

        </div>
    </div>

    <div class="card shadow-sm p-3">
        <h5 class="mb-3">Lịch Sử Chấm Công Của Tôi</h5>
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Ngày</th>
                        <th>Vào Làm</th>
                        <th>Tan Làm</th>
                        <th>Số Phút Làm</th>
                        <th>Số Phút Tăng Ca</th>
                        <th>Trạng Thái</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $item)
                    <tr>
                        <td><strong>{{ date('d/m/Y', strtotime($item->work_date)) }}</strong></td>
                        <td class="text-success font-weight-bold">{{ $item->check_in ?? '--:--' }}</td>
                        <td class="text-danger font-weight-bold">{{ $item->check_out ?? '--:--' }}</td>
                        <td>{{ $item->worked_minutes }} phút</td>
                        <td class="text-info">{{ $item->overtime_minutes }} phút</td>
                        <td>
                            @php
                                $statusMap = [
                                    'present'     => ['class' => 'badge-success', 'text' => 'Đúng giờ'],
                                    'late'        => ['class' => 'badge-warning', 'text' => 'Đi muộn'],
                                    'early_leave' => ['class' => 'badge-orange',  'text' => 'Về sớm'],
                                    'absent'      => ['class' => 'badge-danger',  'text' => 'Vắng mặt']
                                ];
                                $s = $statusMap[$item->status] ?? ['class' => '', 'text' => 'Khác'];
                            @endphp

                            <span class="badge {{ $s['class'] }}">{{ $s['text'] }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-muted p-4">Bạn không có dữ liệu chấm công trong tháng này.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection