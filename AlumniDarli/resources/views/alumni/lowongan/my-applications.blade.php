@extends('alumni-master')

@section('alumni')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-file-alt me-2"></i>Lamaran Saya</h2>
        <a href="{{ route('lowongan.index') }}" class="btn btn-primary">
            <i class="fas fa-briefcase me-1"></i> Cari Lowongan
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if($lamaran->isEmpty())
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
            <h5>Belum Ada Lamaran</h5>
            <p class="text-muted">Anda belum melamar pekerjaan apapun.</p>
            <a href="{{ route('lowongan.index') }}" class="btn btn-primary mt-3">
                <i class="fas fa-search me-1"></i> Cari Lowongan Sekarang
            </a>
        </div>
    </div>
    @else
    <div class="row">
        @foreach($lamaran as $item)
        <div class="col-md-12 mb-3">
            <div class="card application-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-start">
                                @if($item->lowongan->logo_perusahaan)
                                    <img src="{{ asset($item->lowongan->logo_perusahaan) }}" 
                                         alt="{{ $item->lowongan->perusahaan }}" 
                                         class="company-logo me-3">
                                @else
                                    <div class="company-logo-placeholder me-3">
                                        <i class="fas fa-building"></i>
                                    </div>
                                @endif
                                <div>
                                    <h5 class="mb-1">
                                        <a href="{{ route('lowongan.show', $item->lowongan->id) }}" class="text-decoration-none">
                                            {{ $item->lowongan->judul }}
                                        </a>
                                    </h5>
                                    <p class="text-muted mb-2">{{ $item->lowongan->perusahaan }}</p>
                                    <div class="d-flex flex-wrap gap-2">
                                        <span class="badge bg-primary">{{ $item->lowongan->tipe_pekerjaan }}</span>
                                        <span class="badge bg-secondary">{{ $item->lowongan->lokasi }}</span>
                                        <span class="badge 
                                            @if($item->final_status == 'Menunggu') bg-warning text-dark
                                            @elseif($item->final_status == 'Diterima') bg-success
                                            @else bg-danger
                                            @endif">
                                            {{ $item->final_status }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <small class="text-muted d-block mb-2">
                                <i class="fas fa-clock me-1"></i>
                                Dilamar: {{ $item->created_at->format('d M Y') }}
                            </small>
                            <div class="d-flex gap-2 justify-content-md-end">
                                <a href="{{ route('lowongan.show', $item->lowongan->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye me-1"></i> Lihat Lowongan
                                </a>
                                @if($item->cv_path)
                                <a href="{{ asset($item->cv_path) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-download me-1"></i> CV
                                </a>
                                @endif
                            </div>
                            @if($item->cover_letter)
                            <button class="btn btn-sm btn-link mt-2" data-bs-toggle="collapse" 
                                    data-bs-target="#cover{{ $item->id }}">
                                <i class="fas fa-envelope me-1"></i> Lihat Cover Letter
                            </button>
                            @endif
                        </div>
                    </div>
                    
                    @if($item->cover_letter)
                    <div class="collapse mt-3" id="cover{{ $item->id }}">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="mb-2">Cover Letter:</h6>
                                <p class="mb-0" style="white-space: pre-line;">{{ $item->cover_letter }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $lamaran->links() }}
    </div>
    @endif
</div>

<style>
.application-card {
    transition: all 0.3s ease;
    border: 1px solid #e0e0e0;
}

.application-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.company-logo {
    width: 60px;
    height: 60px;
    object-fit: contain;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 5px;
}

.company-logo-placeholder {
    width: 60px;
    height: 60px;
    background: #f8f9fa;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: #6c757d;
}
</style>
@endsection
