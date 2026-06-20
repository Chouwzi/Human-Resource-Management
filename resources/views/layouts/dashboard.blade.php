<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - HRM Team 6</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard-layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    <style>
    /* Ép sidebar chứa các phần tử co giãn linh hoạt */
    .sidebar {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100vh;
        /* Chiều cao tối đa màn hình */
        padding-bottom: 20px;
        /* Khoảng cách an toàn sát đáy */
    }

    /* Khung bọc menu */
    .sidebar-menu-wrapper {
        flex-grow: 1;
        overflow-y: auto;
        width: 100%;
    }

    /* Style cho nút Đăng xuất nằm ở góc dưới */
    .logout-sidebar-container {
        width: 100%;
        padding: 0 20px;
        margin-top: 20px;
        flex-shrink: 0;
    }

    .logout-sidebar-btn {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 15px;
        color: #4b5563;
        background: transparent;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        width: 100%;
        cursor: pointer;
        transition: 0.2s;
    }

    .logout-sidebar-btn:hover {
        background-color: #fee2e2;
        color: #dc2626;
        border-color: #fecaca;
    }
    </style>
</head>

<body>

    <div class="sidebar">
        <div class="sidebar-menu-wrapper">
            <div class="logo-area">
                <a href="{{ request()->is('admin*') ? route('admin.dashboard') : route('employee.dashboard') }}"
                    style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-layer-group"></i> <span>HRM Team 6</span>
                </a>
            </div>

            <ul class="menu-list">
                <li>
                    <a href="{{ request()->is('admin*') ? route('admin.dashboard') : route('employee.dashboard') }}"
                        class="menu-item {{ (request()->routeIs('admin.dashboard') || request()->routeIs('employee.dashboard')) ? 'active' : '' }}">
                        <i class="fas fa-chart-pie"></i> <span>Tổng Quan</span>
                    </a>
                </li>

                @if(request()->is('admin*'))
                <li>
                    <a href="{{ route('admin.employees') }}"
                        class="menu-item {{ request()->routeIs('admin.employees') ? 'active' : '' }}">
                        <i class="fas fa-users"></i> <span>Nhân Sự</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.departments') }}"
                        class="menu-item {{ request()->routeIs('admin.departments') ? 'active' : '' }}">
                        <i class="fas fa-sitemap"></i> <span>Phòng Ban</span>
                    </a>
                </li>
                @endif

                <li>
                    <a href="{{ request()->is('admin*') ? route('admin.leaves') : route('employee.leaves') }}"
                        class="menu-item {{ (request()->routeIs('admin.leaves') || request()->routeIs('employee.leaves')) ? 'active' : '' }}">
                        <i class="fas fa-file-signature"></i> <span>Đơn Nghỉ Phép</span>
                    </a>
                </li>

                <li>
                    <a href="{{ request()->is('admin*') ? route('admin.attendance') : route('employee.attendance') }}"
                        class="menu-item {{ (request()->routeIs('admin.attendance') || request()->routeIs('employee.attendance')) ? 'active' : '' }}">
                        <i class="fas fa-user-check"></i> <span>Chấm Công</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="logout-sidebar-container">
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="logout-sidebar-btn">
                    <i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span>
                </button>
            </form>
        </div>
    </div>

    <div class="main-content">
        <div class="header">
            <h1 class="header-title">@yield('header_title')</h1>

            <div class="profile-area">
                <div class="search-box">
                    <input type="text" class="search-input" id="searchInput" placeholder="Tìm kiếm...">
                    <i class="fas fa-search search-icon" id="searchIcon"></i>
                </div>

                <div class="avatar-group">
                    <span
                        class="user-name">{{ request()->is('admin*') ? 'Tài khoản Admin' : 'Nguyễn Trung Nguyên' }}</span>
                    <img src="{{ asset('images/default-avatar.jpg') }}" class="avatar" alt="Avatar">
                </div>
            </div>
        </div>

        <div class="content-body">
            @yield('content')
        </div>
    </div>

</body>

</html>