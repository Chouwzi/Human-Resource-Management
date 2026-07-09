<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Quản trị hệ thống') - HRM Portal</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    
    @stack('styles')
</head>

<body>
    <div class="admin-layout">

        <aside class="admin-sidebar" id="sidebar">
            <div class="sidebar-brand">
                @php $role = session('user_role'); @endphp
                <a href="{{ $role === 'admin' ? route('admin.home') : ($role === 'hr' ? route('hr.home') : route('user.home')) }}"
                    style="color: inherit; text-decoration: none; display: flex; align-items: center; width: 100%; height: 100%;">
                    HRM Portal
                </a>
            </div>

            <nav class="sidebar-menu">
                {{-- Menu mục Tổng quan --}}
                <a href="{{ $role === 'admin' ? route('admin.home') : ($role === 'hr' ? route('hr.home') : route('user.home')) }}"
                    class="menu-item {{ (request()->routeIs('admin.home') || request()->routeIs('hr.home') || request()->routeIs('user.home')) ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt" style="margin-right:8px; width:16px;"></i>
                    Tổng quan
                </a>

                @if($role === 'admin')
                    {{-- === MENU ADMIN === --}}
                    <a href="{{ route('admin.employees.index') }}"
                       class="menu-item {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}">
                        <i class="fas fa-users" style="margin-right:8px; width:16px;"></i>
                        Nhân sự
                    </a>
                    <a href="{{ route('admin.departments.index') }}"
                       class="menu-item {{ request()->routeIs('admin.departments.*') ? 'active' : '' }}">
                        <i class="fas fa-sitemap" style="margin-right:8px; width:16px;"></i>
                        Cơ cấu tổ chức
                    </a>
                    <a href="{{ route('admin.positions.index') }}"
                       class="menu-item {{ request()->routeIs('admin.positions.*') ? 'active' : '' }}">
                        <i class="fas fa-briefcase" style="margin-right:8px; width:16px;"></i>
                        Chức vụ
                    </a>
                    <a href="{{ route('admin.leaves.pending') }}"
                        class="menu-item {{ request()->routeIs('admin.leaves.pending') ? 'active' : '' }}">
                        <i class="fas fa-clipboard-check" style="margin-right:8px; width:16px;"></i>
                        <span>Duyệt nghỉ phép</span>
                        <span class="badge badge-warning pending-leave-badge" data-pending-leave-badge>
                            {{ \App\Models\Leave::where('status', 'pending')->count() }}
                        </span>
                    </a>
                    <a href="{{ route('admin.attendance.index') }}"
                       class="menu-item {{ request()->routeIs('admin.attendance.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-alt" style="margin-right:8px; width:16px;"></i>
                        Chấm công
                    </a>
                    <a href="{{ route('admin.contracts.index') }}"
                       class="menu-item {{ request()->routeIs('admin.contracts.*') ? 'active' : '' }}">
                        <i class="fas fa-file-contract" style="margin-right:8px; width:16px;"></i>
                        Hợp đồng
                    </a>
                    <a href="{{ route('admin.salaries.index') }}"
                       class="menu-item {{ request()->routeIs('admin.salaries.*') ? 'active' : '' }}">
                        <i class="fas fa-money-bill-wave" style="margin-right:8px; width:16px;"></i>
                        Bảng lương
                    </a>

                @elseif($role === 'hr')
                    {{-- === MENU HR === --}}
                    <a href="{{ route('admin.employees.index') }}"
                       class="menu-item {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}">
                        <i class="fas fa-users" style="margin-right:8px; width:16px;"></i>
                        Nhân sự
                    </a>
                    <a href="{{ route('admin.departments.index') }}"
                       class="menu-item {{ request()->routeIs('admin.departments.*') ? 'active' : '' }}">
                        <i class="fas fa-sitemap" style="margin-right:8px; width:16px;"></i>
                        Cơ cấu tổ chức
                    </a>
                    <a href="{{ route('admin.positions.index') }}"
                       class="menu-item {{ request()->routeIs('admin.positions.*') ? 'active' : '' }}">
                        <i class="fas fa-briefcase" style="margin-right:8px; width:16px;"></i>
                        Chức vụ
                    </a>
                    <a href="{{ route('admin.leaves.pending') }}"
                        class="menu-item {{ request()->routeIs('admin.leaves.pending') ? 'active' : '' }}">
                        <i class="fas fa-clipboard-check" style="margin-right:8px; width:16px;"></i>
                        <span>Duyệt nghỉ phép</span>
                        <span class="badge badge-warning pending-leave-badge" data-pending-leave-badge>
                            {{ \App\Models\Leave::where('status', 'pending')->count() }}
                        </span>
                    </a>
                    <a href="{{ route('admin.attendance.index') }}"
                       class="menu-item {{ request()->routeIs('admin.attendance.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-alt" style="margin-right:8px; width:16px;"></i>
                        Chấm công
                    </a>

                @else
                    {{-- === MENU NHÂN VIÊN === --}}
                    <a href="{{ route('leaves.create') }}"
                       class="menu-item {{ request()->routeIs('leaves.create') ? 'active' : '' }}">
                        <i class="fas fa-plus-circle" style="margin-right:8px; width:16px;"></i>
                        Đăng ký nghỉ phép
                    </a>
                    <a href="{{ route('leaves.index') }}"
                       class="menu-item {{ request()->routeIs('leaves.index') ? 'active' : '' }}">
                        <i class="fas fa-list-alt" style="margin-right:8px; width:16px;"></i>
                        Lịch sử nghỉ phép
                    </a>
                    <a href="{{ route('attendance.index') }}"
                       class="menu-item {{ request()->routeIs('attendance.index') ? 'active' : '' }}">
                        <i class="fas fa-calendar-alt" style="margin-right:8px; width:16px;"></i>
                        Chấm công
                    </a>
                    <a href="{{ route('salaries.index') }}"
                       class="menu-item {{ request()->routeIs('salaries.*') ? 'active' : '' }}">
                        <i class="fas fa-money-bill-wave" style="margin-right:8px; width:16px;"></i>
                        Bảng lương
                    </a>
                    <a href="{{ route('user.contracts.index') }}"
                       class="menu-item {{ request()->routeIs('contracts*') || request()->routeIs('user.contracts.*') ? 'active' : '' }}">
                        <i class="fas fa-file-contract" style="margin-right:8px; width:16px;"></i>
                        Hợp đồng
                    </a>
                @endif
            </nav>

            <div style="padding: 1rem;">
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn btn-danger" style="width: 100%; justify-content: center;">
                        <i class="fas fa-sign-out-alt" style="margin-right: 8px;"></i> Đăng xuất
                    </button>
                </form>
            </div>
        </aside>

        <main class="admin-main">

            <header class="admin-topbar">
                <div class="topbar-left">
                    <button class="btn-toggle-sidebar" id="btnToggleSidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h2 style="font-size: 1.1rem; margin: 0;">@yield('header_title', 'Bảng điều khiển')</h2>
                </div>

                <div class="topbar-right">
                    <div style="display:flex; align-items:center; gap:0.5rem;">
                        @if($role === 'admin')
                            <span class="badge badge-danger">Admin</span>
                        @elseif($role === 'hr')
                            <span class="badge badge-info">HR</span>
                        @else
                            <span class="badge badge-success">Nhân viên</span>
                        @endif
                        <span style="font-weight:500;">{{ session('user_name') ?? session('user_email') }}</span>
                    </div>
                    <i class="fas fa-user-circle"></i>
                </div>
            </header>


            <div class="admin-content">
                @yield('content')
            </div>

        </main>
    </div>

    <script>
    const sidebar = document.getElementById('sidebar');
    const btnToggleSidebar = document.getElementById('btnToggleSidebar');

    // Bật/tắt sidebar trên màn hình nhỏ.
    btnToggleSidebar.addEventListener('click', function(e) {
        sidebar.classList.toggle('active');
        e.stopPropagation();
    });

    // Bấm ngoài sidebar thì đóng menu mobile.
    document.addEventListener('click', function(e) {
        if (sidebar.classList.contains('active')) {
            if (!sidebar.contains(e.target) && !btnToggleSidebar.contains(e.target)) {
                sidebar.classList.remove('active');
            }
        }
    });
    
    </script>
    <script src="{{ asset('js/main.js') }}"></script>
    @stack('scripts')
</body>

</html>
