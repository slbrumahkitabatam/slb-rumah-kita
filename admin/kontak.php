<?php
session_start();
require_once '../config/database.php';
require_once 'auth.php';

$message = '';
$messageType = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $alamat = $_POST['alamat'] ?? '';
    $telepon = $_POST['telepon'] ?? '';
    $email = $_POST['email'] ?? '';
    $maps = $_POST['maps'] ?? '';
    $facebook = $_POST['facebook'] ?? '';
    $instagram = $_POST['instagram'] ?? '';
    $youtube = $_POST['youtube'] ?? '';
    
    // Check if settings exist
    $check = fetchOne("SELECT COUNT(*) as total FROM pengaturan");
    if ($check['total'] > 0) {
        // Update existing
        execute("UPDATE pengaturan SET alamat = ?, telepon = ?, email = ?, maps = ?, facebook = ?, instagram = ?, youtube = ? WHERE id = (SELECT MIN(id) FROM pengaturan)", 
                [$alamat, $telepon, $email, $maps, $facebook, $instagram, $youtube]);
    } else {
        // Insert new
        execute("INSERT INTO pengaturan (alamat, telepon, email, maps, facebook, instagram, youtube) VALUES (?, ?, ?, ?, ?, ?, ?)", 
                [$alamat, $telepon, $email, $maps, $facebook, $instagram, $youtube]);
    }
    
    $message = 'Informasi kontak berhasil diperbarui!';
    $messageType = 'success';
}

// Get current settings
$settings = fetchOne("SELECT * FROM pengaturan LIMIT 1");

$alamat = $settings['alamat'] ?? '';
$telepon = $settings['telepon'] ?? '';
$email = $settings['email'] ?? '';
$maps = $settings['maps'] ?? '';
$facebook = $settings['facebook'] ?? '';
$instagram = $settings['instagram'] ?? '';
$youtube = $settings['youtube'] ?? '';
$active_menu = 'kontak';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak Sekolah - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            <h2 class="fw-bold mb-0">Informasi Kontak</h2>
            <p class="text-muted mb-0">Kelola informasi kontak sekolah</p>
        </div>
        
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <!-- Informasi Kontak -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-map-marker-alt text-primary me-2"></i>Informasi Kontak</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?php echo htmlspecialchars($alamat); ?></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="telepon" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
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
            
            <!-- Google Maps -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-map text-primary me-2"></i>Peta Lokasi</h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label for="maps" class="form-label">Embed Code Google Maps</label>
                <textarea class="form-control" id="maps" name="maps" rows="5" placeholder="Paste iframe embed code dari Google Maps di sini"><?php echo htmlspecialchars($maps); ?></textarea>
                <small class="text-muted mt-1">
                    <i class="fas fa-info-circle me-1"></i>
                    Buka Google Maps, klik "Share" > "Embed a map", lalu copy kode iframe
                </small>
            </div>
            <?php if ($maps): ?>
            <div class="mb-3">
                <label>Preview Peta:</label>
                <div style="border: 2px solid #dee2e6; border-radius: 10px; overflow: hidden;">
                    <?php echo $maps; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
            
            <!-- Media Sosial -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-share-alt text-primary me-2"></i>Media Sosial (Opsional)</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="facebook" class="form-label">
                                <i class="fab fa-facebook text-primary"></i> Facebook URL
                            </label>
                            <input type="url" class="form-control" id="facebook" name="facebook" 
                                   value="<?php echo htmlspecialchars($facebook); ?>" placeholder="https://facebook.com/...">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="instagram" class="form-label">
                                <i class="fab fa-instagram text-danger"></i> Instagram URL
                            </label>
                            <input type="url" class="form-control" id="instagram" name="instagram" 
                                   value="<?php echo htmlspecialchars($instagram); ?>" placeholder="https://instagram.com/...">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="youtube" class="form-label">
                                <i class="fab fa-youtube text-danger"></i> YouTube URL
                            </label>
                            <input type="url" class="form-control" id="youtube" name="youtube" 
                                   value="<?php echo htmlspecialchars($youtube); ?>" placeholder="https://youtube.com/...">
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
                <a href="../kontak.php" target="_blank" class="btn btn-info">
                    <i class="fas fa-external-link-alt me-2"></i>Lihat Halaman Kontak
                </a>
            </div>
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>