<?php
$pageTitle = 'Berita & Kegiatan';
require_once 'includes/header.php';

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
<section class="py-5 bg-primary text-white text-center">
    <div class="container">
        <h1 class="fw-bold mb-3">Berita & Kegiatan Sekolah</h1>
        <p class="lead">Ikuti informasi terbaru dan kegiatan dari SLB Rumah Kita Batam</p>
    </div>
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

<?php require_once 'includes/footer.php'; ?>