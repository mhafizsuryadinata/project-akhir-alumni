<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\AdminGaleriController;
use App\Http\Controllers\LowonganController;
use App\Http\Controllers\MudirController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [DashboardController::class, 'index']);

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/actionlogin', [LoginController::class, 'actionLogin'])->name('actionlogin');

Route::get('/hubungiAdmin', [LoginController::class, 'hubungiAdmin'])->name('hubungiAdmin');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Profile Photo Management (memerlukan auth)
Route::middleware(['auth'])->group(function () {
    Route::post('/profile/update-photo', [AkunController::class, 'updatePhoto'])->name('profile.updatePhoto');
    Route::delete('/profile/remove-photo', [AkunController::class, 'removePhoto'])->name('profile.removePhoto');
});


// Admin Routes (memerlukan auth dan role admin)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'admin'])->name('admin');
    
    // Alumni Management
    Route::prefix('alumni')->group(function () {
        Route::get('/tampil', [AdminController::class, 'tampilAlumni'])->name('admin.alumni.tampil');
        Route::get('/tambah', [AdminController::class, 'tambahAlumni'])->name('admin.alumni.tambah');
        Route::post('/simpan', [AdminController::class, 'simpanAlumni'])->name('admin.alumni.simpan');
        Route::get('/edit/{id_user}', [AdminController::class, 'editAlumni'])->name('admin.alumni.edit');
        Route::post('/update', [AdminController::class, 'updateAlumni'])->name('admin.alumni.update');
        Route::get('/hapus/{id_user}', [AdminController::class, 'hapusAlumni'])->name('admin.alumni.hapus');
        Route::get('/komentar', [AdminController::class, 'komentarAlumni'])->name('admin.alumni.komentar');
    });
    
    // Komentar Management
    Route::prefix('komentar')->name('komentar.')->group(function () {
        Route::get('/', [AdminController::class, 'komentarAlumni'])->name('index');
        Route::post('/{id}/approve', [AdminController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [AdminController::class, 'reject'])->name('reject');
        Route::delete('/{id}', [AdminController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/balas', [AdminController::class, 'reply'])->name('balas');
    });

    // Event Management Routes
    Route::prefix('admin/event')->name('admin.event.')->group(function () {
        Route::get('/', [AdminController::class, 'daftarEvent'])->name('index');
        Route::post('/store', [AdminController::class, 'storeEvent'])->name('store');
        Route::get('/{id}', [AdminController::class, 'showEvent'])->name('show');
        Route::post('/{id}/approve', [AdminController::class, 'approveEvent'])->name('approve');
        Route::post('/{id}/reject', [AdminController::class, 'rejectEvent'])->name('reject');
        Route::get('/{id}/edit', [AdminController::class, 'editEvent'])->name('edit');
        Route::put('/{id}', [AdminController::class, 'updateEvent'])->name('update');
        Route::delete('/{id}', [AdminController::class, 'destroyEvent'])->name('destroy');
        Route::get('/{id}/pendaftar', [AdminController::class, 'tampilPendaftarEvent'])->name('pendaftar');
    });

    // Info Pondok Management
    Route::prefix('admin/info')->name('admin.info.')->group(function () {
        Route::get('/', [AdminController::class, 'tampilInfoPondok'])->name('index');
        Route::get('/create', [AdminController::class, 'tambahInfoPondok'])->name('create');
        Route::post('/store', [AdminController::class, 'simpanInfoPondok'])->name('store');
        Route::get('/{id}/edit', [AdminController::class, 'editInfoPondok'])->name('edit');
        Route::put('/{id}', [AdminController::class, 'updateInfoPondok'])->name('update');
        Route::delete('/{id}', [AdminController::class, 'hapusInfoPondok'])->name('destroy');
    });

    // Kontak Ustadz Management
    Route::prefix('admin/kontak')->name('admin.kontak.')->group(function () {
        Route::get('/', [AdminController::class, 'tampilKontakUstadz'])->name('index');
        Route::get('/create', [AdminController::class, 'tambahKontakUstadz'])->name('create');
        Route::post('/store', [AdminController::class, 'simpanKontakUstadz'])->name('store');
        Route::get('/{id}/edit', [AdminController::class, 'editKontakUstadz'])->name('edit');
        Route::put('/{id}', [AdminController::class, 'updateKontakUstadz'])->name('update');
        Route::delete('/{id}', [AdminController::class, 'hapusKontakUstadz'])->name('destroy');
    });

    // FAQ Management
    Route::prefix('admin/faq')->name('admin.faq.')->group(function () {
        Route::get('/', [AdminController::class, 'tampilFaq'])->name('index');
        Route::get('/create', [AdminController::class, 'tambahFaq'])->name('create');
        Route::post('/store', [AdminController::class, 'simpanFaq'])->name('store');
        Route::get('/{id}/edit', [AdminController::class, 'editFaq'])->name('edit');
        Route::put('/{id}', [AdminController::class, 'updateFaq'])->name('update');
        Route::delete('/{id}', [AdminController::class, 'hapusFaq'])->name('destroy');
    });

    Route::get('admin/pesan', [AdminController::class, 'tampilPesanKontak'])->name('admin.pesan.index');
    Route::post('admin/pesan/{id}/reply', [AdminController::class, 'balasPesanKontak'])->name('admin.pesan.reply');
    Route::delete('admin/pesan/{id}/reply', [AdminController::class, 'hapusBalasan'])->name('admin.pesan.reply.destroy');
    Route::get('admin/pesan/{id}/attachment', [AdminController::class, 'bukaLampiran'])->name('admin.pesan.attachment');
    Route::patch('admin/pesan/{id}/read', [AdminController::class, 'tandaiDibaca'])->name('admin.pesan.read');
    Route::delete('admin/pesan/{id}', [AdminController::class, 'hapusPesanKontak'])->name('admin.pesan.destroy');

    // Admin Account Management
    Route::get('/admin/akun', [AdminController::class, 'akunAdmin'])->name('admin.akun');
    Route::post('/admin/akun/update', [AdminController::class, 'updateAkunAdmin'])->name('admin.akun.update');
    Route::post('/admin/akun/password', [AdminController::class, 'updatePasswordAdmin'])->name('admin.akun.password');

    // Gallery Management
    Route::prefix('admin/galeri')->name('admin.galeri.')->group(function () {
        Route::get('/', [AdminGaleriController::class, 'index'])->name('index');
        Route::post('/store', [AdminGaleriController::class, 'storeAlbum'])->name('store');
        Route::get('/{id}', [AdminGaleriController::class, 'show'])->name('show');
        Route::put('/{id}', [AdminGaleriController::class, 'updateAlbum'])->name('update');
        Route::delete('/{id}', [AdminGaleriController::class, 'destroyAlbum'])->name('destroy');
        Route::post('/{id}/upload', [AdminGaleriController::class, 'uploadMedia'])->name('upload');
        Route::delete('/media/{id}', [AdminGaleriController::class, 'destroyMedia'])->name('media.destroy');
        Route::post('/{id}/approve', [AdminGaleriController::class, 'approveAlbum'])->name('approve');
        Route::post('/{id}/reject', [AdminGaleriController::class, 'rejectAlbum'])->name('reject');
        Route::post('/media/{id}/approve', [AdminGaleriController::class, 'approveMedia'])->name('media.approve');
        Route::post('/media/{id}/reject', [AdminGaleriController::class, 'rejectMedia'])->name('media.reject');
    });

    // Lowongan Admin Management
    Route::resource('admin/lowongan', \App\Http\Controllers\AdminLowonganController::class, [
        'names' => 'admin.lowongan'
    ]);
    Route::get('admin/lowongan/cv/{id}', [\App\Http\Controllers\AdminLowonganController::class, 'downloadCv'])->name('admin.lowongan.cv');
    Route::patch('admin/lowongan/lamaran/{id}/status', [\App\Http\Controllers\AdminLowonganController::class, 'updateStatusLamaran'])->name('admin.lowongan.status');
    Route::post('admin/lowongan/{id}/approve', [\App\Http\Controllers\AdminLowonganController::class, 'approveLowongan'])->name('admin.lowongan.approve');
    Route::post('admin/lowongan/{id}/reject', [\App\Http\Controllers\AdminLowonganController::class, 'rejectLowongan'])->name('admin.lowongan.reject');

    // Global Search
    Route::get('/admin/search/global', [AdminController::class, 'globalSearch'])->name('admin.search.global');
});

// Mudir/Pimpinan Routes
Route::middleware(['auth', 'role:pimpinan'])->group(function () {
    Route::get('/mudir', [MudirController::class, 'index'])->name('mudir.dashboard');
    Route::prefix('mudir/komentar')->name('mudir.komentar.')->group(function () {
        Route::get('/', [MudirController::class, 'tampilKomentar'])->name('index');
        Route::post('/{id}/approve', [MudirController::class, 'approveKomentar'])->name('approve');
        Route::post('/{id}/reject', [MudirController::class, 'rejectKomentar'])->name('reject');
        Route::post('/{id}/balas', [MudirController::class, 'balasKomentar'])->name('balas');
    });

    // Mudir Event Management
    Route::prefix('mudir/event')->name('mudir.event.')->group(function () {
        Route::get('/', [MudirController::class, 'eventIndex'])->name('index');
        Route::post('/store', [MudirController::class, 'storeEvent'])->name('store');
        Route::get('/{id}/edit', [MudirController::class, 'editEvent'])->name('edit');
        Route::put('/{id}', [MudirController::class, 'updateEvent'])->name('update');
        Route::delete('/{id}', [MudirController::class, 'destroyEvent'])->name('destroy');
        Route::post('/{id}/approve', [MudirController::class, 'approveEvent'])->name('approve');
        Route::post('/{id}/reject', [MudirController::class, 'rejectEvent'])->name('reject');
        Route::get('/{id}', [MudirController::class, 'showEvent'])->name('show');
    });
    
    // Mudir Gallery Management
    Route::prefix('mudir/galeri')->name('mudir.galeri.')->group(function () {
        Route::get('/', [MudirController::class, 'galeriIndex'])->name('index');
        Route::post('/store', [MudirController::class, 'storeAlbum'])->name('store');
        Route::put('/{id}', [MudirController::class, 'updateAlbum'])->name('update');
        Route::delete('/{id}', [MudirController::class, 'destroyAlbum'])->name('destroy');
        Route::post('/{id}/approve', [MudirController::class, 'approveAlbum'])->name('approve');
        Route::post('/{id}/reject', [MudirController::class, 'rejectAlbum'])->name('reject');
        Route::get('/{id}', [MudirController::class, 'showAlbum'])->name('show');
        
        Route::post('/{id}/upload', [MudirController::class, 'uploadMedia'])->name('upload');
        Route::delete('/media/{id}', [MudirController::class, 'destroyMedia'])->name('media.destroy');
        Route::post('/media/{id}/approve', [MudirController::class, 'approveMedia'])->name('media.approve');
        Route::post('/media/{id}/reject', [MudirController::class, 'rejectMedia'])->name('media.reject');
    });

    // Mudir Lowongan Management
    Route::prefix('mudir/lowongan')->name('mudir.lowongan.')->group(function () {
        Route::get('/', [MudirController::class, 'lowonganIndex'])->name('index');
        Route::post('/store', [MudirController::class, 'storeLowongan'])->name('store');
        Route::put('/{id}', [MudirController::class, 'updateLowongan'])->name('update');
        Route::delete('/{id}', [MudirController::class, 'destroyLowongan'])->name('destroy');
        Route::post('/{id}/approve', [MudirController::class, 'approveLowongan'])->name('approve');
        Route::post('/{id}/reject', [MudirController::class, 'rejectLowongan'])->name('reject');
        Route::get('/{id}', [MudirController::class, 'showLowongan'])->name('show');
        Route::get('/cv/{id}', [MudirController::class, 'downloadCv'])->name('cv');
        Route::patch('/status/{id}', [MudirController::class, 'updateStatusLamaran'])->name('status');
    });

    // Mudir Alumni Management
    Route::prefix('mudir/alumni')->name('mudir.alumni.')->group(function () {
        Route::get('/', [MudirController::class, 'tampilAlumni'])->name('index');
        Route::post('/simpan', [MudirController::class, 'simpanAlumni'])->name('simpan');
        Route::get('/edit/{id}', [MudirController::class, 'editAlumni'])->name('edit');
        Route::post('/update', [MudirController::class, 'updateAlumni'])->name('update');
        Route::get('/hapus/{id}', [MudirController::class, 'hapusAlumni'])->name('hapus');
    });

    // Mudir Account Management
    Route::get('/mudir/akun', [MudirController::class, 'akun'])->name('mudir.akun');
    Route::post('/mudir/akun/update', [MudirController::class, 'updateAkun'])->name('mudir.akun.update');
    Route::post('/mudir/akun/password', [MudirController::class, 'updatePassword'])->name('mudir.akun.password');
});

Route::post('/komentar/{id}/balas', [CommentController::class, 'balas'])->name('komentar.balas');


// route komentar yang ada dengan:
Route::middleware(['auth'])->group(function () {
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/comments/{target_user_id}', [CommentController::class, 'show'])->name('comments.show');
});


// Routes yang memerlukan authentication
Route::middleware(['auth'])->group(function () {
    // Dashboard Alumni (dengan pengecekan profile complete)
    Route::middleware(['profile.complete'])->group(function () {
        Route::get('/alumni', [AlumniController::class, 'alumni'])->name('alumni');
    });
    
    // Akun Management
    Route::get('/akun', [AkunController::class, 'akun'])->name('akun');
    Route::post('/akun/update', [AkunController::class, 'update'])->name('akun.update');
    Route::post('/akun/update-settings', [AkunController::class, 'updateSettings'])->name('akun.updateSettings');
    Route::post('/akun/update-privacy', [AkunController::class, 'updatePrivacy'])->name('akun.updatePrivacy');
    Route::post('/akun/update-password', [AkunController::class, 'updatePassword'])->name('akun.updatePassword');
    Route::get('/akun/export', [AkunController::class, 'exportData'])->name('akun.export');
    
    // Kontak dan Event
    Route::get('/kontak', [AlumniController::class, 'kontak'])->name('kontak');
    Route::get('/event', [EventController::class, 'event'])->name('event');
    Route::get('/event/kalender', [EventController::class, 'kalender'])->name('event.kalender');
    Route::get('/events/json', [EventController::class, 'getEventsJson'])->name('api.events');
    Route::post('/event/store', [EventController::class, 'store'])->name('event.store');
    Route::put('/event/{id}', [EventController::class, 'update'])->name('event.update');
    Route::post('/event/{id}/join', [EventController::class, 'join'])->name('event.join');
    Route::delete('/event/{id}', [EventController::class, 'destroy'])->name('event.destroy');
});

// Route Galeri
Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri.index');
Route::get('/galeri/{id}', [GaleriController::class, 'show'])->name('galeri.show');

// Galeri routes yang memerlukan auth
Route::middleware(['auth'])->group(function () {
    Route::post('/galeri/upload', [GaleriController::class, 'upload'])->name('galeri.upload');
    Route::delete('/galeri/{id}', [GaleriController::class, 'destroy'])->name('galeri.delete');
    
    Route::post('/album/store', [GaleriController::class, 'storeAlbum'])->name('album.store');
    Route::delete('/album/{id}', [GaleriController::class, 'destroyAlbum'])->name('album.delete');
});

// Route Lowongan (Public - tanpa auth)
Route::get('/lowongan', [LowonganController::class, 'index'])->name('lowongan.index');
Route::get('/lowongan/create', [LowonganController::class, 'create'])->name('lowongan.create');
Route::post('/lowongan', [LowonganController::class, 'store'])->name('lowongan.store');
Route::get('/lowongan/{id}', [LowonganController::class, 'show'])->name('lowongan.show');
Route::get('/my-applications', [LowonganController::class, 'myApplications'])->name('lowongan.myApplications');

// Lowongan routes yang memerlukan auth (edit, delete, apply)
Route::middleware(['auth'])->group(function () {
    Route::get('/lowongan/{id}/edit', [LowonganController::class, 'edit'])->name('lowongan.edit');
    Route::put('/lowongan/{id}', [LowonganController::class, 'update'])->name('lowongan.update');
    Route::delete('/lowongan/{id}', [LowonganController::class, 'destroy'])->name('lowongan.destroy');
    Route::post('/lowongan/{id}/apply', [LowonganController::class, 'apply'])->name('lowongan.apply');
});

// route halaman kontak dan bantuan
Route::post('/contact/send', [\App\Http\Controllers\ContactController::class, 'send'])->name('kontak.kirim');

