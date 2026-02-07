@extends('admin-master')

@section('judul', 'Edit Kontak Ustadz')

@section('isi')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Edit Ustadz</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.kontak.update', $ustadz->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Nama Ustadz <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control" value="{{ $ustadz->nama }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jabatan <span class="text-danger">*</span></label>
                            <input type="text" name="jabatan" class="form-control" value="{{ $ustadz->jabatan }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bidang Keahlian (Pisahkan dengan koma)</label>
                            <input type="text" name="bidang" class="form-control" value="{{ $ustadz->bidang }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nomor HP / WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" name="no_hp" class="form-control" value="{{ $ustadz->no_hp }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $ustadz->email }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Foto Profil</label>
                        @if($ustadz->foto)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $ustadz->foto) }}" alt="Foto Lama" width="100" class="rounded">
                            </div>
                        @endif
                        <input type="file" name="foto" class="form-control" accept="image/*">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengganti foto.</small>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.kontak.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
