# Panduan Testing Fitur Lowongan Pekerjaan

## ✅ Checklist Komponen yang Sudah Siap

### 1. Database ✅
- ✅ Tabel `lowongan` sudah dibuat
- ✅ Tabel `lamaran` sudah dibuat
- ✅ 6 lowongan dummy sudah terisi

### 2. Storage Folders ✅
- ✅ `/storage/app/public/lowongan/logos` - untuk logo perusahaan
- ✅ `/storage/app/public/lamaran/cv` - untuk CV pelamar
- ✅ Symlink `public/storage` sudah dibuat
- ✅ Permission folder sudah 775

### 3. Models ✅
- ✅ Model `Lowongan` dengan fillable dan relasi lengkap
- ✅ Model `Lamaran` dengan fillable dan relasi lengkap
- ✅ Scope `active()` untuk filter lowongan aktif

### 4. Controller ✅
- ✅ LowonganController dengan 8 method lengkap:
  - `index()` - Daftar lowongan dengan filter
  - `show($id)` - Detail lowongan
  - `create()` - Form posting lowongan
  - `store()` - Simpan lowongan baru
  - `edit($id)` - Form edit lowongan
  - `update($id)` - Update lowongan
  - `destroy($id)` - Hapus lowongan
  - `apply($id)` - Melamar lowongan
  - `myApplications()` - Daftar lamaran saya

### 5. Routes ✅
- ✅ Semua routes sudah terdaftar dengan middleware auth yang benar
- ✅ Public routes: index, show
- ✅ Auth required: create, store, edit, update, destroy, apply, myApplications

### 6. Views ✅
- ✅ `index.blade.php` - Daftar lowongan dengan filter
- ✅ `show.blade.php` - Detail lowongan dengan tombol apply/edit/delete
- ✅ `create.blade.php` - Form posting lowongan
- ✅ `edit.blade.php` - Form edit lowongan
- ✅ `my-applications.blade.php` - Daftar lamaran saya
- ✅ Alert messages sudah ada di semua view

### 7. Middleware ✅
- ✅ Guest middleware untuk prevent double login
- ✅ Auth middleware untuk protect routes
- ✅ Permission check untuk edit/delete lowongan

## 🎯 Cara Testing Setiap Fitur

### Test 1: Lihat Daftar Lowongan (Public - Tidak Perlu Login)
**URL:** `/lowongan`

**Expected Result:**
- ✅ Tampil 6 lowongan dari seeder
- ✅ Filter by search, tipe, level, lokasi berfungsi
- ✅ Pagination berfungsi
- ✅ Card lowongan menampilkan info lengkap

**Cara Test:**
1. Buka browser
2. Akses `http://localhost:8000/lowongan`
3. Coba filter dan search
4. Klik detail lowongan

---

### Test 2: Posting Lowongan Baru (Auth Required)
**URL:** `/lowongan/create`

**Expected Result:**
- ✅ Form posting lowongan tampil
- ✅ Validasi bekerja
- ✅ Upload logo berfungsi
- ✅ Redirect ke index dengan success message
- ✅ Lowongan muncul di daftar

**Cara Test:**
1. Login sebagai alumni atau admin
2. Di halaman `/lowongan`, klik tombol "Posting Lowongan"
3. Isi semua field:
   - Judul: Test Web Developer
   - Perusahaan: PT Test Indonesia
   - Lokasi: Jakarta
   - Tipe: Full Time
   - Level: Entry Level
   - Deskripsi: (isi minimal 10 kata)
   - Kualifikasi: (isi minimal 10 kata)
   - Benefit: (opsional)
   - Gaji Min: 5000000
   - Gaji Max: 8000000
   - Email: test@test.com
   - Website: https://test.com
   - Tanggal Tutup: (pilih tanggal besok)
   - Logo: (upload gambar JPG/PNG max 2MB - OPSIONAL)
4. Klik "Simpan Lowongan"
5. ✅ Harus redirect ke `/lowongan` dengan alert "Lowongan berhasil ditambahkan!"
6. ✅ Lowongan baru muncul di daftar

