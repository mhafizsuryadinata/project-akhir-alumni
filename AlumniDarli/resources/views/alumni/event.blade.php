@extends('alumni-master')

@section('alumni')
<section class="hero">
    <div class="container">
        <h1>Event & Kegiatan Alumni</h1>
        <p>Temukan dan ikuti berbagai event menarik untuk mempererat silaturahmi antar alumni</p>
        <div class="mt-4">
            <span class="badge bg-light text-primary me-2"><i class="fas fa-calendar me-1"></i> {{ $stats['upcoming'] ?? 0 }} Event Mendatang</span>
            <span class="badge bg-light text-primary me-2"><i class="fas fa-check-circle me-1"></i> {{ $stats['finished'] ?? 0 }} Selesai</span>
            <span class="badge bg-light text-primary"><i class="fas fa-calendar-alt me-1"></i> {{ $events->count() }} Total Event</span>
        </div>
    </div>
</section>

<!-- Filter -->
<div class="card mb-4 fade-in">
    <div class="card-body">
        <div class="row g-3 align-items-center">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Cari event...">
                </div>
            </div>
            <div class="col-md-3">
                <select id="categoryFilter" class="form-select">
                    <option value="">Semua Kategori</option>
                    <option value="Reuni">Reuni</option>
                    <option value="Seminar">Seminar</option>
                    <option value="Workshop">Workshop</option>
                    <option value="Bakti Sosial">Bakti Sosial</option>
                </select>
            </div>
            <div class="col-md-3">
                <select id="statusFilter" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="Upcoming">Upcoming</option>
                    <option value="Finished">Finished</option>
                </select>
            </div>
            <div class="col-md-2">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="hideFinishedToggle">
                    <label class="form-check-label small fw-bold text-muted" for="hideFinishedToggle">Sembunyikan Terlaksana</label>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-triangle me-2"></i>
    @if($errors->has('error'))
        {{ $errors->first('error') }}
    @else
        Ada kesalahan pada input. Silakan cek kembali form.
        <ul class="mb-0 mt-2 small">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row g-4">
    <!-- Konten Event -->
    <div class="col-lg-9">
        <div class="row g-4" id="eventList">
            @forelse($events as $event)
            @php
                $eventDateTime = \Carbon\Carbon::parse($event->date . ' ' . $event->time);
                $isUpcoming = $eventDateTime > now();
            @endphp
            <div class="col-md-4 event-item" 
                 data-title="{{ strtolower($event->title) }}" 
                 data-category="{{ $event->category }}" 
                 data-status="{{ $isUpcoming ? 'upcoming' : 'finished' }}">
                <div class="card event-card fade-in h-100">
                    <div class="position-relative">
                        @if($event->image)
                            <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top" alt="{{ $event->title }}" style="height:180px;object-fit:cover;">
                        @else
                            <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80" 
                                 class="card-img-top" alt="{{ $event->title }}" style="height:180px;object-fit:cover;">
                        @endif
                        <div class="position-absolute top-0 start-0 m-2">
                            <span class="badge bg-primary">{{ date('d M', strtotime($event->date)) }}</span>
                        </div>
                        <div class="position-absolute top-0 end-0 m-2">
                            @if($isUpcoming)
                                <span class="badge bg-success">Upcoming</span>
                            @else
                                <span class="badge bg-secondary">Finished</span>
                            @endif
                        </div>
                        @if($event->user_id == (auth()->check() ? auth()->user()->id_user : 0) && ($event->status_admin != 'approved' || $event->status_pimpinan != 'approved'))
                            <div class="position-absolute bottom-0 start-0 m-2">
                                <span class="badge {{ $event->status_admin == 'approved' && $event->status_pimpinan == 'pending' ? 'bg-info' : ($event->status_admin == 'rejected' || $event->status_pimpinan == 'rejected' ? 'bg-danger' : 'bg-warning text-dark') }}" style="font-size: 0.65rem;">
                                    <i class="fas fa-clock me-1"></i>
                                    @if($event->status_admin == 'rejected' || $event->status_pimpinan == 'rejected')
                                        DITOLAK
                                    @elseif($event->status_admin == 'approved')
                                        MENUNGGU PIMPINAN
                                    @else
                                        MENUNGGU ADMIN
                                    @endif
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <span class="badge bg-light text-primary mb-2">{{ $event->category }}</span>
                        <h6 class="card-title">{{ $event->title }}</h6>
                        <p class="card-text text-muted small">{{ Str::limit($event->description, 60) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted"><i class="fas fa-map-marker-alt me-1"></i>{{ Str::limit($event->location, 15) }}</small>
                            <small class="text-muted"><i class="fas fa-clock me-1"></i>{{ date('H:i', strtotime($event->time)) }}</small>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-primary btn-sm flex-grow-1"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#eventDetailModal"
                                    data-title="{{ $event->title }}"
                                    data-category="{{ $event->category }}"
                                    data-date="{{ $event->date }}"
                                    data-time="{{ date('H:i', strtotime($event->time)) }}"
                                    data-location="{{ $event->location }}"
                                    data-description="{{ $event->description }}"
                                    data-status="{{ $isUpcoming ? 'upcoming' : 'finished' }}"
                                    data-image="{{ $event->image ? asset('storage/' . $event->image) : '' }}"
                                    data-id="{{ $event->id }}"
                                    data-owner-id="{{ $event->user_id }}"
                                    onclick="showEventDetail(this)">
                                <i class="fas fa-info-circle me-1"></i>Detail
                            </button>
                            @if($isUpcoming)
                                @php
                                    $isRegistered = \App\Models\Event::find($event->id)->participants()->where('event_user.user_id', auth()->user()->id_user)->exists();
                                @endphp
                                @if($isRegistered)
                                    <button class="btn btn-secondary btn-sm" disabled>
                                        <i class="fas fa-check-circle me-1"></i> Terdaftar
                                    </button>
                                @else
                                    <form action="{{ route('event.join', $event->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin mendaftar event ini?')">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fas fa-user-plus me-1"></i> Daftar
                                        </button>
                                    </form>
                                @endif
                            @endif
                            @if($event->user_id == (auth()->check() ? auth()->user()->id_user : 0) || auth()->user()->role == 'admin')
                                <form action="{{ route('event.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Hapus event ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12" id="noEventMessage">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-2"></i>
                    Belum ada event tersedia. <a href="#" data-bs-toggle="modal" data-bs-target="#createEventModal">Buat event baru</a>
                </div>
            </div>
            @endforelse
            
            <!-- Message for no filter results -->
            <div class="col-12 d-none" id="noFilterResult">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-2"></i>
                    Tidak ada event yang sesuai dengan filter yang dipilih.
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-3">
        <div class="card fade-in">
            <div class="card-header">
                <i class="fas fa-bolt me-2"></i>Aksi Cepat
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-primary text-start" data-bs-toggle="modal" data-bs-target="#createEventModal">
                        <i class="fas fa-plus me-2"></i>Buat Event Baru
                    </button>
                    <a href="{{ route('event.kalender') }}" class="btn btn-outline-primary text-start">
                        <i class="fas fa-calendar-alt me-2"></i>Kalender Saya
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Event Modal -->
<div class="modal fade" id="createEventModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white border-0">
                <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i>Buat Event Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="createEventForm" action="{{ route('event.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted">Nama Event</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" placeholder="Contoh: Reuni Akbar 2024" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted">Kategori</label>
                            <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                                <option value="">Pilih kategori</option>
                                <option value="Reuni" {{ old('category') == 'Reuni' ? 'selected' : '' }}>Reuni</option>
                                <option value="Seminar" {{ old('category') == 'Seminar' ? 'selected' : '' }}>Seminar</option>
                                <option value="Workshop" {{ old('category') == 'Workshop' ? 'selected' : '' }}>Workshop</option>
                                <option value="Bakti Sosial" {{ old('category') == 'Bakti Sosial' ? 'selected' : '' }}>Bakti Sosial</option>
                                <option value="Lainnya" {{ old('category') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted">Tanggal</label>
                            <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date') }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted">Waktu</label>
                            <input type="time" name="time" class="form-control @error('time') is-invalid @enderror" value="{{ old('time') }}" required>
                            @error('time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Lokasi</label>
                        <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" placeholder="Masukkan lokasi" value="{{ old('location') }}" required>
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Deskripsi</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="Jelaskan detail event..." required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Gambar Event</label>
                        <input name="image" class="form-control @error('image') is-invalid @enderror" type="file" accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text mt-1">Maksimal 2MB (JPEG, PNG, JPG).</div>
                    </div>

                    <div class="modal-footer border-0 p-0 pt-3">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-check me-1"></i>Simpan Event
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Event Modal -->
<div class="modal fade" id="editEventModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white border-0">
                <h5 class="modal-title fw-bold text-white"><i class="fas fa-edit me-2"></i>Edit Event</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div id="editImagePreviewContainer"></div>
                <div class="p-4">
                    <form id="editEventForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted">Nama Event</label>
                            <input type="text" name="title" id="editTitle" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted">Kategori</label>
                            <select name="category" id="editCategory" class="form-select" required>
                                <option value="Reuni">Reuni</option>
                                <option value="Seminar">Seminar</option>
                                <option value="Workshop">Workshop</option>
                                <option value="Bakti Sosial">Bakti Sosial</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted">Tanggal</label>
                            <input type="date" name="date" id="editDate" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted">Waktu</label>
                            <input type="time" name="time" id="editTime" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Lokasi</label>
                        <input type="text" name="location" id="editLocation" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Deskripsi</label>
                        <textarea name="description" id="editDescription" class="form-control" rows="4" required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Gambar Event (Opsional)</label>
                        <input name="image" class="form-control" type="file" accept="image/*">
                        <div class="form-text mt-1">Biarkan kosong jika tidak ingin mengubah gambar.</div>
                    </div>

                    <div class="modal-footer border-0 p-0 pt-3">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">
                            <i class="fas fa-save me-1"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Event Detail Modal -->
<div class="modal fade" id="eventDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white border-0">
                <h5 class="modal-title">Detail Event</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div id="modalImageContainer"></div>
                <div class="p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <span id="modalCategory" class="badge bg-light text-primary mb-2"></span>
                            <h4 id="modalEventTitle" class="mb-0"></h4>
                        </div>
                        <span id="modalStatus" class="badge"></span>
                    </div>
                    
                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <div class="d-flex align-items-center text-muted">
                                <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                <span id="modalDate"></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center text-muted">
                                <i class="fas fa-clock me-2 text-primary"></i>
                                <span id="modalTime"></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center text-muted">
                                <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                <span id="modalLocation"></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-0">
                        <h6 class="fw-bold mb-2">Deskripsi</h6>
                        <p id="modalDescription" class="text-muted mb-0 text-break" style="white-space: pre-line"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 p-3">
                <button type="button" id="modalEditBtn" class="btn btn-warning px-4 d-none" 
                        data-bs-toggle="modal" data-bs-target="#editEventModal"
                        onclick="prepareEditFromDetail()">
                    <i class="fas fa-edit me-1"></i>Edit
                </button>
                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<style>
.event-card { transition: all .3s ease; }
.event-card:hover { transform: translateY(-5px); }
#modalImageContainer img, #editImagePreviewContainer img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}
</style>

<script>
    function showEventDetail(button) {
        const data = button.dataset;
        
        document.getElementById('modalEventTitle').innerText = data.title;
        document.getElementById('modalCategory').innerText = data.category;
        
        // Format date to Indonesian
        const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const eventDate = new Date(data.date);
        document.getElementById('modalDate').innerText = eventDate.toLocaleDateString('id-ID', dateOptions);
        
        document.getElementById('modalTime').innerText = data.time + ' WIB';
        document.getElementById('modalLocation').innerText = data.location;
        document.getElementById('modalDescription').innerText = data.description;
        
        // Status badge
        const statusBadge = document.getElementById('modalStatus');
        statusBadge.innerText = data.status.toUpperCase();
        statusBadge.className = 'badge ' + (data.status === 'upcoming' ? 'bg-success' : 'bg-secondary');
        
        // Image
        const imgContainer = document.getElementById('modalImageContainer');
        if (data.image) {
            imgContainer.innerHTML = `<img src="${data.image}" alt="${data.title}">`;
        } else {
            imgContainer.innerHTML = '';
        }

        // Show/Hide Edit button based on ownership
        const editBtn = document.getElementById('modalEditBtn');
        const currentUserId = "{{ auth()->user()->id_user }}";
        const isAdmin = {{ auth()->user()->role === 'admin' ? 'true' : 'false' }};
        
        if (data.ownerId == currentUserId || isAdmin) {
            editBtn.classList.remove('d-none');
            // Store data for editing
            editBtn.dataset.id = data.id;
            editBtn.dataset.title = data.title;
            editBtn.dataset.category = data.category;
            editBtn.dataset.date = data.date;
            editBtn.dataset.time = data.time;
            editBtn.dataset.location = data.location;
            editBtn.dataset.description = data.description;
            editBtn.dataset.image = data.image;
        } else {
            editBtn.classList.add('d-none');
        }
    }

    function prepareEditFromDetail() {
        const detailEditBtn = document.getElementById('modalEditBtn');
        const editModalBtn = document.createElement('button');
        editModalBtn.dataset.id = detailEditBtn.dataset.id;
        editModalBtn.dataset.title = detailEditBtn.dataset.title;
        editModalBtn.dataset.category = detailEditBtn.dataset.category;
        editModalBtn.dataset.date = detailEditBtn.dataset.date;
        editModalBtn.dataset.time = detailEditBtn.dataset.time;
        editModalBtn.dataset.location = detailEditBtn.dataset.location;
        editModalBtn.dataset.description = detailEditBtn.dataset.description;
        editModalBtn.dataset.image = detailEditBtn.dataset.image;
        
        showEditEvent(editModalBtn);
    }

    function showEditEvent(button) {
        const data = button.dataset;
        const form = document.getElementById('editEventForm');
        
        // Set action URL
        form.action = `/event/${data.id}`;
        
        // Fill data
        document.getElementById('editTitle').value = data.title;
        document.getElementById('editCategory').value = data.category;
        document.getElementById('editDate').value = data.date;
        document.getElementById('editTime').value = data.time;
        document.getElementById('editLocation').value = data.location;
        document.getElementById('editDescription').value = data.description;

        // Image Preview
        const previewContainer = document.getElementById('editImagePreviewContainer');
        if (data.image) {
            previewContainer.innerHTML = `<img src="${data.image}" alt="${data.title}">`;
        } else {
            previewContainer.innerHTML = '';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        @if($errors->any())
            const createModal = new bootstrap.Modal(document.getElementById('createEventModal'));
            createModal.show();
        @endif

        // Client-side filtering
        const searchInput = document.getElementById('searchInput');
        const categoryFilter = document.getElementById('categoryFilter');
        const statusFilter = document.getElementById('statusFilter');
        const hideFinishedToggle = document.getElementById('hideFinishedToggle');
        const eventItems = document.querySelectorAll('.event-item');
        const noFilterResult = document.getElementById('noFilterResult');
        const noEventMessage = document.getElementById('noEventMessage');

        function filterEvents() {
            const searchValue = searchInput.value.toLowerCase();
            const categoryValue = categoryFilter.value;
            const statusValue = statusFilter.value.toLowerCase(); // upcoming/finished
            const hideFinished = hideFinishedToggle.checked;

            let visibleCount = 0;

            eventItems.forEach(item => {
                const title = item.dataset.title.toLowerCase();
                const category = item.dataset.category;
                const status = item.dataset.status; // upcoming/finished

                const matchSearch = title.includes(searchValue);
                const matchCategory = categoryValue === "" || category === categoryValue;
                const matchStatus = statusValue === "" || status === statusValue;
                const matchHideFinished = !hideFinished || status !== 'finished';

                if (matchSearch && matchCategory && matchStatus && matchHideFinished) {
                    item.style.display = ""; // Show
                    visibleCount++;
                } else {
                    item.style.display = "none"; // Hide
                }
            });

            // Show/hide 'no result' message
            if (visibleCount === 0 && eventItems.length > 0) {
                // If we have items but none match filter
                if (noFilterResult) noFilterResult.classList.remove('d-none');
            } else {
                if (noFilterResult) noFilterResult.classList.add('d-none');
            }
        }

        if (searchInput) {
            searchInput.addEventListener('input', filterEvents);
            categoryFilter.addEventListener('change', filterEvents);
            statusFilter.addEventListener('change', filterEvents);
            hideFinishedToggle.addEventListener('change', filterEvents);
        }
    });
</script>
@endsection