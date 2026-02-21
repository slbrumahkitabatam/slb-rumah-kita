<?php
$pageTitle = 'Kontak Kami';
require_once 'includes/header.php';

// Process form submission
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = htmlspecialchars($_POST['nama'] ?? '');
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars($_POST['subject'] ?? '');
    $pesan = htmlspecialchars($_POST['pesan'] ?? '');
    
    if ($nama && $email && $subject && $pesan) {
        // Di sini bisa ditambahkan logika untuk menyimpan ke database atau mengirim email
        $message = 'Pesan Anda telah berhasil dikirim. Kami akan segera menghubungi Anda.';
        $messageType = 'success';
    } else {
        $message = 'Mohon lengkapi semua field yang diperlukan.';
        $messageType = 'danger';
    }
}
?>

<!-- Elegant Header Section -->
<section class="elegant-header-section position-relative overflow-hidden">
    <div class="container position-relative">
        <div class="row align-items-center py-5">
            <div class="col-lg-8">
                <div class="header-badge mb-4">
                    <span class="badge bg-light text-primary">
                        <i class="fas fa-envelope me-2"></i>Kontak Kami
                    </span>
                </div>
                <h1 class="fw-bold mb-4 text-white animate-title">
                    Hubungi Kami
                </h1>
                <p class="lead text-white-50 mb-4 animate-subtitle">
                    Kami siap membantu dan menjawab pertanyaan Anda
                </p>
                <div class="header-features mt-4">
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <div class="feature-item" role="button" tabindex="0" onclick="handleFeatureClick(this)" onkeypress="handleFeatureKeypress(event, this)">
                            <i class="fas fa-check-circle text-success"></i>
                            <span class="text-white">Respon Cepat</span>
                        </div>
                        <div class="feature-item" role="button" tabindex="0" onclick="handleFeatureClick(this)" onkeypress="handleFeatureKeypress(event, this)">
                            <i class="fas fa-check-circle text-success"></i>
                            <span class="text-white">Layanan Terbaik</span>
                        </div>
                        <div class="feature-item" role="button" tabindex="0" onclick="handleFeatureClick(this)" onkeypress="handleFeatureKeypress(event, this)">
                            <i class="fas fa-check-circle text-success"></i>
                            <span class="text-white">Solusi Tepat</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-center d-none d-lg-block">
                <div class="header-icon-container">
                    <div class="icon-circle-main">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="floating-icon icon-1">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div class="floating-icon icon-2">
                        <i class="fas fa-comments"></i>
                    </div>
                    <div class="floating-icon icon-3">
                        <i class="fas fa-handshake"></i>
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

<!-- Contact Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Contact Info -->
            <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="contact-info mb-4">
                    <h4 class="mb-4"><i class="fas fa-info-circle me-2"></i>Informasi Kontak</h4>
                    <div class="mb-4">
                        <p class="mb-2"><strong><i class="fas fa-building me-2"></i>Nama Sekolah</strong></p>
                        <p><?php echo htmlspecialchars($pengaturan['nama_sekolah']); ?></p>
                    </div>
                    <div class="mb-4">
                        <p class="mb-2"><strong><i class="fas fa-map-marker-alt me-2"></i>Alamat</strong></p>
                        <p><?php echo nl2br(htmlspecialchars($pengaturan['alamat'])); ?></p>
                    </div>
                    <div class="mb-4">
                        <p class="mb-2"><strong><i class="fas fa-phone me-2"></i>Telepon</strong></p>
                        <p><?php echo htmlspecialchars($pengaturan['telepon']); ?></p>
                    </div>
                    <div class="mb-4">
                        <p class="mb-2"><strong><i class="fas fa-envelope me-2"></i>Email</strong></p>
                        <p><?php echo htmlspecialchars($pengaturan['email']); ?></p>
                    </div>
                    <div>
                        <p class="mb-2"><strong><i class="fas fa-clock me-2"></i>Jam Operasional</strong></p>
                        <p>Senin - Jumat: 08.00 - 16.00<br>Sabtu: 08.00 - 12.00</p>
                    </div>
                </div>
                
                <!-- Social Media -->
                <div class="card shadow-sm">
                    <div class="card-body p-4 text-center">
                        <h5 class="mb-3">Ikuti Kami</h5>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="#" class="btn btn-primary btn-circle rounded-circle" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                <i class="fab fa-facebook-f fa-lg"></i>
                            </a>
                            <a href="#" class="btn btn-info btn-circle rounded-circle" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                <i class="fab fa-instagram fa-lg"></i>
                            </a>
                            <a href="#" class="btn btn-danger btn-circle rounded-circle" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                <i class="fab fa-youtube fa-lg"></i>
                            </a>
                            <a href="#" class="btn btn-success btn-circle rounded-circle" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                <i class="fab fa-whatsapp fa-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Contact Form -->
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h4 class="mb-4"><i class="fas fa-paper-plane me-2"></i>Kirim Pesan</h4>
                        
                        <?php if ($message): ?>
                            <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                                <?php echo $message; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST" action="">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama" name="nama" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subjek <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="subject" name="subject" required>
                            </div>
                            <div class="mb-3">
                                <label for="pesan" class="form-label">Pesan <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="pesan" name="pesan" rows="5" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>Kirim Pesan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Google Maps Section -->
