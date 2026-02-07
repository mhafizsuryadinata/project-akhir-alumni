@extends('admin-master')

@section('judul', 'Pengelolaan Event')

@push('styles')
<style>
    :root {
        --primary-blue: #1a73e8;
        --secondary-blue: #4285f4;
        --dark-blue: #1557b0;
        --success-green: #28a745;
        --warning-yellow: #ffc107;
        --danger-red: #dc3545;
        --info-cyan: #17a2b8;
        --light-gray: #f8f9fa;
        --medium-gray: #e9ecef;
        --dark-gray: #6c757d;
        --white: #ffffff;
        --shadow: 0 4px 20px rgba(26, 115, 232, 0.1);
        --shadow-hover: 0 8px 30px rgba(26, 115, 232, 0.15);
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Hero Section - Matching page-hero theme */
    .hero-event {
        background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
        color: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        margin-bottom: 2rem;
        box-shadow: 0 15px 35px rgba(15, 12, 41, 0.2);
        position: relative;
        overflow: hidden;
    }

    .hero-event h1 {
        font-weight: 800;
        font-size: 1.5rem;
        margin-bottom: 0.25rem;
    }

    .hero-event p {
        font-size: 0.9rem;
        opacity: 0.75;
    }

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: var(--white);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        box-shadow: var(--shadow);
        transition: var(--transition);
        border-left: 5px solid;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-hover);
    }

    .stat-card.total { border-left-color: var(--primary-blue); }
    .stat-card.upcoming { border-left-color: var(--success-green); }
    .stat-card.past { border-left-color: var(--dark-gray); }

    .stat-card .icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }

    .stat-card.total .icon { background: rgba(26, 115, 232, 0.1); color: var(--primary-blue); }
    .stat-card.upcoming .icon { background: rgba(40, 167, 69, 0.1); color: var(--success-green); }
    .stat-card.past .icon { background: rgba(108, 117, 125, 0.1); color: var(--dark-gray); }

    .stat-card .number {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .stat-card .label {
        font-size: 0.875rem;
        color: var(--dark-gray);
        font-weight: 500;
    }

    /* Filter Section */
    .filter-section {
        background: var(--white);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow);
    }

    .filter-group {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        align-items: center;
    }

    .filter-group .form-control,
    .filter-group .form-select {
        border: 2px solid var(--medium-gray);
        border-radius: 10px;
        padding: 0.85rem 1.2rem;
        transition: var(--transition);
        font-size: 1rem;
        min-height: 50px;
        display: flex;
        align-items: center;
    }

    .filter-group .form-select {
        padding-right: 2.5rem; /* Space for arrow */
    }

    .filter-group .form-control:focus,
    .filter-group .form-select:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 0.25rem rgba(26, 115, 232, 0.15);
    }

    /* Table */
    .table-container {
        background: var(--white);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        box-shadow: var(--shadow);
    }

    .table-event {
        margin-bottom: 0;
    }

    .table-event thead th {
        background: var(--light-gray);
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.8px;
        color: #444;
        border: none;
        padding: 1rem;
    }

    .table-event tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-color: var(--medium-gray);
    }

    .table-event tbody tr {
        transition: var(--transition);
    }

    .table-event tbody tr:hover {
        background: rgba(26, 115, 232, 0.02);
    }

    /* Badges */
    .badge-category {
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.75rem;
    }

    .badge-status {
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.75rem;
    }

    .badge-upcoming {
        background: rgba(40, 167, 69, 0.1);
        color: var(--success-green);
    }

    .badge-past {
        background: rgba(108, 117, 125, 0.1);
        color: var(--dark-gray);
    }

    /* Buttons */
    .btn-primary-custom {
        background: var(--primary-blue);
        border: none;
        border-radius: 10px;
        padding: 0.6rem 1.5rem;
        font-weight: 600;
        color: var(--white);
        transition: var(--transition);
    }

    .btn-primary-custom:hover {
        background: var(--dark-blue);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(26, 115, 232, 0.3);
    }

    .btn-action {
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-size: 0.875rem;
        transition: var(--transition);
        border: none;
    }

    .btn-action:hover {
        transform: scale(1.05);
    }

    /* Modal Enhancements */
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

    .modal-header .btn-close {
        filter: brightness(0) invert(1);
    }

    .modal-body {
        padding: 2rem;
    }

    .form-label {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #333;
    }

    .form-control, .form-select, textarea {
        border: 2px solid var(--medium-gray);
        border-radius: 10px;
        transition: var(--transition);
        min-height: 50px; /* Ensure sufficient height */
        font-size: 1rem;
    }

    .form-control, textarea {
        padding: 0.85rem 1.2rem;
    }

    .form-select {
        /* Reset default appearance for consistency */
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        
        /* Custom styling with arrow */
        padding: 0.85rem 2.5rem 0.85rem 1.2rem;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 1.2rem center;
        background-size: 16px 12px;
        line-height: 1.5;
    }

    textarea {
        min-height: 120px; /* Taller for textarea */
    }

    .form-control:focus, .form-select:focus, textarea:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 0.25rem rgba(26, 115, 232, 0.15);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-state i {
        font-size: 4rem;
        color: var(--medium-gray);
        margin-bottom: 1rem;
    }

    .empty-state p {
        color: var(--dark-gray);
        font-size: 1rem;
    }

    /* Image Preview */
    .image-preview {
        max-width: 200px;
        max-height: 200px;
        border-radius: 10px;
        margin-top: 1rem;
        display: none;
    }

    .event-image-detail {
        max-width: 100%;
        border-radius: 10px;
        margin-top: 1rem;
    }
