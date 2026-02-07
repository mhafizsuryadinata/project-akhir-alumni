@extends('mudir-master')

@section('content')
<!-- Hero Section -->
<section class="hero-header text-white mb-4 shadow-sm" style="border-radius: 16px; overflow: hidden;">
    <div class="p-4" style="background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="fw-800 mb-2 text-white"><i class="fas fa-comments me-2"></i>Manajemen Aspirasi Alumni</h1>
                <p class="mb-0 opacity-80">Tinjau, setujui, dan berikan respon resmi pada setiap komentar alumni</p>
            </div>
            <div class="col-md-4 text-md-end d-none d-md-block">
                <iconify-icon icon="solar:chat-round-dots-bold-duotone" class="text-white opacity-20" style="font-size: 5rem;"></iconify-icon>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Cards -->
<div class="row g-4 mb-4 fade-in">
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-left: 5px solid var(--primary-blue) !important;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="bg-light-primary p-3 rounded-circle text-primary">
                        <iconify-icon icon="solar:chat-round-dots-bold" class="fs-6"></iconify-icon>
                    </div>
                    <div class="text-end">
                        <div class="h3 fw-800 mb-0">{{ $stats['total'] }}</div>
                        <div class="text-muted small fw-600">Total Komentar</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-left: 5px solid var(--success) !important;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="bg-light-success p-3 rounded-circle text-success" style="background: rgba(40, 167, 69, 0.1);">
                        <iconify-icon icon="solar:check-read-bold" class="fs-6"></iconify-icon>
                    </div>
                    <div class="text-end">
                        <div class="h3 fw-800 mb-0 text-success">{{ $stats['approved'] }}</div>
                        <div class="text-muted small fw-600">Disetujui</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-left: 5px solid var(--warning) !important;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="bg-light-warning p-3 rounded-circle text-warning" style="background: rgba(255, 193, 7, 0.1);">
                        <iconify-icon icon="solar:hourglass-bold" class="fs-6"></iconify-icon>
                    </div>
                    <div class="text-end">
                        <div class="h3 fw-800 mb-0 text-warning">{{ $stats['pending'] }}</div>
                        <div class="text-muted small fw-600">Menunggu</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-left: 5px solid var(--danger) !important;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="bg-light-danger p-3 rounded-circle text-danger" style="background: rgba(220, 53, 69, 0.1);">
                        <iconify-icon icon="solar:close-circle-bold" class="fs-6"></iconify-icon>
                    </div>
                    <div class="text-end">
                        <div class="h3 fw-800 mb-0 text-danger">{{ $stats['rejected'] }}</div>
                        <div class="text-muted small fw-600">Ditolak</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 fade-in">
    <div class="col-12">
        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-header bg-white py-4 px-4 border-bottom border-light">
                <h5 class="mb-0 fw-700 text-dark">Daftar Komentar Alumni</h5>
            </div>
            <div class="card-body p-0">
                @if(session('success'))
                    <div class="alert alert-success border-0 mx-4 mt-4 mb-0 fade-in" role="alert" style="background: rgba(40, 167, 69, 0.1); color: #28a745;">
                        <div class="d-flex align-items-center">
                            <iconify-icon icon="solar:check-read-bold" class="fs-5 me-2"></iconify-icon>
                            <span class="fw-600">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                <div class="table-responsive mt-4">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-muted fw-700 small text-uppercase" style="letter-spacing: 1px; border: none;">Info Alumni</th>
                                <th class="py-3 text-muted fw-700 small text-uppercase" style="letter-spacing: 1px; border: none;">Komentar & Penilaian</th>
                                <th class="py-3 text-muted fw-700 small text-uppercase" style="letter-spacing: 1px; border: none;">Status Admin</th>
                                <th class="pe-4 py-3 text-muted fw-700 small text-uppercase text-center" style="letter-spacing: 1px; border: none;">Persetujuan & Respon</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($comments as $c)
                                <tr class="transition-all">
                                    <td class="ps-4 py-4">
                                        <div class="d-flex align-items-center">
                                            <div class="position-relative">
                                                @if($c->user->foto)
                                                    <img src="{{ asset('storage/' . $c->user->foto) }}" alt="user" width="55" height="55" class="rounded-4 border border-2 border-white shadow-sm" style="object-fit: cover;">
                                                @else
                                                    <div class="rounded-4 bg-light-blue d-flex align-items-center justify-content-center border border-2 border-white shadow-sm" style="width: 55px; height: 55px;">
                                                        <iconify-icon icon="solar:user-bold" class="text-primary fs-6"></iconify-icon>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="fw-800 mb-0 text-dark">{{ $c->user->nama ?? $c->user->username }}</h6>
                                                <span class="badge-soft-primary small mt-1 shadow-none" style="font-size: 0.65rem;">TAHUN {{ $c->user->tahun_masuk ?? '?' }} - {{ $c->user->tahun_tamat ?? '?' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4">
                                        <div class="d-flex align-items-center gap-1 mb-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <iconify-icon icon="solar:star-bold" 
                                                    class="{{ $i <= $c->rating ? 'text-warning' : 'text-muted opacity-20' }}" 
                                                    style="font-size: 1.2rem;"></iconify-icon>
                                            @endfor
                                        </div>
                                        <p class="mb-2 text-dark fw-500" style="font-size: 0.95rem; line-height: 1.6;">"{{ $c->content }}"</p>
                                        <div class="d-flex align-items-center text-muted gap-2" style="font-size: 0.75rem;">
                                            <iconify-icon icon="solar:calendar-linear"></iconify-icon>
                                            {{ $c->created_at->format('d F Y, H:i') }}
                                        </div>

                                        {{-- Reply Section --}}
                                        @if($c->admin_reply || $c->mudir_reply || $c->replies->count() > 0)
                                            <div class="mt-4 p-4 rounded-4 shadow-none border-0" style="background: #f9fbff; border-left: 4px solid var(--primary-blue) !important;">
                                                @if($c->admin_reply)
                                                    <div class="mb-3">
                                                        <div class="d-flex align-items-center gap-2 mb-1">
                                                            <span class="badge bg-primary px-2" style="font-size: 0.6rem;">ADMIN</span>
                                                            <small class="text-muted" style="font-size: 0.7rem;">{{ $c->admin_reply_date ? \Carbon\Carbon::parse($c->admin_reply_date)->format('d/m/Y') : '' }}</small>
                                                        </div>
                                                        <p class="mb-0 small text-dark opacity-90 fst-italic">"{{ $c->admin_reply }}"</p>
                                                    </div>
                                                @endif

                                                @if($c->mudir_reply)
                                                    <div class="mb-3">
                                                        <div class="d-flex align-items-center gap-2 mb-1">
                                                            <span class="badge bg-success px-2" style="font-size: 0.6rem;">PIMPINAN</span>
                                                            <small class="text-muted" style="font-size: 0.7rem;">{{ $c->mudir_reply_date ? \Carbon\Carbon::parse($c->mudir_reply_date)->format('d/m/Y') : '' }}</small>
                                                        </div>
                                                        <p class="mb-0 small text-dark fw-700">"{{ $c->mudir_reply }}"</p>
                                                    </div>
                                                @endif

                                                @if($c->replies->count() > 0)
                                                    <div class="mt-2 pt-2 border-top border-light">
                                                        <button class="btn btn-link btn-sm text-decoration-none p-0 d-flex align-items-center gap-2 text-primary fw-600" type="button" data-bs-toggle="collapse" data-bs-target="#replies-{{ $c->id }}">
                                                            <iconify-icon icon="solar:list-bold-duotone"></iconify-icon>
                                                            Lihat {{ $c->replies->count() }} Interaksi Alumni
                                                        </button>
                                                        <div class="collapse mt-3" id="replies-{{ $c->id }}">
                                                            @foreach($c->replies as $reply)
                                                                <div class="p-3 mb-2 bg-white rounded-3 shadow-none border border-light">
                                                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                                                        <span class="fw-800 small text-dark">{{ $reply->user->nama }}</span>
                                                                        <small class="text-muted" style="font-size: 0.65rem;">{{ $reply->created_at->format('d/m/Y') }}</small>
                                                                    </div>
                                                                    <p class="mb-0 small text-muted lh-base">{{ $reply->content }}</p>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-4">
                                        @if($c->admin_status == 'approved')
                                            <span class="badge-soft-success fw-700 d-inline-flex align-items-center gap-2">
                                                <iconify-icon icon="solar:check-read-bold" class="fs-4"></iconify-icon>
                                                DISETUJUI
                                            </span>
                                        @elseif($c->admin_status == 'rejected')
                                            <span class="badge-soft-danger fw-700 d-inline-flex align-items-center gap-2">
                                                <iconify-icon icon="solar:close-circle-bold" class="fs-4"></iconify-icon>
                                                DITOLAK
                                            </span>
                                        @else
                                            <span class="badge-soft-warning fw-700 d-inline-flex align-items-center gap-2">
                                                <iconify-icon icon="solar:hourglass-bold-duotone" class="fs-4"></iconify-icon>
                                                PENDING
                                            </span>
                                        @endif
                                    </td>
                                    <td class="pe-4 py-4 text-center">
                                        @if($c->mudir_status == 'pending')
                                            <div class="d-flex justify-content-center gap-2 mb-3">
                                                <form action="{{ route('mudir.komentar.approve', $c->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success p-3 rounded-circle shadow-sm border-0 d-flex" title="Setujui">
                                                        <iconify-icon icon="solar:check-read-bold" class="fs-4"></iconify-icon>
                                                    </button>
                                                </form>
                                                <form action="{{ route('mudir.komentar.reject', $c->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger p-3 rounded-circle shadow-sm border-0 d-flex" title="Tolak">
                                                        <iconify-icon icon="solar:close-circle-bold" class="fs-4"></iconify-icon>
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <div class="mb-3">
                                                @if($c->mudir_status == 'approved')
                                                    <span class="badge bg-success-soft text-success px-4 py-2 rounded-pill fw-800" style="background: rgba(40, 167, 69, 0.1);">Approved by You</span>
                                                @else
                                                    <span class="badge bg-danger-soft text-danger px-4 py-2 rounded-pill fw-800" style="background: rgba(220, 53, 69, 0.1);">Rejected by You</span>
                                                @endif
                                            </div>
                                        @endif
                                        
                                        <button class="btn btn-primary btn-sm w-100 py-3 d-flex align-items-center justify-content-center gap-2 fw-700 shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#reply-form-{{ $c->id }}">
                                            <iconify-icon icon="solar:pen-2-bold-duotone" class="fs-4"></iconify-icon>
                                            {{ $c->mudir_reply ? 'Ubah Respon Resmi' : 'Tulis Respon Resmi' }}
                                        </button>

                                        <div class="collapse mt-3" id="reply-form-{{ $c->id }}">
                                            <form action="{{ route('mudir.komentar.balas', $c->id) }}" method="POST" class="text-start">
                                                @csrf
                                                <div class="mb-3">
                                                    <label class="form-label small fw-700 text-muted">PESAN RESPON PIMPINAN</label>
                                                    <textarea name="balasan" class="form-control border-0 shadow-none p-3" rows="4" style="background: #f4f6f9; border-radius: 12px;" placeholder="Berikan arahan atau tanggapan bijak..." required>{{ $c->mudir_reply }}</textarea>
                                                </div>
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-dark py-3 fw-800">SIMPAN & KIRIM RESPON</button>
                                                </div>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <iconify-icon icon="solar:chat-round-dots-bold-duotone" class="text-muted opacity-10" style="font-size: 8rem;"></iconify-icon>
                                        <h5 class="text-muted mt-4 fw-600">Belum ada aspirasi masuk hari ini.</h5>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hero-header h1 { font-size: 1.8rem; }
    .opacity-80 { opacity: 0.8; }
    .bg-light-primary { background: rgba(26, 115, 232, 0.08); }
    .bg-light-success { background: rgba(40, 167, 69, 0.08); }
    .bg-light-warning { background: rgba(255, 193, 7, 0.08); }
    .bg-light-danger { background: rgba(220, 53, 69, 0.08); }
    .badge-soft-primary { background: rgba(26, 115, 232, 0.1); color: var(--primary-blue); border: none; padding: 5px 12px; border-radius: 6px; }
    .badge-soft-success { background: rgba(40, 167, 69, 0.1); color: #28a745; padding: 8px 15px; border-radius: 8px; }
    .badge-soft-danger { background: rgba(220, 53, 69, 0.1); color: #dc3545; padding: 8px 15px; border-radius: 8px; }
    .badge-soft-warning { background: rgba(255, 193, 10, 0.1); color: #ffc107; padding: 8px 15px; border-radius: 8px; }
    .opacity-20 { opacity: 0.2; }
    .opacity-10 { opacity: 0.1; }
    .transition-all { transition: all 0.3s ease; }
    .table-hover tbody tr:hover { background-color: rgba(26, 115, 232, 0.02) !important; transform: scale(1.001); }
    .fade-in { animation: fadeIn 0.6s ease-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection
