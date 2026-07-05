<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - HRM Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>

<body class="login-body">

    <div class="team-intro">
        <div class="login-brand-title">HRM Portal</div>
        <div class="login-brand-subtitle">Hệ thống quản trị nhân sự</div>
    </div>

    <div class="login-card">
        <h2 class="title">Đăng nhập hệ thống</h2>

        <div id="js-error-message" class="alert-error"></div>

        @if ($errors->any())
        <div class="alert-error">
            {{ $errors->first() }}
        </div>
        @endif

        <form id="loginForm" action="{{ route('login.store') }}" method="POST">
            @csrf
            <div class="input-group">
                <i class="fas fa-envelope icon"></i>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Nhập Email của bạn"
                    maxlength="255" autofocus>
            </div>

            <div class="input-group">
                <i class="fas fa-lock icon"></i>
                <input type="password" id="password" name="password" placeholder="Mật khẩu" maxlength="100">
                <i class="far fa-eye toggle-password" onclick="togglePasswordVisibility()"></i>
            </div>

            <button type="submit" class="btn-login" id="submitBtn">
                <span class="spinner" id="loginSpinner"></span>
                <span id="btnText">Đăng nhập</span>
            </button>
        </form>
    </div>

    <script src="{{ asset('js/auth.js') }}"></script>
</body>

</html>
