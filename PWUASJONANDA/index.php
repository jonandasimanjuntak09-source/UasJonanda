<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Smart Event Campus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .login-box {
            background: #fff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 400px;
            width: 100%;
        }
        .login-box .logo { text-align: center; margin-bottom: 25px; }
        .login-box .logo i { font-size: 48px; color: #667eea; }
        .login-box .logo h1 { font-size: 24px; font-weight: 700; color: #333; margin-top: 5px; }
        .login-box .logo h1 span { color: #667eea; }
        .login-box .logo p { color: #888; font-size: 14px; }
        .form-group { margin-bottom: 18px; }
        .form-group label { font-weight: 600; color: #333; font-size: 14px; display: block; margin-bottom: 5px; }
        .form-group input { width: 100%; padding: 10px 14px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; transition: 0.3s; }
        .form-group input:focus { outline: none; border-color: #667eea; }
        .btn-login { width: 100%; padding: 12px; background: linear-gradient(135deg, #667eea, #764ba2); color: #fff; border: none; border-radius: 8px; font-weight: 700; font-size: 16px; cursor: pointer; transition: 0.3s; }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(102,126,234,0.4); }
        .alert-error { background: #fef0f0; color: #c0392b; padding: 10px; border-radius: 8px; margin-bottom: 15px; display: none; }
        .alert-error.show { display: block; }
        .info { text-align: center; margin-top: 15px; font-size: 13px; color: #999; }
        .info strong { color: #667eea; }
    </style>
</head>
<body>
    <div class="login-box">
        <div class="logo">
            <i class="bi bi-calendar-event"></i>
            <h1>Smart <span>Event</span> Campus</h1>
            <p>Login Administrator</p>
        </div>
        <div class="alert-error <?php echo isset($_GET['error']) ? 'show' : ''; ?>">
            <i class="bi bi-exclamation-circle"></i> Username atau password salah!
        </div>
        <form action="login_process.php" method="POST" autocomplete="off">
            <div class="form-group">
                <label>Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan username" autocomplete="off" required autofocus>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password" autocomplete="new-password" required>
            </div>
            <button type="submit" class="btn-login"><i class="bi bi-box-arrow-in-right"></i> Login</button>
        </form>
        <div class="info"><i class="bi bi-info-circle"></i> Default: <strong>admin</strong> / <strong>admin123</strong></div>
    </div>
</body>
</html>