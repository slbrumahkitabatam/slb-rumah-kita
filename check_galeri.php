<?php
require_once 'config/database.php';

echo "=== MEMERIKSA DATA GALERI ===\n\n";

// Ambil semua data galeri
$galeri = fetchAll('SELECT * FROM galeri ORDER BY id DESC');

if (empty($galeri)) {
    echo "Tidak ada data galeri di database!\n";
    exit;
}

echo "Total galeri: " . count($galeri) . "\n\n";

foreach ($galeri as $item) {
    echo "ID: {$item['id']}\n";
    echo "Judul: {$item['judul']}\n";
    echo "Gambar: {$item['gambar']}\n";
    
    // Cek apakah file ada
    $filePath = 'uploads/galeri/' . $item['gambar'];
    $fileExists = file_exists($filePath);
    
    echo "File exists: " . ($fileExists ? 'YES' : 'NO') . "\n";
    
    if (!$fileExists && $item['gambar']) {
        echo "⚠️  FILE TIDAK DITEMUKAN!\n";
    }
    
    echo "Kategori: " . ($item['kategori'] ?? 'N/A') . "\n";
    echo "Tanggal: {$item['tanggal']}\n";
    echo "----------------------------------------\n";
}

echo "\n=== STRUKTUR TABEL GALERI ===\n";
$columns = fetchAll("SHOW COLUMNS FROM galeri");
foreach ($columns as $col) {
    echo "- {$col['Field']} ({$col['Type']})\n";
}
?>