<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hệ thống Quản trị Admin')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

    <div class="admin-layout">
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="sidebar-brand">
                <span>Trang Quản Trị</span>
            </div>
            <nav class="sidebar-menu">
                <a href="#" class="menu-item active">Dashboard</a>
                <a href="#" class="menu-item">Quản lý nhân viên</a>
                <a href="#" class="menu-item">Quản lý đơn từ</a>
            </nav>
        </aside>
        <div class="admin-main">
            <header class="admin-topbar">
                <div class="topbar-left">
                    <button class="btn-toggle-sidebar" id="sidebarToggle">☰</button>
                    <h1 style="font-size: 1.125rem; font-weight: 600;">Hệ thống</h1>
                </div>
                <div class="topbar-right">
                    <span>Xin chào, <strong>Quản trị viên</strong></span>
                </div>
            </header>

            <main class="admin-content">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');
        const adminSidebar = document.getElementById('adminSidebar');

        sidebarToggle.addEventListener('click', (e) => {
            adminSidebar.classList.toggle('active');
            e.stopPropagation();
        });

        // Tự động đóng sidebar khi click ra ngoài vùng menu trên thiết bị di động
        document.addEventListener('click', (e) => {
            if (!adminSidebar.contains(e.target) && adminSidebar.classList.contains('active')) {
                adminSidebar.classList.remove('active');
            }
        });
    </script>
</body>
</html>