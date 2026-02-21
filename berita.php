<?php
$pageTitle = 'Berita & Kegiatan';
require_once 'includes/header.php';
?>
<style>
/* Elegant Header Section */
.elegant-header-section {
    background: linear-gradient(135deg, #4A90E2 0%, #357ABD 100%);
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
    -webkit-tap-highlight-color: transparent;
    touch-action: manipulation;
}

/* Hover state for desktop */
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

/* Active/Focus state for all devices */
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

.feature-item:active span,
.feature-item:focus span {
    color: rgba(255, 255, 255, 1);
}

.feature-item i {
    font-size: 1.2rem;
    transition: transform 0.3s;
}

.feature-item span {
    font-weight: 500;
    transition: color 0.3s;
}

/* Header Icon Container */
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

/* Decorative Shapes */
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

/* News Card Enhancement */
.news-card {
    border: none;
    border-radius: 20px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
}

.news-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.news-card .card-img-top {
    height: 220px;
    object-fit: cover;
    transition: transform 0.3s;
}

.news-card:hover .card-img-top {
    transform: scale(1.05);
}

.news-card .card-body {
    padding: 25px;
}

.news-card .card-title {
    font-weight: 700;
    font-size: 1.2rem;
    margin-bottom: 15px;
    line-height: 1.4;
}

.news-card .card-title a {
    color: #333;
    transition: color 0.3s;
}

.news-card:hover .card-title a {
    color: #4A90E2;
}

.news-card .btn {
    border-radius: 10px;
    font-weight: 600;
    padding: 10px 20px;
    transition: all 0.3s;
}

.news-card .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(74, 144, 226, 0.4);
}

/* Pagination Enhancement */
.pagination .page-link {
    border: none;
    color: #4A90E2;
    font-weight: 600;
    padding: 10px 15px;
    border-radius: 10px;
    margin: 0 5px;
    transition: all 0.3s;
}

.pagination .page-link:hover {
    background: #4A90E2;
    color: white;
    transform: translateY(-2px);
}

.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #4A90E2, #357ABD);
    border: none;
}

/* Responsive */
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
    
    .feature-item:hover {
        transform: translateY(-2px) scale(1.01);
        padding: 10px 16px;
    }
    
    .feature-item:active {
        transform: translateY(0) scale(0.99);
    }
    
    .feature-item i {
        font-size: 1rem;
    }
    
    /* Button Responsive */
    .news-card .btn {
        font-size: 0.9rem;
        padding: 8px 16px;
    }
    
    .pagination .page-link {
        padding: 8px 12px;
        font-size: 0.9rem;
    }
    
    .news-card .card-title {
        font-size: 1.1rem;
    }
    
    .header-badge .badge {
        font-size: 0.8rem;
        padding: 8px 16px;
    }
}

@media (max-width: 375px) {
    /* Extra Small Devices */
    .news-card .btn {
        font-size: 0.85rem;
        padding: 6px 12px;
    }
    
    .pagination .page-link {
        padding: 6px 10px;
        font-size: 0.85rem;
        margin: 0 3px;
    }
    
    .news-card .card-title {
        font-size: 1rem;
    }
    
    .news-card .card-body {
        padding: 20px;
    }
}
</style>
<?php

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 6;
$offset = ($page - 1) * $perPage;

// Ambil total berita
$total_berita = fetchOne("SELECT COUNT(*) as total FROM berita");
$totalPages = ceil($total_berita['total'] / $perPage);

// Ambil berita dengan pagination
$berita = fetchAll("SELECT * FROM berita ORDER BY tanggal DESC LIMIT $offset, $perPage");
?>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="bg-light py-3">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Berita</li>
        </ol>
    </div>
</nav>

