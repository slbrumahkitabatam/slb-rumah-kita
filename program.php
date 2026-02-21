<?php
$pageTitle = 'Program & Layanan';
require_once 'includes/header.php';
?>
<style>
/* Elegant Header Section */
.elegant-header-section {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
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

/* Elegant CTA Section */
.cta-section {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    position: relative;
    overflow: hidden;
    min-height: 450px;
    display: flex;
    align-items: center;
}

.cta-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    opacity: 0.3;
}

.cta-icon {
    width: 120px;
    height: 120px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    font-size: 4rem;
    color: white;
    backdrop-filter: blur(10px);
    border: 3px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    animation: pulse-cta 3s infinite;
    position: relative;
    z-index: 2;
}

@keyframes pulse-cta {
    0%, 100% {
        transform: scale(1);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    }
    50% {
        transform: scale(1.1);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }
}

.animate-title-cta {
    font-size: 3.5rem;
    font-weight: 800;
    letter-spacing: -1px;
    text-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
    animation: fadeInUp-cta 0.8s ease-out 0.2s both;
}

.animate-subtitle-cta {
    font-size: 1.4rem;
    font-weight: 400;
    letter-spacing: 0.5px;
    animation: fadeInUp-cta 0.8s ease-out 0.4s both;
}

.animate-buttons-cta {
    animation: fadeInUp-cta 0.8s ease-out 0.6s both;
}

@keyframes fadeInUp-cta {
    from {
        opacity: 0;
        transform: translateY(40px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.cta-primary {
    background: white !important;
    color: var(--primary-color) !important;
    border: none !important;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.cta-primary::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    transition: width 0.6s ease, height 0.6s ease;
}

.cta-primary:hover::before {
    width: 300px;
    height: 300px;
}

.cta-primary:hover {
    transform: translateY(-5px) scale(1.05);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
}

.cta-primary:active {
    transform: translateY(-2px) scale(0.98);
}

.cta-secondary {
    background: transparent !important;
    border: 2px solid white !important;
    color: white !important;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    backdrop-filter: blur(5px);
}

.cta-secondary:hover {
    background: rgba(255, 255, 255, 0.1) !important;
    transform: translateY(-5px) scale(1.05);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
}

.cta-secondary:active {
    transform: translateY(-2px) scale(0.98);
}

.cta-decorative-shape {
    position: absolute;
    border-radius: 50%;
    opacity: 0.15;
}

.cta-decorative-shape.shape-1 {
    width: 400px;
    height: 400px;
    background: white;
    top: -150px;
    right: -150px;
    animation: morph-cta 20s infinite;
}

.cta-decorative-shape.shape-2 {
    width: 300px;
    height: 300px;
    background: white;
    bottom: -100px;
    left: 15%;
    animation: morph-cta 25s infinite reverse;
}

.cta-decorative-shape.shape-3 {
    width: 200px;
    height: 200px;
    background: white;
    top: 40%;
    right: 5%;
    animation: morph-cta 15s infinite;
}

@keyframes morph-cta {
    0%, 100% {
        border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
    }
    50% {
        border-radius: 30% 60% 70% 40% / 50% 60% 30% 60%;
    }
}

.cta-floating-icon {
    position: absolute;
    width: 70px;
    height: 70px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    color: white;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.4);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
}

.cta-floating-icon.float-1 {
    top: 30px;
    left: 40px;
    animation: float-cta 4s ease-in-out infinite;
}

.cta-floating-icon.float-2 {
    top: 80px;
    right: 60px;
    animation: float-cta 4s ease-in-out infinite 1.3s;
}

.cta-floating-icon.float-3 {
    bottom: 60px;
    left: 100px;
    animation: float-cta 4s ease-in-out infinite 2.6s;
}

@keyframes float-cta {
    0%, 100% {
        transform: translateY(0) rotate(0deg);
    }
    50% {
        transform: translateY(-20px) rotate(10deg);
    }
}

@media (max-width: 991.98px) {
    .cta-section {
        min-height: 400px;
    }
    
    .cta-icon {
        width: 100px;
        height: 100px;
        font-size: 3rem;
    }
    
    .animate-title-cta {
        font-size: 2.5rem;
    }
    
    .animate-subtitle-cta {
        font-size: 1.2rem;
    }
}

@media (max-width: 575.98px) {
    .cta-section {
        min-height: 350px;
    }
    
    .cta-icon {
        width: 80px;
        height: 80px;
        font-size: 2.5rem;
    }
    
    .animate-title-cta {
        font-size: 2rem;
    }
    
    .animate-subtitle-cta {
        font-size: 1rem;
    }
    
    .cta-buttons {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
    }
    
    .cta-primary,
    .cta-secondary {
        margin: 0 !important;
        width: 100%;
        max-width: 300px;
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
                        <i class="fas fa-graduation-cap me-2"></i>Program & Layanan
                    </span>
                </div>
                <h1 class="fw-bold mb-4 text-white animate-title">
                    Program Pendidikan & Layanan Khusus
                </h1>
                <p class="lead text-white-50 mb-4 animate-subtitle">
                    Program pendidikan berkualitas dan layanan khusus untuk siswa berkebutuhan khusus
                </p>
                <div class="header-features mt-4">
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <div class="feature-item" role="button" tabindex="0" onclick="handleFeatureClick(this)" onkeypress="handleFeatureKeypress(event, this)">
                            <i class="fas fa-check-circle text-success"></i>
                            <span class="text-white">Pendidikan Berkualitas</span>
                        </div>
                        <div class="feature-item" role="button" tabindex="0" onclick="handleFeatureClick(this)" onkeypress="handleFeatureKeypress(event, this)">
                            <i class="fas fa-check-circle text-success"></i>
                            <span class="text-white">Layanan Terapi</span>
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
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="floating-icon icon-1">
                        <i class="fas fa-book-reader"></i>
                    </div>
                    <div class="floating-icon icon-2">
                        <i class="fas fa-heart"></i>
                    </div>
                    <div class="floating-icon icon-3">
                        <i class="fas fa-hands-helping"></i>
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
                    <h5>Mesjid</h5>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section position-relative overflow-hidden">
    <div class="container position-relative">
        <div class="row align-items-center py-5">
            <div class="col-lg-8 mx-auto text-center">
                <div class="cta-icon mb-4">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h2 class="fw-bold mb-4 text-white animate-title-cta">Ingin Mendaftar?</h2>
                <p class="lead text-white-75 mb-5 animate-subtitle-cta">
                    Hubungi kami untuk informasi pendaftaran dan jadwal kunjungan
                </p>
                <div class="cta-buttons animate-buttons-cta">
                    <a href="kontak.php" class="btn btn-light btn-lg px-5 py-3 fw-bold me-3 mb-3 cta-primary">
                        <i class="fas fa-phone me-2"></i>Hubungi Kami
                    </a>
                    <a href="kontak.php" class="btn btn-outline-light btn-lg px-5 py-3 fw-bold mb-3 cta-secondary">
                        <i class="fas fa-calendar me-2"></i>Jadwalkan Kunjungan
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Decorative Floating Elements -->
    <div class="cta-decorative-shape shape-1"></div>
    <div class="cta-decorative-shape shape-2"></div>
    <div class="cta-decorative-shape shape-3"></div>
    <div class="cta-floating-icon float-1">
        <i class="fas fa-star"></i>
    </div>
    <div class="cta-floating-icon float-2">
        <i class="fas fa-award"></i>
    </div>
    <div class="cta-floating-icon float-3">
        <i class="fas fa-heart"></i>
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
