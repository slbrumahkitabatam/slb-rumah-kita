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
    
    // Handle file upload with proper error handling
    $gambar = '';
    $uploadError = '';
    
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] !== UPLOAD_ERR_NO_FILE) {
        $uploadDir = '../uploads/galeri/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        // Check for upload errors
        if ($_FILES['gambar']['error'] !== UPLOAD_ERR_OK) {
            $uploadErrors = [
                UPLOAD_ERR_INI_SIZE => 'Ukuran file melebihi batas maximum (upload_max_filesize)',
                UPLOAD_ERR_FORM_SIZE => 'Ukuran file melebihi batas maximum form',
                UPLOAD_ERR_PARTIAL => 'File hanya terupload sebagian',
                UPLOAD_ERR_NO_TMP_DIR => 'Folder temporary tidak ditemukan',
                UPLOAD_ERR_CANT_WRITE => 'Gagal menulis file ke disk',
                UPLOAD_ERR_EXTENSION => 'Upload file dihentikan oleh extension PHP'
            ];
            $uploadError = $uploadErrors[$_FILES['gambar']['error']] ?? 'Terjadi kesalahan saat upload file';
        } else {
            // Validate file type
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $_FILES['gambar']['tmp_name']);
            finfo_close($finfo);
            
            if (!in_array($mimeType, $allowedTypes)) {
                $uploadError = 'Tipe file tidak diizinkan. Hanya file gambar (JPG, PNG, GIF, WEBP) yang diperbolehkan.';
            } else {
                // Validate file size (max 5MB)
                $maxSize = 5 * 1024 * 1024; // 5MB
                if ($_FILES['gambar']['size'] > $maxSize) {
                    $uploadError = 'Ukuran file terlalu besar. Maksimal 5MB.';
                } else {
                    // Upload file
                    $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
                    $gambar = uniqid() . '.' . $ext;
                    
                    if (!move_uploaded_file($_FILES['gambar']['tmp_name'], $uploadDir . $gambar)) {
                        $uploadError = 'Gagal menyimpan file ke server. Periksa permission folder uploads.';
                        $gambar = '';
                    }
                }
            }
        }
    }
    
    if ($action === 'tambah') {
        if ($uploadError) {
            $message = 'Upload gagal: ' . $uploadError;
            $messageType = 'danger';
        } elseif ($judul && $gambar) {
            try {
                execute(
                    "INSERT INTO galeri (judul, deskripsi, gambar, tanggal) VALUES (?, ?, ?, NOW())",
                    [$judul, $deskripsi, $gambar]
                );
                $message = 'Foto berhasil ditambahkan!';
                $messageType = 'success';
                $action = ''; // Reset action to show list
            } catch (PDOException $e) {
                $message = 'Gagal menyimpan ke database: ' . $e->getMessage();
                $messageType = 'danger';
                // Delete uploaded file if database insert failed
                if ($gambar && file_exists($uploadDir . $gambar)) {
                    unlink($uploadDir . $gambar);
                }
            }
        } else {
            $message = 'Mohon lengkapi judul dan upload gambar!';
            $messageType = 'danger';
        }
    } elseif ($action === 'edit') {
        if ($uploadError) {
            $message = 'Upload gagal: ' . $uploadError;
            $messageType = 'danger';
        } elseif ($judul) {
            try {
                // Get old image for deletion if new image is uploaded
                $oldGambar = '';
                if ($gambar) {
                    $oldData = fetchOne("SELECT gambar FROM galeri WHERE id = ?", [$id]);
                    $oldGambar = $oldData['gambar'] ?? '';
                }
                
                if ($gambar) {
                    execute(
                        "UPDATE galeri SET judul = ?, deskripsi = ?, gambar = ? WHERE id = ?",
                        [$judul, $deskripsi, $gambar, $id]
                    );
                    // Delete old image if update successful
                    if ($oldGambar && file_exists($uploadDir . $oldGambar)) {
                        unlink($uploadDir . $oldGambar);
                    }
                } else {
                    execute(
                        "UPDATE galeri SET judul = ?, deskripsi = ? WHERE id = ?",
                        [$judul, $deskripsi, $id]
                    );
                }
                $message = 'Foto berhasil diperbarui!';
                $messageType = 'success';
                $action = '';
            } catch (PDOException $e) {
                $message = 'Gagal memperbarui data: ' . $e->getMessage();
                $messageType = 'danger';
                // Delete new image if database update failed
                if ($gambar && file_exists($uploadDir . $gambar)) {
                    unlink($uploadDir . $gambar);
                }
            }
        } else {
            $message = 'Mohon lengkapi judul!';
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
    $message = 'Foto berhasil dihapus!';
    $messageType = 'success';
    $action = '';
}

// Get data for edit
$galeri = null;
if ($action === 'edit' && $id) {
    $galeri = fetchOne("SELECT * FROM galeri WHERE id = ?", [$id]);
}
$active_menu = 'galeri';
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
        .gallery-item {
            transition: transform 0.3s;
        }
        .gallery-item:hover {
            transform: scale(1.02);
        }
    </style>
</head>
<body>
    <?php require_once 'includes/sidebar.php'; ?>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-0">
                    <?php echo $action === 'tambah' ? 'Upload Foto' : ($action === 'edit' ? 'Edit Foto' : 'Manajemen Galeri'); ?>
                </h2>
                <p class="text-muted mb-0">Kelola galeri foto sekolah</p>
            </div>
            <?php if (!$action): ?>
            <a href="?action=tambah" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Upload Foto
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
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Foto <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="judul" name="judul" 
                                   value="<?php echo $galeri ? htmlspecialchars($galeri['judul']) : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"><?php echo $galeri ? htmlspecialchars($galeri['deskripsi']) : ''; ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="gambar" class="form-label">
                                <?php echo $action === 'tambah' ? 'Upload Gambar <span class="text-danger">*</span>' : 'Ganti Gambar'; ?>
                            </label>
                            <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" 
                                   <?php echo $action === 'tambah' ? 'required' : ''; ?>>
                            <?php if ($galeri && $galeri['gambar']): ?>
                                <div class="mt-2">
                                    <img src="../uploads/galeri/<?php echo htmlspecialchars($galeri['gambar']); ?>" 
                                         alt="Current image" class="img-thumbnail" style="max-width: 200px;">
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
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
                $galeri_list = fetchAll("SELECT * FROM galeri ORDER BY created_at DESC");
                if ($galeri_list):
                    foreach ($galeri_list as $item):
                ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card border-0 shadow-sm gallery-item h-100">
                        <?php if ($item['gambar']): ?>
                            <img src="../uploads/galeri/<?php echo htmlspecialchars($item['gambar']); ?>" 
                                 alt="<?php echo htmlspecialchars($item['judul']); ?>" 
                                 class="card-img-top" style="height: 200px; object-fit: cover;">
                        <?php else: ?>
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($item['judul']); ?></h5>
                            <?php if ($item['deskripsi']): ?>
                                <p class="card-text text-muted small"><?php echo htmlspecialchars(substr($item['deskripsi'], 0, 100)); ?>...</p>
                            <?php endif; ?>
                            <small class="text-muted">
                                <i class="far fa-calendar-alt me-1"></i>
                                <?php echo date('d F Y', strtotime($item['tanggal'])); ?>
                            </small>
                        </div>
                        <div class="card-footer bg-white border-top">
                            <div class="d-flex gap-2">
                                <a href="?action=edit&id=<?php echo $item['id']; ?>" class="btn btn-sm btn-info flex-grow-1">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </a>
                                <a href="?action=hapus&id=<?php echo $item['id']; ?>" class="btn btn-sm btn-danger" 
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus foto ini?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php 
                    endforeach;
                else:
                ?>
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-images fa-3x text-muted mb-3 d-block"></i>
                        <p class="text-muted">Belum ada foto di galeri</p>
                        <a href="?action=tambah" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Upload Foto
                        </a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>