<?php
// Konfigurasi Database dan Environment

// Deteksi Environment Otomatis
$is_localhost = ($_SERVER['SERVER_NAME'] == 'localhost' || 
                 $_SERVER['SERVER_NAME'] == '127.0.0.1' || 
                 strpos($_SERVER['SERVER_NAME'], '.local') !== false ||
                 strpos($_SERVER['HTTP_HOST'], 'localhost') !== false ||
                 strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false);

// Base URL Otomatis
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$path = dirname($_SERVER['SCRIPT_NAME']);

// Hilangkan '/config' dari path jika ada
$path = str_replace('/config', '', $path);
$path = rtrim($path, '/');

define('BASE_URL', $protocol . '://' . $host . $path);
define('BASE_PATH', __DIR__ . '/..'); // Path absolut ke root project

// Konfigurasi Path Gambar dan Upload
define('UPLOADS_DIR', BASE_PATH . '/uploads');
define('GAMBAR_DIR', BASE_PATH . '/gambar');
define('UPLOADS_URL', BASE_URL . '/uploads');
define('GAMBAR_URL', BASE_URL . '/gambar');

// Konfigurasi Database berdasarkan Environment
if ($is_localhost) {
    // KONFIGURASI LOCALHOST
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'rumahkitabtmweb_ftth');
} else {
    // KONFIGURASI HOSTING/cPanel
    // Edit bagian ini saat deploy ke hosting
    define('DB_HOST', 'localhost'); // Biasanya localhost di cPanel
    define('DB_USER', '');         // Isi dengan username database cPanel
    define('DB_PASS', '');         // Isi dengan password database cPanel
    define('DB_NAME', '');         // Isi dengan nama database cPanel
}

// Koneksi ke Database
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    // Tampilkan error detail di localhost, sederhanakan di hosting
    if ($is_localhost) {
        die("<strong>Koneksi Database Gagal!</strong><br> 
             Error: " . $e->getMessage() . "<br>
             Pastikan konfigurasi database di <code>config/database.php</code> sudah benar.");
    } else {
        die("Terjadi kesalahan koneksi database. Silakan hubungi administrator.");
    }
}

// Fungsi helper untuk query
function query($sql, $params = []) {
    global $pdo;
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt;
}

function fetchAll($sql, $params = []) {
    $stmt = query($sql, $params);
    return $stmt->fetchAll();
}

function fetchOne($sql, $params = []) {
    $stmt = query($sql, $params);
    return $stmt->fetch();
}

function execute($sql, $params = []) {
    return query($sql, $params);
}
?>
