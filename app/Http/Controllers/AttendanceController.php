<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Leave;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    // 1. Danh sách chấm công theo ngày/tháng (Cho cả Admin và Nhân viên)
    public function index(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập!');
        }

        $role = strtolower(trim(session('user_role', '')));
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));

        if (in_array($role, ['admin', 'hr'], true)) {
            $attendances = Attendance::with('user')
                            ->whereMonth('work_date', $month)
                            ->whereYear('work_date', $year)
                            ->orderBy('work_date', 'desc')
                            ->get();
            return view('admin.attendance.report', compact('attendances', 'month', 'year'));
        } else {
            $attendances = Attendance::where('employee_id', session('user_id'))
                            ->whereMonth('work_date', $month)
                            ->whereYear('work_date', $year)
                            ->orderBy('work_date', 'desc')
                            ->get();
            return view('user.attendance.index', compact('attendances', 'month', 'year'));
        }
    }

    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->check_in = $request->check_in;
        $attendance->check_out = $request->check_out;
        $attendance->status = $request->status;
        
        if ($request->check_in && $request->check_out) {
            $checkInTime = Carbon::parse($attendance->work_date . ' ' . $request->check_in);
            $checkOutTime = Carbon::parse($attendance->work_date . ' ' . $request->check_out);
            $totalMinutes = abs($checkOutTime->diffInMinutes($checkInTime));
            
            $attendance->worked_minutes = ($totalMinutes > 480) ? 480 : $totalMinutes;
            $attendance->overtime_minutes = ($totalMinutes > 480) ? ($totalMinutes - 480) : 0;
        }
        $attendance->save();
        return redirect()->back()->with('success', 'Cập nhật thành công!');
    }

    // 2. Xử lý Check-in (Tạo bản ghi mới hoặc báo lỗi trùng)
    public function checkIn()
    {
        $empId = session('user_id');
        $today = Carbon::today()->toDateString(); // Lấy ngày Y-m-d hiện tại
        $now = Carbon::now();

        // Chặn trùng chấm công theo employee_id + work_date
        $exists = Attendance::where('employee_id', $empId)->where('work_date', $today)->exists();
        if ($exists) {
            return redirect()->back()->with('error', 'Hôm nay bạn đã check-in rồi!');
        }

        // Tính toán trạng thái ban đầu dựa trên giờ check-in (Sau 08:00 là đi muộn)
        $status = $now->format('H:i:s') > '08:00:00' ? 'late' : 'present';

        Attendance::create([
            'employee_id' => $empId,
            'work_date'   => $today,
            'check_in'    => $now->toTimeString(),
            'status'      => $status
        ]);

        return redirect()->back()->with('success', 'Check-in thành công lúc ' . $now->format('H:i'));
    }

    // 3. Xử lý Check-out (Cập nhật bản ghi & Tính worked_minutes + overtime_minutes)
    public function checkOut()
    {
        $empId = session('user_id');
        $today = Carbon::today()->toDateString();
        $now = Carbon::now();

        // Tìm bản ghi check-in của ngày hôm nay
        $attendance = Attendance::where('employee_id', $empId)->where('work_date', $today)->first();

        if (!$attendance) {
            return redirect()->back()->with('error', 'Bạn cần phải check-in trước khi check-out!');
        }

        if ($attendance->check_out) {
            return redirect()->back()->with('error', 'Hôm nay bạn đã check-out rồi!');
        }

        $checkInTime = Carbon::parse($attendance->work_date . ' ' . $attendance->check_in);
        $checkOutTime = $now;

        // Tính tổng số phút thực tế ở công ty
        //  Thêm hàm abs() bọc bên ngoài
        $totalMinutes = abs($checkOutTime->diffInMinutes($checkInTime));

        // Quy ước giờ làm việc tiêu chuẩn hành chính (Giờ công tối đa = 480 phút)
        $standardMinutes = 480; 
        
        // Tính toán worked_minutes và overtime_minutes đơn giản
        if ($totalMinutes > $standardMinutes) {
            $attendance->worked_minutes = $standardMinutes;
            $attendance->overtime_minutes = $totalMinutes - $standardMinutes;
        } else {
            $attendance->worked_minutes = $totalMinutes;
            $attendance->overtime_minutes = 0;
            // Nếu về trước 17:00 thì cập nhật trạng thái về sớm
            if ($checkOutTime->format('H:i:s') < '17:00:00') {
                $attendance->status = 'early_leave';
            }
            else {
                        $attendance->status = 'present';
                }
        }

        $attendance->check_out = $checkOutTime->toTimeString();
        $attendance->save();

        return redirect()->back()->with('success', 'Check-out thành công. Tổng số phút làm việc: ' . $totalMinutes);
    }
    public function finalizeAttendance(Request $request)
    {
        // 1. Lấy ngày cần chốt công (mặc định là hôm nay)
        $targetDate = date('Y-m-d');

        // 2. Lấy danh sách toàn bộ nhân viên (Lưu ý: điều chỉnh cột 'role' cho khớp với DB của bạn, ví dụ 'user' hoặc 'employee')
        $employees = User::where('role_id',3)->get(); 

        $addedCount = 0;

        // 3. Vòng lặp quét từng nhân viên
        foreach ($employees as $emp) {
            // Kiểm tra nhân viên này đã có bản ghi chấm công trong ngày chưa
            $hasAttendance = Attendance::where('employee_id', $emp->id)
                                    ->whereDate('work_date', $targetDate)
                                    ->exists();

            // Nếu CHƯA CÓ dữ liệu (tức là không check-in)
            if (!$hasAttendance) {
                
                // Kiểm tra xem họ có đơn nghỉ phép được duyệt vào ngày này không?
                // (Lưu ý: Đổi chữ 'leave_date' thành tên cột ngày xin nghỉ trong bảng leaves của bạn)
                // Kiểm tra xem ngày chốt công ($targetDate) có nằm trong giai đoạn xin nghỉ không
            $isApprovedLeave = Leave::where('emp_id', $emp->id) // Đổi thành emp_id
                                    ->whereDate('start_date', '<=', $targetDate) // Ngày bắt đầu <= Ngày chốt
                                    ->whereDate('end_date', '>=', $targetDate)   // Ngày kết thúc >= Ngày chốt
                                    ->where('status', 'approved')
                                    ->exists();

                // Quyết định trạng thái: Có đơn -> on_leave, Không đơn -> absent
                $finalStatus = $isApprovedLeave ? 'on_leave' : 'absent';

                // Tạo bản ghi chấm công mới
                Attendance::create([
                    'employee_id'      => $emp->id,
                    'work_date'        => $targetDate,
                    'status'           => $finalStatus,
                    'check_in'         => null,
                    'check_out'        => null,
                    'worked_minutes'   => 0,
                    'overtime_minutes' => 0,
                ]);

                $addedCount++;
            }
        }

        // Trả về giao diện và báo thành công
        return redirect()->back()->with('success', "Đã chốt công thành công cho ngày " . date('d/m/Y', strtotime($targetDate)) . ". Đã bổ sung {$addedCount} bản ghi vắng/nghỉ phép.");
    }
}