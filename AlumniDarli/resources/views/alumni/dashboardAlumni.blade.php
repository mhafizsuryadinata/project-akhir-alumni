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
            width: 40px;
            height: 40px;
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
            transition: background-color 0.3s ease, transform 0.2s ease;
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

    <style>
    /* Comment Section Styles */
    .comment-section {
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        padding: 2rem;
        margin-top: 2rem;
    }
    
    .comment-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--light-gray);
    }
    
    .comment-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-blue);
        margin: 0;
    }
    
    .comment-stats {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .comment-count {
        font-weight: 600;
        color: var(--dark-gray);
    }
    
    .rating-summary {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .average-rating {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary-blue);
    }
    
    .stars {
        display: flex;
        gap: 2px;
    }
    
    .star {
        color: #ffc107;
        font-size: 1.1rem;
    }
    
    .star.empty {
        color: var(--medium-gray);
    }
    
    /* Comment Form */
    .comment-form {
        background: var(--light-gray);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .form-group {
        margin-bottom: 1rem;
    }
    
    .rating-input {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    
    .rating-label {
        font-weight: 600;
        color: var(--dark-gray);
    }
    
    .star-rating {
        display: flex;
        gap: 5px;
        direction: rtl;
    }
    
    .star-rating input {
        display: none;
    }
    
    .star-rating label {
        font-size: 1.5rem;
        color: var(--medium-gray);
        cursor: pointer;
        transition: var(--transition);
    }
    
    .star-rating label:hover,
    .star-rating label:hover ~ label,
    .star-rating input:checked ~ label {
        color: #ffc107;
    }
    
    .comment-textarea {
        width: 100%;
        min-height: 120px;
        border: 2px solid var(--medium-gray);
        border-radius: 10px;
        padding: 1rem;
        font-family: 'Poppins', sans-serif;
        resize: vertical;
        transition: var(--transition);
    }
    
    .comment-textarea:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 0.25rem rgba(26, 115, 232, 0.15);
        outline: none;
    }
    
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 1rem;
    }
    
    /* Comments List */
    .comments-list {
        max-height: 600px;
        overflow-y: auto;
        padding-right: 10px;
    }
    
    .comment-item {
        background: var(--white);
        border: 1px solid rgba(26, 115, 232, 0.1);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        transition: var(--transition);
    }
    
    .comment-item:hover {
        border-color: var(--primary-blue);
        box-shadow: var(--shadow);
    }
    
    .comment-header-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    
    .comment-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--primary-blue);
    }
    
    .comment-user-info {
        flex: 1;
    }
    
    .comment-user-name {
        font-weight: 600;
        margin: 0;
        color: var(--primary-blue);
    }
    
    .comment-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-top: 0.25rem;
    }
    
    .comment-date {
        color: var(--dark-gray);
        font-size: 0.875rem;
    }
    
    .comment-rating {
        display: flex;
        gap: 2px;
    }
    
    .comment-content {
        margin-bottom: 1rem;
        line-height: 1.6;
    }
    
    .comment-actions {
        display: flex;
        gap: 1rem;
    }
    
    .comment-action {
        background: none;
        border: none;
        color: var(--dark-gray);
        cursor: pointer;
        padding: 0.25rem 0.5rem;
        border-radius: 5px;
        transition: var(--transition);
        font-size: 0.875rem;
    }
    
    .comment-action:hover {
        background: var(--light-gray);
        color: var(--primary-blue);
    }
    
    .comment-action.liked {
        color: var(--danger);
    }
    
    .no-comments {
        text-align: center;
        padding: 3rem;
        color: var(--dark-gray);
    }
    
    .no-comments i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: var(--medium-gray);
    }
    
    /* Filter and Sort */
    .comment-filters {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding: 1rem;
        background: var(--light-gray);
        border-radius: 10px;
    }
    
    .filter-buttons {
        display: flex;
        gap: 0.5rem;
    }
    
    .filter-btn {
        padding: 0.5rem 1rem;
        border: 1px solid var(--medium-gray);
        background: var(--white);
        border-radius: 20px;
        cursor: pointer;
        transition: var(--transition);
        font-size: 0.875rem;
    }
    
    .filter-btn.active {
        background: var(--primary-blue);
        color: var(--white);
        border-color: var(--primary-blue);
    }
    
    .sort-select {
        border: 1px solid var(--medium-gray);
        border-radius: 10px;
        padding: 0.5rem 1rem;
        background: var(--white);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .comment-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .comment-filters {
            flex-direction: column;
            gap: 1rem;
        }
        
        .comment-header-info {
            flex-direction: column;
            align-items: flex-start;
            text-align: left;
        }
        
        .comment-meta {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
    }

/* Modal Styling */
.bg-gradient-primary {
    background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
}

.icon-box {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
}

.modal-content {
    border: none;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-hover);
}

.modal-header {
    border-radius: var(--border-radius) var(--border-radius) 0 0;
}

#modalLinkedinLink:hover, #modalInstagramLink:hover {
    text-decoration: underline !important;
}

</style>

@extends('alumni-master')
@section('alumni')

<section class="hero">
    <div class="container">
        <h1>Selamat Datang Kembali, {{ Auth::user()->nama ?? 'Alumni' }}</h1>
        <p>Dashboard Alumni Dar El-Ilmi - Pantau Info Pondok, Hubungi Ustadz, dan Ikuti Event Reuni</p>
        <div class="mt-4">
            <span class="badge bg-light text-primary me-2"><i class="fas fa-users me-1"></i> {{ number_format($jumlahAlumni2) }}+ Alumni</span>
            <span class="badge bg-light text-primary me-2"><i class="fas fa-calendar me-1"></i> {{ $total_upcoming }} Event Mendatang</span>
            <span class="badge bg-light text-primary"><i class="fas fa-bullhorn me-1"></i> 3 Pengumuman Baru</span>
        </div>
    </div>
</section>

