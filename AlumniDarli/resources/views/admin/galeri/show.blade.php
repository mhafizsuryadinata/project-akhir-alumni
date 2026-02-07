@extends('admin-master')

@section('judul', 'Detail Album')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
<style>
    /* Reusing variables from index */
    :root {
        --primary-blue: #1a73e8;
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --white: #ffffff;
        --shadow: 0 4px 20px rgba(26, 115, 232, 0.1);
        --shadow-hover: 0 8px 30px rgba(26, 115, 232, 0.15);
    }

    .album-header {
        background: var(--white);
        border-radius: var(--border-radius);
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow);
        position: relative;
        overflow: hidden;
    }

    .album-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: linear-gradient(90deg, var(--primary-blue), #4285f4);
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
        cursor: pointer;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        transition: var(--transition);
        background: #f8f9fa;
    }

    .gallery-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    .gallery-media {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }

    .gallery-item:hover .gallery-media {
        transform: scale(1.1);
    }

    .video-icon {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 50px;
        height: 50px;
        background: rgba(0,0,0,0.6);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        pointer-events: none;
        z-index: 2;
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
        justify-content: flex-end;
        align-items: center;
    }

    .gallery-item:hover .item-overlay {
        opacity: 1;
    }

    /* Modal Styling */
    .form-control, .form-select, textarea {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        min-height: 50px;
        padding: 0.85rem 1.2rem;
    }
    textarea { min-height: 100px; }
    
    .btn-delete-media {
        background: rgba(220, 53, 69, 0.9);
        color: white;
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
    }

    .btn-delete-media:hover {
        background: #dc3545;
        transform: scale(1.1);
    }

    /* Upload Area */
    .upload-area {
        border: 2px dashed #a0aec0;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        background: #f8f9fa;
        cursor: pointer;
        transition: var(--transition);
    }
    
    .upload-area:hover {
        border-color: var(--primary-blue);
        background: #ebf8ff;
    }

    .status-badge-media {
        position: absolute;
        top: 10px;
        left: 10px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.65rem;
        font-weight: 700;
        z-index: 5;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }
</style>
@endpush

@section('isi')

<!-- Back and Title -->
<div class="d-flex align-items-center mb-4">
    <a href="{{ route('admin.galeri.index') }}" class="btn btn-outline-secondary me-3 rounded-circle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h3 class="mb-0 fw-bold">Detail Album</h3>
</div>

<!-- Success Message -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Album Info Header -->
<div class="album-header">
    <div class="row align-items-center">
        <div class="col-md-9">
            <div class="d-flex align-items-center mb-2">
                <span class="badge bg-primary me-2">{{ $album->kategori }}</span>
                <span class="badge bg-secondary">{{ $album->tahun }}</span>
            </div>
            <h2 class="fw-bold mb-2">{{ $album->nama_album }}</h2>
            <p class="text-muted mb-0" style="font-size: 1.1rem;">{{ $album->deskripsi ?? 'Tidak ada deskripsi' }}</p>
            <div class="mt-3 text-muted small">
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

