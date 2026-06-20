<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cổng thông tin Nhân viên')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
</head>
<body>

    <header class="user-header">
        <div class="header-container">
            <div class="user-brand">Workspace Portal</div>
            <nav class="user-nav">
                <a href="#" class="nav-link active">Dashboard</a>
                <a href="#" class="nav-link">Đơn nghỉ phép</a>
                <div class="user-profile-menu">
                    <span>Mã NV: 1245</span>
                </div>
            </nav>
        </div>
    </header>

    <main class="user-main-content">
        @yield('content')
    </main>

</body>
</html>