<?php

namespace App\Http\Controllers;

use App\Models\AttendanceLog;
use App\Models\Employee;
use App\Models\Leave;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    // 1. Xem lịch sử chấm công cá nhân của nhân viên (có lọc theo tháng/năm)
    public function index(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập!');
        }

        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));

        $employee = Employee::where('user_id', session('user_id'))->first();
        if (!$employee) {
            return redirect()->back()->with('error', 'Không tìm thấy hồ sơ nhân sự!');
        }

        $attendances = AttendanceLog::where('employee_id', $employee->id)
                        ->whereMonth('work_date', $month)
                        ->whereYear('work_date', $year)
                        ->orderBy('work_date', 'desc')
                        ->get();

        return view('user.attendance.index', compact('attendances', 'month', 'year'));
    }

    // 2. Xử lý Check-in của nhân viên
    public function checkIn()
    {
        $employee = Employee::where('user_id', session('user_id'))->first();
        if (!$employee) {
            return redirect()->back()->with('error', 'Không tìm thấy hồ sơ nhân sự!');
        }

        $empId = $employee->id;
        $today = Carbon::today()->toDateString();
        $now = Carbon::now();

        // Chặn trùng chấm công
        $exists = AttendanceLog::where('employee_id', $empId)->where('work_date', $today)->exists();
        if ($exists) {
            return redirect()->back()->with('error', 'Hôm nay bạn đã check-in rồi!');
        }

        // Tính toán đi muộn sau 08:00
        $status = $now->format('H:i:s') > '08:00:00' ? 'late' : 'present';

        AttendanceLog::create([
            'employee_id' => $empId,
            'work_date'   => $today,
            'check_in_at' => $now,
            'status'      => $status
        ]);

        return redirect()->back()->with('success', 'Check-in thành công lúc ' . $now->format('H:i'));
    }

    // 3. Xử lý Check-out của nhân viên
    public function checkOut()
    {
        $employee = Employee::where('user_id', session('user_id'))->first();
        if (!$employee) {
            return redirect()->back()->with('error', 'Không tìm thấy hồ sơ nhân sự!');
        }

        $empId = $employee->id;
        $today = Carbon::today()->toDateString();
        $now = Carbon::now();

        // Tìm bản ghi check-in ngày hôm nay
        $attendance = AttendanceLog::where('employee_id', $empId)->where('work_date', $today)->first();

        if (!$attendance) {
            return redirect()->back()->with('error', 'Bạn cần phải check-in trước khi check-out!');
        }

        if ($attendance->check_out_at) {
            return redirect()->back()->with('error', 'Hôm nay bạn đã check-out rồi!');
        }

        $checkInTime = Carbon::parse($attendance->check_in_at);
        $checkOutTime = $now;

        $totalMinutes = abs($checkOutTime->diffInMinutes($checkInTime));
        $standardMinutes = 480; // 8 tiếng

        if ($totalMinutes > $standardMinutes) {
            $attendance->worked_minutes = $standardMinutes;
            $attendance->overtime_minutes = $totalMinutes - $standardMinutes;
        } else {
            $attendance->worked_minutes = $totalMinutes;
            $attendance->overtime_minutes = 0;
            // Về trước 17:00
            if ($checkOutTime->format('H:i:s') < '17:00:00') {
                $attendance->note = 'Về sớm';
            }
        }

        $attendance->check_out_at = $checkOutTime;
        $attendance->save();

        return redirect()->back()->with('success', 'Check-out thành công. Tổng số phút làm việc: ' . $totalMinutes);
    }

    // 4. Admin chốt công ngày (quét vắng mặt và nghỉ phép)
    public function finalizeAttendance(Request $request)
    {
        $targetDate = date('Y-m-d');
        $employees = Employee::all();
        $addedCount = 0;

        foreach ($employees as $emp) {
            $hasAttendance = AttendanceLog::where('employee_id', $emp->id)
                                    ->whereDate('work_date', $targetDate)
                                    ->exists();

            if (!$hasAttendance) {
                // Kiểm tra nghỉ phép từ bảng leaves cũ (lưu emp_id = user_id)
                $isApprovedLeave = Leave::where('emp_id', $emp->user_id)
                                        ->whereDate('start_date', '<=', $targetDate)
                                        ->whereDate('end_date', '>=', $targetDate)
                                        ->where('status', 'approved')
                                        ->exists();

                $finalStatus = $isApprovedLeave ? 'leave' : 'absent';

                AttendanceLog::create([
                    'employee_id'      => $emp->id,
                    'work_date'        => $targetDate,
                    'status'           => $finalStatus,
                    'check_in_at'      => null,
                    'check_out_at'     => null,
                    'worked_minutes'   => 0,
                    'overtime_minutes' => 0,
                ]);

                $addedCount++;
            }
        }

        return redirect()->back()->with('success', "Đã chốt công thành công cho ngày " . date('d/m/Y', strtotime($targetDate)) . ". Đã bổ sung {$addedCount} bản ghi vắng/nghỉ phép.");
    }
}