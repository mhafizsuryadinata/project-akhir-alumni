    @extends('alumni-master')

@section('alumni')
<section class="hero">
    <div class="container">
        <h1>Lowongan Pekerjaan</h1>
        <p>Temukan peluang karir terbaik untuk alumni Dar El-Ilmi</p>
        <div class="mt-4">
            <span class="badge bg-light text-primary me-2">
                <i class="fas fa-briefcase me-1"></i> {{ $totalLowongan }} Lowongan Aktif
            </span>
            <a href="{{ route('lowongan.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus me-1"></i> Posting Lowongan
            </a>
            <a href="{{ route('lowongan.myApplications') }}" class="btn btn-info btn-sm">
                <i class="fas fa-file-alt me-1"></i> Lamaran Saya
            </a>
        </div>
    </div>
</section>

<!-- Filter -->
<div class="card mb-4 fade-in">
    <div class="card-body">
        <div class="row g-3 align-items-center">
            <div class="col-md-3">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control border-start-0" 
                           placeholder="Cari lowongan...">
                </div>
            </div>
            <div class="col-md-2">
                <select id="typeFilter" class="form-select">
                    <option value="">Semua Tipe</option>
                    @foreach($tipeList as $tipe)
                        <option value="{{ $tipe }}">{{ $tipe }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select id="levelFilter" class="form-select">
                    <option value="">Semua Level</option>
                    @foreach($levelList as $level)
                        <option value="{{ $level }}">{{ $level }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select id="locationFilter" class="form-select">
                    <option value="">Semua Lokasi</option>
                    @foreach($lokasiList as $lok)
                        <option value="{{ $lok }}">{{ $lok }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <div class="form-check form-switch mt-2">
                    <input class="form-check-input" type="checkbox" id="hideClosedToggle">
                    <label class="form-check-label small fw-bold text-muted" for="hideClosedToggle">Sembunyikan Tutup</label>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Alert Messages -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- Daftar Lowongan -->
<div class="row g-4" id="lowonganList">
    @forelse($lowongan as $item)
    <div class="col-md-6 col-lg-4 lowongan-item" 
         data-title="{{ strtolower($item->judul) }}" 
         data-company="{{ strtolower($item->perusahaan) }}"
         data-type="{{ $item->tipe_pekerjaan }}"
         data-level="{{ $item->level }}"
         data-location="{{ $item->lokasi }}"
         data-status="{{ $item->isActive() ? 'active' : 'closed' }}">
        <div class="card h-100 lowongan-card fade-in">
            <div class="card-body">
                <div class="d-flex align-items-start mb-3">
                    @if($item->logo_perusahaan)
                        @php
                            $logoUrl = str_starts_with($item->logo_perusahaan, 'storage/') 
                                ? asset($item->logo_perusahaan) 
                                : asset('storage/' . $item->logo_perusahaan);
                        @endphp
                        <img src="{{ $logoUrl }}" 
                             alt="{{ $item->perusahaan }}" 
                             class="company-logo me-3">
                    @else
                        <div class="company-logo-placeholder me-3">
                            <i class="fas fa-building"></i>
                        </div>
                    @endif
                    <div class="flex-grow-1">
                        <h5 class="card-title mb-1">{{ $item->judul }}</h5>
                        <p class="text-muted mb-2">{{ $item->perusahaan }}</p>
                    </div>
                </div>
                
                <div class="mb-3">
                    <span class="badge bg-primary me-1">{{ $item->tipe_pekerjaan }}</span>
                    <span class="badge bg-secondary">{{ $item->level }}</span>
                    @if($item->posted_by == (auth()->check() ? auth()->user()->id_user : 0) && ($item->status_admin != 'approved' || $item->status_pimpinan != 'approved'))
                        <span class="badge {{ $item->status_admin == 'approved' ? 'bg-info' : ($item->status_admin == 'rejected' || $item->status_pimpinan == 'rejected' ? 'bg-danger' : 'bg-warning text-dark') }} ms-1">
                            @if($item->status_admin == 'rejected' || $item->status_pimpinan == 'rejected')
                                DITOLAK
                            @elseif($item->status_admin == 'approved')
                                MENUNGGU PIMPINAN
                            @else
                                MENUNGGU ADMIN
                            @endif
                        </span>
                    @endif
                </div>
                
                <div class="info-item">
                    <i class="fas fa-map-marker-alt text-muted me-2"></i>
                    <span>{{ $item->lokasi }}</span>
                </div>
                
                @if($item->gaji_min && $item->gaji_max)
                <div class="info-item">
                    <i class="fas fa-money-bill-wave text-muted me-2"></i>
                    <span>{{ $item->gaji_min }} - {{ $item->gaji_max }}</span>
                </div>
                @endif
                
                <div class="info-item">
                    <i class="fas fa-calendar-alt text-muted me-2"></i>
                    <span>Tutup: {{ \Carbon\Carbon::parse($item->tanggal_tutup)->format('d M Y') }}</span>
                </div>
                
                <div class="mt-3">
                    <a href="{{ route('lowongan.show', $item->id) }}" class="btn btn-outline-primary w-100">
                        Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12" id="noLowonganMessage">
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle me-2"></i>
            Belum ada lowongan tersedia saat ini.
        </div>
    </div>
    @endforelse

    <!-- Message for no filter results -->
    <div class="col-12 d-none" id="noFilterResult">
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle me-2"></i>
            Tidak ada lowongan yang sesuai dengan filter yang dipilih.
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const typeFilter = document.getElementById('typeFilter');
    const levelFilter = document.getElementById('levelFilter');
    const locationFilter = document.getElementById('locationFilter');
    const hideClosedToggle = document.getElementById('hideClosedToggle');
    const lowonganItems = document.querySelectorAll('.lowongan-item');
    const noFilterResult = document.getElementById('noFilterResult');

    function filterLowongan() {
        const searchValue = searchInput.value.toLowerCase();
        const typeValue = typeFilter.value;
        const levelValue = levelFilter.value;
        const locationValue = locationFilter.value;
        const hideClosed = hideClosedToggle ? hideClosedToggle.checked : false;

        let visibleCount = 0;

        lowonganItems.forEach(item => {
            const title = item.dataset.title;
            const company = item.dataset.company;
            const type = item.dataset.type;
            const level = item.dataset.level;
            const location = item.dataset.location;
            const status = item.dataset.status;

            const matchSearch = title.includes(searchValue) || company.includes(searchValue);
            const matchType = typeValue === "" || type === typeValue;
            const matchLevel = levelValue === "" || level === levelValue;
            const matchLocation = locationValue === "" || location === locationValue;
            const matchHideClosed = !hideClosed || status === 'active';

            if (matchSearch && matchType && matchLevel && matchLocation && matchHideClosed) {
                item.style.display = ""; // Show
                visibleCount++;
            } else {
                item.style.display = "none"; // Hide
            }
        });

        // Show/hide 'no result' message
        if (visibleCount === 0 && lowonganItems.length > 0) {
            if (noFilterResult) noFilterResult.classList.remove('d-none');
        } else {
            if (noFilterResult) noFilterResult.classList.add('d-none');
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterLowongan);
        typeFilter.addEventListener('change', filterLowongan);
        levelFilter.addEventListener('change', filterLowongan);
        locationFilter.addEventListener('change', filterLowongan);
        if (hideClosedToggle) hideClosedToggle.addEventListener('change', filterLowongan);
    }
});
</script>

<style>
.lowongan-card {
    transition: all 0.3s ease;
    border: 1px solid #e0e0e0;
}

.lowongan-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
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

.info-item {
    display: flex;
    align-items: center;
    margin-bottom: 8px;
    font-size: 14px;
}

.hero {
    background: linear-gradient(135deg, #1557b0 0%, #4285f4 100%);
    color: white;
    padding: 60px 0;
    margin-bottom: 30px;
    border-radius: 10px;
}

.hero h1 {
    font-size: 2.5rem;
    font-weight: bold;
    margin-bottom: 10px;
}

.fade-in {
    animation: fadeIn 0.5s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

<style>
.hero {
    position: relative;
    z-index: 10;
}

.hero a.btn {
    position: relative;
    z-index: 999;
    pointer-events: auto;
}

/* Matikan overlay yang menutupi */
* {
    pointer-events: auto !important;
}
</style>


@endsection
