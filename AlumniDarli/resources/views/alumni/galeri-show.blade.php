@extends('alumni-master')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" integrity="sha512-M5LRNRZvG2U7VHGX6cV8Q4Bs1RNDua3N1oMQAlt4bFAqMyxSCFqQ822XYgV5X2sg+EB5eOo0qH8jE0dPD9ajQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    /* Custom lightbox styles */
    .lb-outerContainer {
        border-radius: 8px;
        background: transparent !important;
    }
    
    .lightbox .lb-image {
        border: 5px solid #fff;
        border-radius: 8px;
        max-width: 85vw !important;
        max-height: 85vh !important;
    }
    
    .lightbox .lb-nav a.lb-prev,
    .lightbox .lb-nav a.lb-next {
        opacity: 1 !important;
        width: 30% !important;
        height: 100% !important;
        cursor: pointer !important;
    }
    
    .lightbox .lb-nav a.lb-prev {
        left: 0 !important;
        background: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IiNmZmZmZmYiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIiBjbGFzcz0ibHVjaWRlIGx1Y2lkZS1hcnJvdy1sZWZ0Ij48cGF0aCBkPSJtMTIgMTktNy03IDctNzkiLz48cGF0aCBkPSJNMTkgMTJINSIvPjwvc3ZnPg==) no-repeat center center !important;
        background-size: 30px !important;
    }
    
    .lightbox .lb-nav a.lb-next {
        right: 0 !important;
        background: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IiNmZmZmZmYiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIiBjbGFzcz0ibHVjaWRlIGx1Y2lkZS1hcnJvdy1yaWdodCI+PHBhdGggZD0ibDUgMTIgMTQtNzdNMTkgMTJINU0xOSA1bC0xNCA3Ii8+PC9zdmc+) no-repeat center center !important;
        background-size: 30px !important;
    }
    
    .lightbox .lb-data .lb-close {
        background: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IiNmZmZmZmYiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIiBjbGFzcz0ibHVjaWRlIGx1Y2lkZS14Ij48bGluZSB4MT0iMThsLTYtNm0wIDZsLTYtNm02IDZsNi02bS02IDZsLTYgNiIvPjwvc3ZnPg==) no-repeat center center !important;
        background-size: 24px !important;
        opacity: 0.9 !important;
        width: 40px !important;
        height: 40px !important;
        top: 10px !important;
        right: 10px !important;
        cursor: pointer !important;
        z-index: 9999 !important;
    }
    
    .lightbox .lb-data .lb-close:hover {
        opacity: 1 !important;
        transform: scale(1.1);
    }
    
    .lightbox .lb-data .lb-close:hover {
        opacity: 1;
    }
    
    /* Video play icon */
    .video-play-icon {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: rgba(255, 255, 255, 0.9);
        font-size: 3rem;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        transition: all 0.3s ease;
        opacity: 0.9;
    }
    
    a:hover .video-play-icon {
        color: #fff;
        transform: translate(-50%, -50%) scale(1.1);
        opacity: 1;
    }
    
    /* Card hover effect */
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        overflow: hidden;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .lightbox .lb-container {
            padding: 0 15px;
        }
        
        .lightbox .lb-image {
            max-width: 100% !important;
            width: auto !important;
            height: auto !important;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox-plus-jquery.min.js" integrity="sha512-oa5vZK+YB9I8sD0qL6X1qo0wGji48U8o0QadHGyPkFmlU1A3oJ4Oe0A6z7Y5fg5l5FV1I1U1V1fFCD4wAYUqQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize lightbox with swipe support
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'showImageNumberLabel': true,
            'disableScrolling': true,
            'albumLabel': 'Gambar %1 dari %2',
            'fadeDuration': 200,
            'imageFadeDuration': 200,
            'alwaysShowNavOnTouchDevices': true
        });
        
        // Add keyboard navigation
        document.addEventListener('keydown', function(e) {
            const lightbox = document.querySelector('.lb-outerContainer');
            if (!lightbox) return;
            
            switch(e.key) {
                case 'ArrowLeft':
                    document.querySelector('.lb-prev').click();
                    break;
                case 'ArrowRight':
                    document.querySelector('.lb-next').click();
                    break;
                case 'Escape':
                    document.querySelector('.lb-close').click();
                    break;
            }
        });
    });
