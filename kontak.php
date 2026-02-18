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

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="bg-light py-3">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Kontak</li>
        </ol>
    </div>
</nav>

<!-- Header -->
<section class="py-5 bg-primary text-white text-center">
    <div class="container">
        <h1 class="fw-bold mb-3">Hubungi Kami</h1>
        <p class="lead">Kami siap membantu dan menjawab pertanyaan Anda</p>
    </div>
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

<!-- Google Maps -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center mb-5">Lokasi Kami</h2>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-0">
                        <!-- Google Maps Placeholder - Ganti dengan embed Google Maps yang sebenarnya -->
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.123456789!2d103.959445!3d1.141689!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMcKwMDUnMzAuMyJOIDEwM8KwNTcnMzMuOCJF!5e0!3m2!1sen!2sid!4v1234567890123"
                            width="100%" 
                            height="400" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title text-center mb-5">Pertanyaan Umum (FAQ)</h2>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                Bagaimana cara mendaftar di sekolah ini?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Untuk mendaftar, silakan hubungi kami melalui telepon atau email untuk menjadwalkan kunjungan dan mendapatkan formulir pendaftaran. Kami akan membimbing Anda melalui proses pendaftaran.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                Apakah ada biaya pendidikan?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Biaya pendidikan bervariasi tergantung program yang diikuti. Kami menyediakan informasi lengkap mengenai biaya saat kunjungan pendaftaran.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                Apa syarat pendaftaran?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Syarat pendaftaran meliputi: akta kelahiran, kartu keluarga, surat keterangan dari dokter/psikolog, dan foto berwarna. Dokumentasi tambahan mungkin diperlukan sesuai kebutuhan.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                Apakah ada program beasiswa?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Ya, kami menyediakan beberapa program bantuan untuk siswa yang membutuhkan. Hubungi kami untuk informasi lebih lanjut mengenai program bantuan yang tersedia.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>