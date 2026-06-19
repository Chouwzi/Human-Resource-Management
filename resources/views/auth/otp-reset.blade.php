<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác Thực OTP - Team 6 HRM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>

<body class="login-body">

    <div class="team-intro">Dự Án Quản Lý Nhân Sự - Team 6</div>

    <div class="login-card">
        <h2 class="title">Xác Thực OTP</h2>

        <p class="auth-description">
            Mã xác nhận gồm 6 chữ số đã được gửi đến email của bạn.
        </p>

        {{-- Lỗi từ Backend gửi về --}}
        @if(session('error'))
        <div class="alert-error">
            {{ session('error') }}
        </div>
        @endif

        {{-- Lỗi từ JavaScript --}}
        <div id="js-error-message" class="alert-error" style="display: none;"></div>

        <form id="otpResetForm" action="{{ route('password.otp.verify') ?? '#' }}" method="POST">
            @csrf

            {{-- Email nhận từ trang forgot-password --}}
            <div class="input-group">
                <i class="fas fa-envelope icon"></i>
                <input type="email" id="email" name="email" value="{{ session('email') ?? request()->email ?? '' }}"
                    readonly class="readonly-input">
            </div>

            {{-- Ô NHẬP OTP 6 SỐ --}}
            <div class="input-group">
                <i class="fas fa-key icon"></i>
                <input type="text" id="otp" name="otp" placeholder="Nhập mã OTP 6 số" maxlength="6" inputmode="numeric"
                    autocomplete="one-time-code" autofocus>
            </div>

            <div class="input-group">
                <i class="fas fa-lock icon"></i>
                <input type="password" id="password" name="password" placeholder="Mật khẩu mới (Tối thiểu 8 ký tự)">
            </div>

            <div class="input-group">
                <i class="fas fa-check-circle icon"></i>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    placeholder="Xác nhận mật khẩu mới">
            </div>

            <button type="submit" class="btn-login" id="submitBtn">Xác Nhận & Cập Nhật</button>

            <div class="auth-footer">
                <p>Không nhận được mã? <a href="#" id="resendOtp">Gửi lại mã</a></p>
                <a href="{{ route('login') ?? '#' }}" class="forgot-password">Quay lại Đăng nhập</a>
            </div>
        </form>
    </div>

    <script src="{{ asset('js/auth.js') }}"></script>
</body>

</html>