**Troubleshooting:**
- Jika error "The given data was invalid" → cek tanggal tutup harus besok/nanti
- Jika error upload → cek permission folder storage
- Jika redirect ke login → cek sudah login atau belum

---

### Test 3: Melamar Pekerjaan (Auth Required)
**URL:** `/lowongan/{id}`

**Expected Result:**
- ✅ Tombol "Lamar Sekarang" tampil
- ✅ Modal apply muncul saat klik tombol
- ✅ Upload CV berfungsi
- ✅ Cover letter bisa diisi
- ✅ Alert success muncul setelah apply
- ✅ Tombol berubah jadi "Sudah Melamar"

**Cara Test:**
1. Login sebagai alumni
2. Akses salah satu lowongan `/lowongan/1`
3. Klik tombol "Lamar Sekarang"
4. Modal apply muncul
5. Upload CV (PDF/DOC/DOCX max 5MB - OPSIONAL)
6. Isi cover letter (OPSIONAL)
7. Klik "Kirim Lamaran"
8. ✅ Alert "Lamaran Anda berhasil dikirim!" muncul
9. ✅ Tombol berubah jadi "Sudah Melamar" (disabled, hijau)
10. ✅ Lamaran tersimpan di database

**Troubleshooting:**
- Jika modal tidak muncul → cek Bootstrap JS sudah loaded
- Jika error "Anda sudah melamar" → berarti sudah pernah apply, coba lowongan lain
- Jika error upload CV → cek permission folder storage

---

### Test 4: Lihat Status Lamaran (Auth Required)
**URL:** `/my-applications`

**Expected Result:**
- ✅ Tampil semua lamaran yang pernah disubmit
- ✅ Status lamaran (Pending/Diterima/Ditolak) tampil
- ✅ Link ke lowongan berfungsi
- ✅ Link download CV berfungsi
- ✅ Cover letter bisa dibuka/tutup (collapse)

**Cara Test:**
1. Login sebagai alumni
2. Di halaman `/lowongan`, klik tombol "Lamaran Saya"
3. ✅ Tampil daftar semua lamaran yang pernah disubmit
4. ✅ Badge status tampil dengan warna berbeda:
   - Pending: kuning
   - Diterima: hijau
   - Ditolak: merah
5. Klik "Lihat Detail" → redirect ke lowongan
6. Jika ada CV, klik link CV → download file
7. Klik "Lihat Cover Letter" → expand/collapse text

**Troubleshooting:**
- Jika kosong → berarti belum pernah apply, silakan apply dulu (Test 3)
- Jika link CV error → cek file ada di folder storage

---

### Test 5: Edit Lowongan Sendiri (Auth Required + Permission)
**URL:** `/lowongan/{id}/edit`

**Expected Result:**
- ✅ Hanya bisa edit lowongan yang diposting sendiri
- ✅ Admin bisa edit semua lowongan
- ✅ Form edit terisi data existing
- ✅ Bisa ubah semua field
- ✅ Bisa ubah status (Aktif/Ditutup/Draft)
- ✅ Bisa upload logo baru (logo lama terhapus)
- ✅ Redirect ke detail dengan success message

**Cara Test:**
1. Login sebagai alumni yang pernah posting lowongan
2. Buka lowongan yang diposting sendiri
3. Klik tombol "Edit" (kuning)
4. ✅ Form edit tampil dengan data existing
5. Ubah beberapa field (misal: judul, gaji)
6. Ubah status jika perlu
7. Upload logo baru (opsional)
8. Klik "Update Lowongan"
9. ✅ Redirect ke detail lowongan dengan alert "Lowongan berhasil diperbarui!"
10. ✅ Perubahan tersimpan

**Troubleshooting:**
- Jika tidak muncul tombol Edit → cek lowongan bukan milik sendiri, atau belum login
- Jika error 403 → tidak punya permission, harus admin atau poster

---

### Test 6: Hapus Lowongan Sendiri (Auth Required + Permission)
**URL:** POST `/lowongan/{id}` with DELETE method

**Expected Result:**
- ✅ Hanya bisa hapus lowongan yang diposting sendiri
- ✅ Admin bisa hapus semua lowongan
- ✅ Konfirmasi muncul sebelum hapus
- ✅ Logo terhapus dari storage
- ✅ Redirect ke index dengan success message

