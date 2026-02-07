@extends('admin-master')

@section('judul', 'Detail Lowongan')

@push('styles')
<style>
    :root {
        --primary-blue: #1a73e8;
        --border-radius: 16px;
        --shadow: 0 4px 20px rgba(26, 115, 232, 0.1);
    }
    
    .detail-card {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
    }

    .applicants-table thead th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }
    
    .company-logo-large {
        width: 100px;
        height: 100px;
        object-fit: contain;
        border-radius: 15px;
        background: #fff;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
</style>
@endpush

@section('isi')
<div class="mb-4">
    <a href="{{ route('admin.lowongan.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="row g-4">
    <!-- Detail Lowongan -->
    <div class="col-lg-8">
        <div class="card detail-card h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-start gap-3 mb-4">
                    @if($lowongan->logo_perusahaan)
                        @php
                            $logoUrl = str_starts_with($lowongan->logo_perusahaan, 'storage/') 
                                ? asset($lowongan->logo_perusahaan) 
                                : asset('storage/' . $lowongan->logo_perusahaan);
                        @endphp
                        <img src="{{ $logoUrl }}" class="company-logo-large">
                    @else
                        <div class="company-logo-large d-flex align-items-center justify-content-center bg-light text-primary fs-1 fw-bold">
                            {{ substr($lowongan->perusahaan, 0, 1) }}
                        </div>
                    @endif
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="fw-bold mb-1">{{ $lowongan->judul }}</h3>
                                <div class="text-muted fs-5"><i class="fas fa-building me-2"></i>{{ $lowongan->perusahaan }}</div>
                            </div>
                            <div class="d-flex gap-2">
                                <span class="badge {{ $lowongan->isActive() ? 'bg-success' : 'bg-danger' }} fs-6 px-3 py-2">
                                    {{ $lowongan->isActive() ? 'Aktif' : 'Ditutup' }}
                                </span>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="badge bg-light text-dark border me-2"><i class="fas fa-map-marker-alt me-1"></i> {{ $lowongan->lokasi }}</span>
                            <span class="badge bg-light text-dark border me-2"><i class="fas fa-briefcase me-1"></i> {{ $lowongan->tipe_pekerjaan }}</span>
                            <span class="badge bg-light text-dark border"><i class="fas fa-layer-group me-1"></i> {{ $lowongan->level }}</span>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <small class="text-muted text-uppercase fw-bold d-block mb-1">Email Kontak</small>
                        <a href="mailto:{{ $lowongan->email_kontak }}" class="text-decoration-none">{{ $lowongan->email_kontak }}</a>
                    </div>
                    @if($lowongan->website)
                    <div class="col-md-6 mb-3">
                        <small class="text-muted text-uppercase fw-bold d-block mb-1">Website</small>
                        <a href="{{ $lowongan->website }}" target="_blank" class="text-decoration-none">{{ parse_url($lowongan->website, PHP_URL_HOST) }} <i class="fas fa-external-link-alt ms-1"></i></a>
                    </div>
                    @endif
                    @if($lowongan->gaji_max)
                    <div class="col-md-12">
                        <small class="text-muted text-uppercase fw-bold d-block mb-1">Estimasi Gaji</small>
                        <span class="fw-bold text-success">
                            Rp {{ number_format((float)$lowongan->gaji_min, 0, ',', '.') }} - Rp {{ number_format((float)$lowongan->gaji_max, 0, ',', '.') }}
                        </span>
                    </div>
                    @endif
                </div>

                <hr class="text-muted my-4">

                <div class="mb-4">
                    <h5 class="fw-bold mb-3">Deskripsi Pekerjaan</h5>
                    <div class="text-muted" style="white-space: pre-line;">{{ $lowongan->deskripsi }}</div>
                </div>
                
                <div class="mb-4">
                    <h5 class="fw-bold mb-3">Kualifikasi</h5>
                    <div class="text-muted" style="white-space: pre-line;">{{ $lowongan->kualifikasi }}</div>
                </div>

                @if($lowongan->benefit)
                <div class="mb-4">
                    <h5 class="fw-bold mb-3">Benefit</h5>
                    <div class="text-muted" style="white-space: pre-line;">{{ $lowongan->benefit }}</div>
                </div>
                @endif
                
                <div class="mt-5 d-flex gap-2">
                    <button class="btn btn-success" onclick="shareJob()">
                        <i class="fas fa-share-alt me-2"></i>Bagikan Lowongan
                    </button>
                    <!-- Trigger Edit Modal (Optional: logic same as index) -->
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik & Pelamar -->
    <div class="col-lg-4">
        <!-- Statistik Kecil -->
        <div class="row g-3 mb-4">
            <div class="col-6">
                <div class="card border-0 shadow-sm text-center py-3">
                    <h3 class="fw-bold text-primary mb-0">{{ $stats['total_pelamar'] }}</h3>
                    <small class="text-muted">Pelamar</small>
                </div>
            </div>
            <div class="col-6">
                <div class="card border-0 shadow-sm text-center py-3">
                    <h3 class="fw-bold text-warning mb-0">{{ $stats['hari_sisa'] > 0 ? $stats['hari_sisa'] : 0 }}</h3>
                    <small class="text-muted">Hari Sisa</small>
                </div>
            </div>
        </div>

        <!-- Daftar Pelamar -->
        <div class="card detail-card">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="mb-0 fw-bold"><i class="fas fa-users me-2 text-primary"></i>Daftar Pelamar</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover applicants-table mb-0 align-middle">
                        <thead>
                            <tr>
                                <th class="ps-3">Nama Alumni</th>
                                <th>Moderasi</th>
                                <th class="pe-3 text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lowongan->lamaran as $lamaran)
                            <tr>
                                <td class="ps-3">
                                    <div class="fw-bold">{{ $lamaran->user->nama ?? 'Alumni' }}</div>
                                    <small class="text-muted">{{ $lamaran->created_at->format('d M Y') }}</small>
                                </td>
                                <td>
                                    <div class="mb-1">
                                        <span class="badge {{ $lamaran->status_admin == 'Diterima' ? 'bg-success' : ($lamaran->status_admin == 'Ditolak' ? 'bg-danger' : 'bg-warning text-dark') }}" style="font-size: 0.65rem;">
                                            ADM: {{ $lamaran->status_admin }}
                                        </span>
                                    </div>
                                    <div class="mb-1">
                                        <span class="badge {{ $lamaran->status_pimpinan == 'Diterima' ? 'bg-success' : ($lamaran->status_pimpinan == 'Ditolak' ? 'bg-danger' : 'bg-warning text-dark') }}" style="font-size: 0.65rem;">
                                            PIM: {{ $lamaran->status_pimpinan }}
                                        </span>
                                    </div>
                                    <hr class="my-1 opacity-25">
                                    <div class="fw-bold small text-uppercase">
                                        Final: <span class="text-{{ $lamaran->final_status == 'Diterima' ? 'success' : ($lamaran->final_status == 'Ditolak' ? 'danger' : 'warning') }}">{{ $lamaran->final_status }}</span>
                                    </div>
                                </td>
                                <td class="pe-3 text-end">
                                    <div class="btn-group">
                                        @if($lamaran->cv_path)
                                            <a href="{{ route('admin.lowongan.cv', $lamaran->id) }}" class="btn btn-sm btn-outline-primary" title="Download CV">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        @endif
                                        
                                        @if($lamaran->status_admin == 'Menunggu')
                                            <form action="{{ route('admin.lowongan.status', $lamaran->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="Diterima">
                                                <button type="submit" class="btn btn-sm btn-outline-success" title="Terima (Admin)" onclick="return confirm('Terima lamaran ini sebagai Admin?')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.lowongan.status', $lamaran->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="Ditolak">
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Tolak (Admin)" onclick="return confirm('Tolak lamaran ini sebagai Admin?')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.lowongan.status', $lamaran->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="Menunggu">
                                                <button type="submit" class="btn btn-sm btn-outline-secondary" title="Reset ke Menunggu" onclick="return confirm('Reset status moderasi Admin?')">
                                                    <i class="fas fa-undo"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">
                                    Belum ada yang melamar.
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
@endsection

@push('scripts')
<script>
    function shareJob() {
        if (navigator.share) {
            navigator.share({
                title: 'Lowongan: {{ $lowongan->judul }}',
                text: 'Cek lowongan {{ $lowongan->judul }} di {{ $lowongan->perusahaan }}',
                url: window.location.href
            })
            .then(() => console.log('Successful share'))
            .catch((error) => console.log('Error sharing', error));
        } else {
            // Fallback copy link
            navigator.clipboard.writeText(window.location.href).then(function() {
                alert('Tautan berhasil disalin ke clipboard!');
            });
        }
    }
</script>
@endpush
