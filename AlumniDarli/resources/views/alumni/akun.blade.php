<style>
        :root {
            --primary-blue: #1a73e8;
            --secondary-blue: #4285f4;
            --dark-blue: #1557b0;
            --white: #ffffff;
            --light-blue: #e3f2fd;
            --light-gray: #f8f9fa;
            --medium-gray: #e9ecef;
            --dark-gray: #6c757d;
            --success: #28a745;
            --warning: #ffc107;
            --danger: #dc3545;
            --shadow: 0 4px 20px rgba(26, 115, 232, 0.1);
            --shadow-hover: 0 8px 30px rgba(26, 115, 232, 0.15);
            --border-radius: 16px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--white) 0%, var(--light-blue) 100%);
            color: #333;
            line-height: 1.6;
            min-height: 100vh;
        }
        
        /* Navbar */
        .navbar {
            background: var(--white);
            box-shadow: var(--shadow);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-blue) !important;
        }
        
        .nav-link {
            color: #666 !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            border-radius: 10px;
            transition: var(--transition);
            position: relative;
        }
        
        .nav-link:hover, .nav-link.active {
            color: var(--primary-blue) !important;
            background: rgba(26, 115, 232, 0.05);
        }
        
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 15%;
            width: 70%;
            height: 2px;
            background: var(--primary-blue);
            border-radius: 2px;
        }
        
        .profile-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid var(--primary-blue);
            object-fit: cover;
        }

        /*profile navbar*/
        .profile-img {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
        }

        .placeholder-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #777;
            font-size: 16px;
        }

        
        .notification-badge {
            position: absolute;
            top: 0;
            right: 0;
            background: var(--danger);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Main Container */
        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            color: var(--white);
            padding: 3rem 0;
            border-radius: var(--border-radius);
            margin-bottom: 2rem;
            text-align: center;
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="%23ffffff" opacity="0.05"><polygon points="1000,100 1000,0 0,100"></polygon></svg>');
            background-size: cover;
        }
        
        .hero h1 {
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            position: relative;
        }
        
        .hero p {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
            position: relative;
        }
        
        /* Cards */
        .card {
            background: var(--white);
            border: 1px solid rgba(26, 115, 232, 0.1);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            transition: var(--transition);
            overflow: hidden;
            height: 100%;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
            border-color: var(--primary-blue);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            color: var(--white);
            border: none;
            padding: 1.25rem 1.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .card-body {
            padding: 1.5rem;
            background: var(--white);
        }
        
        /* Profile Section */
        .profile-section {
            text-align: center;
            padding: 2rem 1rem;
        }
        
        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid var(--primary-blue);
            margin: 0 auto 1.5rem;
            object-fit: cover;
            box-shadow: var(--shadow);
        }
        
        .profile-name {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--primary-blue);
        }
        
        .profile-batch {
            font-size: 1rem;
            color: var(--dark-gray);
            margin-bottom: 1.5rem;
        }
        
        .profile-stats {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-bottom: 1.5rem;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-blue);
        }
        
        .stat-label {
            font-size: 0.875rem;
            color: var(--dark-gray);
        }
        
        /* Form Styles */
        .form-label {
            font-weight: 600;
            color: var(--dark-gray);
            margin-bottom: 0.5rem;
        }
        
        .form-control, .form-select {
            border: 2px solid var(--medium-gray);
            border-radius: 10px;
            padding: 0.75rem 1rem;
            transition: var(--transition);
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.25rem rgba(26, 115, 232, 0.15);
        }
        
        /* Info Items */
        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1rem;
            background: var(--light-gray);
            border-radius: 10px;
            margin-bottom: 1rem;
            transition: var(--transition);
            border-left: 4px solid var(--primary-blue);
        }
        
        .info-item:hover {
            background: var(--light-blue);
        }
        
        .info-icon {
            width: 45px;
            height: 45px;
            background: var(--primary-blue);
            color: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1.1rem;
        }
        
        .info-content {
            flex: 1;
        }
        
        .info-content h6 {
            margin-bottom: 0.25rem;
        }
        
        .info-content p {
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        
        /* Buttons */
        .btn-primary {
            background: var(--primary-blue);
            border: none;
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: var(--transition);
        }
        
        .btn-primary:hover {
            background: var(--dark-blue);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(26, 115, 232, 0.3);
        }
        
        .btn-outline-primary {
            border: 2px solid var(--primary-blue);
            color: var(--primary-blue);
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: var(--transition);
        }
        
        .btn-outline-primary:hover {
            background: var(--primary-blue);
            color: var(--white);
        }
        
        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }
        
        /* Badges */
        .badge {
            font-weight: 500;
            padding: 0.35em 0.65em;
        }
        
        /* Tabs */
        .nav-tabs {
            border-bottom: 2px solid var(--medium-gray);
        }
        
        .nav-tabs .nav-link {
            border: none;
            color: var(--dark-gray);
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            border-radius: 10px 10px 0 0;
        }
        
        .nav-tabs .nav-link.active {
            color: var(--primary-blue);
            background: var(--white);
            border-bottom: 3px solid var(--primary-blue);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }
            
            .main-container {
                padding: 1rem;
            }
            
            .profile-stats {
                flex-direction: column;
                gap: 1rem;
            }
        }
        
        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: var(--light-gray);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--primary-blue);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--dark-blue);
        }
        
        /* Form Section Styling */
        .form-section {
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .section-title {
            color: var(--dark-gray);
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        
        .section-title i {
            margin-right: 10px;
            color: var(--primary-blue);
        }
        
        .required::after {
            content: " *";
            color: #e53e3e;
        }
    </style>

@extends('alumni-master')
@section('alumni')

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <h1>Akun Saya</h1>
        <p>Kelola informasi profil, pengaturan akun, dan preferensi Anda</p>
    </div>
</section>

<div class="row g-4">
    <!-- Profile Card -->
    <div class="col-lg-12">
        <div class="card fade-in">
            <div class="profile-section">
                @if (Auth::user()->foto)
                    <img 
                        src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : asset('images/default-avatar.png') }}" 
                        class="profile-avatar" 
                        alt="Profile" 
                        id="profileImage">

                @else
                    <div class="profile-avatar placeholder-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                @endif

                <h2 class="profile-name">{{ Auth::user()->nama ?? 'Alumni' }}</h2>
                <p class="profile-batch">Tahun: {{ Auth::user()->tahun_masuk ?? '?' }} - {{ Auth::user()->tahun_tamat ?? '?' }}</p>
                
                <div class="profile-stats">
                    <div class="stat-item">
                        <div class="stat-number">{{ $total_events }}</div>
                        <div class="stat-label">Event</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">{{ $total_koneksi }}</div>
                        <div class="stat-label">Koneksi</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">{{ $years_joined }}</div>
                        <div class="stat-label">Tahun</div>
                    </div>
                </div>
                
                <div class="d-grid gap-2">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#changePhotoModal">
                        <i class="fas fa-camera me-2"></i>Ubah Foto
                    </button>
                    <button class="btn btn-outline-primary" onclick="shareProfile()">
                        <i class="fas fa-share-alt me-2"></i>Bagikan Profil
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
        <div class="col-lg-12">
        <div class="card mt-4 fade-in">
            <div class="card-header">
                <i class="fas fa-bolt me-2"></i>Aksi Cepat
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-primary text-start" data-bs-toggle="modal" data-bs-target="#createEventModal">
                        <i class="fas fa-calendar-plus me-2"></i>Buat Event
                    </button>
                    <button class="btn btn-outline-primary text-start" onclick="inviteFriend()">
                        <i class="fas fa-user-plus me-2"></i>Undang Teman
                    </button>
                    <a href="{{ route('akun.export') }}" class="btn btn-outline-primary text-start">
                        <i class="fas fa-file-export me-2"></i>Ekspor Data
                    </a>
                    <button class="btn btn-outline-primary text-start" onclick="document.getElementById('settings-tab').click(); window.scrollTo(0, document.getElementById('accountTabs').offsetTop - 100);">
                        <i class="fas fa-bell me-2"></i>Pengaturan Notifikasi
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="col-lg-12">
        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs mb-4" id="accountTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">
                    <i class="fas fa-user-circle me-2"></i>Profil
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings" type="button" role="tab">
                    <i class="fas fa-cog me-2"></i>Pengaturan
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="privacy-tab" data-bs-toggle="tab" data-bs-target="#privacy" type="button" role="tab">
                    <i class="fas fa-shield-alt me-2"></i>Privasi
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="activity-tab" data-bs-toggle="tab" data-bs-target="#activity" type="button" role="tab">
                    <i class="fas fa-chart-line me-2"></i>Aktivitas
                </button>
            </li>
        </ul>

        <!-- Tabs Content -->
        <div class="tab-content" id="accountTabsContent">
            <!-- Profile Tab -->
            <div class="tab-pane fade show active" id="profile" role="tabpanel">
                <div class="card fade-in">
                    <div class="card-header">
                        <i class="fas fa-user-edit me-2"></i>Informasi Profil
                    </div>
                    <div class="card-body">
                        @if(session('info'))
                            <div class="alert alert-info">{{ session('info') }}</div>
                        @endif
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ url('akun/update') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Informasi Pribadi -->
                            <div class="form-section">
                                <div class="section-title">
                                    <i class="fas fa-user"></i> Informasi Pribadi
                                </div>
                                
                                <div class="mb-3">
                                    <label for="nama" class="form-label required">Nama Lengkap</label>
                                    <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', Auth::user()->nama ?? '') }}" required>
                                </div>


                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="tahun_masuk" class="form-label">Tahun Masuk (Angkatan)</label>
                                        <input type="number" name="tahun_masuk" id="tahun_masuk" class="form-control bg-light" value="{{ old('tahun_masuk', Auth::user()->tahun_masuk ?? '') }}" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="tahun_tamat" class="form-label">Tahun Tamat (Lulus)</label>
                                        <input type="number" name="tahun_tamat" id="tahun_tamat" class="form-control bg-light" value="{{ old('tahun_tamat', Auth::user()->tahun_tamat ?? '') }}" readonly>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-text text-muted mb-3">
                                            <i class="fas fa-info-circle me-1"></i> Data tahun angkatan dan tamat hanya dapat diubah oleh Admin.
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="alamat" class="form-label required">Alamat</label>
                                    <textarea name="alamat" id="alamat" rows="3" class="form-control" required>{{ old('alamat', Auth::user()->alamat ?? '') }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="no_hp" class="form-label required">Nomor HP</label>
                                    <input type="text" name="no_hp" id="no_hp" class="form-control" value="{{ old('no_hp', Auth::user()->no_hp ?? '') }}" required>
                                </div>
                            </div>
                            
                            <!-- Informasi Tambahan -->
                            <div class="form-section">
                                <div class="section-title">
                                    <i class="fas fa-graduation-cap"></i> Informasi Tambahan
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="pekerjaan" class="form-label">Pekerjaan Saat Ini</label>
                                        <input type="text" name="pekerjaan" id="pekerjaan" class="form-control" value="{{ old('pekerjaan', Auth::user()->pekerjaan ?? '') }}" placeholder="Contoh: Mahasiswa, Guru, dll">
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', Auth::user()->email ?? '') }}" placeholder="nama@gamil.com">
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="lokasi" class="form-label">Lokasi saat ini</label>
                                    <textarea name="lokasi" id="lokasi" rows="2" class="form-control" placeholder="Masukkan lokasi anda terkini !!">{{ old('lokasi', Auth::user()->lokasi ?? '') }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="bio" class="form-label">Bio / Tentang Saya</label>
                                    <textarea name="bio" id="bio" rows="3" class="form-control" placeholder="Ceritakan sedikit tentang anda...">{{ old('bio', Auth::user()->bio ?? '') }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="instagram" class="form-label">Instagram</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-instagram"></i></span>
                                            <input type="text" name="instagram" id="instagram" class="form-control" value="{{ old('instagram', Auth::user()->instagram ?? '') }}" placeholder="Username Instagram">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="linkedin" class="form-label">LinkedIn</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-linkedin"></i></span>
                                            <input type="text" name="linkedin" id="linkedin" class="form-control" value="{{ old('linkedin', Auth::user()->linkedin ?? '') }}" placeholder="URL Profil LinkedIn">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="pendidikan_lanjutan" class="form-label">Setelah tamat lanjut ke mana?</label>
                                    <input type="text" name="pendidikan_lanjutan" id="pendidikan_lanjutan" class="form-control" value="{{ old('pendidikan_lanjutan', Auth::user()->pendidikan_lanjutan ?? '') }}" placeholder="Contoh: Kuliah di UNAND, Bekerja di Jakarta, dll">
                                </div>
                            </div>
                            
                            <!-- Unggah Foto -->
                            <div class="mb-4">
                                <div class="section-title">
                                    <i class="fas fa-camera"></i> Unggah Foto
                                </div>
                                
                                <div class="mb-3">
                                    <label for="foto" class="form-label">Foto Terbaru (Opsional)</label>
                                    <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
                                    <div class="form-text">Format: JPG, PNG. Maksimal 2MB.</div>
                                </div>
                            </div>

                            <!-- Tombol Submit -->
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <button type="button" class="btn btn-outline-primary">Batal</button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Settings Tab -->
            <div class="tab-pane fade" id="settings" role="tabpanel">
                <div class="card fade-in">
                    <div class="card-header">
                        <i class="fas fa-bell me-2"></i>Pengaturan Notifikasi
                    </div>
                    <div class="card-body">
                        <form action="{{ route('akun.updateSettings') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" name="notifEvents" id="notifEvents" @checked($settings['notifEvents'] ?? false)>
                                    <label class="form-check-label" for="notifEvents">Event & Kegiatan</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" name="notifMessages" id="notifMessages" @checked($settings['notifMessages'] ?? false)>
                                    <label class="form-check-label" for="notifMessages">Pesan dari Alumni</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" name="notifAnnouncements" id="notifAnnouncements" @checked($settings['notifAnnouncements'] ?? false)>
                                    <label class="form-check-label" for="notifAnnouncements">Pengumuman Pondok</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" name="notifJobs" id="notifJobs" @checked($settings['notifJobs'] ?? false)>
                                    <label class="form-check-label" for="notifJobs">Lowongan Kerja</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="notifNewsletter" id="notifNewsletter" @checked($settings['notifNewsletter'] ?? false)>
                                    <label class="form-check-label" for="notifNewsletter">Newsletter Bulanan</label>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="card mt-4 fade-in">
                    <div class="card-header">
                        <i class="fas fa-lock me-2"></i>Keamanan Akun
                    </div>
                    <div class="card-body">
                        <div class="info-item mb-4">
                            <div class="info-icon">
                                <i class="fas fa-key"></i>
                            </div>
                            <div class="info-content">
                                <h6>Ubah Kata Sandi</h6>
                                <p>Pastikan menggunakan kata sandi yang kuat dan unik</p>
                                <form action="{{ route('akun.updatePassword') }}" method="POST" class="mt-3">
                                    @csrf
                                    <div class="mb-2">
                                        <input type="password" name="current_password" class="form-control form-control-sm" placeholder="Kata Sandi Saat Ini" required>
                                    </div>
                                    <div class="mb-2">
                                        <input type="password" name="new_password" class="form-control form-control-sm" placeholder="Kata Sandi Baru" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="password" name="new_password_confirmation" class="form-control form-control-sm" placeholder="Konfirmasi Kata Sandi Baru" required>
                                    </div>
                                    <button type="submit" class="btn btn-outline-primary btn-sm w-100">Simpan Kata Sandi Baru</button>
                                </form>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div class="info-content">
                                <h6>Verifikasi Dua Langkah</h6>
                                <p>Tambah lapisan keamanan ekstra untuk akun Anda</p>
                                <button class="btn btn-outline-primary btn-sm">Aktifkan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Privacy Tab -->
            <div class="tab-pane fade" id="privacy" role="tabpanel">
                <div class="card fade-in">
                    <div class="card-header">
                        <i class="fas fa-eye me-2"></i>Pengaturan Visibilitas
                    </div>
                    <div class="card-body">
                        <form action="{{ route('akun.updatePrivacy') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <h6>Siapa yang dapat melihat profil Anda?</h6>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="visibility" value="public" id="visibilityPublic" @checked(($privacy['visibility'] ?? 'public') === 'public')>
                                    <label class="form-check-label" for="visibilityPublic">
                                        Semua alumni (Rekomendasi)
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="visibility" value="connections" id="visibilityConnections" @checked(($privacy['visibility'] ?? '') === 'connections')>
                                    <label class="form-check-label" for="visibilityConnections">
                                        Hanya koneksi
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="visibility" value="private" id="visibilityPrivate" @checked(($privacy['visibility'] ?? '') === 'private')>
                                    <label class="form-check-label" for="visibilityPrivate">
                                        Hanya saya
                                    </label>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <h6>Informasi yang dapat dilihat</h6>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" name="showEmail" id="showEmail" @checked($privacy['showEmail'] ?? false)>
                                    <label class="form-check-label" for="showEmail">Alamat Email</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" name="showPhone" id="showPhone" @checked($privacy['showPhone'] ?? false)>
                                    <label class="form-check-label" for="showPhone">Nomor Telepon</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" name="showSocial" id="showSocial" @checked($privacy['showSocial'] ?? false)>
                                    <label class="form-check-label" for="showSocial">Media Sosial</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="showActivity" id="showActivity" @checked($privacy['showActivity'] ?? false)>
                                    <label class="form-check-label" for="showActivity">Aktivitas Terbaru</label>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Activity Tab -->
            <div class="tab-pane fade" id="activity" role="tabpanel">
                <div class="card fade-in">
                    <div class="card-header">
                        <i class="fas fa-history me-2"></i>Riwayat Aktivitas
                    </div>
                    <div class="card-body">
                        @forelse($activities as $activity)
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="info-content">
                                <h6>Mendaftar Event "{{ $activity->title }}"</h6>
                                <p>Anda telah mendaftar untuk mengikuti event ini di {{ $activity->location }}</p>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($activity->pivot->created_at)->diffForHumans() }}</small>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <p class="text-muted mb-0">Belum ada riwayat aktivitas.</p>
                        </div>
                        @endforelse
                                <p>Anda terhubung dengan Siti Fatimah</p>
                                <small class="text-muted">1 minggu yang lalu</small>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-edit"></i>
                            </div>
                            <div class="info-content">
                                <h6>Memperbarui profil</h6>
                                <p>Anda menambahkan informasi pekerjaan terbaru</p>
                                <small class="text-muted">2 minggu yang lalu</small>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-comment"></i>
                            </div>
                            <div class="info-content">
                                <h6>Memberikan komentar</h6>
                                <p>Anda memberikan komentar pada pengumuman "Pembangunan Gedung"</p>
                                <small class="text-muted">3 minggu yang lalu</small>
                            </div>
                        </div>
                        
                        <div class="text-center mt-3">
                            <button class="btn btn-outline-primary">Muat Lebih Banyak</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal - Change Photo -->
<div class="modal fade" id="changePhotoModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ubah Foto Profil</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="text-center mb-4">
          <img 
            src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : asset('images/default-avatar.png') }}" 
            class="profile-avatar rounded-circle" 
            alt="Profile" 
            id="profileImage"
            width="120" height="120"
            style="object-fit: cover;">
        </div>

        <div class="mb-3">
          <label for="formFile" class="form-label">Pilih foto baru</label>
          <input class="form-control" type="file" id="formFile" accept="image/*">
        </div>

        <div class="form-check mb-3">
          <input class="form-check-input" type="checkbox" id="removePhoto">
          <label class="form-check-label" for="removePhoto">
            Hapus foto profil
          </label>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" onclick="updateProfilePhoto()">Simpan</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal - Create Event -->
