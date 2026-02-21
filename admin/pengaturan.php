<?php
session_start();
require_once '../config/database.php';
require_once 'auth.php';

$message = '';
$messageType = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_sekolah = $_POST['nama_sekolah'] ?? '';
    $alamat = $_POST['alamat'] ?? '';
    $telepon = $_POST['telepon'] ?? '';
    $email = $_POST['email'] ?? '';
    
    try {
        // Check if settings exist
        $check = fetchOne("SELECT COUNT(*) as total FROM pengaturan");
        if ($check && $check['total'] > 0) {
            // Update existing
            execute("UPDATE pengaturan SET nama_sekolah = ?, alamat = ?, telepon = ?, email = ? WHERE id = (SELECT MIN(id) FROM pengaturan)", 
                    [$nama_sekolah, $alamat, $telepon, $email]);
        } else {
            // Insert new
            execute("INSERT INTO pengaturan (nama_sekolah, alamat, telepon, email) VALUES (?, ?, ?, ?)", 
                    [$nama_sekolah, $alamat, $telepon, $email]);
        }
        
        $message = 'Pengaturan berhasil diperbarui!';
        $messageType = 'success';
    } catch (PDOException $e) {
        $message = 'Terjadi kesalahan: ' . $e->getMessage();
        $messageType = 'danger';
    }
}

// Get current settings
$settings = fetchOne("SELECT * FROM pengaturan LIMIT 1");

$nama_sekolah = $settings['nama_sekolah'] ?? 'SLB Rumah Kita Batam';
$alamat = $settings['alamat'] ?? '';
$telepon = $settings['telepon'] ?? '';
$email = $settings['email'] ?? '';
$active_menu = 'pengaturan';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SLB Rumah Kita Batam – Admin Panel</title>
    <link rel="shortcut icon" href="../gambar/icon.jpg">
    <link rel="icon" href="../gambar/icon.jpg">
 +++++++ REPLACE
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
 +++++++ REPLACE
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <?php require_once 'includes/sidebar.php'; ?>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="mb-4">
            <h2 class="fw-bold mb-0">Pengaturan Website</h2>
            <p class="text-muted mb-0">Konfigurasi dasar website</p>
        </div>
        
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <form method="POST">
        <!-- Informasi Sekolah -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-school text-primary me-2"></i>Informasi Sekolah</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="nama_sekolah" class="form-label">Nama Sekolah <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nama_sekolah" name="nama_sekolah" 
                           value="<?php echo htmlspecialchars($nama_sekolah); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?php echo htmlspecialchars($alamat); ?></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="telepon" class="form-label">Telepon <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="telepon" name="telepon" 
                               value="<?php echo htmlspecialchars($telepon); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?php echo htmlspecialchars($email); ?>" required>
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
</body>
</html>