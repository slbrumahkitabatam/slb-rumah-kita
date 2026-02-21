<?php
$pageTitle = 'Profil Sekolah';
require_once 'includes/header.php';

// Ambil konten profil dari tabel profil_sekolah
$profil = fetchOne("SELECT * FROM profil_sekolah LIMIT 1");
$tentang = $profil ? ['isi' => $profil['tentang']] : null;
$visi_misi = $profil ? ['isi' => $profil['visi_misi']] : null;
?>
<style>
/* Elegant Header Section */
.elegant-header-section {
    background: linear-gradient(135deg, <?php echo $tampilan['warna_utama'] ?? '#4A90E2'; ?> 0%, <?php 
        $primaryColor = $tampilan['warna_utama'] ?? '#4A90E2';
        $r = hexdec(substr($primaryColor, 1, 2));
        $g = hexdec(substr($primaryColor, 3, 2));
        $b = hexdec(substr($primaryColor, 5, 2));
        $r = max(0, $r - 30);
        $g = max(0, $g - 30);
        $b = max(0, $b - 30);
        echo sprintf('#%02X%02X%02X', $r, $g, $b);
    ?> 100%);
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
</style>

<!-- Header -->
<section class="elegant-header-section position-relative overflow-hidden">
    <div class="container position-relative">
        <div class="row align-items-center py-5">
            <div class="col-lg-8">
                <div class="header-badge mb-4">
                    <span class="badge bg-light text-primary">
                        <i class="fas fa-school me-2"></i>Profil Sekolah
                    </span>
                </div>
                <h1 class="fw-bold mb-4 text-white animate-title">
                    Mengenal SLB Rumah Kita
                </h1>
                <p class="lead text-white-50 mb-4 animate-subtitle">
                    Sekolah Luar Biasa yang berkomitmen memberikan pendidikan terbaik untuk siswa berkebutuhan khusus
                </p>
                <div class="header-features mt-4">
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <div class="feature-item" role="button" tabindex="0" onclick="handleFeatureClick(this)" onkeypress="handleFeatureKeypress(event, this)">
                            <i class="fas fa-check-circle text-success"></i>
                            <span class="text-white">Pendidikan Berkualitas</span>
                        </div>
                        <div class="feature-item" role="button" tabindex="0" onclick="handleFeatureClick(this)" onkeypress="handleFeatureKeypress(event, this)">
                            <i class="fas fa-check-circle text-success"></i>
                            <span class="text-white">Guru Profesional</span>
                        </div>
                        <div class="feature-item" role="button" tabindex="0" onclick="handleFeatureClick(this)" onkeypress="handleFeatureKeypress(event, this)">
                            <i class="fas fa-check-circle text-success"></i>
                            <span class="text-white">Fasilitas Lengkap</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-center d-none d-lg-block">
                <div class="header-icon-container">
                    <div class="icon-circle-main">
                        <i class="fas fa-school"></i>
                    </div>
                    <div class="floating-icon icon-1">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="floating-icon icon-2">
                        <i class="fas fa-heart"></i>
                    </div>
                    <div class="floating-icon icon-3">
                        <i class="fas fa-users"></i>
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
                                                 style="object-fit: cover; border: 4px solid <?php echo $tampilan['warna_utama'] ?? '#4A90E2'; ?>;">
                                        <?php else: ?>
                                            <img src="https://via.placeholder.com/150x150/<?php echo substr($tampilan['warna_utama'] ?? '4A90E2', 1); ?>/ffffff?text=<?php echo urlencode(substr($item['nama'], 0, 1)); ?>" 
                                                 alt="<?php echo htmlspecialchars($item['nama']); ?>" 
                                                 class="rounded-circle mb-3" width="150" height="150" 
                                                 style="object-fit: cover; border: 4px solid <?php echo $tampilan['warna_utama'] ?? '#4A90E2'; ?>;">
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
