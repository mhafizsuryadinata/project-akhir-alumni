@extends('admin-master')

@section('judul', 'Pengelolaan Lowongan Kerja')

@push('styles')
<style>
    /* Styling konsisten dengan Admin Galeri */
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

    /* Hero Section - Matching page-hero theme */
    .hero-section {
        background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
        color: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        margin-bottom: 2rem;
        box-shadow: 0 15px 35px rgba(15, 12, 41, 0.2);
        position: relative;
        overflow: hidden;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: var(--white);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        box-shadow: var(--shadow);
        border-left: 5px solid var(--primary-blue);
    }

    .stat-card.active { border-left-color: var(--success-green); }
    .stat-card.closed { border-left-color: var(--danger-red); }

    .stat-card .number { font-size: 2rem; font-weight: 700; }
    .stat-card .label { font-size: 0.875rem; color: #6c757d; }

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

    /* Modal Form Styling - Consistent with Galeri */
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
        border: 2px solid #e9ecef;
        border-radius: 10px;
        transition: all 0.3s;
        min-height: 50px;
        padding: 0.85rem 1.2rem;
        font-size: 1rem;
    }
    
    textarea { min-height: 120px; }

    .form-control:focus, .form-select:focus, textarea:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 0.25rem rgba(26, 115, 232, 0.15);
    }
</style>
@endpush

@section('isi')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <h1 class="fw-bold"><i class="fas fa-briefcase me-2"></i>Pengelolaan Lowongan</h1>
        <p class="mb-0">Kelola info karir dan pantau pelamar alumni</p>
    </div>
</section>

<!-- Stats -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <div class="number">{{ $stats['total'] }}</div>
                <div class="label">Total Lowongan</div>
            </div>
            <i class="fas fa-layer-group fa-2x text-primary opacity-25"></i>
        </div>
    </div>
    <div class="stat-card active">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <div class="number">{{ $stats['aktif'] }}</div>
                <div class="label">Lowongan Aktif</div>
            </div>
            <i class="fas fa-check-circle fa-2x text-success opacity-25"></i>
        </div>
    </div>
    <div class="stat-card closed">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <div class="number">{{ $stats['tutup'] }}</div>
                <div class="label">Lowongan Tutup</div>
            </div>
            <i class="fas fa-times-circle fa-2x text-danger opacity-25"></i>
        </div>
    </div>
</div>

<!-- Filter Bar -->
<div class="card border-0 shadow-sm mb-4 rounded-4">
    <div class="card-body p-3">
        <div class="row g-3 align-items-center">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-light border-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" id="adminSearchInput" class="form-control border-0 bg-light" placeholder="Cari judul atau perusahaan...">
                </div>
            </div>
            <div class="col-md-3">
                <select id="adminStatusFilter" class="form-select border-0 bg-light">
                    <option value="">Semua Status (Aktif/Tutup)</option>
                    <option value="active">Aktif</option>
                    <option value="closed">Ditutup</option>
                </select>
            </div>
            <div class="col-md-3">
                <div class="form-check form-switch mt-1">
                    <input class="form-check-input" type="checkbox" id="adminHideClosedToggle">
                    <label class="form-check-label small fw-bold text-muted" for="adminHideClosedToggle">Sembunyikan Tutup</label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0 text-secondary">Daftar Lowongan</h4>
    <button class="btn btn-primary px-4 py-2 rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#createJobModal">
        <i class="fas fa-plus me-2"></i>Tambah Lowongan
    </button>
</div>

<!-- Job Grid -->
<div class="row g-4">
    @forelse($lowongan as $job)
    <div class="col-md-6 col-lg-4 admin-lowongan-item" 
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

                @if($job->status_admin == 'pending')
                <div class="alert alert-info py-2 px-3 mb-3 d-flex justify-content-between align-items-center">
                    <span class="small fw-bold">Moderasi Admin:</span>
                    <div class="btn-group">
                        <form action="{{ route('admin.lowongan.approve', $job->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-xs btn-success py-0 px-2" style="font-size: 0.7rem;">Setujui</button>
                        </form>
                        <form action="{{ route('admin.lowongan.reject', $job->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-xs btn-danger py-0 px-2" style="font-size: 0.7rem;">Tolak</button>
                        </form>
                    </div>
                </div>
                @endif

                <hr class="my-3">

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-users me-1 text-primary"></i> 
                        <span class="fw-bold">{{ $job->lamaran_count }}</span> <span class="small text-muted">Pelamar</span>
                    </div>
                    <div class="btn-group">
                        <a href="{{ route('admin.lowongan.show', $job->id) }}" class="btn btn-sm btn-outline-primary rounded-start px-3">
                            Detail
                        </a>
                        <button class="btn btn-sm btn-outline-warning" onclick="editJob({{ $job }})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger rounded-end" onclick="deleteJob({{ $job->id }}, '{{ $job->judul }}')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
            @if($job->posted_by != Auth::user()->id_user)
            <div class="card-footer bg-light py-1">
                <small class="text-muted fst-italic">Diposting oleh: {{ $job->poster->nama ?? 'Alumni' }}</small>
            </div>
            @endif
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <i class="fas fa-folder-open fa-4x text-muted opacity-25 mb-3"></i>
        <p class="text-muted">Belum ada lowongan kerja.</p>
    </div>
    @endforelse
</div>

<!-- Create/Update Modals will be placed here -->
@include('admin.lowongan.modals')

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('adminSearchInput');
        const statusFilter = document.getElementById('adminStatusFilter');
        const hideClosedToggle = document.getElementById('adminHideClosedToggle');
        const jobItems = document.querySelectorAll('.admin-lowongan-item');

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
        // Populate modal fields
        document.getElementById('edit_judul').value = job.judul;
        document.getElementById('edit_perusahaan').value = job.perusahaan;
        document.getElementById('edit_lokasi').value = job.lokasi;
        document.getElementById('edit_deskripsi').value = job.deskripsi;
        document.getElementById('edit_kualifikasi').value = job.kualifikasi;
        document.getElementById('edit_benefit').value = job.benefit;
        
        // Sanitize salary from "Rp 8.000.000" to "8000000"
        let cleanMin = job.gaji_min ? job.gaji_min.replace(/[^0-9]/g, '') : '';
        let cleanMax = job.gaji_max ? job.gaji_max.replace(/[^0-9]/g, '') : '';
        
        document.getElementById('edit_gaji_min').value = cleanMin;
        document.getElementById('edit_gaji_max').value = cleanMax;
        document.getElementById('edit_email').value = job.email_kontak;
        document.getElementById('edit_website').value = job.website;
        // Format date for input type="date"
        let date = new Date(job.tanggal_tutup);
        document.getElementById('edit_tanggal_tutup').value = date.toISOString().split('T')[0];
        
        document.getElementById('edit_level').value = job.level;
        document.getElementById('edit_tipe').value = job.tipe_pekerjaan;
        document.getElementById('edit_status').value = job.status;
        
        // Update form action
        document.getElementById('editForm').action = `/admin/lowongan/${job.id}`;
        
        // Show modal
        new bootstrap.Modal(document.getElementById('editJobModal')).show();
    }

    function deleteJob(id, title) {
        if(confirm(`Hapus lowongan "${title}"?\nSemua data pelamar juga akan dihapus.`)) {
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/lowongan/${id}`;
            form.innerHTML = `@csrf @method('DELETE')`;
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
@endpush
