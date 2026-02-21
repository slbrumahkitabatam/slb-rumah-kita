<?php
$pageTitle = 'Galeri Kegiatan';
require_once 'includes/header.php';

// Default gallery image
$defaultGalleryImage = 'gambar/galerydefault.jpg';

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 9;
$offset = ($page - 1) * $perPage;

// Filter kategori
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';

// Ambil total galeri
if ($kategori) {
    $total_galeri = fetchOne("SELECT COUNT(*) as total FROM galeri WHERE kategori = '$kategori'");
} else {
    $total_galeri = fetchOne("SELECT COUNT(*) as total FROM galeri");
}
$totalPages = ceil($total_galeri['total'] / $perPage);

// Ambil galeri dengan pagination
if ($kategori) {
    $galeri = fetchAll("SELECT * FROM galeri WHERE kategori = '$kategori' ORDER BY tanggal DESC LIMIT $offset, $perPage");
} else {
    $galeri = fetchAll("SELECT * FROM galeri ORDER BY tanggal DESC LIMIT $offset, $perPage");
}

// Definisi kategori dengan icon dan warna
$kategoriInfo = [
    'kbm' => ['nama' => 'Kegiatan Belajar', 'icon' => 'fa-book-open', 'color' => '#667eea', 'gradient' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)'],
    'eskul' => ['nama' => 'Ekstrakurikuler', 'icon' => 'fa-running', 'color' => '#f093fb', 'gradient' => 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)'],
    'prestasi' => ['nama' => 'Prestasi Siswa', 'icon' => 'fa-award', 'color' => '#ff9a9e', 'gradient' => 'linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%)'],
    'kegiatan' => ['nama' => 'Kegiatan Sekolah', 'icon' => 'fa-calendar-check', 'color' => '#a18cd1', 'gradient' => 'linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%)'],
    'fasilitas' => ['nama' => 'Fasilitas', 'icon' => 'fa-school', 'color' => '#48c6ef', 'gradient' => 'linear-gradient(135deg, #48c6ef 0%, #6f86d6 100%)']
];
?>

<!-- Elegant Header Section -->
<section class="elegant-header-section position-relative overflow-hidden">
    <div class="container position-relative">
        <div class="row align-items-center py-5">
            <div class="col-lg-8">
                <div class="header-badge mb-4">
                    <span class="badge bg-light text-primary">
                        <i class="fas fa-images me-2"></i>Galeri Kegiatan
                    </span>
                </div>
                <h1 class="fw-bold mb-4 text-white animate-title">
                    Galeri Foto & Video
                </h1>
                <p class="lead text-white-50 mb-4 animate-subtitle">
                    Dokumentasi aktivitas dan kegiatan siswa SLB Rumah Kita Batam
                </p>
                <div class="header-features mt-4">
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <div class="feature-item" role="button" tabindex="0" onclick="handleFeatureClick(this)" onkeypress="handleFeatureKeypress(event, this)">
                            <i class="fas fa-check-circle text-success"></i>
                            <span class="text-white">Dokumentasi Lengkap</span>
                        </div>
                        <div class="feature-item" role="button" tabindex="0" onclick="handleFeatureClick(this)" onkeypress="handleFeatureKeypress(event, this)">
                            <i class="fas fa-check-circle text-success"></i>
                            <span class="text-white">Kategori Beragam</span>
                        </div>
                        <div class="feature-item" role="button" tabindex="0" onclick="handleFeatureClick(this)" onkeypress="handleFeatureKeypress(event, this)">
                            <i class="fas fa-check-circle text-success"></i>
                            <span class="text-white">Kualitas Terjamin</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-center d-none d-lg-block">
                <div class="header-icon-container">
                    <div class="icon-circle-main">
                        <i class="fas fa-images"></i>
                    </div>
                    <div class="floating-icon icon-1">
                        <i class="fas fa-camera"></i>
                    </div>
                    <div class="floating-icon icon-2">
                        <i class="fas fa-video"></i>
                    </div>
                    <div class="floating-icon icon-3">
                        <i class="fas fa-folder-open"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Decorative Elements -->
    <div class="decorative-shape shape-1"></div>
    <div class="decorative-shape shape-2"></div>
    <div class="decorative-shape shape-3"></div>
</section>

