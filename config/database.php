<?php
// Konfigurasi Database
define('DB_HOST', 'localhost');
define('DB_USER', 'rumahkitabtmweb_ftth');
define('DB_PASS', 'Of,C9kyqg4M}eXFw');
define('DB_NAME', 'rumahkitabtmweb_ftth');

// Koneksi ke Database
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
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