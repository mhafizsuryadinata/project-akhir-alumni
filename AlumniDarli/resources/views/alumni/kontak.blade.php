@extends('alumni-master')

@section('alumni')
<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <h1>Kontak & Bantuan</h1>
        <p>Hubungi kami untuk informasi lebih lanjut atau bantuan teknis</p>
        <div class="mt-4">
            <span class="badge bg-light text-primary me-2"><i class="fas fa-phone me-1"></i> (021) 1234-5678</span>
            <span class="badge bg-light text-primary me-2"><i class="fas fa-envelope me-1"></i> info@darli.ac.id</span>
            <span class="badge bg-light text-primary"><i class="fas fa-map-marker-alt me-1"></i> Payakumbuh</span>
        </div>
    </div>
</section>

<div class="row g-4">
    <!-- Contact Information -->
    <div class="col-lg-4">
        <div class="card fade-in">
            <div class="card-header">
                <div><i class="fas fa-info-circle me-2"></i>Informasi Kontak</div>
            </div>
            <div class="card-body">
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-map-marker-alt text-white"></i>
                    </div>
                    <div class="info-content">
                        <h6>Alamat</h6>
                        <p>Jl. Singa Harau No. 87, Balai Panjang, Payakumbuh Selatan, Kota Payakumbuh, Sumatera Barat</p>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-phone text-white"></i>
                    </div>
                    <div class="info-content">
                        <h6>Telepon</h6>
                        <p>(021) 1234-5678<br>(021) 8765-4321</p>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-envelope text-white"></i>
                    </div>
                    <div class="info-content">
                        <h6>Email</h6>
                        <p>info@darli.ac.id<br>alumni@darli.ac.id</p>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-clock text-white"></i>
                    </div>
                    <div class="info-content">
                        <h6>Jam Operasional</h6>
                        <p>Senin - Jumat: 08:00 - 17:00 WIB<br>Sabtu: 08:00 - 14:00 WIB</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Form -->
    <div class="col-lg-8">
        <div class="card fade-in">
            <div class="card-header">
                <div><i class="fas fa-paper-plane me-2"></i>Kirim Pesan</div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

               <form action="{{ route('kontak.kirim') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->nama ?? '' }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="{{ Auth::user()->email ?? '' }}" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Subjek</label>
                        <select class="form-select" name="subject" required>
                            <option value="" selected>Pilih subjek...</option>
                            <option value="Informasi Alumni">Informasi Alumni</option>
                            <option value="Bantuan Teknis">Bantuan Teknis</option>
                            <option value="Event & Kegiatan">Event & Kegiatan</option>
                            <option value="Lowongan Kerja">Lowongan Kerja</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pesan</label>
                        <textarea class="form-control" name="message" rows="6" placeholder="Tulis pesan Anda di sini..." required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Lampiran (Opsional)</label>
                        <input type="file" class="form-control" name="attachment">
                        <div class="form-text">Format: PDF, DOC, JPG, PNG. Maksimal 5MB.</div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="reset" class="btn btn-outline-secondary">Reset</button>~
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i>Kirim Pesan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- Support Team -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card fade-in">
            <div class="card-header">
                <div><i class="fas fa-headset me-2"></i>Tim Dukungan Alumni</div>
            </div>
            <div class="card-body">
                <div class="row g-4 team-container collapsed" id="teamContainer">
                    @forelse($ustadz as $index => $u)
                    <div class="col-md-4 team-item">
                        <div class="text-center">
                            @if($u->foto)
                                <div class="ustadz-avatar mx-auto mb-3" style="width: 80px; height: 80px; overflow: hidden; border-radius: 50%;">
                                    <img src="{{ asset('storage/' . $u->foto) }}" alt="{{ $u->nama }}" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                            @else
                                <div class="ustadz-avatar mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background-color: var(--primary-blue); border-radius: 50%;">
                                    <i class="fas fa-user-tie fs-4 text-white"></i>
                                </div>
                            @endif
                            <h5>{{ $u->nama }}</h5>
                            <p class="text-muted">{{ $u->jabatan }} @if($u->bidang) ({{ $u->bidang }}) @endif</p>
                            <div class="d-flex justify-content-center gap-2">
                                @if($u->email)
                                <a href="mailto:{{ $u->email }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-envelope"></i>
                                </a>
                                @endif
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $u->no_hp) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center text-muted">
                        <p>Belum ada data tim dukungan.</p>
                    </div>
                @endforelse
                </div>

                @if(count($ustadz) > 3)
                <div class="text-center mt-4">
                    <button class="btn btn-outline-primary" id="toggleTeamBtn" onclick="toggleTeam()">
                        <i class="fas fa-chevron-down me-1"></i> Lihat Seluruhnya
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- FAQ & Bantuan Section -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card fade-in">
            <div class="card-header">
                <div><i class="fas fa-question-circle me-2"></i>Pertanyaan Umum (FAQ)</div>
            </div>
            <div class="card-body">
                <div class="accordion" id="faqAccordion">
                    @forelse($faqs as $faq)
                    <div class="accordion-item mb-2 border-0 shadow-sm">
                        <h2 class="accordion-header" id="heading{{ $faq->id }}">
                            <button class="accordion-button collapsed rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->id }}" aria-expanded="false" aria-controls="collapse{{ $faq->id }}">
                                <i class="fas fa-info-circle me-2 text-primary"></i> {{ $faq->question }}
                            </button>
                        </h2>
                        <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $faq->id }}" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                {!! nl2br(e($faq->answer)) !!}
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4 text-muted">
                        <p>Belum ada FAQ yang tersedia.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Riwayat Pesan Section -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card fade-in">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-history me-2"></i>Riwayat Pesan Anda</span>
                <span class="badge bg-primary">{{ count($my_messages) }} Pesan</span>
            </div>
            <div class="card-body">
                <div class="accordion" id="messageAccordion">
                    @forelse($my_messages as $m)
                    <div class="accordion-item mb-3 border shadow-sm rounded">
                        <h2 class="accordion-header" id="msgHeading{{ $m->id }}">
                            <button class="accordion-button collapsed py-3" type="button" data-bs-toggle="collapse" data-bs-target="#msgCollapse{{ $m->id }}">
                                <div class="d-flex justify-content-between align-items-center w-100 me-3">
                                    <div>
                                        <span class="fw-bold">{{ $m->subject }}</span>
                                        <br>
                                        <small class="text-muted">{{ $m->created_at ? $m->created_at->format('d M Y H:i') : '-' }}</small>
                                    </div>
                                    <div>
                                        @if($m->admin_reply)
                                            <span class="badge bg-success">Sudah Dibalas</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Menunggu Balasan</span>
                                        @endif
                                    </div>
                                </div>
                            </button>
                        </h2>
                        <div id="msgCollapse{{ $m->id }}" class="accordion-collapse collapse" data-bs-parent="#messageAccordion">
                            <div class="accordion-body">
                                <div class="message-content p-3 bg-light rounded mb-3">
                                    <h6 class="fw-bold mb-2">Pesan Anda:</h6>
                                    <p class="mb-0 text-muted">{{ $m->message }}</p>
                                    @if($m->attachment)
                                    <div class="mt-2 text-end">
                                        <a href="{{ asset('storage/' . $m->attachment) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-paperclip me-1"></i> Lampiran
                                        </a>
                                    </div>
                                    @endif
                                </div>

                                @if($m->admin_reply)
                                <div class="reply-content p-3 border-start border-4 border-success bg-success bg-opacity-10 rounded">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="fw-bold text-success mb-0"><i class="fas fa-reply me-1 text-success"></i> Balasan Admin:</h6>
                                        <small class="text-muted">{{ $m->replied_at ? $m->replied_at->format('d M Y H:i') : '-' }}</small>
                                    </div>
                                    <p class="mb-0">{{ $m->admin_reply }}</p>
                                </div>
                                @else
                                <div class="p-3 text-center text-muted italic">
                                    <i class="fas fa-hourglass-half me-2"></i> Belum ada balasan dari admin.
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-envelope-open fs-1 mb-3"></i>
                        <p>Anda belum pernah mengirim pesan.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .accordion-button {
        font-weight: 500;
        background-color: var(--light-gray);
        border: 1px solid var(--medium-gray);
    }
    
    .accordion-button:not(.collapsed) {
        background-color: var(--light-blue);
        color: var(--primary-blue);
        border-color: var(--primary-blue);
    }
    
    .accordion-button:focus {
        box-shadow: 0 0 0 0.25rem rgba(26, 115, 232, 0.25);
        border-color: var(--primary-blue);
    }

    .team-container.collapsed .team-item:nth-child(n+4) {
        display: none;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const resetBtn = document.querySelector('button[type="reset"]');
        if(resetBtn) {
            resetBtn.addEventListener('click', function() {
                // Clear any manual resets if needed
            });
        }
    });

    function toggleTeam() {
        const container = document.getElementById('teamContainer');
        const btn = document.getElementById('toggleTeamBtn');
        const isCollapsed = container.classList.contains('collapsed');
        
        if (isCollapsed) {
            container.classList.remove('collapsed');
            btn.innerHTML = '<i class="fas fa-chevron-up me-1"></i> Tampilkan Lebih Sedikit';
        } else {
            container.classList.add('collapsed');
            btn.innerHTML = '<i class="fas fa-chevron-down me-1"></i> Lihat Seluruhnya';
        }
    }
</script>
@endsection