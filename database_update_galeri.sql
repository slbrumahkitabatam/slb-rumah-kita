-- Update tabel galeri untuk menambahkan kategori
ALTER TABLE galeri ADD COLUMN kategori VARCHAR(100) NOT NULL DEFAULT 'kegiatan';

-- Insert contoh data galeri untuk 5 kategori menarik

-- 1. Galeri Kegiatan Belajar Mengajar
INSERT INTO galeri (judul, deskripsi, gambar, tanggal, kategori) VALUES 
('Siswa Belajar Membaca', 'Siswa kelas SDLB sedang belajar membaca dengan metode yang menyenangkan', 'kbm1.jpg', '2025-01-15', 'kbm'),
('Praktik Melukis', 'Kegiatan melukis siswa kelas SMALB dalam seni rupa', 'kbm2.jpg', '2025-01-18', 'kbm'),
('Belajar Komputer', 'Siswa berlatih menggunakan komputer di lab komputer sekolah', 'kbm3.jpg', '2025-01-20', 'kbm'),
('Pelajaran Matematika', 'Siswa SDLB belajar berhitung dengan alat peraga', 'kbm4.jpg', '2025-01-22', 'kbm'),
('Membaca Al-Quran', 'Kegiatan membaca Al-Quran bagi siswa muslim', 'kbm5.jpg', '2025-01-25', 'kbm');

-- 2. Galeri Ekstrakurikuler
INSERT INTO galeri (judul, deskripsi, gambar, tanggal, kategori) VALUES 
('Olahraga Basket', 'Tim basket sekolah sedang berlatih', 'eskul1.jpg', '2025-02-01', 'eskul'),
('Seni Tari', 'Latihan tari tradisional siswi', 'eskul2.jpg', '2025-02-03', 'eskul'),
('Paduan Suara', 'Latihan menyanyi paduan suara', 'eskul3.jpg', '2025-02-05', 'eskul'),
('Kerajinan Tangan', 'Siswa membuat kerajinan tangan dari barang bekas', 'eskul4.jpg', '2025-02-08', 'eskul'),
('Bercocok Tanam', 'Kegiatan bercocok tanam di kebun sekolah', 'eskul5.jpg', '2025-02-10', 'eskul');

-- 3. Galeri Prestasi Siswa
INSERT INTO galeri (judul, deskripsi, gambar, tanggal, kategori) VALUES 
('Juara 1 Lomba Melukis', 'Siswa kami meraih juara 1 lomba melukis tingkat kota', 'prestasi1.jpg', '2025-03-01', 'prestasi'),
('Medali Emas Olimpiade', 'Peraih medali emas Olimpiade Matematika Khusus', 'prestasi2.jpg', '2025-03-05', 'prestasi'),
('Juara Lomba Paduan Suara', 'Tim paduan suara meraih juara 2 tingkat provinsi', 'prestasi3.jpg', '2025-03-10', 'prestasi'),
('Siswa Berprestasi', 'Penghargaan siswa berprestasi tahun ajaran 2024/2025', 'prestasi4.jpg', '2025-03-15', 'prestasi'),
('Juara Basket', 'Tim basket sekolah juara 2 turnamen kota', 'prestasi5.jpg', '2025-03-20', 'prestasi');

-- 4. Galeri Kegiatan Sekolah
INSERT INTO galeri (judul, deskripsi, gambar, tanggal, kategori) VALUES 
('Perayaan Hari Kemerdekaan', 'Upacara peringatan Hari Kemerdekaan RI ke-80', 'kegiatan1.jpg', '2025-08-17', 'kegiatan'),
('Ulang Tahun Sekolah', 'Perayaan ulang tahun ke-10 SLB Rumah Kita', 'kegiatan2.jpg', '2025-09-01', 'kegiatan'),
('Kunjungan Studi Banding', 'Kunjungan dari SLB se-Kota Batam', 'kegiatan3.jpg', '2025-10-15', 'kegiatan'),
('Baksos Pengobatan Gratis', 'Bakti sosial pengobatan gratis untuk masyarakat', 'kegiatan4.jpg', '2025-11-20', 'kegiatan'),
('Wisuda Siswa', 'Wisuda siswa SMALB tahun ajaran 2024/2025', 'kegiatan5.jpg', '2025-12-10', 'kegiatan');

-- 5. Galeri Fasilitas Sekolah
INSERT INTO galeri (judul, deskripsi, gambar, tanggal, kategori) VALUES 
('Ruang Kelas SDLB', 'Ruang kelas yang nyaman untuk pembelajaran', 'fasilitas1.jpg', '2025-01-01', 'fasilitas'),
('Laboratorium Komputer', 'Lab komputer lengkap dengan 20 unit', 'fasilitas2.jpg', '2025-01-01', 'fasilitas'),
('Ruang Terapi', 'Ruang terapi untuk kebutuhan khusus siswa', 'fasilitas3.jpg', '2025-01-01', 'fasilitas'),
('Perpustakaan', 'Perpustakaan dengan koleksi buku lengkap', 'fasilitas4.jpg', '2025-01-01', 'fasilitas'),
('Lapangan Olahraga', 'Lapangan basket dan voli untuk kegiatan olahraga', 'fasilitas5.jpg', '2025-01-01', 'fasilitas');