<!-- Gallery Grid -->
@if($album->galeri->count() > 0)
    <div class="gallery-grid">
        @foreach($album->galeri as $media)
            <div class="gallery-item">
                <!-- Status Badge -->
                <span class="status-badge-media {{ $media->status_admin == 'approved' ? 'bg-success text-white' : ($media->status_admin == 'rejected' ? 'bg-danger text-white' : 'bg-warning text-dark') }}">
                    {{ strtoupper($media->status_admin) }}
                </span>

                @if(in_array($media->tipe, ['photo', 'foto']))
                    @php
                        $fileUrl = str_starts_with($media->file_path, 'storage/') 
                            ? asset($media->file_path) 
                            : asset('storage/' . $media->file_path);
                    @endphp
                    <a href="{{ $fileUrl }}" data-fancybox="gallery" data-caption="{{ $media->deskripsi }}">
                        <img src="{{ $fileUrl }}" class="gallery-media" loading="lazy">
                    </a>
                @else
                    @php
                        $fileUrl = str_starts_with($media->file_path, 'storage/') 
                            ? asset($media->file_path) 
                            : asset('storage/' . $media->file_path);
                    @endphp
                    <a href="{{ $fileUrl }}" data-fancybox="gallery" data-caption="{{ $media->deskripsi }}">
                        <video class="gallery-media">
                            <source src="{{ $fileUrl }}#t=0.5" type="video/mp4">
                        </video>
                        <div class="video-icon"><i class="fas fa-play"></i></div>
                    </a>
                @endif
                
                <div class="item-overlay d-flex flex-column gap-2">
                    @if($media->status_admin == 'pending')
                    <div class="d-flex gap-1 w-100">
                        <form action="{{ route('admin.galeri.media.approve', $media->id) }}" method="POST" class="flex-grow-1">
                            @csrf
                            <button type="submit" class="btn btn-success btn-xs w-100 py-1" style="font-size: 0.7rem;">Approve</button>
                        </form>
                        <form action="{{ route('admin.galeri.media.reject', $media->id) }}" method="POST" class="flex-grow-1">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-xs w-100 py-1" style="font-size: 0.7rem;">Reject</button>
                        </form>
                    </div>
                    @endif

                    <div class="d-flex gap-1 justify-content-end w-100">
                        <a href="{{ $fileUrl }}" download class="btn btn-primary btn-sm rounded-circle" style="width: 28px; height: 28px; display: flex; align-items: center; justify-content: center;" title="Download">
                             <i class="fas fa-download" style="font-size: 0.7rem;"></i>
                        </a>
                        <button onclick="shareItem('{{ $fileUrl }}', '{{ $media->deskripsi }}')" class="btn btn-success btn-sm rounded-circle" style="width: 28px; height: 28px; display: flex; align-items: center; justify-content: center;" title="Bagikan">
                            <i class="fas fa-share-alt" style="font-size: 0.7rem;"></i>
                        </button>
                        <form action="{{ route('admin.galeri.media.destroy', $media->id) }}" method="POST" onsubmit="return confirm('Hapus media ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete-media" style="width: 28px; height: 28px;" title="Hapus">
                                <i class="fas fa-trash-alt" style="font-size: 0.7rem;"></i>
                            </button>
                        </form>
                    </div>
                    <div class="text-white-50 text-end" style="font-size: 0.6rem;">
                        Oleh: {{ $media->uploader->nama ?? 'Alumni' }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="text-center py-5 bg-white rounded-3 shadow-sm">
        <i class="fas fa-images fa-4x text-muted opacity-25 mb-3"></i>
        <h4>Belum ada media</h4>
        <p class="text-muted">Album ini masih kosong. Mulai upload foto atau video dokumentasi.</p>
        <button class="btn btn-outline-primary mt-2" data-bs-toggle="modal" data-bs-target="#uploadMediaModal">
            Upload Sekarang
        </button>
    </div>
@endif

<!-- Upload Modal -->
<div class="modal fade" id="uploadMediaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-cloud-upload-alt me-2"></i>Upload Media</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.galeri.upload', $album->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="upload-area mb-3" onclick="document.getElementById('fileInput').click()">
                        <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
                        <h5>Klik untuk memilih file</h5>
                        <p class="text-muted small mb-0">Format: JPG, PNG, MP4. Max: 20MB</p>
                    </div>
                    <input type="file" name="file" id="fileInput" class="form-control d-none" required onchange="previewFile(this)">
                    
                    <div id="previewContainer" class="mb-3 d-none text-center">
                        <img id="imagePreview" style="max-height: 200px; border-radius: 10px;" class="d-none">
                        <div id="videoPreview" class="alert alert-info d-none">
                            <i class="fas fa-video me-2"></i> Video terpilih
                        </div>
                        <p id="fileName" class="small text-muted mt-2"></p>
                    </div>

                    <div class="form-group">
                        <label class="form-label fw-bold">Deskripsi / Caption (Opsional)</label>
                        <textarea name="deskripsi" class="form-control" rows="2" placeholder="Tulis keterangan foto/video..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
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
    Fancybox.bind("[data-fancybox]", {
        // Your custom options
    });

    function previewFile(input) {
        const previewContainer = document.getElementById('previewContainer');
        const imagePreview = document.getElementById('imagePreview');
        const videoPreview = document.getElementById('videoPreview');
        const fileName = document.getElementById('fileName');

        if (input.files && input.files[0]) {
            const file = input.files[0];
            previewContainer.classList.remove('d-none');
            fileName.textContent = file.name;

            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.classList.remove('d-none');
                    videoPreview.classList.add('d-none');
                }
                reader.readAsDataURL(file);
            } else if (file.type.startsWith('video/')) {
                imagePreview.classList.add('d-none');
                videoPreview.classList.remove('d-none');
            }
        }
    }

    function shareItem(fileUrl, description) {
        // Construct absolute URL if it isn't already
        const fullUrl = fileUrl.startsWith('http') ? fileUrl : window.location.origin + fileUrl;
        const text = description ? description : 'Lihat foto/video ini';
        
        if (navigator.share) {
            navigator.share({
                title: 'Galeri Admin',
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
        }
    }
</script>
@endpush
