@extends('layouts.dashboard')

@section('title', 'Lịch Sử Chấm Công')
@section('header_title', 'Chấm công cá nhân')

@section('content')
<div class="admin-container">
    <div class="section-card content-card">

        <div
            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
            <h3 style="margin: 0;"><i class="fas fa-calendar-alt" style="color: #6b7280; margin-right: 8px;"></i>
                Bảng chấm công</h3>

            <select
                style="padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; outline: none; cursor: pointer;">
                <option value="06">Tháng 06/2026</option>
                <option value="05">Tháng 05/2026</option>
                <option value="04">Tháng 04/2026</option>
            </select>
        </div>

        <div style="overflow-x: auto; padding-bottom: 10px;">
            <table class="styled-table admin-table bg-white" style="width: 100%; min-width: 600px;">
                <thead>
                    <tr>
                        <th>Ngày</th>
                        <th>Giờ Vào (Check-in)</th>
                        <th>Giờ Ra (Check-out)</th>
                        <th>Tổng Giờ (Giờ)</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>21/06/2026</strong></td>
                        <td>07:55 AM</td>
                        <td>17:05 PM</td>
                        <td>8.0</td>
                        <td><span class="badge badge-success">Đúng giờ</span></td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection