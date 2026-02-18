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
    $urutan = $_POST['urutan'] ?? 0;
    $aktif = isset($_POST['aktif']) ? 1 : 0;
    $icon = $_POST['icon'] ?? 'fa-file-alt';
    
    // Generate slug
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $judul)));
    
    if ($action === 'tambah') {
        if ($judul && $isi) {
            execute(
                "INSERT INTO halaman (judul, slug, isi, urutan, aktif, icon) VALUES (?, ?, ?, ?, ?, ?)",
                [$judul, $slug, $isi, $urutan, $aktif, $icon]
            );
            $message = 'Halaman berhasil ditambahkan!';
            $messageType = 'success';
        } else {
            $message = 'Mohon lengkapi field yang diperlukan!';
            $messageType = 'danger';
        }
    } elseif ($action === 'edit') {
        if ($judul && $isi) {
            execute(
                "UPDATE halaman SET judul = ?, slug = ?, isi = ?, urutan = ?, aktif = ?, icon = ? WHERE id = ?",
                [$judul, $slug, $isi, $urutan, $aktif, $icon, $id]
            );
            $message = 'Halaman berhasil diperbarui!';
            $messageType = 'success';
            $action = '';
        } else {
            $message = 'Mohon lengkapi field yang diperlukan!';
            $messageType = 'danger';
        }
    }
}

// Handle delete
if ($action === 'hapus' && $id) {
    execute("DELETE FROM halaman WHERE id = ?", [$id]);
    $message = 'Halaman berhasil dihapus!';
    $messageType = 'success';
    $action = '';
}

// Get data for edit
$halaman = null;
if ($action === 'edit' && $id) {
    $halaman = fetchOne("SELECT * FROM halaman WHERE id = ?", [$id]);
}
$active_menu = 'halaman';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Halaman & Menu - Admin Panel</title>
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
                    <?php echo $action === 'tambah' ? 'Tambah Halaman' : ($action === 'edit' ? 'Edit Halaman' : 'Manajemen Halaman & Menu'); ?>
                </h2>
                <p class="text-muted mb-0">Kelola halaman website dan menu navigasi</p>
            </div>
            <?php if (!$action): ?>
            <a href="?action=tambah" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Halaman
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
                    <form method="POST" action="?action=<?php echo $action; ?><?php echo $id ? '&id=' . $id : ''; ?>">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="judul" class="form-label">Judul Halaman <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="judul" name="judul" 
                                       value="<?php echo $halaman ? htmlspecialchars($halaman['judul']) : ''; ?>" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="urutan" class="form-label">Urutan Menu</label>
                                <input type="number" class="form-control" id="urutan" name="urutan" 
                                       value="<?php echo $halaman ? $halaman['urutan'] : 0; ?>">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="icon" class="form-label">Icon Menu</label>
                                <select class="form-select" id="icon" name="icon">
                                    <option value="fa-file-alt" <?php echo ($halaman && $halaman['icon'] === 'fa-file-alt') ? 'selected' : ''; ?>>📄 Dokumen</option>
                                    <option value="fa-home" <?php echo ($halaman && $halaman['icon'] === 'fa-home') ? 'selected' : ''; ?>>🏠 Beranda</option>
                                    <option value="fa-school" <?php echo ($halaman && $halaman['icon'] === 'fa-school') ? 'selected' : ''; ?>>🏫 Sekolah</option>
                                    <option value="fa-graduation-cap" <?php echo ($halaman && $halaman['icon'] === 'fa-graduation-cap') ? 'selected' : ''; ?>>🎓 Program</option>
                                    <option value="fa-users" <?php echo ($halaman && $halaman['icon'] === 'fa-users') ? 'selected' : ''; ?>>👥 Guru</option>
                                    <option value="fa-envelope" <?php echo ($halaman && $halaman['icon'] === 'fa-envelope') ? 'selected' : ''; ?>>📧 Kontak</option>
                                    <option value="fa-info-circle" <?php echo ($halaman && $halaman['icon'] === 'fa-info-circle') ? 'selected' : ''; ?>>ℹ️ Info</option>
                                    <option value="fa-star" <?php echo ($halaman && $halaman['icon'] === 'fa-star') ? 'selected' : ''; ?>>⭐ Bintang</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="isi" class="form-label">Konten Halaman <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="isi" name="isi" rows="15" required><?php echo $halaman ? $halaman['isi'] : ''; ?></textarea>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="aktif" name="aktif" 
                                       <?php echo ($halaman && $halaman['aktif']) || !$halaman ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="aktif">
                                    Aktif (tampilkan di menu)
                                </label>
                            </div>
                        </div>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>URL Halaman:</strong> <code><?php echo '../halaman.php?slug=' . ($halaman ? $halaman['slug'] : '[slug]'); ?></code>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan
                            </button>
                            <a href="halaman.php" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <!-- List Halaman -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>No</th>
                                    <th>Icon</th>
                                    <th>Judul</th>
                                    <th>Slug</th>
                                    <th>Urutan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $halaman_list = fetchAll("SELECT * FROM halaman ORDER BY urutan ASC, judul ASC");
                                if ($halaman_list):
                                    $no = 1;
                                    foreach ($halaman_list as $item):
                                ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td>
                                        <span class="badge bg-light text-dark">
                                            <i class="fas <?php echo htmlspecialchars($item['icon'] ?? 'fa-file-alt'); ?>"></i>
                                        </span>
                                    </td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($item['judul']); ?></strong>
                                    </td>
                                    <td>
                                        <code><?php echo htmlspecialchars($item['slug']); ?></code>
                                        <br>
                                        <a href="../halaman.php?slug=<?php echo htmlspecialchars($item['slug']); ?>" target="_blank" class="small">
                                            <i class="fas fa-external-link-alt"></i> Lihat
                                        </a>
                                    </td>
                                    <td><?php echo $item['urutan']; ?></td>
                                    <td>
                                        <?php if ($item['aktif']): ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="?action=edit&id=<?php echo $item['id']; ?>" class="btn btn-sm btn-info me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="?action=hapus&id=<?php echo $item['id']; ?>" class="btn btn-sm btn-danger" 
                                           onclick="return confirm('Apakah Anda yakin ingin menghapus halaman ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php 
                                    endforeach;
                                else:
                                ?>
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <i class="fas fa-sitemap fa-3x text-muted mb-3 d-block"></i>
                                        <p class="text-muted">Belum ada halaman</p>
                                        <a href="?action=tambah" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Tambah Halaman
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