<?php
session_start();
require_once '../config/database.php';
require_once 'auth.php';

$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? '';
$message = '';
$messageType = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'] ?? '';
    $deskripsi = $_POST['deskripsi'] ?? '';
    $tanggal = $_POST['tanggal'] ?? date('Y-m-d');
    
    // Handle file upload
    $gambar = '';
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/galeri/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $gambar = uniqid() . '.' . $ext;
        move_uploaded_file($_FILES['gambar']['tmp_name'], $uploadDir . $gambar);
    }
    
    if ($action === 'tambah') {
        if ($judul && $gambar) {
            execute(
                "INSERT INTO galeri (judul, deskripsi, gambar, tanggal) VALUES (?, ?, ?, ?)",
                [$judul, $deskripsi, $gambar, $tanggal]
            );
            $message = 'Foto berhasil ditambahkan!';
            $messageType = 'success';
        } else {
            $message = 'Judul dan gambar wajib diisi!';
            $messageType = 'danger';
        }
    } elseif ($action === 'edit') {
        if ($judul) {
            if ($gambar) {
                execute(
                    "UPDATE galeri SET judul = ?, deskripsi = ?, gambar = ?, tanggal = ? WHERE id = ?",
                    [$judul, $deskripsi, $gambar, $tanggal, $id]
                );
            } else {
                execute(
                    "UPDATE galeri SET judul = ?, deskripsi = ?, tanggal = ? WHERE id = ?",
                    [$judul, $deskripsi, $tanggal, $id]
                );
            }
            $message = 'Galeri berhasil diperbarui!';
            $messageType = 'success';
            $action = '';
        } else {
            $message = 'Judul wajib diisi!';
            $messageType = 'danger';
        }
    }
}

// Handle delete
if ($action === 'hapus' && $id) {
    $galeri = fetchOne("SELECT * FROM galeri WHERE id = ?", [$id]);
    if ($galeri && $galeri['gambar']) {
        $file = '../uploads/galeri/' . $galeri['gambar'];
        if (file_exists($file)) {
            unlink($file);
        }
    }
    execute("DELETE FROM galeri WHERE id = ?", [$id]);
    $message = 'Galeri berhasil dihapus!';
    $messageType = 'success';
    $action = '';
}

// Get data for edit
$galeri = null;
if ($action === 'edit' && $id) {
    $galeri = fetchOne("SELECT * FROM galeri WHERE id = ?", [$id]);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Galeri - Admin Panel</title>
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
        .gallery-preview {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
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
                    <a class="nav-link active" href="galeri.php">
                        <i class="fas fa-images"></i>Galeri
                    </a>
                    <a class="nav-link" href="profil.php">
                        <i class="fas fa-user-edit"></i>Profil
                    </a>
                    <a class="nav-link" href="pengaturan.php">
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
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fw-bold mb-0">
                            <?php echo $action === 'tambah' ? 'Upload Galeri' : ($action === 'edit' ? 'Edit Galeri' : 'Manajemen Galeri'); ?>
                        </h2>
                        <p class="text-muted mb-0">Kelola foto galeri kegiatan sekolah</p>
                    </div>
                    <?php if (!$action): ?>
                    <a href="?action=tambah" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>Upload Galeri
                    </a>
                    <?php endif; ?>
                </div>
                
                <?php if ($message): ?>
                    <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                        <?php echo $message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <?php if ($action === 'tambah' || $action === 'edit'): ?>
                    <!-- Form Tambah/Edit -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <form method="POST" action="?action=<?php echo $action; ?><?php echo $id ? '&id=' . $id : ''; ?>" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="judul" class="form-label">Judul Foto <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="judul" name="judul" 
                                               value="<?php echo $galeri ? htmlspecialchars($galeri['judul']) : ''; ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="tanggal" name="tanggal" 
                                               value="<?php echo $galeri ? $galeri['tanggal'] : date('Y-m-d'); ?>" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="gambar" class="form-label">
                                        <?php echo $action === 'tambah' ? 'Gambar <span class="text-danger">*</span>' : 'Gambar'; ?>
                                    </label>
                                    <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" 
                                           <?php echo $action === 'tambah' ? 'required' : ''; ?>>
                                    <?php if ($galeri && $galeri['gambar']): ?>
                                        <div class="mt-2">
                                            <img src="../uploads/galeri/<?php echo htmlspecialchars($galeri['gambar']); ?>" 
                                                 alt="Preview" class="gallery-preview">
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"><?php echo $galeri ? $galeri['deskripsi'] : ''; ?></textarea>
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save me-2"></i>Simpan
                                    </button>
                                    <a href="galeri.php" class="btn btn-secondary">
                                        <i class="fas fa-times me-2"></i>Batal
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- List Galeri -->
                    <div class="row">
                        <?php
                        $galeri_list = fetchAll("SELECT * FROM galeri ORDER BY tanggal DESC");
                        if ($galeri_list):
                            foreach ($galeri_list as $item):
                        ?>
                        <div class="col-md-4 col-lg-3 mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="position-relative">
                                    <?php if ($item['gambar']): ?>
                                        <img src="../uploads/galeri/<?php echo htmlspecialchars($item['gambar']); ?>" 
                                             alt="<?php echo htmlspecialchars($item['judul']); ?>" class="card-img-top gallery-preview">
                                    <?php else: ?>
                                        <div class="card-img-top gallery-preview bg-light d-flex align-items-center justify-content-center">
                                            <i class="fas fa-image fa-3x text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div class="position-absolute top-0 end-0 p-2">
                                        <div class="btn-group">
                                            <a href="?action=edit&id=<?php echo $item['id']; ?>" class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="?action=hapus&id=<?php echo $item['id']; ?>" class="btn btn-sm btn-danger" 
                                               onclick="return confirm('Apakah Anda yakin ingin menghapus foto ini?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h6 class="card-title mb-1"><?php echo htmlspecialchars($item['judul']); ?></h6>
                                    <small class="text-muted">
                                        <i class="far fa-calendar-alt me-1"></i>
                                        <?php echo date('d F Y', strtotime($item['tanggal'])); ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <?php 
                            endforeach;
                        else:
                        ?>
                        <div class="col-12 text-center py-5">
                            <i class="fas fa-images fa-5x text-muted mb-3 d-block"></i>
                            <h3 class="text-muted">Belum Ada Galeri</h3>
                            <p class="text-muted mb-4">Belum ada foto yang diupload</p>
                            <a href="?action=tambah" class="btn btn-success">
                                <i class="fas fa-upload me-2"></i>Upload Galeri
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>