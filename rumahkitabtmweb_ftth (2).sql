-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 21, 2026 at 06:40 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rumahkitabtmweb_ftth`
--

--
-- Procedures
--

DELIMITER $$

DROP PROCEDURE IF EXISTS clean_security_tables$$

CREATE PROCEDURE clean_security_tables()
BEGIN
    -- Hapus login attempts lebih dari 24 jam
    DELETE FROM login_attempts 
    WHERE attempt_time < DATE_SUB(NOW(), INTERVAL 24 HOUR);

    -- Hapus security logs lebih dari 90 hari
    DELETE FROM security_logs 
    WHERE event_time < DATE_SUB(NOW(), INTERVAL 90 DAY);

    -- Hapus CSRF tokens yang sudah expired atau sudah digunakan
    DELETE FROM csrf_tokens 
    WHERE expires_at < NOW() OR used = 1;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `penulis` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `berita`
--

INSERT INTO `berita` (`id`, `judul`, `slug`, `isi`, `gambar`, `tanggal`, `penulis`, `created_at`) VALUES
(1, 'Pembukaan Program Pelatihan Keterampilan Vokasi untuk Siswa SLB', 'pembukaan-program-pelatihan-keterampilan-vokasi-untuk-siswa-slb', '<p>SLB Rumah Kita Batam dengan bangga mengumumkan pembukaan program pelatihan keterampilan vokasi baru untuk siswa-siswi kami. Program ini dirancang khusus untuk mengembangkan potensi siswa dalam berbagai bidang keterampilan.</p><p>Program pelatihan ini mencakup:</p><ul><li>Keterampilan komputer dan IT</li><li>Kerajinan tangan dan seni</li><li>Keterampilan tata boga</li><li>Keterampilan otomotif dasar</li></ul><p>Kami berharap program ini dapat membantu siswa kami menjadi lebih mandiri dan siap menghadapi tantangan di masa depan.</p>', '6999b2790ac84.png', '2025-01-10', 'Administrator', '2026-02-21 11:39:46'),
(2, 'Perayaan Hari Penyandang Disabilitas Internasional di SLB Rumah Kita', 'perayaan-hari-penyandang-disabilitas-internasional-di-slb-rumah-kita', '<p>SLB Rumah Kita Batam merayakan Hari Penyandang Disabilitas Internasional dengan berbagai kegiatan yang menarik dan bermakna. Acara ini dihadiri oleh seluruh siswa, guru, staf, serta orang tua siswa.</p><p>Acara yang diselenggarakan antara lain:</p><ul><li>Pentas seni siswa</li><li>Lomba kreativitas</li><li>Seminar parenting</li><li>Bazaar produk kerajinan siswa</li></ul><p>Melalui perayaan ini, kami ingin meningkatkan kesadaran masyarakat akan pentingnya inklusi dan kesetaraan bagi penyandang disabilitas.</p>', '6999d8bbeb849.webp', '2025-03-15', 'Administrator', '2026-02-21 11:39:46'),
(3, 'Kunjungan Studi Banding dari SLB Se-Kota Batam', 'kunjungan-studi-banding-dari-slb-se-kota-batam', '<p>SLB Rumah Kita Batam menerima kunjungan studi banding dari berbagai SLB se-Kota Batam. Kunjungan ini bertujuan untuk berbagi pengalaman dan praktik terbaik dalam pendidikan khusus.</p><p>Agenda kunjungan meliputi:</p><ul><li>Pembukaan dan sambutan kepala sekolah</li><li>Observasi kelas</li><li>Diskusi kurikulum</li><li>Presentasi program unggulan</li></ul><p>Kami sangat mengapresiasi kunjungan ini dan berharap dapat terus berkolaborasi untuk kemajuan pendidikan khusus di Batam.</p>', '6999b26c61899.png', '2025-02-20', 'Administrator', '2026-02-21 11:39:46'),
(4, 'Kunjungan Edukasi ke Museum Batam untuk Siswa SLB', 'kunjungan-edukasi-ke-museum-batam-untuk-siswa-slb', '<p>Siswa-siswi SLB Rumah Kita Batam melakukan kunjungan edukasi ke Museum Batam. Kunjungan ini merupakan bagian dari program pembelajaran luar kelas yang bertujuan untuk mengenalkan sejarah dan budaya Batam kepada siswa.</p><p>Selama kunjungan, siswa melakukan berbagai aktivitas:</p><ul><li>Observasi koleksi museum</li><li>Diskusi dengan pemandu museum</li><li>Kuis interaktif tentang sejarah</li><li>Dokumentasi pengalaman belajar</li></ul><p>Kunjungan ini sangat bermanfaat untuk mengembangkan wawasan siswa tentang sejarah daerah.</p>', '6999b27155f98.png', '2025-02-05', 'Administrator', '2026-02-21 11:39:46'),
(5, 'Siswa Kami Meraih Juara 1 Lomba Basket', 'siswa-kami-meraih-juara-1-lomba-basket', '<p>Prestasi membanggakan kembali diraih oleh siswa SLB Rumah Kita Batam. Tim basket sekolah berhasil meraih juara 1 dalam turnamen basket tingkat kota yang diselenggarakan baru-baru ini.</p><p>Tim basket kami menunjukkan semangat juang yang luar biasa dan kerjasama tim yang solid. Kemenangan ini merupakan hasil dari latihan keras dan dedikasi siswa serta pelatih.</p><p>Selamat kepada tim basket SLB Rumah Kita Batam! Teruslah berprestasi!</p>', '6999b266531be.png', '2025-03-01', 'Guru Basket', '2026-02-21 11:39:46'),
(6, 'Wisuda Siswa Angkatan Tahun Ajaran 2024/2025', 'wisuda-siswa-angkatan-tahun-ajaran-2024-2025', '<p>SLB Rumah Kita Batam dengan bangga menyelenggarakan acara wisuda untuk siswa angkatan tahun ajaran 2024/2025. Acara wisuda ini dihadiri oleh orang tua siswa, guru, staf, serta undangan.</p><p>Sebanyak 25 siswa dari jenjang SDLB, SMPLB, dan SMALB berhasil menyelesaikan pendidikan mereka di SLB Rumah Kita Batam. Mereka diharapkan dapat melanjutkan ke tahap selanjutnya dengan bekal ilmu dan keterampilan yang telah diperoleh.</p><p>Selamat kepada para wisudawan dan wisudawati! Semoga sukses di masa depan.</p>', '6999b1b55831e.jpg', '2025-06-20', 'Administrator', '2026-02-21 11:39:46');

-- --------------------------------------------------------

--
-- Table structure for table `csrf_tokens`
--

CREATE TABLE `csrf_tokens` (
  `id` int(11) NOT NULL,
  `token` varchar(64) NOT NULL,
  `session_id` varchar(128) NOT NULL,
  `created_at` datetime NOT NULL,
  `expires_at` datetime NOT NULL,
  `used` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `galeri`
--

CREATE TABLE `galeri` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `kategori` varchar(100) NOT NULL DEFAULT 'kegiatan',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `galeri`
--

INSERT INTO `galeri` (`id`, `judul`, `deskripsi`, `gambar`, `tanggal`, `kategori`, `created_at`) VALUES
(1, 'Siswa Belajar Membaca', 'Siswa kelas SDLB sedang belajar membaca dengan metode yang menyenangkan', 'Siswa Belajar Membaca.jpeg', '2025-01-15', 'kbm', '2026-02-21 11:39:46'),
(2, 'Praktik Melukis', 'Kegiatan melukis siswa kelas SMALB dalam seni rupa', 'Praktik Melukis.jpeg', '2025-01-18', 'kbm', '2026-02-21 11:39:46'),
(3, 'Belajar Komputer', 'Siswa berlatih menggunakan komputer di lab komputer sekolah', 'Belajar Komputer.jpeg', '2025-01-20', 'kbm', '2026-02-21 11:39:46'),
(4, 'Olahraga Basket', 'Tim basket sekolah sedang berlatih', 'Juara Basket.jpeg', '2025-02-01', 'eskul', '2026-02-21 11:39:46'),
(5, 'Seni Tari', 'Latihan tari tradisional siswi', 'lukis.jpg', '2025-02-03', 'eskul', '2026-02-21 11:39:46'),
(6, 'Paduan Suara', 'Latihan menyanyi paduan suara', 'lukis.jpg', '2025-02-05', 'eskul', '2026-02-21 11:39:46'),
(7, 'Perayaan Hari Kemerdekaan', 'Upacara peringatan Hari Kemerdekaan RI ke-80', 'Perayaan Hari Kemerdekaan.jpeg', '2025-08-17', 'kegiatan', '2026-02-21 11:39:46'),
(8, 'Ulang Tahun Sekolah', 'Perayaan ulang tahun ke-10 SLB Rumah Kita', 'Ulang Tahun Sekolah.jpeg', '2025-09-01', 'kegiatan', '2026-02-21 11:39:46'),
(9, 'Kunjungan Studi Banding', 'Kunjungan dari SLB se-Kota Batam', 'Kunjungan Studi Banding.jpeg', '2025-10-15', 'kegiatan', '2026-02-21 11:39:46'),
(10, 'Baksos Pengobatan Gratis', 'Bakti sosial pengobatan gratis untuk masyarakat', 'Baksos Pengobatan Gratis.jpg', '2025-11-20', 'kegiatan', '2026-02-21 11:39:46'),
(11, 'Wisuda Siswa', 'Wisuda siswa SMALB tahun ajaran 2024/2025', 'Wisuda Siswa.jpg', '2025-12-10', 'kegiatan', '2026-02-21 11:39:46'),
(12, 'Ruang Kelas SDLB', 'Ruang kelas yang nyaman untuk pembelajaran', 'Tentang Sekolah1.jpg', '2025-01-01', 'fasilitas', '2026-02-21 11:39:46'),
(13, 'Laboratorium Komputer', 'Lab komputer lengkap dengan 20 unit', 'Belajar Komputer.jpeg', '2025-01-01', 'fasilitas', '2026-02-21 11:39:46'),
(14, 'Ruang Terapi', 'Ruang terapi untuk kebutuhan khusus siswa', 'Tentang Sekolah2.jpg', '2025-01-01', 'fasilitas', '2026-02-21 11:39:46'),
(15, 'Perpustakaan', 'Perpustakaan dengan koleksi buku lengkap', 'Tentang Sekolah3.jpg', '2025-01-01', 'fasilitas', '2026-02-21 11:39:46'),
(16, 'Lapangan Olahraga', 'Lapangan basket dan voli untuk kegiatan olahraga', 'Juara Basket.jpeg', '2025-01-01', 'fasilitas', '2026-02-21 11:39:46');

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `urutan` int(11) DEFAULT 0,
  `aktif` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id`, `nama`, `jabatan`, `foto`, `deskripsi`, `urutan`, `aktif`, `created_at`, `updated_at`) VALUES
