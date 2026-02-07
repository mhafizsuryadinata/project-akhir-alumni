@extends('admin-master')

@section('judul', 'Data Alumni Dar El-ilmi')

@section('isi')
<div class="row g-4 page-content">
    <!-- Hero Header -->
    <div class="col-12 animate-box" style="animation-delay: 0.1s">
        <div class="card overflow-hidden border-0 page-hero">
            <div class="card-body p-4 position-relative">
                <div class="row align-items-center position-relative z-index-1">
                    <div class="col-md-8 text-white">
                        <h3 class="fw-800 mb-1"><iconify-icon icon="solar:users-group-rounded-bold-duotone" class="me-2"></iconify-icon> Data Alumni</h3>
                        <p class="mb-0 opacity-75 small">Kelola seluruh data alumni Pondok Pesantren Dar El-ilmi</p>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <button class="btn btn-light fw-600 shadow-sm" data-bs-toggle="collapse" data-bs-target="#tambahAlumniForm">
                            <iconify-icon icon="solar:add-circle-bold-duotone" class="me-1"></iconify-icon> Tambah Alumni
                        </button>
                    </div>
                </div>
                <div class="position-absolute floating-icon" style="right: -30px; bottom: -30px; opacity: 0.1;">
                    <iconify-icon icon="solar:users-group-rounded-bold-duotone" style="font-size: 150px; color: white;"></iconify-icon>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 animate-box" style="animation-delay: 0.2s">
        <!-- Tambah Alumni Form (Glassmorphism Style) -->
        <div class="collapse mb-4" id="tambahAlumniForm">
            <div class="card glass-card">
                <div class="card-header d-flex align-items-center justify-content-between p-4">
                    <h5 class="card-title mb-0"><iconify-icon icon="solar:user-plus-bold-duotone" class="text-primary me-2"></iconify-icon>Tambah Data Alumni Baru</h5>
                    <button type="button" class="btn-close" data-bs-toggle="collapse" data-bs-target="#tambahAlumniForm"></button>
                </div>
                <div class="card-body p-4">
                    <form action="{{url('alumni/simpan')}}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-700">Nomor NIA</label>
                                <input type="text" name="nomor_nia" class="form-control" placeholder="Masukkan NIA" required>
                                <div class="form-text small opacity-75">NIA akan digunakan sebagai password default.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-700">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Masukkan username unik" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-700">Tahun Angkatan (Tahun Masuk)</label>
                                <input type="number" name="tahun_masuk" class="form-control" placeholder="Contoh: 2020">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-700">Tahun Tamat (Lulus)</label>
                                <input type="number" name="tahun_tamat" class="form-control" placeholder="Contoh: 2023">
                            </div>
                        </div>
                        <div class="mt-4 text-end">
                            <button type="button" class="btn btn-light px-4 me-2" data-bs-toggle="collapse" data-bs-target="#tambahAlumniForm">Batal</button>
                            <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                <iconify-icon icon="solar:disk-bold-duotone" class="me-1"></iconify-icon> Simpan Alumni
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabel Alumni Premium -->
        <div class="card glass-card">
            <div class="card-header d-flex justify-content-between align-items-center p-4">
                <div>
                    <h4 class="card-title mb-1">Daftar Alumni Dar El-ilmi</h4>
                    <p class="text-muted small mb-0">Total {{ number_format($users->count()) }} alumni terdaftar dalam sistem</p>
                </div>
            </div>
            <div class="card-body p-0">
                @if(session('pesan'))
                <div class="mx-4 mt-3 alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('pesan') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                    <table class="table table-hover align-middle mb-0" id="alumniTable">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 text-uppercase small fw-800 text-muted border-0 py-3" width="60">NO</th>
                                <th class="text-uppercase small fw-800 text-muted border-0 py-3">Informasi Alumni</th>
                                <th class="text-uppercase small fw-800 text-muted border-0 py-3">Identitas Dasar</th>
                                <th class="text-uppercase small fw-800 text-muted border-0 py-3">Lokasi & Pekerjaan</th>
                                <th class="text-uppercase small fw-800 text-muted border-0 py-3 text-center" width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $a)
                            <tr>
                                <td class="ps-4 text-center fw-600 text-muted">{{$loop->iteration}}</td>
                                <td>
                                    <div class="d-flex align-items-center py-2">
                                        <div class="me-3 position-relative">
                                            @if($a->foto)
                                                <img src="{{ asset('storage/' . $a->foto) }}" alt="{{$a->nama}}" width="48" height="48" class="rounded-circle shadow-sm" style="object-fit: cover; border: 2px solid var(--white);">
                                            @else
                                                <div class="rounded-circle bg-light-blue text-primary d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; border: 2px solid var(--white);">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            @endif
                                            <span class="position-absolute bottom-0 end-0 bg-success border border-white rounded-circle p-1" title="Aktif"></span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-800 fs-6">{{ $a->nama ?? 'Nama Belum Diisi' }}</h6>
                                            <small class="text-muted d-block text-truncate" style="max-width: 200px;">{{ $a->email ?? '-' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="mb-1">
                                        <span class="badge bg-light-blue text-primary rounded-pill px-3 py-2 fw-700" style="font-size: 0.7rem;">
                                            Tahun: {{ $a->tahun_masuk ?? '?' }} - {{ $a->tahun_tamat ?? '?' }}
                                        </span>
                                    </div>
                                    <div class="small fw-600 text-dark">NIA: {{ $a->nomor_nia }}</div>
                                    <div class="small text-muted"><i class="fas fa-user-tag me-1 small"></i>{{ $a->username }}</div>
                                </td>
                                <td>
                                    <div class="fw-700 text-dark small mb-1"><i class="fas fa-briefcase text-primary me-2"></i>{{ $a->pekerjaan ?? '-' }}</div>
                                    <div class="text-muted small"><i class="fas fa-map-marker-alt text-danger me-2"></i>{{ $a->lokasi ?? '-' }}</div>
                                    @if($a->no_hp)
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $a->no_hp) }}" target="_blank" class="badge bg-light-success text-success mt-2 py-2 px-3 rounded-pill text-decoration-none" style="background: rgba(40,167,69,0.1);">
                                            <i class="fab fa-whatsapp me-2"></i>{{ $a->no_hp }}
                                        </a>
                                    @endif
                                </td>
                                <td class="ps-0">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="edit/{{$a->id_user}}" class="btn btn-sm btn-icon bg-light-warning text-warning rounded-pill" 
                                           style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; background: rgba(255,193,7,0.12); border: 1px solid rgba(255,193,7,0.2);"
                                           data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data Alumni">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <span data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Alumni">
                                            <button type="button" class="btn btn-sm btn-icon bg-light-danger text-danger rounded-pill" 
                                                    style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; background: rgba(220,53,69,0.12); border: 1px solid rgba(220,53,69,0.2);"
                                                    data-bs-toggle="modal" data-bs-target="#deleteAlumniModal" 
                                                    onclick="setDeleteAction('{{url('alumni/hapus/'.$a->id_user)}}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white border-0 py-3">
                <!-- Pagination can go here if needed -->
            </div>
        </div>
    </div>
