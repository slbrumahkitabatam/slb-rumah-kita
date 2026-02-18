-- Database: slb_rumah_kita

-- Tabel Users (Admin)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Berita
CREATE TABLE IF NOT EXISTS berita (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    isi TEXT NOT NULL,
    gambar VARCHAR(255),
    tanggal DATE NOT NULL,
    penulis VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Galeri
CREATE TABLE IF NOT EXISTS galeri (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    gambar VARCHAR(255) NOT NULL,
    tanggal DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Halaman (Profil, Visi Misi, dll)
CREATE TABLE IF NOT EXISTS halaman (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    isi TEXT NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel Pengaturan
CREATE TABLE IF NOT EXISTS pengaturan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_sekolah VARCHAR(255) NOT NULL DEFAULT 'SLB Rumah Kita Batam',
    alamat TEXT,
    telepon VARCHAR(50),
    email VARCHAR(100),
    logo VARCHAR(255),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert default admin (password: admin123)
INSERT INTO users (username, password, nama) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator');

-- Insert default pengaturan
INSERT INTO pengaturan (nama_sekolah, alamat, telepon, email) VALUES 
('SLB Rumah Kita Batam', 'Jl. Contoh No. 123, Batam', '(0778) 1234567', 'info@rumahkita.sch.id');

-- Insert default halaman
INSERT INTO halaman (judul, slug, isi) VALUES 
('Tentang Sekolah', 'tentang', '<p>SLB Rumah Kita Batam adalah sekolah luar biasa yang berdedikasi untuk memberikan pendidikan berkualitas bagi anak-anak berkebutuhan khusus.</p>'),
('Visi & Misi', 'visi-misi', '<h3>Visi</h3><p>Menjadi sekolah luar biasa terdepan yang inklusif dan berdaya saing.</p><h3>Misi</h3><ol><li>Menyelenggarakan pendidikan berkualitas bagi anak berkebutuhan khusus</li><li>Mengembangkan potensi siswa secara optimal</li><li>Membangun kerjasama dengan berbagai pihak</li></ol>');