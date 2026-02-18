-- Update Database untuk Panel Admin Lengkap

-- Tabel Guru & Staf
CREATE TABLE IF NOT EXISTS guru (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    jabatan VARCHAR(100) NOT NULL,
    foto VARCHAR(255),
    deskripsi TEXT,
    urutan INT DEFAULT 0,
    aktif TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel Halaman Website (Update tabel halaman yang ada)
ALTER TABLE halaman ADD COLUMN urutan INT DEFAULT 0;
ALTER TABLE halaman ADD COLUMN aktif TINYINT(1) DEFAULT 1;
ALTER TABLE halaman ADD COLUMN icon VARCHAR(50);

-- Tabel Tampilan Website
CREATE TABLE IF NOT EXISTS tampilan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    logo VARCHAR(255),
    favicon VARCHAR(255),
    background_beranda VARCHAR(255),
    background_halaman VARCHAR(255),
    background_footer VARCHAR(255),
    warna_utama VARCHAR(7) DEFAULT '#4A90E2',
    warna_teks VARCHAR(7) DEFAULT '#333333',
    font_website VARCHAR(50) DEFAULT 'Poppins',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel Kontak Sekolah (Update tabel pengaturan)
ALTER TABLE pengaturan ADD COLUMN maps_embed TEXT;
ALTER TABLE pengaturan ADD COLUMN facebook VARCHAR(255);
ALTER TABLE pengaturan ADD COLUMN instagram VARCHAR(255);
ALTER TABLE pengaturan ADD COLUMN youtube VARCHAR(255);
ALTER TABLE pengaturan ADD COLUMN whatsapp VARCHAR(50);
ALTER TABLE pengaturan ADD COLUMN meta_title VARCHAR(255);
ALTER TABLE pengaturan ADD COLUMN meta_description TEXT;
ALTER TABLE pengaturan ADD COLUMN meta_keywords TEXT;
ALTER TABLE pengaturan ADD COLUMN footer_text TEXT;

-- Tabel Admin Role (untuk manajemen user opsional)
CREATE TABLE IF NOT EXISTS admin_roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    role VARCHAR(20) DEFAULT 'admin',
    aktif TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert default tampilan
INSERT INTO tampilan (warna_utama, warna_teks, font_website) VALUES 
('#4A90E2', '#333333', 'Poppins');

-- Insert sample guru data
INSERT INTO guru (nama, jabatan, deskripsi, urutan, aktif) VALUES 
('Drs. Budi Santoso', 'Kepala Sekolah', 'Berpengalaman dalam pendidikan khusus selama 20 tahun.', 1, 1),
('Ibu Sari Wulandari', 'Wakil Kepala Sekolah', 'Ahli dalam kurikulum adaptif dan pembelajaran individual.', 2, 1),
('Ibu Rina Susanti', 'Guru Kelas', 'Spesialis dalam metode pembelajaran inklusif.', 3, 1),
('Bapak Ahmad Jaya', 'Guru Terapi', 'Terapis fisik dan okupasi berlisensi.', 4, 1);

-- Insert additional halaman
INSERT INTO halaman (judul, slug, isi, urutan, aktif, icon) VALUES 
('Program Pendidikan', 'program', '<p>Kami menyediakan berbagai program pendidikan yang disesuaikan dengan kebutuhan setiap siswa.</p>', 1, 1, 'fa-graduation-cap'),
('Guru & Staf', 'guru', '<p>Tim pengajar kami terdiri dari profesional berpengalaman dalam pendidikan khusus.</p>', 2, 1, 'fa-users'),
('Kontak', 'kontak', '<p>Hubungi kami untuk informasi lebih lanjut tentang pendaftaran dan program pendidikan.</p>', 3, 1, 'fa-envelope');