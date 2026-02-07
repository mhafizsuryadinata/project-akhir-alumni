@extends('alumni-master')

@section('alumni')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Lowongan</h4>
                </div>
                <div class="card-body">
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

                    <form action="{{ route('lowongan.update', $lowongan->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="judul" class="form-label">Judul Posisi <span class="text-danger">*</span></label>
                                <input type="text" name="judul" id="judul" class="form-control" 
                                       value="{{ old('judul', $lowongan->judul) }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="perusahaan" class="form-label">Nama Perusahaan <span class="text-danger">*</span></label>
                                <input type="text" name="perusahaan" id="perusahaan" class="form-control" 
                                       value="{{ old('perusahaan', $lowongan->perusahaan) }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="lokasi" class="form-label">Lokasi <span class="text-danger">*</span></label>
                                <input type="text" name="lokasi" id="lokasi" class="form-control" 
                                       value="{{ old('lokasi', $lowongan->lokasi) }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tipe_pekerjaan" class="form-label">Tipe Pekerjaan <span class="text-danger">*</span></label>
                                <select name="tipe_pekerjaan" id="tipe_pekerjaan" class="form-select" required>
                                    <option value="">-- Pilih Tipe --</option>
                                    <option value="Full Time" {{ old('tipe_pekerjaan', $lowongan->tipe_pekerjaan) == 'Full Time' ? 'selected' : '' }}>Full Time</option>
                                    <option value="Part Time" {{ old('tipe_pekerjaan', $lowongan->tipe_pekerjaan) == 'Part Time' ? 'selected' : '' }}>Part Time</option>
                                    <option value="Freelance" {{ old('tipe_pekerjaan', $lowongan->tipe_pekerjaan) == 'Freelance' ? 'selected' : '' }}>Freelance</option>
                                    <option value="Contract" {{ old('tipe_pekerjaan', $lowongan->tipe_pekerjaan) == 'Contract' ? 'selected' : '' }}>Contract</option>
                                    <option value="Internship" {{ old('tipe_pekerjaan', $lowongan->tipe_pekerjaan) == 'Internship' ? 'selected' : '' }}>Internship</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="level" class="form-label">Level Posisi <span class="text-danger">*</span></label>
                                <select name="level" id="level" class="form-select" required>
                                    <option value="">-- Pilih Level --</option>
                                    <option value="Entry Level" {{ old('level', $lowongan->level) == 'Entry Level' ? 'selected' : '' }}>Entry Level</option>
                                    <option value="Mid Level" {{ old('level', $lowongan->level) == 'Mid Level' ? 'selected' : '' }}>Mid Level</option>
                                    <option value="Senior Level" {{ old('level', $lowongan->level) == 'Senior Level' ? 'selected' : '' }}>Senior Level</option>
                                    <option value="Manager" {{ old('level', $lowongan->level) == 'Manager' ? 'selected' : '' }}>Manager</option>
                                    <option value="Director" {{ old('level', $lowongan->level) == 'Director' ? 'selected' : '' }}>Director</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="gaji_min" class="form-label">Gaji Minimum</label>
                                <input type="text" name="gaji_min" id="gaji_min" class="form-control" 
                                       value="{{ old('gaji_min', $lowongan->gaji_min) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="gaji_max" class="form-label">Gaji Maximum</label>
                                <input type="text" name="gaji_max" id="gaji_max" class="form-control" 
                                       value="{{ old('gaji_max', $lowongan->gaji_max) }}">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi Pekerjaan <span class="text-danger">*</span></label>
                                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="5" required>{{ old('deskripsi', $lowongan->deskripsi) }}</textarea>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="kualifikasi" class="form-label">Kualifikasi <span class="text-danger">*</span></label>
                                <textarea name="kualifikasi" id="kualifikasi" class="form-control" rows="5" required>{{ old('kualifikasi', $lowongan->kualifikasi) }}</textarea>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="benefit" class="form-label">Benefit</label>
                                <textarea name="benefit" id="benefit" class="form-control" rows="4">{{ old('benefit', $lowongan->benefit) }}</textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email_kontak" class="form-label">Email Kontak <span class="text-danger">*</span></label>
                                <input type="email" name="email_kontak" id="email_kontak" class="form-control" 
                                       value="{{ old('email_kontak', $lowongan->email_kontak) }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="website" class="form-label">Website Perusahaan</label>
                                <input type="url" name="website" id="website" class="form-control" 
                                       value="{{ old('website', $lowongan->website) }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="tanggal_tutup" class="form-label">Tanggal Tutup Lamaran <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_tutup" id="tanggal_tutup" class="form-control" 
                                       value="{{ old('tanggal_tutup', $lowongan->tanggal_tutup->format('Y-m-d')) }}" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="Aktif" {{ old('status', $lowongan->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="Ditutup" {{ old('status', $lowongan->status) == 'Ditutup' ? 'selected' : '' }}>Ditutup</option>
                                    <option value="Draft" {{ old('status', $lowongan->status) == 'Draft' ? 'selected' : '' }}>Draft</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="logo_perusahaan" class="form-label">Logo Perusahaan</label>
                                <input type="file" name="logo_perusahaan" id="logo_perusahaan" class="form-control" 
                                       accept="image/*">
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah logo</small>
                            </div>

                            @if($lowongan->logo_perusahaan)
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Logo Saat Ini:</label><br>
                                <img src="{{ asset($lowongan->logo_perusahaan) }}" alt="Logo" style="max-width: 100px; border: 1px solid #ddd; padding: 5px; border-radius: 5px;">
                            </div>
                            @endif
                        </div>

                        <hr class="my-4">

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update Lowongan
                            </button>
                            <a href="{{ route('lowongan.show', $lowongan->id) }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