</script>
@endpush

@section('alumni')
<div class="container py-4">
    @if($album->status_admin != 'approved' || $album->status_pimpinan != 'approved')
        <div class="alert alert-warning border-0 shadow-sm mb-4 d-inline-block py-2 px-3">
            <div class="d-flex align-items-center">
                <i class="fas fa-info-circle me-2 text-warning"></i>
                <div class="small">
                    <span class="fw-bold">Status Album:</span>
                    @if($album->status_admin == 'rejected' || $album->status_pimpinan == 'rejected')
                        <span class="text-danger fw-bold">DITOLAK</span>
                    @elseif($album->status_admin == 'approved')
                        <span class="text-info fw-bold">MENUNGGU PIMPINAN</span>
                    @else
                        <span class="text-dark fw-bold">MENUNGGU ADMIN</span>
                    @endif
                </div>
            </div>
        </div>
    @endif
    <h2 class="mb-3">{{ $album->nama_album }}</h2>
    <p class="text-muted">{{ $album->deskripsi }}</p>

    <div class="mt-4 d-flex flex-wrap gap-2">
        <a href="{{ route('galeri.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Galeri
        </a>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModalShow">
            <i class="fas fa-plus me-1"></i> Tambah Foto/Video
        </button>
        <button class="btn btn-success" onclick="shareAlbum()">
            <i class="fas fa-share-alt me-1"></i> Bagikan Album
        </button>
    </div>

    <div class="row g-4 mt-4">
        @foreach ($album->galeri as $item)
            <div class="col-md-4">
                <div class="card shadow-sm position-relative">
                    @php
                        $fileUrl = str_starts_with($item->file_path, 'storage/') 
                            ? asset($item->file_path) 
                            : asset('storage/' . $item->file_path);
                    @endphp

                    @if(in_array($item->tipe, ['foto', 'photo']))
                        <a href="{{ $fileUrl }}" 
                           data-lightbox="gallery-{{ $album->id }}" 
                           data-title="{{ $item->deskripsi ?? 'Foto Galeri' }}"
                           data-alt="{{ $item->deskripsi ?? 'Foto Galeri' }}">
                            <img src="{{ $fileUrl }}" 
                                 class="card-img-top" 
                                 alt="{{ $item->deskriksi ?? 'Foto Galeri' }}" 
                                 style="height: 200px; object-fit: cover; cursor: pointer;">
                        </a>
                    @else
                        <a href="{{ $fileUrl }}" 
                           data-lightbox="gallery-{{ $album->id }}" 
                           data-title="{{ $item->deskripsi ?? 'Video Galeri' }}"
                           data-alt="{{ $item->deskripsi ?? 'Video Galeri' }}">
                            <video style="width:100%; height:200px; object-fit:cover;" preload="metadata">
                                <source src="{{ $fileUrl }}" 
                                        type="{{ 
                                            pathinfo($item->file_path, PATHINFO_EXTENSION) === 'mp4' ? 'video/mp4' : 
                                            (pathinfo($item->file_path, PATHINFO_EXTENSION) === 'mov' ? 'video/quicktime' : 
                                            'video/' . pathinfo($item->file_path, PATHINFO_EXTENSION)) 
                                        }}">
                                Browser kamu tidak mendukung video.
                            </video>
                            <div class="video-play-icon">
                                <i class="fas fa-play-circle"></i>
                            </div>
                        </a>
                    @endif

                    @if($item->uploaded_by == (auth()->check() ? auth()->user()->id_user : 0) && ($item->status_admin != 'approved' || $item->status_pimpinan != 'approved'))
                        <div class="position-absolute top-0 start-0 m-2" style="z-index: 10;">
                            <span class="badge {{ $item->status_admin == 'approved' ? 'bg-info' : ($item->status_admin == 'rejected' || $item->status_pimpinan == 'rejected' ? 'bg-danger' : 'bg-warning text-dark') }}" style="font-size: 0.65rem; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                                <i class="fas fa-clock me-1"></i>
                                @if($item->status_admin == 'rejected' || $item->status_pimpinan == 'rejected')
                                    DITOLAK
                                @elseif($item->status_admin == 'approved')
                                    MENUNGGU PIMPINAN
                                @else
                                    MENUNGGU ADMIN
                                @endif
                            </span>
                        </div>
                    @endif

                    <div class="card-body">
                        <p class="card-text small">{{ $item->deskripsi ?? '-' }}</p>
                        <div class="d-flex gap-2 mb-2">
                            <a href="{{ $fileUrl }}" download class="btn btn-outline-primary btn-sm flex-fill">
                                <i class="fas fa-download me-1"></i> Download
                            </a>
                            <button onclick="shareItem('{{ $fileUrl }}', '{{ $item->deskripsi }}')" class="btn btn-outline-success btn-sm flex-fill">
                                <i class="fas fa-share me-1"></i> Bagikan
                            </button>
                        </div>
                        @if($item->uploaded_by == (auth()->check() ? auth()->user()->id_user : 0))
                            <form action="{{ route('galeri.delete', $item->id) }}" method="POST" onsubmit="return confirm('Hapus file ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm w-100">
                                    <i class="fas fa-trash-alt me-1"></i> Hapus
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Modal Upload Foto/Video -->
<div class="modal fade" id="uploadModalShow" tabindex="-1" aria-labelledby="uploadModalShowLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('galeri.upload') }}" method="POST" enctype="multipart/form-data" class="modal-content">
        @csrf
        <input type="hidden" name="album_id" value="{{ $album->id }}">
        <div class="modal-header">
            <h5 class="modal-title" id="uploadModalShowLabel">Tambah Foto/Video ke Album</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label for="file" class="form-label">File Foto/Video</label>
                <input type="file" name="file" id="file" class="form-control" accept="image/*,video/*" required>
                <small class="text-muted">Max: 10MB untuk foto, 50MB untuk video</small>
            </div>
            <div class="mb-3">
                <label for="tipe" class="form-label">Tipe File</label>
                <select name="tipe" id="tipe" class="form-select" required>
                    <option value="foto">Foto</option>
                    <option value="video">Video</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" placeholder="Tambahkan deskripsi untuk foto/video ini..."></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-upload me-1"></i> Upload
            </button>
        </div>
    </form>
  </div>
