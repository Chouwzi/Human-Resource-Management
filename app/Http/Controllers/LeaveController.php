<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    // 1. Nhân viên xem lịch sử đơn của mình
    public function index()
    {
    $leavesHistory = \App\Models\Leave::orderBy('created_at', 'desc')->get();
    return view('user.leaves.index', compact('leavesHistory'));
    }

    // 2. Nhân viên vào trang tạo đơn
    public function create()
    {
        return view('user.leaves.create');
    }

    // 3. Xử lý khi nhân viên bấm "Gửi Đơn"
    public function store(Request $request)
    {
        $request->validate([
            'leave_type' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required',
        ]);

        // Tự động tính toán số ngày nghỉ dựa trên khoảng cách ngày
        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);
        $days = $start->diffInDays($end) + 1;

        // Lưu thông tin vào Database (Tạm thời dùng thông tin cứng, sau này ráp Auth::user() vào)
        Leave::create([
            'emp_id' => '1',
            'emp_name' => 'Nguyễn Trung Nguyên',
            'leave_type' => $request->leave_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'days' => $days,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return redirect()->route('leaves.index')->with('success', 'Gửi đơn nghỉ phép thành công!');
    }

    // 4. Admin xem danh sách đơn chờ xử lý
    public function pending()
    {
        $pendingLeaves = \App\Models\Leave::where('status', 'pending')->orderBy('created_at', 'desc')->get();
        return view('admin.leaves.pending', compact('pendingLeaves'));
    }

    // 5. Admin bấm "Duyệt" đơn
    public function approve($id)
    {
        $leave = \App\Models\Leave::findOrFail($id);
    
        $leave->status = 'approved';
        
        // 👉 Lấy ID của người đang đăng nhập từ Session
        $adminId = session('user_id'); 
        $admin = \App\Models\User::find($adminId);
        
        // Lấy email nếu tìm thấy admin, không thì để tên mặc định
        $leave->approved_by = $admin ? $admin->email : 'Admin'; 
        $leave->approved_at = now();
        
        $leave->save();

        return redirect()->back()->with('success', 'Đã phê duyệt đơn nghỉ phép.');
    }

    // 6. Admin bấm "Từ chối" đơn
    public function reject($id)
    {
        $leave = \App\Models\Leave::findOrFail($id);
    
        $leave->status = 'rejected';
        
        // 👉 Lấy ID của người đang đăng nhập từ Session
        $adminId = session('user_id');
        $admin = \App\Models\User::find($adminId);
        
        $leave->approved_by = $admin ? $admin->email : 'Admin'; 
        $leave->approved_at = now();
        
        $leave->save();

        return redirect()->back()->with('success', 'Đã từ chối đơn nghỉ phép.');
    }

    // 7. Nhân viên tự bấm "Hủy đơn"
    public function cancel($id)
    {
        $leave = Leave::findOrFail($id);
        
        // Chỉ cho phép hủy khi đơn vẫn đang ở trạng thái chờ duyệt
        if ($leave->status === 'pending') {
            $leave->update(['status' => 'cancelled']);
            return redirect()->route('leaves.index')->with('success', 'Đã hủy đơn nghỉ phép thành công!');
        }

        return redirect()->route('leaves.index')->with('error', 'Không thể hủy đơn này!');
    }
    // Xóa đơn nghỉ phép khỏi cơ sở dữ liệu
    public function destroy($id)
    {
        $leave = Leave::findOrFail($id);
        $leave->delete();

        return redirect()->route('leaves.index')->with('success', 'Đã xóa đơn nghỉ phép thành công!');
    }
    
    public function dashboard()
    {
    $emp_id = '1'; // Sau này thay bằng Auth::user()->emp_id

    $recentLeaves = Leave::where('emp_id', $emp_id)
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

    return view('dashboard.user', compact('recentLeaves'));
    }
}
