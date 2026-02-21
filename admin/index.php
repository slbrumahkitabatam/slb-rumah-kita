<?php
require_once '../config/database.php';
require_once 'auth.php';

// Get statistics
$total_berita = fetchOne("SELECT COUNT(*) as total FROM berita")['total'];
$total_galeri = fetchOne("SELECT COUNT(*) as total FROM galeri")['total'];
$total_guru = fetchOne("SELECT COUNT(*) as total FROM guru WHERE aktif = 1")['total'];
$total_halaman = fetchOne("SELECT COUNT(*) as total FROM halaman WHERE aktif = 1")['total'];
$total_users = fetchOne("SELECT COUNT(*) as total FROM users")['total'];

// Get gallery by category
$gallery_by_category = fetchAll("SELECT kategori, COUNT(*) as total FROM galeri GROUP BY kategori");
$gallery_kategori = [];
$gallery_kategori_count = [];
foreach ($gallery_by_category as $cat) {
    $gallery_kategori[] = ucfirst($cat['kategori']);
    $gallery_kategori_count[] = $cat['total'];
}

// Get news by month
$news_by_month = fetchAll("SELECT DATE_FORMAT(tanggal, '%M %Y') as bulan, COUNT(*) as total FROM berita GROUP BY DATE_FORMAT(tanggal, '%Y-%m') ORDER BY tanggal DESC LIMIT 6");
$news_months = array_reverse(array_column($news_by_month, 'bulan'));
$news_count = array_reverse(array_column($news_by_month, 'total'));

// Get latest activities
$latest_activities = [];
$latest_berita = fetchAll("SELECT id, judul, 'berita' as type, created_at FROM berita ORDER BY created_at DESC LIMIT 3");
$latest_galeri = fetchAll("SELECT id, judul, 'galeri' as type, created_at FROM galeri ORDER BY created_at DESC LIMIT 3");
foreach ($latest_berita as $item) {
    $latest_activities[] = $item;
}
foreach ($latest_galeri as $item) {
    $latest_activities[] = $item;
}
usort($latest_activities, function($a, $b) {
    return strtotime($b['created_at']) - strtotime($a['created_at']);
});
$latest_activities = array_slice($latest_activities, 0, 5);

// Get most viewed/read (simulated by recent)
$popular_news = fetchAll("SELECT * FROM berita ORDER BY created_at DESC LIMIT 5");

// Get active teachers count by position
$guru_by_jabatan = fetchAll("SELECT jabatan, COUNT(*) as total FROM guru WHERE aktif = 1 GROUP BY jabatan");

