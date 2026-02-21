<?php
require_once '../config/database.php';
require_once 'auth.php';

$message = '';
$messageType = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tentang = $_POST['tentang'] ?? '';
    $visi_misi = $_POST['visi_misi'] ?? '';
    
    if ($tentang && $visi_misi) {
        // Check jika data profil sudah ada
        $existing = fetchOne("SELECT id FROM profil_sekolah LIMIT 1");
        
        if ($existing) {
            // Update data yang sudah ada
            execute(
                "UPDATE profil_sekolah SET tentang = ?, visi_misi = ?",
                [$tentang, $visi_misi]
            );
        } else {
            // Insert data baru
            execute(
                "INSERT INTO profil_sekolah (tentang, visi_misi) VALUES (?, ?)",
                [$tentang, $visi_misi]
            );
        }
        $message = 'Profil berhasil diperbarui!';
        $messageType = 'success';
    } else {
        $message = 'Mohon lengkapi semua field!';
        $messageType = 'danger';
    }
}

// Get current data
$profil = fetchOne("SELECT * FROM profil_sekolah LIMIT 1");
$tentang = $profil ? $profil['tentang'] : '';
$visi_misi = $profil ? $profil['visi_misi'] : '';
$active_menu = 'profil';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SLB Rumah Kita Batam – Admin Panel</title>
    <link rel="shortcut icon" href="../gambar/icon.jpg">
    <link rel="icon" href="../gambar/icon.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/4.25.1-lts/standard/ckeditor.js"></script>
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
            <h2 class="fw-bold mb-0">Edit Profil Sekolah</h2>
            <p class="text-muted mb-0">Kelola informasi profil sekolah</p>
        </div>
        
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <!-- Tentang Sekolah -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle text-primary me-2"></i>Tentang Sekolah</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="tentang" class="form-label">Deskripsi Sekolah <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="tentang" name="tentang" rows="10" required><?php echo $tentang; ?></textarea>
                    </div>
                </div>
            </div>
            
            <!-- Visi & Misi -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-bullseye text-primary me-2"></i>Visi & Misi</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="visi_misi" class="form-label">Visi dan Misi <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="visi_misi" name="visi_misi" rows="10" required><?php echo $visi_misi; ?></textarea>
                        <small class="text-muted mt-2">Gunakan format HTML untuk heading dan list.</small>
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
            </div>
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        CKEDITOR.replace('tentang');
        CKEDITOR.replace('visi_misi');
        
        // Update CKEditor content before form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            CKEDITOR.instances.tentang.updateElement();
            CKEDITOR.instances.visi_misi.updateElement();
        });
    </script>
</body>
</html>