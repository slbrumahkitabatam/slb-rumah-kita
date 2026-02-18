# 🔧 Perbaikan Sistem Upload Gambar

## Ringkasan Perbaikan

Semua masalah upload gambar telah diperbaiki. Berikut adalah perubahan yang dilakukan:

## Masalah yang Ditemukan

1. **Tanpa Error Handling**: Upload bisa gagal tanpa pesan error yang jelas
2. **Tanpa Validasi File**: Tidak ada validasi tipe file dan ukuran file
3. **Tanpa Cleanup**: Jika database gagal, file yang sudah diupload tidak dihapus
4. **Tanpa Feedback**: User tidak tahu kenapa upload gagal
5. **Folder Permissions**: Folder upload mungkin tidak writable

## Perbaikan yang Dilakukan

### 1. admin/galeri.php
- ✅ Menambahkan validasi tipe file (JPG, PNG, GIF, WEBP)
- ✅ Menambahkan validasi ukuran file (max 5MB)
- ✅ Menambahkan error handling yang detail
- ✅ Menambahkan try-catch untuk database operations
- ✅ Auto-delete file jika database insert/update gagal
- ✅ Menampilkan pesan error yang jelas kepada user
- ✅ Auto-create folder jika tidak ada

### 2. admin/berita.php
- ✅ Semua perbaikan yang sama seperti galeri.php
- ✅ Menangani update gambar dengan menghapus gambar lama
- ✅ Validasi dan error handling yang lengkap

### 3. test_upload.php (Baru)
- ✅ Script diagnostic untuk mengecek sistem
- ✅ Cek konfigurasi PHP
- ✅ Cek permission folder uploads
- ✅ Auto-create folder jika perlu
- ✅ Test database connection
- ✅ Test upload gambar secara langsung

## Cara Menggunakan

### 1. Test Sistem

Buka browser dan akses:
```
http://localhost/sekolah/test_upload.php
```

Script ini akan:
- Menampilkan konfigurasi PHP Anda
- Mengecek apakah folder uploads sudah ada dan writable
- Membuat folder jika belum ada
- Mengecek database dan tabel
- Memberikan form untuk test upload gambar

### 2. Cek Folder Uploads

Pastikan folder berikut ada dan writable:
```
sekolah/uploads/
sekolah/uploads/galeri/
sekolah/uploads/berita/
```

Jika folder tidak ada, script test_upload.php akan membuatnya secara otomatis.

### 3. Upload Gambar

**Untuk Galeri:**
1. Login ke admin panel
2. Buka menu Galeri
3. Klik "Upload Foto"
4. Isi judul dan deskripsi
5. Pilih file gambar (JPG, PNG, GIF, atau WEBP, max 5MB)
6. Klik "Simpan"

**Untuk Berita:**
1. Login ke admin panel
2. Buka menu Berita
3. Klik "Tambah Berita"
4. Isi judul, tanggal, penulis, dan isi berita
5. Pilih file gambar (opsional untuk berita)
6. Klik "Simpan"

## Error Messages

Jika upload gagal, Anda akan melihat pesan error yang jelas:

- **"Ukuran file melebihi batas maximum"** - File terlalu besar
- **"Tipe file tidak diizinkan"** - File bukan gambar yang valid
- **"Gagal menyimpan file ke server"** - Permission problem pada folder uploads
- **"Gagal menyimpan ke database"** - Masalah koneksi atau query database

## Troubleshooting

### Upload Gagal - Permission Denied

**Masalah:** "Gagal menyimpan file ke server. Periksa permission folder uploads."

**Solusi:**
1. Pastikan folder `uploads/` dan subfoldernya ada
2. Di Windows, pastikan folder tidak Read-only
3. Di Linux/Mac, jalankan perintah:
   ```bash
   chmod -R 777 uploads/
   ```

### Upload Gagal - File Too Large

**Masalah:** "Ukuran file terlalu besar. Maksimal 5MB."

**Solusi:**
1. Kompres atau resize gambar sebelum upload
2. Atau ubah limit di php.ini:
   ```ini
   upload_max_filesize = 10M
   post_max_size = 10M
   ```

### Database Error

**Masalah:** "Gagal menyimpan ke database: ..."

**Solusi:**
1. Pastikan database tersambung
2. Cek apakah tabel `galeri` dan `berita` ada
3. Pastikan kolom `gambar` ada di tabel yang sesuai
4. Jalankan test_upload.php untuk diagnosa

## Struktur Folder Setelah Perbaikan

```
sekolah/
├── uploads/
│   ├── galeri/       (untuk foto galeri)
│   │   └── [nama file unik].jpg
│   └── berita/       (untuk gambar berita)
│       └── [nama file unik].jpg
├── admin/
│   ├── galeri.php    (sudah diperbaiki)
│   └── berita.php    (sudah diperbaiki)
└── test_upload.php   (script diagnostic baru)
```

## Validasi File

Sistem sekarang memvalidasi:
- ✅ Tipe MIME file (hanya gambar yang diizinkan)
- ✅ Ukuran file (maksimal 5MB)
- ✅ Error code dari PHP upload
- ✅ Kehadiran file di temporary location
- ✅ Kemampuan menulis ke folder uploads

## Keamanan

- Nama file di-generate secara unik (menggunakan `uniqid()`)
- Validasi tipe file menggunakan `finfo()` (tidak hanya ekstensi)
- File yang gagal dihapus untuk mencegah file orphaned
- Permission folder yang aman

## Support

Jika masih mengalami masalah:
1. Jalankan `test_upload.php` untuk diagnosa
2. Cek error log PHP: `error_log()`
3. Cek error log Apache/Nginx
4. Pastikan database connection berjalan dengan baik

---

**Diperbarui:** 18 Februari 2026  
**Status:** ✅ Selesai dan teruji