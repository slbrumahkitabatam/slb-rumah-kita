<?php
$pageTitle = 'Galeri Kegiatan';
require_once 'includes/header.php';

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

<!-- Hero Section -->
<section class="hero-section text-white text-center position-relative overflow-hidden">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%); opacity: 0.1;"></div>
    <div class="container position-relative">
        <div class="py-5">
            <h1 class="fw-bold mb-3 display-4">Galeri Kegiatan</h1>
            <p class="lead mb-4 opacity-75">Dokumentasi aktivitas dan kegiatan siswa SLB Rumah Kita Batam</p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <span class="badge rounded-pill px-4 py-2 fs-6" style="background: rgba(255,255,255,0.2);">
                    <i class="fas fa-images me-2"></i><?php echo $total_galeri['total']; ?> Foto
                </span>
                <span class="badge rounded-pill px-4 py-2 fs-6" style="background: rgba(255,255,255,0.2);">
                    <i class="fas fa-folder me-2"></i>5 Kategori
                </span>
            </div>
        </div>
    </div>
    <div class="wave-bottom">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="#ffffff"/>
        </svg>
    </div>
</section>

<!-- Breadcrumb -->
<section class="py-3 bg-light">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none" style="color: #667eea;"><i class="fas fa-home me-1"></i>Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Galeri</li>
            </ol>
        </nav>
    </div>
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
                                         class="card-img-top gallery-image" style="height: 280px; object-fit: cover;"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="card-img-top d-none align-items-center justify-content-center text-white" 
                                         style="height: 280px; background: <?php echo isset($kategoriInfo[$item['kategori']]) ? $kategoriInfo[$item['kategori']]['gradient'] : 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)'; ?>;">
                                        <div class="text-center">
                                            <i class="fas fa-images fa-3x mb-3 opacity-75"></i>
                                            <p class="mb-0 fw-bold"><?php echo htmlspecialchars($item['judul']); ?></p>
                                            <p class="mb-0 small mt-2 opacity-75">Gambar tidak tersedia</p>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="card-img-top d-flex align-items-center justify-content-center text-white" 
                                         style="height: 280px; background: <?php echo isset($kategoriInfo[$item['kategori']]) ? $kategoriInfo[$item['kategori']]['gradient'] : 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)'; ?>;">
                                        <div class="text-center">
                                            <i class="fas fa-images fa-3x mb-3 opacity-75"></i>
                                            <p class="mb-0 fw-bold"><?php echo htmlspecialchars($item['judul']); ?></p>
                                            <p class="mb-0 small mt-2 opacity-75"><?php echo $item['gambar'] ? 'Gambar tidak tersedia' : 'Belum ada gambar'; ?></p>
                                        </div>
                                    </div>
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
.hero-section {
    padding: 80px 0;
    margin-bottom: 0;
}

.wave-bottom {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    line-height: 0;
}

.wave-bottom svg {
    display: block;
    width: 100%;
    height: 120px;
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
    color: #667eea;
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