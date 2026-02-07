@extends('admin-master')

@section('judul', 'Pengelolaan Galeri')

@push('styles')
<style>
    :root {
        --primary-blue: #1a73e8;
        --secondary-blue: #4285f4;
        --dark-blue: #1557b0;
        --success-green: #28a745;
        --warning-yellow: #ffc107;
        --danger-red: #dc3545;
        --info-cyan: #17a2b8;
        --light-gray: #f8f9fa;
        --medium-gray: #e9ecef;
        --dark-gray: #6c757d;
        --white: #ffffff;
        --shadow: 0 4px 20px rgba(26, 115, 232, 0.1);
        --shadow-hover: 0 8px 30px rgba(26, 115, 232, 0.15);
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Hero Section - Matching page-hero theme */
    .hero-gallery {
        background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
        color: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        margin-bottom: 2rem;
        box-shadow: 0 15px 35px rgba(15, 12, 41, 0.2);
        position: relative;
        overflow: hidden;
    }

    .hero-gallery h1 {
        font-weight: 800;
        font-size: 1.5rem;
        margin-bottom: 0.25rem;
    }

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: var(--white);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        box-shadow: var(--shadow);
        transition: var(--transition);
        border-left: 5px solid;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-hover);
    }

    .stat-card.albums { border-left-color: var(--primary-blue); }
    .stat-card.photos { border-left-color: var(--success-green); }
    .stat-card.videos { border-left-color: var(--warning-yellow); }

    .stat-card .icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }

    .stat-card.albums .icon { background: rgba(26, 115, 232, 0.1); color: var(--primary-blue); }
    .stat-card.photos .icon { background: rgba(40, 167, 69, 0.1); color: var(--success-green); }
    .stat-card.videos .icon { background: rgba(255, 193, 7, 0.1); color: var(--warning-yellow); }

    .stat-card .number { font-size: 2rem; font-weight: 700; margin-bottom: 0.25rem; }
    .stat-card .label { font-size: 0.875rem; color: var(--dark-gray); font-weight: 500; }

    /* Album Card */
    .album-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    .album-card {
        background: var(--white);
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--shadow);
        transition: var(--transition);
        position: relative;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .album-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-hover);
    }

    .album-cover {
        height: 180px;
        background-color: var(--medium-gray);
        position: relative;
        overflow: hidden;
    }

    .album-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }

    .album-card:hover .album-cover img {
        transform: scale(1.1);
    }

    .album-cover .no-cover {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: var(--dark-gray);
        font-size: 3rem;
        background: linear-gradient(45deg, #f3f4f6, #e5e7eb);
    }

    .album-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.3);
        opacity: 0;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .album-card:hover .album-overlay {
        opacity: 1;
    }

    .album-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(255,255,255,0.9);
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--primary-blue);
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .album-body {
        padding: 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .album-title {
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
        color: #333;
    }

    .album-info {
        color: var(--dark-gray);
        font-size: 0.875rem;
        margin-bottom: 1rem;
        flex: 1;
    }

    .album-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
        padding-top: 1rem;
        border-top: 1px solid var(--medium-gray);
        color: var(--dark-gray);
        font-size: 0.8rem;
    }

    /* Modal Styling - Consistent with Event Page */
    .modal-content {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    }

    .modal-header {
        background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
        color: var(--white);
        border-radius: var(--border-radius) var(--border-radius) 0 0;
        border: none;
        padding: 1.5rem;
    }

    .modal-header .btn-close { filter: brightness(0) invert(1); }

    .form-control, .form-select, textarea {
        border: 2px solid var(--medium-gray);
        border-radius: 10px;
        transition: var(--transition);
        min-height: 50px;
        padding: 0.85rem 1.2rem;
        font-size: 1rem;
    }
    
    .form-select {
        padding-right: 2.5rem;
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 1.2rem center;
    }

    textarea { min-height: 120px; }

    .form-control:focus, .form-select:focus, textarea:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 0.25rem rgba(26, 115, 232, 0.15);
    }

    /* Floating Action Button for Mobile */
    .fab {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: var(--primary-blue);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        box-shadow: 0 4px 15px rgba(26, 115, 232, 0.4);
        border: none;
        z-index: 1000;
        transition: var(--transition);
    }
    
    .fab:hover { transform: scale(1.1) rotate(90deg); }
