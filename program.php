<?php
$pageTitle = 'Program & Layanan';
require_once 'includes/header.php';
?>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="bg-light py-3">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Program & Layanan</li>
        </ol>
    </div>
</nav>

<!-- Header -->
<section class="py-5 bg-primary text-white text-center">
    <div class="container">
        <h1 class="fw-bold mb-3">Program & Layanan</h1>
        <p class="lead">Program pendidikan dan layanan khusus untuk siswa berkebutuhan khusus</p>
    </div>
</section>

<!-- Program Pendidikan -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title text-center mb-5">Program Pendidikan</h2>
        
        <div class="row">
            <!-- SDLB -->
            <div class="col-lg-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <i class="fas fa-book-reader fa-4x text-primary mb-3"></i>
                            <h3 class="card-title">SDLB</h3>
                            <p class="text-muted">Sekolah Dasar Luar Biasa</p>
                        </div>
                        <h5 class="mb-3">Fokus Pembelajaran:</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Calistung Dasar</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Matematika Terapan</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Sains Dasar</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Budi Pekerti</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Olahraga & Kesehatan</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- SMPLB -->
            <div class="col-lg-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <i class="fas fa-graduation-cap fa-4x text-primary mb-3"></i>
                            <h3 class="card-title">SMPLB</h3>
                            <p class="text-muted">Sekolah Menengah Pertama Luar Biasa</p>
                        </div>
                        <h5 class="mb-3">Fokus Pembelajaran:</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Pengembangan Kognitif</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Matematika & Sains</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Bahasa Indonesia & Inggris</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>IPS & PKN</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Seni & Budaya</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- SMALB -->
            <div class="col-lg-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <i class="fas fa-university fa-4x text-primary mb-3"></i>
                            <h3 class="card-title">SMALB</h3>
                            <p class="text-muted">Sekolah Menengah Atas Luar Biasa</p>
                        </div>
                        <h5 class="mb-3">Fokus Pembelajaran:</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Kemandirian Siswa</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Keterampilan Vokasi</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Siap Kerja</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Wirausaha</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Life Skills</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Layanan Khusus -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center mb-5">Layanan Khusus</h2>
        
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-hands-helping fa-3x text-primary me-4"></i>
                            <div>
                                <h4 class="card-title">Terapi Wicara</h4>
                                <p class="card-text text-muted">Layanan terapi untuk meningkatkan kemampuan komunikasi dan berbicara siswa.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-brain fa-3x text-primary me-4"></i>
                            <div>
                                <h4 class="card-title">Terapi Okupasi</h4>
                                <p class="card-text text-muted">Latihan untuk meningkatkan kemampuan motorik halus dan kasar siswa.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-user-friends fa-3x text-primary me-4"></i>
                            <div>
                                <h4 class="card-title">Bimbingan Konseling</h4>
                                <p class="card-text text-muted">Layanan bimbingan psikologis untuk mendukung kesehatan mental siswa.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-palette fa-3x text-primary me-4"></i>
                            <div>
                                <h4 class="card-title">Ekstrakurikuler Seni</h4>
                                <p class="card-text text-muted">Kegiatan seni untuk mengembangkan bakat dan kreativitas siswa.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-tools fa-3x text-primary me-4"></i>
                            <div>
                                <h4 class="card-title">Pelatihan Keterampilan</h4>
                                <p class="card-text text-muted">Pelatihan keterampilan vokasi untuk kemandirian siswa dalam dunia kerja.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-users fa-3x text-primary me-4"></i>
                            <div>
                                <h4 class="card-title">Layanan Orang Tua</h4>
                                <p class="card-text text-muted">Edukasi dan dukungan untuk orang tua siswa dalam pengasuhan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Fasilitas -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title text-center mb-5">Fasilitas Sekolah</h2>
        
        <div class="row">
            <div class="col-md-3 col-6 mb-4">
                <div class="text-center">
                    <i class="fas fa-chalkboard-teacher fa-3x text-primary mb-3"></i>
                    <h5>Ruang Kelas AC</h5>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="text-center">
                    <i class="fas fa-book fa-3x text-primary mb-3"></i>
                    <h5>Perpustakaan</h5>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="text-center">
                    <i class="fas fa-laptop fa-3x text-primary mb-3"></i>
                    <h5>Lab Komputer</h5>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="text-center">
                    <i class="fas fa-running fa-3x text-primary mb-3"></i>
                    <h5>Lapangan Olahraga</h5>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="text-center">
                    <i class="fas fa-music fa-3x text-primary mb-3"></i>
                    <h5>Ruang Musik</h5>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="text-center">
                    <i class="fas fa-paint-brush fa-3x text-primary mb-3"></i>
                    <h5>Ruang Seni</h5>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="text-center">
                    <i class="fas fa-utensils fa-3x text-primary mb-3"></i>
                    <h5>Kantin Sehat</h5>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="text-center">
                    <i class="fas fa-pray fa-3x text-primary mb-3"></i>
                    <h5>Masjid</h5>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-5 bg-primary text-white text-center">
    <div class="container">
        <h2 class="fw-bold mb-4">Ingin Mendaftar?</h2>
        <p class="lead mb-4">Hubungi kami untuk informasi pendaftaran dan jadwal kunjungan</p>
        <a href="kontak.php" class="btn btn-light btn-lg px-5 py-3 fw-bold">
            <i class="fas fa-phone me-2"></i>Hubungi Kami
        </a>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>