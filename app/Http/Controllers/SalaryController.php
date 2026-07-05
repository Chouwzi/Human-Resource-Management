<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Salary;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SalaryController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        $employee = Employee::where('user_id', $request->session()->get('user_id'))->first();

        if (! $employee) {
            return redirect()->route('user.home')->with('error', 'Không tìm thấy hồ sơ nhân sự.');
        }

        $salaries = Salary::where('employee_id', $employee->id)
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->get();

        return view('user.salaries.index', compact('employee', 'salaries'));
    }
}
