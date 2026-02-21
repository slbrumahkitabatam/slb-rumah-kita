<?php
require_once 'config/database.php';

echo "<!DOCTYPE html>
<html lang='id'>
<head>
    <meta charset='UTF-8'>
    <title>Check & Fix Database</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
</head>
<body class='p-5'>";

echo "<div class='container'>
    <h1 class='mb-4'>🔍 Cek & Perbaiki Database</h1>";

try {
    // Check if pengaturan table has required columns
    echo "<div class='card mb-4'>
        <div class='card-header bg-primary text-white'>
            <h5 class='mb-0'>Step 1: Cek Struktur Tabel Pengaturan</h5>
        </div>
        <div class='card-body'>";
    
    $columns = fetchAll("SHOW COLUMNS FROM pengaturan");
    $requiredColumns = ['warna_utama', 'warna_teks', 'maps', 'facebook', 'instagram', 'youtube'];
    
    echo "<table class='table'>
        <thead>
            <tr>
                <th>Kolom</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>";
    
    $allColumnsExist = true;
    $columnNames = [];
    foreach ($columns as $col) {
        $columnNames[] = $col['Field'];
    }
    
    foreach ($requiredColumns as $reqCol) {
        $exists = in_array($reqCol, $columnNames);
        $allColumnsExist = $allColumnsExist && $exists;
        echo "<tr>
            <td><code>$reqCol</code></td>
            <td>" . ($exists ? "<span class='badge bg-success'>✓ Ada</span>" : "<span class='badge bg-danger'>✗ Tidak Ada</span>") . "</td>
        </tr>";
    }
    
    echo "</tbody></table>";
    echo "</div></div>";
    
    // Add missing columns
    if (!$allColumnsExist) {
        echo "<div class='card mb-4'>
            <div class='card-header bg-warning'>
                <h5 class='mb-0'>Step 2: Menambahkan Kolom yang Hilang</h5>
            </div>
            <div class='card-body'>";
        
        $fixes = [
            'warna_utama' => "ALTER TABLE pengaturan ADD COLUMN warna_utama VARCHAR(7) DEFAULT '#667eea'",
            'warna_teks' => "ALTER TABLE pengaturan ADD COLUMN warna_teks VARCHAR(7) DEFAULT '#333333'",
            'maps' => "ALTER TABLE pengaturan ADD COLUMN maps TEXT",
            'facebook' => "ALTER TABLE pengaturan ADD COLUMN facebook VARCHAR(255)",
            'instagram' => "ALTER TABLE pengaturan ADD COLUMN instagram VARCHAR(255)",
            'youtube' => "ALTER TABLE pengaturan ADD COLUMN youtube VARCHAR(255)"
        ];
        
        foreach ($fixes as $col => $sql) {
            if (!in_array($col, $columnNames)) {
                try {
                    execute($sql);
                    echo "<div class='alert alert-success'>✓ Kolom <strong>$col</strong> berhasil ditambahkan!</div>";
                } catch (PDOException $e) {
                    echo "<div class='alert alert-danger'>✗ Gagal menambahkan <strong>$col</strong>: " . $e->getMessage() . "</div>";
                }
            }
        }
        
        echo "</div></div>";
    } else {
        echo "<div class='alert alert-success'>✅ Semua kolom yang diperlukan sudah ada!</div>";
    }
    
    // Check if there's data in pengaturan
    echo "<div class='card mb-4'>
        <div class='card-header bg-info text-white'>
            <h5 class='mb-0'>Step 3: Cek Data Pengaturan</h5>
        </div>
        <div class='card-body'>";
    
    $count = fetchOne("SELECT COUNT(*) as total FROM pengaturan");
    
    if ($count['total'] == 0) {
        execute("INSERT INTO pengaturan (nama_sekolah, alamat, telepon, email, warna_utama, warna_teks) VALUES 
            ('SLB Rumah Kita Batam', 'Jl. Contoh No. 123', '08123456789', 'info@rumahkita.sch.id', '#667eea', '#333333')");
        echo "<div class='alert alert-success'>✓ Data default pengaturan berhasil ditambahkan!</div>";
    } else {
        echo "<div class='alert alert-info'>ℹ️ Ada {$count['total']} baris data di tabel pengaturan</div>";
        
        // Show current data
        $data = fetchOne("SELECT * FROM pengaturan LIMIT 1");
        echo "<table class='table table-sm mt-3'>
            <thead>
                <tr><th>Kolom</th><th>Nilai</th></tr>
            </thead>
            <tbody>";
        
        foreach ($data as $key => $value) {
            if ($key !== 'id' && $value !== null) {
                echo "<tr>
                    <td><strong>$key</strong></td>
                    <td>" . htmlspecialchars($value) . "</td>
                </tr>";
            }
        }
        echo "</tbody></table>";
    }
    
    echo "</div></div>";
    
    // Test save operation
    echo "<div class='card mb-4'>
        <div class='card-header bg-success text-white'>
            <h5 class='mb-0'>Step 4: Test Operasi Simpan</h5>
        </div>
        <div class='card-body'>";
    
    $testWarna = '#ff0000';
    $testMaps = '<iframe>Test</iframe>';
    
    try {
        execute("UPDATE pengaturan SET warna_utama = ?, warna_teks = ?, maps = ? WHERE id = (SELECT MIN(id) FROM pengaturan)", 
                [$testWarna, $testWarna, $testMaps]);
        
        $result = fetchOne("SELECT warna_utama, warna_teks, maps FROM pengaturan LIMIT 1");
        
        if ($result['warna_utama'] === $testWarna) {
            echo "<div class='alert alert-success'>✅ Test SAVE: SUKSES!</div>";
            echo "<div class='alert alert-info'>Data berhasil disimpan:</div>";
            echo "<ul>";
            echo "<li>warna_utama: <span style='display:inline-block;width:30px;height:30px;background-color:" . $result['warna_utama'] . ";border:1px solid #ccc;'></span> " . $result['warna_utama'] . "</li>";
            echo "<li>warna_teks: " . $result['warna_teks'] . "</li>";
            echo "<li>maps: " . htmlspecialchars($result['maps']) . "</li>";
            echo "</ul>";
        } else {
            echo "<div class='alert alert-danger'>❌ Test SAVE: GAGAL!</div>";
            echo "<p>Expected: $testWarna</p>";
            echo "<p>Got: " . $result['warna_utama'] . "</p>";
        }
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>❌ Test GAGAL: " . $e->getMessage() . "</div>";
    }
    
    echo "</div></div>";
    
    // Important notice
    echo "<div class='alert alert-warning'>
        <h5>⚠️ Penting: Perhatian!</h5>
        <p>Data <strong>tampilan</strong> tersimpan di tabel <code>pengaturan</code>, bukan di tabel <code>tampilan</code>.</p>
        <p>Setelah Anda menyimpan warna di <strong>admin/tampilan.php</strong>, cek kolom-kolom berikut di tabel <strong>pengaturan</strong>:</p>
        <ul>
            <li><code>warna_utama</code></li>
            <li><code>warna_teks</code></li>
            <li><code>logo</code></li>
        </ul>
        <p><strong>JANGAN</strong> cari di tabel <code>tampilan</code> karena tabel tersebut tidak ada.</p>
    </div>";
    
    // Links to admin pages
    echo "<div class='card'>
        <div class='card-header bg-dark text-white'>
            <h5 class='mb-0'>🚀 Test Simpan di Admin Panel</h5>
        </div>
        <div class='card-body'>
            <p>Sekarang coba simpan data di halaman admin berikut:</p>
            <div class='list-group'>
                <a href='admin/tampilan.php' target='_blank' class='list-group-item list-group-item-action'>
                    <strong>admin/tampilan.php</strong> - Ganti warna dan klik Simpan
                </a>
                <a href='admin/kontak.php' target='_blank' class='list-group-item list-group-item-action'>
                    <strong>admin/kontak.php</strong> - Isi kontak dan klik Simpan
                </a>
                <a href='admin/pengaturan.php' target='_blank' class='list-group-item list-group-item-action'>
                    <strong>admin/pengaturan.php</strong> - Isi data sekolah dan klik Simpan
                </a>
            </div>
            <p class='mt-3 mb-0'>Setelah menyimpan, kembali ke sini dan refresh halaman ini untuk melihat data yang tersimpan.</p>
        </div>
    </div>";
    
} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>
        <h5>❌ Error Database</h5>
        <p>" . $e->getMessage() . "</p>
    </div>";
}

echo "</div>
</body>
</html>";
?>