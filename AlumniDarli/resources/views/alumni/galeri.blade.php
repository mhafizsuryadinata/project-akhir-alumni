@extends('alumni-master')

@section('alumni')
<section class="hero">
    <div class="container">
        <h1>Galeri Alumni</h1>
        <p>Kumpulan momen berharga dan kenangan indah bersama keluarga besar Dar El-Ilmi</p>
        <div class="mt-4">
            <span class="badge bg-light text-primary me-2"><i class="fas fa-images me-1"></i> {{ $totalFoto }} Foto</span>
            <span class="badge bg-light text-primary me-2"><i class="fas fa-video me-1"></i> {{ $totalVideo }} Video</span>
            <span class="badge bg-light text-primary"><i class="fas fa-calendar me-1"></i> {{ $totalAlbum }} Album</span>
        </div>
    </div>
</section>

<!-- Filter -->
<div class="card mb-4 fade-in">
    <div class="card-body">
        <div class="row g-3 align-items-center">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Cari foto atau album...">
                </div>
            </div>
            <div class="col-md-3">
                <select id="categoryFilter" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoriList as $kategori)
                        <option value="{{ $kategori }}">{{ $kategori }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select id="yearFilter" class="form-select">
                    <option value="">Semua Tahun</option>
                    @foreach($tahunList as $tahun)
                        <option value="{{ $tahun }}">{{ $tahun }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Konten Galeri -->
    <div class="col-lg-9">
        <div class="row g-4" id="galleryList">
            @forelse($albums as $album)
            <div class="col-md-4 gallery-item" 
                 data-title="{{ strtolower($album->nama_album) }}" 
                 data-kategori="{{ $album->kategori }}" 
                 data-tahun="{{ $album->tahun }}">
                <div class="card gallery-album fade-in h-100">
                    <div class="position-relative">
                        @php
                            $coverUrl = str_starts_with($album->cover, 'storage/') 
                                ? asset($album->cover) 
                                : asset('storage/' . $album->cover);
                        @endphp
                        <img src="{{ $coverUrl }}" class="card-img-top" alt="{{ $album->nama_album }}" style="height:200px;object-fit:cover;">
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge bg-primary me-1"><i class="fas fa-image me-1"></i>{{ $album->jumlah_foto ?? 0 }}</span>
                            <span class="badge bg-danger"><i class="fas fa-video me-1"></i>{{ $album->jumlah_video ?? 0 }}</span>
                        </div>
                        @if($album->created_by == (auth()->check() ? auth()->user()->id_user : 0) && ($album->status_admin != 'approved' || $album->status_pimpinan != 'approved'))
                            <div class="position-absolute top-0 start-0 m-2" style="z-index: 10;">
                                <span class="badge {{ $album->status_admin == 'approved' ? 'bg-info' : ($album->status_admin == 'rejected' || $album->status_pimpinan == 'rejected' ? 'bg-danger' : 'bg-warning text-dark') }}" style="font-size: 0.65rem; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                                    <i class="fas fa-clock me-1"></i>
                                    @if($album->status_admin == 'rejected' || $album->status_pimpinan == 'rejected')
                                        DITOLAK
                                    @elseif($album->status_admin == 'approved')
                                        MENUNGGU PIMPINAN
                                    @else
                                        MENUNGGU ADMIN
                                    @endif
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $album->nama_album }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($album->deskripsi, 80) }}</p>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <small class="text-muted"><i class="far fa-calendar me-1"></i> {{ $album->tahun }}</small>
                            <a href="{{ route('galeri.show', $album->id) }}" class="btn btn-outline-primary btn-sm">Lihat Album</a>
                        </div>
                        @if($album->created_by == (auth()->check() ? auth()->user()->id_user : 0))
                            <form action="{{ route('album.delete', $album->id) }}" method="POST" onsubmit="return confirm('Hapus album ini beserta semua foto/video di dalamnya?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm w-100">
                                    <i class="fas fa-trash-alt me-1"></i> Hapus Album
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12" id="noGalleryMessage">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-2"></i>
                    Belum ada album tersedia.
                </div>
            </div>
            @endforelse

            <!-- Message for no filter results -->
            <div class="col-12 d-none" id="noFilterResult">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-2"></i>
                    Tidak ada album yang sesuai dengan filter yang dipilih.
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-3">
        <div class="card fade-in">
            <div class="card-header">
                <i class="fas fa-bolt me-2"></i>Aksi Cepat
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-primary text-start" data-bs-toggle="modal" data-bs-target="#uploadModal">
                        <i class="fas fa-upload me-2"></i>Unggah Foto / Video
                    </button>
                    <button class="btn btn-outline-primary text-start" data-bs-toggle="modal" data-bs-target="#albumModal">
                        <i class="fas fa-plus me-2"></i>Buat Album Baru
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Upload -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('galeri.upload') }}" method="POST" enctype="multipart/form-data" class="modal-content">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title" id="uploadModalLabel">Unggah Foto / Video</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label for="album_id" class="form-label">Pilih Album</label>
                <select name="album_id" id="album_id" class="form-select" required>
                    @foreach($albums as $album)
                        <option value="{{ $album->id }}">{{ $album->nama_album }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="file" class="form-label">File Foto/Video</label>
                <input type="file" name="file" id="file" class="form-control" accept="image/*,video/*" required>
            </div>
            <div class="mb-3">
                <label for="tipe" class="form-label">Tipe File</label>
                <select name="tipe" id="tipe" class="form-select">
                    <option value="foto">Foto</option>
                    <option value="video">Video</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="2"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success"><i class="fas fa-upload me-1"></i> Upload</button>
        </div>
    </form>
  </div>
</div>

<!-- Modal Tambah Album -->
<div class="modal fade" id="albumModal" tabindex="-1" aria-labelledby="albumModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('album.store') }}" method="POST" enctype="multipart/form-data" class="modal-content">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title" id="albumModalLabel">Buat Album Baru</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label for="nama_album" class="form-label">Nama Album</label>
                <input type="text" name="nama_album" id="nama_album" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="2"></textarea>
            </div>
            <div class="mb-3">
                <label for="tahun" class="form-label">Tahun</label>
                <input type="text" name="tahun" id="tahun" class="form-control" placeholder="contoh: 2024" required>
            </div>
            <div class="mb-3">
                <label for="kategori" class="form-label">Kategori</label>
                <select name="kategori" id="kategori" class="form-select">
                    <option value="Event">Event</option>
                    <option value="Reuni">Reuni</option>
                    <option value="Kegiatan Pesantren">Kegiatan Pesantren</option>
                    <option value="Foto Angkatan">Foto Angkatan</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="cover" class="form-label">Cover Album</label>
                <input type="file" name="cover" id="cover" class="form-control" accept="image/*" required>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan Album</button>
        </div>
    </form>
  </div>
</div>

<style>
.gallery-album { transition: all .3s ease; }
.gallery-album:hover { transform: translateY(-5px); }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const yearFilter = document.getElementById('yearFilter');
    const galleryItems = document.querySelectorAll('.gallery-item');
    const noFilterResult = document.getElementById('noFilterResult');

    function filterGallery() {
        const searchValue = searchInput.value.toLowerCase();
        const categoryValue = categoryFilter.value;
        const yearValue = yearFilter.value;

        let visibleCount = 0;

        galleryItems.forEach(item => {
            const title = item.dataset.title.toLowerCase();
            const category = item.dataset.kategori;
            const year = item.dataset.tahun;

            const matchSearch = title.includes(searchValue);
            const matchCategory = categoryValue === "" || category === categoryValue;
            const matchYear = yearValue === "" || year === yearValue;

            if (matchSearch && matchCategory && matchYear) {
                item.style.display = ""; // Show
                visibleCount++;
            } else {
                item.style.display = "none"; // Hide
            }
        });

        // Show/hide 'no result' message
        if (visibleCount === 0 && galleryItems.length > 0) {
            if (noFilterResult) noFilterResult.classList.remove('d-none');
        } else {
            if (noFilterResult) noFilterResult.classList.add('d-none');
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterGallery);
        categoryFilter.addEventListener('change', filterGallery);
        yearFilter.addEventListener('change', filterGallery);
    }
});
</script>
@endsection
