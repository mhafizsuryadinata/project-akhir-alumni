@extends('alumni-master')

@section('alumni')
<div class="container py-3">
    <!-- Breadcrumb & Back -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('lowongan.index') }}" class="text-decoration-none">Lowongan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail</li>
            </ol>
        </nav>
        <a href="{{ route('lowongan.index') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-3 py-2" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-check-circle me-2 fs-5"></i>
            <div class="small">{{ session('success') }}</div>
        </div>
        <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row g-3">
        <div class="col-lg-8">
            <!-- Job Header Card (Hero-like) -->
            <div class="card border-0 shadow-sm mb-3 overflow-hidden">
                <div class="card-header-premium p-3 p-md-4 text-white">
                    <div class="d-flex flex-column flex-md-row align-items-center align-items-md-start gap-3">
                        @if($lowongan->logo_perusahaan)
                            @php
                                $logoUrl = str_starts_with($lowongan->logo_perusahaan, 'storage/') 
                                    ? asset($lowongan->logo_perusahaan) 
                                    : asset('storage/' . $lowongan->logo_perusahaan);
                            @endphp
                            <div class="logo-wrapper shadow">
                                <img src="{{ $logoUrl }}" 
                                     alt="{{ $lowongan->perusahaan }}" 
                                     class="company-logo-img">
                            </div>
                        @else
                            <div class="logo-placeholder-premium shadow">
                                <i class="fas fa-building"></i>
                            </div>
                        @endif
                        <div class="text-center text-md-start flex-grow-1">
                            <h2 class="h3 fw-bold mb-1">{{ $lowongan->judul }}</h2>
                            <h5 class="h6 opacity-90 mb-2">{{ $lowongan->perusahaan }}</h5>
                            <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-1">
                                <span class="badge badge-premium-light small">
                                    <i class="fas fa-briefcase me-1"></i> {{ $lowongan->tipe_pekerjaan }}
                                </span>
                                <span class="badge badge-premium-light small">
                                    <i class="fas fa-layer-group me-1"></i> {{ $lowongan->level }}
                                </span>
                                <span class="badge badge-premium-{{ $lowongan->isActive() ? 'success' : 'danger' }} small">
                                    <i class="fas {{ $lowongan->isActive() ? 'fa-check' : 'fa-times' }} me-1"></i> 
                                    {{ $lowongan->isActive() ? 'Aktif' : 'Ditutup' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-3 border-top">
                    <!-- Essential Meta Information -->
                    <div class="row g-2 mb-3">
                        <div class="col-6 col-md-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="meta-icon bg-light-primary">
                                    <i class="fas fa-map-marker-alt text-primary"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <small class="text-muted d-block smaller">Lokasi</small>
                                    <span class="fw-semibold small text-truncate d-block">{{ $lowongan->lokasi }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="meta-icon bg-light-success">
                                    <i class="fas fa-money-bill-wave text-success"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <small class="text-muted d-block smaller">Gaji</small>
                                    <span class="fw-semibold small text-truncate d-block">
                                        {{ ($lowongan->gaji_min && $lowongan->gaji_max) ? $lowongan->gaji_min . ' - ' . $lowongan->gaji_max : 'Kompetitif' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="meta-icon bg-light-warning">
                                    <i class="fas fa-calendar-alt text-warning"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <small class="text-muted d-block smaller">Batas</small>
                                    <span class="fw-semibold small text-truncate d-block">{{ \Carbon\Carbon::parse($lowongan->tanggal_tutup)->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="meta-icon bg-light-info">
                                    <i class="fas fa-user-clock text-info"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <small class="text-muted d-block smaller">Posting</small>
                                    <span class="fw-semibold small text-truncate d-block">{{ $lowongan->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2 pt-2 border-top">
                        @auth
                            @if($sudahApply)
                                <button class="btn btn-success btn-sm px-4" disabled>
                                    <i class="fas fa-check-circle me-1"></i> Terkirim
                                </button>
                            @else
                                @if($lowongan->isActive())
                                    <button class="btn btn-primary btn-sm px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#applyModal">
                                        <i class="fas fa-paper-plane me-1"></i> Lamar Sekarang
                                    </button>
                                @else
                                    <button class="btn btn-secondary btn-sm px-4" disabled>
                                        <i class="fas fa-lock me-1"></i> Ditutup
                                    </button>
                                @endif
                            @endif

                            @if(Auth::user()->role === 'admin' || $lowongan->posted_by === Auth::user()->id_user)
                                <a href="{{ route('lowongan.edit', $lowongan->id) }}" class="btn btn-outline-warning btn-sm px-3">
                                    <i class="fas fa-edit me-1"></i> Edit
                                </a>
                                <form action="{{ route('lowongan.destroy', $lowongan->id) }}" method="POST" class="d-inline" 
                                      onsubmit="return confirm('Hapus lowongan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm px-3">
                                        <i class="fas fa-trash me-1"></i>
                                    </button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-sm px-4 shadow-sm">
                                <i class="fas fa-sign-in-alt me-1"></i> Login untuk Melamar
                            </a>
                        @endauth
                        
                        <button class="btn btn-light btn-sm border px-3" onclick="shareJob()">
                            <i class="fas fa-share-alt me-1"></i> Bagikan
                        </button>
                    </div>
                </div>
            </div>

            <!-- Main Content Detail -->
            <div class="content-section mb-3">
                <div class="nav-tabs-custom mb-3">
                    <button class="tab-link active small" onclick="showSection(event, 'deskripsi')">Deskripsi</button>
                    <button class="tab-link small" onclick="showSection(event, 'kualifikasi')">Kualifikasi</button>
                    @if($lowongan->benefit)
                    <button class="tab-link small" onclick="showSection(event, 'benefit')">Benefit</button>
                    @endif
                </div>

                <div id="deskripsi" class="tab-content-premium active shadow-sm bg-white p-3 rounded-4">
                    <h6 class="fw-bold mb-2 d-flex align-items-center">
                        <span class="title-indicator me-2"></span> Deskripsi Pekerjaan
                    </h6>
                    <div class="description-text small">
                        {!! nl2br(e($lowongan->deskripsi)) !!}
                    </div>
                </div>

                <div id="kualifikasi" class="tab-content-premium shadow-sm bg-white p-3 rounded-4">
                    <h6 class="fw-bold mb-2 d-flex align-items-center">
                        <span class="title-indicator me-2"></span> Kualifikasi
                    </h6>
                    <div class="description-text small">
                        {!! nl2br(e($lowongan->kualifikasi)) !!}
                    </div>
                </div>

                @if($lowongan->benefit)
                <div id="benefit" class="tab-content-premium shadow-sm bg-white p-3 rounded-4">
                    <h6 class="fw-bold mb-2 d-flex align-items-center">
                        <span class="title-indicator me-2"></span> Keuntungan (Benefit)
                    </h6>
                    <div class="description-text small">
                        {!! nl2br(e($lowongan->benefit)) !!}
                    </div>
                </div>
                @endif
            </div>

            @auth
                @if(Auth::user()->role === 'admin' || $lowongan->posted_by === Auth::user()->id_user)
                <!-- Daftar Pelamar (Khusus Admin/Poster) -->
                <div class="card border-0 shadow-sm mb-3 mt-4">
                    <div class="card-header bg-white py-3 border-0">
                        <h6 class="mb-0 fw-bold"><i class="fas fa-users me-2 text-primary"></i>Daftar Pelamar (Internal)</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-3 border-0 small py-2">Pelamar</th>
                                        <th class="border-0 small py-2">Status</th>
                                        <th class="pe-3 text-end border-0 small py-2">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($lowongan->lamaran as $lamaran)
                                    <tr>
                                        <td class="ps-3 border-0">
                                            <div class="fw-bold small">{{ $lamaran->user->nama ?? 'Alumni' }}</div>
                                            <small class="text-muted smaller">{{ $lamaran->created_at->format('d M Y') }}</small>
                                        </td>
                                        <td class="border-0">
                                            @php
                                                $badgeClass = 'bg-warning text-dark';
                                                if($lamaran->final_status == 'Diterima') $badgeClass = 'bg-success';
                                                if($lamaran->final_status == 'Ditolak') $badgeClass = 'bg-danger';
                                            @endphp
                                            <span class="badge {{ $badgeClass }} smaller">{{ $lamaran->final_status }}</span>
                                        </td>
                                        <td class="pe-3 text-end border-0">
                                            <div class="btn-group">
                                                @if($lamaran->cv_path)
                                                    <a href="{{ route('admin.lowongan.cv', $lamaran->id) }}" class="btn btn-sm btn-outline-primary py-0" title="Download CV">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                @endif
                                                
                                                @if($lamaran->status == 'Menunggu' || $lamaran->status == 'Pending')
                                                    <form action="{{ route('admin.lowongan.status', $lamaran->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="Diterima">
                                                        <button type="submit" class="btn btn-sm btn-outline-success py-0" title="Terima" onclick="return confirm('Terima lamaran ini?')">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.lowongan.status', $lamaran->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="Ditolak">
                                                        <button type="submit" class="btn btn-sm btn-outline-danger py-0" title="Tolak" onclick="return confirm('Tolak lamaran ini?')">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-3 text-muted smaller">Belum ada pelamar.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            @endauth
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Contact Card -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body p-3">
                    <h6 class="fw-bold mb-3 d-flex align-items-center">
                        <i class="fas fa-address-book text-primary me-2"></i> Kontak
                    </h6>
                    
                    <div class="contact-item d-flex gap-2 mb-2">
                        <div class="meta-icon sm bg-light-primary">
                            <i class="fas fa-envelope text-primary"></i>
                        </div>
                        <div class="overflow-hidden">
                            <small class="text-muted d-block smaller">Email</small>
                            <a href="mailto:{{ $lowongan->email_kontak }}" class="fw-semibold text-decoration-none text-dark d-block text-truncate small">
                                {{ $lowongan->email_kontak }}
                            </a>
                        </div>
                    </div>

                    @if($lowongan->website)
                    <div class="contact-item d-flex gap-2 mb-3">
                        <div class="meta-icon sm bg-light-info">
                            <i class="fas fa-globe text-info"></i>
                        </div>
                        <div class="overflow-hidden">
                            <small class="text-muted d-block smaller">Website</small>
                            <a href="{{ $lowongan->website }}" target="_blank" class="fw-semibold text-decoration-none text-primary d-block text-truncate small">
                                {{ str_replace(['http://', 'https://'], '', $lowongan->website) }}
                            </a>
                        </div>
                    </div>
                    @endif

                    <div class="alert alert-light border shadow-none mb-0 smaller p-2">
                        <i class="fas fa-info-circle me-1 text-warning"></i>
                        Jangan memberikan uang selama proses rekrutmen.
                    </div>
                </div>
            </div>

            <!-- Related Jobs -->
            @if($lowonganTerkait->isNotEmpty())
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <h6 class="fw-bold mb-3 d-flex align-items-center">
                        <i class="fas fa-lightbulb text-warning me-2"></i> Lowongan Serupa
                    </h6>
                    
                    @foreach($lowonganTerkait as $related)
                    <a href="{{ route('lowongan.show', $related->id) }}" class="related-job-card mb-2 d-flex align-items-center gap-2 p-2 text-decoration-none text-dark border rounded-3 transition-all">
                        <div class="related-job-logo">
                            @if($related->logo_perusahaan)
                                @php
                                    $relatedLogoUrl = str_starts_with($related->logo_perusahaan, 'storage/') 
                                        ? asset($related->logo_perusahaan) 
                                        : asset('storage/' . $related->logo_perusahaan);
                                @endphp
                                <img src="{{ $relatedLogoUrl }}" alt="">
                            @else
                                <div class="placeholder"><i class="fas fa-building"></i></div>
                            @endif
                        </div>
                        <div class="overflow-hidden">
                            <h6 class="mb-0 text-truncate fw-bold small">{{ $related->judul }}</h6>
                            <p class="smaller text-muted mb-0 text-truncate">{{ $related->perusahaan }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Apply -->
@auth
@if(!$sudahApply && $lowongan->isActive())
<div class="modal fade" id="applyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <form action="{{ route('lowongan.apply', $lowongan->id) }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-lg">
            @csrf
            <div class="modal-header bg-primary text-white p-3">
                <h6 class="modal-title fw-bold" id="applyModalLabel">
                    <i class="fas fa-paper-plane me-2"></i> Lamar Pekerjaan
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <div class="mb-3">
                    <label for="cv" class="form-label fw-bold small">Unggah CV (Opsional)</label>
                    <input type="file" name="cv" id="cv" class="form-control form-control-sm" accept=".pdf,.doc,.docx">
                    <small class="text-muted smaller">PDF atau Word. Maks: 5MB</small>
                </div>
                
                <div class="mb-0">
                    <label for="cover_letter" class="form-label fw-bold small">Pesan (Opsional)</label>
                    <textarea name="cover_letter" id="cover_letter" class="form-control form-control-sm" rows="3" 
                              placeholder="Tuliskan alasan melamar..."></textarea>
                </div>
            </div>
            <div class="modal-footer bg-light p-2">
                <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold">Kirim</button>
            </div>
        </form>
    </div>
</div>
@endif
@endauth

<script>
function showSection(evt, sectionName) {
    var i, tabContent, tabLinks;
    tabContent = document.getElementsByClassName("tab-content-premium");
    for (i = 0; i < tabContent.length; i++) {
        tabContent[i].classList.remove("active");
    }
    tabLinks = document.getElementsByClassName("tab-link");
    for (i = 0; i < tabLinks.length; i++) {
        tabLinks[i].classList.remove("active");
    }
    document.getElementById(sectionName).classList.add("active");
    evt.currentTarget.classList.add("active");
}

function shareJob() {
    const jobTitle = "{{ $lowongan->judul }}";
    const company = "{{ $lowongan->perusahaan }}";
    const jobUrl = window.location.href;
    
    if (navigator.share) {
        navigator.share({
            title: jobTitle,
            text: `Kursi lowongan di ${company}: ${jobTitle}.`,
            url: jobUrl
        })
        .then(() => console.log('Shared'))
        .catch((error) => console.log('Error:', error));
    } else {
        navigator.clipboard.writeText(jobUrl).then(() => {
            alert('Tautan disalin!');
        }).catch(() => {
            prompt('Salin tautan:', jobUrl);
        });
    }
}
</script>

<style>
/* Optimized Compact Layout */
.smaller { font-size: 0.75rem; }

.card-header-premium {
    background: linear-gradient(45deg, #1557b0 0%, #4285f4 100%);
    position: relative;
    border: none;
}

.logo-wrapper {
    width: 80px;
    height: 80px;
    background: white;
    border-radius: 12px;
    padding: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.company-logo-img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.logo-placeholder-premium {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    color: white;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.badge-premium-light {
    background: rgba(255, 255, 255, 0.15);
    color: white;
    backdrop-filter: blur(5px);
    padding: 4px 10px;
    border-radius: 20px;
    font-weight: 500;
}

.badge-premium-success {
    background: #d1fae5;
    color: #065f46;
    padding: 4px 10px;
    border-radius: 20px;
    font-weight: 600;
}

.badge-premium-danger {
    background: #fee2e2;
    color: #991b1b;
    padding: 4px 10px;
    border-radius: 20px;
    font-weight: 600;
}

.meta-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    flex-shrink: 0;
}

.meta-icon.sm {
    width: 28px;
    height: 28px;
    font-size: 0.8rem;
    border-radius: 6px;
}

.bg-light-primary { background: #e7f0ff; }
.bg-light-success { background: #e6f9ed; }
.bg-light-warning { background: #fff8e6; }
.bg-light-info { background: #e6f7ff; }

/* Tabs Design */
.nav-tabs-custom {
    display: flex;
    border-bottom: 1px solid #e9ecef;
}

.tab-link {
    background: none;
    border: none;
    padding: 8px 16px;
    font-weight: 600;
    color: #6c757d;
    position: relative;
    transition: all 0.3s;
}

.tab-link:hover { color: #4285f4; }
.tab-link.active { color: #1557b0; }

.tab-link.active::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 0;
    width: 100%;
    height: 2px;
    background: #1557b0;
}

.tab-content-premium { display: none; }
.tab-content-premium.active {
    display: block;
    animation: fadeIn 0.3s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(3px); }
    to { opacity: 1; transform: translateY(0); }
}

.title-indicator {
    width: 3px;
    height: 14px;
    background: #4285f4;
    border-radius: 2px;
}

.description-text {
    line-height: 1.6;
    color: #444;
}

/* Related Jobs */
.related-job-card:hover {
    background: #f8f9fa;
    border-color: #4285f4 !important;
    transform: translateX(3px);
}

.related-job-logo {
    width: 36px;
    height: 36px;
    background: #f8f9fa;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    overflow: hidden;
}

.related-job-logo img {
    max-width: 100%;
    max-height: 100%;
}

.related-job-logo .placeholder {
    font-size: 14px;
    color: #adb5bd;
}

.transition-all {
    transition: all 0.2s ease-in-out;
}
</style>
@endsection
