<?php
// Test Upload Diagnostic Script
// This script helps diagnose upload issues

echo "<!DOCTYPE html>
<html lang='id'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Test Upload - SLB Rumah Kita</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
</head>
<body class='bg-light py-5'>
    <div class='container'>
        <div class='card shadow'>
            <div class='card-header bg-primary text-white'>
                <h2 class='mb-0'>🔍 Diagnostic Upload</h2>
            </div>
            <div class='card-body'>
";

// Check PHP configuration
echo "<h4>⚙️ Konfigurasi PHP</h4>";
echo "<ul class='list-group mb-4'>";

$maxUpload = ini_get('upload_max_filesize');
$maxPost = ini_get('post_max_size');
echo "<li class='list-group-item'><strong>upload_max_filesize:</strong> $maxUpload</li>";
echo "<li class='list-group-item'><strong>post_max_size:</strong> $maxPost</li>";
echo "<li class='list-group-item'><strong>file_uploads:</strong> " . (ini_get('file_uploads') ? '✅ Enabled' : '❌ Disabled') . "</li>";
echo "<li class='list-group-item'><strong>max_execution_time:</strong> " . ini_get('max_execution_time') . "s</li>";
echo "</ul>";

// Check directories
echo "<h4>📁 Cek Folder Uploads</h4>";
$uploadDirs = [
    'uploads',
    'uploads/galeri',
    'uploads/berita'
];

echo "<ul class='list-group mb-4'>";
foreach ($uploadDirs as $dir) {
    if (is_dir($dir)) {
        if (is_writable($dir)) {
            echo "<li class='list-group-item list-group-item-success'>✅ <strong>$dir</strong> - Ada & writable</li>";
        } else {
            echo "<li class='list-group-item list-group-item-warning'>⚠️ <strong>$dir</strong> - Ada tapi tidak writable</li>";
        }
    } else {
        echo "<li class='list-group-item list-group-item-danger'>❌ <strong>$dir</strong> - Tidak ada</li>";
    }
}
echo "</ul>";

// Create directories if they don't exist
echo "<h4>🔧 Create Directories</h4>";
echo "<ul class='list-group mb-4'>";
foreach ($uploadDirs as $dir) {
    if (!is_dir($dir)) {
        if (mkdir($dir, 0777, true)) {
            echo "<li class='list-group-item list-group-item-success'>✅ <strong>$dir</strong> - Berhasil dibuat</li>";
        } else {
            echo "<li class='list-group-item list-group-item-danger'>❌ <strong>$dir</strong> - Gagal dibuat</li>";
        }
    }
}
echo "</ul>";

// Database connection test
echo "<h4>🗄️ Test Database</h4>";
try {
    require_once 'config/database.php';
    echo "<div class='alert alert-success'>✅ Database connection successful!</div>";
    
    // Check tables
    $tables = ['galeri', 'berita'];
    echo "<h5>Cek Tabel:</h5>";
    echo "<ul class='list-group mb-4'>";
    
    foreach ($tables as $table) {
        $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
        if ($stmt->rowCount() > 0) {
            // Check gambar column
            $columns = $pdo->query("SHOW COLUMNS FROM $table")->fetchAll();
            $hasGambar = false;
            foreach ($columns as $col) {
                if ($col['Field'] === 'gambar') {
                    $hasGambar = true;
                    break;
                }
            }
            if ($hasGambar) {
                echo "<li class='list-group-item list-group-item-success'>✅ <strong>$table</strong> - Ada dengan kolom gambar</li>";
            } else {
                echo "<li class='list-group-item list-group-item-warning'>⚠️ <strong>$table</strong> - Ada tapi tidak ada kolom gambar</li>";
            }
        } else {
            echo "<li class='list-group-item list-group-item-danger'>❌ <strong>$table</strong> - Tidak ada</li>";
        }
    }
    echo "</ul>";
    
} catch (Exception $e) {
    echo "<div class='alert alert-danger'>❌ Database error: " . htmlspecialchars($e->getMessage()) . "</div>";
}

// Test upload form
echo "<h4>📤 Test Upload Gambar</h4>";
?>
<form method="POST" enctype="multipart/form-data" class="mb-4">
    <div class="mb-3">
        <label class="form-label">Pilih file untuk diupload:</label>
        <input type="file" name="test_file" class="form-control" accept="image/*" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Upload ke:</label>
        <select name="upload_dir" class="form-select">
            <option value="galeri">uploads/galeri</option>
            <option value="berita">uploads/berita</option>
        </select>
    </div>
    <button type="submit" name="upload_test" class="btn btn-primary">Upload Test</button>
</form>

<?php
if (isset($_POST['upload_test'])) {
    echo "<div class='card bg-light mb-4'>";
    echo "<div class='card-body'>";
    echo "<h5>Hasil Upload:</h5>";
    
    if (isset($_FILES['test_file'])) {
        echo "<pre>";
        echo "Error code: " . $_FILES['test_file']['error'] . "\n";
        echo "Name: " . $_FILES['test_file']['name'] . "\n";
        echo "Size: " . $_FILES['test_file']['size'] . " bytes\n";
        echo "Type: " . $_FILES['test_file']['type'] . "\n";
        echo "Tmp name: " . $_FILES['test_file']['tmp_name'] . "\n";
        echo "</pre>";
        
        $uploadDir = 'uploads/' . $_POST['upload_dir'] . '/';
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        if ($_FILES['test_file']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['test_file']['name'], PATHINFO_EXTENSION);
            $filename = 'test_' . time() . '.' . $ext;
            
            if (move_uploaded_file($_FILES['test_file']['tmp_name'], $uploadDir . $filename)) {
                echo "<div class='alert alert-success'>✅ Upload berhasil!</div>";
                echo "<p>File tersimpan: <strong>" . htmlspecialchars($uploadDir . $filename) . "</strong></p>";
                if (file_exists($uploadDir . $filename)) {
                    echo "<img src='" . htmlspecialchars($uploadDir . $filename) . "' class='img-thumbnail' style='max-width: 300px;'>";
                }
            } else {
                echo "<div class='alert alert-danger'>❌ Gagal memindahkan file ke folder uploads</div>";
            }
        } else {
            $errors = [
                UPLOAD_ERR_INI_SIZE => 'File terlalu besar (upload_max_filesize)',
                UPLOAD_ERR_FORM_SIZE => 'File terlalu besar (MAX_FILE_SIZE)',
                UPLOAD_ERR_PARTIAL => 'File hanya terupload sebagian',
                UPLOAD_ERR_NO_FILE => 'Tidak ada file yang diupload',
                UPLOAD_ERR_NO_TMP_DIR => 'Folder temporary tidak ditemukan',
                UPLOAD_ERR_CANT_WRITE => 'Gagal menulis ke disk',
                UPLOAD_ERR_EXTENSION => 'Upload dihentikan oleh extension PHP'
            ];
            $errorMsg = $errors[$_FILES['test_file']['error']] ?? 'Unknown error';
            echo "<div class='alert alert-danger'>❌ Upload gagal: " . htmlspecialchars($errorMsg) . "</div>";
        }
    }
    echo "</div></div>";
}

echo "</div></div></div></body></html>";
?>