<!-- Stats Section -->
<div class="row g-4 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="card stats-card fade-in">
            <div class="stats-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stats-number">{{ number_format($jumlahAlumni2) }}+</div>
            <div class="stats-label">Total Alumni</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card stats-card fade-in">
            <div class="stats-icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stats-number">{{ $total_events_year }}</div>
            <div class="stats-label">Event Tahun Ini</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card stats-card fade-in">
            <div class="stats-icon">
                <i class="fas fa-user-tie"></i>
            </div>
            <div class="stats-number">{{ $total_ustadz }}</div>
            <div class="stats-label">Ustadz Aktif</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card stats-card fade-in">
            <div class="stats-icon">
                <i class="fas fa-briefcase"></i>
            </div>
            <div class="stats-number">{{ $total_lowongan }}</div>
            <div class="stats-label">Lowongan Kerja</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Info Pondok -->
    <div class="col-lg-6">
        <div class="card fade-in">
            <div class="card-header">
                <div>
                    <i class="fas fa-info-circle me-2"></i>Info Pondok
                </div>
                <div class="card-actions d-flex align-items-center">
                    <div class="input-group input-group-sm me-2" style="width: 200px;">
                        <span class="input-group-text bg-transparent border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" id="filterInfoInput" class="form-control border-start-0" placeholder="Cari info...">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="infoPondokList" style="max-height: 400px; overflow-y: auto; padding-right: 5px;">
                    @forelse($info_pondok as $info)
                    <div class="info-item btn-detail-info" 
                         style="cursor: pointer;" 
                         data-judul="{{ $info->judul }}"
                         data-konten="{{ $info->konten }}"
                         data-jenis="{{ $info->jenis }}"
                         data-tanggal="{{ $info->created_at->translatedFormat('d F Y, H:i') }}"
                         data-gambar="{{ $info->gambar ? asset('storage/' . $info->gambar) : '' }}">
                        <div class="info-icon">
                            @if($info->jenis == 'Pengumuman')
                                <i class="fas fa-bullhorn"></i>
                            @elseif($info->jenis == 'Kegiatan')
                                <i class="fas fa-calendar-day"></i>
                            @else
                                <i class="fas fa-building"></i>
                            @endif
                        </div>
                        <div class="info-content">
                            <h6 class="info-title">{{ $info->judul }}</h6>
                            <p class="mb-1 info-preview">{{ Str::limit($info->konten, 80) }}</p>
                            <div class="info-meta">
                                <span class="badge {{ $info->jenis == 'Pengumuman' ? 'bg-primary' : ($info->jenis == 'Kegiatan' ? 'bg-success' : 'bg-info') }}">
                                    {{ $info->jenis }}
                                </span>
                                <span><i class="far fa-clock me-1"></i>{{ $info->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-info-circle fa-2x mb-2"></i>
                        <p>Belum ada info pondok terbaru.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Kontak Ustadz -->
    <!-- Kontak Ustadz -->
    <div class="col-lg-6">
        <div class="card fade-in">
            <div class="card-header">
                <div>
                    <i class="fas fa-user-tie me-2"></i>Kontak Para Ustadz
                </div>
                <div class="card-actions d-flex align-items-center">
                    <div class="input-group input-group-sm me-2" style="width: 200px;">
                        <span class="input-group-text bg-transparent border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" id="filterUstadzInput" class="form-control border-start-0" placeholder="Cari ustadz...">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="ustadzList" style="max-height: 400px; overflow-y: auto; padding-right: 5px;">
                    @forelse($kontak_ustadz as $ustadz)
                    <div class="ustadz-item btn-detail-ustadz" 
                         style="cursor: pointer;"
                         data-nama="{{ $ustadz->nama }}"
                         data-jabatan="{{ $ustadz->jabatan }}"
                         data-bidang="{{ $ustadz->bidang }}"
                         data-nohp="{{ $ustadz->no_hp }}"
                         data-email="{{ $ustadz->email }}"
                         data-foto="{{ $ustadz->foto ? asset('storage/' . $ustadz->foto) : '' }}">
                        <div class="d-flex align-items-center">
                            @if($ustadz->foto)
                                <img src="{{ asset('storage/' . $ustadz->foto) }}" class="ustadz-avatar" alt="{{ $ustadz->nama }}">
                            @else
                                <div class="ustadz-avatar">{{ substr($ustadz->nama, 0, 2) }}</div>
                            @endif
                            <div class="ustadz-info">
                                <h6 class="ustadz-name">{{ $ustadz->nama }}</h6>
                                <small class="ustadz-jabatan">{{ $ustadz->jabatan }}</small>
                                <div class="mt-1">
                                    @if($ustadz->bidang)
                                        @foreach(explode(',', $ustadz->bidang) as $bidang)
                                            <span class="badge bg-primary me-1">{{ trim($bidang) }}</span>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="ustadz-actions">
                             <!-- Actions are now in the modal for cleaner look, but we can keep quick actions here if desired, 
                                  but request asked for "like info pondok", so click to view detail is primary. 
                                  Let's keep the click-to-view-detail paradigm predominant. -->
                             <button class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></button>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-user-tie fa-2x mb-2"></i>
                        <p>Belum ada data ustadz.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Reuni & Event -->
    <div class="col-12">
        <div class="card fade-in">
            <div class="card-header">
                <div>
                    <i class="fas fa-calendar-alt me-2"></i>Reuni Angkatan & Event
                </div>
                <div class="card-actions">
                    <button class="btn btn-sm btn-light"><i class="fas fa-ellipsis-v"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    @forelse($upcoming_events as $event)
                    <div class="col-md-4 mb-3">
                        <div class="event-item btn-detail-event"
                             style="cursor: pointer;"
                             data-title="{{ $event->title }}"
                             data-date="{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}"
                             data-time="{{ $event->time }}"
                             data-location="{{ $event->location }}"
                             data-category="{{ $event->category }}"
                             data-description="{{ $event->description }}"
                             data-image="{{ $event->image ? asset('storage/' . $event->image) : '' }}">
                            <div class="event-date">
                                <span>{{ \Carbon\Carbon::parse($event->date)->format('d') }}</span>
                                <small>{{ strtoupper(\Carbon\Carbon::parse($event->date)->format('M')) }}</small>
                            </div>
                            <div class="event-content">
                                <h6>{{ Str::limit($event->title, 25) }}</h6>
                                <p class="text-muted small mb-1"><i class="fas fa-map-marker-alt me-1"></i>{{ Str::limit($event->location, 30) }}</p>
                                <div class="event-meta">
                                    <span class="badge bg-soft-primary text-primary">{{ $event->category }}</span>
                                </div>
                            </div>
                            <div class="event-actions mt-2">
                                <button type="button" class="btn btn-primary btn-sm w-100">Lihat</button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-4">
                        <p class="text-muted">Belum ada event mendatang.</p>
                    </div>
                    @endforelse
                </div>
                <a href="{{ route('event') }}" class="btn btn-outline-primary w-100">Lihat Semua Event</a>
            </div>
        </div>
    </div>

    <!-- Data Alumni -->
    <div class="col-12">
        <div class="card fade-in">
            <div class="card-header">
                <div>
                    <i class="fas fa-users me-2"></i>Data Alumni Per Angkatan
                </div>
                <div class="card-actions">
                    <button class="btn btn-sm btn-light"><i class="fas fa-download"></i></button>
                    <button class="btn btn-sm btn-light"><i class="fas fa-ellipsis-v"></i></button>
                </div>
            </div>
            <div class="card-body">
                <!-- Search and Filter -->
                <div class="search-filter mb-3">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-start-0" id="searchInput" placeholder="Cari alumni...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select id="angkatanFilter" class="form-select">
                                <option selected>Semua Tahun</option>
                                @foreach($users->pluck('tahun_masuk')->unique()->sortDesc() as $tahun)
                                    <option>{{ $tahun }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="profesiFilter" class="form-select">
                                <option selected>Semua Profesi</option>
                                @foreach($users->pluck('pekerjaan')->unique() as $profesi)
                                    <option>{{ $profesi }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table alumni-table" id="alumniTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Angkatan</th>
                                <th>Profesi</th>
                                <th>Lokasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $a)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                   <img 
                                        src="{{ $a->foto ? asset('storage/' . $a->foto) : asset('images/default-avatar.png') }}" 
                                        class="profile-avatar" 
                                        alt="Profile" 
                                        id="profileImage">
                                    {{$a->nama}}
                                </td>
                                <td>
                                    <span class="batch-badge">
                                        {{ $a->tahun_masuk ?? '?' }} - {{ $a->tahun_tamat ?? '?' }}
                                    </span>
                                </td>
                                <td>{{$a->pekerjaan}}</td>
                                <td>{{$a->lokasi}}</td>
                               <td>
                                <button 
                                    class="btn btn-primary btn-sm me-1 viewProfileBtn" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#profileModal1"
                                    data-nama="{{ $a->nama }}"
                                    data-masuk="{{ $a->tahun_masuk }}"
                                    data-tamat="{{ $a->tahun_tamat }}"
                                    data-email="{{ $a->email }}"
                                    data-nohp="{{ $a->no_hp }}"
                                    data-pekerjaan="{{ $a->pekerjaan ?? 'Belum diisi' }}"
                                    data-lokasi="{{ $a->lokasi ?? 'Belum diisi' }}"
                                    data-foto="{{ $a->foto ? asset('storage/' . $a->foto) : asset('images/default-avatar.png') }}"
                                    data-bio="{{ $a->bio ?? 'Belum ada bio.' }}"
                                    data-linkedin="{{ $a->linkedin ?? '-' }}"
                                    data-instagram="{{ $a->instagram ?? '-' }}"
                                    data-pendidikan_lanjutan="{{ $a->pendidikan_lanjutan ?? 'Belum diisi' }}"
                                    data-tahun_masuk="{{ $a->tahun_masuk }}"
                                    data-tahun_tamat="{{ $a->tahun_tamat }}"
                                    type="button">
                                    <i class="fas fa-eye"></i>
                                </button>
                                
                                <button 
                                    class="btn btn-outline-primary btn-sm chatBtn" 
                                    data-email="{{ $a->email }}"
                                    data-nama="{{ $a->nama }}"
                                    data-nohp="{{ $a->no_hp }}"
                                    type="button">
                                    <i class="fas fa-envelope"></i>
                                </button>
                            </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tambahkan section komentar di bagian bawah sebelum penutup section -->
<div class="comment-section fade-in">
    <div class="comment-header">
        <h3 class="comment-title">
            <i class="fas fa-comments me-2"></i>Komentar & Ulasan Aplikasi DARLI
        </h3>
        <div class="comment-stats">
            <span class="comment-count">{{ $comments->count() }} Ulasan</span>
            @php
                $avgRating = $comments->avg('rating') ?: 0;
                $fullStars = floor($avgRating);
            @endphp
            <div class="rating-summary">
                <span class="average-rating">{{ number_format($avgRating, 1) }}</span>
                <div class="stars">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star {{ $i <= $fullStars ? 'star' : 'star empty' }}"></i>
                    @endfor
                </div>
            </div>
        </div>
    </div>

    <!-- Comment Form -->
    <div class="comment-form">
        <h5 class="mb-3">Bagikan Pengalaman Anda</h5>
        <form id="commentForm" action="{{ route('comments.store') }}" method="POST">
            @csrf
            <!-- Gunakan 0 untuk komentar aplikasi, bukan user ID -->
            <input type="hidden" name="target_user_id" value="0">
            
            <div class="rating-input">
                <span class="rating-label">Rating:</span>
                <div class="star-rating">
                    <input type="radio" id="star5" name="rating" value="5" required>
                    <label for="star5">★</label>
                    <input type="radio" id="star4" name="rating" value="4">
                    <label for="star4">★</label>
                    <input type="radio" id="star3" name="rating" value="3">
                    <label for="star3">★</label>
                    <input type="radio" id="star2" name="rating" value="2">
                    <label for="star2">★</label>
                    <input type="radio" id="star1" name="rating" value="1">
                    <label for="star1">★</label>
                </div>
            </div>
            
            <div class="form-group">
                <textarea 
                    name="content"
                    class="comment-textarea" 
                    placeholder="Bagikan pengalaman Anda menggunakan aplikasi DARLI..." 
                    required></textarea>
            </div>
            
            <div class="form-actions">
                <button type="button" class="btn btn-outline-primary" onclick="this.form.reset()">Batal</button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane me-2"></i>Kirim Ulasan
                </button>
            </div>
        </form>
    </div>

    <!-- Daftar Komentar -->
<div id="commentList">
    <div class="comments-list mt-4">
        @forelse ($comments as $comment)
            <div class="comment-item mb-3 p-3 border rounded">
                <div class="comment-header-info d-flex align-items-center">
                    <img src="{{ $comment->user->foto ? asset('storage/' . $comment->user->foto) : asset('images/default-avatar.png') }}" 
                        alt="User" class="comment-avatar me-2" 
                        style="width:50px; height:50px; border-radius:50%; object-fit:cover;">
                    <div class="comment-user-info">
                        <h6 class="comment-user-name mb-0">{{ $comment->user->nama }}</h6>
                        <div class="comment-meta">
                            <span class="comment-date">{{ $comment->created_at->diffForHumans() }}</span>
                            @if($comment->rating)
                                <div class="comment-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $comment->rating ? 'star' : 'star empty' }}"></i>
                                    @endfor
                                    
                                    {{-- Status Pending/Rejected untuk Pemilik Komentar --}}
                                    @if($comment->user_id == Auth::user()->id_user)
                                        <div class="mt-1">
                                            @if($comment->admin_status == 'pending' || $comment->mudir_status == 'pending')
                                                <span class="badge bg-warning text-dark small"><i class="fas fa-clock me-1"></i>Menunggu Persetujuan</span>
                                            @elseif($comment->admin_status == 'rejected' || $comment->mudir_status == 'rejected')
                                                <span class="badge bg-danger small"><i class="fas fa-times me-1"></i>Ditolak</span>
                                            @else
                                                <span class="badge bg-success small"><i class="fas fa-check me-1"></i>Terbit</span>
                                            @endif
                                            
                                            <span class="text-muted x-small ms-1">
                                                (Admin: {{ $comment->admin_status }}, Pimpinan: {{ $comment->mudir_status }})
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="comment-content mt-2">
                    <p>{{ $comment->content }}</p>
                </div>

                {{-- Balasan Admin --}}
                @if($comment->admin_reply)
                    <div class="ms-4 mt-2 border-start ps-3 bg-light rounded p-2">
                        <div class="d-flex align-items-center mb-1">
                            <img src="{{ ($admin && $admin->foto) ? asset('storage/' . $admin->foto) : asset('images/images.jpg') }}" 
                                alt="Admin" style="width:30px; height:30px; border-radius:50%; object-fit:cover;" class="me-2">
                            <strong>Admin</strong>
                            <span class="badge bg-primary ms-1">Admin</span>
                            <small class="text-muted ms-2">{{ $comment->admin_reply_date ? \Carbon\Carbon::parse($comment->admin_reply_date)->diffForHumans() : '' }}</small>
                        </div>
                        <p class="mb-1 small">{{ $comment->admin_reply }}</p>
                    </div>
                @endif

                {{-- Balasan Mudir --}}
                @if($comment->mudir_reply)
                    <div class="ms-4 mt-2 border-start ps-3 bg-light rounded p-2 border-success border-opacity-25">
                        <div class="d-flex align-items-center mb-1">
                            <img src="{{ ($mudir && $mudir->foto) ? asset('storage/' . $mudir->foto) : asset('images/images.jpg') }}" 
                                alt="Pimpinan" style="width:30px; height:30px; border-radius:50%; object-fit:cover;" class="me-2">
                            <strong>Pimpinan (Mudir)</strong>
                            <span class="badge bg-success ms-1">Pimpinan</span>
                            <small class="text-muted ms-2">{{ $comment->mudir_reply_date ? \Carbon\Carbon::parse($comment->mudir_reply_date)->diffForHumans() : '' }}</small>
                        </div>
                        <p class="mb-1 small">{{ $comment->mudir_reply }}</p>
                    </div>
                @endif

                {{-- Balasan Alumni --}}
                <div id="balasan-komentar-{{ $comment->id }}">
                    @foreach ($comment->replies as $reply)
                        <div class="ms-4 mt-2 border-start ps-3">
                            <div class="d-flex align-items-center mb-1">
                                <img src="{{ $reply->user->foto ? asset('storage/' . $reply->user->foto) : asset('images/default-avatar.png') }}" 
                                    alt="User" style="width:30px; height:30px; border-radius:50%; object-fit:cover;" class="me-2">
                                <strong>{{ $reply->user->nama }}</strong>
                                <span class="badge bg-success ms-1">Alumni</span>
                                <small class="text-muted ms-2">{{ $reply->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1">{{ $reply->content }}</p>
                        </div>
                    @endforeach
                </div>

                {{-- Form Balas --}}
                <form action="{{ route('comments.store') }}" method="POST" class="ms-4 mt-2 form-balas">
                    @csrf
                    <input type="hidden" name="target_user_id" value="0">
                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                    <div class="input-group">
                        <textarea name="content" rows="1" class="form-control" placeholder="Balas komentar..." required></textarea>
                        <button type="submit" class="btn btn-outline-primary">Balas</button>
                    </div>
                </form>
            </div>
        @empty
            <div class="no-comments text-center py-5">
                <i class="fas fa-comments"></i>
                <h5 class="mt-3">Belum ada ulasan</h5>
                <p class="text-muted">Jadilah yang pertama memberikan ulasan!</p>
            </div>
        @endforelse
    </div>
</div>


</div>

<!-- Generic Info Pondok Modal -->
<div class="modal fade" id="infoModalGeneric" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalInfoTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="modalInfoImage" src="" class="img-fluid rounded mb-3" style="display:none;" alt="Info Image">
                <div class="mb-2">
                    <span id="modalInfoBadge" class="badge"></span>
                    <small class="text-muted ms-2"><i class="far fa-clock me-1"></i><span id="modalInfoDate"></span></small>
                </div>
                <p id="modalInfoContent" style="white-space: pre-line;"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

    </div>
</div>

<!-- Generic Ustadz Detail Modal -->
<div class="modal fade" id="ustadzModalGeneric" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title"><i class="fas fa-user-tie me-2"></i>Detail Ustadz</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4">
                <img id="modalUstadzFoto" src="" class="rounded-circle shadow mb-3" style="width: 120px; height: 120px; object-fit: cover; display: none; margin: 0 auto; border: 4px solid var(--primary-blue);" alt="Ustadz">
                <div id="modalUstadzAvatarPlaceholder" class="rounded-circle shadow mb-3 align-items-center justify-content-center bg-gradient-primary text-white fw-bold" style="width: 120px; height: 120px; margin: 0 auto; font-size: 2.5rem; display: none;"></div>
                
                <h5 id="modalUstadzNama" class="fw-bold mb-1" style="color: var(--primary-blue);"></h5>
                <p id="modalUstadzJabatan" class="text-muted mb-2"></p>
                <p class="mb-3">
                    <span class="badge bg-light text-primary border px-3 py-2 rounded-pill">
                        <i class="fas fa-phone-alt me-2"></i><span id="modalUstadzNoHP"></span>
                    </span>
                </p>
                <div id="modalUstadzBidang" class="mb-4"></div>

                <div class="d-grid gap-3 col-11 mx-auto">
                    <a href="#" id="btnUstadzWA" class="btn btn-primary rounded-pill shadow-sm py-2" target="_blank">
                        <i class="fab fa-whatsapp me-2"></i>Hubungi via WhatsApp
                    </a>
                    <a href="#" id="btnUstadzEmail" class="btn btn-outline-primary rounded-pill py-2" target="_blank">
                        <i class="fas fa-envelope me-2"></i>Kirim Email
                    </a>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

    </div>
</div>

<!-- Generic Event Detail Modal -->
<div class="modal fade" id="eventModalGeneric" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-gradient-primary text-white border-0">
                <h5 class="modal-title"><i class="fas fa-calendar-check me-2"></i>Detail Reuni & Event</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div id="modalEventImageContainer" class="position-relative" style="display: none;">
                    <img id="modalEventImage" src="" class="img-fluid w-100" style="max-height: 350px; object-fit: cover;" alt="Event Image">
                    <div class="position-absolute bottom-0 start-0 w-100 p-3 bg-gradient-dark text-white">
                        <h4 id="modalEventTitle" class="fw-bold mb-0"></h4>
                    </div>
                </div>
                <div class="p-4">
                    <div id="modalEventTitleAlt" class="mb-3">
                        <h4 class="fw-bold text-primary mb-0"></h4>
                    </div>
                    
                    <div class="row g-3 mb-4">
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded shadow-sm h-100">
                                <div class="icon-circle bg-primary text-white me-3">
                                    <i class="fas fa-calendar-day"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Waktu & Tanggal</small>
                                    <span id="modalEventDateTime" class="fw-bold"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded shadow-sm h-100">
                                <div class="icon-circle bg-success text-white me-3">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Lokasi</small>
                                    <span id="modalEventLocation" class="fw-bold"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5 class="fw-bold border-bottom pb-2 mb-3">Deskripsi Event</h5>
                        <p id="modalEventDescription" class="text-muted" style="white-space: pre-line;"></p>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center p-3 bg-soft-primary rounded border border-primary border-opacity-25">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle text-primary fs-4 me-3"></i>
                            <div>
                                <h6 class="mb-0 fw-bold">Kategori</h6>
                                <span id="modalEventCategory" class="badge bg-primary"></span>
                            </div>
                        </div>
                        <a href="{{ route('event') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                            <i class="fas fa-external-link-alt me-2"></i>Halaman Event
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 p-3">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Profile Modal -->
<div class="modal fade" id="profileModal1" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="profileModalLabel">
                    <i class="fas fa-user-circle me-2"></i>Profil Alumni
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <!-- Kolom Foto & Info Dasar -->
                    <div class="col-md-4 text-center border-end">
                        <img 
                            src="{{ asset('images/default-avatar.png') }}" 
                            class="rounded-circle shadow mb-3" 
                            alt="Profile" 
                            id="modalFoto"
                            style="width:150px; height:150px; object-fit:cover; border: 4px solid var(--primary-blue);">
                        
                        <h5 class="fw-bold text-primary mb-1" id="modalNama2">Nama Alumni</h5>
                        <p class="text-muted mb-2" id="modalAngkatan">
                            <i class="fas fa-graduation-cap me-1"></i>Angkatan ...
                        </p>
                        <p class="text-muted mb-3" id="modalPekerjaan">
                            <i class="fas fa-briefcase me-1"></i>Pekerjaan
                        </p>
                        
                        <!-- Tombol Aksi -->
                        <div class="d-grid gap-2 mt-3">
                            <button class="btn btn-primary" id="btnKirimPesan">
                                <i class="fas fa-envelope me-2"></i>Kirim Pesan
                            </button>
                            <button class="btn btn-outline-success" id="btnWhatsApp">
                                <i class="fab fa-whatsapp me-2"></i>WhatsApp
                            </button>
                        </div>
                    </div>

                    <!-- Kolom Detail Informasi -->
                    <div class="col-md-8">
                        <!-- Bio Section -->
                        <div class="mb-4">
                            <h6 class="text-primary fw-bold mb-2">
                                <i class="fas fa-user me-2"></i>Bio
                            </h6>
                            <div class="bg-light p-3 rounded">
                                <p class="mb-0" id="modalBio">Belum ada bio.</p>
                            </div>
                        </div>
                        
                        <!-- Kontak Section -->
                        <div class="mb-4">
                            <h6 class="text-primary fw-bold mb-3">
                                <i class="fas fa-address-card me-2"></i>Informasi Kontak
                            </h6>
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-box bg-primary bg-opacity-10 rounded p-2 me-2">
                                            <i class="fas fa-envelope text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <small class="text-muted d-block">Email</small>
                                            <span class="fw-semibold text-break" id="modalEmail">-</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-box bg-success bg-opacity-10 rounded p-2 me-2">
                                            <i class="fas fa-phone text-success"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <small class="text-muted d-block">No. HP</small>
                                            <span class="fw-semibold" id="modalNoHP">-</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-box bg-info bg-opacity-10 rounded p-2 me-2">
                                            <i class="fab fa-linkedin text-info"></i>
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <small class="text-muted d-block">LinkedIn</small>
                                            <a href="#" id="modalLinkedinLink" target="_blank" class="fw-semibold text-decoration-none text-break">
                                                <span id="modalLinkedin">-</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-box bg-danger bg-opacity-10 rounded p-2 me-2">
                                            <i class="fab fa-instagram text-danger"></i>
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <small class="text-muted d-block">Instagram</small>
                                            <a href="#" id="modalInstagramLink" target="_blank" class="fw-semibold text-decoration-none text-break">
                                                <span id="modalInstagram">-</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Lokasi Section -->
                        <div class="mb-3">
                            <h6 class="text-primary fw-bold mb-2">
                                <i class="fas fa-map-marker-alt me-2"></i>Lokasi
                            </h6>
                            <div class="bg-light p-3 rounded">
                                <p class="mb-0" id="modalLokasi">
                                    <i class="fas fa-building me-2"></i>Belum ada informasi lokasi
                                </p>
                            </div>
                        </div>

                        <!-- Pendidikan Lanjutan Section -->
                        <div class="mb-3">
                            <h6 class="text-primary fw-bold mb-2">
                                <i class="fas fa-graduation-cap me-2"></i>Setelah Tamat Lanjut ke mana?
                            </h6>
                            <div class="bg-light p-3 rounded">
                                <p class="mb-0" id="modalPendidikanLanjutan">Belum diisi.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Tutup
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
console.log('Script loaded!');

document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM Ready!');
    
    // ========== TOMBOL MATA (VIEW PROFILE) ==========
    const viewBtns = document.querySelectorAll('.viewProfileBtn');
    viewBtns.forEach((btn, index) => {
        btn.addEventListener('click', function () {
            const nama = this.getAttribute('data-nama');
            const masuk = this.getAttribute('data-masuk');
            const tamat = this.getAttribute('data-tamat');
            const email = this.getAttribute('data-email');
            const nohp = this.getAttribute('data-nohp');
            const pekerjaan = this.getAttribute('data-pekerjaan');
            const lokasi = this.getAttribute('data-lokasi');
            const foto = this.getAttribute('data-foto');
            const bio = this.getAttribute('data-bio');
            const linkedin = this.getAttribute('data-linkedin');
            const instagram = this.getAttribute('data-instagram');
            const pendidikan = this.getAttribute('data-pendidikan_lanjutan');
            const thMasuk = this.getAttribute('data-tahun_masuk');
            const thTamat = this.getAttribute('data-tahun_tamat');

            // Isi modal
            document.getElementById('modalNama2').textContent = nama;
            
            let displayAngkatan = 'Tahun: ' + (masuk || '?') + ' - ' + (tamat || '?');
            if(thMasuk && thTamat) {
                displayAngkatan = 'Angkatan ' + thMasuk + ' - ' + thTamat;
            }
            document.getElementById('modalAngkatan').innerHTML = '<i class="fas fa-graduation-cap me-1"></i>' + displayAngkatan;
            document.getElementById('modalPekerjaan').innerHTML = '<i class="fas fa-briefcase me-1"></i>' + pekerjaan;
            
            // Email (Public)
            const modalEmail = document.getElementById('modalEmail');
            const btnChat = document.getElementById('btnKirimPesan');
            modalEmail.textContent = email || '-';
            btnChat.style.display = 'block';
            btnChat.onclick = function() {
                const subjek = encodeURIComponent('Salam dari Alumni DARLI');
                const pesan = encodeURIComponent(`Assalamualaikum ${nama},\n\nSaya alumni DARLI ingin berkomunikasi dengan Anda.\n\nTerima kasih.`);
                window.open(`https://mail.google.com/mail/?view=cm&fs=1&to=${email}&su=${subjek}&body=${pesan}`, '_blank');
            };
            
            // Phone (Public)
            const modalPhone = document.getElementById('modalNoHP');
            const btnWA = document.getElementById('btnWhatsApp');
            modalPhone.textContent = nohp || '-';
            btnWA.style.display = 'block';
            btnWA.onclick = function() {
                const cleanPhone = nohp.replace(/\D/g, '');
                const waNumber = cleanPhone.startsWith('0') ? '62' + cleanPhone.substring(1) : cleanPhone;
                const waMessage = encodeURIComponent(`Assalamualaikum ${nama}, saya alumni DARLI ingin berkomunikasi dengan Anda.`);
                window.open(`https://wa.me/${waNumber}?text=${waMessage}`, '_blank');
            };

            document.getElementById('modalBio').textContent = bio;
            document.getElementById('modalLokasi').innerHTML = '<i class="fas fa-building me-2"></i>' + lokasi;
            document.getElementById('modalFoto').src = foto;

            // Instagram & LinkedIn
            document.getElementById('modalInstagram').textContent = instagram;
            document.getElementById('modalLinkedin').textContent = linkedin;
            
            const igLink = document.getElementById('modalInstagramLink');
            if(instagram && instagram !== '-') {
                igLink.href = instagram.startsWith('http') ? instagram : `https://instagram.com/${instagram}`;
                igLink.classList.remove('text-muted');
            } else {
                igLink.href = '#';
                igLink.classList.add('text-muted');
            }

            const lnLink = document.getElementById('modalLinkedinLink');
            if(linkedin && linkedin !== '-') {
                lnLink.href = linkedin.startsWith('http') ? linkedin : `https://linkedin.com/in/${linkedin}`;
                lnLink.classList.remove('text-muted');
            } else {
                lnLink.href = '#';
                lnLink.classList.add('text-muted');
            }

            document.getElementById('modalPendidikanLanjutan').textContent = pendidikan;
        });
    });

    // ========== TOMBOL AMPLOP (CHAT) ==========
    const chatBtns = document.querySelectorAll('.chatBtn');
    chatBtns.forEach((btn) => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const email = this.getAttribute('data-email');
            const nama = this.getAttribute('data-nama');
            const nohp = this.getAttribute('data-nohp');
            const pilihan = confirm(`Pilih metode kontak untuk ${nama}:\n\n✉️ OK = Email (Gmail)\n📱 Cancel = WhatsApp`);
            if (pilihan) {
                const subjek = encodeURIComponent('Salam dari Alumni DARLI');
                const pesan = encodeURIComponent(`Assalamualaikum ${nama},\n\nSaya alumni DARLI ingin berkomunikasi dengan Anda.\n\nTerima kasih.`);
                window.open(`https://mail.google.com/mail/?view=cm&fs=1&to=${email}&su=${subjek}&body=${pesan}`, '_blank');
            } else {
                const cleanPhone = nohp.replace(/\D/g, '');
                const waNumber = cleanPhone.startsWith('0') ? '62' + cleanPhone.substring(1) : cleanPhone;
                const waMessage = encodeURIComponent(`Assalamualaikum ${nama}, saya alumni DARLI ingin berkomunikasi dengan Anda.`);
                window.open(`https://wa.me/${waNumber}?text=${waMessage}`, '_blank');
            }
        });
    });

    // ========== FILTER & SORT ==========
    const filterButtons = document.querySelectorAll('.filter-btn');
    filterButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            filterButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });
    const sortSelect = document.querySelector('.sort-select');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            console.log('Sort by:', this.value);
        });
    }

    // ========== INFO PONDOK MODAL (Dynamic) ==========
    const infoModalElement = document.getElementById('infoModalGeneric');
    // Pre-initialize modal to avoid lag on first click if possible, or just init on click
    let infoModal = null;
    if(infoModalElement) {
        infoModal = new bootstrap.Modal(infoModalElement);
    }

    document.querySelectorAll('.btn-detail-info').forEach(item => {
        item.addEventListener('click', function() {
            const judul = this.getAttribute('data-judul');
            const konten = this.getAttribute('data-konten');
            const jenis = this.getAttribute('data-jenis');
            const tanggal = this.getAttribute('data-tanggal');
            const gambar = this.getAttribute('data-gambar');

            document.getElementById('modalInfoTitle').innerText = judul;
            document.getElementById('modalInfoContent').innerText = konten;
            document.getElementById('modalInfoDate').innerText = tanggal;
            
            const badge = document.getElementById('modalInfoBadge');
            badge.innerText = jenis;
            // Reset classes
            badge.className = 'badge';
            if(jenis === 'Pengumuman') badge.classList.add('bg-primary');
            else if(jenis === 'Kegiatan') badge.classList.add('bg-success');
            else badge.classList.add('bg-info');

            const img = document.getElementById('modalInfoImage');
            if(gambar) {
                img.src = gambar;
                img.style.display = 'block';
            } else {
                img.style.display = 'none';
            }

            if(infoModal) infoModal.show();
        });
    });

    // ========== FILTER INFO PONDOK ==========
    const filterInfoInput = document.getElementById('filterInfoInput');
    const infoList = document.getElementById('infoPondokList');
    if (filterInfoInput && infoList) {
        filterInfoInput.addEventListener('keyup', function() {
            const filterValue = this.value.toLowerCase();
            const items = infoList.querySelectorAll('.info-item');

            items.forEach(item => {
                const title = item.querySelector('.info-title').textContent.toLowerCase();
                const preview = item.querySelector('.info-preview').textContent.toLowerCase();
                
                if (title.includes(filterValue) || preview.includes(filterValue)) {
                    item.style.display = "";
                } else {
                    item.style.display = "none";
                }
            });
        });
    }

    // ========== FILTER USTADZ ==========
    const filterUstadzInput = document.getElementById('filterUstadzInput');
    const ustadzList = document.getElementById('ustadzList');
    if (filterUstadzInput && ustadzList) {
        filterUstadzInput.addEventListener('keyup', function() {
            const filterValue = this.value.toLowerCase();
            const items = ustadzList.querySelectorAll('.ustadz-item');
            
            items.forEach(item => {
                const name = item.querySelector('.ustadz-name').textContent.toLowerCase();
                const jabatan = item.querySelector('.ustadz-jabatan').textContent.toLowerCase();
                
                if (name.includes(filterValue) || jabatan.includes(filterValue)) {
                    item.style.display = "";
                } else {
                    item.style.display = "none";
                }
            });
        });
    }

    // ========== MODAL USTADZ ELEMENT ==========
    const ustadzModalElement = document.getElementById('ustadzModalGeneric');
    let ustadzModal = null;
    if (ustadzModalElement) {
        ustadzModal = new bootstrap.Modal(ustadzModalElement);
    }

    document.querySelectorAll('.btn-detail-ustadz').forEach(item => {
        item.addEventListener('click', function() {
            const nama = this.getAttribute('data-nama');
            const jabatan = this.getAttribute('data-jabatan');
            const bidang = this.getAttribute('data-bidang');
            const nohp = this.getAttribute('data-nohp');
            const email = this.getAttribute('data-email');
            const foto = this.getAttribute('data-foto');

            document.getElementById('modalUstadzNama').innerText = nama;
            document.getElementById('modalUstadzJabatan').innerText = jabatan;
            document.getElementById('modalUstadzNoHP').innerText = nohp;

            // Bidang badges
            const bidangContainer = document.getElementById('modalUstadzBidang');
            bidangContainer.innerHTML = '';
            if(bidang) {
                const fields = bidang.split(',');
                fields.forEach(f => {
                    const span = document.createElement('span');
                    span.className = 'badge bg-light text-dark border me-1';
                    span.innerText = f.trim();
                    bidangContainer.appendChild(span);
                });
            }

            // Foto vs Placeholder
            const img = document.getElementById('modalUstadzFoto');
            const placeholder = document.getElementById('modalUstadzAvatarPlaceholder');
            
            if(foto && foto.trim() !== "" && !foto.includes('storage/')) {
                // This is a check for asset('storage/') without a path
                // But let's be more robust: check if foto ends with storage/
            }

            if(foto && !foto.endsWith('storage/')) {
                img.src = foto;
                img.style.display = 'block';
                placeholder.classList.add('d-none');
                placeholder.classList.remove('d-flex');
            } else {
                img.style.display = 'none';
                placeholder.innerText = nama.substring(0,2).toUpperCase();
                placeholder.classList.remove('d-none');
                placeholder.classList.add('d-flex');
            }

            // Buttons
            const btnWA = document.getElementById('btnUstadzWA');
            const btnEmail = document.getElementById('btnUstadzEmail');
            
            if(nohp) {
                let cleanHP = nohp.replace(/\D/g, '');
                if(cleanHP.startsWith('0')) cleanHP = '62' + cleanHP.substring(1);
                btnWA.href = `https://wa.me/${cleanHP}`;
                btnWA.classList.remove('disabled');
            } else {
                btnWA.href = '#';
                btnWA.classList.add('disabled');
            }

            if(email) {
                btnEmail.href = `mailto:${email}`;
                btnEmail.classList.remove('disabled');
            } else {
                btnEmail.href = '#';
                btnEmail.classList.add('disabled');
            }

            if(ustadzModal) ustadzModal.show();
        });
    });

    // ========== MODAL EVENT ELEMENT ==========
    const eventModalElement = document.getElementById('eventModalGeneric');
    let eventModal = null;
    if (eventModalElement) {
        eventModal = new bootstrap.Modal(eventModalElement);
    }

    document.querySelectorAll('.btn-detail-event').forEach(item => {
        item.addEventListener('click', function() {
            const title = this.getAttribute('data-title');
            const date = this.getAttribute('data-date');
            const time = this.getAttribute('data-time');
            const location = this.getAttribute('data-location');
            const category = this.getAttribute('data-category');
            const description = this.getAttribute('data-description');
            const image = this.getAttribute('data-image');

            // Set Title
            document.getElementById('modalEventTitle').innerText = title;
            document.querySelector('#modalEventTitleAlt h4').innerText = title;

            // Date & Time
            document.getElementById('modalEventDateTime').innerText = `${date} (${time})`;
            
            // Location
            document.getElementById('modalEventLocation').innerText = location;

            // Category
            document.getElementById('modalEventCategory').innerText = category;

            // Description
            document.getElementById('modalEventDescription').innerText = description;

            // Image handling
            const imgContainer = document.getElementById('modalEventImageContainer');
            const img = document.getElementById('modalEventImage');
            const titleAlt = document.getElementById('modalEventTitleAlt');

            if(image && image.trim() !== "" && !image.endsWith('storage/')) {
                img.src = image;
                imgContainer.style.display = 'block';
                titleAlt.style.display = 'none';
            } else {
                imgContainer.style.display = 'none';
                titleAlt.style.display = 'block';
            }

            if(eventModal) eventModal.show();
        });
    });
});
</script>