</style>
@endpush

@section('isi')
<!-- Hero Section -->
<section class="hero-event">
    <div class="container">
        <h1><i class="fas fa-calendar-alt me-2"></i>Pengelolaan Event</h1>
        <p>Kelola semua event, monitor peserta, dan lihat statistik event</p>
    </div>
</section>

<!-- Success/Error Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Statistics Cards -->
<div class="stats-grid">
    <div class="stat-card total">
        <div class="icon">
            <i class="fas fa-calendar-check"></i>
        </div>
        <div class="number">{{ $stats['total'] }}</div>
        <div class="label">Total Event</div>
    </div>
    <div class="stat-card upcoming">
        <div class="icon">
            <i class="fas fa-clock"></i>
        </div>
        <div class="number">{{ $stats['upcoming'] }}</div>
        <div class="label">Event Akan Datang</div>
    </div>
    <div class="stat-card past">
        <div class="icon">
            <i class="fas fa-history"></i>
        </div>
        <div class="number">{{ $stats['past'] }}</div>
        <div class="label">Event Terlaksana</div>
    </div>
</div>

<!-- Filter Section -->
<div class="filter-section">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filter & Pencarian</h5>
        <button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#createEventModal">
            <i class="fas fa-plus me-2"></i>Buat Event Baru
        </button>
    </div>
    <div class="filter-group">
        <input type="text" id="searchInput" class="form-control" placeholder="Cari event..." style="flex: 1; min-width: 200px;">
        <select id="statusFilter" class="form-select" style="min-width: 200px; flex-shrink: 0;">
            <option value="">Semua Status</option>
            <option value="upcoming">Akan Datang</option>
            <option value="past">Terlaksana</option>
        </select>
        <select id="categoryFilter" class="form-select" style="min-width: 200px; flex-shrink: 0;">
            <option value="">Semua Kategori</option>
            <option value="Reuni">Reuni</option>
            <option value="Seminar">Seminar</option>
            <option value="Workshop">Workshop</option>
            <option value="Bakti Sosial">Bakti Sosial</option>
            <option value="Lainnya">Lainnya</option>
        </select>
    </div>
</div>