(1, 'Drs. Budi Santoso', 'Kepala Sekolah', 'guru1.jpg', 'Berpengalaman dalam pendidikan khusus selama 20 tahun. Memiliki sertifikasi manajemen pendidikan inklusif.', 1, 1, '2026-02-21 11:39:46', '2026-02-21 11:39:46'),
(2, 'Ibu Sari Wulandari, S.Pd', 'Wakil Kepala Sekolah', 'guru2.jpg', 'Ahli dalam kurikulum adaptif dan pembelajaran individual. Master Pendidikan Khusus dari Universitas Negeri Jakarta.', 2, 1, '2026-02-21 11:39:46', '2026-02-21 11:39:46'),
(3, 'Ibu Rina Susanti, S.Psi', 'Guru Kelas SDLB', 'guru3.jpg', 'Spesialis dalam metode pembelajaran inklusif untuk anak dengan kebutuhan khusus. Sarjana Psikologi Pendidikan.', 3, 1, '2026-02-21 11:39:46', '2026-02-21 11:39:46'),
(4, 'Bapak Ahmad Jaya', 'Guru Terapi', 'guru4.jpg', 'Terapis fisik dan okupasi berlisensi. Berpengalaman menangani berbagai kasus disabilitas fisik.', 4, 1, '2026-02-21 11:39:46', '2026-02-21 11:39:46'),
(5, 'Ibu Dewi Kartika, S.Pd', 'Guru Bahasa Indonesia', 'guru5.jpg', 'Guru bahasa dengan pendekatan komunikatif untuk siswa berkebutuhan khusus. Lulusan Sastra Indonesia.', 5, 1, '2026-02-21 11:39:46', '2026-02-21 11:39:46');

