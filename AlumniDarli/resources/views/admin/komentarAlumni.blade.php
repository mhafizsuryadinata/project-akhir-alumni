@extends('admin-master')

@section('judul', 'Manajemen Komentar Alumni')

@section('isi')
<div class="row g-4">
    <!-- Hero Header -->
    <div class="col-12 animate-box" style="animation-delay: 0.1s">
        <div class="card overflow-hidden border-0 page-hero">
            <div class="card-body p-4 position-relative">
                <div class="row align-items-center position-relative z-index-1">
                    <div class="col-md-8 text-white">
                        <h3 class="fw-800 mb-1"><iconify-icon icon="solar:chat-round-dots-bold-duotone" class="me-2"></iconify-icon> Komentar Alumni</h3>
                        <p class="mb-0 opacity-75 small">Kelola dan balas masukan dari para alumni</p>
                    </div>
                </div>
                <div class="position-absolute floating-icon" style="right: -30px; bottom: -30px; opacity: 0.1;">
                    <iconify-icon icon="solar:chat-round-dots-bold-duotone" style="font-size: 150px; color: white;"></iconify-icon>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 animate-box" style="animation-delay: 0.2s">
        <div class="card shadow-sm border-0 glass-card">
            <div class="card-body">
                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                    <table class="table table-hover align-middle" id="commentTable">
                        <thead class="bg-light">
                            <tr>
                                <th width="50">NO</th>
                                <th>Alumni</th>
                                <th>Komentar & Rating</th>
                                <th>Balasan Alumni</th>
                                <th width="120">Status Admin</th>
                                <th width="120">Status Pimpinan</th>
                                <th>Balasan Admin</th>
                                <th>Balasan Pimpinan</th>
                                <th width="150" class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($comments as $c)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            @if($c->user->foto)
                                                <img src="{{ asset('storage/' . $c->user->foto) }}" alt="avatar" width="45" height="45" class="rounded-circle border border-primary border-2" style="object-fit: cover;">
                                            @else
                                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center border" style="width: 45px; height: 45px;">
                                                    <i class="fas fa-user text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">{{ $c->user->nama ?? $c->user->username }}</h6>
                                            <small class="text-muted">Tahun: {{ $c->user->tahun_masuk ?? '?' }} - {{ $c->user->tahun_tamat ?? '?' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="mb-1 small">
                                        @if($c->rating)
                                            <div>
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $c->rating)
                                                        <i class="fas fa-star text-warning"></i>
                                                    @else
                                                        <i class="fas fa-star text-muted" style="opacity: 0.2;"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                        @endif
                                    </div>
                                    <p class="mb-0 small text-dark">{{ Str::limit($c->content, 100) }}</p>
                                    <small class="text-muted"><i class="far fa-clock me-1"></i>{{ \Carbon\Carbon::parse($c->created_at)->format('d M Y') }}</small>
                                </td>
                                <td>
                                    @forelse($c->replies as $reply)
                                        <div class="p-2 bg-light rounded border-start border-3 border-info mb-2">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <small class="fw-bold">{{ $reply->user->nama ?? $reply->user->username }}</small>
                                                <small class="text-muted x-small">{{ \Carbon\Carbon::parse($reply->created_at)->format('d/m/y') }}</small>
                                            </div>
                                            <p class="mb-0 small">{{ Str::limit($reply->content, 100) }}</p>
                                        </div>
                                    @empty
                                        <span class="text-muted small italic">Tidak ada</span>
                                    @endforelse
                                </td>
                                <td>
                                    @if($c->admin_status == 'approved')
                                        <span class="badge bg-success px-2 py-1">Disetujui</span>
                                    @elseif($c->admin_status == 'rejected')
                                        <span class="badge bg-danger px-2 py-1">Ditolak</span>
                                    @else
                                        <span class="badge bg-warning text-dark px-2 py-1">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    @if($c->mudir_status == 'approved')
                                        <span class="badge bg-success px-2 py-1">Disetujui</span>
                                    @elseif($c->mudir_status == 'rejected')
                                        <span class="badge bg-danger px-2 py-1">Ditolak</span>
                                    @else
                                        <span class="badge bg-warning text-dark px-2 py-1">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    @if($c->admin_reply)
                                        <div class="p-2 bg-light rounded border-start border-3 border-primary shadow-sm">
                                            <p class="mb-0 small text-dark fw-bold">{{ Str::limit($c->admin_reply, 50) }}</p>
                                            <small class="text-muted x-small">{{ $c->admin_reply_date ? \Carbon\Carbon::parse($c->admin_reply_date)->format('d/m/y') : '' }}</small>
                                        </div>
                                    @else
                                        <span class="badge bg-secondary px-2 py-1">Belum dibalas</span>
                                    @endif
                                </td>
                                <td>
                                    @if($c->mudir_reply)
                                        <div class="p-2 bg-light rounded border-start border-3 border-success shadow-sm">
                                            <p class="mb-0 small text-dark fw-bold">{{ Str::limit($c->mudir_reply, 50) }}</p>
                                            <small class="text-muted x-small">{{ $c->mudir_reply_date ? \Carbon\Carbon::parse($c->mudir_reply_date)->format('d/m/y') : '' }}</small>
                                        </div>
                                    @else
                                        <span class="badge bg-secondary px-2 py-1">Belum dibalas</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        @if($c->admin_status == 'pending')
                                            <form action="{{ route('komentar.approve', $c->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm px-2" title="Setujui">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('komentar.reject', $c->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-warning btn-sm px-2 text-dark" title="Tolak">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <button type="button" class="btn btn-primary btn-sm px-2" data-bs-toggle="modal" data-bs-target="#replyModal{{ $c->id }}" title="Balas">
                                            <i class="fas fa-reply"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm px-2" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="setDeleteAction({{ $c->id }})" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="py-3">
                                        <i class="fas fa-comments fa-3x text-muted opacity-25 mb-3"></i>
                                        <p class="text-muted">Belum ada komentar alumni yang masuk.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination removed - menampilkan semua data dengan scroll -->
            </div>
        </div>
    </div>
</div>

<!-- Modal Balas -->
@foreach($comments as $c)
<div class="modal fade" id="replyModal{{ $c->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white"><i class="fas fa-reply me-2"></i>Balas Komentar Alumni</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('komentar.balas', $c->id) }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted small uppercase">Dari Alumni:</label>
                        <h6 class="fw-bold mb-0">{{ $c->user->nama ?? $c->user->username }}</h6>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted small uppercase">Isi Komentar:</label>
                        <div class="p-3 bg-light rounded-3 border small">
                            {{ $c->content }}
                        </div>
                    </div>
                    <div class="mb-0">
                        <label for="balasan{{ $c->id }}" class="form-label fw-bold">Tulis Balasan Admin:</label>
                        <textarea class="form-control" id="balasan{{ $c->id }}" name="balasan" rows="4" placeholder="Ketik balasan Anda di sini..." required>{{ $c->admin_reply ?? '' }}</textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-paper-plane me-1"></i> Kirim Balasan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-body p-4 text-center">
                <i class="fas fa-exclamation-triangle text-danger fs-1 mb-3"></i>
                <h5 class="fw-bold mb-2">Hapus Komentar?</h5>
                <p class="text-muted small mb-4">Tindakan ini tidak dapat dibatalkan dan akan menghapus semua balasan terkait.</p>
                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-light px-4 border" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger px-4">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    #commentTable thead th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #555;
        border-top: none;
        padding: 15px;
    }
    #commentTable tbody td {
        border-color: #f1f1f1;
        padding: 15px;
    }
    .x-small { font-size: 0.7rem; }
    .italic { font-style: italic; }
    
    /* Sticky header for scrollable table */
    #commentTable thead th {
        position: sticky;
        top: 0;
        z-index: 10;
        background-color: #f8f9fa;
    }
</style>

@endsection

@push('scripts')
<script>
function setDeleteAction(id) {
    document.getElementById('deleteForm').action = '/komentar/' + id;
}

document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide alert
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