<!-- Header -->
<section class="elegant-header-section position-relative overflow-hidden">
    <div class="container position-relative">
        <div class="row align-items-center py-5">
            <div class="col-lg-8">
                <div class="header-badge mb-4">
                    <span class="badge bg-light text-primary">
                        <i class="fas fa-newspaper me-2"></i>Berita Terkini
                    </span>
                </div>
                <h1 class="fw-bold mb-4 text-white animate-title">
                    Berita & Kegiatan Sekolah
                </h1>
                <p class="lead text-white-50 mb-4 animate-subtitle">
                    Ikuti informasi terbaru dan kegiatan dari SLB Rumah Kita Batam
                </p>
                <div class="header-features mt-4">
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <div class="feature-item" role="button" tabindex="0" onclick="handleFeatureClick(this)" onkeypress="handleFeatureKeypress(event, this)">
                            <i class="fas fa-check-circle text-success"></i>
                            <span class="text-white">Informasi Terupdate</span>
                        </div>
                        <div class="feature-item" role="button" tabindex="0" onclick="handleFeatureClick(this)" onkeypress="handleFeatureKeypress(event, this)">
                            <i class="fas fa-check-circle text-success"></i>
                            <span class="text-white">Kegiatan Sekolah</span>
                        </div>
                        <div class="feature-item" role="button" tabindex="0" onclick="handleFeatureClick(this)" onkeypress="handleFeatureKeypress(event, this)">
                            <i class="fas fa-check-circle text-success"></i>
                            <span class="text-white">Prestasi Siswa</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-center d-none d-lg-block">
                <div class="header-icon-container">
                    <div class="icon-circle-main">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <div class="floating-icon icon-1">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="floating-icon icon-2">
                        <i class="fas fa-image"></i>
                    </div>
                    <div class="floating-icon icon-3">
                        <i class="fas fa-star"></i>
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

<!-- Berita List -->
<section class="py-5">
    <div class="container">
        <?php if ($berita): ?>
            <div class="row">
                <?php foreach ($berita as $item): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card news-card h-100">
                            <?php if ($item['gambar']): ?>
                                <img src="uploads/berita/<?php echo htmlspecialchars($item['gambar']); ?>" 
                                     alt="<?php echo htmlspecialchars($item['judul']); ?>" class="card-img-top">
                            <?php else: ?>
                                <img src="https://via.placeholder.com/400x250/4A90E2/ffffff?text=Berita" 
                                     alt="<?php echo htmlspecialchars($item['judul']); ?>" class="card-img-top">
                            <?php endif; ?>
                            <div class="card-body">
                                <div class="mb-2">
                                    <span class="badge bg-primary">
                                        <i class="far fa-calendar-alt me-1"></i>
                                        <?php echo date('d F Y', strtotime($item['tanggal'])); ?>
                                    </span>
                                </div>
                                <h5 class="card-title">
                                    <a href="detail_berita.php?slug=<?php echo htmlspecialchars($item['slug']); ?>" 
                                       class="text-decoration-none text-dark">
                                        <?php echo htmlspecialchars($item['judul']); ?>
                                    </a>
                                </h5>
                                <p class="card-text text-muted small">
                                    <i class="far fa-user me-1"></i>
                                    <?php echo htmlspecialchars($item['penulis']); ?>
                                </p>
                                <p class="card-text">
                                    <?php echo substr(strip_tags($item['isi']), 0, 120) . '...'; ?>
                                </p>
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                <a href="detail_berita.php?slug=<?php echo htmlspecialchars($item['slug']); ?>" 
                                   class="btn btn-primary btn-sm w-100">
                                    Baca Selengkapnya
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
            <nav aria-label="Page navigation" class="mt-5">
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    
                    <?php if ($page < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
            <?php endif; ?>
            
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-newspaper fa-5x text-muted mb-3"></i>
                <h3 class="text-muted">Belum Ada Berita</h3>
                <p class="text-muted">Belum ada berita yang tersedia saat ini.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

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
</script>

<?php require_once 'includes/footer.php'; ?>