</div>

<script>
// Fungsi untuk membagikan album
function shareAlbum() {
    const albumTitle = "{{ $album->nama_album }}";
    const albumUrl = window.location.href;
    
    // Cek apakah browser mendukung Web Share API
    if (navigator.share) {
        navigator.share({
            title: albumTitle,
            text: "Lihat album: " + albumTitle,
            url: albumUrl
        })
        .then(() => console.log('Berhasil dibagikan'))
        .catch((error) => console.log('Error sharing:', error));
    } else {
        // Fallback: Copy link ke clipboard
        navigator.clipboard.writeText(albumUrl).then(() => {
            alert('Link album berhasil disalin ke clipboard!\n\n' + albumUrl);
        }).catch(() => {
            // Fallback manual jika clipboard API tidak tersedia
            prompt('Copy link album ini:', albumUrl);
        });
    }
}

// Fungsi untuk membagikan item individual
function shareItem(fileUrl, description) {
    const fullUrl = fileUrl;
    const text = description ? description : 'Lihat foto/video ini';
    
    if (navigator.share) {
        navigator.share({
            title: 'Galeri Alumni',
            text: text,
            url: fullUrl
        })
        .then(() => console.log('Berhasil dibagikan'))
        .catch((error) => console.log('Error sharing:', error));
    } else {
        // Fallback: Copy link ke clipboard
        navigator.clipboard.writeText(fullUrl).then(() => {
            alert('Link berhasil disalin ke clipboard!\n\n' + fullUrl);
        }).catch(() => {
            prompt('Copy link ini:', fullUrl);
        });
    }
}
</script>
@endsection
