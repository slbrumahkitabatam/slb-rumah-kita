<?php
/**
 * Setup Upload Folders
 * Script ini akan membuat folder uploads yang diperlukan
 */

echo "<!DOCTYPE html>
<html lang='id'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Setup Upload Folders - SLB Rumah Kita</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
</head>
<body class='bg-light py-5'>
    <div class='container'>
        <div class='card shadow'>
            <div class='card-header bg-success text-white'>
                <h2 class='mb-0'>📁 Setup Upload Folders</h2>
            </div>
            <div class='card-body'>
";

$directories = [
    'uploads',
    'uploads/galeri',
    'uploads/berita'
];

echo "<h4>Status Folder Uploads:</h4>";
echo "<ul class='list-group mb-4'>";

$allSuccess = true;

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        if (mkdir($dir, 0777, true)) {
            echo "<li class='list-group-item list-group-item-success'>✅ <strong>$dir</strong> - Berhasil dibuat!</li>";
        } else {
            echo "<li class='list-group-item list-group-item-danger'>❌ <strong>$dir</strong> - Gagal dibuat!</li>";
            $allSuccess = false;
        }
    } else {
        if (is_writable($dir)) {
            echo "<li class='list-group-item list-group-item-success'>✅ <strong>$dir</strong> - Sudah ada & writable</li>";
        } else {
            echo "<li class='list-group-item list-group-item-warning'>⚠️ <strong>$dir</strong> - Ada tapi tidak writable</li>";
            $allSuccess = false;
        }
    }
}

echo "</ul>";

// Create .htaccess for security
foreach ($directories as $dir) {
    if (is_dir($dir)) {
        $htaccess = $dir . '/.htaccess';
        if (!file_exists($htaccess)) {
            file_put_contents($htaccess, "Options -Indexes\nOrder Allow,Deny\nDeny from all");
            echo "<div class='alert alert-info'>🔒 Security file (.htaccess) created for <strong>$dir</strong></div>";
        }
    }
}

if ($allSuccess) {
    echo "<div class='alert alert-success'>
        <h5>✅ Setup Selesai!</h5>
        <p>Semua folder uploads telah siap digunakan.</p>
        <p>Sekarang Anda dapat:</p>
        <ul>
            <li><a href='test_upload.php' class='btn btn-info'>Test Upload System</a></li>
            <li><a href='admin/galeri.php' class='btn btn-primary'>Upload Galeri</a></li>
            <li><a href='admin/berita.php' class='btn btn-primary'>Upload Berita</a></li>
        </ul>
    </div>";
} else {
    echo "<div class='alert alert-warning'>
        <h5>⚠️ Ada Masalah</h5>
        <p>Beberapa folder tidak dapat dibuat atau writable. Silakan:</p>
        <ul>
            <li>Cek permission folder</li>
            <li>Pastikan user PHP memiliki akses write</li>
            <li>Di Windows: pastikan folder tidak Read-only</li>
            <li>Di Linux/Mac: coba <code>chmod -R 777 uploads/</code></li>
        </ul>
    </div>";
}

echo "</div></div></div></body></html>";
?>