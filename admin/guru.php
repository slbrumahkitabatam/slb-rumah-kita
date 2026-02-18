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
    $nama = $_POST['nama'] ?? '';
    $jabatan = $_POST['jabatan'] ?? '';
    $deskripsi = $_POST['deskripsi'] ?? '';
    $aktif = isset($_POST['aktif']) ? 1 : 0;
    
    // Handle file upload
    $foto = '';
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/guru/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto = uniqid() . '.' . $ext;
        move_uploaded_file($_FILES['foto']['tmp_name'], $uploadDir . $foto);
    }
    
    if ($action === 'tambah') {
        if ($nama && $jabatan) {
            execute(
                "INSERT INTO guru (nama, jabatan, deskripsi, foto, aktif) VALUES (?, ?, ?, ?, ?)",
                [$nama, $jabatan, $deskripsi, $foto, $aktif]
            );
            $message = 'Data guru berhasil ditambahkan!';
            $messageType = 'success';
        } else {
            $message = 'Mohon lengkapi nama dan jabatan!';
            $messageType = 'danger';
        }
    } elseif ($action === 'edit') {
        if ($nama && $jabatan) {
            if ($foto) {
                execute(
                    "UPDATE guru SET nama = ?, jabatan = ?, deskripsi = ?, foto = ?, aktif = ? WHERE id = ?",
                    [$nama, $jabatan, $deskripsi, $foto, $aktif, $id]
                );
            } else {
                execute(
                    "UPDATE guru SET nama = ?, jabatan = ?, deskripsi = ?, aktif = ? WHERE id = ?",
                    [$nama, $jabatan, $deskripsi, $aktif, $id]
                );
            }
            $message = 'Data guru berhasil diperbarui!';
            $messageType = 'success';
            $action = '';
        } else {
            $message = 'Mohon lengkapi nama dan jabatan!';
            $messageType = 'danger';
        }
    }
}

// Handle delete
if ($action === 'hapus' && $id) {
    $guru = fetchOne("SELECT * FROM guru WHERE id = ?", [$id]);
    if ($guru && $guru['foto']) {
        $file = '../uploads/guru/' . $guru['foto'];
        if (file_exists($file)) {
            unlink($file);
        }
    }
    execute("DELETE FROM guru WHERE id = ?", [$id]);
    $message = 'Data guru berhasil dihapus!';
    $messageType = 'success';
    $action = '';
}

// Get data for edit
$guru = null;
if ($action === 'edit' && $id) {
    $guru = fetchOne("SELECT * FROM guru WHERE id = ?", [$id]);
}
$active_menu = 'guru';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Guru & Staf - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .guru-card {
            transition: transform 0.3s;
        }
        .guru-card:hover {
            transform: translateY(-5px);
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
                    <?php echo $action === 'tambah' ? 'Tambah Guru' : ($action === 'edit' ? 'Edit Guru' : 'Manajemen Guru & Staf'); ?>
                </h2>
                <p class="text-muted mb-0">Kelola data guru dan staf sekolah</p>
            </div>
            <?php if (!$action): ?>
            <a href="?action=tambah" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Guru
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
                                <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama" name="nama" 
                                       value="<?php echo $guru ? htmlspecialchars($guru['nama']) : ''; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="jabatan" class="form-label">Jabatan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="jabatan" name="jabatan" 
                                       value="<?php echo $guru ? htmlspecialchars($guru['jabatan']) : ''; ?>" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi Singkat</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"><?php echo $guru ? htmlspecialchars($guru['deskripsi']) : ''; ?></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="foto" class="form-label">
                                    <?php echo $action === 'tambah' ? 'Upload Foto' : 'Ganti Foto'; ?>
                                </label>
                                <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                                <?php if ($guru && $guru['foto']): ?>
                                    <div class="mt-2">
                                        <img src="../uploads/guru/<?php echo htmlspecialchars($guru['foto']); ?>" 
                                             alt="Current photo" class="img-thumbnail" style="max-width: 150px;">
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6 mb-3 d-flex align-items-end">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="aktif" name="aktif" 
                                           <?php echo ($guru && $guru['aktif']) || !$guru ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="aktif">
                                        Aktif (tampilkan di website)
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan
                            </button>
                            <a href="guru.php" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <!-- List Guru -->
            <div class="row">
                <?php
                $guru_list = fetchAll("SELECT * FROM guru ORDER BY nama ASC");
                if ($guru_list):
                    foreach ($guru_list as $item):
                ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card border-0 shadow-sm guru-card h-100">
                        <?php if ($item['foto']): ?>
                            <img src="../uploads/guru/<?php echo htmlspecialchars($item['foto']); ?>" 
                                 alt="<?php echo htmlspecialchars($item['nama']); ?>" 
                                 class="card-img-top" style="height: 200px; object-fit: cover;">
                        <?php else: ?>
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fas fa-user fa-3x text-muted"></i>
                            </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($item['nama']); ?></h5>
                            <p class="card-text text-primary fw-bold"><?php echo htmlspecialchars($item['jabatan']); ?></p>
                            <?php if ($item['deskripsi']): ?>
                                <p class="card-text text-muted small"><?php echo htmlspecialchars(substr($item['deskripsi'], 0, 100)); ?>...</p>
                            <?php endif; ?>
                        </div>
                        <div class="card-footer bg-white border-top">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>
                                    <?php if ($item['aktif']): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    <?php endif; ?>
                                </span>
                                <div class="d-flex gap-2">
                                    <a href="?action=edit&id=<?php echo $item['id']; ?>" class="btn btn-sm btn-info">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="?action=hapus&id=<?php echo $item['id']; ?>" class="btn btn-sm btn-danger" 
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
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
                        <i class="fas fa-users fa-3x text-muted mb-3 d-block"></i>
                        <p class="text-muted">Belum ada data guru</p>
                        <a href="?action=tambah" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Tambah Guru
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