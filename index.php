<?php
$pageTitle = 'Beranda';
require_once 'includes/header.php';

// Ambil berita terbaru
$berita_terbaru = fetchAll("SELECT * FROM berita ORDER BY tanggal DESC LIMIT 5");

// Ambil profil sekolah
$profil = fetchOne("SELECT * FROM halaman WHERE slug = 'tentang-sekolah'");
?>

<!-- Hero Section -->
<section class="hero-section text-center position-relative overflow-hidden">
    <!-- Background Image with Overlay -->
    <div class="hero-bg position-absolute top-0 start-0 w-100 h-100">
        <img src="gambar/header2.jpg" alt="Background" class="w-100 h-100 object-cover" 
             onerror="this.src='https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=1920&q=80'">
        <div class="hero-overlay position-absolute top-0 start-0 w-100 h-100"></div>
    </div>
    
    <!-- Floating Elements -->
    <div class="hero-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>
    
    <div class="container position-relative z-1">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                <div class="hero-content animate-up">
                    <!-- Badge -->
                    <div class="hero-badge mb-4">
                        <span class="badge bg-white bg-opacity-25 text-white px-4 py-2 rounded-pill">
                            <i class="fas fa-star me-2"></i>Pendidikan Inklusif Terbaik
                        </span>
                    </div>
                    
                    <h1 class="display-3 display-lg-2 fw-bold mb-4 text-white">
                        Selamat Datang<br>
                        <span class="hero-highlight"><?php echo htmlspecialchars($pengaturan['nama_sekolah']); ?></span>
                    </h1>
                    
                    <p class="lead mb-5 text-white text-opacity-90 mx-auto" style="max-width: 700px;">
                        Membangun Masa Depan Cerah bagi Anak Berkebutuhan Khusus dengan Pendekatan 
                        <span class="fw-semibold text-warning">Inklusif</span> dan 
                        <span class="fw-semibold text-warning">Profesional</span>
                    </p>
                    
                    <!-- CTA Buttons -->
                    <div class="hero-buttons mb-5">
                        <a href="kontak.php" class="btn btn-light btn-lg px-5 py-3 fw-bold me-3 mb-3 mb-md-0 shadow hover-lift">
                            <i class="fas fa-phone-alt me-2"></i>Hubungi Kami
                        </a>
                        <a href="program.php" class="btn btn-outline-light btn-lg px-5 py-3 fw-bold mb-3 mb-md-0 shadow hover-lift">
                            <i class="fas fa-book me-2"></i>Lihat Program
                        </a>
                    </div>
                    
                    <!-- Quick Stats -->
                    <div class="hero-stats row g-4 justify-content-center">
                        <div class="col-6 col-md-3">
                            <div class="stat-item">
                                <div class="stat-number">
                                    <i class="fas fa-users text-warning"></i>
                                    <span class="ms-2">50+</span>
                                </div>
                                <div class="stat-label text-white text-opacity-75">Siswa Aktif</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-item">
                                <div class="stat-number">
                                    <i class="fas fa-chalkboard-teacher text-warning"></i>
                                    <span class="ms-2">15+</span>
                                </div>
                                <div class="stat-label text-white text-opacity-75">Guru Profesional</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-item">
                                <div class="stat-number">
                                    <i class="fas fa-award text-warning"></i>
                                    <span class="ms-2">20+</span>
                                </div>
                                <div class="stat-label text-white text-opacity-75">Tahun Pengalaman</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-item">
                                <div class="stat-number">
                                    <i class="fas fa-graduation-cap text-warning"></i>
                                    <span class="ms-2">50+</span>
                                </div>
                                <div class="stat-label text-white text-opacity-75">Lulusan Berprestasi</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scroll Indicator -->
    <div class="scroll-indicator position-absolute bottom-0 start-50 translate-middle-x">
        <a href="#about" class="text-white text-decoration-none">
            <div class="scroll-mouse">
                <div class="scroll-wheel"></div>
            </div>
            <small class="d-block mt-2 text-white text-opacity-75">Scroll ke Bawah</small>
        </a>
    </div>
</section>

