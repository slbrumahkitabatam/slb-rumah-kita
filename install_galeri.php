<?php
// Script instalasi galeri
require_once 'config/database.php';

echo "<h1>Instalasi Galeri SLB</h1>";
echo "<hr>";

try {
    // 1. Tambahkan kolom kategori jika belum ada
    echo "<h3>1. Menambahkan kolom kategori...</h3>";
    
    // Cek apakah kolom kategori sudah ada
    $checkColumn = fetchOne("SHOW COLUMNS FROM galeri LIKE 'kategori'");
    
    if (!$checkColumn) {
        // Tambah kolom kategori
        $pdo->exec("ALTER TABLE galeri ADD COLUMN kategori VARCHAR(100) NOT NULL DEFAULT 'kegiatan'");
        echo "<p style='color: green;'>✓ Kolom kategori berhasil ditambahkan</p>";
    } else {
        echo "<p style='color: blue;'>ℹ Kolom kategori sudah ada, dilewati</p>";
    }
    
    echo "<hr>";
    
    // 2. Hapus data contoh jika ada (opsional - uncomment jika ingin reset)
    /*
    echo "<h3>2. Menghapus data contoh lama...</h3>";
    $pdo->exec("DELETE FROM galeri WHERE kategori IN ('kbm', 'eskul', 'prestasi', 'kegiatan', 'fasilitas')");
    echo "<p style='color: green;'>✓ Data lama berhasil dihapus</p>";
    echo "<hr>";
    */
    
    // 3. Insert data contoh untuk setiap kategori
    echo "<h3>3. Menambahkan data galeri contoh...</h3>";
    
    // Cek data yang sudah ada
    $existingData = fetchAll("SELECT id FROM galeri");
    $existingCount = count($existingData);
    
    if ($existingCount < 25) {
        // Data galeri contoh
        $galeriData = [
            // Kegiatan Belajar
            ['judul' => 'Siswa Belajar Membaca', 'deskripsi' => 'Siswa kelas SDLB sedang belajar membaca dengan metode yang menyenangkan', 'gambar' => 'kbm1.jpg', 'kategori' => 'kbm'],
            ['judul' => 'Praktik Melukis', 'deskripsi' => 'Kegiatan melukis siswa kelas SMALB dalam seni rupa', 'gambar' => 'kbm2.jpg', 'kategori' => 'kbm'],
            ['judul' => 'Belajar Komputer', 'deskripsi' => 'Siswa berlatih menggunakan komputer di lab komputer sekolah', 'gambar' => 'kbm3.jpg', 'kategori' => 'kbm'],
            ['judul' => 'Pelajaran Matematika', 'deskripsi' => 'Siswa SDLB belajar berhitung dengan alat peraga', 'gambar' => 'kbm4.jpg', 'kategori' => 'kbm'],
            ['judul' => 'Membaca Al-Quran', 'deskripsi' => 'Kegiatan membaca Al-Quran bagi siswa muslim', 'gambar' => 'kbm5.jpg', 'kategori' => 'kbm'],
            
            // Ekstrakurikuler
            ['judul' => 'Olahraga Basket', 'deskripsi' => 'Tim basket sekolah sedang berlatih', 'gambar' => 'eskul1.jpg', 'kategori' => 'eskul'],
            ['judul' => 'Seni Tari', 'deskripsi' => 'Latihan tari tradisional siswi', 'gambar' => 'eskul2.jpg', 'kategori' => 'eskul'],
            ['judul' => 'Paduan Suara', 'deskripsi' => 'Latihan menyanyi paduan suara', 'gambar' => 'eskul3.jpg', 'kategori' => 'eskul'],
            ['judul' => 'Kerajinan Tangan', 'deskripsi' => 'Siswa membuat kerajinan tangan dari barang bekas', 'gambar' => 'eskul4.jpg', 'kategori' => 'eskul'],
            ['judul' => 'Bercocok Tanam', 'deskripsi' => 'Kegiatan bercocok tanam di kebun sekolah', 'gambar' => 'eskul5.jpg', 'kategori' => 'eskul'],
            
            // Prestasi
            ['judul' => 'Juara 1 Lomba Melukis', 'deskripsi' => 'Siswa kami meraih juara 1 lomba melukis tingkat kota', 'gambar' => 'prestasi1.jpg', 'kategori' => 'prestasi'],
            ['judul' => 'Medali Emas Olimpiade', 'deskripsi' => 'Peraih medali emas Olimpiade Matematika Khusus', 'gambar' => 'prestasi2.jpg', 'kategori' => 'prestasi'],
            ['judul' => 'Juara Lomba Paduan Suara', 'deskripsi' => 'Tim paduan suara meraih juara 2 tingkat provinsi', 'gambar' => 'prestasi3.jpg', 'kategori' => 'prestasi'],
            ['judul' => 'Siswa Berprestasi', 'deskripsi' => 'Penghargaan siswa berprestasi tahun ajaran 2024/2025', 'gambar' => 'prestasi4.jpg', 'kategori' => 'prestasi'],
            ['judul' => 'Juara Basket', 'deskripsi' => 'Tim basket sekolah juara 2 turnamen kota', 'gambar' => 'prestasi5.jpg', 'kategori' => 'prestasi'],
            
            // Kegiatan Sekolah
            ['judul' => 'Perayaan Hari Kemerdekaan', 'deskripsi' => 'Upacara peringatan Hari Kemerdekaan RI ke-80', 'gambar' => 'kegiatan1.jpg', 'kategori' => 'kegiatan'],
            ['judul' => 'Ulang Tahun Sekolah', 'deskripsi' => 'Perayaan ulang tahun ke-10 SLB Rumah Kita', 'gambar' => 'kegiatan2.jpg', 'kategori' => 'kegiatan'],
            ['judul' => 'Kunjungan Studi Banding', 'deskripsi' => 'Kunjungan dari SLB se-Kota Batam', 'gambar' => 'kegiatan3.jpg', 'kategori' => 'kegiatan'],
            ['judul' => 'Baksos Pengobatan Gratis', 'deskripsi' => 'Bakti sosial pengobatan gratis untuk masyarakat', 'gambar' => 'kegiatan4.jpg', 'kategori' => 'kegiatan'],
            ['judul' => 'Wisuda Siswa', 'deskripsi' => 'Wisuda siswa SMALB tahun ajaran 2024/2025', 'gambar' => 'kegiatan5.jpg', 'kategori' => 'kegiatan'],
            
            // Fasilitas
            ['judul' => 'Ruang Kelas SDLB', 'deskripsi' => 'Ruang kelas yang nyaman untuk pembelajaran', 'gambar' => 'fasilitas1.jpg', 'kategori' => 'fasilitas'],
            ['judul' => 'Laboratorium Komputer', 'deskripsi' => 'Lab komputer lengkap dengan 20 unit', 'gambar' => 'fasilitas2.jpg', 'kategori' => 'fasilitas'],
            ['judul' => 'Ruang Terapi', 'deskripsi' => 'Ruang terapi untuk kebutuhan khusus siswa', 'gambar' => 'fasilitas3.jpg', 'kategori' => 'fasilitas'],
            ['judul' => 'Perpustakaan', 'deskripsi' => 'Perpustakaan dengan koleksi buku lengkap', 'gambar' => 'fasilitas4.jpg', 'kategori' => 'fasilitas'],
            ['judul' => 'Lapangan Olahraga', 'deskripsi' => 'Lapangan basket dan voli untuk kegiatan olahraga', 'gambar' => 'fasilitas5.jpg', 'kategori' => 'fasilitas']
        ];
        
        $inserted = 0;
        $skipped = 0;
        
        foreach ($galeriData as $data) {
            // Cek apakah judul sudah ada
            $existing = fetchOne("SELECT id FROM galeri WHERE judul = ?", [$data['judul']]);
            
            if (!$existing) {
                // Insert data baru
                $stmt = $pdo->prepare("INSERT INTO galeri (judul, deskripsi, gambar, tanggal, kategori) VALUES (?, ?, ?, ?, ?)");
                
                // Generate tanggal berbeda untuk setiap item
                $baseDate = new DateTime('2025-01-01');
                $baseDate->modify('+' . ($inserted + 1) . ' days');
                
                $stmt->execute([
                    $data['judul'],
                    $data['deskripsi'],
                    $data['gambar'],
                    $baseDate->format('Y-m-d'),
                    $data['kategori']
                ]);
                
                $inserted++;
            } else {
                $skipped++;
            }
        }
        
        echo "<p style='color: green;'>✓ Berhasil menambahkan $inserted galeri baru</p>";
        if ($skipped > 0) {
            echo "<p style='color: blue;'>ℹ $skipped galeri dilewati karena sudah ada</p>";
        }
    } else {
        echo "<p style='color: blue;'>ℹ Data galeri sudah ada (" . $existingCount . " item), dilewati</p>";
    }
    
    echo "<hr>";
    
    // 4. Verifikasi instalasi
    echo "<h3>4. Verifikasi Instalasi</h3>";
    
    $totalGaleri = fetchOne("SELECT COUNT(*) as total FROM galeri");
    $kategoriStats = [];
    
    $kategoriList = ['kbm', 'eskul', 'prestasi', 'kegiatan', 'fasilitas'];
    foreach ($kategoriList as $kat) {
        $count = fetchOne("SELECT COUNT(*) as total FROM galeri WHERE kategori = '$kat'");
        $kategoriStats[$kat] = $count['total'];
    }
    
    echo "<p><strong>Total Galeri:</strong> " . $totalGaleri['total'] . "</p>";
    echo "<ul>";
    echo "<li>📚 Kegiatan Belajar: " . ($kategoriStats['kbm'] ?? 0) . " galeri</li>";
    echo "<li>⚽ Ekstrakurikuler: " . ($kategoriStats['eskul'] ?? 0) . " galeri</li>";
    echo "<li>🏆 Prestasi Siswa: " . ($kategoriStats['prestasi'] ?? 0) . " galeri</li>";
    echo "<li>📅 Kegiatan Sekolah: " . ($kategoriStats['kegiatan'] ?? 0) . " galeri</li>";
    echo "<li>🏢 Fasilitas: " . ($kategoriStats['fasilitas'] ?? 0) . " galeri</li>";
    echo "</ul>";
    
    echo "<hr>";
    echo "<h2 style='color: green;'>✓ Instalasi Selesai!</h2>";
    echo "<p>Sistem galeri dengan 5 kategori telah berhasil diinstal.</p>";
    echo "<a href='galeri.php' class='btn btn-primary btn-lg'>Lihat Galeri →</a>";
    echo "<br><br>";
    echo "<small>File ini dapat dihapus setelah instalasi selesai.</small>";
    
} catch (PDOException $e) {
    echo "<h2 style='color: red;'>✗ Terjadi Kesalahan</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
}
?>