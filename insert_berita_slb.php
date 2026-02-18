<?php
require_once 'config/database.php';

// Data 5 Berita tentang SLB
$berita_list = [
    [
        'judul' => 'Siswa SLB Rumah Kita Raih Juara 1 Lomba Melukis Tingkat Kota Batam',
        'isi' => '<p>Selamat kepada siswa-siswi SLB Rumah Kita Batam yang telah meraih prestasi membanggakan dalam ajang Lomba Melukis Tingkat Kota Batam yang diselenggarakan pada tanggal 10 Februari 2026.</p>
        
        <p>Dalam kompetisi ini, tiga siswa kami berhasil membawa pulang berbagai penghargaan:</p>
        <ul>
            <li><strong>Juara 1</strong> - Budi Santoso (Kelas VII)</li>
            <li><strong>Juara 2</strong> - Siti Aminah (Kelas VIII)</li>
            <li><strong>Juara Harapan 1</strong> - Ahmad Rizky (Kelas VI)</li>
        </ul>
        
        <p>Kepala Sekolah SLB Rumah Kita, Bapak Dr. H. Ahmad Fauzi, M.Pd menyatakan kebanggaannya atas pencapaian para siswa. "Prestasi ini membuktikan bahwa anak-anak berkebutuhan khusus memiliki bakat dan potensi luar biasa yang dapat dikembangkan dengan dukungan yang tepat," ujarnya.</p>
        
        <p>Lomba ini diikuti oleh 150 peserta dari berbagai sekolah di Kota Batam, termasuk sekolah umum dan sekolah inklusi. Karya-karya siswa SLB Rumah Kita mendapat pujian dari dewan juri karena keunikan ekspresi seni dan warna yang cerah.</p>
        
        <p>Semoga prestasi ini menjadi motivasi bagi siswa lain untuk terus mengembangkan bakat dan potensi mereka. Terima kasih kepada para guru dan orang tua yang telah mendukung penuh perjalanan siswa-siswi kami.</p>',
        'tanggal' => '2026-02-10',
        'penulis' => 'Admin'
    ],
    [
        'judul' => 'Pembukaan Program Pelatihan Keterampilan Vokasi untuk Siswa SLB',
        'isi' => '<p>SLB Rumah Kita Batam secara resmi membuka program pelatihan keterampilan vokasi baru untuk meningkatkan kemandirian dan kesiapan kerja bagi para siswa. Program ini dirancang khusus untuk mempersiapkan siswa dalam menghadapi dunia kerja setelah lulus sekolah.</p>
        
        <h3>Program yang Tersedia:</h3>
        <ol>
            <li><strong>Pelatihan Komputer Dasar</strong> - Mengoperasikan Microsoft Office dan aplikasi produktivitas lainnya</li>
            <li><strong>Tata Boga</strong> - Memasak dan penyiapan makanan sederhana</li>
            <li><strong>Kerajinan Tangan</strong> - Membuat berbagai produk kerajinan dari limbah</li>
            <li><strong>Pertanian Urban</strong> - Menanam dan merawat tanaman hidroponik</li>
            <li><strong>Otomotif Dasar</strong> - Perbaikan dan perawatan sepeda motor</li>
        </ol>
        
        <p>Program pelatihan ini akan dijalankan selama 6 bulan dengan kurikulum yang disesuaikan dengan kemampuan setiap siswa. Para siswa akan mendapatkan sertifikat kompetensi setelah menyelesaikan program.</p>
        
        <p>"Kami berharap program ini dapat membekali siswa dengan keterampilan praktis yang berguna untuk kehidupan mereka di masa depan," kata Ibu Sari Wulandari, S.Pd, Koordinator Program Vokasi.</p>
        
        <p>Pendaftaran program ini telah dibuka dan akan dimulai pada bulan Maret 2026. Untuk informasi lebih lanjut, silakan menghubungi bagian administrasi sekolah.</p>',
        'tanggal' => '2026-02-08',
        'penulis' => 'Admin'
    ],
    [
        'judul' => 'Kunjungan Edukasi ke Museum Batam untuk Siswa SLB',
        'isi' => '<p>Seluruh siswa SLB Rumah Kita Batam mengikuti kegiatan kunjungan edukasi ke Museum Batam pada tanggal 5 Februari 2026. Kunjungan ini bertujuan untuk memperluas wawasan dan pengalaman belajar siswa di luar lingkungan sekolah.</p>
        
        <p>Selama di museum, siswa diajak untuk mengenal sejarah Batam, budaya Melayu, serta perkembangan kota Batam dari masa ke masa. Kegiatan ini dipandu oleh pemandu museum yang berpengalaman dan para guru pendamping.</p>
        
        <h3>Agenda Kunjungan:</h3>
        <ul>
            <li>Pembukaan dan penjelasan singkat tentang museum</li>
            <li>Tur ke berbagai zona pameran</li>
            <li>Demonstrasi alat-alat tradisional Melayu</li>
            <li>Workshop membuat kerajinan khas Batam</li>
            <li> sesi tanya jawab interaktif</li>
        </ul>
        
        <p>Siswa-siswi tampak antusias mengikuti kegiatan ini. Mereka berinteraksi aktif dengan pemandu museum, mengajukan berbagai pertanyaan, dan mencoba langsung alat-alat yang dipamerkan.</p>
        
        <p>"Kegiatan kunjungan edukasi ini sangat bermanfaat untuk membuka wawasan siswa tentang sejarah dan budaya. Ini juga membantu mereka melatih kemampuan sosial dan komunikasi," ujar Bapak Bambang Sutrisno, Guru Kelas VIII.</p>
        
        <p>Kedepannya, pihak sekolah merencanakan kunjungan edukasi ke berbagai tempat menarik lainnya di Batam dan sekitarnya.</p>',
        'tanggal' => '2026-02-05',
        'penulis' => 'Admin'
    ],
    [
        'judul' => 'Workshop Peningkatan Kompetensi Guru SLB se-Batam',
        'isi' => '<p>SLB Rumah Kita Batam menjadi tuan rumah acara Workshop Peningkatan Kompetensi Guru SLB se-Kota Batam yang diselenggarakan pada tanggal 3-4 Februari 2026. Acara ini diikuti oleh 75 guru dari berbagai SLB di Batam.</p>
        
        <h3>Tema Workshop:</h3>
        <p>"Inovasi Pembelajaran Inklusif untuk Siswa Berkebutuhan Khusus di Era Digital"</p>
        
        <h3>Materi yang Dibahas:</h3>
        <ol>
            <li><strong>Metode Pembelajaran Adaptif</strong> - Strategi mengajar yang disesuaikan dengan kebutuhan individual siswa</li>
            <li><strong>Technology-Assisted Learning</strong> - Pemanfaatan teknologi dalam pembelajaran SLB</li>
            <li><strong>Behavioral Management</strong> - Teknik manajemen perilaku siswa di kelas</li>
            <li><strong>Assessment & Evaluation</strong> - Penilaian dan evaluasi pembelajaran yang efektif</li>
            <li><strong>Collaboration with Parents</strong> - Kerjasama guru dan orang tua dalam mendukung siswa</li>
        </ol>
        
        <p>Workshop ini menghadirkan narasumber ahli dari Dinas Pendidikan Kota Batam, Universitas Internasional Batam, serta praktisi pendidikan SLB berpengalaman.</p>
        
        <p>Kepala Dinas Pendidikan Kota Batam, Bapak Drs. H. Muhammad Yusuf, M.Si yang membuka acara ini menyatakan, "Peningkatan kompetensi guru adalah kunci utama dalam meningkatkan kualitas pendidikan bagi anak berkebutuhan khusus. Kami mengapresiasi SLB Rumah Kita yang telah menginisiasi kegiatan ini."</p>
        
        <p>Peserta workshop menyambut baik acara ini dan berharap dapat dijadikan agenda rutin tahunan untuk berbagi praktik baik antar guru SLB.</p>',
        'tanggal' => '2026-02-03',
        'penulis' => 'Admin'
    ],
    [
        'judul' => 'Perayaan Hari Penyandang Disabilitas Internasional di SLB Rumah Kita',
        'isi' => '<p>SLB Rumah Kita Batam menyelenggarakan perayaan Hari Penyandang Disabilitas Internasional (International Day of Persons with Disabilities) yang jatuh setiap tanggal 3 Desember, namun dirayakan pada tanggal 1 Februari 2026 bersamaan dengan kegiatan rutin sekolah.</p>
        
        <h3>Tema Perayaan Tahun 2026:</h3>
        <p>"Toward an Inclusive and Accessible World for All"</p>
        
        <h3>Rangkaian Kegiatan:</h3>
        <ul>
            <li><strong>Pembukaan Upacara</strong> - Upacara bendera dan pidato tentang inklusi</li>
            <li><strong>Pentas Seni Siswa</strong> - Penampilan tari, musik, dan drama oleh siswa</li>
            <li><strong>Pameran Karya Siswa</strong> - Menampilkan hasil karya seni dan kerajinan tangan</li>
            <li><strong>Lomba Kreasi</strong> - Berbagai lomba kreatif untuk semua siswa</li>
            <li><strong>Sesi Berbagi</strong> - Cerita inspiratif dari alumni dan tamu undangan</li>
        </ul>
        
        <p>Acara ini dihadiri oleh berbagai tamu undangan, termasuk perwakilan dari Dinas Sosial, Dinas Pendidikan, LSM peduli disabilitas, serta orang tua siswa.</p>
        
        <p>Dalam sambutannya, Ketua Komite Sekolah, Ibu Rina Kartika mengatakan, "Perayaan ini adalah wujud nyata komitmen kami untuk mempromosikan kesetaraan dan inklusi bagi semua. Setiap anak berhak mendapatkan pendidikan yang berkualitas, tanpa memandang kondisi fisik atau mentalnya."</p>
        
        <p>Para siswa tampak sangat antusias mengikuti berbagai kegiatan. Mereka menunjukkan bakat dan kemampuan luar biasa melalui penampilan seni dan karya yang ditampilkan.</p>
        
        <p>Pihak sekolah berharap perayaan ini dapat meningkatkan kesadaran masyarakat tentang pentingnya inklusi dan menghilangkan stigma terhadap penyandang disabilitas.</p>',
        'tanggal' => '2026-02-01',
        'penulis' => 'Admin'
    ]
];

// Insert berita ke database
$success_count = 0;
$error_count = 0;

foreach ($berita_list as $berita) {
    // Generate slug
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $berita['judul'])));
    
    try {
        execute(
            "INSERT INTO berita (judul, slug, isi, tanggal, penulis) VALUES (?, ?, ?, ?, ?)",
            [$berita['judul'], $slug, $berita['isi'], $berita['tanggal'], $berita['penulis']]
        );
        $success_count++;
        echo "✓ Berita berhasil ditambahkan: " . $berita['judul'] . "\n";
    } catch (Exception $e) {
        $error_count++;
        echo "✗ Gagal menambahkan berita: " . $berita['judul'] . "\n";
        echo "  Error: " . $e->getMessage() . "\n";
    }
}

echo "\n=== Summary ===\n";
echo "Berhasil: $success_count berita\n";
echo "Gagal: $error_count berita\n";
echo "\nTotal berita di database: " . count(fetchAll("SELECT * FROM berita")) . "\n";