<section class="location-section py-5 position-relative overflow-hidden">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="location-info">
                    <div class="location-badge mb-4">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h2 class="fw-bold mb-4 text-white">Lokasi Kami</h2>
                    <p class="text-white-75 mb-4">
                        Kunjungi sekolah kami untuk melihat langsung fasilitas dan lingkungan belajar yang nyaman
                    </p>
                    <div class="location-details">
                        <div class="detail-item mb-3">
                            <i class="fas fa-building"></i>
                            <div>
                                <strong class="text-white">Nama Sekolah</strong>
                                <p class="text-white-75 mb-0"><?php echo htmlspecialchars($pengaturan['nama_sekolah']); ?></p>
                            </div>
                        </div>
                        <div class="detail-item mb-3">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <strong class="text-white">Alamat</strong>
                                <p class="text-white-75 mb-0"><?php echo nl2br(htmlspecialchars($pengaturan['alamat'])); ?></p>
                            </div>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-clock"></i>
                            <div>
                                <strong class="text-white">Jam Operasional</strong>
                                <p class="text-white-75 mb-0">Senin - Jumat: 08.00 - 16.00<br>Sabtu: 08.00 - 12.00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="map-card shadow-lg">
                    <div class="map-header">
                        <i class="fas fa-map-marked-alt"></i>
                        <span>Peta Lokasi</span>
                    </div>
                    <div class="map-container">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d433.8480841903853!2d103.9460378250045!3d1.1068307360812069!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d98b647bf2c25b%3A0x937c4300e782282a!2sSLB%20Kartini!5e1!3m2!1sid!2sid!4v1771427126569!5m2!1sid!2sid" 
                            width="100%" 
                            height="450" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <div class="faq-badge mb-4">
                <i class="fas fa-question-circle"></i>
            </div>
            <h2 class="fw-bold mb-3" style="color: var(--primary-color);">Pertanyaan Umum (FAQ)</h2>
            <p class="text-muted">Jawaban untuk pertanyaan yang sering diajukan</p>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="faq-container">
                    <div class="faq-item">
                        <div class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="true">
                            <div class="faq-icon">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div class="faq-content">
                                <h4 class="mb-0">Bagaimana cara mendaftar di sekolah ini?</h4>
                            </div>
                            <div class="faq-arrow">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                        <div id="faq1" class="faq-answer collapse show" data-bs-parent="#faqAccordion">
                            <div class="faq-answer-content">
                                <p class="mb-0">
                                    Untuk mendaftar, silakan hubungi kami melalui telepon atau email untuk menjadwalkan kunjungan dan mendapatkan formulir pendaftaran. Kami akan membimbing Anda melalui proses pendaftaran dengan baik dan benar.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="faq-item">
                        <div class="faq-question collapsed" data-bs-toggle="collapse" data-bs-target="#faq2" aria-expanded="false">
                            <div class="faq-icon">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <div class="faq-content">
                                <h4 class="mb-0">Apakah ada biaya pendidikan?</h4>
                            </div>
                            <div class="faq-arrow">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                        <div id="faq2" class="faq-answer collapse" data-bs-parent="#faqAccordion">
                            <div class="faq-answer-content">
                                <p class="mb-0">
                                    Biaya pendidikan bervariasi tergantung program yang diikuti. Kami menyediakan informasi lengkap mengenai biaya saat kunjungan pendaftaran. Biaya bisa dibayar dengan cicilan yang fleksibel.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="faq-item">
                        <div class="faq-question collapsed" data-bs-toggle="collapse" data-bs-target="#faq3" aria-expanded="false">
                            <div class="faq-icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div class="faq-content">
                                <h4 class="mb-0">Apa syarat pendaftaran?</h4>
                            </div>
                            <div class="faq-arrow">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                        <div id="faq3" class="faq-answer collapse" data-bs-parent="#faqAccordion">
                            <div class="faq-answer-content">
                                <p class="mb-0">
                                    Syarat pendaftaran meliputi: akta kelahiran, kartu keluarga, surat keterangan dari dokter/psikolog, dan foto berwarna. Dokumentasi tambahan mungkin diperlukan sesuai kebutuhan spesifik.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="faq-item">
                        <div class="faq-question collapsed" data-bs-toggle="collapse" data-bs-target="#faq4" aria-expanded="false">
                            <div class="faq-icon">
                                <i class="fas fa-hand-holding-heart"></i>
                            </div>
                            <div class="faq-content">
                                <h4 class="mb-0">Apakah ada program beasiswa?</h4>
                            </div>
                            <div class="faq-arrow">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                        <div id="faq4" class="faq-answer collapse" data-bs-parent="#faqAccordion">
                            <div class="faq-answer-content">
                                <p class="mb-0">
                                    Ya, kami menyediakan beberapa program bantuan untuk siswa yang membutuhkan. Hubungi kami untuk informasi lebih lanjut mengenai program bantuan yang tersedia.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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

