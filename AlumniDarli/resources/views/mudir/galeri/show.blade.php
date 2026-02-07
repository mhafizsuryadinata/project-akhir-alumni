@extends('mudir-master')

@section('judul', 'Detail Album')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
<style>
    :root {
        --primary-blue: #1a73e8;
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --white: #ffffff;
        --shadow: 0 4px 20px rgba(26, 115, 232, 0.1);
    }

    .album-header {
        background: var(--white);
        border-radius: var(--border-radius);
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow);
    }

    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
    }

    .gallery-item {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        aspect-ratio: 1;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        transition: var(--transition);
        background: #f8f9fa;
    }

    .gallery-media {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .item-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
        padding: 20px 15px 15px;
        opacity: 0;
        transition: var(--transition);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        gap: 8px;
    }

    .gallery-item:hover .item-overlay {
        opacity: 1;
    }

    .status-badge-media {
        position: absolute;
        top: 10px;
        left: 10px;
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 0.65rem;
        font-weight: 700;
        z-index: 5;
    }
</style>
@endpush

@section('content')
<div class="d-flex align-items-center mb-4">
    <a href="{{ route('mudir.galeri.index') }}" class="btn btn-outline-secondary me-3 rounded-circle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
        <iconify-icon icon="solar:arrow-left-bold"></iconify-icon>
    </a>
    <h3 class="mb-0 fw-bold">Detail Album</h3>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="album-header">
    <div class="row align-items-center">
        <div class="col-md-9">
            <div class="d-flex align-items-center mb-2">
                <span class="badge bg-primary me-2">{{ $album->kategori }}</span>
                <span class="badge bg-secondary">{{ $album->tahun }}</span>
            </div>
            <h2 class="fw-bold mb-2">{{ $album->nama_album }}</h2>
            <p class="text-muted mb-0">{{ $album->deskripsi ?? 'Tidak ada deskripsi' }}</p>
            <div class="mt-3 text-muted small">
                Oleh: <strong>{{ $album->creator->nama ?? 'Alumni' }}</strong> &bull;
                <i class="fas fa-image me-1"></i> {{ $stats['photos'] }} Foto &bull; 
                <i class="fas fa-video me-1"></i> {{ $stats['videos'] }} Video
            </div>
        </div>
        <div class="col-md-3 text-md-end mt-3 mt-md-0">
            <button class="btn btn-primary px-4 py-2 rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#uploadMediaModal">
                <i class="fas fa-cloud-upload-alt me-2"></i> Upload Media
            </button>
        </div>
    </div>
</div>

<div class="gallery-grid">
    @forelse($album->galeri as $media)
        <div class="gallery-item">
            @if($media->status_pimpinan == 'pending')
                <span class="status-badge-media bg-warning">PENDING</span>
            @elseif($media->status_pimpinan == 'approved')
                <span class="status-badge-media bg-success text-white">APPROVED</span>
            @else
                <span class="status-badge-media bg-danger text-white">REJECTED</span>
            @endif

            @php
                $fileUrl = str_starts_with($media->file_path, 'storage/') 
                    ? asset($media->file_path) 
                    : asset('storage/' . $media->file_path);
            @endphp

            @if(in_array($media->tipe, ['photo', 'foto']))
                <a href="{{ $fileUrl }}" data-fancybox="gallery" data-caption="{{ $media->deskripsi }}">
                    <img src="{{ $fileUrl }}" class="gallery-media" loading="lazy">
                </a>
            @else
                <a href="{{ $fileUrl }}" data-fancybox="gallery" data-caption="{{ $media->deskripsi }}">
                    <video class="gallery-media">
                        <source src="{{ $fileUrl }}#t=0.5" type="video/mp4">
                    </video>
                </a>
            @endif
            
            <div class="item-overlay">
                @if($media->status_pimpinan == 'pending')
                <div class="d-flex gap-1 mb-2">
                    <form action="{{ route('mudir.galeri.media.approve', $media->id) }}" method="POST" class="flex-grow-1">
                        @csrf
                        <button type="submit" class="btn btn-success btn-xs w-100 py-1" style="font-size: 0.7rem;">Approve</button>
                    </form>
                    <form action="{{ route('mudir.galeri.media.reject', $media->id) }}" method="POST" class="flex-grow-1">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-xs w-100 py-1" style="font-size: 0.7rem;">Reject</button>
                    </form>
                </div>
                @endif
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-white-50" style="font-size: 0.65rem;">Oleh: {{ $media->uploader->nama ?? 'Alumni' }}</small>
                    <form action="{{ route('mudir.galeri.media.destroy', $media->id) }}" method="POST" onsubmit="return confirm('Hapus media ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link text-white p-0"><iconify-icon icon="solar:trash-bin-trash-bold"></iconify-icon></button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 py-5 text-center bg-white rounded-3 shadow-sm">
            <p class="text-muted">Belum ada media dalam album ini.</p>
        </div>
    @endforelse
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadMediaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Media (Pimpinan)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('mudir.galeri.upload', $album->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="file" name="file" class="form-control mb-3" required accept="image/*,video/*">
                    <textarea name="deskripsi" class="form-control" rows="2" placeholder="Deskripsi (Opsional)"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script>
    Fancybox.bind("[data-fancybox]", {});
</script>
@endpush
