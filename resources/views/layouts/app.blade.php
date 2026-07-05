<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Quản Trị Hệ Thống') -  HRM</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    
    <style>
        :root {
            --border-radius-lg: 16px;
            --border-radius-md: 12px;
            --border-radius-sm: 8px;
            --sidebar-width: 260px; /* Định nghĩa biến để dễ tái sử dụng */
        }

        /* Bo tròn các thẻ Card chứa nội dung */
        .content-card, .card, .admin-content > div {
            border-radius: var(--border-radius-lg) !important;
            border: none !important;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03) !important;
            overflow: hidden;
        }

        /* Bo tròn Nút bấm, Input, Select, Badge và Menu Item */
        input, select, .btn, .badge, .menu-item {
            border-radius: var(--border-radius-sm) !important;
            transition: all 0.2s ease-in-out;
        }

        /* Hiệu ứng hover cho nút */
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(78, 115, 223, 0.3);
        }

        /* Tinh chỉnh Bảng (Table) cho chuyên nghiệp */
        .table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
        }
        .table thead th:first-child { border-top-left-radius: var(--border-radius-md); }
        .table thead th:last-child { border-top-right-radius: var(--border-radius-md); }

        /* --- XỬ LÝ NÚT 3 GẠCH VÀ SIDEBAR --- */
        
        /* 1. Thiết lập nút 3 gạch */
        .btn-toggle-sidebar {
            display: inline-flex !important; 
            align-items: center;
            justify-content: center;
            background: transparent;
            border: none;
            font-size: 1.25rem;
            cursor: pointer;
            color: #333;
            margin-right: 15px;
            padding: 5px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .btn-toggle-sidebar:hover {
            background-color: #e5e7eb;
        }

        /* 2. Logic cho MOBILE (Màn hình nhỏ hơn hoặc bằng 992px) */
        @media (max-width: 992px) {
            .admin-sidebar {
                position: fixed;
                top: 0;
                left: calc(-1 * var(--sidebar-width) - 20px); /* Giấu hẳn ra ngoài */
                width: var(--sidebar-width);
                height: 100vh;
                /* Nâng z-index của Sidebar lên rất cao để đè lên mọi thứ (bao gồm topbar) khi mở */
                z-index: 9999; 
                transition: left 0.3s ease-in-out;
                background: #fff;
            }
            .admin-sidebar.active {
                left: 0;
                box-shadow: 4px 0 25px rgba(0,0,0,0.15); 
            }
            /* Tạo lớp phủ mờ (overlay) nền khi mở menu trên mobile (tùy chọn nhưng UX tốt hơn) */
            .mobile-overlay {
                display: none;
                position: fixed;
                top: 0; left: 0; right: 0; bottom: 0;
                background: rgba(0,0,0,0.4);
                z-index: 9998; /* Nằm ngay dưới sidebar */
                opacity: 0;
                transition: opacity 0.3s ease;
            }
            .mobile-overlay.active {
                display: block;
                opacity: 1;
            }
            .admin-main {
                margin-left: 0;
                width: 100%;
            }
        }

        /* 3. Logic cho PC (Màn hình lớn hơn 992px) */
        @media (min-width: 993px) {
            .admin-sidebar {
                position: fixed;
                top: 0;
                left: 0;
                width: var(--sidebar-width);
                height: 100vh;
                background: #fff;
                z-index: 1000;
                transition: transform 0.3s ease, width 0.3s ease;
                border-right: 1px solid #f3f4f6;
            }
            .admin-main {
                /* Đẩy nội dung chính sang phải để nhường chỗ cho Sidebar */
                margin-left: var(--sidebar-width); 
                transition: margin-left 0.3s ease;
            }

            /* Thu hẹp sidebar khi có class collapsed */
            .admin-sidebar.collapsed {
                transform: translateX(-100%);
                width: 0 !important;
                padding: 0 !important;
                overflow: hidden;
            }
            /* Kéo giãn nội dung chính khi sidebar bị thu hẹp */
            .admin-layout.collapsed-layout .admin-main {
                margin-left: 0 !important;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <div class="admin-layout">
        <div class="mobile-overlay" id="mobileOverlay"></div>

        <aside class="admin-sidebar" id="sidebar">
            <div class="sidebar-brand">
                <a href="{{ request()->is('admin*') ? route('admin.home') : route('user.home') }}"
                    style="color: inherit; text-decoration: none; display: flex; align-items: center; width: 100%; height: 100%;">
                    HRM 
                </a>
            </div>

            <nav class="sidebar-menu">
                <a href="{{ in_array(session('user_role'), ['admin', 'hr']) ? route('admin.home') : route('user.home') }}"
                    class="menu-item {{ (request()->routeIs('admin.home') || request()->routeIs('user.home')) ? 'active' : '' }}">
                    Tổng Quan
                </a>

                @if(request()->is('admin*'))
                    <a href="{{ route('admin.employees.index') }}"
                       class="menu-item {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}">
                        Nhân Sự
                    </a>
                    <a href="{{ route('admin.departments.index') }}"
                       class="menu-item {{ request()->routeIs('admin.departments.*') || request()->routeIs('admin.positions.*') ? 'active' : '' }}">
                        Phòng Ban
                    </a>
                    <a href="{{ route('admin.leaves.pending') }}" 
                        class="menu-item {{ request()->routeIs('admin.leaves.pending') ? 'active' : '' }}">
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

                <a href="{{ request()->is('admin*') ? route('admin.attendance.index') : route('attendance.index') }}"
                   class="menu-item {{ (request()->routeIs('admin.attendance.*') || request()->routeIs('attendance.index')) ? 'active' : '' }}">
                    Chấm Công
                </a>
                @if(request()->is('admin*'))
                    <a href="{{ route('admin.salaries.index') }}"
                       class="menu-item {{ request()->routeIs('admin.salaries.*') ? 'active' : '' }}">
                        Bảng Lương
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

            <header class="admin-topbar" style="display: flex; justify-content: space-between; align-items: center; padding: 0.5rem 1.5rem; background: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                
                <div class="topbar-left" style="display: flex; align-items: center; gap: 12px; min-width: 0; flex: 1;">
                    <button class="btn-toggle-sidebar" id="btnToggleSidebar" style="margin: 0; flex-shrink: 0;">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h2 style="font-size: 1.1rem; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        @yield('header_title', 'Bảng Điều Khiển')
                    </h2>
                </div>

                <div class="topbar-right" style="display: flex; align-items: center; flex-shrink: 0; margin-left: 10px;">
                    <span style="white-space: nowrap;">
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
                    <i class="fas fa-user-circle" style="font-size: 1.5rem; margin-left: 8px; color: #4b5563;"></i>
                </div>
                
            </header>

            <div class="admin-content" style="padding: 1.5rem;">
                @yield('content')
            </div>

        </main>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const btnToggleSidebar = document.getElementById('btnToggleSidebar');
        const adminLayout = document.querySelector('.admin-layout');
        const mobileOverlay = document.getElementById('mobileOverlay');

        // Hàm mở/đóng sidebar trên mobile
        function toggleMobileMenu() {
            sidebar.classList.toggle('active');
            if(mobileOverlay) {
                mobileOverlay.classList.toggle('active');
                // Khắc phục lỗi nháy overlay
                if(mobileOverlay.classList.contains('active')) {
                    mobileOverlay.style.display = 'block';
                } else {
                    setTimeout(() => { mobileOverlay.style.display = 'none'; }, 300);
                }
            }
        }

        // Phân biệt xử lý nút 3 gạch giữa Mobile và PC
        btnToggleSidebar.addEventListener('click', function(e) {
            e.stopPropagation();
            if (window.innerWidth <= 992) {
                // Mobile: Trượt ra/vào
                toggleMobileMenu();
            } else {
                // PC: Thu gọn/Mở rộng
                sidebar.classList.toggle('collapsed');
                adminLayout.classList.toggle('collapsed-layout');
            }
        });

        // Bấm ngoài sidebar hoặc bấm vào overlay thì đóng menu (Mobile)
        document.addEventListener('click', function(e) {
            if (window.innerWidth <= 992 && sidebar.classList.contains('active')) {
                if (!sidebar.contains(e.target) && !btnToggleSidebar.contains(e.target)) {
                    toggleMobileMenu();
                }
            }
        });

        // Xử lý khi kéo/resize trình duyệt qua lại giữa giao diện Mobile và PC
        window.addEventListener('resize', function() {
            if (window.innerWidth > 992) {
                sidebar.classList.remove('active'); // Tắt chế độ trượt
                if(mobileOverlay) {
                    mobileOverlay.classList.remove('active');
                    mobileOverlay.style.display = 'none';
                }
            } else {
                sidebar.classList.remove('collapsed'); // Tắt chế độ gập PC
                adminLayout.classList.remove('collapsed-layout');
            }
        });
    });
    </script>
    <script src="{{ asset('js/main.js') }}"></script>
    @stack('scripts')
</body>

</html>