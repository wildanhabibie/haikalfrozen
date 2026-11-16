# haikalfrozen
This is my computer science bachelor's thesis project, which contains the code for my parents' online store that I created.

## Cara menjalankan (XAMPP)

1. Salin folder proyek ini ke `htdocs` (misalnya `C:\xampp\htdocs\haikalfrozen`).
2. Jalankan **Apache** dan **MySQL** dari XAMPP Control Panel.
3. Buka phpMyAdmin → tab **Import** → pilih `database/online_shop.sql` → **Go**.
   Ini membuat database `online_shop` beserta semua tabelnya.
4. Kalau user/password MySQL anda bukan `root` tanpa password, ubah di `includes/db.php`.
5. Buka `http://localhost/haikalfrozen/` untuk toko dan
   `http://localhost/haikalfrozen/admin/` untuk panel admin.

Login admin bawaan: **admin / admin123** (ganti lewat menu Pengaturan).

Catatan:
- Harga produk disimpan dalam **ribuan rupiah** (isi `25` untuk Rp25.000).
- Database lama tetap bisa dipakai: kolom `products.category_id` yang dibutuhkan
  filter kategori ditambahkan otomatis saat situs pertama kali dibuka.
- Pengiriman email di halaman Kontak hanya berfungsi di server yang sudah
  dikonfigurasi untuk `mail()`.
