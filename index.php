<?php
$pageTitle = 'Beranda';
require_once 'includes/header.php';

// Ambil berita terbaru
$berita_terbaru = fetchAll("SELECT * FROM berita ORDER BY tanggal DESC LIMIT 5");

// Ambil profil sekolah
$profil = fetchOne("SELECT * FROM halaman WHERE slug = 'tentang'");
?>

<!-- Hero Section -->
<section class="hero-section text-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-4">Selamat Datang di123 <?php echo htmlspecialchars($pengaturan['nama_sekolah']); ?></h1>
                <p class="lead mb-4">Membangun Masa Depan Cerah bagi Anak Berkebutuhan Khusus</p>
                <a href="kontak.php" class="btn btn-light btn-lg px-5 py-3 fw-bold">Hubungi Kami</a>
            </div>
        </div>
    </div>
</section>

<!-- Tentang Sekolah -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="https://via.placeholder.com/600x400/4A90E2/ffffff?text=SLB+Rumah+Kita+Batam" 
                     alt="Tentang Sekolah" class="img-fluid rounded shadow">
            </div>
            <div class="col-lg-6">
                <h2 class="section-title">Tentang Sekolah</h2>
                <?php echo $profil ? $profil['isi'] : '<p>Memuat informasi...</p>'; ?>
                <a href="profil.php" class="btn btn-primary mt-3">Selengkapnya <i class="fas fa-arrow-right ms-2"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- Program Pendidikan -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center">Program Pendidikan</h2>
        <p class="text-center mb-5">Kami menyediakan berbagai program pendidikan yang disesuaikan dengan kebutuhan siswa</p>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card h-100 text-center p-4">
                    <div class="card-body">
                        <i class="fas fa-book-reader fa-3x text-primary mb-3"></i>
                        <h4 class="card-title">Program SDLB</h4>
                        <p class="card-text text-muted">Pendidikan dasar untuk anak berkebutuhan khusus di tingkat sekolah dasar</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 text-center p-4">
                    <div class="card-body">
                        <i class="fas fa-graduation-cap fa-3x text-primary mb-3"></i>
                        <h4 class="card-title">Program SMPLB</h4>
                        <p class="card-text text-muted">Pendidikan menengah pertama dengan kurikulum yang disesuaikan</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 text-center p-4">
                    <div class="card-body">
                        <i class="fas fa-university fa-3x text-primary mb-3"></i>
                        <h4 class="card-title">Program SMALB</h4>
                        <p class="card-text text-muted">Pendidikan menengah atas untuk persiapan kemandirian siswa</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Berita Terbaru -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title text-center">Berita Terbaru</h2>
        <p class="text-center mb-5">Ikuti kegiatan dan informasi terbaru dari sekolah kami</p>
        <div class="row">
            <?php if ($berita_terbaru): ?>
                <?php foreach ($berita_terbaru as $berita): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card news-card h-100">
                            <?php if ($berita['gambar']): ?>
                                <img src="uploads/berita/<?php echo htmlspecialchars($berita['gambar']); ?>" 
                                     alt="<?php echo htmlspecialchars($berita['judul']); ?>" class="card-img-top">
                            <?php else: ?>
                                <img src="https://via.placeholder.com/400x200/4A90E2/ffffff?text=Berita" 
                                     alt="<?php echo htmlspecialchars($berita['judul']); ?>" class="card-img-top">
                            <?php endif; ?>
                            <div class="card-body">
                                <small class="text-muted">
                                    <i class="far fa-calendar-alt me-1"></i>
                                    <?php echo date('d F Y', strtotime($berita['tanggal'])); ?>
                                </small>
                                <h5 class="card-title mt-2">
                                    <a href="detail_berita.php?slug=<?php echo htmlspecialchars($berita['slug']); ?>" 
                                       class="text-decoration-none text-dark">
                                        <?php echo htmlspecialchars($berita['judul']); ?>
                                    </a>
                                </h5>
                                <p class="card-text text-muted">
                                    <?php echo substr(strip_tags($berita['isi']), 0, 100) . '...'; ?>
                                </p>
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                <a href="detail_berita.php?slug=<?php echo htmlspecialchars($berita['slug']); ?>" 
                                   class="btn btn-sm btn-outline-primary">
                                    Baca Selengkapnya
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p class="text-muted">Belum ada berita yang tersedia.</p>
                </div>
            <?php endif; ?>
        </div>
        <div class="text-center mt-4">
            <a href="berita.php" class="btn btn-primary">Lihat Semua Berita</a>
        </div>
    </div>
</section>

<!-- Galeri Singkat -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center">Galeri Kegiatan</h2>
        <p class="text-center mb-5">Momen-momen berharga dari kegiatan siswa</p>
        <div class="row">
            <?php
            $galeri = fetchAll("SELECT * FROM galeri ORDER BY tanggal DESC LIMIT 6");
            if ($galeri):
                foreach ($galeri as $item):
            ?>
            <div class="col-md-4 col-lg-2 mb-4">
                <div class="gallery-item">
                    <?php if ($item['gambar']): ?>
                        <img src="uploads/galeri/<?php echo htmlspecialchars($item['gambar']); ?>" 
                             alt="<?php echo htmlspecialchars($item['judul']); ?>">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/300x250/4A90E2/ffffff?text=Galeri" 
                             alt="<?php echo htmlspecialchars($item['judul']); ?>">
                    <?php endif; ?>
                </div>
            </div>
            <?php 
                endforeach;
            endif;
            ?>
        </div>
        <div class="text-center mt-4">
            <a href="galeri.php" class="btn btn-primary">Lihat Semua Galeri</a>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5">
    <div class="container text-center">
        <h2 class="mb-4">Bergabunglah Bersama Kami</h2>
        <p class="lead mb-4 text-muted">Kami siap membantu mengembangkan potensi anak Anda</p>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <a href="kontak.php" class="btn btn-primary btn-lg me-2">
                    <i class="fas fa-phone me-2"></i>Hubungi Kami
                </a>
                <a href="program.php" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-info-circle me-2"></i>Informasi Program
                </a>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>