<!-- Events Table -->
<div class="table-container">
    <div class="table-responsive">
        <table class="table table-event table-hover" id="eventsTable">
            <thead>
                <tr>
                    <th width="50">NO</th>
                    <th>INFO EVENT</th>
                    <th>KATEGORI</th>
                    <th>LOKASI</th>
                    <th class="text-center">PESERTA</th>
                    <th class="text-center">STATUS SISTEM</th>
                    <th class="text-center">STATUS ADMIN</th>
                    <th class="text-center">STATUS PIMPINAN</th>
                    <th class="text-center" width="220">AKSI</th>
                </tr>
            </thead>
            <tbody id="eventTableBody">
                @forelse($events as $event)
                @php
                    $now = now();
                    $eventDateTime = \Carbon\Carbon::parse($event->date . ' ' . $event->time);
                    $isUpcoming = $eventDateTime->isFuture();
                    
                    // Category color mapping
                    $categoryColors = [
                        'Reuni' => 'bg-success',
                        'Seminar' => 'bg-primary',
                        'Workshop' => 'bg-warning text-dark',
                        'Bakti Sosial' => 'bg-danger',
                        'Lainnya' => 'bg-secondary'
                    ];
                    $categoryColor = $categoryColors[$event->category] ?? 'bg-info';
                @endphp
                <tr data-status="{{ $isUpcoming ? 'upcoming' : 'past' }}" data-category="{{ $event->category }}" data-title="{{ strtolower($event->title) }}">
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>
                        <h6 class="fw-bold mb-1">{{ $event->title }}</h6>
                        <small class="text-muted">
                            <i class="far fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}
                            <i class="far fa-clock ms-2 me-1"></i>{{ \Carbon\Carbon::parse($event->time)->format('H:i') }}
                        </small>
                    </td>
                    <td>
                        <span class="badge {{ $categoryColor }} badge-category">{{ $event->category }}</span>
                    </td>
                    <td>
                        <i class="fas fa-map-marker-alt me-1 text-muted"></i>{{ $event->location }}
                    </td>
                    <td class="text-center">
                        <span class="badge bg-dark rounded-pill">{{ $event->participants->count() }}</span>
                    </td>
                    <td class="text-center">
                        <span class="badge badge-status {{ $isUpcoming ? 'badge-upcoming' : 'badge-past' }}">
                            {{ $isUpcoming ? 'Akan Datang' : 'Terlaksana' }}
                        </span>
                    </td>
                    <td class="text-center">
                        <span class="badge {{ $event->status_admin == 'approved' ? 'bg-success' : ($event->status_admin == 'rejected' ? 'bg-danger' : 'bg-warning text-dark') }}" style="font-size: 0.7rem;">
                            {{ strtoupper($event->status_admin) }}
                        </span>
                    </td>
                    <td class="text-center">
                        <span class="badge {{ $event->status_pimpinan == 'approved' ? 'bg-success' : ($event->status_pimpinan == 'rejected' ? 'bg-danger' : 'bg-warning text-dark') }}" style="font-size: 0.7rem;">
                            {{ strtoupper($event->status_pimpinan) }}
                        </span>
                    </td>
                    <td class="text-center">
                        <div class="mb-2">
                            <button class="btn btn-sm btn-info btn-action text-white" onclick="showEventDetail({{ $event->id }})" title="Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            @if($event->status_admin == 'pending')
                                <form action="{{ route('admin.event.approve', $event->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success btn-action" title="Setujui Admin">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.event.reject', $event->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-dark btn-action" title="Tolak Admin">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                        <button class="btn btn-sm btn-warning btn-action" onclick="editEvent({{ $event->id }})" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger btn-action" onclick="confirmDelete({{ $event->id }}, '{{ $event->title }}')" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                        <a href="{{ route('admin.event.pendaftar', $event->id) }}" class="btn btn-sm btn-primary btn-action" title="Lihat Peserta">
                            <i class="fas fa-users"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <i class="fas fa-calendar-times"></i>
                            <p>Belum ada event yang terdaftar</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Create Event Modal -->
