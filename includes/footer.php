<?php
require_once 'config/database.php';

// Ambil pengaturan sekolah
$pengaturan = fetchOne("SELECT * FROM pengaturan WHERE id = 1");

// Ambil pengaturan tampilan (warna, font, dll)
$tampilan = fetchOne("SELECT * FROM tampilan WHERE id = 1");
?>

<!-- Footer -->
<style>
    /* Modern Footer Styles */
    :root {
        --footer-primary: <?php echo $tampilan['warna_utama'] ?? '#4A90E2'; ?>;
        --footer-secondary: <?php echo $tampilan['warna_utama'] ?? '#4A90E2'; ?>;
        --footer-accent: #F5A623;
    }

    .footer {
        background: linear-gradient(135deg, var(--footer-primary) 0%, <?php 
            $primaryColor = $tampilan['warna_utama'] ?? '#4A90E2';
            // Darken the color for gradient effect
            $r = hexdec(substr($primaryColor, 1, 2));
            $g = hexdec(substr($primaryColor, 3, 2));
            $b = hexdec(substr($primaryColor, 5, 2));
            $r = max(0, $r - 30);
            $g = max(0, $g - 30);
            $b = max(0, $b - 30);
            echo sprintf('#%02X%02X%02X', $r, $g, $b);
        ?> 100%);
        color: #ffffff;
        padding: 80px 0 30px 0;
        position: relative;
        overflow: hidden;
    }

    .footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        pointer-events: none;
    }

    .footer h5 {
        font-weight: 700;
        font-size: 1.3rem;
        margin-bottom: 1.5rem;
        position: relative;
        display: inline-block;
    }

    .footer h5::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -10px;
        width: 50px;
        height: 3px;
        background: linear-gradient(90deg, #FFD700, #FFA500);
        border-radius: 3px;
        transition: width 0.3s ease;
    }

    .footer h5:hover::after {
        width: 100%;
    }

    .footer p {
        line-height: 1.8;
        color: rgba(255, 255, 255, 0.9);
    }

    .footer ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer ul li {
        margin-bottom: 0.8rem;
    }

    .footer a {
        color: rgba(255, 255, 255, 0.85);
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        font-size: 0.95rem;
    }

    .footer a:hover {
        color: #FFD700;
        transform: translateX(8px);
    }

    .footer .social-icons {
        display: flex;
        gap: 15px;
        margin-top: 1.5rem;
    }

    .footer .social-icons a {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        transform: translateX(0);
    }

    .footer .social-icons a:hover {
        background: #FFD700;
        color: var(--footer-primary);
        transform: translateY(-5px) scale(1.1);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    .footer .contact-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 1rem;
        color: rgba(255, 255, 255, 0.9);
    }

    .footer .contact-item i {
        color: #FFD700;
        margin-top: 5px;
        margin-right: 12px;
        font-size: 1.1rem;
    }

    .footer hr {
        border-color: rgba(255, 255, 255, 0.2);
        margin: 40px 0;
    }

    .footer .copyright {
        padding-top: 20px;
        color: rgba(255, 255, 255, 0.8);
    }

    .footer .copyright a {
        color: #FFD700;
        font-weight: 600;
    }

    .footer .copyright a:hover {
        color: #fff;
    }

    /* Back to top button */
    .back-to-top {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--footer-primary) 0%, <?php 
            $primaryColor = $tampilan['warna_utama'] ?? '#4A90E2';
            $r = hexdec(substr($primaryColor, 1, 2));
            $g = hexdec(substr($primaryColor, 3, 2));
            $b = hexdec(substr($primaryColor, 5, 2));
            $r = max(0, $r - 30);
            $g = max(0, $g - 30);
            $b = max(0, $b - 30);
            echo sprintf('#%02X%02X%02X', $r, $g, $b);
        ?> 100%);
        color: white;
        border: none;
        cursor: pointer;
        display: none;
        align-items: center;
        justify-content: center;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
        transition: all 0.3s ease;
        z-index: 9999;
    }

    .back-to-top:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
    }

    .back-to-top.show {
        display: flex;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .footer {
            padding: 60px 0 30px 0;
        }
        
        .footer h5::after {
            width: 30px;
        }
    }
</style>

