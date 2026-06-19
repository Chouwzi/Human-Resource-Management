<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - HRM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard-layout.css') }}">
</head>

<body>

    <div class="sidebar">
        <div class="logo-area">
            <i class="fas fa-layer-group"></i> HRM Team 6
        </div>
        <ul class="menu-list">
            <li><a href="{{ route('admin.dashboard') ?? '#' }}" class="menu-item active"><i class="fas fa-home"></i>
                    Tổng Quan</a></li>
            <li><a href="#" class="menu-item"><i class="fas fa-users"></i> Quản Lý Nhân Sự</a></li>
            <li><a href="#" class="menu-item"><i class="fas fa-building"></i> Phòng Ban</a></li>
            <li><a href="#" class="menu-item"><i class="fas fa-calendar-alt"></i> Chấm Công</a></li>
            <li><a href="#" class="menu-item"><i class="fas fa-envelope-open-text"></i> Đơn Từ</a></li>
            <li><a href="#" class="menu-item"><i class="fas fa-cog"></i> Cài Đặt</a></li>
        </ul>
    </div>

    <div class="main-content">

        <div class="header">
            <h1 class="header-title">Tổng quan Admin</h1>
            <div class="profile-area">

                <div class="search-box">
                    <input type="text" class="search-input" id="searchInput" placeholder="Tìm kiếm...">
                    <i class="fas fa-search search-icon" id="searchIcon"></i>
                </div>

                <i class="far fa-bell" style="cursor:pointer;"></i>
                <span style="font-size: 16px; font-weight: 500; color: #333;">{{ $userName ?? 'Quản trị viên' }}</span>
                <div class="avatar"></div>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="icon-circle icon-blue"><i class="fas fa-user-tie"></i></div>
                <div class="stat-info">
                    <span class="stat-label">Tổng Nhân Viên</span>
                    <h3 class="stat-value">{{ $totalEmployees ?? '0' }}</h3>
                </div>
            </div>

            <div class="stat-card">
                <div class="icon-circle icon-purple"><i class="fas fa-sitemap"></i></div>
                <div class="stat-info">
                    <span class="stat-label">Phòng Ban</span>
                    <h3 class="stat-value">{{ $totalDepartments ?? '0' }}</h3>
                </div>
            </div>

            <div class="stat-card">
                <div class="icon-circle icon-orange"><i class="fas fa-file-signature"></i></div>
                <div class="stat-info">
                    <span class="stat-label">Đơn Nghỉ Chờ Duyệt</span>
                    <h3 class="stat-value">{{ $pendingLeaves ?? '0' }}</h3>
                </div>
            </div>

            <div class="stat-card">
                <div class="icon-circle icon-green"><i class="fas fa-check-circle"></i></div>
                <div class="stat-info">
                    <span class="stat-label">Đã Chấm Công (Hôm nay)</span>
                    <h3 class="stat-value">{{ $todayAttendance ?? '0' }}</h3>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/admin.js') }}"></script>
</body>

</html>