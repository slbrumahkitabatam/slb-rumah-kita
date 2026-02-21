<?php
session_start();
require_once '../config/database.php';
require_once 'auth.php';

$message = '';
$messageType = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $warna_utama = $_POST['warna_utama'] ?? '#4A90E2';
    $warna_teks = $_POST['warna_teks'] ?? '#333333';
    
    // Handle logo upload
    $logo = null;
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $ext = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
        $logo = 'logo.' . $ext;
        move_uploaded_file($_FILES['logo']['tmp_name'], $uploadDir . $logo);
    }
    
    // Check if settings exist
    $check = fetchOne("SELECT COUNT(*) as total FROM pengaturan");
    if ($check['total'] > 0) {
        // Update existing - hanya update field tampilan (warna dan logo)
        if ($logo) {
            // Update warna dan logo
            execute("UPDATE pengaturan SET warna_utama = ?, warna_teks = ?, logo = ? WHERE id = (SELECT MIN(id) FROM pengaturan)", 
                   [$warna_utama, $warna_teks, $logo]);
        } else {
            // Update hanya warna
            execute("UPDATE pengaturan SET warna_utama = ?, warna_teks = ? WHERE id = (SELECT MIN(id) FROM pengaturan)", 
                   [$warna_utama, $warna_teks]);
        }
    } else {
        // Insert new - ambil data default untuk field lain
        $default_nama = 'SLB Rumah Kita Batam';
        $default_alamat = '';
        $default_telepon = '';
        $default_email = '';
        execute("INSERT INTO pengaturan (nama_sekolah, alamat, telepon, email, logo, warna_utama, warna_teks) VALUES (?, ?, ?, ?, ?, ?, ?)", 
                [$default_nama, $default_alamat, $default_telepon, $default_email, $logo, $warna_utama, $warna_teks]);
    }
    
    $message = 'Tampilan berhasil diperbarui!';
    $messageType = 'success';
}

// Get current settings
$settings = fetchOne("SELECT * FROM pengaturan LIMIT 1");

$nama_sekolah = $settings['nama_sekolah'] ?? 'SLB Rumah Kita Batam';
$alamat = $settings['alamat'] ?? '';
$telepon = $settings['telepon'] ?? '';
$email = $settings['email'] ?? '';
$logo = $settings['logo'] ?? '';
$warna_utama = $settings['warna_utama'] ?? '#667eea';
$warna_teks = $settings['warna_teks'] ?? '#333333';
$active_menu = 'tampilan';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tampilan Website - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .color-preview {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            border: 2px solid #dee2e6;
            display: inline-block;
            vertical-align: middle;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <?php require_once 'includes/sidebar.php'; ?>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="mb-4">
            <h2 class="fw-bold mb-0">Tampilan Website</h2>
            <p class="text-muted mb-0">Sesuaikan tampilan website</p>
        </div>
        
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <form method="POST" enctype="multipart/form-data">
            <!-- Logo -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-image text-primary me-2"></i>Logo Website</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="logo" class="form-label">Upload Logo</label>
                        <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                        <?php if ($logo): ?>
                            <div class="mt-3">
                                <img src="../uploads/<?php echo htmlspecialchars($logo); ?>" 
                                     alt="Logo" class="img-thumbnail" style="max-width: 200px;">
                                <p class="text-muted small mt-2">Logo saat ini</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Warna -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-palette text-primary me-2"></i>Warna Tema</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="warna_utama" class="form-label">Warna Utama</label>
                            <div class="d-flex align-items-center">
                                <input type="color" class="form-control form-control-color" id="warna_utama" name="warna_utama" 
                                       value="<?php echo htmlspecialchars($warna_utama); ?>" style="width: 100px;">
                                <span class="color-preview" style="background-color: <?php echo htmlspecialchars($warna_utama); ?>"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="warna_teks" class="form-label">Warna Teks</label>
                            <div class="d-flex align-items-center">
                                <input type="color" class="form-control form-control-color" id="warna_teks" name="warna_teks" 
                                       value="<?php echo htmlspecialchars($warna_teks); ?>" style="width: 100px;">
                                <span class="color-preview" style="background-color: <?php echo htmlspecialchars($warna_teks); ?>"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Tombol Simpan -->
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                </button>
                <a href="index.php" class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i>Batal
                </a>
                <a href="../index.php" target="_blank" class="btn btn-info">
                    <i class="fas fa-external-link-alt me-2"></i>Lihat Website
                </a>
            </div>
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Update color preview on change
        document.getElementById('warna_utama').addEventListener('change', function() {
            this.nextElementSibling.style.backgroundColor = this.value;
        });
        document.getElementById('warna_teks').addEventListener('change', function() {
            this.nextElementSibling.style.backgroundColor = this.value;
        });
    </script>
</body>
</html>