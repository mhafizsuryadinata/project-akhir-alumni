# 🔍 Troubleshooting: Tombol Posting Lowongan & Lamaran Saya

## ❓ Masalah: Tombol tidak bisa ditekan

Ada 3 kemungkinan masalah:

---

## 1️⃣ **Anda BELUM LOGIN** ❌

### Gejala:
- Tombol "Posting Lowongan" dan "Lamaran Saya" **TIDAK MUNCUL**
- Yang muncul hanya tombol **"Login untuk Posting Lowongan"**

### Solusi:
```bash
1. Klik tombol "Login untuk Posting Lowongan" (hijau)
   ATAU
2. Akses langsung: http://localhost:8000/login
3. Login dengan NISN dan Username Anda
4. Setelah login, kembali ke /lowongan
5. ✅ Tombol "Posting Lowongan" dan "Lamaran Saya" akan muncul
```

### Verifikasi sudah login:
- Cek pojok kanan atas, ada nama user Anda?
- Atau cek URL setelah login, apakah ke `/alumni` atau `/akun`?

---

## 2️⃣ **Sudah LOGIN tapi tombol TIDAK MUNCUL** ⚠️

### Gejala:
- Anda sudah login (ada nama user di pojok kanan)
- Tapi tombol tetap tidak muncul

### Solusi:
```bash
# Clear cache browser
1. Tekan Ctrl + Shift + Del (Chrome/Firefox)
2. Pilih "Cached images and files"
3. Klik "Clear data"
4. Refresh halaman (F5)

# Clear cache Laravel
php artisan view:clear
php artisan cache:clear
php artisan config:clear
```

---

## 3️⃣ **Tombol MUNCUL tapi TIDAK BISA DIKLIK** 🔒

### Gejala:
- Tombol "Posting Lowongan" dan "Lamaran Saya" terlihat
- Tapi saat diklik tidak terjadi apa-apa atau redirect ke login

### Solusi A: Session Login Bermasalah
```bash
1. Logout dulu (klik nama user → Logout)
2. Login ulang
3. Akses /lowongan lagi
4. Coba klik tombol
```

### Solusi B: Akses Langsung via URL
```bash
# Test Posting Lowongan
http://localhost:8000/lowongan/create

# Test Lamaran Saya  
http://localhost:8000/my-applications

# Jika redirect ke /login → berarti belum login
# Jika tampil halaman → berarti sudah login dan berhasil
```

### Solusi C: Check Console Error
```bash
1. Buka browser
2. Tekan F12 (Developer Tools)
3. Klik tab "Console"
4. Refresh halaman
5. Coba klik tombol
6. Lihat apakah ada error merah di console
```

---

## 🧪 Test Lengkap

### Test 1: Verifikasi Routes
```bash
# Cek routes terdaftar
php artisan route:list --name=lowongan

# Harus muncul:
# lowongan.create → GET /lowongan/create
# lowongan.myApplications → GET /my-applications
```

### Test 2: Verifikasi Login Status
```bash
# Buka browser console (F12)
# Paste di console:
console.log('Auth:', document.querySelector('[href*="logout"]') ? 'LOGGED IN' : 'NOT LOGGED IN');

# Output: Auth: LOGGED IN → Anda sudah login ✅
# Output: Auth: NOT LOGGED IN → Anda belum login ❌
```

### Test 3: Test Direct Access (Setelah Login)
```bash
# Buka tab baru
# Paste URL ini satu per satu:

1. http://localhost:8000/lowongan/create
   ✅ Harus tampil form posting lowongan
   ❌ Jika redirect ke /login → session login bermasalah

2. http://localhost:8000/my-applications  
   ✅ Harus tampil halaman lamaran saya (bisa kosong jika belum apply)
   ❌ Jika redirect ke /login → session login bermasalah

3. http://localhost:8000/akun
   ✅ Harus tampil halaman akun Anda
   ❌ Jika redirect ke /login → session login bermasalah
```

