@extends('mudir-master')

@section('content')
<div class="row g-4">
    <!-- Back Button & Title -->
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius: 16px;">
            <div class="card-body p-4" style="background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%); border-radius: 16px;">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center text-white">
                        <a href="{{ route('mudir.alumni.index') }}" class="btn btn-light btn-sm me-3 rounded-pill px-3" style="border-radius: 12px;">
                            <iconify-icon icon="solar:arrow-left-bold-duotone" class="fs-5"></iconify-icon>
                        </a>
                        <div>
                            <h4 class="fw-800 mb-0"><iconify-icon icon="solar:user-pen-bold-duotone" class="me-2"></iconify-icon>Edit Data Alumni</h4>
                            <small class="opacity-75">Perbarui informasi data alumni {{ $users->nama ?? $users->username }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius: 16px;">
            <div class="card-body p-4">
                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3 mb-4" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <form action="{{ route('mudir.alumni.update') }}" method="POST">
                    @csrf
                    
                    <input type="hidden" name="id_user" value="{{ $users->id_user }}">
                    
                    <!-- Identitas Dasar -->
                    <div class="section-header mb-3">
                        <h6 class="fw-700 text-primary mb-0"><iconify-icon icon="solar:user-id-bold-duotone" class="me-2"></iconify-icon>Identitas Dasar</h6>
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="nomor_nia" class="form-label fw-600">NIA <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nomor_nia" name="nomor_nia" value="{{ $users->nomor_nia }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="username" class="form-label fw-600">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="username" name="username" value="{{ $users->username }}" required>
                        </div>
                        <div class="col-md-12">
                            <label for="nama" class="form-label fw-600">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="{{ $users->nama }}">
                        </div>
                    </div>

                    <!-- Tahun Akademik -->
                    <div class="section-header mb-3">
                        <h6 class="fw-700 text-primary mb-0"><iconify-icon icon="solar:calendar-bold-duotone" class="me-2"></iconify-icon>Tahun Akademik</h6>
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="tahun_masuk" class="form-label fw-600">Tahun Masuk</label>
                            <input type="number" class="form-control" id="tahun_masuk" name="tahun_masuk" value="{{ $users->tahun_masuk }}">
                        </div>
                        <div class="col-md-6">
                            <label for="tahun_tamat" class="form-label fw-600">Tahun Tamat</label>
                            <input type="number" class="form-control" id="tahun_tamat" name="tahun_tamat" value="{{ $users->tahun_tamat }}">
                        </div>
                    </div>

                    <!-- Informasi Kontak -->
                    <div class="section-header mb-3">
                        <h6 class="fw-700 text-primary mb-0"><iconify-icon icon="solar:phone-bold-duotone" class="me-2"></iconify-icon>Informasi Kontak</h6>
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="no_hp" class="form-label fw-600">Nomor HP</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ $users->no_hp }}">
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-600">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $users->email }}">
                        </div>
                        <div class="col-12">
                            <label for="alamat" class="form-label fw-600">Alamat Lengkap</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3">{{ $users->alamat }}</textarea>
                        </div>
                    </div>

                    <!-- Pekerjaan & Lokasi -->
                    <div class="section-header mb-3">
                        <h6 class="fw-700 text-primary mb-0"><iconify-icon icon="solar:case-bold-duotone" class="me-2"></iconify-icon>Pekerjaan & Lokasi</h6>
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="pekerjaan" class="form-label fw-600">Pekerjaan</label>
                            <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" value="{{ $users->pekerjaan }}">
                        </div>
                        <div class="col-md-6">
                            <label for="lokasi" class="form-label fw-600">Lokasi Terkini</label>
                            <input type="text" class="form-control" id="lokasi" name="lokasi" value="{{ $users->lokasi }}">
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('mudir.alumni.index') }}" class="btn btn-light px-4 fw-600" style="border-radius: 12px;">
                            <iconify-icon icon="solar:arrow-left-bold-duotone" class="me-1"></iconify-icon> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary px-4 fw-600 shadow-sm" style="border-radius: 12px;">
                            <iconify-icon icon="solar:disk-bold-duotone" class="me-1"></iconify-icon> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .fw-800 { font-weight: 800; }
    .fw-700 { font-weight: 700; }
    .fw-600 { font-weight: 600; }
    
    .form-control {
        border-radius: 10px;
        border: 1px solid #e0e0e0;
        padding: 10px 15px;
        transition: all 0.2s;
    }
    
    .form-control:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 4px rgba(26, 115, 232, 0.1);
    }
    
    .form-label {
        color: #333;
        margin-bottom: 8px;
    }

    .section-header {
        padding-bottom: 8px;
        border-bottom: 2px solid rgba(26, 115, 232, 0.1);
    }
</style>
@endsection