<!-- Tentang Sekolah -->
<section id="about" class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="gambar/Tentang Sekolah1.jpg" 
                     alt="Tentang Sekolah" 
                     class="img-fluid rounded shadow"
                     onerror="this.src='https://via.placeholder.com/600x400/4A90E2/ffffff?text=SLB+Rumah+Kita+Batam'">
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
<section class="py-5 bg-light position-relative overflow-hidden">
    <div class="container position-relative">
        <div class="text-center mb-5">
            <h2 class="section-title mb-3">Berita Terbaru</h2>
            <p class="text-muted mb-4">Ikuti kegiatan dan informasi terbaru dari sekolah kami</p>
            <div class="section-divider mx-auto"></div>
        </div>
        
        <div class="row g-4">
            <?php if ($berita_terbaru): ?>
                <?php foreach ($berita_terbaru as $berita): ?>
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="news-card h-100">
                            <div class="news-image-wrapper">
                                <?php if ($berita['gambar']): ?>
                                    <img src="uploads/berita/<?php echo htmlspecialchars($berita['gambar']); ?>" 
                                         alt="<?php echo htmlspecialchars($berita['judul']); ?>" 
                                         class="news-image"
                                         onerror="this.src='https://via.placeholder.com/400x160/4A90E2/ffffff?text=Berita'">
                                <?php else: ?>
                                    <img src="https://via.placeholder.com/400x160/4A90E2/ffffff?text=Berita" 
                                         alt="<?php echo htmlspecialchars($berita['judul']); ?>" 
                                         class="news-image">
                                <?php endif; ?>
                                <div class="news-date-badge">
                                    <i class="far fa-calendar-alt"></i>
                                    <span><?php echo date('d M', strtotime($berita['tanggal'])); ?></span>
                                </div>
                            </div>
                            <div class="news-content">
                                <h5 class="news-title">
                                    <a href="detail_berita.php?slug=<?php echo htmlspecialchars($berita['slug']); ?>" 
                                       class="text-decoration-none">
                                        <?php echo htmlspecialchars($berita['judul']); ?>
                                    </a>
                                </h5>
                                <p class="news-excerpt">
                                    <?php echo substr(strip_tags($berita['isi']), 0, 80) . '...'; ?>
                                </p>
                                <div class="news-footer">
                                    <a href="detail_berita.php?slug=<?php echo htmlspecialchars($berita['slug']); ?>" 
                                       class="news-link">
                                        Baca Selengkapnya
                                        <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <div class="no-news-placeholder">
                        <i class="fas fa-newspaper fa-3x mb-3 text-muted"></i>
                        <p class="text-muted">Belum ada berita yang tersedia.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-5">
            <a href="berita.php" class="btn btn-primary btn-sm px-4 py-2 rounded-pill">
                Lihat Semua Berita
                <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<style>
    /* Berita Terbaru Section Styles */
    .news-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        overflow: hidden;
    }
    
    .news-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 30px rgba(74, 144, 226, 0.2);
    }
    
    .news-image-wrapper {
        position: relative;
        overflow: hidden;
        height: 160px;
    }
    
    .news-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    
    .news-card:hover .news-image {
        transform: scale(1.1);
    }
    
    .news-date-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        background: linear-gradient(135deg, #4A90E2 0%, #357ABD 100%);
        color: white;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 4px 12px rgba(74, 144, 226, 0.4);
    }
    
    .news-date-badge i {
        font-size: 0.7rem;
    }
    
    .news-content {
        padding: 1.25rem;
    }
    
    .news-title {
        font-size: 0.95rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .news-title a {
        color: #2C3E50;
        transition: color 0.3s ease;
    }
    
    .news-title a:hover {
        color: #4A90E2;
    }
    
    .news-excerpt {
        font-size: 0.8rem;
        color: #6C757D;
        margin-bottom: 1rem;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .news-footer {
        display: flex;
        justify-content: flex-end;
    }
    
    .news-link {
        font-size: 0.75rem;
        color: #4A90E2;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 6px;
        transition: all 0.3s ease;
        background: rgba(74, 144, 226, 0.1);
    }
    
    .news-link:hover {
        background: #4A90E2;
        color: white;
        transform: translateX(5px);
    }
    
    .news-link i {
        font-size: 0.65rem;
        transition: transform 0.3s ease;
    }
    
    .news-link:hover i {
        transform: translateX(3px);
    }
    
    .no-news-placeholder {
        padding: 3rem 1rem;
    }
    
    .no-news-placeholder i {
        opacity: 0.5;
    }
    
    /* Section Divider */
    .section-divider {
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, #4A90E2 0%, #357ABD 50%, #4A90E2 100%);
        border-radius: 2px;
        position: relative;
    }
    
    .section-divider::before,
    .section-divider::after {
        content: '';
        position: absolute;
        width: 12px;
        height: 12px;
        background: linear-gradient(135deg, #F5A623 0%, #FFD700 100%);
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
    }
    
    .section-divider::before {
        left: -6px;
    }
    
    .section-divider::after {
        right: -6px;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 991px) {
        .news-image-wrapper {
            height: 140px;
        }
        
        .news-content {
            padding: 1rem;
        }
        
        .news-title {
            font-size: 0.9rem;
        }
        
        .news-excerpt {
            font-size: 0.78rem;
        }
    }
    
    @media (max-width: 767px) {
        .news-image-wrapper {
            height: 130px;
        }
        
        .news-date-badge {
            padding: 5px 10px;
            font-size: 0.7rem;
        }
        
        .news-content {
            padding: 0.875rem;
        }
        
        .news-title {
            font-size: 0.85rem;
        }
        
        .news-excerpt {
            font-size: 0.75rem;
            -webkit-line-clamp: 3;
        }
        
        .news-link {
            font-size: 0.7rem;
            padding: 5px 10px;
        }
    }
    
    @media (max-width: 575px) {
        .news-image-wrapper {
            height: 120px;
        }
        
        .news-card {
            border-radius: 10px;
        }
        
        .news-date-badge {
            padding: 4px 8px;
            font-size: 0.68rem;
        }
        
        .news-date-badge i {
            font-size: 0.65rem;
        }
        
        .news-content {
            padding: 0.75rem;
        }
        
        .news-title {
            font-size: 0.8rem;
            margin-bottom: 0.6rem;
        }
        
        .news-excerpt {
            font-size: 0.72rem;
            margin-bottom: 0.75rem;
        }
        
        .news-link {
            font-size: 0.68rem;
            padding: 4px 8px;
        }
        
        .section-title {
            font-size: 1.5rem !important;
        }
    }
    
    /* Gallery Section Styles */
    .gallery-bg-decoration {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: 0;
        pointer-events: none;
    }
    
    .gallery-circle {
        position: absolute;
        border-radius: 50%;
        opacity: 0.03;
    }
    
    .gallery-circle-1 {
        width: 400px;
        height: 400px;
        background: linear-gradient(135deg, #4A90E2 0%, #357ABD 100%);
        top: -200px;
        right: -100px;
        animation: floatCircle 20s ease-in-out infinite;
    }
    
    .gallery-circle-2 {
        width: 300px;
        height: 300px;
        background: linear-gradient(135deg, #F5A623 0%, #FFD700 100%);
        bottom: -150px;
        left: -100px;
        animation: floatCircle 25s ease-in-out infinite reverse;
    }
    
    .gallery-circle-3 {
        width: 200px;
        height: 200px;
        background: linear-gradient(135deg, #4A90E2 0%, #357ABD 100%);
        top: 50%;
        left: 10%;
        animation: floatCircle 18s ease-in-out infinite;
    }
    
    @keyframes floatCircle {
        0%, 100% {
            transform: translateY(0) scale(1);
        }
        50% {
            transform: translateY(-30px) scale(1.05);
        }
    }
    
    .gallery-grid {
        position: relative;
        z-index: 1;
    }
    
    .gallery-card {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        background: white;
        cursor: pointer;
        height: 100%;
    }
    
    .gallery-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 15px 40px rgba(74, 144, 226, 0.25);
    }
    
    .gallery-image-wrapper {
        position: relative;
        overflow: hidden;
        aspect-ratio: 4/3;
        width: 100%;
    }
    
    .gallery-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .gallery-card:hover .gallery-image {
        transform: scale(1.15) rotate(1deg);
    }
    
    .gallery-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, 
            rgba(74, 144, 226, 0.95) 0%, 
            rgba(53, 122, 189, 0.95) 50%,
            rgba(245, 166, 35, 0.85) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: all 0.4s ease;
        backdrop-filter: blur(2px);
    }
    
    .gallery-card:hover .gallery-overlay {
        opacity: 1;
    }
    
    .gallery-overlay-content {
        text-align: center;
        color: white;
        transform: translateY(20px);
        transition: all 0.4s ease;
        padding: 1.5rem;
    }
    
    .gallery-card:hover .gallery-overlay-content {
        transform: translateY(0);
    }
    
    .gallery-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.25);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.5rem;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255, 255, 255, 0.3);
    }
    
    .gallery-card:hover .gallery-icon {
        transform: scale(1.1) rotate(10deg);
        background: rgba(255, 255, 255, 0.35);
    }
    
    .gallery-icon i {
        color: white;
        transition: transform 0.3s ease;
    }
    
    .gallery-card:hover .gallery-icon i {
        transform: scale(1.2);
    }
    
    .gallery-title {
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.4;
    }
    
    .gallery-date {
        font-size: 0.85rem;
        opacity: 0.95;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .gallery-date i {
        font-size: 0.8rem;
    }
    
    .no-gallery-placeholder {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    
    .no-gallery-placeholder i {
        opacity: 0.5;
    }
    
    /* Button Enhancement */
    .gallery-section .btn-primary {
        background: linear-gradient(135deg, #4A90E2 0%, #357ABD 100%);
        border: none;
        box-shadow: 0 4px 15px rgba(74, 144, 226, 0.3);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .gallery-section .btn-primary::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }
    
    .gallery-section .btn-primary:hover::before {
        left: 100%;
    }
    
    .gallery-section .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(74, 144, 226, 0.4);
    }
    
    /* Gallery Responsive Design */
    @media (max-width: 991px) {
        .gallery-image-wrapper {
            aspect-ratio: 16/10;
        }
        
        .gallery-card:hover {
            transform: translateY(-8px);
        }
        
        .gallery-icon {
            width: 50px;
            height: 50px;
            font-size: 1.3rem;
        }
        
        .gallery-title {
            font-size: 0.95rem;
        }
        
        .gallery-date {
            font-size: 0.8rem;
        }
    }
    
    @media (max-width: 767px) {
        .gallery-circle-1,
        .gallery-circle-2 {
            display: none;
        }
        
        .gallery-image-wrapper {
            aspect-ratio: 16/9;
        }
        
        .gallery-card {
            border-radius: 12px;
        }
        
        .gallery-card:hover {
            transform: translateY(-5px);
        }
        
        .gallery-icon {
            width: 45px;
            height: 45px;
            font-size: 1.2rem;
            margin-bottom: 0.75rem;
        }
        
        .gallery-overlay-content {
            padding: 1rem;
        }
        
        .gallery-title {
            font-size: 0.9rem;
            margin-bottom: 0.4rem;
        }
        
        .gallery-date {
            font-size: 0.75rem;
        }
        
        .gallery-section .btn-lg {
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
        }
    }
    
    @media (max-width: 575px) {
        .gallery-card:hover .gallery-image {
            transform: scale(1.05);
        }
        
        .gallery-icon {
            width: 40px;
            height: 40px;
            font-size: 1.1rem;
        }
        
        .gallery-overlay {
            background: linear-gradient(135deg, 
                rgba(74, 144, 226, 0.9) 0%, 
                rgba(53, 122, 189, 0.9) 100%);
        }
        
        .gallery-title {
            font-size: 0.85rem;
            -webkit-line-clamp: 3;
        }
        
        .gallery-date {
            font-size: 0.7rem;
        }
    }
</style>

<!-- Galeri Singkat -->
<section class="py-5 bg-light position-relative overflow-hidden gallery-section">
    <!-- Background Decorative Elements -->
    <div class="gallery-bg-decoration">
        <div class="gallery-circle gallery-circle-1"></div>
        <div class="gallery-circle gallery-circle-2"></div>
        <div class="gallery-circle gallery-circle-3"></div>
    </div>
    
    <div class="container position-relative">
        <div class="text-center mb-5">
            <h2 class="section-title mb-3">Galeri Kegiatan</h2>
            <p class="text-muted mb-4">Momen-momen berharga dari kegiatan siswa</p>
            <div class="section-divider mx-auto"></div>
        </div>
        
        <div class="row g-4 gallery-grid">
            <?php
            $galeri = fetchAll("SELECT * FROM galeri ORDER BY tanggal DESC LIMIT 6");
            if ($galeri):
                foreach ($galeri as $item):
            ?>
            <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                <div class="gallery-card">
                    <div class="gallery-image-wrapper">
                        <?php if ($item['gambar']): ?>
                            <img src="uploads/galeri/<?php echo htmlspecialchars($item['gambar']); ?>" 
                                 alt="<?php echo htmlspecialchars($item['judul']); ?>"
                                 class="gallery-image"
                                 onerror="this.src='https://via.placeholder.com/400x300/4A90E2/ffffff?text=Galeri'">
                        <?php else: ?>
                            <img src="https://via.placeholder.com/400x300/4A90E2/ffffff?text=Galeri" 
                                 alt="<?php echo htmlspecialchars($item['judul']); ?>"
                                 class="gallery-image">
                        <?php endif; ?>
                        
                        <!-- Overlay -->
                        <div class="gallery-overlay">
                            <div class="gallery-overlay-content">
                                <div class="gallery-icon">
                                    <i class="fas fa-search-plus"></i>
                                </div>
                                <h6 class="gallery-title"><?php echo htmlspecialchars($item['judul']); ?></h6>
                                <p class="gallery-date">
                                    <i class="far fa-calendar-alt me-2"></i>
                                    <?php echo date('d F Y', strtotime($item['tanggal'])); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                endforeach;
            else:
            ?>
                <div class="col-12 text-center">
                    <div class="no-gallery-placeholder py-5">
                        <i class="fas fa-images fa-3x mb-3 text-muted"></i>
                        <p class="text-muted">Belum ada galeri yang tersedia.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-5">
            <a href="galeri.php" class="btn btn-primary btn-lg px-5 py-3 rounded-pill shadow hover-lift">
                <i class="fas fa-th-large me-2"></i>Lihat Semua Galeri
                <i class="fas fa-arrow-right ms-2"></i>
            </a>
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