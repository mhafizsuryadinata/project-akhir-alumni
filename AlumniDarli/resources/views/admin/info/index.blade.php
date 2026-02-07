@extends('admin-master')

@section('judul', 'Manajemen Info Pondok')

@section('isi')
<div class="row g-4">
    <!-- Hero Header -->
    <div class="col-12 animate-box" style="animation-delay: 0.1s">
        <div class="card overflow-hidden border-0 page-hero">
            <div class="card-body p-4 position-relative">
                <div class="row align-items-center position-relative z-index-1">
                    <div class="col-md-8 text-white">
                        <h3 class="fw-800 mb-1"><iconify-icon icon="solar:documents-bold-duotone" class="me-2"></iconify-icon> Info Pondok</h3>
                        <p class="mb-0 opacity-75 small">Kelola berita, pengumuman, dan update kegiatan pesantren</p>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    </div>
                </div>
                <div class="position-absolute floating-icon" style="right: -30px; bottom: -30px; opacity: 0.1;">
                    <iconify-icon icon="solar:documents-bold-duotone" style="font-size: 150px; color: white;"></iconify-icon>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 animate-box" style="animation-delay: 0.2s">
        <!-- Tambah Info Form (Collapsed) -->
        <div class="collapse mb-4" id="tambahInfoForm">
            <div class="card shadow-sm border-0 glass-card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 text-white"><iconify-icon icon="solar:add-circle-bold-duotone" class="me-2"></iconify-icon>Buat Info Pondok Baru</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.info.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label fw-bold">Judul Informasi</label>
                                <input type="text" name="judul" class="form-control" placeholder="Tuliskan judul informasi yang menarik..." required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Jenis Informasi</label>
                                <select class="form-select" name="jenis" required>
                                    <option value="">Pilih Jenis...</option>
                                    <option value="Pengumuman">Pengumuman</option>
                                    <option value="Kegiatan">Kegiatan</option>
                                    <option value="Pengembangan">Pengembangan</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Isi Konten</label>
                                <textarea name="konten" class="form-control" rows="4" placeholder="Jelaskan detail informasinya..." required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Unggah Gambar (Opsional)</label>
                                <input type="file" name="gambar" class="form-control">
                                <div class="form-text small text-muted">Format: JPG, PNG, JPEG. Max size: 2MB</div>
                            </div>
                        </div>
                        <div class="mt-4 text-end">
                            <button type="button" class="btn btn-secondary me-2" data-bs-toggle="collapse" data-bs-target="#tambahInfoForm">Batal</button>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-1"></i> Publikasikan Info
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
                <div>
                    <h4 class="card-title mb-0 fw-bold text-dark">Daftar Info Pondok</h4>
                    <p class="text-muted small mb-0">Kelola berita, pengumuman, dan update kegiatan pesantren</p>
                </div>
                <button class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#tambahInfoForm">
                    <i class="fas fa-plus me-1"></i> Tambah Info
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
                    <table class="table table-hover align-middle" id="infoTable">
                        <thead class="bg-light">
                            <tr>
                                <th width="50">NO</th>
                                <th>Informasi</th>
                                <th>Jenis</th>
                                <th>Konten Singkat</th>
                                <th>Tanggal Posting</th>
                                <th width="150" class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($info_pondok as $info)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($info->gambar)
                                            <img src="{{ asset('storage/' . $info->gambar) }}" alt="img" width="45" height="45" class="rounded me-3 border" style="object-fit: cover;">
                                        @else
                                            <div class="rounded bg-light d-flex align-items-center justify-content-center border" style="width: 45px; height: 45px;">
                                                <i class="fas fa-newspaper text-muted"></i>
                                            </div>
                                        @endif
                                        <div class="text-truncate" style="max-width: 250px;">
                                            <span class="fw-bold d-block text-dark">{{ $info->judul }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($info->jenis == 'Pengumuman')
                                        <span class="badge bg-danger px-2 py-1">Pengumuman</span>
                                    @elseif($info->jenis == 'Kegiatan')
                                        <span class="badge bg-success px-2 py-1">Kegiatan</span>
                                    @else
                                        <span class="badge bg-info px-2 py-1">Pengembangan</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted d-block text-truncate" style="max-width: 300px;">
                                        {{ strip_tags($info->konten) }}
                                    </small>
                                </td>
                                <td>
                                    <small class="text-dark fw-medium"><i class="far fa-calendar-alt me-1 opacity-50"></i>{{ $info->created_at->format('d M Y') }}</small>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('admin.info.edit', $info->id) }}" class="btn btn-warning btn-sm text-dark" title="Edit Data">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.info.destroy', $info->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus informasi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus Data">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="fas fa-info-circle fa-3x text-muted opacity-25 mb-3"></i>
                                    <p class="text-muted">Belum ada informasi pondok yang tersedia.</p>
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
    #infoTable thead th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #555;
        border-top: none;
        padding: 15px;
    }
    #infoTable tbody td {
        border-color: #f1f1f1;
        padding: 15px;
    }
    
    /* Sticky header for scrollable table */
    #infoTable thead th {
        position: sticky;
        top: 0;
        z-index: 10;
        background-color: #f8f9fa;
    }
</style>
@endsection
