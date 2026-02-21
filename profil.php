<?php
$pageTitle = 'Profil Sekolah';
require_once 'includes/header.php';

// Ambil konten halaman
$tentang = fetchOne("SELECT * FROM halaman WHERE slug = 'tentang'");
$visi_misi = fetchOne("SELECT * FROM halaman WHERE slug = 'visi-misi'");
?>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="bg-light py-3">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Profil</li>
        </ol>
    </div>
</nav>

<!-- Tentang Sekolah -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="gambar/Tentang Sekolah4.jpg" 
                     alt="Profil Sekolah" class="img-fluid rounded shadow">
            </div>
            <div class="col-lg-6">
                <h2 class="section-title">Tentang Sekolah</h2>
                <?php echo $tentang ? $tentang['isi'] : '<p>Informasi sedang dimuat...</p>'; ?>
                
                <div class="row mt-4">
                    <div class="col-md-4 mb-3">
                        <div class="text-center">
                            <h3 class="text-primary fw-bold">50+</h3>
                            <p class="text-muted">Siswa Aktif</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="text-center">
                            <h3 class="text-primary fw-bold">15+</h3>
                            <p class="text-muted">Guru Profesional</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="text-center">
                            <h3 class="text-primary fw-bold">20+</h3>
                            <p class="text-muted">Tahun Pengalaman</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Visi & Misi -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center mb-5">Visi & Misi</h2>
        
        <div class="row">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <i class="fas fa-eye fa-3x text-primary mb-3"></i>
                            <h3 class="card-title">Visi</h3>
                        </div>
                        <?php 
                        if ($visi_misi) {
                            // Extract visi section from content
                            preg_match('/<h3>Visi<\/h3>\s*<p>(.*?)<\/p>/s', $visi_misi['isi'], $matches);
                            echo $matches ? '<p>' . $matches[1] . '</p>' : '<p>Memuat visi...</p>';
                        } else {
                            echo '<p>Memuat visi...</p>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <i class="fas fa-bullseye fa-3x text-primary mb-3"></i>
                            <h3 class="card-title">Misi</h3>
                        </div>
                        <?php 
                        if ($visi_misi) {
                            // Extract misi section from content
                            preg_match('/<h3>Misi<\/h3>\s*<ol>(.*?)<\/ol>/s', $visi_misi['isi'], $matches);
                            if ($matches) {
                                echo '<ol>' . $matches[1] . '</ol>';
                            } else {
                                echo '<p>Memuat misi...</p>';
                            }
                        } else {
                            echo '<p>Memuat misi...</p>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Struktur Organisasi -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title text-center mb-5">Struktur Organisasi</h2>
        
        <?php
        $guru_list = fetchAll("SELECT * FROM guru WHERE aktif = 1 ORDER BY urutan ASC, nama ASC");
        if ($guru_list):
        ?>
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-5">
                        <div class="row justify-content-center">
                            <?php foreach ($guru_list as $item): ?>
                            <div class="col-md-4 col-lg-3 mb-4">
                                <div class="card h-100 border-0 text-center">
                                    <div class="card-body">
                                        <?php if ($item['foto']): ?>
                                            <img src="uploads/guru/<?php echo htmlspecialchars($item['foto']); ?>" 
                                                 alt="<?php echo htmlspecialchars($item['nama']); ?>" 
                                                 class="rounded-circle mb-3" width="150" height="150" 
                                                 style="object-fit: cover; border: 4px solid #4A90E2;">
                                        <?php else: ?>
                                            <img src="https://via.placeholder.com/150x150/4A90E2/ffffff?text=<?php echo urlencode(substr($item['nama'], 0, 1)); ?>" 
                                                 alt="<?php echo htmlspecialchars($item['nama']); ?>" 
                                                 class="rounded-circle mb-3" width="150" height="150" 
                                                 style="object-fit: cover; border: 4px solid #4A90E2;">
                                        <?php endif; ?>
                                        <h5 class="fw-bold"><?php echo htmlspecialchars($item['nama']); ?></h5>
                                        <p class="text-primary fw-bold mb-2"><?php echo htmlspecialchars($item['jabatan']); ?></p>
                                        <?php if ($item['deskripsi']): ?>
                                            <p class="text-muted small"><?php echo htmlspecialchars(substr($item['deskripsi'], 0, 100)); ?>...</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="text-center py-5">
            <i class="fas fa-users fa-3x text-muted mb-3"></i>
            <p class="text-muted">Belum ada data guru yang ditampilkan</p>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Nilai & Budaya -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center mb-5">Nilai & Budaya</h2>
        
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card h-100 text-center border-0 shadow-sm p-4">
                    <div class="card-body">
                        <i class="fas fa-heart fa-3x text-danger mb-3"></i>
                        <h5 class="card-title">Kasih Sayang</h5>
                        <p class="card-text text-muted small">Memberikan perhatian dan kepedulian penuh kepada setiap siswa</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card h-100 text-center border-0 shadow-sm p-4">
                    <div class="card-body">
                        <i class="fas fa-handshake fa-3x text-success mb-3"></i>
                        <h5 class="card-title">Kerjasama</h5>
                        <p class="card-text text-muted small">Membangun kolaborasi dengan orang tua dan masyarakat</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card h-100 text-center border-0 shadow-sm p-4">
                    <div class="card-body">
                        <i class="fas fa-lightbulb fa-3x text-warning mb-3"></i>
                        <h5 class="card-title">Inovasi</h5>
                        <p class="card-text text-muted small">Terus berinovasi dalam metode pembelajaran</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card h-100 text-center border-0 shadow-sm p-4">
                    <div class="card-body">
                        <i class="fas fa-shield-alt fa-3x text-info mb-3"></i>
                        <h5 class="card-title">Integritas</h5>
                        <p class="card-text text-muted small">Menjunjung tinggi kejujuran dan profesionalisme</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>