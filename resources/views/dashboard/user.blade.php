<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f8fafc; margin: 0; }
        .wrapper { max-width: 720px; margin: 60px auto; padding: 24px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px; }
        .title { font-size: 24px; font-weight: 700; }
        .badge { color: #0f766e; font-weight: 700; }
        .button { color: #ffffff; background: #0f766e; border: none; padding: 10px 14px; border-radius: 8px; text-decoration: none; }
        .section { margin-bottom: 18px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <div>
                <h1 class="title">Trang người dùng</h1>
                <div class="badge">Role: {{ ucfirst($role) }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="button" type="submit">Đăng xuất</button>
            </form>
        </div>

        <div class="section">
            <p>Chào mừng Nhân viên, bạn đã đăng nhập thành công và chỉ role employee mới truy cập được trang này.</p>
        </div>
    </div>
</body>
</html>
