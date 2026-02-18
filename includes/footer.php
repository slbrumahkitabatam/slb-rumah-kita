<!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="mb-3"><?php echo htmlspecialchars($pengaturan['nama_sekolah']); ?></h5>
                    <p class="text-white-50">
                        SLB Rumah Kita Batam adalah sekolah luar biasa yang berdedikasi untuk memberikan pendidikan berkualitas bagi anak-anak berkebutuhan khusus.
                    </p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="mb-3">Link Cepat</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.php"><i class="fas fa-chevron-right me-2"></i>Beranda</a></li>
                        <li><a href="profil.php"><i class="fas fa-chevron-right me-2"></i>Profil</a></li>
                        <li><a href="berita.php"><i class="fas fa-chevron-right me-2"></i>Berita</a></li>
                        <li><a href="program.php"><i class="fas fa-chevron-right me-2"></i>Program</a></li>
                        <li><a href="galeri.php"><i class="fas fa-chevron-right me-2"></i>Galeri</a></li>
                        <li><a href="kontak.php"><i class="fas fa-chevron-right me-2"></i>Kontak</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="mb-3">Hubungi Kami</h5>
                    <ul class="list-unstyled text-white-50">
                        <li class="mb-2">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            <?php echo nl2br(htmlspecialchars($pengaturan['alamat'])); ?>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-phone me-2"></i>
                            <?php echo htmlspecialchars($pengaturan['telepon']); ?>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-envelope me-2"></i>
                            <?php echo htmlspecialchars($pengaturan['email']); ?>
                        </li>
                    </ul>
                    <div class="mt-3">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-youtube fa-lg"></i></a>
                    </div>
                </div>
            </div>
            <hr class="mt-4 mb-4">
            <div class="row">
                <div class="col-md-12 text-center">
                    <p class="mb-0 text-white-50">&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($pengaturan['nama_sekolah']); ?>. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Smooth scroll untuk link anchor
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('shadow-lg');
            } else {
                navbar.classList.remove('shadow-lg');
            }
        });
    </script>
</body>
</html>