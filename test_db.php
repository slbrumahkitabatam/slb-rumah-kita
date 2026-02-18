<?php
// Test database connection
require_once 'config/database.php';

echo "<h1>Database Connection Test</h1>";

// Test connection
try {
    echo "<p>✅ Database connection successful!</p>";
    echo "<p><strong>Database:</strong> " . DB_NAME . "</p>";
    echo "<p><strong>Host:</strong> " . DB_HOST . "</p>";
} catch (Exception $e) {
    echo "<p>❌ Database connection failed: " . $e->getMessage() . "</p>";
    exit;
}

// Check tables
echo "<h2>Checking Tables...</h2>";
$tables = ['users', 'berita', 'galeri', 'halaman', 'pengaturan', 'guru'];
foreach ($tables as $table) {
    $result = $pdo->query("SHOW TABLES LIKE '$table'");
    if ($result->rowCount() > 0) {
        echo "<p>✅ Table '$table' exists</p>";
    } else {
        echo "<p>❌ Table '$table' does NOT exist</p>";
    }
}

// Check data in halaman table
echo "<h2>Data in Halaman Table</h2>";
$halaman_data = fetchAll("SELECT * FROM halaman");
if ($halaman_data) {
    echo "<p>✅ Found " . count($halaman_data) . " pages:</p>";
    echo "<ul>";
    foreach ($halaman_data as $page) {
        $content_preview = strlen($page['isi']) > 100 ? substr($page['isi'], 0, 100) . '...' : $page['isi'];
        echo "<li><strong>{$page['judul']}</strong> (slug: {$page['slug']})<br><small>{$content_preview}</small></li>";
    }
    echo "</ul>";
} else {
    echo "<p>❌ No data found in halaman table</p>";
}

// Check data in berita table
echo "<h2>Data in Berita Table</h2>";
$berita_data = fetchAll("SELECT * FROM berita");
if ($berita_data) {
    echo "<p>✅ Found " . count($berita_data) . " news items:</p>";
    echo "<ul>";
    foreach ($berita_data as $item) {
        $content_preview = strlen($item['isi']) > 100 ? substr($item['isi'], 0, 100) . '...' : $item['isi'];
        echo "<li><strong>{$item['judul']}</strong> by {$item['penulis']}<br><small>{$content_preview}</small></li>";
    }
    echo "</ul>";
} else {
    echo "<p>❌ No data found in berita table</p>";
}

// Check data in guru table
echo "<h2>Data in Guru Table</h2>";
$guru_data = fetchAll("SELECT * FROM guru");
if ($guru_data) {
    echo "<p>✅ Found " . count($guru_data) . " teachers/staff:</p>";
    echo "<ul>";
    foreach ($guru_data as $item) {
        echo "<li><strong>{$item['nama']}</strong> - {$item['jabatan']}</li>";
    }
    echo "</ul>";
} else {
    echo "<p>❌ No data found in guru table</p>";
}

// Check settings
echo "<h2>Pengaturan</h2>";
$pengaturan = fetchOne("SELECT * FROM pengaturan LIMIT 1");
if ($pengaturan) {
    echo "<p>✅ Settings found:</p>";
    echo "<ul>";
    echo "<li><strong>Nama Sekolah:</strong> " . htmlspecialchars($pengaturan['nama_sekolah'] ?? 'Not set') . "</li>";
    echo "<li><strong>Alamat:</strong> " . htmlspecialchars($pengaturan['alamat'] ?? 'Not set') . "</li>";
    echo "<li><strong>Telepon:</strong> " . htmlspecialchars($pengaturan['telepon'] ?? 'Not set') . "</li>";
    echo "<li><strong>Email:</strong> " . htmlspecialchars($pengaturan['email'] ?? 'Not set') . "</li>";
    echo "</ul>";
} else {
    echo "<p>❌ No settings found</p>";
}

echo "<hr>";
echo "<p><a href='index.php'>← Back to Homepage</a></p>";
?>