<script>
// =============================================================
// ========== AJAX KOMENTAR (Tambah & Balasan) =================
// =============================================================
$(document).ready(function() {

    // ===== Kirim komentar utama =====
    $('#commentForm').on('submit', function(e) {
        e.preventDefault();
        let form = $(this);
        let url = form.attr('action');
        let data = form.serialize();

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            beforeSend: function() {
                form.find('button[type=submit]').prop('disabled', true).text('Mengirim...');
            },
            success: function(response) {
                form.find('button[type=submit]').prop('disabled', false).html('<i class="fas fa-paper-plane me-2"></i>Kirim Ulasan');
                form.trigger('reset');
                
                let rating = parseInt(response.rating) || 0;
                let starsHtml = '';
                if (rating > 0) {
                    starsHtml = `
                        <div class="comment-rating">
                            ${'<i class="fas fa-star star"></i>'.repeat(rating)}
                            ${'<i class="fas fa-star star empty"></i>'.repeat(5 - rating)}
                        </div>
                    `;
                }

                $('.no-comments').hide();
                $('.comments-list').prepend(`
                    <div class="comment-item mb-3 p-3 border rounded">
                        <div class="comment-header-info d-flex align-items-center">
                            <img src="${response.user_foto}" alt="User" class="comment-avatar me-2" style="width:50px;height:50px;border-radius:50%;object-fit:cover;">
                            <div class="comment-user-info">
                                <h6 class="comment-user-name mb-0">${response.user_nama}</h6>
                                <div class="comment-meta">
                                    <span class="comment-date">Baru saja</span>
                                    ${starsHtml}
                                </div>
                            </div>
                        </div>
                        <div class="comment-content mt-2"><p>${response.content}</p></div>
                    </div>
                `);
            },
            error: function(xhr) {
                alert('Gagal mengirim komentar.');
                form.find('button[type=submit]').prop('disabled', false).html('<i class="fas fa-paper-plane me-2"></i>Kirim Ulasan');
            }
        });
    });
});
</script>