-- --------------------------------------------------------

--
-- Table structure for table `halaman`
--

CREATE TABLE `halaman` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `urutan` int(11) DEFAULT 0,
  `aktif` tinyint(1) DEFAULT 1,
  `icon` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `halaman`
--

INSERT INTO `halaman` (`id`, `judul`, `slug`, `isi`, `urutan`, `aktif`, `icon`, `updated_at`) VALUES
(2, 'Visi & Misi', 'visi-misi', '<h3>Visi</h3><p>Menjadi sekolah luar biasa terdepan yang inklusif dan berdaya saing.</p><h3>Misi</h3><ol><li>Menyelenggarakan pendidikan berkualitas bagi anak berkebutuhan khusus</li><li>Mengembangkan potensi siswa secara optimal</li><li>Membangun kerjasama dengan berbagai pihak.</li></ol>', 0, 0, 'fa-file-alt', '2026-02-21 16:54:39'),
(3, 'Program Pendidikan', 'program', '<h2>Program Pendidikan SLB Rumah Kita Batam</h2><p>Kami menyediakan berbagai program pendidikan yang disesuaikan dengan kebutuhan setiap siswa:</p><h3>SDLB (Sekolah Dasar Luar Biasa)</h3><p>Program pendidikan dasar untuk siswa dengan kebutuhan khusus pada tingkat dasar, mencakup mata pelajaran umum dengan penyesuaian kurikulum.</p><h3>SMPLB (Sekolah Menengah Pertama Luar Biasa)</h3><p>Program pendidikan menengah pertama dengan fokus pada pengembangan keterampilan akademik dan sosial.</p><h3>SMALB (Sekolah Menengah Atas Luar Biasa)</h3><p>Program pendidikan menengah atas dengan penekanan pada keterampilan vokasi dan persiapan untuk kemandirian.</p>', 3, 1, 'fa-graduation-cap', '2026-02-21 11:39:46'),
(4, 'Guru & Staf', 'guru', '<h2>Tim Pengajar SLB Rumah Kita Batam</h2><p>Tim pengajar kami terdiri dari profesional berpengalaman dalam pendidikan khusus. Setiap guru memiliki komitmen tinggi untuk membantu siswa mencapai potensi terbaik mereka.</p><p>Kami memiliki 15 guru aktif dengan berbagai spesialisasi:</p><ul><li>Guru kelas SDLB</li><li>Guru mata pelajaran SMPLB dan SMALB</li><li>Guru terapi</li><li>Guru BK</li></ul>', 4, 1, 'fa-users', '2026-02-21 11:39:46'),
(5, 'Kontak', 'kontak', '<h2>Hubungi Kami</h2><p>Silakan hubungi kami untuk informasi lebih lanjut tentang pendaftaran dan program pendidikan.</p><h3>Informasi Kontak</h3><p><strong>Alamat:</strong> Jl. Contoh No. 123, Batam<br><strong>Telepon:</strong> (0778) 1234567<br><strong>Email:</strong> info@rumahkita.sch.id<br><strong>WhatsApp:</strong> +62 812-3456-7890</p>', 5, 1, 'fa-envelope', '2026-02-21 11:39:46'),
(18, 'Tentang Sekolah', 'tentang-sekolah', '<h2>Tentang SLB Rumah Kita Batam</h2>\r\n<p>SLB Rumah Kita Batam adalah sekolah luar biasa yang berdedikasi untuk memberikan pendidikan berkualitas bagi anak-anak berkebutuhan khusus. Berdiri sejak tahun 2015, sekolah kami telah melayani ratusan siswa dengan berbagai kebutuhan pendidikan khusus.</p>\r\n\r\n\r\n\r\n<p>Kami berkomitmen untuk memberikan pelayanan terbaik dengan pendekatan individual bagi setiap siswa, mengembangkan potensi mereka secara optimal, dan mempersiapkan mereka untuk menjadi mandiri dan produktif.</p>', 1, 1, 'fa-school', '2026-02-21 17:36:45');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `attempt_time` datetime NOT NULL,
  `is_locked` tinyint(1) DEFAULT 0,
  `lockout_until` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan`
--

CREATE TABLE `pengaturan` (
  `id` int(11) NOT NULL,
  `nama_sekolah` varchar(255) NOT NULL DEFAULT 'SLB Rumah Kita Batam',
  `alamat` text DEFAULT NULL,
  `telepon` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `maps_embed` text DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(50) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `footer_text` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengaturan`
