# Dokumentasi Sistem Middleware Login

## Overview
Sistem login telah dikonfigurasi dengan middleware yang lengkap untuk mengatur akses berdasarkan status autentikasi dan role user.

## Middleware yang Digunakan

### 1. Guest Middleware (`guest`)
**File:** `app/Http/Middleware/RedirectIfAuthenticated.php`

**Fungsi:** Mencegah user yang sudah login mengakses halaman untuk guest (belum login)

**Redirect Logic:**
- **Admin** → `/admin` (Dashboard Admin)
- **Alumni (profil lengkap)** → `/alumni` (Dashboard Alumni)
- **Alumni (profil belum lengkap)** → `/akun` (Halaman Lengkapi Profil)
- **Default** → `/akun`

**Routes yang menggunakan:**
- `/` - Homepage/Dashboard sebelum login
- `/login` - Halaman login

### 2. Auth Middleware (`auth`)
**File:** `app/Http/Middleware/Authenticate.php`

**Fungsi:** Memastikan user sudah login sebelum mengakses halaman tertentu

**Routes yang menggunakan:**
- `/alumni` - Dashboard Alumni
- `/akun` - Halaman Akun
- `/kontak` - Halaman Kontak
- `/event` - Halaman Event
- `/galeri/upload` - Upload foto/video
- `/album/store` - Buat album baru
- `/lowongan/create` - Posting lowongan
- `/lowongan/*/apply` - Melamar lowongan
- `/my-applications` - Lamaran saya
- Dan lain-lain

### 3. Role Middleware (`role:admin`)
**File:** `app/Http/Middleware/RoleMiddleware.php`

**Fungsi:** Memastikan user memiliki role admin

**Routes yang menggunakan:**
- `/admin` - Dashboard Admin
- `/alumni/tampil` - Kelola Alumni
- `/komentar/*` - Kelola Komentar
- Semua route admin management

### 4. Profile Complete Middleware (`profile.complete`)
**File:** `app/Http/Middleware/CheckProfileComplete.php`

**Fungsi:** Memastikan profil alumni sudah lengkap

**Routes yang menggunakan:**
- `/alumni` - Dashboard Alumni (nested dalam auth)

## Struktur Routes

### Routes untuk Guest (Belum Login)
```php
Route::middleware(['guest'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/actionlogin', [LoginController::class, 'actionLogin'])->name('actionlogin');
});
```

### Routes untuk Authenticated User
```php
Route::middleware(['auth'])->group(function () {
    // Dashboard Alumni (dengan profile complete check)
    Route::middleware(['profile.complete'])->group(function () {
        Route::get('/alumni', [AlumniController::class, 'alumni'])->name('alumni');
    });
    
    // Akun Management
    Route::get('/akun', [AkunController::class, 'akun'])->name('akun');
    Route::post('/akun/update', [AkunController::class, 'update'])->name('akun.update');
    
    // Galeri, Lowongan, dll
    // ...
});
```

### Routes untuk Admin
```php
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'admin'])->name('admin');
    // Alumni & Komentar Management
    // ...
});
```

## Flow User Authentication

### 1. User Belum Login
- **Akses `/`** → Tampil homepage guest
- **Akses `/login`** → Tampil form login
- **Akses `/alumni`** → Redirect ke `/login`
- **Akses `/lowongan/create`** → Redirect ke `/login`

### 2. User Login Sebagai Alumni (Profil Belum Lengkap)
- **Login berhasil** → Redirect ke `/akun` dengan pesan "Lengkapi biodata dulu"
- **Akses `/`** → Redirect ke `/akun`
- **Akses `/login`** → Redirect ke `/akun`
- **Akses `/alumni`** → Redirect ke `/akun` (by profile.complete middleware)
- **Dapat akses:** `/akun`, `/galeri`, `/lowongan`, dll

### 3. User Login Sebagai Alumni (Profil Lengkap)
- **Login berhasil** → Redirect ke `/alumni`
- **Akses `/`** → Redirect ke `/alumni`
- **Akses `/login`** → Redirect ke `/alumni`
- **Dapat akses:** Semua halaman alumni

### 4. User Login Sebagai Admin
- **Login berhasil** → Redirect ke `/admin`
- **Akses `/`** → Redirect ke `/admin`
- **Akses `/login`** → Redirect ke `/admin`
- **Dapat akses:** Semua halaman admin + alumni

## Keamanan

### ✅ Yang Sudah Diimplementasikan:
1. **Prevent Double Login** - User yang sudah login tidak bisa kembali ke halaman login/home
2. **Role-Based Access Control** - Admin dan Alumni memiliki akses berbeda
3. **Profile Completion Check** - Alumni harus lengkapi profil sebelum akses dashboard
4. **Route Protection** - Routes sensitif dilindungi dengan middleware auth
5. **Automatic Redirect** - User otomatis diarahkan ke halaman yang sesuai dengan role

### 🔒 Best Practices:
- Semua routes yang mengubah data (POST, PUT, DELETE) dilindungi dengan `auth` middleware
- Routes admin dilindungi dengan `role:admin` middleware
- CSRF protection aktif untuk semua form
- Validasi input di controller

## Testing

### Test Scenario 1: Guest User
1. Buka browser → Akses `/` → ✅ Tampil homepage
2. Akses `/login` → ✅ Tampil form login
3. Akses `/alumni` → ✅ Redirect ke `/login`

### Test Scenario 2: Login Alumni (Profil Belum Lengkap)
1. Login dengan akun alumni baru → ✅ Redirect ke `/akun`
2. Akses `/` → ✅ Redirect ke `/akun`
3. Akses `/alumni` → ✅ Redirect ke `/akun`
4. Lengkapi profil → ✅ Dapat akses `/alumni`

### Test Scenario 3: Login Alumni (Profil Lengkap)
1. Login dengan akun alumni lengkap → ✅ Redirect ke `/alumni`
2. Akses `/` → ✅ Redirect ke `/alumni`
3. Akses `/login` → ✅ Redirect ke `/alumni`
4. Logout → ✅ Redirect ke `/` (homepage guest)

### Test Scenario 4: Login Admin
1. Login dengan akun admin → ✅ Redirect ke `/admin`
2. Akses `/` → ✅ Redirect ke `/admin`
3. Akses `/alumni` → ✅ Bisa akses (admin bisa akses semua)
4. Logout → ✅ Redirect ke `/`

## Troubleshooting

### Issue: User bisa akses halaman setelah logout
**Solution:** Clear cache dan session
```bash
php artisan cache:clear
php artisan config:clear
php artisan session:clear
```

### Issue: Redirect loop
**Solution:** Pastikan route name sudah benar di middleware
- `route('home')` untuk homepage
- `route('login')` untuk login
- `route('alumni')` untuk dashboard alumni
- `route('admin')` untuk dashboard admin
- `route('akun')` untuk halaman akun

### Issue: Middleware tidak bekerja
**Solution:** Pastikan middleware sudah terdaftar di `app/Http/Kernel.php`

## Update Log

**2025-11-08:**
- ✅ Implementasi guest middleware untuk halaman login dan homepage
- ✅ Update RedirectIfAuthenticated untuk redirect berdasarkan role
- ✅ Reorganisasi routes dengan middleware grouping
- ✅ Tambah middleware auth untuk semua routes yang memerlukan login
- ✅ Tambah middleware role:admin untuk admin routes
- ✅ Perbaiki duplikasi routes
- ✅ Tambah route names untuk semua routes penting
