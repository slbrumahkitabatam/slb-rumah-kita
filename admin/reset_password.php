<?php
require_once '../config/database.php';

// Hapus user admin yang ada (jika ada)
execute("DELETE FROM users WHERE username = 'admin'");

// Password admin123 di-hash dengan bcrypt
$password_hash = password_hash('admin123', PASSWORD_DEFAULT);

// Insert user admin baru dengan password yang ter-hash
execute(
    "INSERT INTO users (username, password, nama) VALUES (?, ?, ?)",
    ['admin', $password_hash, 'Administrator']
);

echo "<!DOCTYPE html>
<html lang='id'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Reset Password - Admin Panel</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
</head>
<body class='bg-light'>
    <div class='container mt-5'>
        <div class='row justify-content-center'>
            <div class='col-md-6'>
                <div class='card'>
                    <div class='card-body text-center py-5'>
                        <i class='fas fa-check-circle text-success fa-5x mb-3'></i>
                        <h3 class='mb-3'>Password Berhasil Di-reset!</h3>
                        <div class='alert alert-info'>
                            <strong>Login Info:</strong><br>
                            Username: <code>admin</code><br>
                            Password: <code>admin123</code>
                        </div>
                        <p>Password telah di-hash dengan bcrypt untuk keamanan.</p>
                        <a href='login.php' class='btn btn-primary btn-lg'>
                            <i class='fas fa-sign-in-alt me-2'></i>Ke Halaman Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>";
?>