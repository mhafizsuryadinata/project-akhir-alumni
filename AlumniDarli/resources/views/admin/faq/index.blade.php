@extends('admin-master')

@section('judul', 'Manajemen FAQ')

@section('isi')
<div class="row g-4">
    <!-- Hero Header -->
    <div class="col-12 animate-box" style="animation-delay: 0.1s">
        <div class="card overflow-hidden border-0 page-hero">
            <div class="card-body p-4 position-relative">
                <div class="row align-items-center position-relative z-index-1">
                    <div class="col-md-8 text-white">
                        <h3 class="fw-800 mb-1"><iconify-icon icon="solar:question-circle-bold-duotone" class="me-2"></iconify-icon> Manajemen FAQ</h3>
                        <p class="mb-0 opacity-75 small">Kelola pertanyaan umum untuk membantu alumni</p>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    </div>
                </div>
                <div class="position-absolute floating-icon" style="right: -30px; bottom: -30px; opacity: 0.1;">
                    <iconify-icon icon="solar:question-circle-bold-duotone" style="font-size: 150px; color: white;"></iconify-icon>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 animate-box" style="animation-delay: 0.2s">
        <!-- Tambah FAQ Form (Collapsed) -->
        <div class="collapse mb-4" id="tambahFaqForm">
            <div class="card shadow-sm border-0 glass-card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 text-white"><iconify-icon icon="solar:question-circle-bold-duotone" class="me-2"></iconify-icon>Tambah FAQ Baru</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.faq.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-9">
                                <label class="form-label fw-bold">Pertanyaan</label>
                                <input type="text" name="question" class="form-control" placeholder="Apa yang sering ditanyakan alumni?" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Urutan Tampil</label>
                                <input type="number" name="order" class="form-control" placeholder="Contoh: 1">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Jawaban</label>
                                <textarea name="answer" class="form-control" rows="4" placeholder="Berikan jawaban yang jelas dan ringkas..." required></textarea>
                            </div>
                        </div>
                        <div class="mt-4 text-end">
                            <button type="button" class="btn btn-secondary me-2" data-bs-toggle="collapse" data-bs-target="#tambahFaqForm">Batal</button>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-1"></i> Simpan FAQ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
                <div>
                    <h4 class="card-title mb-0 fw-bold text-dark">Daftar Pertanyaan Umum</h4>
                    <p class="text-muted small mb-0">Kelola FAQ untuk membantu alumni menavigasi sistem</p>
                </div>
                 <button class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#tambahFaqForm">
                    <i class="fas fa-plus me-1"></i> Tambah FAQ
                </button>
            </div>
            <div class="card-body">
                @if(session('pesan'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-1"></i> {{ session('pesan') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                    <table class="table table-hover align-middle" id="faqTable">
                        <thead class="bg-light">
                            <tr>
                                <th width="50">NO</th>
                                <th>Pertanyaan & Jawaban</th>
                                <th width="100" class="text-center">Urutan</th>
                                <th width="150" class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($faqs as $no => $faq)
                            <tr>
                                <td class="text-center">{{ $no + 1 }}</td>
                                <td>
                                    <h6 class="fw-bold text-dark mb-1">{{ $faq->question }}</h6>
                                    <p class="text-muted small mb-0">{{ Str::limit($faq->answer, 150) }}</p>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-light text-dark border">{{ $faq->order ?? '-' }}</span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('admin.faq.edit', $faq->id) }}" class="btn btn-warning btn-sm text-dark" title="Edit Data">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.faq.destroy', $faq->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus FAQ ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" title="Hapus Data">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <i class="fas fa-question-circle fa-3x text-muted opacity-25 mb-3"></i>
                                    <p class="text-muted">Belum ada data FAQ yang tersedia.</p>
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
    #faqTable thead th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #555;
        border-top: none;
        padding: 15px;
    }
    #faqTable tbody td {
        border-color: #f1f1f1;
        padding: 15px;
    }
    
    /* Sticky header for scrollable table */
    #faqTable thead th {
        position: sticky;
        top: 0;
        z-index: 10;
        background-color: #f8f9fa;
    }
</style>
@endsection
