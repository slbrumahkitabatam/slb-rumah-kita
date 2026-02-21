<?php
// Include security configuration first
require_once '../config/database.php';

// Start regular session (tanpa security check untuk halaman login)
session_name('SLB_SESSION_ID');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include security helper functions
require_once '../config/security.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Sanitize input
    $username = sanitizeInput($username);
    
    if ($username && $password) {
        // Check rate limiting
        $rateLimit = checkRateLimit();
        
        if (!$rateLimit['allowed']) {
            $error = $rateLimit['message'];
            logSecurityEvent('LOGIN_BLOCKED', "Rate limit exceeded for IP: " . getClientIP(), $username);
        } else {
            // Get user from database
            $user = fetchOne("SELECT * FROM users WHERE username = ?", [$username]);
            
            if ($user && password_verify($password, $user['password'])) {
                // Successful login
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['nama'] = $user['nama'];
                $_SESSION['role'] = $user['role'] ?? 'guru';
                $_SESSION['login_time'] = time();
                
                // Clear failed login attempts
                clearLoginAttempts($username);
                
                // Log successful login
                logSecurityEvent('LOGIN_SUCCESS', "User logged in successfully", $username);
                
                header('Location: index.php');
                exit;
            } else {
                // Failed login
                $error = 'Username atau password salah!';
                $remainingAttempts = $rateLimit['remaining_attempts'] ?? 0;
                
                if ($remainingAttempts > 0 && $remainingAttempts <= 2) {
                    $error .= " Sisa percobaan: " . $remainingAttempts;
                }
                
                // Record failed attempt
                recordFailedLogin($username);
                logSecurityEvent('LOGIN_FAILED', "Failed login attempt", $username);
            }
        }
    } else {
        $error = 'Mohon lengkapi semua field!';
    }
}

// Jika sudah login, redirect ke dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SLB Rumah Kita Batam – Admin Panel</title>
    <link rel="shortcut icon" href="../gambar/icon.jpg">
    <link rel="icon" href="../gambar/icon.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #66a6ff 0%, #89f7fe 50%, #a1c4fd 100%);
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 80%, rgba(255,255,255,0.15) 0%, transparent 40%),
                        radial-gradient(circle at 80% 20%, rgba(255,255,255,0.2) 0%, transparent 40%),
                        radial-gradient(circle at 50% 50%, rgba(102, 166, 255, 0.1) 0%, transparent 60%);
            z-index: 1;
            pointer-events: none;
            animation: float 15s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(2deg); }
        }
        .container {
            position: relative;
            z-index: 2;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.3);
            animation: slideUp 0.6s ease-out;
        }
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .login-header {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 50%, #0043a8 100%);
            color: white;
            padding: 50px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
        }
        .login-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 60%);
            animation: rotate 25s linear infinite;
        }
        .login-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.8) 50%, transparent 100%);
        }
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .login-header .school-icon {
            font-size: 4rem;
            margin-bottom: 15px;
            display: inline-block;
            animation: pulse 2s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); filter: drop-shadow(0 0 10px rgba(255,255,255,0.3)); }
            50% { transform: scale(1.08); filter: drop-shadow(0 0 20px rgba(255,255,255,0.5)); }
        }
        .login-header h3 {
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 5px;
            position: relative;
        }
        .login-header p {
            font-size: 1rem;
            opacity: 0.9;
            position: relative;
        }
        .login-body {
            padding: 45px 40px;
        }
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }
        .input-group {
            margin-bottom: 5px;
        }
        .input-group-text {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            border: none;
            padding: 12px 15px;
            color: white;
            box-shadow: 0 2px 8px rgba(13, 110, 253, 0.2);
        }
        .input-group-text i {
            font-size: 1.1rem;
        }
        .form-control {
            padding: 12px 15px;
            border-radius: 0 8px 8px 0;
            border: 2px solid #e0e0e0;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
            background: #f8f9ff;
        }
        .btn-login {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            border: none;
            padding: 14px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(13, 110, 253, 0.35);
            position: relative;
            overflow: hidden;
        }
        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s ease;
        }
        .btn-login:hover::before {
            left: 100%;
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #0a58ca 0%, #0043a8 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(13, 110, 253, 0.5);
        }
        .btn-login:active {
            transform: translateY(0);
        }
        .login-info {
            background: linear-gradient(135deg, #e7f1ff 0%, #d0e7ff 100%);
            border-radius: 10px;
            padding: 15px;
            margin-top: 20px;
            border-left: 4px solid #0d6efd;
            box-shadow: 0 2px 8px rgba(13, 110, 253, 0.1);
        }
        .login-info p {
            margin: 0;
            font-size: 0.85rem;
            line-height: 1.6;
        }
        .back-link {
            color: #0d6efd;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            padding: 10px 18px;
            border-radius: 25px;
            background: rgba(13, 110, 253, 0.05);
            border: 1px solid rgba(13, 110, 253, 0.2);
        }
        .back-link:hover {
            background: rgba(13, 110, 253, 0.15);
            color: #0a58ca;
            transform: translateX(-5px);
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
        }
        .alert {
            border-radius: 10px;
            border: none;
            animation: shake 0.5s ease-in-out;
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }
        .alert-danger {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a5a 100%);
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="login-card">
                    <div class="login-header">
                        <i class="fas fa-school school-icon"></i>
                        <h3 class="fw-bold">Admin Panel</h3>
                        <p class="mb-0">SLB Rumah Kita Batam</p>
                    </div>
                    <div class="login-body">
                        <?php if ($error): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo $error; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text" class="form-control" id="username" name="username" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-login w-100 mb-3">
                                <i class="fas fa-sign-in-alt me-2"></i>Masuk ke Dashboard
                            </button>
                        </form>
                        
                        <div class="text-center">
                            <a href="../index.php" class="back-link">
                                <i class="fas fa-arrow-left me-1"></i>Kembali ke Website
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>