<script>
$(document).on('submit', '.form-balas', function(e) {
    e.preventDefault();

    let form = $(this);
    let formData = form.serialize();
    let parentId = form.find('input[name="parent_id"]').val();
    let url = form.attr('action');

    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        success: function(response) {
            // Kosongkan textarea
            form.find('textarea[name="content"]').val('');

            // Buat HTML balasan baru
            let newReply = `
                <div class="ms-4 mt-2 border-start ps-3">
                    <div class="d-flex align-items-center mb-1">
                        <img src="${response.user_foto}" 
                             alt="User" style="width:30px; height:30px; border-radius:50%; object-fit:cover;" class="me-2">
                        <strong>${response.user_nama}</strong>
                        <span class="badge bg-success ms-1">Alumni</span>
                        <small class="text-muted ms-2">baru saja</small>
                    </div>
                    <p class="mb-1">${response.content}</p>
                </div>
            `;

            // Tambahkan langsung ke bawah komentar yang sesuai
            $('#balasan-komentar-' + parentId).append(newReply);
        },
        error: function(xhr) {
            alert('Gagal mengirim balasan!');
        }
    });
});
</script>

<!--pencarian dan filter tabel alumni-->

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const angkatanFilter = document.getElementById('angkatanFilter');
    const profesiFilter = document.getElementById('profesiFilter');
    const table = document.getElementById('alumniTable');
    if (!table) return; // Guard clause
    const rows = table.getElementsByTagName('tr');

    function filterTable() {
        const searchText = searchInput.value.toLowerCase();
        const selectedAngkatan = angkatanFilter.value;
        const selectedProfesi = profesiFilter.value;

        for (let i = 1; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            if (cells.length > 0) {
                const nama = cells[1].innerText.toLowerCase();
                const angkatan = cells[2].innerText.trim();
                const profesi = cells[3].innerText.trim().toLowerCase();
                const lokasi = cells[4].innerText.toLowerCase();

                const matchSearch =
                    nama.includes(searchText) ||
                    profesi.includes(searchText) ||
                    lokasi.includes(searchText);
                const matchAngkatan =
                    selectedAngkatan === "Semua Tahun" || angkatan.includes(selectedAngkatan);
                const matchProfesi =
                    selectedProfesi === "Semua Profesi" || profesi === selectedProfesi.toLowerCase();

                if (matchSearch && matchAngkatan && matchProfesi) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        }
    }

    if (searchInput) searchInput.addEventListener('input', filterTable);
    if (angkatanFilter) angkatanFilter.addEventListener('change', filterTable);
    if (profesiFilter) profesiFilter.addEventListener('change', filterTable);
});
</script>
@endpush
@endsection