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
            <select name="employee_id" required>
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
            <input name="contract_code" value="{{ old('contract_code', $editingContract->contract_code ?? '') }}" maxlength="50" required>
            @error('contract_code')<small class="form-error">{{ $message }}</small>@enderror
        </div>
        <div>
            <label>Loại hợp đồng</label>
            <select name="contract_type" required>
                <option value="probation" @selected(old('contract_type', $editingContract->contract_type ?? '') === 'probation')>Thử việc</option>
                <option value="fixed_term" @selected(old('contract_type', $editingContract->contract_type ?? '') === 'fixed_term')>Có thời hạn</option>
                <option value="indefinite" @selected(old('contract_type', $editingContract->contract_type ?? '') === 'indefinite')>Không xác định thời hạn</option>
            </select>
            @error('contract_type')<small class="form-error">{{ $message }}</small>@enderror
        </div>
        <div>
            <label>Trạng thái</label>
            <select name="status" required>
                <option value="active" @selected(old('status', $editingContract->status ?? '') === 'active')>Đang hiệu lực</option>
                <option value="expired" @selected(old('status', $editingContract->status ?? '') === 'expired')>Hết hạn</option>
                <option value="terminated" @selected(old('status', $editingContract->status ?? '') === 'terminated')>Đã chấm dứt</option>
            </select>
            @error('status')<small class="form-error">{{ $message }}</small>@enderror
        </div>
        <div>
            <label>Ngày bắt đầu</label>
            <input name="start_date" type="date" value="{{ old('start_date', optional($editingContract?->start_date)->format('Y-m-d')) }}" required>
            @error('start_date')<small class="form-error">{{ $message }}</small>@enderror
        </div>
        <div>
            <label>Ngày kết thúc</label>
            <input name="end_date" type="date" value="{{ old('end_date', optional($editingContract?->end_date)->format('Y-m-d')) }}">
            @error('end_date')<small class="form-error">{{ $message }}</small>@enderror
        </div>
        <div>
            <label>Lương thỏa thuận</label>
            <input name="salary" type="number" min="0" step="100000" value="{{ old('salary', $editingContract->salary ?? 0) }}" required>
            @error('salary')<small class="form-error">{{ $message }}</small>@enderror
        </div>
        <div>
            <label>Giờ làm/tuần</label>
            <input name="working_hours_per_week" type="number" min="0" max="168" step="0.5" value="{{ old('working_hours_per_week', $editingContract->working_hours_per_week ?? 40) }}" required>
            @error('working_hours_per_week')<small class="form-error">{{ $message }}</small>@enderror
        </div>
        <div class="hrm-form-full">
            <button class="btn btn-primary" type="submit">{{ $editingContract ? 'Cập nhật' : 'Thêm mới' }}</button>
            @if($editingContract)
                <a href="{{ route('admin.contracts.index') }}" class="btn btn-secondary">Hủy</a>
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
                        'active'     => ['class' => 'badge-success', 'text' => 'Đang hiệu lực'],
                        'expired'    => ['class' => 'badge-danger',  'text' => 'Hết hạn'],
                        'terminated' => ['class' => 'badge-warning', 'text' => 'Đã chấm dứt'],
                    ];
                    $cs = $contractStatusMap[$contract->effective_status] ?? ['class' => '', 'text' => $contract->effective_status];
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
                    <td><span class="badge {{ $cs['class'] }}">{{ $cs['text'] }}</span></td>
                    <td>
                        <div class="table-actions">
                            <a href="{{ route('admin.contracts.index', ['edit_contract' => $contract->id]) }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-edit"></i> Sửa
                            </a>
                            @if(session('user_role') === 'admin')
                            <form method="POST" action="{{ route('admin.contracts.destroy', $contract) }}">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Xóa hợp đồng này?')">
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
