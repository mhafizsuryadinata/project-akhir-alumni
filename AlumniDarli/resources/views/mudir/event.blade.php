@extends('mudir-master')

@push('styles')
<style>
    .event-card {
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    .event-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    .status-badge {
        font-size: 0.75rem;
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: 600;
    }
    .badge-pending { background-color: #fff3cd; color: #856404; }
    .badge-approved { background-color: #d4edda; color: #155724; }
    .badge-rejected { background-color: #f8d7da; color: #721c24; }
    
    .hero-header h1 { font-size: 1.8rem; }
    .opacity-80 { opacity: 0.8; }
    .opacity-20 { opacity: 0.2; }
    .fw-800 { font-weight: 800; }
    .bg-light-primary { background: rgba(26, 115, 232, 0.08); }
    .bg-light-success { background: rgba(40, 167, 69, 0.08); }
    
    .table-container {
        background: #fff;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.03);
    }
    
    .btn-approve {
        background: #28a745;
        color: white;
        border-radius: 8px;
        transition: all 0.2s;
    }
    .btn-approve:hover {
        background: #218838;
        transform: scale(1.05);
    }
    .btn-reject {
        background: #dc3545;
        color: white;
        border-radius: 8px;
        transition: all 0.2s;
    }
    .btn-reject:hover {
        background: #c82333;
        transform: scale(1.05);
    }
    .btn-action-mudir {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.2s;
        border: none;
    }
    .image-preview {
        max-width: 100%;
        max-height: 200px;
        border-radius: 10px;
        margin-top: 10px;
        display: none;
        border: 2px dashed #ddd;
        padding: 5px;
    }
    .modal-detail-banner {
        height: 200px;
        background-color: #f8f9fa;
        border-radius: 15px;
        overflow: hidden;
        margin-bottom: 20px;
        position: relative;
    }
    .modal-detail-banner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .modal-detail-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 10;
    }
    .info-label {
        color: #6c757d;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 2px;
        font-weight: 700;
    }
    .info-value {
        color: #212529;
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .info-value iconify-icon {
        color: var(--bs-primary);
        font-size: 1.2rem;
    }
    .creator-box {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 20px;
    }
    .creator-avatar {
        width: 45px;
        height: 45px;
        border-radius: 10px;
        background: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: var(--bs-primary);
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-header text-white mb-4 shadow-sm" style="border-radius: 16px; overflow: hidden;">
    <div class="p-4" style="background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="fw-800 mb-2 text-white"><i class="fas fa-calendar-alt me-2"></i>Pengelolaan Event Alumni</h1>
                <p class="mb-0 opacity-80">Manajemen, publikasi, dan moderasi event komunitas pondok</p>
            </div>
            <div class="col-md-4 text-md-end d-none d-md-block">
                <iconify-icon icon="solar:calendar-bold-duotone" class="text-white opacity-20" style="font-size: 5rem;"></iconify-icon>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Row 1: Timeline & Scale -->
<div class="row g-4 mb-4 fade-in">
    <div class="col-xl-4 col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-left: 5px solid var(--primary-blue) !important;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="h3 fw-800 mb-0">{{ $stats['total'] }}</div>
                        <div class="text-muted small fw-600">Total Event</div>
                    </div>
                    <div class="bg-light-primary p-3 rounded-circle text-primary">
                        <iconify-icon icon="solar:calendar-bold" class="fs-6"></iconify-icon>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-left: 5px solid var(--success) !important;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="h3 fw-800 mb-0 text-success">{{ $stats['upcoming'] }}</div>
                        <div class="text-muted small fw-600">Akan Datang</div>
                    </div>
                    <div class="bg-light-success p-3 rounded-circle text-success" style="background: rgba(40, 167, 69, 0.1);">
                        <iconify-icon icon="solar:calendar-add-bold" class="fs-6"></iconify-icon>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-12">
        <div class="card border-0 shadow-sm h-100" style="border-left: 5px solid var(--dark-gray) !important;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="h3 fw-800 mb-0 text-secondary">{{ $stats['past'] }}</div>
                        <div class="text-muted small fw-600">Telah Berlalu</div>
                    </div>
                    <div class="bg-light-secondary p-3 rounded-circle text-secondary" style="background: rgba(108, 117, 125, 0.1);">
                        <iconify-icon icon="solar:calendar-check-bold" class="fs-6"></iconify-icon>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Row 2: Moderation Status -->
<div class="row g-4 mb-4 fade-in">
    <div class="col-xl-6 col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-left: 5px solid var(--success) !important;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-light-success p-3 rounded-pill text-success" style="background: rgba(40, 167, 69, 0.1);">
                            <iconify-icon icon="solar:shield-check-bold" class="fs-6"></iconify-icon>
                        </div>
                        <div>
                            <div class="h4 fw-800 mb-0 text-success">{{ $stats['approved'] }}</div>
                            <div class="text-muted small fw-600">Event Disetujui</div>
                        </div>
                    </div>
                    <iconify-icon icon="solar:check-read-linear" class="fs-7 text-success opacity-20"></iconify-icon>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-left: 5px solid var(--danger) !important;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-light-danger p-3 rounded-pill text-danger" style="background: rgba(220, 53, 69, 0.1);">
                            <iconify-icon icon="solar:shield-cross-bold" class="fs-6"></iconify-icon>
                        </div>
                        <div>
                            <div class="h4 fw-800 mb-0 text-danger">{{ $stats['rejected'] }}</div>
                            <div class="text-muted small fw-600">Event Ditolak</div>
                        </div>
                    </div>
                    <iconify-icon icon="solar:close-circle-linear" class="fs-7 text-danger opacity-20"></iconify-icon>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold text-dark mb-0">Daftar Event Alumni</h5>
            </div>
            <div>
                <button class="btn btn-primary px-4 py-2 rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#createEventModal">
                    <i class="fas fa-plus me-2"></i>Buat Event Baru
                </button>
            </div>
        </div>
    </div>


    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-container p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th class="border-0 text-uppercase small fw-bold" style="width: 50px;">No</th>
                        <th class="border-0 text-uppercase small fw-bold">Event</th>
                        <th class="border-0 text-uppercase small fw-bold">Pengirim</th>
                        <th class="border-0 text-uppercase small fw-bold text-center">Status Admin</th>
                        <th class="border-0 text-uppercase small fw-bold text-center">Status Pimpinan</th>
                        <th class="border-0 text-uppercase small fw-bold text-center">Aksi Pimpinan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $event)
                    <tr>
                        <td class="text-muted">{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ $event->image ? asset('storage/' . $event->image) : asset('images/event-placeholder.jpg') }}" 
                                     class="rounded-3 me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                <div>
                                    <h6 class="mb-0 fw-bold">{{ $event->title }}</h6>
                                    <small class="text-muted"><i class="far fa-calendar-alt me-1"></i> {{ date('d M Y', strtotime($event->date)) }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span class="avatar-sm bg-light text-primary rounded-circle border d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px; font-size: 0.8rem;">
                                    {{ substr($event->user->nama ?? 'A', 0, 1) }}
                                </span>
                                <span class="small fw-600">{{ $event->user->nama ?? 'Admin' }}</span>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="status-badge badge-{{ $event->status_admin }}">
                                {{ strtoupper($event->status_admin) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="status-badge badge-{{ $event->status_pimpinan }}">
                                {{ strtoupper($event->status_pimpinan) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                @if($event->status_pimpinan == 'pending')
                                    <form action="{{ route('mudir.event.approve', $event->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-approve" title="Setujui">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('mudir.event.reject', $event->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-reject" title="Tolak">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @endif

                                <button class="btn-action-mudir bg-info text-white" onclick="showEventDetail({{ $event->id }})" title="Detail">
                                    <iconify-icon icon="solar:eye-bold"></iconify-icon>
                                </button>
                                
                                <button class="btn-action-mudir bg-warning text-white" onclick="editEvent({{ $event->id }})" title="Edit">
                                    <iconify-icon icon="solar:pen-new-square-bold"></iconify-icon>
                                </button>

                                <button class="btn-action-mudir bg-danger text-white" onclick="confirmDelete({{ $event->id }}, '{{ $event->title }}')" title="Hapus">
                                    <iconify-icon icon="solar:trash-bin-trash-bold"></iconify-icon>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-calendar-times fs-1 mb-3"></i>
                                <p>Belum ada data event.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Event Modal -->
<div class="modal fade" id="createEventModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <h5 class="modal-title fw-bold"><iconify-icon icon="solar:add-circle-bold" class="me-2 align-middle text-primary"></iconify-icon>Buat Event Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('mudir.event.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-600">Judul Event <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" placeholder="Masukkan judul event" required style="border-radius: 10px;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Kategori <span class="text-danger">*</span></label>
                            <select name="category" class="form-select" required style="border-radius: 10px;">
                                <option value="">Pilih Kategori</option>
                                <option value="Reuni">Reuni</option>
                                <option value="Seminar">Seminar</option>
                                <option value="Workshop">Workshop</option>
                                <option value="Bakti Sosial">Bakti Sosial</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Lokasi <span class="text-danger">*</span></label>
                            <input type="text" name="location" class="form-control" placeholder="Masukkan lokasi" required style="border-radius: 10px;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="date" class="form-control" required style="border-radius: 10px;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Waktu <span class="text-danger">*</span></label>
                            <input type="time" name="time" class="form-control" required style="border-radius: 10px;">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600">Deskripsi <span class="text-danger">*</span></label>
                            <textarea name="description" class="form-control" rows="4" placeholder="Masukkan deskripsi event" required style="border-radius: 10px;"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600">Gambar Event</label>
                            <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(this, 'createPreview')" style="border-radius: 10px;">
                            <img id="createPreview" class="image-preview">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal" style="border-radius: 10px;">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm" style="border-radius: 10px;">Simpan Event</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Event Modal -->
<div class="modal fade" id="editEventModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <h5 class="modal-title fw-bold"><iconify-icon icon="solar:pen-new-square-bold" class="me-2 align-middle text-warning"></iconify-icon>Edit Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editEventForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-600">Judul Event <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="edit_title" class="form-control" required style="border-radius: 10px;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Kategori <span class="text-danger">*</span></label>
                            <select name="category" id="edit_category" class="form-select" required style="border-radius: 10px;">
                                <option value="Reuni">Reuni</option>
                                <option value="Seminar">Seminar</option>
                                <option value="Workshop">Workshop</option>
                                <option value="Bakti Sosial">Bakti Sosial</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Lokasi <span class="text-danger">*</span></label>
                            <input type="text" name="location" id="edit_location" class="form-control" required style="border-radius: 10px;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="date" id="edit_date" class="form-control" required style="border-radius: 10px;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Waktu <span class="text-danger">*</span></label>
                            <input type="time" name="time" id="edit_time" class="form-control" required style="border-radius: 10px;">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600">Deskripsi <span class="text-danger">*</span></label>
                            <textarea name="description" id="edit_description" class="form-control" rows="4" required style="border-radius: 10px;"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600">Ganti Gambar (Kosongkan jika tetap)</label>
                            <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(this, 'editPreview')" style="border-radius: 10px;">
                            <img id="editPreview" class="image-preview" style="display: block;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal" style="border-radius: 10px;">Batal</button>
                    <button type="submit" class="btn btn-warning text-white px-4 shadow-sm" style="border-radius: 10px;">Update Event</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Detail Event Modal -->
<div class="modal fade" id="detailEventModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <h5 class="modal-title fw-bold"><iconify-icon icon="solar:info-circle-bold" class="me-2 align-middle text-info"></iconify-icon>Detail Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4" id="eventDetailContent">
                <!-- Data akan dimuat via JS -->
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteEventModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <h5 class="modal-title fw-bold text-danger"><iconify-icon icon="solar:danger-bold" class="me-2 align-middle"></iconify-icon>Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="bg-light-danger text-danger rounded-circle d-inline-flex p-3 mb-3">
                    <iconify-icon icon="solar:trash-bin-trash-bold" class="fs-1"></iconify-icon>
                </div>
                <h5>Apakah Anda yakin?</h5>
                <p class="text-muted">Event <strong id="deleteEventTitle"></strong> akan dihapus permanen.</p>
            </div>
            <div class="modal-footer border-0 p-4 justify-content-center">
                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal" style="border-radius: 10px;">Batal</button>
                <form id="deleteEventForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4 shadow-sm" style="border-radius: 10px;">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Image Preview
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Show Detail
function showEventDetail(id) {
    const modal = new bootstrap.Modal(document.getElementById('detailEventModal'));
    const content = document.getElementById('eventDetailContent');
    modal.show();
    
    fetch(`/mudir/event/${id}`) // Sekarang menggunakan rute mudir
        .then(res => res.json())
        .then(data => {
            const statusAdmin = data.status_admin === 'approved' ? 'success' : (data.status_admin === 'rejected' ? 'danger' : 'warning');
            const statusPimpinan = data.status_pimpinan === 'approved' ? 'success' : (data.status_pimpinan === 'rejected' ? 'danger' : 'warning');
            
            content.innerHTML = `
                <div class="modal-detail-banner elevation-1">
                    <img src="${data.image ? data.image : '{{ asset('images/event-placeholder.jpg') }}'}" alt="Event Banner">
                    <div class="modal-detail-badge">
                        <span class="badge bg-primary px-3 py-2 rounded-pill shadow-sm">${data.category}</span>
                    </div>
                </div>
                
                <div class="row px-2">
                    <div class="col-md-8">
                        <h3 class="fw-bold text-dark mb-1">${data.title}</h3>
                        <p class="text-muted mb-4 small"><iconify-icon icon="solar:clock-circle-bold" class="align-middle"></iconify-icon> Dibuat pada ${data.created_at}</p>
                        
                        <div class="mb-4">
                            <div class="info-label">Deskripsi Event</div>
                            <div class="text-dark opacity-75" style="line-height: 1.6; text-align: justify;">
                                ${data.description.replace(/\n/g, '<br>')}
                            </div>
                        </div>
                        
                        <div class="creator-box">
                            <div class="creator-avatar">
                                ${data.creator.substring(0, 1).toUpperCase()}
                            </div>
                            <div>
                                <div class="info-label" style="margin-bottom: 0;">Dikirim Oleh</div>
                                <div class="fw-bold text-dark">${data.creator}</div>
                            </div>
                            <div class="ms-auto">
                                <span class="badge bg-dark-subtle text-dark rounded-pill px-3">${data.participants_count} Peserta</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card border-0 bg-light p-3 mb-3" style="border-radius: 15px;">
                            <div class="info-label">Waktu & Lokasi</div>
                            <div class="info-value">
                                <iconify-icon icon="solar:calendar-bold"></iconify-icon>
                                <span>${new Date(data.date).toLocaleDateString('id-ID', {day:'numeric', month:'long', year:'numeric'})}</span>
                            </div>
                            <div class="info-value">
                                <iconify-icon icon="solar:clock-circle-bold"></iconify-icon>
                                <span>${data.time} WIB</span>
                            </div>
                            <div class="info-value">
                                <iconify-icon icon="solar:map-point-bold"></iconify-icon>
                                <span class="text-truncate">${data.location}</span>
                            </div>
                        </div>

                        <div class="card border-0 bg-light p-3 mb-4" style="border-radius: 15px;">
                            <div class="info-label">Status Moderasi</div>
                            <div class="d-flex flex-column gap-2 mt-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">Admin:</small>
                                    <span class="badge bg-${statusAdmin}-subtle text-${statusAdmin} border border-${statusAdmin} rounded-pill px-2" style="font-size: 0.65rem;">${data.status_admin.toUpperCase()}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">Pimpinan:</small>
                                    <span class="badge bg-${statusPimpinan}-subtle text-${statusPimpinan} border border-${statusPimpinan} rounded-pill px-2" style="font-size: 0.65rem;">${data.status_pimpinan.toUpperCase()}</span>
                                </div>
                            </div>
                        </div>

                        ${data.status_pimpinan === 'pending' ? `
                            <div class="d-grid gap-2">
                                <form action="/mudir/event/${data.id}/approve" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success w-100 d-flex align-items-center justify-content-center gap-2 py-2 shadow-sm" style="border-radius: 10px;">
                                        <iconify-icon icon="solar:check-read-bold" class="fs-5"></iconify-icon>
                                        <span>Setujui Event</span>
                                    </button>
                                </form>
                                <form action="/mudir/event/${data.id}/reject" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center gap-2 py-2" style="border-radius: 10px;">
                                        <iconify-icon icon="solar:close-circle-bold" class="fs-5"></iconify-icon>
                                        <span>Tolak Event</span>
                                    </button>
                                </form>
                            </div>
                        ` : ''}
                    </div>
                </div>
            `;
        });
}

// Edit Event
function editEvent(id) {
    fetch(`/mudir/event/${id}/edit`)
        .then(res => res.json())
        .then(data => {
            document.getElementById('edit_title').value = data.title;
            document.getElementById('edit_category').value = data.category;
            document.getElementById('edit_date').value = data.date;
            document.getElementById('edit_time').value = data.time.substring(0, 5);
            document.getElementById('edit_location').value = data.location;
            document.getElementById('edit_description').value = data.description;
            
            const preview = document.getElementById('editPreview');
            if(data.image) {
                preview.src = `/storage/${data.image}`;
                preview.style.display = 'block';
            } else {
                preview.style.display = 'none';
            }

            document.getElementById('editEventForm').action = `/mudir/event/${id}`;
            const modal = new bootstrap.Modal(document.getElementById('editEventModal'));
            modal.show();
        });
}

// Confirm Delete
function confirmDelete(id, title) {
    document.getElementById('deleteEventTitle').textContent = title;
    document.getElementById('deleteEventForm').action = `/mudir/event/${id}`;
    const modal = new bootstrap.Modal(document.getElementById('deleteEventModal'));
    modal.show();
}
</script>
@endpush
