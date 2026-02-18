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
    
    // Handle logo upload
    $logo = '';
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $ext = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
        $logo = 'logo_' . uniqid() . '.' . $ext;
        move_uploaded_file($_FILES['logo']['tmp_name'], $uploadDir . $logo);
    }
    
    if ($nama_sekolah) {
        if ($logo) {
            execute(
                "UPDATE pengaturan SET nama_sekolah = ?, alamat = ?, telepon = ?, email = ?, logo = ? WHERE id = 1",
                [$nama_sekolah, $alamat, $telepon, $email, $logo]
            );
        } else {
            execute(
                "UPDATE pengaturan SET nama_sekolah = ?, alamat = ?, telepon = ?, email = ? WHERE id = 1",
                [$nama_sekolah, $alamat, $telepon, $email]
            );
        }
        $message = 'Pengaturan berhasil diperbarui!';
        $messageType = 'success';
    } else {
        $message = 'Nama sekolah wajib diisi!';
        $messageType = 'danger';
    }
}

// Get current settings
$pengaturan = fetchOne("SELECT * FROM pengaturan WHERE id = 1");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            background: linear-gradient(135deg, #4A90E2 0%, #357ABD 100%);
            min-height: 100vh;
            color: white;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            margin: 5px 10px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: rgba(255,255,255,0.2);
            color: white;
        }
        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
        }
        .main-content {
            padding: 30px;
        }
        .logo-preview {
            width: 200px;
            height: auto;
            object-fit: contain;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar d-md-block p-0">
                <div class="p-4 text-center border-bottom border-light">
                    <i class="fas fa-school fa-3x mb-2"></i>
                    <h5 class="mb-0 fw-bold">Admin Panel</h5>
                    <small>SLB Rumah Kita Batam</small>
                </div>
                <nav class="nav flex-column py-3">
                    <a class="nav-link" href="index.php">
                        <i class="fas fa-tachometer-alt"></i>Dashboard
                    </a>
                    <a class="nav-link" href="berita.php">
                        <i class="fas fa-newspaper"></i>Berita
                    </a>
                    <a class="nav-link" href="galeri.php">
                        <i class="fas fa-images"></i>Galeri
                    </a>
                    <a class="nav-link" href="profil.php">
                        <i class="fas fa-user-edit"></i>Profil
                    </a>
                    <a class="nav-link active" href="pengaturan.php">
                        <i class="fas fa-cog"></i>Pengaturan
                    </a>
                    <a class="nav-link mt-4" href="../index.php" target="_blank">
                        <i class="fas fa-external-link-alt"></i>Lihat Website
                    </a>
                    <a class="nav-link text-danger" href="logout.php">
                        <i class="fas fa-sign-out-alt"></i>Logout
                    </a>
                </nav>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <!-- Header -->
                <div class="mb-4">
                    <h2 class="fw-bold mb-0">Pengaturan Website</h2>
                    <p class="text-muted mb-0">Kelola informasi dan identitas sekolah</p>
                </div>
                
                <?php if ($message): ?>
                    <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                        <?php echo $message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <form method="POST" enctype="multipart/form-data">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="fas fa-building text-primary me-2"></i>Informasi Sekolah</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label for="nama_sekolah" class="form-label">Nama Sekolah <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama_sekolah" name="nama_sekolah" 
                                           value="<?php echo $pengaturan ? htmlspecialchars($pengaturan['nama_sekolah']) : ''; ?>" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="logo" class="form-label">Logo Sekolah</label>
                                    <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                                    <?php if ($pengaturan && $pengaturan['logo']): ?>
                                        <div class="mt-2">
                                            <img src="../uploads/<?php echo htmlspecialchars($pengaturan['logo']); ?>" 
                                                 alt="Logo Sekolah" class="logo-preview rounded">
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat Sekolah <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?php echo $pengaturan ? htmlspecialchars($pengaturan['alamat']) : ''; ?></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="telepon" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="telepon" name="telepon" 
                                           value="<?php echo $pengaturan ? htmlspecialchars($pengaturan['telepon']) : ''; ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email Sekolah <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?php echo $pengaturan ? htmlspecialchars($pengaturan['email']) : ''; ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Informasi Tambahan -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="fas fa-info-circle text-info me-2"></i>Informasi Tambahan</h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="fas fa-lightbulb me-2"></i>
                                <strong>Tips:</strong>
                                <ul class="mb-0">
                                    <li>Logo sekolah akan ditampilkan di header website</li>
                                    <li>Informasi kontak akan ditampilkan di halaman kontak dan footer</li>
                                    <li>Pastikan semua informasi sudah benar sebelum menyimpan</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tombol Simpan -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save me-2"></i>Simpan Pengaturan
                        </button>
                        <a href="index.php" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>