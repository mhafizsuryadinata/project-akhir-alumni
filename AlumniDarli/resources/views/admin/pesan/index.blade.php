@extends('admin-master')

@section('judul', 'Manajemen Pesan Kontak')

@section('isi')
<div class="row g-4">
    <!-- Hero Header -->
    <div class="col-12 animate-box" style="animation-delay: 0.1s">
        <div class="card overflow-hidden border-0 page-hero">
            <div class="card-body p-4 position-relative">
                <div class="row align-items-center position-relative z-index-1">
                    <div class="col-md-8 text-white">
                        <h3 class="fw-800 mb-1"><iconify-icon icon="solar:letter-bold-duotone" class="me-2"></iconify-icon> Pesan Kontak</h3>
                        <p class="mb-0 opacity-75 small">Kelola pertanyaan dan masukan langsung dari para alumni</p>
                    </div>
                </div>
                <div class="position-absolute floating-icon" style="right: -30px; bottom: -30px; opacity: 0.1;">
                    <iconify-icon icon="solar:letter-bold-duotone" style="font-size: 150px; color: white;"></iconify-icon>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 animate-box" style="animation-delay: 0.2s">
        <div class="card shadow-sm border-0 glass-card">
            <div class="card-body">
                @if(session('pesan'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-1"></i> {{ session('pesan') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                    <table class="table table-hover align-middle" id="pesanTable">
                        <thead class="bg-light">
                            <tr>
                                <th width="50">NO</th>
                                <th>Pengirim</th>
                                <th>Subjek & Detail Pesan</th>
                                <th class="text-center">Lampiran</th>
                                <th class="text-center">Status</th>
                                <th width="200" class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pesans as $no => $pesan)
                            <tr class="{{ $pesan->status == 'unread' ? 'bg-light bg-opacity-50' : '' }}">
                                <td class="text-center">{{ $no + 1 }}</td>
                                <td>
                                    <h6 class="mb-0 fw-bold text-dark">{{ $pesan->user->nama ?? 'Unknown' }}</h6>
                                    <small class="text-muted">{{ $pesan->user->email ?? '-' }}</small>
                                </td>
                                <td>
                                    <div class="mb-1">
                                        <span class="badge bg-primary px-2 mb-1">{{ $pesan->subject }}</span>
                                    </div>
                                    <p class="mb-1 small text-dark">{{ Str::limit($pesan->message, 150) }}</p>
                                    <small class="text-muted x-small"><i class="far fa-clock me-1"></i>{{ $pesan->created_at ? $pesan->created_at->format('d M Y H:i') : '-' }}</small>
                                    
                                    @if($pesan->admin_reply)
                                    <div class="mt-2 p-3 bg-light rounded-3 border-start border-3 border-success">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <small class="fw-bold text-success"><i class="fas fa-reply me-1"></i>Balasan Admin</small>
                                            <small class="text-muted x-small">{{ $pesan->replied_at ? $pesan->replied_at->format('d/m/y H:i') : '-' }}</small>
                                        </div>
                                        <p class="mb-0 small italic text-dark">{{ $pesan->admin_reply }}</p>
                                    </div>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($pesan->attachment)
                                        <a href="{{ route('admin.pesan.attachment', $pesan->id) }}" target="_blank" class="btn btn-outline-info btn-sm rounded-pill px-3" title="Lihat Lampiran">
                                            <i class="fas fa-paperclip me-1"></i> Lihat
                                        </a>
                                    @else
                                        <span class="text-muted small opacity-50">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($pesan->status == 'unread')
                                        <span class="badge bg-danger px-3 shadow-sm">Baru</span>
                                        <form action="{{ route('admin.pesan.read', $pesan->id) }}" method="POST" class="mt-1">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-link btn-sm p-0 text-decoration-none x-small text-muted">Tandai Dibaca</button>
                                        </form>
                                    @else
                                        <span class="badge bg-success px-3 shadow-sm">Terbaca</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <button type="button" class="btn btn-primary btn-sm px-3" data-bs-toggle="modal" data-bs-target="#replyModal{{ $pesan->id }}">
                                            <i class="fas fa-reply me-1"></i> {{ $pesan->admin_reply ? 'Ubah' : 'Balas' }}
                                        </button>
                                        
                                        @if($pesan->admin_reply)
                                        <form action="{{ route('admin.pesan.reply.destroy', $pesan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus balasan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-warning btn-sm" title="Batalkan Balasan">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        </form>
                                        @endif

                                        <form action="{{ route('admin.pesan.destroy', $pesan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pesan ini secara permanen?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus Pesan">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Reply Modal -->
                                    <div class="modal fade" id="replyModal{{ $pesan->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content border-0 shadow">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title text-white"><i class="fas fa-paper-plane me-2"></i>Balas Pesan Alumni</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('admin.pesan.reply', $pesan->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body p-4">
                                                        <div class="mb-4">
                                                            <label class="form-label fw-bold text-muted small uppercase">Pesan dari Alumni:</label>
                                                            <div class="p-3 bg-light rounded-3 border small">
                                                                <strong class="d-block mb-1">{{ $pesan->subject }}</strong>
                                                                {{ $pesan->message }}
                                                            </div>
                                                        </div>
                                                        <div class="mb-0">
                                                            <label class="form-label fw-bold">Tulis Balasan Admin:</label>
                                                            <textarea name="reply" class="form-control" rows="5" required placeholder="Ketik balasan Anda di sini...">{{ $pesan->admin_reply }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer bg-light">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-success px-4">
                                                            <i class="fas fa-paper-plane me-1"></i> Kirim Balasan
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="fas fa-envelope-open fa-3x text-muted opacity-25 mb-3"></i>
                                    <p class="text-muted">Kotak masuk kosong. Belum ada pesan dari alumni.</p>
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
    #pesanTable thead th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #555;
        border-top: none;
        padding: 15px;
    }
    #pesanTable tbody td {
        border-color: #f1f1f1;
        padding: 15px;
    }
    .x-small { font-size: 0.7rem; }
    .italic { font-style: italic; }
    
    /* Sticky header for scrollable table */
    #pesanTable thead th {
        position: sticky;
        top: 0;
        z-index: 10;
        background-color: #f8f9fa;
    }
</style>
@endsection