---

## 🔧 Fix Step by Step

### LANGKAH 1: Pastikan Sudah Login
```bash
1. Buka http://localhost:8000/login
2. Masukkan NISN dan Username
3. Klik Login
4. Harus redirect ke:
   - /alumni (jika profil sudah lengkap)
   - /akun (jika profil belum lengkap)
```

### LANGKAH 2: Akses Halaman Lowongan
```bash
1. Buka http://localhost:8000/lowongan
2. Scroll ke atas
3. Lihat di bawah "X Lowongan Aktif"
4. ✅ Harus ada 2 tombol:
   - "Posting Lowongan" (hijau)
   - "Lamaran Saya" (biru)
```

### LANGKAH 3: Klik Tombol
```bash
# Klik "Posting Lowongan"
→ Harus pindah ke halaman form posting lowongan
→ URL: /lowongan/create

# Klik "Lamaran Saya"  
→ Harus pindah ke halaman daftar lamaran
→ URL: /my-applications
```

### LANGKAH 4: Jika Masih Tidak Bisa
```bash
# Clear semua cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Clear browser cache
Ctrl + Shift + Del → Clear

# Restart server (jika pakai php artisan serve)
Ctrl + C
php artisan serve

# Login ulang
Logout → Login → Akses /lowongan
```

---

## 📸 Screenshot Expected

### Sebelum Login:
```
┌─────────────────────────────────────┐
│ Lowongan Pekerjaan                 │
│ Temukan peluang karir terbaik      │
│                                     │
│ 🏢 6 Lowongan Aktif                │
│ [🔐 Login untuk Posting Lowongan]  │ ← Tombol Login
└─────────────────────────────────────┘
```

### Setelah Login:
```
┌─────────────────────────────────────┐
│ Lowongan Pekerjaan                 │
│ Temukan peluang karir terbaik      │
│                                     │
│ 🏢 6 Lowongan Aktif                │
│ [➕ Posting Lowongan]               │ ← Tombol Hijau
│ [📄 Lamaran Saya]                   │ ← Tombol Biru
└─────────────────────────────────────┘
```

---

## ✅ Checklist Debugging

- [ ] Sudah login? (cek nama user di pojok kanan atas)
- [ ] Cache browser sudah clear? (Ctrl+Shift+Del)
- [ ] Cache Laravel sudah clear? (php artisan cache:clear)
- [ ] Tombol muncul di halaman /lowongan?
- [ ] Bisa akses langsung /lowongan/create?
- [ ] Bisa akses langsung /my-applications?
- [ ] Ada error di browser console? (F12)
- [ ] Session login masih aktif? (cek /akun bisa diakses?)

---

## 🆘 Masih Tidak Bisa?

### Cek File Log Laravel:
```bash
tail -50 storage/logs/laravel.log
```

### Test Manual via Tinker:
```bash
php artisan tinker

# Cek user login
>>> Auth::check()
// Harus return: true

# Cek user ID
>>> Auth::user()->id_user
// Harus return: angka ID

# Cek role
>>> Auth::user()->role
// Harus return: "alumni" atau "admin"
```

---

## 📞 Summary Solusi Cepat

```bash
# Jika tombol tidak muncul:
1. ✅ LOGIN DULU di /login
2. Clear cache browser (Ctrl+Shift+Del)
3. Refresh halaman /lowongan

# Jika tombol muncul tapi tidak bisa diklik:
1. Logout → Login ulang
2. Clear cache Laravel: php artisan cache:clear
3. Akses langsung: /lowongan/create dan /my-applications

# Jika masih redirect ke login:
1. Session bermasalah → Login ulang
2. Middleware bermasalah → Check routes
3. Config bermasalah → php artisan config:clear
```

**PALING MUDAH: LOGOUT → LOGIN ULANG → REFRESH HALAMAN** 🔄
