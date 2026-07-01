<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Quản Trị Hệ Thống') - HRM Team 6</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    
    @stack('styles')
</head>

<body>
    <div class="admin-layout">

        <aside class="admin-sidebar" id="sidebar">
            <div class="sidebar-brand">
                <a href="{{ request()->is('admin*') ? route('admin.home') : route('user.home') }}"
                    style="color: inherit; text-decoration: none; display: flex; align-items: center; width: 100%; height: 100%;">
                    HRM Team 6
                </a>
            </div>

            <nav class="sidebar-menu">
                <a href="{{ in_array(session('user_role'), ['admin', 'hr']) ? route('admin.home') : route('user.home') }}"
                    class="menu-item {{ (request()->routeIs('admin.home') || request()->routeIs('user.home')) ? 'active' : '' }}">
                    Tổng Quan
                </a>

                @if(in_array(session('user_role'), ['admin', 'hr']))
                    <a href="#" class="menu-item">Nhân Sự</a>
                    <a href="#" class="menu-item">Phòng Ban</a>
                    <a href="{{ route('admin.leaves.pending') }}" class="menu-item {{ request()->routeIs('admin.leaves.pending') ? 'active' : '' }}">
                        Duyệt Đơn Nghỉ Phép
                    </a>
                @else
                    <a href="{{ route('leaves.create') }}" class="menu-item {{ request()->routeIs('leaves.create') ? 'active' : '' }}">
                        Tạo Đơn Nghỉ Phép
                    </a>
                    <a href="{{ route('leaves.index') }}" class="menu-item {{ request()->routeIs('leaves.index') ? 'active' : '' }}">
                        Lịch Sử Đơn Nghỉ Phép
                    </a>
                @endif

                <a href="{{ route('attendance.index') }}" class="menu-item {{ Request::is('attendance*') ? 'active' : '' }}">
                    Chấm Công
                </a>
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
                    <h2 style="font-size: 1.1rem; margin: 0;">@yield('header_title', 'Bảng Điều Khiển')</h2>
                </div>

                <div class="topbar-right">
        <span>
            @if(session('user_role') === 'admin' || (Auth::check() && Auth::user()->role_id == 1))
                Admin
            @elseif(session('user_role') === 'hr' || (Auth::check() && Auth::user()->role_id == 2))
                HR
            @elseif(Auth::check())
                {{ Auth::user()->name }}
            @else
                {{ session('user_name') }}
            @endif
        </span>

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

    // Khi bấm vào nút băm burger (Toggle)
    btnToggleSidebar.addEventListener('click', function(e) {
        sidebar.classList.toggle('active');
        e.stopPropagation(); // Ngăn sự kiện click bị lan ra ngoài document gây tự động đóng luôn
    });

    // Khi bấm vào bất kỳ đâu trên màn hình
    document.addEventListener('click', function(e) {
        // Kiểm tra nếu sidebar đang mở trên mobile (đang có class active)
        if (sidebar.classList.contains('active')) {
            // Nếu vùng bấm KHÔNG nằm trong sidebar VÀ KHÔNG phải nút bật menu thì đóng sidebar lại
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