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
    
    // Handle file upload with proper error handling
    $gambar = '';
    $uploadError = '';
    
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] !== UPLOAD_ERR_NO_FILE) {
        $uploadDir = '../uploads/berita/';
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
        } elseif ($judul && $isi) {
            try {
                execute(
                    "INSERT INTO berita (judul, slug, isi, gambar, tanggal, penulis) VALUES (?, ?, ?, ?, ?, ?)",
                    [$judul, $slug, $isi, $gambar, $tanggal, $penulis]
                );
                $message = 'Berita berhasil ditambahkan!';
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
            $message = 'Mohon lengkapi semua field!';
            $messageType = 'danger';
        }
    } elseif ($action === 'edit') {
        if ($uploadError) {
            $message = 'Upload gagal: ' . $uploadError;
            $messageType = 'danger';
        } elseif ($judul && $isi) {
            try {
                // Get old image for deletion if new image is uploaded
                $oldGambar = '';
                if ($gambar) {
                    $oldData = fetchOne("SELECT gambar FROM berita WHERE id = ?", [$id]);
                    $oldGambar = $oldData['gambar'] ?? '';
                }
                
                if ($gambar) {
                    execute(
                        "UPDATE berita SET judul = ?, slug = ?, isi = ?, gambar = ?, tanggal = ?, penulis = ? WHERE id = ?",
                        [$judul, $slug, $isi, $gambar, $tanggal, $penulis, $id]
                    );
                    // Delete old image if update successful
                    if ($oldGambar && file_exists($uploadDir . $oldGambar)) {
                        unlink($uploadDir . $oldGambar);
                    }
                } else {
                    execute(
                        "UPDATE berita SET judul = ?, slug = ?, isi = ?, tanggal = ?, penulis = ? WHERE id = ?",
                        [$judul, $slug, $isi, $tanggal, $penulis, $id]
                    );
                }
                $message = 'Berita berhasil diperbarui!';
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
        
        /* Elegant Header Styles */
        .elegant-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(102, 126, 234, 0.4);
        }
        
        .elegant-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: shimmer 15s infinite;
        }
        
        @keyframes shimmer {
            0%, 100% { transform: rotate(0deg); }
            50% { transform: rotate(180deg); }
        }
        
        .header-content {
            position: relative;
            z-index: 1;
        }
        
        .header-icon {
            width: 70px;
            height: 70px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            margin-bottom: 20px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        .elegant-header h2 {
            color: white;
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 10px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1rem;
            margin-bottom: 0;
            font-weight: 300;
            letter-spacing: 0.5px;
        }
        
        .btn-elegant {
            background: white;
            color: #667eea;
            border: none;
            padding: 12px 30px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .btn-elegant:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            color: #764ba2;
        }
        
        .decorative-dots {
            position: absolute;
            bottom: 20px;
            right: 30px;
            display: flex;
            gap: 10px;
        }
        
        .decorative-dots .dot {
            width: 10px;
            height: 10px;
            background: rgba(255, 255, 255, 0.4);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }
        
        .decorative-dots .dot:nth-child(2) {
            animation-delay: 0.4s;
        }
        
        .decorative-dots .dot:nth-child(3) {
            animation-delay: 0.8s;
        }
        
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                opacity: 0.4;
            }
            50% {
                transform: scale(1.3);
                opacity: 0.8;
            }
        }
        
        /* Card Enhancement */
        .card {
            border-radius: 16px;
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
        }
        
        .card:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        }
        
        /* Table Enhancement */
        .table thead th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: 600;
            border: none;
            padding: 15px;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
        
        .table tbody tr {
            transition: all 0.3s;
        }
        
        .table tbody tr:hover {
            background-color: rgba(102, 126, 234, 0.05);
            transform: scale(1.01);
        }
        
        .table td {
            vertical-align: middle;
            padding: 15px;
        }
        
        /* Button Enhancement */
        .btn-info {
            background: linear-gradient(135deg, #17a2b8, #138496);
            border: none;
            transition: all 0.3s;
        }
        
        .btn-info:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(23, 162, 184, 0.4);
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #dc3545, #c82333);
            border: none;
            transition: all 0.3s;
        }
        
        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.4);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        /* Alert Enhancement */
        .alert {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }
    </style>
 +++++++ REPLACE
</head>
<body>
    <?php require_once 'includes/sidebar.php'; ?>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Elegant Header -->
        <div class="elegant-header">
            <div class="header-content d-flex justify-content-between align-items-center">
                <div>
                    <div class="header-icon">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <h2>
                        <?php echo $action === 'tambah' ? 'Tambah Berita Baru' : ($action === 'edit' ? 'Edit Berita' : 'Berita & Kegiatan Sekolah'); ?>
                    </h2>
                    <p class="subtitle">
                        <?php echo $action === 'tambah' ? 'Buat berita baru untuk website sekolah' : ($action === 'edit' ? 'Perbarui konten berita yang ada' : 'Ikuti informasi terbaru dan kegiatan dari SLB Rumah Kita Batam'); ?>
                    </p>
                </div>
                <?php if (!$action): ?>
                <a href="?action=tambah" class="btn btn-elegant">
                    <i class="fas fa-plus me-2"></i>Tambah Berita
                </a>
                <?php endif; ?>
            </div>
            <div class="decorative-dots">
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>
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