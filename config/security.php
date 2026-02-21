<?php
/**
 * Security Configuration and Helper Functions
 * File ini berisi fungsi-fungsi keamanan untuk aplikasi
 */

/**
 * Rate Limiting Configuration
 */
define('MAX_LOGIN_ATTEMPTS', 5); // Maksimal percobaan login
define('LOGIN_LOCKOUT_TIME', 900); // 15 menit dalam detik
define('RATE_LIMIT_WINDOW', 900); // 15 menit dalam detik

/**
 * Session Configuration
 */
define('SESSION_TIMEOUT', 1800); // 30 menit dalam detik
define('SESSION_COOKIE_NAME', 'SLB_SESSION_ID');
define('SESSION_COOKIE_LIFETIME', 0); // 0 = sampai browser ditutup

/**
 * Security Headers
 */
define('X_FRAME_OPTIONS', 'SAMEORIGIN');
define('X_CONTENT_TYPE_OPTIONS', 'nosniff');
define('X_XSS_PROTECTION', '1; mode=block');

/**
 * Initialize Secure Session
 */
function initSecureSession() {
    // Set secure session parameters SEBELUM session di-start
    ini_set('session.cookie_httponly', 1);
    ini_set('session.cookie_secure', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 1 : 0);
    ini_set('session.cookie_samesite', 'Strict');
    ini_set('session.use_strict_mode', 1);
    ini_set('session.use_only_cookies', 1);
    
    // Set custom session name
    session_name(SESSION_COOKIE_NAME);
    
    // Start session
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Session timeout check
    if (isset($_SESSION['last_activity'])) {
        $elapsed = time() - $_SESSION['last_activity'];
        if ($elapsed > SESSION_TIMEOUT) {
            // Session expired, destroy it
            destroySession();
            return false;
        }
    }
    
    // Update last activity time
    $_SESSION['last_activity'] = time();
    
    // Regenerate session ID periodically (prevent session fixation)
    if (!isset($_SESSION['created'])) {
        $_SESSION['created'] = time();
    } else if (time() - $_SESSION['created'] > 600) {
        // Regenerate session ID every 10 minutes
        session_regenerate_id(true);
        $_SESSION['created'] = time();
    }
    
    return true;
}

/**
 * Destroy Session Securely
 */
function destroySession() {
    $_SESSION = array();
    
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    
    session_destroy();
}

/**
 * Check Rate Limiting for Login
 */
