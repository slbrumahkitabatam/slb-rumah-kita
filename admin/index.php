<?php
session_start();
require_once '../config/database.php';
require_once 'auth.php';

// Get statistics
$total_berita = fetchOne("SELECT COUNT(*) as total FROM berita")['total'];
$total_galeri = fetchOne("SELECT COUNT(*) as total FROM galeri")['total'];
$total_guru = fetchOne("SELECT COUNT(*) as total FROM guru WHERE aktif = 1")['total'];
$total_halaman = fetchOne("SELECT COUNT(*) as total FROM halaman WHERE aktif = 1")['total'];
$active_menu = 'dashboard';
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
 +++++++ REPLACE
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .stat-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        .quick-action-btn {
            transition: all 0.3s;
            height: 100%;
        }
        .quick-action-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        .recent-item {
            transition: all 0.3s;
        }
        .recent-item:hover {
            background-color: #f8f9fa;
            transform: translateX(5px);
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
                <h2 class="fw-bold mb-0">Dashboard</h2>
                <p class="text-muted mb-0">Selamat datang, <?php echo htmlspecialchars($_SESSION['nama']); ?>!</p>
            </div>
            <div class="d-flex align-items-center">
                <span class="badge bg-primary me-2" style="padding: 8px 16px; font-size: 0.9rem;">
                    <i class="fas fa-user me-1"></i>
                    <?php echo htmlspecialchars($_SESSION['username']); ?>
                </span>
            </div>
        </div>
        
        <!-- Statistics -->
        <div class="row mb-4">
            <div class="col-md-3 mb-4">
                <div class="stat-card card h-100 p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-muted mb-1">Total Berita</h6>
                            <h2 class="fw-bold mb-0"><?php echo $total_berita; ?></h2>
                        </div>
                        <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-newspaper"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="stat-card card h-100 p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-muted mb-1">Total Galeri</h6>
                            <h2 class="fw-bold mb-0"><?php echo $total_galeri; ?></h2>
                        </div>
                        <div class="stat-icon bg-success bg-opacity-10 text-success">
                            <i class="fas fa-images"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="stat-card card h-100 p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-muted mb-1">Guru Aktif</h6>
                            <h2 class="fw-bold mb-0"><?php echo $total_guru; ?></h2>
                        </div>
                        <div class="stat-icon bg-info bg-opacity-10 text-info">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="stat-card card h-100 p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-muted mb-1">Halaman Aktif</h6>
                            <h2 class="fw-bold mb-0"><?php echo $total_halaman; ?></h2>
                        </div>
                        <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                            <i class="fas fa-sitemap"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-bolt text-warning me-2"></i>Aksi Cepat</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <a href="berita.php?action=tambah" class="btn btn-primary quick-action-btn w-100 py-4">
                                    <i class="fas fa-plus-circle fa-2x mb-2 d-block"></i>
                                    Tambah Berita
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="galeri.php?action=tambah" class="btn btn-success quick-action-btn w-100 py-4">
                                    <i class="fas fa-upload fa-2x mb-2 d-block"></i>
                                    Upload Galeri
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="profil.php" class="btn btn-info quick-action-btn w-100 py-4">
                                    <i class="fas fa-edit fa-2x mb-2 d-block"></i>
                                    Edit Profil
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="pengaturan.php" class="btn btn-warning quick-action-btn w-100 py-4">
                                    <i class="fas fa-cog fa-2x mb-2 d-block"></i>
                                    Pengaturan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Activity -->
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-newspaper text-primary me-2"></i>Berita Terbaru</h5>
                    </div>
                    <div class="card-body">
                        <?php
                        $recent_berita = fetchAll("SELECT * FROM berita ORDER BY created_at DESC LIMIT 5");
                        if ($recent_berita):
                            foreach ($recent_berita as $berita):
                        ?>
                            <div class="recent-item d-flex align-items-center mb-3 pb-3 border-bottom">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">
                                        <a href="berita.php?action=edit&id=<?php echo $berita['id']; ?>" class="text-decoration-none text-dark">
                                            <?php echo htmlspecialchars($berita['judul']); ?>
                                        </a>
                                    </h6>
                                    <small class="text-muted">
                                        <i class="far fa-calendar-alt me-1"></i>
                                        <?php echo date('d F Y', strtotime($berita['tanggal'])); ?>
                                    </small>
                                </div>
                                <a href="berita.php?action=edit&id=<?php echo $berita['id']; ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        <?php 
                            endforeach;
                        else:
                        ?>
                            <p class="text-muted text-center">Belum ada berita</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-images text-success me-2"></i>Galeri Terbaru</h5>
                    </div>
                    <div class="card-body">
                        <?php
                        $recent_galeri = fetchAll("SELECT * FROM galeri ORDER BY created_at DESC LIMIT 5");
                        if ($recent_galeri):
                            foreach ($recent_galeri as $item):
                        ?>
                            <div class="recent-item d-flex align-items-center mb-3 pb-3 border-bottom">
                                <?php if ($item['gambar']): ?>
                                    <img src="../uploads/galeri/<?php echo htmlspecialchars($item['gambar']); ?>" 
                                         alt="" class="rounded me-3" width="50" height="50" style="object-fit: cover;">
                                <?php else: ?>
                                    <div class="bg-light rounded me-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1"><?php echo htmlspecialchars($item['judul']); ?></h6>
                                    <small class="text-muted">
                                        <i class="far fa-calendar-alt me-1"></i>
                                        <?php echo date('d F Y', strtotime($item['tanggal'])); ?>
                                    </small>
                                </div>
                            </div>
                        <?php 
                            endforeach;
                        else:
                        ?>
                            <p class="text-muted text-center">Belum ada galeri</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>