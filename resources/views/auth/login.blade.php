<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f8fafc; margin: 0; }
        .container { max-width: 420px; margin: 80px auto; padding: 24px; background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 8px 24px rgba(15,23,42,.08); }
        .title { margin-bottom: 16px; font-size: 22px; font-weight: 600; }
        .field { margin-bottom: 16px; }
        .field label { display: block; margin-bottom: 6px; color: #334155; font-weight: 600; }
        .field input { width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 8px; }
        .button { width: 100%; padding: 12px 14px; background: #0f766e; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 700; }
        .error { margin-bottom: 16px; color: #b91c1c; background: #fef2f2; border: 1px solid #fecaca; padding: 12px; border-radius: 8px; }
        .hint { margin-top: 18px; color: #475569; font-size: 14px; }
        .hint strong { color: #0f766e; }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="title">Đăng nhập</h1>

        @if ($errors->any())
            <div class="error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.store') }}">
            @csrf

            <div class="field">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="field">
                <label for="password">Mật khẩu</label>
                <input id="password" name="password" type="password" required>
            </div>

            <button class="button" type="submit">Đăng nhập</button>
        </form>

        <p class="hint">
            Demo accounts:<br>
            admin@example.com / password<br>
            hr@example.com / password<br>
            employee@example.com / password
        </p>
    </div>
</body>
</html>