<!-- Kategori Filter -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-3" style="color: #667eea;">Jelajahi Galeri</h2>
            <p class="text-muted">Pilih kategori untuk melihat koleksi foto kami</p>
        </div>
        
        <div class="row g-4 justify-content-center">
            <div class="col-6 col-md-4 col-lg-2">
                <a href="galeri.php?kategori=kbm" class="text-decoration-none">
                    <div class="category-card text-center py-4 px-3 rounded-3 h-100 <?php echo $kategori == 'kbm' ? 'active' : ''; ?>" style="background: <?php echo $kategori == 'kbm' ? 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)' : '#ffffff'; ?>;">
                        <div class="category-icon mb-3">
                            <i class="fas fa-book-open fa-2x"></i>
                        </div>
                        <h6 class="mb-0 fw-bold">Kegiatan Belajar</h6>
                        <small class="<?php echo $kategori == 'kbm' ? 'text-white-75' : 'text-muted'; ?> mt-2 d-block">5 Galeri</small>
                    </div>
                </a>
            </div>
            
            <div class="col-6 col-md-4 col-lg-2">
                <a href="galeri.php?kategori=eskul" class="text-decoration-none">
                    <div class="category-card text-center py-4 px-3 rounded-3 h-100 <?php echo $kategori == 'eskul' ? 'active' : ''; ?>" style="background: <?php echo $kategori == 'eskul' ? 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)' : '#ffffff'; ?>;">
                        <div class="category-icon mb-3">
                            <i class="fas fa-running fa-2x"></i>
                        </div>
                        <h6 class="mb-0 fw-bold">Ekstrakurikuler</h6>
                        <small class="<?php echo $kategori == 'eskul' ? 'text-white-75' : 'text-muted'; ?> mt-2 d-block">5 Galeri</small>
                    </div>
                </a>
            </div>
            
            <div class="col-6 col-md-4 col-lg-2">
                <a href="galeri.php?kategori=prestasi" class="text-decoration-none">
                    <div class="category-card text-center py-4 px-3 rounded-3 h-100 <?php echo $kategori == 'prestasi' ? 'active' : ''; ?>" style="background: <?php echo $kategori == 'prestasi' ? 'linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%)' : '#ffffff'; ?>;">
                        <div class="category-icon mb-3">
                            <i class="fas fa-award fa-2x"></i>
                        </div>
                        <h6 class="mb-0 fw-bold">Prestasi Siswa</h6>
                        <small class="<?php echo $kategori == 'prestasi' ? 'text-white-75' : 'text-muted'; ?> mt-2 d-block">5 Galeri</small>
                    </div>
                </a>
            </div>
            
            <div class="col-6 col-md-4 col-lg-2">
                <a href="galeri.php?kategori=kegiatan" class="text-decoration-none">
                    <div class="category-card text-center py-4 px-3 rounded-3 h-100 <?php echo $kategori == 'kegiatan' ? 'active' : ''; ?>" style="background: <?php echo $kategori == 'kegiatan' ? 'linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%)' : '#ffffff'; ?>;">
                        <div class="category-icon mb-3">
                            <i class="fas fa-calendar-check fa-2x"></i>
                        </div>
                        <h6 class="mb-0 fw-bold">Kegiatan Sekolah</h6>
                        <small class="<?php echo $kategori == 'kegiatan' ? 'text-white-75' : 'text-muted'; ?> mt-2 d-block">5 Galeri</small>
                    </div>
                </a>
            </div>
            
            <div class="col-6 col-md-4 col-lg-2">
                <a href="galeri.php?kategori=fasilitas" class="text-decoration-none">
                    <div class="category-card text-center py-4 px-3 rounded-3 h-100 <?php echo $kategori == 'fasilitas' ? 'active' : ''; ?>" style="background: <?php echo $kategori == 'fasilitas' ? 'linear-gradient(135deg, #48c6ef 0%, #6f86d6 100%)' : '#ffffff'; ?>;">
                        <div class="category-icon mb-3">
                            <i class="fas fa-school fa-2x"></i>
                        </div>
                        <h6 class="mb-0 fw-bold">Fasilitas</h6>
                        <small class="<?php echo $kategori == 'fasilitas' ? 'text-white-75' : 'text-muted'; ?> mt-2 d-block">5 Galeri</small>
                    </div>
                </a>
            </div>
            
            <div class="col-6 col-md-4 col-lg-2">
                <a href="galeri.php" class="text-decoration-none">
                    <div class="category-card text-center py-4 px-3 rounded-3 h-100 <?php echo !$kategori ? 'active' : ''; ?>" style="background: <?php echo !$kategori ? 'linear-gradient(135deg, #11998e 0%, #38ef7d 100%)' : '#ffffff'; ?>;">
                        <div class="category-icon mb-3">
                            <i class="fas fa-th fa-2x"></i>
                        </div>
                        <h6 class="mb-0 fw-bold">Semua</h6>
                        <small class="<?php echo !$kategori ? 'text-white-75' : 'text-muted'; ?> mt-2 d-block"><?php echo $total_galeri['total']; ?> Galeri</small>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Judul Kategori Aktif -->
