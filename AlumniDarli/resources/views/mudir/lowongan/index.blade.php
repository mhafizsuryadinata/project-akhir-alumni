@extends('mudir-master')

@section('judul', 'Pengelolaan Lowongan Kerja')

@push('styles')
<style>
    :root {
        --primary-blue: #1a73e8;
        --secondary-blue: #4285f4;
        --success-green: #28a745;
        --warning-yellow: #ffc107;
        --danger-red: #dc3545;
        --white: #ffffff;
        --shadow: 0 4px 20px rgba(26, 115, 232, 0.1);
        --border-radius: 16px;
    }

    .hero-section {
        background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
        color: var(--white);
        padding: 2.5rem 0;
        border-radius: var(--border-radius);
        margin-bottom: 2rem;
        text-align: center;
        box-shadow: var(--shadow);
    }

    .job-card {
        transition: transform 0.3s, box-shadow 0.3s;
        border: none;
        border-radius: 16px;
        overflow: hidden;
        height: 100%;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }

    .job-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(26, 115, 232, 0.15);
    }

    .company-logo {
        width: 60px;
        height: 60px;
        object-fit: contain;
        border-radius: 10px;
        background: #f8f9fa;
        padding: 5px;
    }

    .badge-status {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-active { background-color: rgba(40, 167, 69, 0.1); color: var(--success-green); }
    .badge-closed { background-color: rgba(220, 53, 69, 0.1); color: var(--danger-red); }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-header text-white mb-4 shadow-sm" style="border-radius: 16px; overflow: hidden;">
    <div class="p-4" style="background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));">
        <div class="row align-items-center text-start">
            <div class="col-md-8">
                <h1 class="fw-800 mb-2 text-white"><i class="fas fa-briefcase me-2"></i>Pengelolaan Lowongan</h1>
                <p class="mb-0 opacity-80">Kelola info karir dan moderasi lowongan dari alumni</p>
            </div>
            <div class="col-md-4 text-md-end d-none d-md-block">
                <iconify-icon icon="solar:briefcase-bold-duotone" class="text-white opacity-20" style="font-size: 5rem;"></iconify-icon>
            </div>
        </div>
    </div>
</section>

<!-- Stats -->
<div class="stats-grid mt-4">
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="stat-card shadow-sm border-0 bg-white p-4 rounded-4" style="border-left: 5px solid var(--primary-blue) !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="h2 fw-bold mb-0">{{ $stats['total'] }}</div>
                        <div class="text-muted small">Total Lowongan</div>
                    </div>
                    <div class="bg-light-primary p-3 rounded-circle">
                         <i class="fas fa-layer-group fa-lg text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card shadow-sm border-0 bg-white p-4 rounded-4" style="border-left: 5px solid var(--success-green) !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="h2 fw-bold mb-0 text-success">{{ $stats['aktif'] }}</div>
                        <div class="text-muted small">Lowongan Aktif</div>
                    </div>
                    <div class="bg-light-success p-3 rounded-circle">
                        <i class="fas fa-check-circle fa-lg text-success"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card shadow-sm border-0 bg-white p-4 rounded-4" style="border-left: 5px solid var(--danger-red) !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="h2 fw-bold mb-0 text-danger">{{ $stats['tutup'] }}</div>
                        <div class="text-muted small">Lowongan Tutup</div>
                    </div>
                    <div class="bg-light-danger p-3 rounded-circle">
                        <i class="fas fa-times-circle fa-lg text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Filter Bar -->
<div class="card border-0 shadow-sm mb-4 rounded-4">
    <div class="card-body p-3">
        <div class="row g-3 align-items-center">
            <div class="col-md-6">
                <select id="mudirStatusFilter" class="form-select border-0 bg-light">
                    <option value="">Semua Status (Aktif/Tutup)</option>
                    <option value="active">Aktif</option>
                    <option value="closed">Ditutup</option>
                </select>
            </div>
            <div class="col-md-6">
                <div class="form-check form-switch mt-1">
                    <input class="form-check-input" type="checkbox" id="mudirHideClosedToggle">
                    <label class="form-check-label small fw-bold text-muted" for="mudirHideClosedToggle">Sembunyikan Tutup</label>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0 text-secondary">Daftar Lowongan</h4>
    <button class="btn btn-primary px-4 py-2 rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#createJobModal">
        <i class="fas fa-plus me-2"></i>Tambah Lowongan
    </button>
</div>

<!-- Job Grid -->
<div class="row g-4">
    @forelse($lowongan as $job)
    <div class="col-md-6 col-lg-4 mudir-lowongan-item" 
         data-title="{{ strtolower($job->judul) }}" 
         data-company="{{ strtolower($job->perusahaan) }}"
         data-active="{{ $job->isActive() ? 'active' : 'closed' }}">
        <div class="card job-card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    @if($job->logo_perusahaan)
                        @php
                            $logoUrl = str_starts_with($job->logo_perusahaan, 'storage/') 
                                ? asset($job->logo_perusahaan) 
                                : asset('storage/' . $job->logo_perusahaan);
                        @endphp
                        <img src="{{ $logoUrl }}" alt="Logo" class="company-logo">
                    @else
                        <div class="company-logo d-flex align-items-center justify-content-center text-primary fw-bold fs-4">
                            {{ substr($job->perusahaan, 0, 1) }}
                        </div>
                    @endif
                    <div class="text-end">
                        <span class="badge-status {{ $job->isActive() ? 'badge-active' : 'badge-closed' }}">
                            {{ $job->isActive() ? 'Aktif' : 'Ditutup' }}
                        </span>
                        <div class="mt-2">
                             <div class="badge {{ $job->status_admin == 'approved' ? 'bg-success' : ($job->status_admin == 'rejected' ? 'bg-danger' : 'bg-warning text-dark') }}" style="font-size: 0.65rem;">
                                ADM: {{ strtoupper($job->status_admin) }}
                            </div>
                            <div class="badge {{ $job->status_pimpinan == 'approved' ? 'bg-success' : ($job->status_pimpinan == 'rejected' ? 'bg-danger' : 'bg-warning text-dark') }}" style="font-size: 0.65rem;">
                                PIM: {{ strtoupper($job->status_pimpinan) }}
                            </div>
                        </div>
                        <div class="small text-muted mt-1">{{ \Carbon\Carbon::parse($job->created_at)->diffForHumans() }}</div>
                    </div>
                </div>
                
                <h5 class="fw-bold mb-1 text-truncate" title="{{ $job->judul }}">{{ $job->judul }}</h5>
                <p class="text-muted small mb-2"><i class="fas fa-building me-1"></i> {{ $job->perusahaan }}</p>
                <div class="d-flex gap-2 mb-3 flex-wrap">
                    <span class="badge bg-light text-dark border"><i class="fas fa-map-marker-alt me-1"></i> {{ $job->lokasi }}</span>
                    <span class="badge bg-light text-dark border"><i class="fas fa-clock me-1"></i> {{ $job->tipe_pekerjaan }}</span>
                </div>

                @if($job->status_pimpinan == 'pending')
                <div class="alert alert-info py-2 px-3 mb-3 d-flex justify-content-between align-items-center">
                    <span class="small fw-bold">Moderasi Pimpinan:</span>
                    <div class="btn-group">
                        <form action="{{ route('mudir.lowongan.approve', $job->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-xs btn-success py-0 px-2" style="font-size: 0.7rem;">Setujui</button>
                        </form>
                        <form action="{{ route('mudir.lowongan.reject', $job->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-xs btn-danger py-0 px-2" style="font-size: 0.7rem;">Tolak</button>
                        </form>
                    </div>
                </div>
                @endif

                <div class="mb-3">
                    <small class="text-muted">Diposting oleh: <strong>{{ $job->poster->nama ?? 'Alumni' }}</strong></small>
                </div>

                <hr class="my-3">

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-users me-1 text-primary"></i> 
                        <span class="fw-bold">{{ $job->lamaran_count }}</span> <span class="small text-muted">Pelamar</span>
                    </div>
                    <div class="btn-group">
                        <a href="{{ route('mudir.lowongan.show', $job->id) }}" class="btn btn-sm btn-outline-primary rounded-start px-3">
                            Detail
                        </a>
                        <button class="btn btn-sm btn-outline-warning" onclick='editJob(@json($job))'>
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger rounded-end" onclick="deleteJob({{ $job->id }}, '{{ $job->judul }}')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <i class="fas fa-briefcase fa-4x text-muted opacity-25 mb-3"></i>
        <p class="text-muted">Belum ada lowongan kerja.</p>
    </div>
    @endforelse
</div>

@include('mudir.lowongan.modals')

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('globalSearchInput');
        const statusFilter = document.getElementById('mudirStatusFilter');
        const hideClosedToggle = document.getElementById('mudirHideClosedToggle');
        const jobItems = document.querySelectorAll('.mudir-lowongan-item');

        function filterJobs() {
            const search = (searchInput && searchInput.value) ? searchInput.value.toLowerCase() : '';
            const statusVal = (statusFilter && statusFilter.value) ? statusFilter.value : '';
            const hideClosed = hideClosedToggle ? hideClosedToggle.checked : false;

            jobItems.forEach(item => {
                const title = item.dataset.title;
                const company = item.dataset.company;
                const isActive = item.dataset.active; // 'active' or 'closed'

                const matchSearch = title.includes(search) || company.includes(search);
                const matchStatus = statusVal === "" || isActive === statusVal;
                const matchHideClosed = !hideClosed || isActive === 'active';

                if (matchSearch && matchStatus && matchHideClosed) {
                    item.style.display = "";
                } else {
                    item.style.display = "none";
                }
            });
        }

        if (searchInput) {
            searchInput.addEventListener('input', filterJobs);
            statusFilter.addEventListener('change', filterJobs);
            hideClosedToggle.addEventListener('change', filterJobs);
        }
    });

    function editJob(job) {
        document.getElementById('edit_judul').value = job.judul;
        document.getElementById('edit_perusahaan').value = job.perusahaan;
        document.getElementById('edit_lokasi').value = job.lokasi;
        document.getElementById('edit_deskripsi').value = job.deskripsi;
        document.getElementById('edit_kualifikasi').value = job.kualifikasi;
        document.getElementById('edit_benefit').value = job.benefit;
        
        let cleanMin = job.gaji_min ? job.gaji_min.replace(/[^0-9]/g, '') : '';
        let cleanMax = job.gaji_max ? job.gaji_max.replace(/[^0-9]/g, '') : '';
        
        document.getElementById('edit_gaji_min').value = cleanMin;
        document.getElementById('edit_gaji_max').value = cleanMax;
        document.getElementById('edit_email').value = job.email_kontak;
        document.getElementById('edit_website').value = job.website;
        
        let date = new Date(job.tanggal_tutup);
        document.getElementById('edit_tanggal_tutup').value = date.toISOString().split('T')[0];
        
        document.getElementById('edit_level').value = job.level;
        document.getElementById('edit_tipe').value = job.tipe_pekerjaan;
        document.getElementById('edit_status').value = job.status;
        
        document.getElementById('editForm').action = `/mudir/lowongan/${job.id}`;
        
        new bootstrap.Modal(document.getElementById('editJobModal')).show();
    }

    function deleteJob(id, title) {
        if(confirm(`Hapus lowongan "${title}"?`)) {
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = `/mudir/lowongan/${id}`;
            form.innerHTML = `@csrf @method('DELETE')`;
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
@endpush