</style>
@endpush

@section('isi')
<!-- Hero Section -->
<section class="hero-gallery">
    <div class="container">
        <h1><i class="fas fa-images me-2"></i>Pengelolaan Galeri</h1>
        <p>Kelola album, foto, dan video dokumentasi kegiatan alumni</p>
    </div>
</section>

<!-- Success/Error Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Statistics Cards -->
<div class="stats-grid">
    <div class="stat-card albums">
        <div class="icon"><i class="fas fa-folder"></i></div>
        <div class="number">{{ $stats['total_album'] }}</div>
        <div class="label">Total Album</div>
    </div>
    <div class="stat-card photos">
        <div class="icon"><i class="fas fa-image"></i></div>
        <div class="number">{{ $stats['total_photo'] }}</div>
        <div class="label">Total Foto</div>
    </div>
    <div class="stat-card videos">
        <div class="icon"><i class="fas fa-video"></i></div>
        <div class="number">{{ $stats['total_video'] }}</div>
        <div class="label">Total Video</div>
    </div>
</div>

<!-- Action Bar -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold text-secondary">Daftar Album</h4>
    <button class="btn btn-primary px-4 py-2 rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#createAlbumModal">
        <i class="fas fa-plus me-2"></i>Buat Album Baru
    </button>
</div>

<!-- Album Grid -->
<div class="album-grid">
    @forelse($albums as $album)
    <div class="album-card">
        <div class="album-cover">
            @if($album->cover)
                @php
                    $coverUrl = str_starts_with($album->cover, 'storage/') 
                        ? asset($album->cover) 
                        : asset('storage/' . $album->cover);
                @endphp
                <img src="{{ $coverUrl }}" alt="{{ $album->nama_album }}">
            @else
                <div class="no-cover"><i class="fas fa-image"></i></div>
            @endif
            <div class="album-badge">{{ $album->tahun }}</div>
            <div class="album-overlay">
                <a href="{{ route('admin.galeri.show', $album->id) }}" class="btn btn-light btn-sm rounded-pill px-4 mx-1">
                    <i class="fas fa-eye me-1"></i> Lihat
                </a>
            </div>
        </div>
        <div class="album-body">
            <h5 class="album-title text-truncate" title="{{ $album->nama_album }}">{{ $album->nama_album }}</h5>
            <p class="album-info text-truncate-2 mb-1">{{ $album->deskripsi ?? 'Tidak ada deskripsi' }}</p>
            <small class="text-muted d-block mb-3">Oleh: <strong>{{ $album->creator->nama ?? 'Alumni' }}</strong></small>

            <div class="d-flex flex-column gap-2 mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="small text-muted">Status Admin:</span>
                    <span class="badge {{ $album->status_admin == 'approved' ? 'bg-success' : ($album->status_admin == 'rejected' ? 'bg-danger' : 'bg-warning text-dark') }}" style="font-size: 0.65rem;">
                        {{ strtoupper($album->status_admin) }}
                    </span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="small text-muted">Status Pimpinan:</span>
                    <span class="badge {{ $album->status_pimpinan == 'approved' ? 'bg-success' : ($album->status_pimpinan == 'rejected' ? 'bg-danger' : 'bg-warning text-dark') }}" style="font-size: 0.65rem;">
                        {{ strtoupper($album->status_pimpinan) }}
                    </span>
                </div>
            </div>

            @if($album->status_admin == 'pending')
            <div class="d-flex gap-2 mb-3">
                <form action="{{ route('admin.galeri.approve', $album->id) }}" method="POST" class="flex-grow-1">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm w-100">Setujui</button>
                </form>
                <form action="{{ route('admin.galeri.reject', $album->id) }}" method="POST" class="flex-grow-1">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm w-100">Tolak</button>
                </form>
            </div>
            @endif
            
            <div class="d-flex gap-2">
                <button onclick="editAlbum({{ $album->id }}, '{{ $album->nama_album }}', {{ $album->tahun }}, '{{ $album->kategori }}', `{{ $album->deskripsi }}`)" 
                        class="btn btn-outline-warning btn-sm flex-grow-1">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button onclick="confirmDelete({{ $album->id }}, '{{ $album->nama_album }}')" 
                        class="btn btn-outline-danger btn-sm flex-grow-1">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </div>
            
            <div class="album-meta">
                <span><i class="fas fa-camera me-1"></i> {{ $album->total_photos }} Foto</span>
                <span><i class="fas fa-video me-1"></i> {{ $album->total_videos }} Video</span>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 py-5 text-center">
        <div class="text-muted">
            <i class="fas fa-folder-open fa-4x mb-3 opacity-25"></i>
            <p class="lead">Belum ada album yang dibuat</p>
            <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#createAlbumModal">
                Buat Album Pertama
            </button>
        </div>
    </div>
    @endforelse