</div>


<!-- Modal Konfirmasi Hapus Modern -->
<div class="modal fade" id="deleteAlumniModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-body p-4 text-center">
                <div class="mb-3">
                    <i class="fas fa-exclamation-circle text-danger" style="font-size: 3.5rem; opacity: 0.2;"></i>
                </div>
                <h5 class="fw-800 mb-2">Hapus Alumni?</h5>
                <p class="text-muted small mb-4">Tindakan ini permanen. Data alumni dan informasi terkait akan dihapus selamanya.</p>
                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-light px-4 border-0 fw-600" data-bs-dismiss="modal" style="background: #f1f3f5; border-radius: 12px;">Batal</button>
                    <a id="confirmDeleteBtn" href="#" class="btn btn-danger px-4 fw-600 shadow-sm" style="border-radius: 12px;">Hapus</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .fw-800 { font-weight: 800; }
    .fw-700 { font-weight: 700; }
    .fw-600 { font-weight: 600; }
    .bg-light-blue { background: rgba(26, 115, 232, 0.1); }
    .bg-light-success { background: rgba(40, 167, 69, 0.1); }
    .fade-in { animation: fadeIn 0.5s ease-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    
    #alumniTable tbody tr { transition: all 0.2s; }
    #alumniTable tbody tr:hover { background-color: rgba(26, 115, 232, 0.02) !important; }
    
    /* Sticky header for scrollable table */
    #alumniTable thead th {
        position: sticky;
        top: 0;
        z-index: 10;
        background-color: #f8f9fa;
    }

    /* Tooltip styling */
    .tooltip-inner {
        background-color: var(--primary-blue);
        font-weight: 600;
        font-size: 0.75rem;
        padding: 5px 12px;
        border-radius: 8px;
    }
    .bs-tooltip-top .tooltip-arrow::before {
        border-top-color: var(--primary-blue);
    }
</style>

@push('scripts')
<script>
    function setDeleteAction(url) {
        document.getElementById('confirmDeleteBtn').setAttribute('href', url);
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Auto-hide alerts
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });
</script>
@endpush
@endsection