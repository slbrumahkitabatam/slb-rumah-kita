<?php
session_start();
require_once '../config/database.php';
require_once 'auth.php';

// Get statistics
$total_berita = fetchOne("SELECT COUNT(*) as total FROM berita")['total'];
$total_galeri = fetchOne("SELECT COUNT(*) as total FROM galeri")['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin Panel</title>
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
        .main-content {
            padding: 30px;
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
                    <a class="nav-link active" href="index.php">
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
                        <h2 class="fw-bold mb-0">Dashboard</h2>
                        <p class="text-muted mb-0">Selamat datang, <?php echo htmlspecialchars($_SESSION['nama']); ?>!</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-primary me-2">
                            <i class="fas fa-user me-1"></i>
                            <?php echo htmlspecialchars($_SESSION['username']); ?>
                        </span>
                    </div>
                </div>
                
                <!-- Statistics -->
                <div class="row mb-4">
                    <div class="col-md-4 mb-4">
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
                    <div class="col-md-4 mb-4">
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
                    <div class="col-md-4 mb-4">
                        <div class="stat-card card h-100 p-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="text-muted mb-1">Admin Aktif</h6>
                                    <h2 class="fw-bold mb-0">1</h2>
                                </div>
                                <div class="stat-icon bg-info bg-opacity-10 text-info">
                                    <i class="fas fa-user-shield"></i>
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
                                        <a href="berita.php?action=tambah" class="btn btn-primary w-100 py-3">
                                            <i class="fas fa-plus-circle fa-2x mb-2 d-block"></i>
                                            Tambah Berita
                                        </a>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <a href="galeri.php?action=tambah" class="btn btn-success w-100 py-3">
                                            <i class="fas fa-upload fa-2x mb-2 d-block"></i>
                                            Upload Galeri
                                        </a>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <a href="profil.php" class="btn btn-info w-100 py-3">
                                            <i class="fas fa-edit fa-2x mb-2 d-block"></i>
                                            Edit Profil
                                        </a>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <a href="pengaturan.php" class="btn btn-warning w-100 py-3">
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
                                    <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
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
                                    <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
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
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>