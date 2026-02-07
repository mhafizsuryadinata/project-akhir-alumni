@extends('alumni-master')

@section('alumni')
<!-- FullCalendar CSS -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />

<section class="hero mb-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1>Kalender Event</h1>
                <p>Pantau semua agenda dan kegiatan alumni dalam satu tampilan kalender</p>
            </div>
            <a href="{{ route('event') }}" class="btn btn-light" style="position: relative; z-index: 10;">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
            </a>
        </div>
    </div>
</section>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 fade-in">
                <div class="card-body p-4">
                    <div id='calendar'></div>
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
                <h5 class="modal-title" id="modalTitle">Detail Event</h5>
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
                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- FullCalendar JS -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/id.js'></script>

<style>
    #calendar {
        min-height: 600px;
    }
    .fc-event {
        cursor: pointer;
        padding: 2px 4px;
        border-radius: 4px;
        border: none;
    }
    .fc-toolbar-title {
        font-size: 1.5rem !important;
        font-weight: 700;
        color: var(--primary-blue);
    }
    .fc-button-primary {
        background-color: var(--primary-blue) !important;
        border-color: var(--primary-blue) !important;
    }
    #modalImageContainer img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'id',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listMonth'
        },
        events: "{{ route('api.events') }}",
        eventClick: function(info) {
            const event = info.event;
            const props = event.extendedProps;
            
            // Set modal content
            document.getElementById('modalEventTitle').innerText = event.title;
            document.getElementById('modalCategory').innerText = props.category;
            document.getElementById('modalLocation').innerText = props.location;
            document.getElementById('modalTime').innerText = props.time + ' WIB';
            document.getElementById('modalDate').innerText = event.start.toLocaleDateString('id-ID', { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });
            document.getElementById('modalDescription').innerText = props.description;
            
            // Status badge
            const statusBadge = document.getElementById('modalStatus');
            statusBadge.innerText = props.status.toUpperCase();
            statusBadge.className = 'badge ' + (props.status === 'upcoming' ? 'bg-success' : 'bg-secondary');
            
            // Image
            const imgContainer = document.getElementById('modalImageContainer');
            if (props.image) {
                imgContainer.innerHTML = `<img src="${props.image}" alt="${event.title}">`;
            } else {
                imgContainer.innerHTML = '';
            }
            
            // Show modal
            var myModal = new bootstrap.Modal(document.getElementById('eventDetailModal'));
            myModal.show();
        },
        eventMouseEnter: function(info) {
            info.el.style.opacity = '0.8';
        },
        eventMouseLeave: function(info) {
            info.el.style.opacity = '1';
        }
    });
    calendar.render();
});
</script>
@endsection