<?php if ($kategori && isset($kategoriInfo[$kategori])): ?>
<section class="py-4 text-center">
    <div class="container">
        <h2 class="fw-bold mb-2">
            <i class="fas <?php echo $kategoriInfo[$kategori]['icon']; ?> me-3"></i>
            <?php echo $kategoriInfo[$kategori]['nama']; ?>
        </h2>
        <p class="text-muted mb-0">
            Menampilkan <?php echo count($galeri); ?> dari <?php echo $total_galeri['total']; ?> galeri
        </p>
    </div>
</section>
<?php endif; ?>

<!-- Galeri Grid -->
<section class="py-5">
    <div class="container">
        <?php if ($galeri): ?>
            <div class="row g-4">
                <?php foreach ($galeri as $item): ?>
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="gallery-card card border-0 h-100 shadow-sm">
                            <div class="position-relative overflow-hidden rounded-top">
                                <?php 
                                $imagePath = 'uploads/galeri/' . $item['gambar'];
                                $fileExists = $item['gambar'] && file_exists($imagePath);
                                
                                if ($fileExists): ?>
                                    <img src="<?php echo htmlspecialchars($imagePath); ?>" 
                                         alt="<?php echo htmlspecialchars($item['judul']); ?>" 
                                         class="card-img-top gallery-image" style="height: 280px; object-fit: cover;">
                                <?php else: ?>
                                    <img src="<?php echo $defaultGalleryImage; ?>" 
                                         alt="<?php echo htmlspecialchars($item['judul']); ?>" 
                                         class="card-img-top gallery-image" style="height: 280px; object-fit: cover;">
                                <?php endif; ?>
                                
                                <!-- Badge Kategori -->
                                <?php if (isset($item['kategori']) && isset($kategoriInfo[$item['kategori']])): ?>
                                    <div class="position-absolute top-0 start-0 m-3">
                                        <span class="badge rounded-pill px-3 py-2 shadow" style="background: <?php echo $kategoriInfo[$item['kategori']]['gradient']; ?>;">
                                            <i class="fas <?php echo $kategoriInfo[$item['kategori']]['icon']; ?> me-1"></i>
                                            <?php echo $kategoriInfo[$item['kategori']]['nama']; ?>
                                        </span>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Overlay -->
                                <div class="gallery-overlay position-absolute bottom-0 start-0 end-0 p-4">
                                    <h5 class="fw-bold mb-2 text-white"><?php echo htmlspecialchars($item['judul']); ?></h5>
                                    <p class="text-white-75 mb-2 small">
                                        <i class="far fa-calendar-alt me-1"></i>
                                        <?php echo date('d F Y', strtotime($item['tanggal'])); ?>
                                    </p>
                                    <?php if ($item['deskripsi']): ?>
                                        <p class="text-white-90 mb-3 small"><?php echo htmlspecialchars(substr($item['deskripsi'], 0, 100)); ?>...</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title fw-bold mb-2"><?php echo htmlspecialchars($item['judul']); ?></h5>
                                <p class="card-text text-muted small mb-0">
                                    <i class="far fa-calendar-alt me-1"></i>
                                    <?php echo date('d F Y', strtotime($item['tanggal'])); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
            <nav aria-label="Page navigation" class="mt-5">
                <ul class="pagination justify-content-center pagination-lg">
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $page - 1; ?><?php echo $kategori ? '&kategori='.$kategori : ''; ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo; Sebelumnya</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <?php 
                    $startPage = max(1, $page - 2);
                    $endPage = min($totalPages, $page + 2);
                    
                    if ($startPage > 1) {
                        echo '<li class="page-item"><a class="page-link" href="?page=1' . ($kategori ? '&kategori='.$kategori : '') . '">1</a></li>';
                        if ($startPage > 2) echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                    }
                    
                    for ($i = $startPage; $i <= $endPage; $i++): ?>
                        <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?><?php echo $kategori ? '&kategori='.$kategori : ''; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor;
                    
                    if ($endPage < $totalPages) {
                        if ($endPage < $totalPages - 1) echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                        echo '<li class="page-item"><a class="page-link" href="?page=' . $totalPages . ($kategori ? '&kategori='.$kategori : '') . '">' . $totalPages . '</a></li>';
                    }
                    ?>
                    
                    <?php if ($page < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $page + 1; ?><?php echo $kategori ? '&kategori='.$kategori : ''; ?>" aria-label="Next">
                                <span aria-hidden="true">Selanjutnya &raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
            <?php endif; ?>
            
        <?php else: ?>
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-images fa-5x text-muted opacity-50"></i>
                </div>
                <h3 class="fw-bold text-muted mb-3">Belum Ada Galeri</h3>
                <p class="text-muted mb-4">Belum ada foto galeri yang tersedia di kategori ini.</p>
                <?php if ($kategori): ?>
                    <a href="galeri.php" class="btn btn-primary btn-lg rounded-pill px-5">
                        <i class="fas fa-arrow-left me-2"></i>Lihat Semua Galeri
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="fw-bold mb-3" style="color: #667eea;">Tertarik dengan Sekolah Kami?</h2>
                <p class="text-muted mb-4">Jangan ragu untuk menghubungi kami atau berkunjung langsung ke sekolah untuk informasi lebih lanjut.</p>
                <a href="kontak.php" class="btn btn-primary btn-lg rounded-pill px-5">
                    <i class="fas fa-envelope me-2"></i>Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</section>

<style>
/* Elegant Header Section */
.elegant-header-section {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    min-height: 400px;
    position: relative;
}

.elegant-header-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

.header-badge .badge {
    padding: 10px 20px;
    font-size: 0.9rem;
    font-weight: 600;
    border-radius: 30px;
    backdrop-filter: blur(10px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.animate-title {
    font-size: 3rem;
    font-weight: 800;
    letter-spacing: -0.5px;
    text-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    animation: fadeInUp 0.8s ease-out;
}

.animate-subtitle {
    font-size: 1.25rem;
    font-weight: 300;
    letter-spacing: 0.5px;
    animation: fadeInUp 0.8s ease-out 0.2s both;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.header-features {
    animation: fadeInUp 0.8s ease-out 0.4s both;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 25px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    user-select: none;
}

@media (hover: hover) {
    .feature-item:hover {
        background: rgba(255, 255, 255, 0.25);
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
        border-color: rgba(255, 255, 255, 0.4);
    }
    
    .feature-item:hover i {
        transform: scale(1.2);
    }
    
    .feature-item:hover span {
        color: rgba(255, 255, 255, 1);
    }
}

.feature-item:active,
.feature-item:focus {
    background: rgba(255, 255, 255, 0.25);
    transform: translateY(-2px) scale(0.98);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
    border-color: rgba(255, 255, 255, 0.4);
    outline: none;
}

.feature-item:active i,
.feature-item:focus i {
    transform: scale(1.2);
}

.feature-item i {
    font-size: 1.2rem;
    transition: transform 0.3s;
}

.feature-item span {
    font-weight: 500;
    transition: color 0.3s;
}

.header-icon-container {
    position: relative;
    height: 300px;
}

.icon-circle-main {
    width: 180px;
    height: 180px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 5rem;
    color: white;
    margin: 0 auto;
    backdrop-filter: blur(10px);
    border: 3px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    animation: pulse 3s infinite;
    position: relative;
    z-index: 2;
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    }
    50% {
        transform: scale(1.05);
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
    }
}

.floating-icon {
    position: absolute;
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.25);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.4);
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
}

.floating-icon.icon-1 {
    top: 20px;
    left: 20px;
    animation: float 3s ease-in-out infinite;
}

.floating-icon.icon-2 {
    top: 60px;
    right: 30px;
    animation: float 3s ease-in-out infinite 1s;
}

.floating-icon.icon-3 {
    bottom: 40px;
    left: 40px;
    animation: float 3s ease-in-out infinite 2s;
}

@keyframes float {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-15px);
    }
}

