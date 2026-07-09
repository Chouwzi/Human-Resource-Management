@extends('layouts.app')

@section('title', 'Hợp đồng')
@section('header_title', 'Quản lý hợp đồng')

@section('content')
@include('admin.hrm.partials.flash')

<div class="content-card">
    <h4 class="content-card-header">{{ $editingContract ? 'Cập nhật hợp đồng' : 'Thêm hợp đồng' }}</h4>
    <form method="POST" action="{{ $editingContract ? route('admin.contracts.update', $editingContract) : route('admin.contracts.store') }}" class="hrm-form hrm-form-grid">
        @csrf
        @if($editingContract) @method('PUT') @endif

        <div>
            <label>Nhân viên</label>
            <select name="employee_id" title="Chọn nhân viên cần lập hợp đồng" required>
                <option value="">-- Chọn nhân viên --</option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}" @selected(old('employee_id', $editingContract->employee_id ?? '') == $employee->id)>
                        {{ $employee->employee_code }} - {{ $employee->full_name }}
                    </option>
                @endforeach
            </select>
            @error('employee_id')<small class="form-error">{{ $message }}</small>@enderror
        </div>
        <div>
            <label>Mã hợp đồng</label>
            <input name="contract_code" title="Nhập mã hợp đồng lao động" value="{{ old('contract_code', $editingContract->contract_code ?? '') }}" maxlength="50" required>
            @error('contract_code')<small class="form-error">{{ $message }}</small>@enderror
        </div>
        <div>
            <label>Loại hợp đồng</label>
            <select name="contract_type" title="Chọn loại hợp đồng" required>
                <option value="probation" @selected(old('contract_type', $editingContract->contract_type ?? '') === 'probation')>Thử việc</option>
                <option value="fixed_term" @selected(old('contract_type', $editingContract->contract_type ?? '') === 'fixed_term')>Có thời hạn</option>
                <option value="indefinite" @selected(old('contract_type', $editingContract->contract_type ?? '') === 'indefinite')>Không xác định thời hạn</option>
            </select>
            @error('contract_type')<small class="form-error">{{ $message }}</small>@enderror
        </div>
        <div>
            <label>Trạng thái</label>
            <select name="status" title="Chọn trạng thái hiệu lực của hợp đồng" required>
                <option value="active" @selected(old('status', $editingContract->status ?? '') === 'active')>Đang hiệu lực</option>
                <option value="expired" @selected(old('status', $editingContract->status ?? '') === 'expired')>Hết hạn</option>
                <option value="terminated" @selected(old('status', $editingContract->status ?? '') === 'terminated')>Đã chấm dứt</option>
            </select>
            @error('status')<small class="form-error">{{ $message }}</small>@enderror
        </div>
        <div>
            <label>Ngày bắt đầu</label>
            <input name="start_date" type="date" title="Chọn ngày bắt đầu hiệu lực" value="{{ old('start_date', optional($editingContract?->start_date)->format('Y-m-d')) }}" required>
            @error('start_date')<small class="form-error">{{ $message }}</small>@enderror
        </div>
        <div>
            <label>Ngày kết thúc</label>
            <input name="end_date" type="date" title="Chọn ngày kết thúc hiệu lực (bỏ trống nếu không xác định thời hạn)" value="{{ old('end_date', optional($editingContract?->end_date)->format('Y-m-d')) }}">
            @error('end_date')<small class="form-error">{{ $message }}</small>@enderror
        </div>
        <div>
            <label>Lương thỏa thuận</label>
            <input name="salary" type="number" min="0" step="100000" title="Nhập mức lương thỏa thuận (VND)" value="{{ old('salary', $editingContract->salary ?? 0) }}" required>
            @error('salary')<small class="form-error">{{ $message }}</small>@enderror
        </div>
        <div>
            <label>Giờ làm/tuần</label>
            <input name="working_hours_per_week" type="number" min="0" max="168" step="0.5" title="Nhập số giờ làm việc quy định mỗi tuần" value="{{ old('working_hours_per_week', $editingContract->working_hours_per_week ?? 40) }}" required>
            @error('working_hours_per_week')<small class="form-error">{{ $message }}</small>@enderror
        </div>
        <div class="hrm-form-full">
            <button class="btn btn-primary" type="submit" title="{{ $editingContract ? 'Lưu lại các thay đổi của hợp đồng này' : 'Tạo mới hợp đồng lao động' }}">{{ $editingContract ? 'Cập nhật' : 'Thêm mới' }}</button>
            @if($editingContract)
                <a href="{{ route('admin.contracts.index') }}" class="btn btn-secondary" title="Hủy bỏ chỉnh sửa và quay lại">Hủy</a>
            @endif
        </div>
    </form>
</div>

<div class="content-card">
    <h4 class="content-card-header">Danh sách hợp đồng</h4>
    <div class="table-responsive m-0">
        <table class="table table-dense">
            <thead>
                <tr>
                    <th>Mã HĐ</th>
                    <th>Nhân viên</th>
                    <th>Loại</th>
                    <th>Thời hạn</th>
                    <th>Lương</th>
                    <th>Giờ/tuần</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contracts as $contract)
                @php
                    $typeMap = [
                        'probation' => 'Thử việc',
                        'fixed_term' => 'Có thời hạn',
                        'indefinite' => 'Không xác định thời hạn',
                    ];
                    $contractStatusMap = [
                        'active'     => ['class' => 'badge-success', 'text' => 'Đang hiệu lực', 'title' => 'Hợp đồng đang có hiệu lực hoạt động'],
                        'expired'    => ['class' => 'badge-danger',  'text' => 'Hết hạn', 'title' => 'Hợp đồng đã quá thời hạn hiệu lực'],
                        'terminated' => ['class' => 'badge-warning', 'text' => 'Đã chấm dứt', 'title' => 'Hợp đồng lao động đã bị chấm dứt hoặc thanh lý'],
                    ];
                    $cs = $contractStatusMap[$contract->effective_status] ?? ['class' => '', 'text' => $contract->effective_status, 'title' => 'Trạng thái hiệu lực'];
                @endphp
                <tr>
                    <td><strong>{{ $contract->contract_code }}</strong></td>
                    <td>{{ $contract->employee->full_name }}</td>
                    <td>{{ $typeMap[$contract->contract_type] ?? $contract->contract_type }}</td>
                    <td>
                        {{ $contract->start_date->format('d/m/Y') }}
                        -
                        {{ $contract->end_date ? $contract->end_date->format('d/m/Y') : 'Không thời hạn' }}
                    </td>
                    <td>{{ number_format($contract->salary) }} VND</td>
                    <td>{{ $contract->working_hours_per_week }}</td>
                    <td><span class="badge {{ $cs['class'] }}" title="{{ $s['title'] ?? $cs['title'] }}">{{ $cs['text'] }}</span></td>
                    <td>
                        <div class="table-actions">
                            <a href="{{ route('admin.contracts.index', ['edit_contract' => $contract->id]) }}" class="btn btn-secondary btn-sm" title="Chỉnh sửa hợp đồng này">
                                <i class="fas fa-edit"></i> Sửa
                            </a>
                            @if(session('user_role') === 'admin')
                            <form method="POST" action="{{ route('admin.contracts.destroy', $contract) }}">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" title="Xóa hợp đồng này" onclick="return confirm('Xóa hợp đồng này?')">
                                    <i class="fas fa-trash-alt"></i> Xóa
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center">Chưa có hợp đồng nào.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('styles')
@include('admin.hrm.partials.styles')
@endpush