</div>

<!-- Create Album Modal -->
<div class="modal fade" id="createAlbumModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i>Buat Album Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-bold">Nama Album <span class="text-danger">*</span></label>
                            <input type="text" name="nama_album" class="form-control" required placeholder="Contoh: Reuni Akbar 2024">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Tahun <span class="text-danger">*</span></label>
                            <input type="number" name="tahun" class="form-control" required value="{{ date('Y') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                            <select name="kategori" class="form-select" required>
                                <option value="Kegiatan">Kegiatan</option>
                                <option value="Reuni">Reuni</option>
                                <option value="Fasilitas">Fasilitas</option>
                                <option value="Dokumentasi">Dokumentasi</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Deskripsi singkat album..."></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Cover Album</label>
                            <input type="file" name="cover" class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Album</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Album Modal -->
<div class="modal fade" id="editAlbumModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Album</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editAlbumForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-bold">Nama Album <span class="text-danger">*</span></label>
                            <input type="text" name="nama_album" id="edit_nama" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Tahun <span class="text-danger">*</span></label>
                            <input type="number" name="tahun" id="edit_tahun" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                            <select name="kategori" id="edit_kategori" class="form-select" required>
                                <option value="Kegiatan">Kegiatan</option>
                                <option value="Reuni">Reuni</option>
                                <option value="Fasilitas">Fasilitas</option>
                                <option value="Dokumentasi">Dokumentasi</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Deskripsi</label>
                            <textarea name="deskripsi" id="edit_deskripsi" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Ganti Cover (Opsional)</label>
                            <input type="file" name="cover" class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update Album</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteAlbumModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter: brightness(0) invert(1);"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus album ini?</p>
                <h6 class="fw-bold" id="deleteAlbumTitle"></h6>
                <div class="alert alert-warning mt-3 mb-0">
                    <i class="fas fa-exclamation-circle me-1"></i> Semua foto dan video di dalam album ini akan ikut terhapus!
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteAlbumForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus Permanen</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function editAlbum(id, nama, tahun, kategori, deskripsi) {
        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_tahun').value = tahun;
        document.getElementById('edit_kategori').value = kategori;
        document.getElementById('edit_deskripsi').value = deskripsi ? deskripsi : '';
        
        document.getElementById('editAlbumForm').action = `/admin/galeri/${id}`;
        
        const modal = new bootstrap.Modal(document.getElementById('editAlbumModal'));
        modal.show();
    }

    function confirmDelete(id, nama) {
        document.getElementById('deleteAlbumTitle').textContent = nama;
        document.getElementById('deleteAlbumForm').action = `/admin/galeri/${id}`;
        
        const modal = new bootstrap.Modal(document.getElementById('deleteAlbumModal'));
        modal.show();
    }
</script>
@endpush
