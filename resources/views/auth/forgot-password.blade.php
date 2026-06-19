<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên Mật Khẩu - Team 6 HRM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>

<body class="login-body">

    <div class="team-intro">Dự Án Quản Lý Nhân Sự - Team 6</div>

    <div class="login-card">
        <h2 class="title">Quên Mật Khẩu</h2>

        <p class="auth-description">
            <center>Nhập email của bạn .</center>
        </p>

        {{-- Hiển thị thông báo thành công từ Backend --}}
        @if (session('status'))
        <div class="alert-success">
            {{ session('status') }}
        </div>
        @endif

        {{-- Hiển thị thông báo lỗi từ JS Validation hoặc Backend --}}
        <div id="js-error-message" class="alert-error" style="display: none;"></div>

        <form id="forgotPasswordForm" action="{{ route('password.email') ?? '#' }}" method="POST">
            @csrf

            <div class="input-group">
                <i class="fas fa-envelope icon"></i>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Nhập Email của bạn"
                    autofocus>
                @error('email')
                <span class="field-error-text">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-login" id="submitBtn">Gửi OTP </button>

            <a href="{{ route('login') ?? '#' }}" class="forgot-password">
                <i class="fas fa-arrow-left"></i> Quay lại Đăng nhập
            </a>
        </form>
    </div>

    <script src="{{ asset('js/auth.js') }}"></script>
</body>

</html>