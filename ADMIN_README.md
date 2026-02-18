# Panel Admin Backend - SLB Rumah Kita Batam

## 📋 Overview

Panel admin ini adalah sistem manajemen konten lengkap untuk website sekolah SLB Rumah Kita Batam. Panel ini memungkinkan administrator untuk mengelola seluruh konten website dari satu tempat.

## 🔐 Login

- **URL:** `http://localhost/sekolah/admin/login.php`
- **Username:** `admin`
- **Password:** `admin123`

*Catatan: Password default dapat diubah melalui database.*

## 📊 Fitur Panel Admin

### 1. Dashboard
- Statistik jumlah berita, galeri, guru, dan halaman
- Akses cepat untuk menambah konten
- Preview berita dan galeri terbaru

### 2. Manajemen Berita
- ✅ Tambah berita baru
- ✅ Edit berita yang ada
- ✅ Hapus berita
- ✅ Upload gambar berita
- ✅ Rich Text Editor (CKEditor)
- ✅ Menetapkan tanggal dan penulis

### 3. Manajemen Galeri
- ✅ Upload foto galeri
- ✅ Edit judul dan deskripsi
- ✅ Hapus foto
- ✅ Preview gambar

### 4. Manajemen Guru & Staf
- ✅ Tambah data guru
- ✅ Upload foto guru
- ✅ Set jabatan dan deskripsi
- ✅ Atur urutan tampilan
- ✅ Aktif/nonaktifkan guru

### 5. Manajemen Halaman & Menu
- ✅ Tambah halaman baru
- ✅ Edit konten halaman
- ✅ Hapus halaman
- ✅ Atur urutan menu
- ✅ Aktif/nonaktifkan menu
- ✅ Pilih icon untuk menu

### 6. Manajemen Tampilan Website
- ✅ Upload logo utama
- ✅ Upload favicon
- ✅ Upload background (beranda, halaman, footer)
- ✅ Atur warna utama
- ✅ Atur warna teks
- ✅ Pilih font website

### 7. Manajemen Kontak
- ✅ Edit nama sekolah
- ✅ Edit alamat
- ✅ Edit nomor telepon
- ✅ Edit email
- ✅ Setup Google Maps embed
- ✅ Setup media sosial (Facebook, Instagram, YouTube)
- ✅ Setup WhatsApp

### 8. Pengaturan Website
- ✅ Meta Title (SEO)
- ✅ Meta Description (SEO)
- ✅ Meta Keywords (SEO)
- ✅ Teks Footer

## 🗄️ Struktur Database

### Tabel yang digunakan:
1. **users** - Data administrator
2. **berita** - Konten berita
3. **galeri** - Foto galeri
4. **halaman** - Halaman statis
5. **pengaturan** - Konfigurasi website
6. **tampilan** - Tampilan website (logo, background, warna)
7. **guru** - Data guru dan staf

## 📁 Struktur Folder

```
sekolah/
├── admin/              # Panel admin
│   ├── index.php      # Dashboard
│   ├── login.php      # Halaman login
│   ├── logout.php     # Logout
│   ├── auth.php       # Autentikasi
│   ├── berita.php     # Manajemen berita
│   ├── galeri.php     # Manajemen galeri
│   ├── profil.php     # Manajemen profil sekolah
│   ├── guru.php       # Manajemen guru & staf
│   ├── halaman.php    # Manajemen halaman & menu
│   ├── tampilan.php   # Manajemen tampilan
│   ├── kontak.php     # Manajemen kontak
│   └── pengaturan.php # Pengaturan website
├── config/
│   └── database.php   # Koneksi database
├── uploads/           # File yang diupload
│   ├── berita/
│   ├── galeri/
│   ├── guru/
│   └── tampilan/
└── *.php              # Halaman frontend
```

## 🚀 Cara Menggunakan

### 1. Login ke Admin Panel
1. Buka browser dan kunjungi `http://localhost/sekolah/admin/login.php`
2. Masukkan username dan password
3. Klik tombol "Login"

### 2. Menambah Berita
1. Masuk ke menu "Berita"
2. Klik tombol "Tambah Berita"
3. Isi judul, tanggal, penulis
4. Upload gambar (opsional)
5. Tulis isi berita menggunakan editor
6. Klik "Simpan"

### 3. Menambah Guru
1. Masuk ke menu "Guru & Staf"
2. Klik "Tambah Guru"
3. Isi nama lengkap dan jabatan
4. Upload foto
5. Tulis deskripsi singkat
6. Atur urutan tampilan
7. Centang "Aktif" untuk menampilkan di website
8. Klik "Simpan"

### 4. Mengubah Tampilan
1. Masuk ke menu "Tampilan Website"
2. Upload logo dan favicon
3. Upload background untuk beranda, halaman, dan footer
4. Pilih warna utama dan warna teks
5. Pilih font yang diinginkan
6. Klik "Simpan Perubahan"

### 5. Mengatur Kontak
1. Masuk ke menu "Kontak"
2. Isi informasi sekolah
3. Paste embed code dari Google Maps
4. Isi URL media sosial
5. Klik "Simpan Perubahan"

## 🔒 Keamanan

- Session-based authentication
- Proteksi halaman admin dengan `auth.php`
- Password di-hash menggunakan bcrypt
- Validasi input form
- Upload file dengan filter ekstensi

## 🎨 Desain UI

- Framework: Bootstrap 5.3
- Font: Poppins (Google Fonts)
- Icons: Font Awesome 6.4
- Rich Text Editor: CKEditor 4
- Warna tema: Biru gradient (#4A90E2 - #357ABD)
- Layout: Sidebar kiri, konten di kanan

## 📱 Responsif

Panel admin sepenuhnya responsif dan dapat diakses dari:
- Desktop (lebar penuh)
- Tablet (sidebar menyesuaikan)
- Mobile (sidebar collapsible)

## 🛠️ Teknologi yang Digunakan

- **Backend:** PHP Native
- **Database:** MySQL
- **Frontend Framework:** Bootstrap 5.3
- **Icons:** Font Awesome 6.4
- **Editor:** CKEditor 4
- **Fonts:** Google Fonts (Poppins)

## 📝 Catatan Penting

1. **Pastikan folder uploads memiliki permission 777**
2. **Jalankan database_update.sql untuk membuat tabel baru**
3. **Password default admin adalah: admin123**
4. **Semua gambar akan diupload ke folder uploads/**
5. **Pastikan PHP GD library aktif untuk upload gambar**

## 🔧 Troubleshooting

### Tidak bisa upload gambar
- Pastikan folder `uploads/` ada
- Pastikan permission folder adalah 777
- Cek PHP upload_max_filesize di php.ini

### Tidak bisa login
- Cek apakah password sudah di-hash di database
- Pastikan session aktif di server
- Clear cache browser

### Database error
- Pastikan database `rumahkitabtmweb_ftth` ada
- Jalankan SQL file untuk membuat tabel
- Cek kredensial database di `config/database.php`

## 📞 Support

Untuk bantuan lebih lanjut, hubungi developer atau cek dokumentasi PHP/MySQL.

---

**Versi:** 1.0.0  
**Last Updated:** 2024  
**Developer:** Cline AI Assistant