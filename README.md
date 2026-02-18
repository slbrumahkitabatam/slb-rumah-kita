# Website SLB "Rumah Kita Batam"

Website profesional dan elegan untuk Sekolah Luar Biasa (SLB) "Rumah Kita Batam" yang dibangun dengan HTML, PHP, dan MySQL.

## 🌟 Fitur Utama

### Frontend (Website Publik)
- **Beranda** - Hero section, ringkasan profil, berita terbaru, dan galeri
- **Profil Sekolah** - Tentang sekolah, visi & misi, struktur organisasi, nilai & budaya
- **Berita & Kegiatan** - Daftar berita dengan pagination dan detail berita
- **Program & Layanan** - Informasi program pendidikan SDLB, SMPLB, SMALB dan layanan khusus
- **Galeri** - Galeri foto kegiatan sekolah dengan grid layout
- **Kontak** - Form kontak, informasi kontak, Google Maps, dan FAQ

### Backend (Admin Panel)
- **Dashboard** - Statistik, aktivitas terbaru, dan aksi cepat
- **Manajemen Berita** - Tambah, edit, hapus berita dengan upload gambar dan editor WYSIWYG (CKEditor)
- **Manajemen Galeri** - Upload dan hapus foto galeri
- **Manajemen Profil** - Edit tentang sekolah dan visi misi
- **Pengaturan** - Edit nama sekolah, logo, alamat, telepon, dan email
- **Autentikasi** - Sistem login aman dengan session management

## 🛠️ Teknologi

- **Frontend**: HTML5, CSS3, Bootstrap 5, JavaScript
- **Backend**: PHP 8+ dengan PDO (PHP Data Objects)
- **Database**: MySQL
- **Editor WYSIWYG**: CKEditor 4
- **Icons**: Font Awesome 6
- **Fonts**: Google Fonts (Poppins)

## 📦 Struktur Proyek

```
sekolah/
├── admin/                  # Admin Panel
│   ├── auth.php          # Autentikasi
│   ├── index.php         # Dashboard
│   ├── login.php         # Login page
│   ├── logout.php        # Logout
│   ├── berita.php        # Manajemen berita
│   ├── galeri.php        # Manajemen galeri
│   ├── profil.php        # Edit profil
│   └── pengaturan.php   # Pengaturan website
├── config/
│   └── database.php     # Konfigurasi database
├── includes/
│   ├── header.php        # Header + Navbar
│   └── footer.php        # Footer
├── uploads/              # Folder upload (dibuat otomatis)
│   ├── berita/          # Gambar berita
│   └── galeri/         # Foto galeri
├── index.php             # Halaman beranda
├── profil.php            # Halaman profil
├── berita.php            # Halaman berita
├── detail_berita.php     # Detail berita
├── program.php           # Halaman program
├── galeri.php           # Halaman galeri
├── kontak.php            # Halaman kontak
├── database.sql          # Schema database
└── README.md            # Dokumentasi
```

## 🚀 Instalasi

### Prasyarat
- Web server (Apache/Nginx)
- PHP 7.4 atau higher
- MySQL 5.7 atau higher
- Browser modern (Chrome, Firefox, Safari, Edge)

### Langkah Instalasi

1. **Clone atau download repository**
   ```bash
   cd /path/to/web/directory
   ```

2. **Setup Database**
   - Buat database baru di MySQL dengan nama `slb_rumah_kita`
   - Import file `database.sql` ke database
   ```bash
   mysql -u root -p slb_rumah_kita < database.sql
   ```
   Atau gunakan phpMyAdmin untuk import

3. **Konfigurasi Database**
   - Edit file `config/database.php` jika perlu:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('DB_NAME', 'slb_rumah_kita');
   ```

4. **Setup Permissions**
   - Pastikan folder `uploads/` dan subfoldernya memiliki permission write:
   ```bash
   chmod -R 755 uploads/
   ```

5. **Akses Website**
   - Website: `http://localhost/sekolah/`
   - Admin Panel: `http://localhost/sekolah/admin/`

### Login Default

**Username**: `admin`  
**Password**: `admin123`

⚠️ **Penting**: Ganti password default setelah login pertama untuk keamanan!

## 👤 Fitur Keamanan

- ✅ Password hashing dengan bcrypt
- ✅ Session management
- ✅ SQL injection prevention (PDO prepared statements)
- ✅ XSS protection (htmlspecialchars)
- ✅ File upload validation
- ✅ CSRF protection (ready to implement)

## 🎨 Desain & UX

- **Warna**: Biru lembut (#4A90E2) dengan nuansa profesional
- **Font**: Poppins untuk modernitas dan keterbacaan
- **Responsive**: Mobile-first approach, kompatibel di semua perangkat
- **Animasi**: Smooth dan tidak berlebihan
- **Aksesibilitas**: Kontras jelas dan navigasi sederhana

## 📝 Panduan Penggunaan

### Menambah Berita
1. Login ke Admin Panel
2. Menu Berita → Tambah Berita
3. Isi judul, tanggal, penulis, dan konten
4. Upload gambar (opsional)
5. Gunakan CKEditor untuk format teks
6. Klik Simpan

### Upload Galeri
1. Login ke Admin Panel
2. Menu Galeri → Upload Galeri
3. Upload foto dan isi judul serta deskripsi
4. Klik Simpan

### Edit Profil
1. Login ke Admin Panel
2. Menu Profil
3. Edit tentang sekolah dan visi misi
4. Gunakan format HTML untuk heading dan list
5. Klik Simpan Perubahan

### Pengaturan
1. Login ke Admin Panel
2. Menu Pengaturan
3. Edit nama sekolah, logo, alamat, telepon, email
4. Klik Simpan Pengaturan

## 🔧 Troubleshooting

### Database Connection Error
- Pastikan MySQL service berjalan
- Cek kredensial database di `config/database.php`
- Pastikan database `slb_rumah_kita` sudah dibuat

### Upload Gambar Gagal
- Pastikan folder `uploads/` dan subfoldernya ada
- Cek permission folder (755 atau 777)
- Cek PHP upload_max_filesize dan post_max_size

### Page Not Found (404)
- Pastikan web server (Apache/Nginx) sudah terinstall
- Cek file `.htaccess` jika menggunakan Apache
- Pastikan URL benar

## 📞 Dukungan

Jika mengalami masalah atau pertanyaan:
- Cek dokumentasi PHP di https://www.php.net/docs.php
- Cek dokumentasi MySQL di https://dev.mysql.com/doc/
- Cek dokumentasi Bootstrap di https://getbootstrap.com/docs/

## 📄 Lisensi

Proyek ini dibuat untuk SLB "Rumah Kita Batam". Anda bebas menggunakannya dan memodifikasinya sesuai kebutuhan.

## 👨‍💻 Pengembang

Website ini dikembangkan dengan ❤️ menggunakan teknologi web modern dan praktik terbaik dalam pengembangan PHP/MySQL.

---

**SLB Rumah Kita Batam** - Membangun Masa Depan Cerah bagi Anak Berkebutuhan Khusus