<div class="modal fade" id="createEventModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i>Buat Event Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.event.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Judul Event <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select name="category" class="form-select" required>
                                <option value="">Pilih Kategori</option>
                                <option value="Reuni">Reuni</option>
                                <option value="Seminar">Seminar</option>
                                <option value="Workshop">Workshop</option>
                                <option value="Bakti Sosial">Bakti Sosial</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Lokasi <span class="text-danger">*</span></label>
                            <input type="text" name="location" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Waktu <span class="text-danger">*</span></label>
                            <input type="time" name="time" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                            <textarea name="description" class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Gambar Event</label>
                            <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(this, 'createPreview')">
                            <img id="createPreview" class="image-preview">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="fas fa-save me-2"></i>Simpan Event
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Event Modal -->
<div class="modal fade" id="editEventModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editEventForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Judul Event <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="edit_title" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select name="category" id="edit_category" class="form-select" required>
                                <option value="Reuni">Reuni</option>
                                <option value="Seminar">Seminar</option>
                                <option value="Workshop">Workshop</option>
                                <option value="Bakti Sosial">Bakti Sosial</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Lokasi <span class="text-danger">*</span></label>
                            <input type="text" name="location" id="edit_location" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="date" id="edit_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Waktu <span class="text-danger">*</span></label>
                            <input type="time" name="time" id="edit_time" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                            <textarea name="description" id="edit_description" class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Gambar Event Baru (Kosongkan jika tidak ingin mengubah)</label>
                            <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(this, 'editPreview')">
                            <img id="editPreview" class="image-preview">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="fas fa-save me-2"></i>Update Event
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Detail Event Modal -->
<div class="modal fade" id="detailEventModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-info-circle me-2"></i>Detail Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="eventDetailContent">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteEventModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter: brightness(0) invert(1);"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus event ini?</p>
                <h6 class="fw-bold" id="deleteEventTitle"></h6>
                <p class="text-muted small mb-0">Data yang dihapus tidak dapat dikembalikan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteEventForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Hapus Event
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Filter and Search Functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const categoryFilter = document.getElementById('categoryFilter');
    const tableBody = document.getElementById('eventTableBody');
    const rows = tableBody.querySelectorAll('tr[data-status]');

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value;
        const categoryValue = categoryFilter.value;

        let visibleCount = 0;

        rows.forEach(row => {
            const title = row.getAttribute('data-title');
            const status = row.getAttribute('data-status');
            const category = row.getAttribute('data-category');

            const matchesSearch = title.includes(searchTerm);
            const matchesStatus = !statusValue || status === statusValue;
            const matchesCategory = !categoryValue || category === categoryValue;

            if (matchesSearch && matchesStatus && matchesCategory) {
                row.style.display = '';
                visibleCount++;
                // Update numbering
                row.querySelector('td:first-child').textContent = visibleCount;
            } else {
                row.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('keyup', filterTable);
    statusFilter.addEventListener('change', filterTable);
    categoryFilter.addEventListener('change', filterTable);
});

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

// Show Event Detail
function showEventDetail(id) {
    const modal = new bootstrap.Modal(document.getElementById('detailEventModal'));
    const content = document.getElementById('eventDetailContent');
    
    content.innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `;
    
    modal.show();
    
    fetch(`/admin/event/${id}`)
        .then(response => response.json())
        .then(data => {
            content.innerHTML = `
                <div class="row">
                    <div class="col-md-5">
                        ${data.image ? `<img src="${data.image}" class="event-image-detail" alt="${data.title}">` : '<div class="bg-light p-5 text-center rounded"><i class="fas fa-image fa-3x text-muted"></i><p class="mt-3 text-muted">Tidak ada gambar</p></div>'}
                    </div>
                    <div class="col-md-7">
                        <h4 class="fw-bold mb-3">${data.title}</h4>
                        <div class="mb-3">
                            <span class="badge bg-primary">${data.category}</span>
                        </div>
                        <div class="mb-2">
                            <i class="far fa-calendar text-primary me-2"></i>
                            <strong>Tanggal:</strong> ${new Date(data.date).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'})}
                        </div>
                        <div class="mb-2">
                            <i class="far fa-clock text-primary me-2"></i>
                            <strong>Waktu:</strong> ${data.time}
                        </div>
                        <div class="mb-2">
                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                            <strong>Lokasi:</strong> ${data.location}
                        </div>
                        <div class="mb-2">
                            <i class="fas fa-user text-primary me-2"></i>
                            <strong>Dibuat oleh:</strong> ${data.creator}
                        </div>
                        <div class="mb-2">
                            <i class="fas fa-users text-primary me-2"></i>
                            <strong>Jumlah Peserta:</strong> ${data.participants_count} orang
                        </div>
                        <div class="mb-3">
                            <i class="far fa-calendar-plus text-primary me-2"></i>
                            <strong>Dibuat pada:</strong> ${data.created_at}
                        </div>
                        <hr>
                        <h6 class="fw-bold">Deskripsi:</h6>
                        <p>${data.description}</p>
                    </div>
                </div>
            `;
        })
        .catch(error => {
            content.innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    Gagal memuat detail event
                </div>
            `;
        });
}

// Edit Event
function editEvent(id) {
    fetch(`/admin/event/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_title').value = data.title;
            document.getElementById('edit_category').value = data.category;
            document.getElementById('edit_date').value = data.date;
            document.getElementById('edit_time').value = data.time;
            document.getElementById('edit_location').value = data.location;
            document.getElementById('edit_description').value = data.description;
            
            document.getElementById('editEventForm').action = `/admin/event/${id}`;
            document.getElementById('editPreview').style.display = 'none';
            
            const modal = new bootstrap.Modal(document.getElementById('editEventModal'));
            modal.show();
        })
        .catch(error => {
            alert('Gagal memuat data event');
        });
}

// Confirm Delete
function confirmDelete(id, title) {
    document.getElementById('deleteEventTitle').textContent = title;
    document.getElementById('deleteEventForm').action = `/admin/event/${id}`;
    
    const modal = new bootstrap.Modal(document.getElementById('deleteEventModal'));
    modal.show();
}
</script>
@endpush
