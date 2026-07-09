@extends('layouts.app')

@section('title', 'Chấm công')
@section('header_title', 'Quản lý chấm công')

@section('content')
@include('admin.hrm.partials.flash')

<div class="content-card">
    <h4 class="content-card-header">Nhập chấm công</h4>
    <form method="POST" action="{{ route('admin.attendance.store') }}" class="hrm-form hrm-form-grid">
        @csrf
        <div>
            <label>Nhân viên</label>
            <div style="display: flex; gap: 0.5rem; margin-bottom: 0.5rem;">
                <select id="filter_department" style="flex: 1;" title="Lọc danh sách nhân viên theo phòng ban">
                    <option value="">-- Tất cả phòng ban --</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                    @endforeach
                </select>
                <select id="filter_position" style="flex: 1;" title="Lọc danh sách nhân viên theo chức vụ">
                    <option value="">-- Tất cả chức vụ --</option>
                    @foreach($positions as $pos)
                        <option value="{{ $pos->id }}" data-dept="{{ $pos->department_id }}">{{ $pos->name }}</option>
                    @endforeach
                </select>
            </div>
            <select name="employee_id" id="employee_select" title="Chọn nhân viên cần chấm công" required>
                <option value="">-- Chọn nhân viên --</option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}" 
                            data-dept="{{ $employee->position->department_id ?? '' }}" 
                            data-pos="{{ $employee->position_id ?? '' }}"
                            @selected(old('employee_id') == $employee->id)>
                        {{ $employee->employee_code }} - {{ $employee->full_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Ngày làm việc</label>
            <input name="work_date" type="date" title="Chọn ngày làm việc" value="{{ old('work_date', now()->toDateString()) }}" required>
        </div>
        <div>
            <label>Check-in</label>
            <input name="check_in_at" type="time" title="Giờ vào làm thực tế" value="{{ old('check_in_at', '08:00') }}">
        </div>
        <div>
            <label>Check-out</label>
            <input name="check_out_at" type="time" title="Giờ tan làm thực tế" value="{{ old('check_out_at', '17:00') }}">
        </div>
        <div>
            <label>Trạng thái</label>
            <select name="status" title="Chọn trạng thái đi làm" required>
                <option value="present">Có mặt</option>
                <option value="late">Đi muộn</option>
                <option value="absent">Vắng</option>
                <option value="leave">Nghỉ phép</option>
            </select>
        </div>
        <div>
            <label>Ghi chú</label>
            <input name="note" title="Nhập ghi chú thêm nếu cần" value="{{ old('note') }}" maxlength="255">
        </div>
        <div class="hrm-form-full">
            <button class="btn btn-primary" type="submit" title="Lưu thông tin chấm công vừa nhập">Lưu chấm công</button>
        </div>
    </form>
</div>

<div class="content-card">
    <div class="content-card-header-flex">
        <h4>Bảng chấm công</h4>
        <div style="display: flex; gap: 1rem; align-items: center;">
            {{-- Nút chốt công --}}
            <form method="POST" action="{{ route('attendance.finalize') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="btn btn-secondary" title="Khóa dữ liệu chấm công ngày hôm qua" onclick="return confirm('Chốt công cho ngày hôm nay?')">
                    <i class="fas fa-check-circle"></i> Chốt công hôm nay
                </button>
            </form>

            {{-- Nút xuất dữ liệu CSV --}}
            <a href="{{ route('admin.attendance.export', ['month' => $month, 'year' => $year]) }}" class="btn btn-primary" title="Tải xuống tệp CSV chấm công tháng này">
                <i class="fas fa-file-csv"></i> Xuất CSV
            </a>

            {{-- Lọc dữ liệu theo tháng --}}
            <form method="GET" action="{{ route('admin.attendance.index') }}" style="display: flex; align-items: center; gap: 0.5rem; margin: 0;">
                <select name="month" title="Chọn tháng cần xem bảng chấm công" style="padding: 0.35rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                    @for($m=1; $m<=12; $m++)
                        <option value="{{ sprintf('%02d', $m) }}" @selected($month == $m)>Tháng {{ $m }}</option>
                    @endfor
                </select>
                <button type="submit" class="btn btn-secondary" title="Lọc bảng chấm công theo tháng đã chọn" style="padding: 0.35rem 0.75rem;">Lọc</button>
            </form>
        </div>
    </div>
    <div class="table-responsive m-0">
        <table class="table">
            <thead>
                <tr>
                    <th>Ngày</th>
                    <th>Nhân viên</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Phút làm</th>
                    <th>Tăng ca</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                @php
                    $statusMap = [
                        'present' => ['class' => 'badge-success', 'text' => 'Đúng giờ', 'title' => 'Đi làm đúng giờ quy định'],
                        'late'    => ['class' => 'badge-warning', 'text' => 'Đi muộn', 'title' => 'Đi làm muộn so với giờ quy định'],
                        'absent'  => ['class' => 'badge-danger', 'text' => 'Vắng mặt', 'title' => 'Không đi làm và không có lý do báo trước'],
                        'leave'   => ['class' => 'badge-info', 'text' => 'Nghỉ phép', 'title' => 'Nghỉ phép đã được phê duyệt']
                    ];
                    $s = $statusMap[$log->status] ?? ['class' => '', 'text' => $log->status, 'title' => 'Trạng thái chấm công'];
                @endphp
                <tr>
                    <td><strong>{{ date('d/m/Y', strtotime($log->work_date)) }}</strong></td>
                    <td>{{ $log->employee->full_name }}</td>
                    <td>{{ $log->check_in_at ? \Carbon\Carbon::parse($log->check_in_at)->format('H:i') : '-' }}</td>
                    <td>{{ $log->check_out_at ? \Carbon\Carbon::parse($log->check_out_at)->format('H:i') : '-' }}</td>
                    <td>{{ $log->worked_minutes }} phút</td>
                    <td style="color: var(--info);">{{ $log->overtime_minutes }} phút</td>
                    <td>
                        <span class="badge {{ $s['class'] }}" title="{{ $s['title'] }}">{{ $s['text'] }}</span>
                        @if($log->note)
                            <br><small style="color: var(--text-muted);">({{ $log->note }})</small>
                        @endif
                    </td>
                    <td>
                        <div class="table-actions">
                            <form method="POST" action="{{ route('admin.attendance.destroy', $log) }}">
                                @csrf
                                @method('DELETE')
                                @php $logDate = date('d/m/Y', strtotime($log->work_date)); @endphp
                                <button class="btn btn-danger btn-sm" type="submit" title="Xóa bản ghi chấm công này"
                                    onclick="return confirm('Xóa chấm công ngày {{ $logDate }} của {{ $log->employee->full_name }}?')">
                                    <i class="fas fa-trash-alt"></i> Xóa
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center" style="color: var(--text-muted); padding: 2rem 0;">Chưa có dữ liệu chấm công.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('styles')
@include('admin.hrm.partials.styles')
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterDept = document.getElementById('filter_department');
    const filterPos = document.getElementById('filter_position');
    const employeeSelect = document.getElementById('employee_select');
    
    if (filterDept && filterPos && employeeSelect) {
        const originalOptions = Array.from(employeeSelect.options);
        const originalPosOptions = Array.from(filterPos.options);
        
        function filterEmployees() {
            const selectedDept = filterDept.value;
            const selectedPos = filterPos.value;
            
            // Lọc danh sách chức vụ theo phòng ban
            filterPos.innerHTML = '';
            originalPosOptions.forEach(opt => {
                if (opt.value === '' || !selectedDept || opt.getAttribute('data-dept') === selectedDept) {
                    filterPos.appendChild(opt);
                }
            });
            if (Array.from(filterPos.options).some(opt => opt.value === selectedPos)) {
                filterPos.value = selectedPos;
            } else {
                filterPos.value = '';
            }
            
            // Lọc danh sách nhân viên theo phòng ban và chức vụ
            const finalDept = filterDept.value;
            const finalPos = filterPos.value;
            
            employeeSelect.innerHTML = '';
            originalOptions.forEach(opt => {
                const optDept = opt.getAttribute('data-dept');
                const optPos = opt.getAttribute('data-pos');
                
                const matchDept = !finalDept || optDept === finalDept;
                const matchPos = !finalPos || optPos === finalPos;
                
                if (opt.value === '' || (matchDept && matchPos)) {
                    employeeSelect.appendChild(opt);
                }
            });
        }
        
        filterDept.addEventListener('change', filterEmployees);
        filterPos.addEventListener('change', filterEmployees);
    }
});
</script>
@endpush