**Cara Test:**
1. Login sebagai alumni yang pernah posting lowongan
2. Buka lowongan yang diposting sendiri
3. Klik tombol "Hapus" (merah)
4. ✅ Konfirmasi dialog muncul "Yakin ingin menghapus lowongan ini?"
5. Klik OK
6. ✅ Redirect ke `/lowongan` dengan alert "Lowongan berhasil dihapus!"
7. ✅ Lowongan tidak muncul lagi di daftar
8. ✅ Logo terhapus dari folder storage

**Troubleshooting:**
- Jika tidak muncul tombol Hapus → cek lowongan bukan milik sendiri
- Jika error 403 → tidak punya permission

---

## 🔧 Troubleshooting Umum

### Issue 1: Redirect ke Login Terus
**Solusi:**
1. Pastikan sudah login
2. Clear cache: `php artisan cache:clear`
3. Clear session: `php artisan session:clear`
4. Cek middleware di routes

### Issue 2: Error Upload File
**Solusi:**
1. Cek permission folder:
```bash
chmod -R 775 storage/app/public/lowongan
chmod -R 775 storage/app/public/lamaran
```
2. Pastikan symlink ada:
```bash
php artisan storage:link
```
3. Cek php.ini upload_max_filesize dan post_max_size

### Issue 3: Form Tidak Bisa Submit
**Solusi:**
1. Cek CSRF token ada di form
2. Cek method POST/PUT/DELETE benar
3. Cek route name benar
4. Cek JavaScript tidak ada error (F12 Console)
5. Cek validasi form HTML tidak menghalangi

### Issue 4: Alert Messages Tidak Muncul
**Solusi:**
1. Cek Bootstrap CSS/JS sudah loaded
2. Cek session flash message di controller
3. Cek blade directive @if(session('success'))

### Issue 5: Tombol Edit/Hapus Tidak Muncul
**Solusi:**
1. Cek user sudah login
2. Cek lowongan milik user (posted_by === user.id_user)
3. Atau login sebagai admin
4. Cek blade condition: @if(Auth::user()->role === 'admin' || ...)

---

## 📝 Command Berguna

```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Recreate storage link
php artisan storage:link

# Check routes
php artisan route:list --name=lowongan

# Check database
php artisan tinker
>>> App\Models\Lowongan::count()
>>> App\Models\Lamaran::count()

# Reset database (HATI-HATI: menghapus semua data)
php artisan migrate:fresh --seed
```

---

## ✨ Fitur yang Sudah Aktif

1. ✅ **Lihat Daftar Lowongan** - Public, tidak perlu login
2. ✅ **Filter Lowongan** - Search, tipe, level, lokasi
3. ✅ **Detail Lowongan** - Public, tidak perlu login
4. ✅ **Posting Lowongan Baru** - Auth required
5. ✅ **Edit Lowongan** - Auth + permission (admin atau poster)
6. ✅ **Hapus Lowongan** - Auth + permission (admin atau poster)
7. ✅ **Melamar Pekerjaan** - Auth required
8. ✅ **Upload CV** - Opsional saat apply
9. ✅ **Cover Letter** - Opsional saat apply
10. ✅ **Lihat Status Lamaran** - Auth required
11. ✅ **Download CV** - Dari halaman lamaran saya
12. ✅ **Lowongan Terkait** - Di halaman detail
13. ✅ **Share Lowongan** - Web Share API
14. ✅ **Badge Status** - Aktif/Ditutup/Draft
15. ✅ **Cek Sudah Apply** - Prevent double apply

---

## 🎉 Kesimpulan

**SEMUA FITUR LOWONGAN SUDAH AKTIF DAN SIAP DIGUNAKAN!**

Jika masih ada masalah:
1. Pastikan sudah login sebagai alumni atau admin
2. Clear cache dan session
3. Cek permission folder storage
4. Cek error di browser console (F12)
5. Cek Laravel log di `storage/logs/laravel.log`

---

**Last Updated:** 2025-11-08
**Status:** ✅ READY TO USE