$active_menu = 'dashboard';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SLB Rumah Kita Batam – Admin Dashboard</title>
    <link rel="shortcut icon" href="../gambar/icon.jpg">
    <link rel="icon" href="../gambar/icon.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #4A90E2;
            --secondary-color: #6C63FF;
            --success-color: #00C853;
            --warning-color: #FFAB00;
            --danger-color: #FF3D00;
            --info-color: #00B0FF;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        
        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .welcome-banner {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 30px;
            color: white;
            margin-bottom: 30px;
            box-shadow: 0 10px 40px rgba(102, 126, 234, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .welcome-banner::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }
        
        .welcome-banner::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }
        
        .stat-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background: white;
            position: relative;
            overflow: hidden;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }
        
        .stat-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }
        
        .stat-icon {
            width: 70px;
            height: 70px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            position: relative;
        }
        
        .stat-icon::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 18px;
            background: currentColor;
            opacity: 0.1;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.1; }
            50% { transform: scale(1.1); opacity: 0.2; }
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .stat-label {
            color: #6B7280;
            font-size: 0.9rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .stat-trend {
            font-size: 0.85rem;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 600;
        }
        
        .stat-trend.positive {
            background: rgba(0, 200, 83, 0.1);
            color: var(--success-color);
        }
        
        .stat-trend.negative {
            background: rgba(255, 61, 0, 0.1);
            color: var(--danger-color);
        }
        
        .content-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            background: white;
            margin-bottom: 30px;
        }
        
        .card-header-custom {
            background: white;
            border-bottom: 2px solid #f0f0f0;
            padding: 25px;
            border-radius: 20px 20px 0 0;
        }
        
        .card-header-custom h5 {
            font-weight: 600;
            color: #1F2937;
            margin: 0;
        }
        
        .chart-container {
            padding: 25px;
            height: 350px;
        }
        
        .activity-item {
            padding: 15px;
            border-left: 3px solid transparent;
            transition: all 0.3s;
            margin-bottom: 10px;
            background: #f9fafb;
            border-radius: 10px;
        }
        
        .activity-item:hover {
            background: #f0f9ff;
            border-left-color: var(--primary-color);
            transform: translateX(5px);
        }
        
        .activity-icon {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            margin-right: 15px;
        }
        
        .badge-custom {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .badge-berita {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }
        
        .badge-galeri {
            background: linear-gradient(135deg, #00C853, #00E676);
            color: white;
        }
        
        .recent-image {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            object-fit: cover;
            border: 3px solid #f0f0f0;
        }
        
        .quick-action-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            display: block;
        }
        
        .quick-action-card:hover {
            transform: translateY(-10px) scale(1.05);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }
        
        .quick-action-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 1.8rem;
            color: white;
        }
        
        .quick-action-icon i,
        .quick-action-icon span {
            color: white !important;
            font-size: 1.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Fallback for icons */
        .quick-action-icon i::before {
            display: inline-block;
            speak: none;
            text-transform: none;
            line-height: 1;
            -webkit-font-smoothing: antialiased;
        }
        
        .quick-action-card.btn-primary .quick-action-icon {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }
        
        .quick-action-card.btn-success .quick-action-icon {
            background: linear-gradient(135deg, #00C853, #00E676);
        }
        
        .quick-action-card.btn-info .quick-action-icon {
            background: linear-gradient(135deg, #00B0FF, #40C4FF);
        }
        
        .quick-action-card.btn-warning .quick-action-icon {
            background: linear-gradient(135deg, #FFAB00, #FFCA28);
        }
        
        .progress-custom {
            height: 8px;
            border-radius: 10px;
            background: #f0f0f0;
            overflow: hidden;
        }
        
        .progress-bar-custom {
            height: 100%;
            border-radius: 10px;
            transition: width 1s ease-in-out;
        }
        
        .teacher-item {
            padding: 15px;
            background: #f9fafb;
            border-radius: 12px;
            margin-bottom: 10px;
            transition: all 0.3s;
        }
        
        .teacher-item:hover {
            background: #f0f9ff;
            transform: translateX(5px);
        }
        
        .teacher-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .scrollbar-custom::-webkit-scrollbar {
            width: 6px;
        }
        
        .scrollbar-custom::-webkit-scrollbar-track {
            background: #f0f0f0;
            border-radius: 10px;
        }
        
        .scrollbar-custom::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 10px;
        }
        
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            
            .stat-card {
                margin-bottom: 20px;
            }
            
            .stat-number {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <?php require_once 'includes/sidebar.php'; ?>
    
    <!-- Main Content -->
    <div class="main-content dashboard-container">
        <!-- Welcome Banner -->
        <div class="welcome-banner">
            <div class="row align-items-center position-relative" style="z-index: 1;">
                <div class="col-md-8">
                    <h1 class="fw-bold mb-2">Selamat Datang, <?php echo htmlspecialchars($_SESSION['nama']); ?>! 👋</h1>
                    <p class="mb-0 opacity-75">Dashboard Overview - <?php echo date('d F Y'); ?></p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="d-inline-flex align-items-center bg-white bg-opacity-20 rounded-pill px-4 py-2">
                        <i class="fas fa-user-circle me-2 fs-4"></i>
                        <span class="fw-semibold" style="color: #000000;"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="stat-card card h-100 p-4">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <p class="stat-label mb-1">Total Berita</p>
                            <h3 class="stat-number mb-2"><?php echo $total_berita; ?></h3>
                            <span class="stat-trend positive">
                                <i class="fas fa-arrow-up me-1"></i>Aktif
                            </span>
                        </div>
                        <div class="stat-icon text-primary">
                            <i class="fas fa-newspaper position-relative"></i>
                        </div>
                    </div>
                    <div class="progress-custom mt-3">
                        <div class="progress-bar-custom bg-gradient-primary" style="width: 85%; background: linear-gradient(90deg, #667eea, #764ba2);"></div>
                    </div>
                    <small class="text-muted mt-2 d-block">85% dari target bulanan</small>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="stat-card card h-100 p-4">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <p class="stat-label mb-1">Total Galeri</p>
                            <h3 class="stat-number mb-2"><?php echo $total_galeri; ?></h3>
                            <span class="stat-trend positive">
                                <i class="fas fa-arrow-up me-1"></i>+12% bulan ini
                            </span>
                        </div>
                        <div class="stat-icon text-success">
                            <i class="fas fa-images position-relative"></i>
                        </div>
                    </div>
                    <div class="progress-custom mt-3">
                        <div class="progress-bar-custom" style="width: 92%; background: linear-gradient(90deg, #00C853, #00E676);"></div>
                    </div>
                    <small class="text-muted mt-2 d-block">92% dari target bulanan</small>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="stat-card card h-100 p-4">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <p class="stat-label mb-1">Guru Aktif</p>
                            <h3 class="stat-number mb-2"><?php echo $total_guru; ?></h3>
                            <span class="stat-trend positive">
                                <i class="fas fa-check-circle me-1"></i>100% aktif
                            </span>
                        </div>
                        <div class="stat-icon text-info">
                            <i class="fas fa-chalkboard-teacher position-relative"></i>
                        </div>
                    </div>
                    <div class="progress-custom mt-3">
                        <div class="progress-bar-custom" style="width: 100%; background: linear-gradient(90deg, #00B0FF, #40C4FF);"></div>
                    </div>
                    <small class="text-muted mt-2 d-block">Semua guru aktif mengajar</small>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="stat-card card h-100 p-4">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <p class="stat-label mb-1">Halaman & User</p>
                            <h3 class="stat-number mb-2"><?php echo $total_halaman; ?> / <?php echo $total_users; ?></h3>
                            <span class="stat-trend positive">
                                <i class="fas fa-check-double me-1"></i>Sistem OK
                            </span>
                        </div>
                        <div class="stat-icon text-warning">
                            <i class="fas fa-layer-group position-relative"></i>
                        </div>
                    </div>
                    <div class="progress-custom mt-3">
                        <div class="progress-bar-custom" style="width: 88%; background: linear-gradient(90deg, #FFAB00, #FFCA28);"></div>
                    </div>
                    <small class="text-muted mt-2 d-block">88% konten terisi</small>
                </div>
            </div>
        </div>
        
        <!-- Charts Section -->
        <div class="row mb-4">
            <div class="col-lg-8 mb-4">
                <div class="content-card">
                    <div class="card-header-custom d-flex justify-content-between align-items-center">
                        <h5><i class="fas fa-chart-line text-primary me-2"></i>Statistik Berita per Bulan</h5>
                        <select class="form-select form-select-sm" style="width: auto;">
                            <option>6 Bulan Terakhir</option>
                            <option>1 Tahun</option>
                            <option>Semua</option>
                        </select>
                    </div>
                    <div class="chart-container">
                        <canvas id="newsChart"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 mb-4">
                <div class="content-card">
                    <div class="card-header-custom">
                        <h5><i class="fas fa-chart-pie text-success me-2"></i>Distribusi Galeri</h5>
                    </div>
                    <div class="chart-container">
                        <canvas id="galleryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="content-card">
                    <div class="card-header-custom">
                        <h5><i class="fas fa-bolt text-warning me-2"></i>Aksi Cepat</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-xl-3 col-md-6 mb-3">
                                <a href="berita.php?action=tambah" class="quick-action-card btn-primary">
                                    <div class="quick-action-icon">
                                        <i class="fas fa-plus-circle"></i>
                                    </div>
                                    <h6 class="fw-bold mb-1">Tambah Berita</h6>
                                    <p class="text-muted small mb-0">Buat berita baru</p>
                                </a>
                            </div>
                            <div class="col-xl-3 col-md-6 mb-3">
                                <a href="galeri.php?action=tambah" class="quick-action-card btn-success">
                                    <div class="quick-action-icon">
                                        <i class="fas fa-image"></i>
                                    </div>
                                    <h6 class="fw-bold mb-1">Upload Galeri</h6>
                                    <p class="text-muted small mb-0">Tambah foto/video</p>
                                </a>
                            </div>
                            <div class="col-xl-3 col-md-6 mb-3">
                                <a href="guru.php" class="quick-action-card btn-info">
                                    <div class="quick-action-icon">
                                        <i class="fas fa-users-cog"></i>
                                    </div>
                                    <h6 class="fw-bold mb-1">Kelola Guru</h6>
                                    <p class="text-muted small mb-0">Tambah/edit guru</p>
                                </a>
                            </div>
                            <div class="col-xl-3 col-md-6 mb-3">
                                <a href="pengaturan.php" class="quick-action-card btn-warning">
                                    <div class="quick-action-icon">
                                        <i class="fas fa-cogs"></i>
                                    </div>
                                    <h6 class="fw-bold mb-1">Pengaturan</h6>
                                    <p class="text-muted small mb-0">Konfigurasi sistem</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Activity & Teachers -->
        <div class="row mb-4">
            <div class="col-lg-6 mb-4">
                <div class="content-card h-100">
                    <div class="card-header-custom d-flex justify-content-between align-items-center">
                        <h5><i class="fas fa-history text-primary me-2"></i>Aktivitas Terbaru</h5>
                        <a href="#" class="text-primary text-decoration-none small">Lihat Semua</a>
                    </div>
                    <div class="card-body p-3 scrollbar-custom" style="max-height: 450px; overflow-y: auto;">
                        <?php if ($latest_activities): ?>
                            <?php foreach ($latest_activities as $activity): ?>
                                <div class="activity-item d-flex align-items-center">
                                    <div class="activity-icon <?php echo $activity['type'] == 'berita' ? 'bg-primary bg-opacity-10 text-primary' : 'bg-success bg-opacity-10 text-success'; ?>">
                                        <i class="fas <?php echo $activity['type'] == 'berita' ? 'fa-newspaper' : 'fa-images'; ?>"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 fw-semibold"><?php echo htmlspecialchars($activity['judul']); ?></h6>
                                        <div class="d-flex align-items-center">
                                            <span class="badge-custom badge-<?php echo $activity['type']; ?> me-2">
                                                <?php echo ucfirst($activity['type']); ?>
                                            </span>
                                            <small class="text-muted">
                                                <i class="far fa-clock me-1"></i>
                                                <?php echo date('d M Y H:i', strtotime($activity['created_at'])); ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted text-center py-5">
                                <i class="fas fa-inbox fa-3x mb-3 d-block opacity-25"></i>
                                Belum ada aktivitas
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 mb-4">
                <div class="content-card h-100">
                    <div class="card-header-custom d-flex justify-content-between align-items-center">
                        <h5><i class="fas fa-users text-info me-2"></i>Guru Aktif</h5>
                        <a href="guru.php" class="text-primary text-decoration-none small">Kelola Guru</a>
                    </div>
                    <div class="card-body p-3 scrollbar-custom" style="max-height: 450px; overflow-y: auto;">
                        <?php
                        $teachers = fetchAll("SELECT * FROM guru WHERE aktif = 1 ORDER BY urutan ASC LIMIT 8");
                        if ($teachers):
                            foreach ($teachers as $teacher):
                        ?>
                            <div class="teacher-item d-flex align-items-center">
                                <?php if ($teacher['foto']): ?>
                                    <img src="../uploads/guru/<?php echo htmlspecialchars($teacher['foto']); ?>" 
                                         alt="<?php echo htmlspecialchars($teacher['nama']); ?>" 
                                         class="teacher-avatar">
                                <?php else: ?>
                                    <div class="teacher-avatar bg-gradient-primary d-flex align-items-center justify-content-center text-white fw-bold">
                                        <?php echo strtoupper(substr($teacher['nama'], 0, 1)); ?>
                                    </div>
                                <?php endif; ?>
                                <div class="ms-3 flex-grow-1">
                                    <h6 class="mb-1 fw-semibold"><?php echo htmlspecialchars($teacher['nama']); ?></h6>
                                    <p class="mb-0 text-muted small"><?php echo htmlspecialchars($teacher['jabatan']); ?></p>
                                </div>
                                <span class="badge bg-success bg-opacity-10 text-success">
                                    <i class="fas fa-circle me-1" style="font-size: 8px;"></i>Aktif
                                </span>
                            </div>
                        <?php 
                            endforeach;
                        else:
                        ?>
                            <p class="text-muted text-center py-5">
                                <i class="fas fa-user-slash fa-3x mb-3 d-block opacity-25"></i>
                                Belum ada guru aktif
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent News & Gallery -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="content-card h-100">
                    <div class="card-header-custom d-flex justify-content-between align-items-center">
                        <h5><i class="fas fa-newspaper text-primary me-2"></i>Berita Terbaru</h5>
                        <a href="berita.php" class="text-primary text-decoration-none small">Kelola Berita</a>
                    </div>
                    <div class="card-body p-3 scrollbar-custom" style="max-height: 400px; overflow-y: auto;">
                        <?php if ($popular_news): ?>
                            <?php foreach ($popular_news as $berita): ?>
                                <div class="activity-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-2 fw-semibold">
                                                <a href="berita.php?action=edit&id=<?php echo $berita['id']; ?>" 
                                                   class="text-decoration-none text-dark">
                                                    <?php echo htmlspecialchars($berita['judul']); ?>
                                                </a>
                                            </h6>
                                            <div class="d-flex align-items-center">
                                                <span class="text-muted small me-3">
                                                    <i class="far fa-user me-1"></i>
                                                    <?php echo htmlspecialchars($berita['penulis']); ?>
                                                </span>
                                                <span class="text-muted small">
                                                    <i class="far fa-calendar me-1"></i>
                                                    <?php echo date('d M Y', strtotime($berita['tanggal'])); ?>
                                                </span>
                                            </div>
                                        </div>
                                        <a href="berita.php?action=edit&id=<?php echo $berita['id']; ?>" 
                                           class="btn btn-sm btn-outline-primary ms-2">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted text-center py-5">
                                <i class="fas fa-newspaper fa-3x mb-3 d-block opacity-25"></i>
                                Belum ada berita
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 mb-4">
                <div class="content-card h-100">
                    <div class="card-header-custom d-flex justify-content-between align-items-center">
                        <h5><i class="fas fa-images text-success me-2"></i>Galeri Terbaru</h5>
                        <a href="galeri.php" class="text-primary text-decoration-none small">Kelola Galeri</a>
                    </div>
                    <div class="card-body p-3 scrollbar-custom" style="max-height: 400px; overflow-y: auto;">
                        <?php
                        $recent_galeri = fetchAll("SELECT * FROM galeri ORDER BY created_at DESC LIMIT 6");
                        if ($recent_galeri):
                            foreach ($recent_galeri as $item):
                        ?>
                            <div class="activity-item d-flex align-items-center">
                                <?php if ($item['gambar']): ?>
                                    <img src="../uploads/galeri/<?php echo htmlspecialchars($item['gambar']); ?>" 
                                         alt="<?php echo htmlspecialchars($item['judul']); ?>" 
                                         class="recent-image">
                                <?php else: ?>
                                    <div class="recent-image bg-light d-flex align-items-center justify-content-center">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="ms-3 flex-grow-1">
                                    <h6 class="mb-1 fw-semibold"><?php echo htmlspecialchars($item['judul']); ?></h6>
                                    <div class="d-flex align-items-center">
                                        <span class="badge badge-custom text-white me-2" style="background: linear-gradient(135deg, #00C853, #00E676);">
                                            <?php echo ucfirst($item['kategori']); ?>
                                        </span>
                                        <span class="text-muted small">
                                            <?php echo date('d M Y', strtotime($item['tanggal'])); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php 
                            endforeach;
                        else:
                        ?>
                            <p class="text-muted text-center py-5">
                                <i class="fas fa-images fa-3x mb-3 d-block opacity-25"></i>
                                Belum ada galeri
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // News Chart
        const newsCtx = document.getElementById('newsChart').getContext('2d');
        new Chart(newsCtx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($news_months); ?>,
                datasets: [{
                    label: 'Jumlah Berita',
                    data: <?php echo json_encode($news_count); ?>,
                    borderColor: '#667eea',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#667eea',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
        
        // Gallery Chart
        const galleryCtx = document.getElementById('galleryChart').getContext('2d');
        new Chart(galleryCtx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($gallery_kategori); ?>,
                datasets: [{
                    data: <?php echo json_encode($gallery_kategori_count); ?>,
                    backgroundColor: [
                        '#667eea',
                        '#00C853',
                        '#FFAB00',
                        '#FF3D00',
                        '#00B0FF'
                    ],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    }
                },
                cutout: '70%'
            }
        });
    </script>
</body>
</html>
