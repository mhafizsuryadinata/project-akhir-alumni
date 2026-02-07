@extends('admin-master')
@section('isi')

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Edit Info Pondok</h4>
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @push('styles')
                <style>
                    .form-control, .form-select, textarea {
                        border: 2px solid #e9ecef;
                        border-radius: 10px;
                        transition: all 0.3s;
                        min-height: 50px; /* Ensure sufficient height */
                        font-size: 1rem;
                        padding: 0.85rem 1.2rem;
                    }

                    .form-select {
                        appearance: none;
                        -webkit-appearance: none;
                        -moz-appearance: none;
                        padding-right: 2.5rem;
                        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
                        background-repeat: no-repeat;
                        background-position: right 1.2rem center;
                        background-size: 16px 12px;
                    }

                    textarea {
                        min-height: 150px;
                    }

                    .form-control:focus, .form-select:focus {
                        border-color: #1a73e8; /* Primary Blue */
                        box-shadow: 0 0 0 0.25rem rgba(26, 115, 232, 0.15);
                    }
                </style>
                @endpush

                <form action="{{ route('admin.info.update', $info->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group mb-3">
                        <label for="judul" class="form-label fw-bold">Judul Info</label>
                        <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul', $info->judul) }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="jenis" class="form-label fw-bold">Jenis Info</label>
                        <select class="form-select" id="jenis" name="jenis" required>
                            <option value="Pengumuman" {{ $info->jenis == 'Pengumuman' ? 'selected' : '' }}>Pengumuman (Penting)</option>
                            <option value="Kegiatan" {{ $info->jenis == 'Kegiatan' ? 'selected' : '' }}>Kegiatan (Event/Acara)</option>
                            <option value="Pengembangan" {{ $info->jenis == 'Pengembangan' ? 'selected' : '' }}>Pengembangan (Pembangunan/Proses)</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="konten" class="form-label fw-bold">Isi Konten</label>
                        <textarea class="form-control" id="konten" name="konten" rows="5" required>{{ old('konten', $info->konten) }}</textarea>
                    </div>

                    <div class="form-group mb-4">
                        <label for="gambar" class="form-label fw-bold">Gambar (Opsional)</label>
                        @if($info->gambar)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $info->gambar) }}" alt="Current Image" style="max-height: 150px; border-radius: 8px;">
                            </div>
                        @endif
                        <input type="file" class="form-control" id="gambar" name="gambar">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success px-4 py-2">
                            <i class="fas fa-save me-2"></i>Update Info
                        </button>
                        <a href="{{ route('admin.info.index') }}" class="btn btn-secondary px-4 py-2">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