function checkRateLimit($ip = null) {
    global $pdo;
    
    if ($ip === null) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    
    // Get failed login attempts from this IP in the last window
    $stmt = $pdo->prepare("
        SELECT COUNT(*) as attempts 
        FROM login_attempts 
        WHERE ip_address = ? 
        AND attempt_time > DATE_SUB(NOW(), INTERVAL ? SECOND)
    ");
    $stmt->execute([$ip, RATE_LIMIT_WINDOW]);
    $result = $stmt->fetch();
    
    $attempts = $result['attempts'];
    
    // Check if IP is currently locked out
    $stmt = $pdo->prepare("
        SELECT lockout_until 
        FROM login_attempts 
        WHERE ip_address = ? 
        AND is_locked = 1 
        AND lockout_until > NOW()
        ORDER BY attempt_time DESC 
        LIMIT 1
    ");
    $stmt->execute([$ip]);
    $lockout = $stmt->fetch();
    
    if ($lockout) {
        $remaining = strtotime($lockout['lockout_until']) - time();
        return [
            'allowed' => false,
            'attempts' => $attempts,
            'locked' => true,
            'remaining_time' => $remaining,
            'message' => "Terlalu banyak percobaan login. Silakan coba lagi dalam " . ceil($remaining / 60) . " menit."
        ];
    }
    
    if ($attempts >= MAX_LOGIN_ATTEMPTS) {
        // Lock out this IP
        $stmt = $pdo->prepare("
            UPDATE login_attempts 
            SET is_locked = 1, lockout_until = DATE_ADD(NOW(), INTERVAL ? SECOND)
            WHERE ip_address = ? 
            AND attempt_time > DATE_SUB(NOW(), INTERVAL ? SECOND)
        ");
        $stmt->execute([LOGIN_LOCKOUT_TIME, $ip, RATE_LIMIT_WINDOW]);
        
        return [
            'allowed' => false,
            'attempts' => $attempts,
            'locked' => true,
            'remaining_time' => LOGIN_LOCKOUT_TIME,
            'message' => "Terlalu banyak percobaan login. Akun dikunci selama " . ceil(LOGIN_LOCKOUT_TIME / 60) . " menit."
        ];
    }
    
    return [
        'allowed' => true,
        'attempts' => $attempts,
        'locked' => false,
        'remaining_attempts' => MAX_LOGIN_ATTEMPTS - $attempts
    ];
}

/**
 * Record Failed Login Attempt
 */
function recordFailedLogin($username, $ip = null) {
    global $pdo;
    
    if ($ip === null) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    
    $stmt = $pdo->prepare("
        INSERT INTO login_attempts (username, ip_address, attempt_time, is_locked)
        VALUES (?, ?, NOW(), 0)
    ");
    $stmt->execute([$username, $ip]);
    
    // Clean old login attempts (older than 24 hours)
    $stmt = $pdo->prepare("DELETE FROM login_attempts WHERE attempt_time < DATE_SUB(NOW(), INTERVAL 24 HOUR)");
    $stmt->execute();
}

/**
 * Clear Failed Login Attempts on Successful Login
 */
function clearLoginAttempts($username, $ip = null) {
    global $pdo;
    
    if ($ip === null) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    
    $stmt = $pdo->prepare("
        DELETE FROM login_attempts 
        WHERE (username = ? OR ip_address = ?)
        AND attempt_time > DATE_SUB(NOW(), INTERVAL 24 HOUR)
    ");
    $stmt->execute([$username, $ip]);
}

/**
 * Validate Password Strength
 */
function validatePasswordStrength($password) {
    $errors = [];
    
    if (strlen($password) < 8) {
        $errors[] = "Password minimal 8 karakter";
    }
    
    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = "Password harus mengandung huruf kapital";
    }
    
    if (!preg_match('/[a-z]/', $password)) {
        $errors[] = "Password harus mengandung huruf kecil";
    }
    
    if (!preg_match('/[0-9]/', $password)) {
        $errors[] = "Password harus mengandung angka";
    }
    
    if (!preg_match('/[^A-Za-z0-9]/', $password)) {
        $errors[] = "Password harus mengandung karakter spesial (!@#$%^&*)";
    }
    
    return empty($errors) ? true : $errors;
}

/**
 * Sanitize Input Data
 */
function sanitizeInput($data) {
    if (is_array($data)) {
        return array_map('sanitizeInput', $data);
    }
    
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    
    return $data;
}

/**
 * Generate CSRF Token
 */
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Validate CSRF Token
 */
function validateCSRFToken($token) {
    if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        return false;
    }
    return true;
}

/**
 * Generate Security Headers
 */
function setSecurityHeaders() {
    header("X-Frame-Options: " . X_FRAME_OPTIONS);
    header("X-Content-Type-Options: " . X_CONTENT_TYPE_OPTIONS);
    header("X-XSS-Protection: " . X_XSS_PROTECTION);
    
    // Prevent MIME type sniffing
    header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline'");
}

/**
 * Get Client IP Address
 */
function getClientIP() {
    $ip = '';
    
    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED'];
    } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_FORWARDED_FOR'];
    } else if (isset($_SERVER['HTTP_FORWARDED'])) {
        $ip = $_SERVER['HTTP_FORWARDED'];
    } else if (isset($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    
    return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : '0.0.0.0';
}

/**
 * Log Security Event
 */
function logSecurityEvent($event_type, $description, $username = null, $ip = null) {
    global $pdo;
    
    if ($username === null) {
        $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'anonymous';
    }
    
    if ($ip === null) {
        $ip = getClientIP();
    }
    
    $stmt = $pdo->prepare("
        INSERT INTO security_logs (event_type, description, username, ip_address, event_time)
        VALUES (?, ?, ?, ?, NOW())
    ");
    $stmt->execute([$event_type, $description, $username, $ip]);
    
    // Clean old logs (older than 90 days)
    $stmt = $pdo->prepare("DELETE FROM security_logs WHERE event_time < DATE_SUB(NOW(), INTERVAL 90 DAY)");
    $stmt->execute();
}
?>