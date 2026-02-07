@extends('admin-master')

@section('judul', 'Data Kontak Ustadz')

@section('isi')
<div class="row g-4">
    <!-- Hero Header -->
    <div class="col-12 animate-box" style="animation-delay: 0.1s">
        <div class="card overflow-hidden border-0 page-hero">
            <div class="card-body p-4 position-relative">
                <div class="row align-items-center position-relative z-index-1">
                    <div class="col-md-8 text-white">
                        <h3 class="fw-800 mb-1"><iconify-icon icon="solar:user-id-bold-duotone" class="me-2"></iconify-icon> Kontak Ustadz</h3>
                        <p class="mb-0 opacity-75 small">Tim dukungan dan bimbingan untuk alumni</p>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    </div>
                </div>
                <div class="position-absolute floating-icon" style="right: -30px; bottom: -30px; opacity: 0.1;">
                    <iconify-icon icon="solar:user-id-bold-duotone" style="font-size: 150px; color: white;"></iconify-icon>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 animate-box" style="animation-delay: 0.2s">
        <!-- Tambah Kontak Form (Collapsed) -->
        <div class="collapse mb-4" id="tambahKontakForm">
            <div class="card shadow-sm border-0 glass-card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 text-white"><iconify-icon icon="solar:user-plus-bold-duotone" class="me-2"></iconify-icon>Tambah Kontak Ustadz Baru</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.kontak.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold"><i class="fas fa-user me-1 text-primary"></i>Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" placeholder="Nama lengkap beserta gelar..." required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold"><i class="fas fa-id-badge me-1 text-primary"></i>Jabatan</label>
                                <input type="text" name="jabatan" class="form-control" placeholder="Contoh: Mudir, Ustadz..." required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold"><i class="fas fa-briefcase me-1 text-primary"></i>Bidang (Opsional)</label>
                                <input type="text" name="bidang" class="form-control" placeholder="Contoh: Kurikulum, Kesantrian...">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold"><i class="fab fa-whatsapp me-1 text-success"></i>Nomor WhatsApp</label>
                                <input type="text" name="no_hp" class="form-control" placeholder="628123456789" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold"><i class="fas fa-envelope me-1 text-danger"></i>Email (Opsional)</label>
                                <input type="email" name="email" class="form-control" placeholder="ustadz@example.com">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold"><i class="fas fa-image me-1 text-info"></i>Foto Profil (Opsional)</label>
                                <input type="file" name="foto" class="form-control">
                            </div>
                        </div>
                        <div class="mt-4 text-end">
                            <button type="button" class="btn btn-secondary me-2" data-bs-toggle="collapse" data-bs-target="#tambahKontakForm">Batal</button>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-1"></i> Simpan Kontak
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
                <div>
                    <h4 class="card-title mb-0 fw-bold text-dark">Daftar Kontak Ustadz</h4>
                    <p class="text-muted small mb-0">Tim dukungan dan bimbingan untuk alumni</p>
                </div>
                <button class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#tambahKontakForm">
                    <i class="fas fa-plus me-1"></i> Tambah Data
                </button>
            </div>
            <div class="card-body">
                @if(session('pesan'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-1"></i> {{ session('pesan') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                    <table class="table table-hover align-middle" id="kontakTable">
                        <thead class="bg-light">
                            <tr>
                                <th width="50" class="text-center">NO</th>
                                <th><i class="fas fa-user me-1"></i>PROFIL</th>
                                <th><i class="fas fa-id-badge me-1"></i>JABATAN & BIDANG</th>
                                <th><i class="fas fa-address-book me-1"></i>KONTAK</th>
                                <th width="150" class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ustadzs as $no => $ustadz)
                            <tr>
                                <td class="text-center">{{ $no + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            @if($ustadz->foto)
                                                <img src="{{ asset('storage/' . $ustadz->foto) }}" alt="Foto" width="50" height="50" class="rounded-circle border border-primary border-2" style="object-fit: cover;">
                                            @else
                                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center border" style="width: 50px; height: 50px;">
                                                    <i class="fas fa-user-tie text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold text-dark">{{ $ustadz->nama }}</h6>
                                            <small class="text-muted">Pondok Pesantren Dar El-ilmi</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary px-2 py-1 mb-1">{{ $ustadz->jabatan }}</span><br>
                                    <small class="text-muted"><i class="fas fa-briefcase me-1 opacity-50"></i>{{ $ustadz->bidang ?? '-' }}</small>
                                </td>
                                <td>
                                    <div class="mb-1">
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $ustadz->no_hp) }}" target="_blank" class="text-success text-decoration-none small fw-medium">
                                            <i class="fab fa-whatsapp me-1"></i> {{ $ustadz->no_hp }}
                                        </a>
                                    </div>
                                    <div>
                                        <i class="fas fa-envelope text-muted me-1 small opacity-50"></i>
                                        <small class="text-muted">{{ $ustadz->email ?? '-' }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('admin.kontak.edit', $ustadz->id) }}" class="btn btn-warning btn-sm text-dark" title="Edit Data">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.kontak.destroy', $ustadz->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" title="Hapus Data">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <i class="fas fa-user-tie fa-3x text-muted opacity-25 mb-3"></i>
                                    <p class="text-muted">Belum ada data kontak ustadz.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    #kontakTable thead th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #555;
        border-top: none;
        padding: 15px;
    }
    #kontakTable tbody td {
        border-color: #f1f1f1;
        padding: 15px;
    }
    
    /* Sticky header for scrollable table */
    #kontakTable thead th {
        position: sticky;
        top: 0;
        z-index: 10;
        background-color: #f8f9fa;
    }
</style>
@endsection
