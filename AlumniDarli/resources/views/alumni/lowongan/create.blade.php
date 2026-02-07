@extends('alumni-master')

@section('alumni')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Posting Lowongan Baru</h4>
                </div>
                <div class="card-body">
                    @guest
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Info:</strong> Anda dapat posting lowongan tanpa login. 
                        Namun, Anda <strong>tidak akan bisa mengedit atau menghapus</strong> lowongan ini nanti. 
                        <a href="{{ route('login') }}" class="alert-link">Login sekarang</a> untuk fitur lengkap.
                    </div>
                    @endguest
                    
                    @if($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> Ada beberapa masalah dengan input Anda.<br><br>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('lowongan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="judul" class="form-label">Judul Posisi <span class="text-danger">*</span></label>
                                <input type="text" name="judul" id="judul" class="form-control" 
                                       value="{{ old('judul') }}" required placeholder="Contoh: Web Developer">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="perusahaan" class="form-label">Nama Perusahaan <span class="text-danger">*</span></label>
                                <input type="text" name="perusahaan" id="perusahaan" class="form-control" 
                                       value="{{ old('perusahaan') }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="lokasi" class="form-label">Lokasi <span class="text-danger">*</span></label>
                                <input type="text" name="lokasi" id="lokasi" class="form-control" 
                                       value="{{ old('lokasi') }}" required placeholder="Contoh: Jakarta">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tipe_pekerjaan" class="form-label">Tipe Pekerjaan <span class="text-danger">*</span></label>
                                <select name="tipe_pekerjaan" id="tipe_pekerjaan" class="form-select" required>
                                    <option value="">-- Pilih Tipe --</option>
                                    <option value="Full Time" {{ old('tipe_pekerjaan') == 'Full Time' ? 'selected' : '' }}>Full Time</option>
                                    <option value="Part Time" {{ old('tipe_pekerjaan') == 'Part Time' ? 'selected' : '' }}>Part Time</option>
                                    <option value="Freelance" {{ old('tipe_pekerjaan') == 'Freelance' ? 'selected' : '' }}>Freelance</option>
                                    <option value="Contract" {{ old('tipe_pekerjaan') == 'Contract' ? 'selected' : '' }}>Contract</option>
                                    <option value="Internship" {{ old('tipe_pekerjaan') == 'Internship' ? 'selected' : '' }}>Internship</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="level" class="form-label">Level Posisi <span class="text-danger">*</span></label>
                                <select name="level" id="level" class="form-select" required>
                                    <option value="">-- Pilih Level --</option>
                                    <option value="Entry Level" {{ old('level') == 'Entry Level' ? 'selected' : '' }}>Entry Level</option>
                                    <option value="Mid Level" {{ old('level') == 'Mid Level' ? 'selected' : '' }}>Mid Level</option>
                                    <option value="Senior Level" {{ old('level') == 'Senior Level' ? 'selected' : '' }}>Senior Level</option>
                                    <option value="Manager" {{ old('level') == 'Manager' ? 'selected' : '' }}>Manager</option>
                                    <option value="Director" {{ old('level') == 'Director' ? 'selected' : '' }}>Director</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="gaji_min" class="form-label">Gaji Minimum</label>
                                <input type="text" name="gaji_min" id="gaji_min" class="form-control" 
                                       value="{{ old('gaji_min') }}" placeholder="Contoh: Rp 5.000.000">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="gaji_max" class="form-label">Gaji Maximum</label>
                                <input type="text" name="gaji_max" id="gaji_max" class="form-control" 
                                       value="{{ old('gaji_max') }}" placeholder="Contoh: Rp 10.000.000">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi Pekerjaan <span class="text-danger">*</span></label>
                                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="5" required 
                                          placeholder="Jelaskan tugas dan tanggung jawab pekerjaan...">{{ old('deskripsi') }}</textarea>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="kualifikasi" class="form-label">Kualifikasi <span class="text-danger">*</span></label>
                                <textarea name="kualifikasi" id="kualifikasi" class="form-control" rows="5" required 
                                          placeholder="Tuliskan persyaratan dan kualifikasi yang dibutuhkan...">{{ old('kualifikasi') }}</textarea>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="benefit" class="form-label">Benefit</label>
                                <textarea name="benefit" id="benefit" class="form-control" rows="4" 
                                          placeholder="Tuliskan benefit yang ditawarkan (opsional)...">{{ old('benefit') }}</textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email_kontak" class="form-label">Email Kontak <span class="text-danger">*</span></label>
                                <input type="email" name="email_kontak" id="email_kontak" class="form-control" 
                                       value="{{ old('email_kontak') }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="website" class="form-label">Website Perusahaan</label>
                                <input type="url" name="website" id="website" class="form-control" 
                                       value="{{ old('website') }}" placeholder="https://">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tanggal_tutup" class="form-label">Tanggal Tutup Lamaran <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_tutup" id="tanggal_tutup" class="form-control" 
                                       value="{{ old('tanggal_tutup') }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="logo_perusahaan" class="form-label">Logo Perusahaan</label>
                                <input type="file" name="logo_perusahaan" id="logo_perusahaan" class="form-control" 
                                       accept="image/*">
                                <small class="text-muted">Format: JPG, PNG. Max: 2MB</small>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Posting Lowongan
                            </button>
                            <a href="{{ route('lowongan.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Set min date untuk tanggal tutup (besok)
document.addEventListener('DOMContentLoaded', function() {
    var today = new Date();
    today.setDate(today.getDate() + 1);
    var tomorrow = today.toISOString().split('T')[0];
    document.getElementById('tanggal_tutup').setAttribute('min', tomorrow);
});
</script>
@endsection