<div class="modal fade" id="createEventModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title"><i class="fas fa-calendar-plus me-2"></i>Buat Event Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('event.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label required">Judul Event</label>
                            <input type="text" name="title" class="form-control" placeholder="Contoh: Reuni Akbar Angkatan 2020" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label required">Kategori</label>
                            <select name="category" class="form-select" required>
                                <option value="reuni">Reuni</option>
                                <option value="seminar">Seminar</option>
                                <option value="sosial">Sosial</option>
                                <option value="olahraga">Olahraga</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">Tanggal</label>
                            <input type="date" name="date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">Waktu</label>
                            <input type="time" name="time" class="form-control" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label required">Lokasi</label>
                            <input type="text" name="location" class="form-control" placeholder="Tempat pelaksanaan event" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label required">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="4" placeholder="Jelaskan detail event anda..." required></textarea>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Gambar Banner (Opsional)</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i>Publikasikan Event
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script -->
<script>
function updateProfilePhoto() {
  const fileInput = document.getElementById('formFile');
  const removeCheckbox = document.getElementById('removePhoto');
  const formData = new FormData();

  if (removeCheckbox.checked) {
    formData.append('remove', 'true');
  } else if (fileInput.files.length > 0) {
    formData.append('foto', fileInput.files[0]);
  } else {
    alert('Pilih foto atau centang hapus foto terlebih dahulu.');
    return;
  }

  fetch("{{ url('profile/update-photo') }}", {
    method: "POST",
    headers: {
      "X-CSRF-TOKEN": "{{ csrf_token() }}"
    },
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if (!data.success) {
      alert(data.message);
      return;
    }

    // Update gambar profil tanpa reload
    const newPath = data.path + '?t=' + new Date().getTime(); // cache buster
    document.getElementById('profileImage').src = newPath;

    // Update juga foto di navbar (jika ada)
    const navImg = document.querySelector('.profile-pic');
    if (navImg) {
      navImg.src = newPath;
    }

    // Tutup modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('changePhotoModal'));
    modal.hide();
  })
  .catch(err => console.error(err));
}

function shareProfile() {
    const dummy = document.createElement('input'),
    text = window.location.href;
    document.body.appendChild(dummy);
    dummy.value = text;
    dummy.select();
    document.execCommand('copy');
    document.body.removeChild(dummy);
    alert('Link profil telah disalin ke clipboard!');
}

function inviteFriend() {
    const text = "Ayo bergabung dengan aplikasi Alumni DARLI! " + window.location.origin;
    if (navigator.share) {
        navigator.share({
            title: 'Alumni DARLI',
            text: text,
            url: window.location.origin,
        });
    } else {
        const dummy = document.createElement('input');
        document.body.appendChild(dummy);
        dummy.value = text;
        dummy.select();
        document.execCommand('copy');
        document.body.removeChild(dummy);
        alert('Link undangan telah disalin ke clipboard!');
    }
}
</script>

@endsection