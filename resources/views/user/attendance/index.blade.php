@extends('layouts.app')

@section('title', 'Chấm công')
@section('header_title', 'Chấm công cá nhân')

@section('content')
@include('admin.hrm.partials.flash')

<div class="content-grid">
    {{-- Thao tác chấm công --}}
    <div class="content-card text-center" style="display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 2.5rem 1.5rem;">
        <h4 style="margin-top: 0; margin-bottom: 0.5rem; color: var(--primary);">Chấm công hôm nay</h4>
        <p style="color: var(--text-muted); margin-bottom: 2rem; font-weight: 500;">Hôm nay: {{ date('d/m/Y') }}</p>
        
        <div style="display: flex; gap: 1rem; width: 100%; justify-content: center; flex-wrap: wrap;">
            <form method="POST" action="{{ route('attendance.checkin') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="btn btn-primary" title="Ghi nhận thời gian bắt đầu làm việc hôm nay" style="padding: 0.75rem 2rem; font-size: 1rem; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-sign-in-alt"></i> Check-in
                </button>
            </form>

            <form method="POST" action="{{ route('attendance.checkout') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="btn btn-danger" title="Ghi nhận thời gian kết thúc làm việc hôm nay" style="padding: 0.75rem 2rem; font-size: 1rem; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-sign-out-alt"></i> Check-out
                </button>
            </form>
        </div>
    </div>

    {{-- Lịch sử chấm công --}}
    <div class="content-card">
        <div class="content-card-header-flex">
            <h4>Lịch sử chấm công</h4>
            {{-- Lọc dữ liệu theo tháng --}}
            <form method="GET" action="{{ route('attendance.index') }}" style="display: flex; align-items: center; gap: 0.5rem; margin: 0;">
                <select name="month" title="Chọn tháng cần xem lịch sử" style="padding: 0.35rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                    @for($m=1; $m<=12; $m++)
                        <option value="{{ sprintf('%02d', $m) }}" @selected($month == $m)>Tháng {{ $m }}</option>
                    @endfor
                </select>
                <button type="submit" class="btn btn-secondary" title="Lọc lịch sử chấm công theo tháng đã chọn" style="padding: 0.35rem 0.75rem;">Lọc</button>
            </form>
        </div>

        <div class="table-responsive m-0">
            <table class="table">
                <thead>
                    <tr>
                        <th>Ngày</th>
                        <th>Vào làm</th>
                        <th>Tan làm</th>
                        <th>Thời gian làm</th>
                        <th>Tăng ca</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $item)
                    @php
                        $statusMap = [
                            'present' => ['class' => 'badge-success', 'text' => 'Đúng giờ', 'title' => 'Đi làm đúng giờ quy định'],
                            'late'    => ['class' => 'badge-warning', 'text' => 'Đi muộn', 'title' => 'Đi làm muộn so với giờ quy định'],
                            'absent'  => ['class' => 'badge-danger', 'text' => 'Vắng mặt', 'title' => 'Không đi làm và không có lý do báo trước'],
                            'leave'   => ['class' => 'badge-info', 'text' => 'Nghỉ phép', 'title' => 'Nghỉ phép đã được phê duyệt']
                        ];
                        $s = $statusMap[$item->status] ?? ['class' => '', 'text' => $item->status, 'title' => 'Trạng thái chấm công'];
                    @endphp
                    <tr>
                        <td><strong>{{ date('d/m/Y', strtotime($item->work_date)) }}</strong></td>
                        <td style="color: var(--success); font-weight: 600;">
                            {{ $item->check_in_at ? \Carbon\Carbon::parse($item->check_in_at)->format('H:i') : '--:--' }}
                        </td>
                        <td style="color: var(--danger); font-weight: 600;">
                            {{ $item->check_out_at ? \Carbon\Carbon::parse($item->check_out_at)->format('H:i') : '--:--' }}
                        </td>
                        <td>{{ $item->worked_minutes }} phút</td>
                        <td style="color: var(--info);">{{ $item->overtime_minutes }} phút</td>
                        <td>
                            <span class="badge {{ $s['class'] }}" title="{{ $s['title'] }}">{{ $s['text'] }}</span>
                            @if($item->note)
                                <br><small style="color: var(--text-muted);">({{ $item->note }})</small>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center" style="color: var(--text-muted); padding: 2rem 0;">Bạn không có dữ liệu chấm công trong tháng này.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
