@extends('admin-master')

@section('judul', 'Pendaftar Event')

@section('isi')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
                <div>
                    <h4 class="card-title mb-0 fw-bold text-dark">Pendaftar Event</h4>
                    <span class="badge bg-primary px-3 py-2 mt-2 shadow-sm">{{ $event->title }}</span>
                </div>
                <a href="{{ route('admin.event.index') }}" class="btn btn-outline-secondary px-4">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                    <table class="table table-hover align-middle" id="participantTable">
                        <thead class="bg-light">
                            <tr>
                                <th width="50">NO</th>
                                <th>Alumni</th>
                                <th>Angkatan</th>
                                <th>Pekerjaan</th>
                                <th>Kontak</th>
                                <th class="text-center">Tgl Daftar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($participants as $p)
                            <tr>
                                <td class="text-center">{{$loop->iteration}}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            @if($p->foto)
                                                <img src="{{ asset('storage/' . $p->foto) }}" alt="avatar" width="45" height="45" class="rounded-circle border border-2 border-primary" style="object-fit: cover;">
                                            @else
                                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center border" style="width: 45px; height: 45px;">
                                                    <i class="fas fa-user text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold text-dark">{{$p->nama ?? $p->username}}</h6>
                                            <small class="text-muted">{{ $p->username }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border px-2 fw-normal">{{ $p->tahun_masuk ?? '?' }} - {{ $p->tahun_tamat ?? '?' }}</span>
                                </td>
                                <td>
                                    <span class="small text-dark">{{$p->pekerjaan ?? '-'}}</span>
                                </td>
                                <td>
                                    @if($p->no_hp)
                                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', $p->no_hp) }}" target="_blank" class="text-success text-decoration-none fw-bold">
                                            <i class="fab fa-whatsapp me-1"></i> {{$p->no_hp}}
                                        </a>
                                    @else
                                        <span class="text-muted italic opacity-50">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <small class="text-muted">{{$p->pivot->created_at->format('d M Y H:i')}}</small>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="fas fa-users-slash fa-3x text-muted opacity-25 mb-3"></i>
                                    <p class="text-muted">Belum ada alumni yang mendaftar untuk event ini.</p>
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
    #participantTable thead th {
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.8px;
        color: #444;
        border-top: none;
        padding: 20px 15px;
        background-color: #f8f9fa;
    }
    #participantTable tbody td {
        border-color: #f1f1f1;
        padding: 18px 15px;
    }
    .italic { font-style: italic; }
    
    /* Sticky header for scrollable table */
    #participantTable thead th {
        position: sticky;
        top: 0;
        z-index: 10;
        background-color: #f8f9fa;
    }
</style>
@endsection
