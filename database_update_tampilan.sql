-- Tambah kolom warna ke tabel pengaturan
ALTER TABLE pengaturan ADD COLUMN warna_utama VARCHAR(7) DEFAULT '#667eea';
ALTER TABLE pengaturan ADD COLUMN warna_teks VARCHAR(7) DEFAULT '#333333';

-- Update pengaturan yang sudah ada dengan warna default
UPDATE pengaturan SET warna_utama = '#667eea', warna_teks = '#333333' WHERE warna_utama IS NULL;