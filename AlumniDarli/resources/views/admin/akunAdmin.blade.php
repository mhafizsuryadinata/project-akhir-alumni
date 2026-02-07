@extends('admin-master')

@push('styles')
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

    /* Hero Section - Matching page-hero theme */
    .hero-akun {
        background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
        color: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        margin-bottom: 2rem;
        box-shadow: 0 15px 35px rgba(15, 12, 41, 0.2);
        position: relative;
        overflow: hidden;
    }
    
    .hero-akun h1 {
        font-weight: 800;
        font-size: 1.5rem;
        margin-bottom: 0.25rem;
        position: relative;
    }
    
    .hero-akun p {
        font-size: 0.9rem;
        opacity: 0.75;
        position: relative;
    }

    /* Cards */
    .card-profile {
        background: var(--white);
        border: 1px solid rgba(26, 115, 232, 0.1);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        transition: var(--transition);
        overflow: hidden;
        margin-bottom: 30px;
    }
    
    .card-profile:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-hover);
        border-color: var(--primary-blue);
    }
    
    .card-profile .card-header {
        background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
        color: var(--white);
        border: none;
        padding: 1.25rem 1.5rem;
        font-weight: 600;
    }

    /* Profile Section */
    .profile-section-akun {
        text-align: center;
        padding: 2.5rem 1.5rem;
    }
    
    .profile-avatar-akun {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        border: 5px solid var(--primary-blue);
        margin: 0 auto 1.5rem;
        object-fit: cover;
        box-shadow: var(--shadow);
    }
    
    .profile-name-akun {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: var(--primary-blue);
    }
    
    .profile-role-akun {
        font-size: 1rem;
        color: var(--dark-gray);
        margin-bottom: 1.5rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: 600;
    }
    
    .profile-stats-akun {
        display: flex;
        justify-content: center;
        gap: 3rem;
        margin-bottom: 2rem;
    }
    
    .stat-item-akun {
        text-align: center;
    }
    
    .stat-number-akun {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--primary-blue);
    }
    
    .stat-label-akun {
        font-size: 0.875rem;
        color: var(--dark-gray);
        font-weight: 500;
    }

    /* Tabs */
    .nav-tabs-akun {
        border-bottom: 2px solid var(--medium-gray);
        gap: 10px;
    }
    
    .nav-tabs-akun .nav-link {
        border: none;
        color: var(--dark-gray);
        font-weight: 600;
        padding: 1rem 2rem;
        border-radius: 12px 12px 0 0;
        transition: var(--transition);
        background: transparent;
    }
    
    .nav-tabs-akun .nav-link.active {
        color: var(--primary-blue);
        background: var(--white);
        border-bottom: 4px solid var(--primary-blue);
    }

    .form-section-akun {
        padding: 1rem 0;
    }

    .section-title-akun {
        color: var(--dark-gray);
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .section-title-akun i {
        color: var(--primary-blue);
    }

    .form-control-akun {
        border: 2px solid var(--medium-gray);
        border-radius: 12px;
        padding: 0.8rem 1.2rem;
        transition: var(--transition);
    }

    .form-control-akun:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 0.25rem rgba(26, 115, 232, 0.15);
    }

    .btn-save-akun {
        background: var(--primary-blue);
        border: none;
        border-radius: 12px;
        padding: 0.8rem 2rem;
        font-weight: 600;
        color: white;
        transition: var(--transition);
    }

    .btn-save-akun:hover {
        background: var(--dark-blue);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(26,115,232,0.3);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .fade-in-akun {
        animation: fadeIn 0.5s ease-out;
    }
</style>
@endpush

@section('isi')
<!-- Hero Section -->
<section class="hero-akun fade-in-akun">
    <div class="container">
        <h1>Profil Admin</h1>
        <p>Kelola informasi identitas dan keamanan akun administrator Anda</p>
    </div>
</section>

<div class="row g-4">
    <!-- Left Column: Profile Card -->
    <div class="col-lg-4">
        <div class="card-profile fade-in-akun">
            <div class="profile-section-akun">
                <div class="position-relative d-inline-block mb-4">
                    <img src="{{ $user->foto ? asset('storage/' . $user->foto) : asset('images/saya.jpeg') }}" 
                         class="profile-avatar-akun" 
                         alt="Admin Profile"
                         id="previewFoto">
                    <button class="btn btn-sm btn-primary position-absolute bottom-0 end-0 rounded-circle p-2 shadow"
                            onclick="document.getElementById('inputFoto').click()">
                        <i class="fas fa-camera"></i>
                    </button>
                </div>
                
                <h2 class="profile-name-akun text-truncate">{{ $user->nama ?? $user->username }}</h2>
                <p class="profile-role-akun">Administrator</p>
                
                <div class="profile-stats-akun">
                    <div class="stat-item-akun">
                        <div class="stat-number-akun">{{ $totalAlumni }}</div>
                        <div class="stat-label-akun">Alumni</div>
                    </div>
                    <div class="stat-item-akun">
                        <div class="stat-number-akun">{{ $totalEvents }}</div>
                        <div class="stat-label-akun">Event</div>
                    </div>
                </div>

                <div class="alert alert-info small py-2 px-3 border-0 rounded-3 mb-0">
                    <i class="fas fa-info-circle me-1"></i> Terdaftar sejak {{ $user->created_at->format('d M Y') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Tabs Content -->
    <div class="col-lg-8">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <ul class="nav nav-tabs-akun mb-4" id="adminTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button">
                    <i class="fas fa-user-edit me-2"></i>Edit Profil
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button">
                    <i class="fas fa-lock me-2"></i>Keamanan
                </button>
            </li>
        </ul>

        <div class="tab-content" id="adminTabsContent">
            <!-- Tab Edit Profil -->
            <div class="tab-pane fade show active" id="profile">
                <div class="card card-profile border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form action="{{ route('admin.akun.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="foto" id="inputFoto" class="d-none" accept="image/*" onchange="previewImage(this)">
                            
                            <div class="form-section-akun">
                                <div class="section-title-akun">
                                    <i class="fas fa-id-card"></i> Identitas Admin
                                </div>
                                <div class="row g-3">

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Nama Lengkap</label>
                                        <input type="text" name="nama" class="form-control form-control-akun" value="{{ old('nama', $user->nama) }}" placeholder="Masukkan nama lengkap">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">E-mail</label>
                                        <input type="email" name="email" class="form-control form-control-akun" value="{{ old('email', $user->email) }}" placeholder="admin@example.com">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Nomor WhatsApp</label>
                                        <input type="text" name="no_hp" class="form-control form-control-akun" value="{{ old('no_hp', $user->no_hp) }}" placeholder="08xxxxxxxxx">
                                    </div>


                                    <div class="col-12">
                                        <label class="form-label fw-bold">Alamat Lengkap</label>
                                        <textarea name="alamat" class="form-control form-control-akun" rows="2" placeholder="Masukkan alamat lengkap">{{ old('alamat', $user->alamat) }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-bold">Bio / Tentang Admin</label>
                                        <textarea name="bio" class="form-control form-control-akun" rows="3" placeholder="Ceritakan sedikit tentang Anda...">{{ old('bio', $user->bio) }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4 opacity-50">

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-save-akun">
                                    <i class="fas fa-save me-2"></i> Perbarui Profil
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tab Keamanan -->
            <div class="tab-pane fade" id="password">
                <div class="card card-profile border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="section-title-akun mb-4">
                            <i class="fas fa-shield-alt"></i> Ganti Kata Sandi
                        </div>
                        <form action="{{ route('admin.akun.password') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold">Kata Sandi Saat Ini</label>
                                <input type="password" name="current_password" class="form-control form-control-akun" placeholder="Konfirmasi kata sandi lama">
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Kata Sandi Baru</label>
                                    <input type="password" name="new_password" class="form-control form-control-akun" placeholder="Minimal 6 karakter">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Konfirmasi Kata Sandi Baru</label>
                                    <input type="password" name="new_password_confirmation" class="form-control form-control-akun" placeholder="Ulangi kata sandi baru">
                                </div>
                            </div>

                            <div class="alert alert-warning mt-4 border-0 rounded-3 py-2 px-3 small">
                                <i class="fas fa-exclamation-triangle me-1"></i> Setelah mengganti kata sandi, Anda mungkin perlu masuk kembali pada sesi berikutnya.
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-save-akun bg-danger">
                                    <i class="fas fa-key me-2"></i> Ganti Kata Sandi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewFoto').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
