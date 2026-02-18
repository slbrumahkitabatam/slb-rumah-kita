<?php
$pageTitle = 'Galeri Kegiatan';
require_once 'includes/header.php';

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 12;
$offset = ($page - 1) * $perPage;

// Ambil total galeri
$total_galeri = fetchOne("SELECT COUNT(*) as total FROM galeri");
$totalPages = ceil($total_galeri['total'] / $perPage);

// Ambil galeri dengan pagination
$galeri = fetchAll("SELECT * FROM galeri ORDER BY tanggal DESC LIMIT $offset, $perPage");
?>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="bg-light py-3">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Galeri</li>
        </ol>
    </div>
</nav>

<!-- Header -->
<section class="py-5 bg-primary text-white text-center">
    <div class="container">
        <h1 class="fw-bold mb-3">Galeri Kegiatan</h1>
        <p class="lead">Dokumentasi aktivitas dan kegiatan siswa SLB Rumah Kita Batam</p>
    </div>
</section>

<!-- Galeri Grid -->
<section class="py-5">
    <div class="container">
        <?php if ($galeri): ?>
            <div class="row">
                <?php foreach ($galeri as $item): ?>
                    <div class="col-lg-3 col-md-4 col-6 mb-4">
                        <div class="gallery-item position-relative">
                            <?php if ($item['gambar']): ?>
                                <img src="uploads/galeri/<?php echo htmlspecialchars($item['gambar']); ?>" 
                                     alt="<?php echo htmlspecialchars($item['judul']); ?>" 
                                     class="w-100" style="height: 200px; object-fit: cover;">
                            <?php else: ?>
                                <img src="https://via.placeholder.com/300x200/4A90E2/ffffff?text=Galeri" 
                                     alt="<?php echo htmlspecialchars($item['judul']); ?>" 
                                     class="w-100" style="height: 200px; object-fit: cover;">
                            <?php endif; ?>
                            <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-75 text-white p-3" style="display: none;">
                                <h6 class="mb-1"><?php echo htmlspecialchars($item['judul']); ?></h6>
                                <small class="text-white-50">
                                    <i class="far fa-calendar-alt me-1"></i>
                                    <?php echo date('d F Y', strtotime($item['tanggal'])); ?>
                                </small>
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
                <i class="fas fa-images fa-5x text-muted mb-3"></i>
                <h3 class="text-muted">Belum Ada Galeri</h3>
                <p class="text-muted">Belum ada foto galeri yang tersedia saat ini.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<script>
// Gallery overlay on hover
document.querySelectorAll('.gallery-item').forEach(item => {
    const overlay = item.querySelector('.position-absolute.bottom-0');
    item.addEventListener('mouseenter', () => {
        overlay.style.display = 'block';
    });
    item.addEventListener('mouseleave', () => {
        overlay.style.display = 'none';
    });
});
</script>

<?php require_once 'includes/footer.php'; ?>