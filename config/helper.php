<?php
// Helper Functions untuk Path dan URL yang Dinamis

/**
 * Mendapatkan base URL aplikasi
 */
function base_url($path = '') {
    return BASE_URL . ($path ? '/' . ltrim($path, '/') : '');
}

/**
 * Mendapatkan URL gambar
 */
function gambar_url($filename) {
    if (empty($filename)) return GAMBAR_URL . '/no-image.jpg';
    return GAMBAR_URL . '/' . ltrim($filename, '/');
}

/**
 * Mendapatkan URL upload
 */
function upload_url($filename) {
    if (empty($filename)) return UPLOADS_URL . '/no-file.jpg';
    return UPLOADS_URL . '/' . ltrim($filename, '/');
}

/**
 * Mendapatkan path absolut untuk file gambar
 */
function gambar_path($filename) {
    if (empty($filename)) return GAMBAR_DIR . '/no-image.jpg';
    return GAMBAR_DIR . '/' . ltrim($filename, '/');
}

/**
 * Mendapatkan path absolut untuk file upload
 */
function upload_path($filename) {
    if (empty($filename)) return UPLOADS_DIR . '/no-file.jpg';
    return UPLOADS_DIR . '/' . ltrim($filename, '/');
}

/**
 * Redirect ke URL tertentu
 */
function redirect($url) {
    header("Location: " . base_url($url));
    exit();
}

/**
 * Redirect kembali ke halaman sebelumnya
 */
function redirect_back() {
    if (isset($_SERVER['HTTP_REFERER'])) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
        redirect('');
    }
    exit();
}

/**
 * Format tanggal Indonesia
 */
function tgl_indo($tanggal) {
    if (empty($tanggal)) return '-';
    
    $bulan = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];
    
    $pecah = explode('-', $tanggal);
    if (count($pecah) == 3) {
        return $pecah[2] . ' ' . $bulan[(int)$pecah[1]] . ' ' . $pecah[0];
    }
    return $tanggal;
}

/**
 * Format tanggal singkat (dd-mm-yyyy)
 */
function tgl_singkat($tanggal) {
    if (empty($tanggal)) return '-';
    $pecah = explode('-', $tanggal);
    if (count($pecah) == 3) {
        return $pecah[2] . '-' . $pecah[1] . '-' . $pecah[0];
    }
    return $tanggal;
}

/**
 * Potong teks (truncate)
 */
function potong_teks($teks, $panjang = 150) {
    if (strlen($teks) <= $panjang) return $teks;
    return substr(strip_tags($teks), 0, $panjang) . '...';
}

/**
 * Sanitasi input
 */
function sanitize($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

/**
 * Cek apakah user login
 */
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

/**
 * Cek apakah user adalah admin
 */
function is_admin() {
    return isset($_SESSION['role']) && $_SESSION['role'] == 'admin';
}

/**
 * Generate slug dari judul
 */
function generate_slug($judul) {
    $slug = strtolower($judul);
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    $slug = trim($slug, '-');
    return $slug;
}

/**
 * Upload file
 */
function upload_file($file, $target_dir = 'uploads', $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'webp']) {
    if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
        return ['success' => false, 'message' => 'Tidak ada file yang diupload'];
    }
    
    $filename = $file['name'];
    $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $file_size = $file['size'];
    
    // Validasi tipe file
    if (!in_array($file_ext, $allowed_types)) {
        return ['success' => false, 'message' => 'Tipe file tidak diizinkan'];
    }
    
    // Validasi ukuran file (max 5MB)
    if ($file_size > 5 * 1024 * 1024) {
        return ['success' => false, 'message' => 'Ukuran file terlalu besar (max 5MB)'];
    }
    
    // Generate nama file unik
    $new_filename = time() . '_' . uniqid() . '.' . $file_ext;
    $target_path = BASE_PATH . '/' . $target_dir . '/' . $new_filename;
    
    // Pastikan direktori ada
    if (!file_exists(BASE_PATH . '/' . $target_dir)) {
        mkdir(BASE_PATH . '/' . $target_dir, 0777, true);
    }
    
    // Upload file
    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        return ['success' => true, 'filename' => $new_filename];
    } else {
        return ['success' => false, 'message' => 'Gagal mengupload file'];
    }
}

/**
 * Hapus file
 */
function delete_file($filename, $target_dir = 'uploads') {
    if (empty($filename)) return true;
    
    $file_path = BASE_PATH . '/' . $target_dir . '/' . $filename;
    if (file_exists($file_path)) {
        return unlink($file_path);
    }
    return true;
}

/**
 * Set flash message
 */
function set_flash($type, $message) {
    $_SESSION['flash'][$type] = $message;
}

/**
 * Get flash message
 */
function get_flash($type) {
    if (isset($_SESSION['flash'][$type])) {
        $message = $_SESSION['flash'][$type];
        unset($_SESSION['flash'][$type]);
        return $message;
    }
    return '';
}

/**
 * Tampilkan alert Bootstrap
 */
function alert($type, $message) {
    $alert_types = [
        'success' => 'alert-success',
        'error' => 'alert-danger',
        'warning' => 'alert-warning',
        'info' => 'alert-info'
    ];
    
    $class = isset($alert_types[$type]) ? $alert_types[$type] : 'alert-info';
    return '<div class="alert ' . $class . ' alert-dismissible fade show" role="alert">
            ' . $message . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}

/**
 * Convert hex color to RGB format
 * Used for CSS rgba() and box-shadow
 */
function hexToRgb($hex) {
    $hex = preg_replace("/[^0-9a-fA-F]/", '', $hex);
    
    if (strlen($hex) == 3) {
        $r = hexdec($hex[0] . $hex[0]);
        $g = hexdec($hex[1] . $hex[1]);
        $b = hexdec($hex[2] . $hex[2]);
    } elseif (strlen($hex) == 6) {
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
    } else {
        return '102, 126, 234'; // Default color
    }
    
    return $r . ', ' . $g . ', ' . $b;
}

/**
 * Adjust color brightness
 * Positive value lightens, negative value darkens
 */
function adjustColorBrightness($hex, $percent) {
    $hex = preg_replace("/[^0-9a-fA-F]/", '', $hex);
    
    if (strlen($hex) == 3) {
        $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
    }
    
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    
    $r = min(255, max(0, $r + ($r * $percent / 100)));
    $g = min(255, max(0, $g + ($g * $percent / 100)));
    $b = min(255, max(0, $b + ($b * $percent / 100)));
    
    return sprintf("#%02x%02x%02x", round($r), round($g), round($b));
}
?>