--

INSERT INTO `pengaturan` (`id`, `nama_sekolah`, `alamat`, `telepon`, `email`, `logo`, `maps_embed`, `facebook`, `instagram`, `youtube`, `whatsapp`, `meta_title`, `meta_description`, `meta_keywords`, `footer_text`, `updated_at`) VALUES
(1, 'SLB Rumah Kita Batam', 'Jl. Contoh No. 123, Batam, Kepulauan Riau', '(0778) 123456788', 'info@rumahkita.sch.id', NULL, '', 'https://facebook.com/slbrumahkitabatam', 'https://instagram.com/slbrumahkitabatam', 'https://youtube.com/slbrumahkitabatam', '+62 812-3456-7890', 'SLB Rumah Kita Batam - Sekolah Luar Biasa Terpercaya', 'SLB Rumah Kita Batam adalah sekolah luar biasa yang menyediakan pendidikan berkualitas bagi anak berkebutuhan khusus di Batam.', 'SLB Rumah Kita Batam, sekolah luar biasa, pendidikan khusus, SDLB, SMPLB, SMALB, Batam', '© 2025 SLB Rumah Kita Batam. Seluruh hak cipta dilindungi.', '2026-02-21 16:41:35');

-- --------------------------------------------------------

--
-- Table structure for table `profil_sekolah`
--

