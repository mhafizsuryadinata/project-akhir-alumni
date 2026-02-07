@extends('mudir-master')

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

    /* Hero Section */
    .hero-gallery {
        background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
        color: var(--white);
        padding: 2.5rem 0;
        border-radius: var(--border-radius);
        margin-bottom: 2rem;
        text-align: center;
        box-shadow: var(--shadow);
    }

    .hero-gallery h1 {
        font-weight: 700;
        font-size: 2.2rem;
        margin-bottom: 0.5rem;
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

    .status-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    .album-card:hover .album-overlay {
        opacity: 1 !important;
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

    /* Modal Styling */
    .modal-content {
        border: none;
        border-radius: var(--border-radius);
    }

    .modal-header {
        background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
        color: var(--white);
        border-radius: var(--border-radius) var(--border-radius) 0 0;
    }

    .form-control, .form-select, textarea {
        border-radius: 10px;
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-header text-white mb-4 shadow-sm" style="border-radius: 16px; overflow: hidden;">
    <div class="p-4" style="background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));">
        <div class="row align-items-center text-start">
            <div class="col-md-8">
                <h1 class="fw-800 mb-2 text-white"><i class="fas fa-images me-2"></i>Pengelolaan Galeri</h1>
                <p class="mb-0 opacity-80">Kelola album, foto, dan video serta moderasi konten dari alumni</p>
            </div>
            <div class="col-md-4 text-md-end d-none d-md-block">
                <iconify-icon icon="solar:gallery-bold-duotone" class="text-white opacity-20" style="font-size: 5rem;"></iconify-icon>
            </div>
        </div>
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
            
            <!-- Status Badge -->
            @if($album->status_pimpinan == 'pending')
                <span class="status-badge bg-warning text-dark">Menunggu Persetujuan</span>
            @elseif($album->status_pimpinan == 'approved')
                <span class="status-badge bg-success text-white">Disetujui</span>
            @else
                <span class="status-badge bg-danger text-white">Ditolak</span>
            @endif

            <div class="album-overlay d-flex align-items-center justify-content-center" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.3); opacity: 0; transition: all 0.3s ease;">
                <a href="{{ route('mudir.galeri.show', $album->id) }}" class="btn btn-light btn-sm rounded-pill px-4 mx-1">
                    <i class="fas fa-eye me-1"></i> Lihat
                </a>
            </div>
        </div>
        <div class="album-body">
            <h5 class="album-title text-truncate" title="{{ $album->nama_album }}">{{ $album->nama_album }}</h5>
            <p class="album-info text-truncate-2 mb-1">{{ $album->deskripsi ?? 'Tidak ada deskripsi' }}</p>
            <small class="text-muted d-block mb-3">Oleh: <strong>{{ $album->creator->nama ?? 'Alumni' }}</strong></small>
            
            <div class="d-flex flex-column gap-2">
                @if($album->status_pimpinan == 'pending')
                <div class="d-flex gap-2">
                    <form action="{{ route('mudir.galeri.approve', $album->id) }}" method="POST" class="flex-grow-1">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm w-100">Setujui</button>
                    </form>
                    <form action="{{ route('mudir.galeri.reject', $album->id) }}" method="POST" class="flex-grow-1">
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
        </div>
    </div>
    @endforelse
</div>

<!-- Create Album Modal -->
<div class="modal fade" id="createAlbumModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i>Buat Album Baru (Pimpinan)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('mudir.galeri.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-bold">Nama Album <span class="text-danger">*</span></label>
                            <input type="text" name="nama_album" class="form-control" required>
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
                            <textarea name="deskripsi" class="form-control" rows="3"></textarea>
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
        
        document.getElementById('editAlbumForm').action = `/mudir/galeri/${id}`;
        
        const modal = new bootstrap.Modal(document.getElementById('editAlbumModal'));
        modal.show();
    }

    function confirmDelete(id, nama) {
        document.getElementById('deleteAlbumTitle').textContent = nama;
        document.getElementById('deleteAlbumForm').action = `/mudir/galeri/${id}`;
        
        const modal = new bootstrap.Modal(document.getElementById('deleteAlbumModal'));
        modal.show();
    }
</script>
@endpush
