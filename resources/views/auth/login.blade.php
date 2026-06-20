<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập - Team 6 HRM</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>

<body class="login-body">

    <div class="team-intro">Dự Án Quản Lý Nhân Sự - Team 6</div>

    <div class="login-card">
        <h2 class="title">Đăng Nhập</h2>

        @if(session('error'))
        <div id="server-error-message" class="alert-error">
            {{ session('error') }}
        </div>
        @endif

        <div id="js-error-message" class="alert-error" style="display: none;"></div>

        <form id="loginForm" action="{{ route('login') ?? '#' }}" method="POST">
            @csrf

            <div class="input-group">
                <i class="fas fa-user icon"></i>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Email đăng nhập"
                    maxlength="255" autofocus>
                @error('email')
                <span class="field-error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group" style="position: relative;">
                <i class="fas fa-lock icon"></i>
                <input type="password" id="password" name="password" placeholder="Mật khẩu" maxlength="32">
                <i class="fas fa-eye toggle-password" toggle="#password"
                    style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #9ca3af;"
                    title="Xem/Ẩn mật khẩu"></i>
                @error('password')
                <span class="field-error-text">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-login" id="submitBtn">Đăng Nhập</button>

            <a href="{{ route('password.request') }}" class="forgot-password">Quên mật khẩu?</a>
        </form>
    </div>

    <div id="js-error-message" class="alert-error" style="display: none;">

    </div>

    <script src="{{ asset('js/auth.js') }}"></script>
</body>

</html>