# Panduan Galeri SLB Rumah Kita

## 📸 5 Galeri Menarik Tentang SLB

Sistem galeri telah diperbarui dengan 5 kategori menarik yang relevan untuk SLB (Sekolah Luar Biasa):

### 1. 📚 Galeri Kegiatan Belajar (KBM)
**Warna:** Biru (#4A90E2)  
**Icon:** Chalkboard Teacher

Dokumentasi kegiatan belajar mengajar di kelas, meliputi:
- Siswa belajar membaca
- Praktik melukis dalam seni rupa
- Belajar komputer di laboratorium
- Pelajaran matematika dengan alat peraga
- Membaca Al-Quran

**Tujuan:** Menunjukkan proses pembelajaran yang interaktif dan menyenangkan untuk siswa berkebutuhan khusus.

---

### 2. ⚽ Galeri Ekstrakurikuler
**Warna:** Oranye (#F5A623)  
**Icon:** Sepak Bola

Dokumentasi kegiatan ekstrakurikuler untuk pengembangan bakat dan keterampilan siswa:
- Olahraga basket
- Seni tari tradisional
- Paduan suara
- Kerajinan tangan dari barang bekas
- Bercocok tanam di kebun sekolah

**Tujuan:** Menampilkan aktivitas non-akademik yang membantu pengembangan kreativitas dan keterampilan siswa.

---

### 3. 🏆 Galeri Prestasi Siswa
**Warna:** Merah (#E74C3C)  
**Icon:** Piala

Dokumentasi prestasi dan pencapaian siswa dalam berbagai kompetisi:
- Juara 1 Lomba Melukis tingkat kota
- Medali Emas Olimpiade Matematika Khusus
- Juara 2 Lomba Paduan Suara tingkat provinsi
- Penghargaan Siswa Berprestasi
- Juara 2 Turnamen Basket

**Tujuan:** Menginspirasi dan menunjukkan potensi siswa berkebutuhan khusus untuk berprestasi.

---

### 4. 📅 Galeri Kegiatan Sekolah
**Warna:** Ungu (#9B59B6)  
**Icon:** Kalender

Dokumentasi kegiatan-kegiatan besar di sekolah:
- Perayaan Hari Kemerdekaan Indonesia
- Ulang Tahun Sekolah
- Kunjungan Studi Banding dari SLB lain
- Bakti Sosial Pengobatan Gratis
- Wisuda Siswa

**Tujuan:** Menunjukkan kehidupan sekolah yang aktif dan berkontribusi pada masyarakat.

---

### 5. 🏢 Galeri Fasilitas Sekolah
**Warna:** Hijau (#1ABC9C)  
**Icon:** Gedung

Dokumentasi fasilitas dan sarana yang tersedia di sekolah:
- Ruang kelas SDLB yang nyaman
- Laboratorium komputer lengkap
- Ruang terapi khusus
- Perpustakaan dengan koleksi lengkap
- Lapangan olahraga (basket dan voli)

**Tujuan:** Menunjukkan kualitas fasilitas yang mendukung pembelajaran siswa berkebutuhan khusus.

---

## 🚀 Cara Install & Menggunakan

### Langkah 1: Update Database
Jalankan file SQL untuk menambahkan kolom kategori dan data contoh:

```bash
# Jika menggunakan phpMyAdmin:
1. Buka phpMyAdmin
2. Pilih database slb_rumah_kita
3. Klik tab SQL
4. Copy dan paste isi file database_update_galeri.sql
5. Klik Go

# Atau via command line:
mysql -u root -p slb_rumah_kita < database_update_galeri.sql
```

### Langkah 2: Siapkan Folder Upload
Buat folder untuk menyimpan gambar galeri:

```bash
# Pastikan folder uploads/galeri sudah ada
mkdir -p uploads/galeri
```

### Langkah 3: Upload Gambar (Opsional)
Upload gambar-gambar ke folder `uploads/galeri/` dengan nama file sesuai yang ada di database:
- kbm1.jpg, kbm2.jpg, kbm3.jpg, kbm4.jpg, kbm5.jpg
- eskul1.jpg, eskul2.jpg, eskul3.jpg, eskul4.jpg, eskul5.jpg
- prestasi1.jpg, prestasi2.jpg, prestasi3.jpg, prestasi4.jpg, prestasi5.jpg
- kegiatan1.jpg, kegiatan2.jpg, kegiatan3.jpg, kegiatan4.jpg, kegiatan5.jpg
- fasilitas1.jpg, fasilitas2.jpg, fasilitas3.jpg, fasilitas4.jpg, fasilitas5.jpg

**Catatan:** Jika gambar tidak ada, sistem akan otomatis menampilkan placeholder dengan warna sesuai kategori.

### Langkah 4: Akses Halaman Galeri
Buka browser dan akses:
```
http://localhost/sekolah/galeri.php
```

---

## ✨ Fitur Galeri

### 🎨 Desain Menarik
- Layout responsif untuk semua ukuran layar
- Kartu kategori dengan warna dan icon berbeda
- Efek hover yang smooth dan interaktif
- Badge kategori pada setiap gambar
- Overlay informasi saat mouse hover

### 🔍 Filter Kategori
- Klik kartu kategori untuk melihat galeri spesifik
- Judul kategori yang sedang aktif ditampilkan
- Tombol "Semua Galeri" untuk melihat semua kategori
- Pagination tetap berfungsi dengan filter kategori

### 📱 Responsive Design
- Tampilan optimal di desktop (4 kolom)
- Tampilan tablet (3 kolom)
- Tampilan mobile (2 kolom)
- Tombol kategori grid 2 kolom di mobile

### 🎯 User Experience
- Loading cepat dengan pagination
- Indikator visual untuk kategori aktif
- Pesan jika tidak ada galeri di kategori tertentu
- Link kembali ke semua galeri saat filter aktif

---

## 📝 Menambah Galeri Baru

### Via Admin Panel (Recommended)
1. Login ke admin panel
2. Masuk ke menu Galeri
3. Klik "Tambah Galeri"
4. Isi form:
   - Judul: Nama galeri
   - Deskripsi: Penjelasan singkat
   - Gambar: Upload file gambar
   - Tanggal: Tanggal kegiatan
   - Kategori: Pilih salah satu dari 5 kategori

### Via Database (Advanced)
```sql
INSERT INTO galeri (judul, deskripsi, gambar, tanggal, kategori) 
VALUES ('Judul Galeri', 'Deskripsi lengkap', 'nama-file.jpg', '2025-02-20', 'kbm');
```

Kategori yang tersedia:
- `kbm` - Kegiatan Belajar
- `eskul` - Ekstrakurikuler
- `prestasi` - Prestasi Siswa
- `kegiatan` - Kegiatan Sekolah
- `fasilitas` - Fasilitas

---

## 🎯 Tips Menggunakan Galeri

### Untuk Admin:
1. **Upload gambar berkualitas baik** (minimal 800x600 px)
2. **Gunakan nama file yang deskriptif** (misal: kbm-belajar-membaca.jpg)
3. **Isi deskripsi yang informatif** untuk memberikan konteks
4. **Update galeri secara rutin** untuk menunjukkan aktivitas terbaru
5. **Seimbangkan setiap kategori** agar galeri terlihat beragam

### Untuk Pengunjung:
1. **Klik kartu kategori** untuk melihat galeri spesifik
2. **Hover pada gambar** untuk melihat detail lebih lengkap
3. **Gunakan pagination** untuk navigasi ke halaman berikutnya
4. **Klik "Semua Galeri"** untuk kembali ke tampilan lengkap

---

## 🛠️ Customization

### Mengubah Warna Kategori
Edit file `galeri.php` di bagian array `$kategoriInfo`:

```php
$kategoriInfo = [
    'kbm' => ['nama' => 'Kegiatan Belajar', 'icon' => 'fa-chalkboard-teacher', 'color' => '#4A90E2'],
    // Ubah warna di sini
];
```

### Mengubah Jumlah Item per Halaman
Edit baris:
```php
$perPage = 8; // Ganti angka ini
```

### Mengubah Ukuran Gambar
Edit CSS di file `galeri.php`:
```css
.gallery-item img {
    height: 250px; /* Ubah tinggi gambar */
}
```

---

## 📞 Dukungan

Jika mengalami masalah:
1. Pastikan database sudah diupdate dengan file SQL yang benar
2. Cek koneksi database di `config/database.php`
3. Pastikan folder `uploads/galeri/` ada dan bisa ditulis
4. Pastikan gambar ada di folder yang sesuai

---

## 📄 Lisensi

Sistem galeri ini adalah bagian dari SLB Rumah Kita Batam dan dapat digunakan untuk keperluan pendidikan.