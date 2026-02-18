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
    $isi = $_POST['isi'] ?? '';
    $penulis = $_POST['penulis'] ?? $_SESSION['nama'];
    $tanggal = $_POST['tanggal'] ?? date('Y-m-d');
    
    // Generate slug
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $judul)));
    
    // Handle file upload
    $gambar = '';
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/berita/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $gambar = uniqid() . '.' . $ext;
        move_uploaded_file($_FILES['gambar']['tmp_name'], $uploadDir . $gambar);
    }
    
    if ($action === 'tambah') {
        if ($judul && $isi) {
            execute(
                "INSERT INTO berita (judul, slug, isi, gambar, tanggal, penulis) VALUES (?, ?, ?, ?, ?, ?)",
                [$judul, $slug, $isi, $gambar, $tanggal, $penulis]
            );
            $message = 'Berita berhasil ditambahkan!';
            $messageType = 'success';
        } else {
            $message = 'Mohon lengkapi semua field!';
            $messageType = 'danger';
        }
    } elseif ($action === 'edit') {
        if ($judul && $isi) {
            if ($gambar) {
                execute(
                    "UPDATE berita SET judul = ?, slug = ?, isi = ?, gambar = ?, tanggal = ?, penulis = ? WHERE id = ?",
                    [$judul, $slug, $isi, $gambar, $tanggal, $penulis, $id]
                );
            } else {
                execute(
                    "UPDATE berita SET judul = ?, slug = ?, isi = ?, tanggal = ?, penulis = ? WHERE id = ?",
                    [$judul, $slug, $isi, $tanggal, $penulis, $id]
                );
            }
            $message = 'Berita berhasil diperbarui!';
            $messageType = 'success';
            $action = '';
        } else {
            $message = 'Mohon lengkapi semua field!';
            $messageType = 'danger';
        }
    }
}

// Handle delete
if ($action === 'hapus' && $id) {
    $berita = fetchOne("SELECT * FROM berita WHERE id = ?", [$id]);
    if ($berita && $berita['gambar']) {
        $file = '../uploads/berita/' . $berita['gambar'];
        if (file_exists($file)) {
            unlink($file);
        }
    }
    execute("DELETE FROM berita WHERE id = ?", [$id]);
    $message = 'Berita berhasil dihapus!';
    $messageType = 'success';
    $action = '';
}

// Get data for edit
$berita = null;
if ($action === 'edit' && $id) {
    $berita = fetchOne("SELECT * FROM berita WHERE id = ?", [$id]);
}
$active_menu = 'berita';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Berita - Admin Panel</title>
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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-0">
                    <?php echo $action === 'tambah' ? 'Tambah Berita' : ($action === 'edit' ? 'Edit Berita' : 'Manajemen Berita'); ?>
                </h2>
                <p class="text-muted mb-0">Kelola konten berita sekolah</p>
            </div>
            <?php if (!$action): ?>
            <a href="?action=tambah" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Berita
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
                            <div class="col-md-8 mb-3">
                                <label for="judul" class="form-label">Judul Berita <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="judul" name="judul" 
                                       value="<?php echo $berita ? htmlspecialchars($berita['judul']) : ''; ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" 
                                       value="<?php echo $berita ? $berita['tanggal'] : date('Y-m-d'); ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="penulis" class="form-label">Penulis <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="penulis" name="penulis" 
                                       value="<?php echo $berita ? htmlspecialchars($berita['penulis']) : htmlspecialchars($_SESSION['nama']); ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="gambar" class="form-label">Gambar</label>
                                <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                                <?php if ($berita && $berita['gambar']): ?>
                                    <small class="text-muted">Gambar saat ini: <?php echo $berita['gambar']; ?></small>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="isi" class="form-label">Isi Berita <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="isi" name="isi" rows="10" required><?php echo $berita ? $berita['isi'] : ''; ?></textarea>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan
                            </button>
                            <a href="berita.php" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <!-- List Berita -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Judul</th>
                                    <th>Tanggal</th>
                                    <th>Penulis</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $berita_list = fetchAll("SELECT * FROM berita ORDER BY tanggal DESC");
                                if ($berita_list):
                                    $no = 1;
                                    foreach ($berita_list as $item):
                                ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td>
                                        <?php if ($item['gambar']): ?>
                                            <img src="../uploads/berita/<?php echo htmlspecialchars($item['gambar']); ?>" 
                                                 alt="" width="50" height="50" style="object-fit: cover;" class="rounded">
                                        <?php else: ?>
                                            <div class="bg-light rounded" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($item['judul']); ?></strong>
                                        <br>
                                        <small class="text-muted">
                                            <a href="../detail_berita.php?slug=<?php echo htmlspecialchars($item['slug']); ?>" target="_blank">
                                                Lihat di website <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        </small>
                                    </td>
                                    <td><?php echo date('d F Y', strtotime($item['tanggal'])); ?></td>
                                    <td><?php echo htmlspecialchars($item['penulis']); ?></td>
                                    <td>
                                        <a href="?action=edit&id=<?php echo $item['id']; ?>" class="btn btn-sm btn-info me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="?action=hapus&id=<?php echo $item['id']; ?>" class="btn btn-sm btn-danger" 
                                           onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php 
                                    endforeach;
                                else:
                                ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <i class="fas fa-newspaper fa-3x text-muted mb-3 d-block"></i>
                                        <p class="text-muted">Belum ada berita</p>
                                        <a href="?action=tambah" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Tambah Berita
                                        </a>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        CKEDITOR.replace('isi');
        
        // Update CKEditor content before form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            CKEDITOR.instances.isi.updateElement();
        });
    </script>
</body>
</html>