<footer class="footer">
        <div class="container position-relative">
            <div class="row">
                <!-- School Info -->
                <div class="col-lg-4 col-md-6 mb-5">
                    <div class="footer-about">
                        <h5><?php echo htmlspecialchars($pengaturan['nama_sekolah']); ?></h5>
                        <p class="mt-4">
                            SLB Rumah Kita Batam adalah sekolah luar biasa yang berdedikasi untuk memberikan pendidikan berkualitas bagi anak-anak berkebutuhan khusus. Kami berkomitmen membantu setiap siswa mencapai potensi terbaik mereka.
                        </p>
                        <div class="social-icons">
                            <a href="#" title="Facebook" data-bs-toggle="tooltip" data-bs-placement="top">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" title="Instagram" data-bs-toggle="tooltip" data-bs-placement="top">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" title="YouTube" data-bs-toggle="tooltip" data-bs-placement="top">
                                <i class="fab fa-youtube"></i>
                            </a>
                            <a href="#" title="Twitter" data-bs-toggle="tooltip" data-bs-placement="top">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-4 col-md-6 mb-5">
                    <div class="footer-links">
                        <h5>Link Cepat</h5>
                        <ul class="mt-4">
                            <li>
                                <a href="index.php">
                                    <i class="fas fa-chevron-right me-2" style="font-size: 0.7rem; color: #ffd700;"></i>
                                    Beranda
                                </a>
                            </li>
                            <li>
                                <a href="profil.php">
                                    <i class="fas fa-chevron-right me-2" style="font-size: 0.7rem; color: #ffd700;"></i>
                                    Profil Sekolah
                                </a>
                            </li>
                            <li>
                                <a href="berita.php">
                                    <i class="fas fa-chevron-right me-2" style="font-size: 0.7rem; color: #ffd700;"></i>
                                    Berita & Kegiatan
                                </a>
                            </li>
                            <li>
                                <a href="program.php">
                                    <i class="fas fa-chevron-right me-2" style="font-size: 0.7rem; color: #ffd700;"></i>
                                    Program Unggulan
                                </a>
                            </li>
                            <li>
                                <a href="galeri.php">
                                    <i class="fas fa-chevron-right me-2" style="font-size: 0.7rem; color: #ffd700;"></i>
                                    Galeri Foto
                                </a>
                            </li>
                            <li>
                                <a href="kontak.php">
                                    <i class="fas fa-chevron-right me-2" style="font-size: 0.7rem; color: #ffd700;"></i>
                                    Hubungi Kami
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="col-lg-4 col-md-6 mb-5">
                    <div class="footer-contact">
                        <h5>Hubungi Kami</h5>
                        <div class="mt-4">
                            <div class="contact-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <div>
                                    <strong>Alamat:</strong><br>
                                    <?php echo nl2br(htmlspecialchars($pengaturan['alamat'])); ?>
                                </div>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-phone-alt"></i>
                                <div>
                                    <strong>Telepon:</strong><br>
                                    <a href="tel:<?php echo htmlspecialchars($pengaturan['telepon']); ?>" style="margin-left: 0;">
                                        <?php echo htmlspecialchars($pengaturan['telepon']); ?>
                                    </a>
                                </div>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-envelope"></i>
                                <div>
                                    <strong>Email:</strong><br>
                                    <a href="mailto:<?php echo htmlspecialchars($pengaturan['email']); ?>" style="margin-left: 0;">
                                        <?php echo htmlspecialchars($pengaturan['email']); ?>
                                    </a>
                                </div>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-clock"></i>
                                <div>
                                    <strong>Jam Operasional:</strong><br>
                                    Senin - Jumat: 07:30 - 16:00
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-5">

            <!-- Copyright -->
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="copyright">
                        <p class="mb-0">
                            &copy; <?php echo date('Y'); ?> <a href="#"><?php echo htmlspecialchars($pengaturan['nama_sekolah']); ?></a>. 
                            All rights reserved. | Dibuat dengan <i class="fas fa-heart text-danger" style="animation: heartbeat 1.5s ease infinite;"></i> untuk pendidikan inklusif
                        </p>
                        <style>
                            @keyframes heartbeat {
                                0%, 100% { transform: scale(1); }
                                50% { transform: scale(1.2); }
                            }
                        </style>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back to Top Button -->
        <button class="back-to-top" id="backToTop" title="Kembali ke atas">
            <i class="fas fa-arrow-up"></i>
        </button>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Smooth scroll untuk link anchor
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href !== '#' && document.querySelector(href)) {
                    e.preventDefault();
                    document.querySelector(href).scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (navbar) {
                if (window.scrollY > 50) {
                    navbar.classList.add('shadow-lg');
                } else {
                    navbar.classList.remove('shadow-lg');
                }
            }

            // Back to top button
            const backToTop = document.getElementById('backToTop');
            if (backToTop) {
                if (window.scrollY > 300) {
                    backToTop.classList.add('show');
                } else {
                    backToTop.classList.remove('show');
                }
            }
        });

        // Back to top functionality
        const backToTop = document.getElementById('backToTop');
        if (backToTop) {
            backToTop.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }

        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
        });
    </script>
</body>
</html>