/* Location Section */
.location-section {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    position: relative;
    overflow: hidden;
}

.location-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    opacity: 0.3;
}

.location-info {
    position: relative;
    z-index: 2;
}

.location-badge {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: white;
    backdrop-filter: blur(10px);
    border: 3px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    animation: pulse-location 3s infinite;
}

@keyframes pulse-location {
    0%, 100% {
        transform: scale(1);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }
    50% {
        transform: scale(1.05);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
    }
}

.location-details {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    padding: 25px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.detail-item {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    padding: 15px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 12px;
    transition: all 0.3s ease;
}

@media (hover: hover) {
    .detail-item:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateX(5px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
    }
}

.detail-item i {
    font-size: 1.5rem;
    color: white;
    flex-shrink: 0;
}

.map-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    position: relative;
    z-index: 2;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
}

.map-header {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    color: white;
    font-weight: 600;
    font-size: 1.1rem;
}

.map-header i {
    font-size: 1.5rem;
}

.map-container {
    position: relative;
}

.map-container iframe {
    filter: grayscale(0);
    transition: filter 0.3s ease;
}

@media (hover: hover) {
    .map-card:hover .map-container iframe {
        filter: grayscale(0.1);
    }
}

/* FAQ Section */
.faq-section {
    background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);
}

.faq-badge {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: white;
    margin: 0 auto;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    animation: pulse-faq 3s infinite;
}

@keyframes pulse-faq {
    0%, 100% {
        transform: scale(1);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }
    50% {
        transform: scale(1.05);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
    }
}

.faq-container {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.faq-item {
    border-bottom: 1px solid rgba(0, 0, 0, 0.08);
}

.faq-item:last-child {
    border-bottom: none;
}

.faq-question {
    padding: 25px;
    display: flex;
    align-items: center;
    gap: 20px;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.faq-question::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.faq-question[aria-expanded="true"]::before {
    opacity: 0.1;
}

@media (hover: hover) {
    .faq-question:hover::before {
        opacity: 0.05;
    }
    
    .faq-question:hover .faq-icon {
        transform: scale(1.1) rotate(5deg);
    }
    
    .faq-question:hover .faq-arrow i {
        transform: translateY(3px);
    }
}

.faq-question[aria-expanded="true"] {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
}

.faq-question[aria-expanded="true"] .faq-icon {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.4);
}

.faq-question[aria-expanded="true"] h4 {
    color: white !important;
}

.faq-question[aria-expanded="true"] .faq-arrow i {
    color: white;
    transform: rotate(180deg);
}

.faq-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    flex-shrink: 0;
    transition: all 0.3s ease;
    position: relative;
    z-index: 1;
}

.faq-content {
    flex: 1;
    position: relative;
    z-index: 1;
}

.faq-content h4 {
    color: #2c3e50;
    font-weight: 600;
    transition: color 0.3s ease;
}

.faq-arrow {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    color: var(--primary-color);
    transition: all 0.3s ease;
    position: relative;
    z-index: 1;
}

.faq-arrow i {
    transition: transform 0.3s ease;
}

.faq-answer {
    background: #f8f9fa;
}

.faq-answer-content {
    padding: 0 25px 25px 25px;
}

.faq-answer-content p {
    color: #555;
    line-height: 1.8;
    margin-bottom: 0;
}

@media (max-width: 991.98px) {
    .location-section {
        text-align: center;
    }
    
    .location-details {
        text-align: left;
    }
    
    .location-badge {
        margin: 0 auto 20px;
    }
    
    .detail-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    
    .detail-item i {
        align-self: flex-start;
    }
    
    .faq-question {
        padding: 20px;
        gap: 15px;
    }
    
    .faq-icon {
        width: 50px;
        height: 50px;
        font-size: 1.3rem;
    }
    
    .faq-arrow {
        width: 35px;
        height: 35px;
        font-size: 1rem;
    }
    
    .faq-content h4 {
        font-size: 1rem;
    }
}

@media (max-width: 575.98px) {
    .location-section {
        padding: 40px 0;
    }
    
    .location-badge {
        width: 70px;
        height: 70px;
        font-size: 2rem;
    }
    
    .location-details {
        padding: 20px;
    }
    
    .detail-item {
        padding: 12px;
    }
    
    .faq-question {
        padding: 15px;
        gap: 12px;
    }
    
    .faq-icon {
        width: 45px;
        height: 45px;
        font-size: 1.2rem;
    }
    
    .faq-content h4 {
        font-size: 0.95rem;
    }
    
    .faq-answer-content {
        padding: 0 15px 15px 15px;
    }
}
</style>

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