.decorative-shape {
    position: absolute;
    border-radius: 50%;
    opacity: 0.1;
}

.decorative-shape.shape-1 {
    width: 300px;
    height: 300px;
    background: white;
    top: -100px;
    right: -100px;
    animation: morph 15s infinite;
}

.decorative-shape.shape-2 {
    width: 200px;
    height: 200px;
    background: white;
    bottom: -50px;
    left: 20%;
    animation: morph 20s infinite reverse;
}

.decorative-shape.shape-3 {
    width: 150px;
    height: 150px;
    background: white;
    top: 50%;
    right: 10%;
    animation: morph 12s infinite;
}

@keyframes morph {
    0%, 100% {
        border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
    }
    50% {
        border-radius: 30% 60% 70% 40% / 50% 60% 30% 60%;
    }
}

@media (max-width: 991.98px) {
    .animate-title {
        font-size: 2.5rem;
    }
    
    .animate-subtitle {
        font-size: 1.1rem;
    }
    
    .header-features {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .feature-item {
        margin-bottom: 10px;
    }
}

@media (max-width: 575.98px) {
    .animate-title {
        font-size: 2rem;
    }
    
    .animate-subtitle {
        font-size: 1rem;
    }
    
    .feature-item {
        font-size: 0.9rem;
        padding: 8px 14px;
        gap: 6px;
    }
}

.category-card {
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.category-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
}

.category-card:not(.active) {
    color: #333;
}

.category-card.active {
    color: white;
}

.category-icon {
    transition: transform 0.3s ease;
}

.category-card:hover .category-icon {
    transform: scale(1.2);
}

.gallery-card {
    transition: all 0.3s ease;
}

.gallery-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.gallery-image {
    transition: transform 0.5s ease;
}

.gallery-card:hover .gallery-image {
    transform: scale(1.1);
}

.gallery-overlay {
    background: linear-gradient(to top, rgba(0,0,0,0.85), rgba(0,0,0,0.5), transparent);
    opacity: 0;
    transition: opacity 0.3s ease;
    pointer-events: none;
}

.gallery-card:hover .gallery-overlay {
    opacity: 1;
}

.pagination .page-link {
    color: #000000;
    border: 2px solid #e9ecef;
    margin: 0 5px;
    border-radius: 10px;
    padding: 10px 20px;
    font-weight: 500;
}

.pagination .page-link:hover {
    background-color: #667eea;
    border-color: #667eea;
    color: white;
}

.pagination .page-item.active .page-link {
    background-color: #667eea;
    border-color: #667eea;
}

.pagination .page-item.disabled .page-link {
    border-color: #e9ecef;
}

@media (max-width: 768px) {
    .hero-section {
        padding: 40px 0;
    }
    
    .gallery-image {
        height: 220px;
    }
}
</style>

<script>
// Handle click on feature items
function handleFeatureClick(element) {
    // Add active state temporarily
    element.style.transform = 'translateY(-2px) scale(0.98)';
    element.style.background = 'rgba(255, 255, 255, 0.25)';
    element.style.boxShadow = '0 8px 25px rgba(0, 0, 0, 0.25)';
    
    // Reset after animation
    setTimeout(() => {
        element.style.transform = '';
        element.style.background = '';
        element.style.boxShadow = '';
    }, 200);
}

// Handle keyboard interaction
function handleFeatureKeypress(event, element) {
    if (event.key === 'Enter' || event.key === ' ') {
        event.preventDefault();
        handleFeatureClick(element);
    }
}

// Touch support for mobile devices
document.addEventListener('DOMContentLoaded', function() {
    const featureItems = document.querySelectorAll('.feature-item');
    
    featureItems.forEach(item => {
        // Touch start
        item.addEventListener('touchstart', function(e) {
            this.style.transform = 'translateY(-2px) scale(0.98)';
            this.style.background = 'rgba(255, 255, 255, 0.25)';
            this.style.boxShadow = '0 8px 25px rgba(0, 0, 0, 0.25)';
        }, { passive: true });
        
        // Touch end
        item.addEventListener('touchend', function(e) {
            setTimeout(() => {
                this.style.transform = '';
                this.style.background = '';
                this.style.boxShadow = '';
            }, 150);
        }, { passive: true });
        
        // Touch cancel
        item.addEventListener('touchcancel', function(e) {
            this.style.transform = '';
            this.style.background = '';
            this.style.boxShadow = '';
        }, { passive: true });
    });
});

// Smooth scroll for pagination links
document.querySelectorAll('a.page-link').forEach(link => {
    link.addEventListener('click', function(e) {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
});
</script>

<?php require_once 'includes/footer.php'; ?>