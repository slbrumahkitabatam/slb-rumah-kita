<?php
require_once 'includes/header.php';

// Ambil slug dari URL
$slug = isset($_GET['slug']) ? $_GET['slug'] : '';

// Ambil berita berdasarkan slug
$berita = fetchOne("SELECT * FROM berita WHERE slug = ?", [$slug]);

if (!$berita) {
    header('Location: berita.php');
    exit;
}

$pageTitle = htmlspecialchars($berita['judul']);

// Ambil berita terkait
$berita_terkait = fetchAll("SELECT * FROM berita WHERE id != ? ORDER BY tanggal DESC LIMIT 4", [$berita['id']]);
?>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="bg-light py-3">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
            <li class="breadcrumb-item"><a href="berita.php">Berita</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($berita['judul']); ?></li>
        </ol>
    </div>
</nav>

<!-- Detail Berita -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <!-- Artikel -->
                <article>
                    <div class="mb-4">
                        <?php if ($berita['gambar']): ?>
                            <img src="uploads/berita/<?php echo htmlspecialchars($berita['gambar']); ?>" 
                                 alt="<?php echo htmlspecialchars($berita['judul']); ?>" 
                                 class="img-fluid rounded shadow w-100 mb-4">
                        <?php else: ?>
                            <img src="https://via.placeholder.com/800x400/4A90E2/ffffff?text=Berita" 
                                 alt="<?php echo htmlspecialchars($berita['judul']); ?>" 
                                 class="img-fluid rounded shadow w-100 mb-4">
                        <?php endif; ?>
                        
                        <h1 class="display-5 fw-bold mb-3"><?php echo htmlspecialchars($berita['judul']); ?></h1>
                        
                        <div class="d-flex align-items-center text-muted mb-4">
                            <span class="me-4">
                                <i class="far fa-calendar-alt me-2"></i>
                                <?php echo date('d F Y', strtotime($berita['tanggal'])); ?>
                            </span>
                            <span class="me-4">
                                <i class="far fa-user me-2"></i>
                                <?php echo htmlspecialchars($berita['penulis']); ?>
                            </span>
                        </div>
                        
                        <div class="blog-content">
                            <?php echo $berita['isi']; ?>
                        </div>
                    </div>
                    
                    <!-- Share Buttons -->
                    <div class="border-top pt-4 mt-4">
                        <h5 class="mb-3">Bagikan Artikel Ini</h5>
                        <div class="d-flex gap-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" 
                               class="btn btn-outline-primary" target="_blank">
                                <i class="fab fa-facebook-f"></i> Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" 
                               class="btn btn-outline-info" target="_blank">
                                <i class="fab fa-twitter"></i> Twitter
                            </a>
                            <a href="https://wa.me/?text=<?php echo urlencode($berita['judul'] . ' - ' . 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" 
                               class="btn btn-outline-success" target="_blank">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </a>
                        </div>
                    </div>
                </article>
                
                <!-- Berita Terkait -->
                <?php if ($berita_terkait): ?>
                <div class="mt-5">
                    <h3 class="section-title">Berita Terkait</h3>
                    <div class="row">
                        <?php foreach ($berita_terkait as $item): ?>
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <?php if ($item['gambar']): ?>
                                        <img src="uploads/berita/<?php echo htmlspecialchars($item['gambar']); ?>" 
                                             alt="<?php echo htmlspecialchars($item['judul']); ?>" 
                                             class="card-img-top" style="height: 150px; object-fit: cover;">
                                    <?php else: ?>
                                        <img src="https://via.placeholder.com/300x150/4A90E2/ffffff?text=Berita" 
                                             alt="<?php echo htmlspecialchars($item['judul']); ?>" 
                                             class="card-img-top" style="height: 150px; object-fit: cover;">
                                    <?php endif; ?>
                                    <div class="card-body p-3">
                                        <small class="text-muted">
                                            <i class="far fa-calendar-alt me-1"></i>
                                            <?php echo date('d F Y', strtotime($item['tanggal'])); ?>
                                        </small>
                                        <h6 class="card-title mt-2">
                                            <a href="detail_berita.php?slug=<?php echo htmlspecialchars($item['slug']); ?>" 
                                               class="text-decoration-none text-dark">
                                                <?php echo htmlspecialchars($item['judul']); ?>
                                            </a>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Sekolah</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-3">
                                <i class="fas fa-building me-2 text-primary"></i>
                                <?php echo htmlspecialchars($pengaturan['nama_sekolah']); ?>
                            </li>
                            <li class="mb-3">
                                <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                <?php echo nl2br(htmlspecialchars($pengaturan['alamat'])); ?>
                            </li>
                            <li class="mb-3">
                                <i class="fas fa-phone me-2 text-primary"></i>
                                <?php echo htmlspecialchars($pengaturan['telepon']); ?>
                            </li>
                            <li>
                                <i class="fas fa-envelope me-2 text-primary"></i>
                                <?php echo htmlspecialchars($pengaturan['email']); ?>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-newspaper me-2"></i>Berita Terbaru</h5>
                    </div>
                    <div class="card-body p-3">
                        <?php
                        $berita_sidebar = fetchAll("SELECT * FROM berita ORDER BY tanggal DESC LIMIT 5");
                        if ($berita_sidebar):
                            foreach ($berita_sidebar as $item):
                        ?>
                            <div class="mb-3 pb-3 border-bottom">
                                <h6 class="mb-1">
                                    <a href="detail_berita.php?slug=<?php echo htmlspecialchars($item['slug']); ?>" 
                                       class="text-decoration-none text-dark">
                                        <?php echo htmlspecialchars($item['judul']); ?>
                                    </a>
                                </h6>
                                <small class="text-muted">
                                    <i class="far fa-calendar-alt me-1"></i>
                                    <?php echo date('d F Y', strtotime($item['tanggal'])); ?>
                                </small>
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
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>