CREATE TABLE `profil_sekolah` (
  `id` int(11) NOT NULL,
  `tentang` text NOT NULL,
  `visi_misi` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profil_sekolah`
--

INSERT INTO `profil_sekolah` (`id`, `tentang`, `visi_misi`, `updated_at`) VALUES
(1, '<h2> SLB Rumah Kita Batam</h2><p>SLB Rumah Kita Batam adalah sekolah luar biasa yang berdedikasi untuk memberikan pendidikan berkualitas bagi anak-anak berkebutuhan khusus. Berdiri sejak tahun 2015, sekolah kami telah melayani ratusan siswa dengan berbagai kebutuhan pendidikan khusus.</p>', '<h3>Visi</h3><p>Menjadi lembaga pendidikan luar biasa yang unggul dalam membentuk anak-anak berkebutuhan khusus yang mandiri, percaya diri, dan berdaya saing.</p>\r\n\r\n<h3>Misi</h3><ol><li>Menyediakan layanan pendidikan yang sesuai dengan kebutuhan masing-masing anak.</li><li>Mengembangkan kemampuan akademik, sosial, dan keterampilan hidup (life skills).</li><li>Memberikan pendampingan terapi dan pembinaan karakter secara berkelanjutan.</li><li>Menciptakan lingkungan belajar yang aman, nyaman, dan inklusif.</li></ol>', '2026-02-21 16:56:45');

-- --------------------------------------------------------

--
-- Table structure for table `security_logs`
--

CREATE TABLE `security_logs` (
  `id` int(11) NOT NULL,
  `event_type` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `ip_address` varchar(45) NOT NULL,
  `event_time` datetime NOT NULL,
  `user_agent` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `security_logs`
--

INSERT INTO `security_logs` (`id`, `event_type`, `description`, `username`, `ip_address`, `event_time`, `user_agent`) VALUES
(1, 'LOGIN_SUCCESS', 'User logged in successfully', 'admin', '::1', '2026-02-21 22:19:49', NULL),
(2, 'LOGIN_SUCCESS', 'User logged in successfully', 'admin', '::1', '2026-02-21 22:26:17', NULL),
(3, 'LOGIN_FAILED', 'Failed login attempt', 'admin', '::1', '2026-02-21 22:34:20', NULL),
(4, 'LOGIN_SUCCESS', 'User logged in successfully', 'admin', '::1', '2026-02-21 22:34:26', NULL),
(5, 'LOGIN_SUCCESS', 'User logged in successfully', 'riyan', '::1', '2026-02-21 23:18:39', NULL),
(6, 'LOGIN_SUCCESS', 'User logged in successfully', 'admin', '::1', '2026-02-21 23:19:16', NULL),
(7, 'LOGIN_SUCCESS', 'User logged in successfully', 'riyan', '::1', '2026-02-21 23:19:49', NULL),
(8, 'LOGIN_SUCCESS', 'User logged in successfully', 'riyan', '::1', '2026-02-21 23:20:25', NULL),
(9, 'LOGIN_SUCCESS', 'User logged in successfully', 'admin', '::1', '2026-02-21 23:20:42', NULL),
(10, 'LOGIN_SUCCESS', 'User logged in successfully', 'riyan', '::1', '2026-02-21 23:21:16', NULL),
(11, 'LOGIN_SUCCESS', 'User logged in successfully', 'budi', '::1', '2026-02-21 23:23:18', NULL),
(12, 'LOGIN_SUCCESS', 'User logged in successfully', 'admin', '::1', '2026-02-21 23:25:02', NULL),
(13, 'LOGIN_SUCCESS', 'User logged in successfully', 'riyan', '::1', '2026-02-21 23:33:33', NULL),
(14, 'LOGIN_SUCCESS', 'User logged in successfully', 'admin', '::1', '2026-02-21 23:33:49', NULL),
(15, 'LOGIN_SUCCESS', 'User logged in successfully', 'budi', '::1', '2026-02-21 23:34:07', NULL),
(16, 'LOGIN_SUCCESS', 'User logged in successfully', 'riyan', '::1', '2026-02-21 23:34:45', NULL),
(17, 'LOGIN_SUCCESS', 'User logged in successfully', 'admin', '::1', '2026-02-21 23:49:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tampilan`
--

CREATE TABLE `tampilan` (
  `id` int(11) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `background_beranda` varchar(255) DEFAULT NULL,
  `background_halaman` varchar(255) DEFAULT NULL,
  `background_footer` varchar(255) DEFAULT NULL,
  `warna_utama` varchar(7) DEFAULT '#4A90E2',
  `warna_teks` varchar(7) DEFAULT '#333333',
  `font_website` varchar(50) DEFAULT 'Poppins',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tampilan`
--

INSERT INTO `tampilan` (`id`, `logo`, `favicon`, `background_beranda`, `background_halaman`, `background_footer`, `warna_utama`, `warna_teks`, `font_website`, `updated_at`) VALUES
(1, 'logo.jpg', NULL, NULL, NULL, NULL, '#4474d5', '#000000', 'Poppins', '2026-02-21 16:16:52');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `role` varchar(20) DEFAULT 'guru',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama`, `role`, `created_at`) VALUES
(1, 'admin', '$2y$10$I4snosFs9pCdVCmiJ0w8uO/FoTJ6mf90qeUZ1KRKfO7ajk8V930pq', 'Administrator', 'admin', '2026-02-21 11:39:46'),
(2, 'guru', '$2y$10$yIJ7tRhGljWxnEI0hLGIZOCr/sHDvOnrfUB701K7DcCKUi0VQedBe', 'Ibu Rina Susanti, S.Psi', 'guru', '2026-02-21 11:39:46'),
(3, 'budi', '$2y$10$CHQd.8yqQLh1yKiP13BqXuAMhAwLyDkZ7jFY3XxV3zz2JZ.1L/1fK', 'Drs. Budi Santoso', 'guru', '2026-02-21 15:53:10'),
(4, 'riyan', '$2y$10$KCuJkXl7Qo9b6hjTmUEtUOUATNZuQdfm/Yi7x2G/mWIgt/tkKtOIC', 'riyansyah', 'admin', '2026-02-21 16:18:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_berita_slug` (`slug`),
  ADD KEY `idx_berita_tanggal` (`tanggal`);

--
-- Indexes for table `csrf_tokens`
--
ALTER TABLE `csrf_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_token` (`token`),
  ADD KEY `idx_session` (`session_id`),
  ADD KEY `idx_expires` (`expires_at`);

--
-- Indexes for table `galeri`
--
ALTER TABLE `galeri`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_galeri_kategori` (`kategori`),
  ADD KEY `idx_galeri_tanggal` (`tanggal`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_guru_aktif` (`aktif`);

--
-- Indexes for table `halaman`
--
ALTER TABLE `halaman`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_halaman_slug` (`slug`),
  ADD KEY `idx_halaman_aktif` (`aktif`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ip_time` (`ip_address`,`attempt_time`),
  ADD KEY `idx_username` (`username`),
  ADD KEY `idx_lockout` (`is_locked`,`lockout_until`);

--
-- Indexes for table `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profil_sekolah`
--
ALTER TABLE `profil_sekolah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `security_logs`
--
ALTER TABLE `security_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_event_type` (`event_type`),
  ADD KEY `idx_time` (`event_time`),
  ADD KEY `idx_username` (`username`);

--
-- Indexes for table `tampilan`
--
ALTER TABLE `tampilan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `idx_users_username` (`username`),
  ADD KEY `idx_role` (`role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `csrf_tokens`
--
ALTER TABLE `csrf_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `halaman`
--
ALTER TABLE `halaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pengaturan`
--
ALTER TABLE `pengaturan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `profil_sekolah`
--
ALTER TABLE `profil_sekolah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `security_logs`
--
ALTER TABLE `security_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tampilan`
--
ALTER TABLE `tampilan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
